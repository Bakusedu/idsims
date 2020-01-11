<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Drug;
use Validator;

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
            $drug = User::find(auth()->id())->drugs()->where('name','LIKE','%'.$query.'%')
            ->orWhere('company','LIKE','%'.$query.'%')->orWhere('effects','LIKE','%'.$query.'%')
            ->orWhere('interaction','LIKE','%'.$query.'%')->orWhere('cure','LIKE','%'.$query.'%')->get();
        }
        else {
            $drug = Drug::where('vendor_id',auth()->id())->get();
        }
        return $drug;
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
