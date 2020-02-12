<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Drug;
use App\Vendor;
use Validator;
use Illuminate\Support\Facades\DB;
class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      // vendor priviledges in users table is set to 2
      private $priviledges = 2;
      //declare rules for authentication
     public function rules()
     {
         return [
             'name' => 'required|max:45',
             'email' => 'required|email|unique:users',
             'password' => 'required|min:6|confirmed',
            //  'age' => 'required|integer',
             'phone' => 'required|max:11',
         ];
     }

     public function settings_rules()
     {
         return [
             'name' => 'required|max:20',
             'address' => 'required|max:65'
         ];
     }
    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate user requests
        $rules = $this->rules();
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()],400);
        }
        else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'age' => $request->age,
                'phone' => $request->phone,
                'priviledges' => $this->priviledges
            ]);

            return response()->json([
                'message' => 'Account created successfully'
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    // search for anything related to a drug

    public function search()
    {
        if($query = \Request::get('q')){
            $query = strtolower($query);

            $drugs = DB::table('drugs')
            ->select('id','name','company','price','effects','interaction','cure','qty','overdose','hcpi','active_ingredients','expiry_date')
            ->where(function($value) use ($query) {
                $value->where('name', 'like', '%' . $query . '%')
                ->orWhere('company', 'like', '%' . $query . '%')
                ->orWhere('cure', 'like', '%' . $query . '%')
                ->orWhere('active_ingredients', 'like', '%' . $query . '%');
            })
            ->Where('vendor_id', '=', auth()->id())
            ->get();
        }
        else {
            $drugs = Drug::where('vendor_id',auth()->id())->get();
        }
        return $drugs;
    }

    // Set vendor profile in home-page

    public function upload(Request $request){
        //validate user requests
        $rules = $this->settings_rules();
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()],400);
        }
        else {
            // image upload
            if($request->photo){
                $imageName = time().'.'.explode('/',explode(':',substr($request->photo,0,strpos($request->photo,';')))[1])[1];
                \Image::make($request->photo)->resize(800,600)->save(public_path('images/').$imageName);
            }
            else {
                $imageName = null;
            }

            $vendor = Vendor::where('store_id',auth()->user()->id)->first();
            // if no image use picture from db
            if($vendor){
                if($vendor->picture){
                    
                    $path = public_path().'/images/'.$vendor->picture;
                    if(file_exists($path)){
                        unlink($path);
                    }
                }
                // update vendor settings
                $vendor->store_name = $request->name;
                $vendor->address = $request->address;
                $vendor->picture = $imageName;
                $user = $vendor->user;
                $user->picture = 'set';
                $user->save();
                $vendor->save();

                return response()->json(['vendor' => $vendor,'message' => 'Profile successfully updated']);
            }
            else {
                $imageName = null;
                $vendor = Vendor::create([
                    'store_id' => auth()->user()->id,
                    'store_name' => $request->name,
                    'address' => $request->address,
                    'picture' => $imageName,
                ]);
                // update picture field in user table
                $user = $vendor->user;
                $user->picture = 'set';
                $user->save();
                return response()->json(['vendor' => $vendor,'message' => 'Profile successfully created']);
            }
        }
    }

    public function getSettings()
    {
        if($settings = Vendor::where('store_id',auth()->user()->id)->first()){
            return response()->json(['settings' => $settings,'user' => auth()->user()->name]);
        }
        return response()->json(['error' => 'Please setup your OTC shop profile']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
