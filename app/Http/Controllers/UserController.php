<?php

namespace App\Http\Controllers;
use App\User;
use App\Purchase;
use Illuminate\Http\Request;
use App\Drug;
use App\Vendor;
use Illuminate\Support\Facades\DB;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //declare rules for authentication

    // priviledges for admin is set to 1
    private $priviledges = 1;

    public function rules()
    {
        return [
            'name' => 'required|max:45',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'age' => 'required|integer',
            'phone' => 'required|max:11|unique',
        ];
    }
    public function update_rules()
    {
        return [
            'name' => 'required|max:45',
            'email' => 'required|email',
            'address' => 'required|min:10',
            'phone' => 'required|max:11',
        ];
    }

    public function index()
    {
        //
    }

    //return users drugs 

    public function user_drugs()
    {
        $drugs = auth()->user()->drugs();

        return response()->json(['drugs' => $drugs], 200);
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

            return response()->json(['user' => $user], 200);
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
        //show the users profile
        // attached to the response headers must append the users token
        $phone = User::where('id',$id)->first()->phone;

        return response()->json(['phone' => $phone]);
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
        //validate user requests
        $rules = $this->update_rules();
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()],400);
        }
        else{
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->save();
        }

        return $user;
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

    // login the user
    public function login(Request $request){
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('myapp')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Authentication failed'], 401);
        }
    }

    // register customer purchase
    public function purchase(Request $request)
    {
        $number = $request->number;
        $drugId = $request->drug_id;
        $qty = $request->qty;
        // get user id
        $user = User::where('phone',$number)->first()->id;
        if(!$user){
            return response()->json(['error' => 'Customer not found, please kindly signup the customer']);
        }
        $vendor_id = auth()->user()->id;
        $purchase = new Purchase();
        $purchase->drug_id = $drugId;
        $purchase->qty = $qty;
        $purchase->purchasedBy = $user;
        $purchase->purchasedFrom = $vendor_id;
        // subtract bought qty from qty of drugs
        $drug = Drug::where('vendor_id',$vendor_id)->where('id',$drugId)->first();
        $new_qty = $drug->qty - $qty;
        $drug->qty = $new_qty;
        $drug->save();

        $purchase->save();

        return response()->json(['message' => 'Purchase recorded successfully']);

    }

    public function customerDrugHistory($phone)
    {
        
        $user = User::where('phone',$phone)->Orwhere('id',$phone)->where('priviledges',3)->first();

        if(!$user){
            return response()->json(['error'=> 'New customer? please signup']);
        }
        else {
            $purchases = $user->customerPurchase()->pluck('drug_id');
            if(empty($purchases)){
                return response()->json(['message' => 'Customer purchase history not found']);
            }
            $drug_qty = $user->customerPurchase()->pluck('qty');
            $vendors = $user->customerPurchase()->pluck('purchasedFrom');
            $times = $user->customerPurchase()->pluck('created_at');
            foreach($purchases as $purchase){
                $drug_names[] = Drug::where('id',$purchase)->first()->name;
            }
            foreach($vendors as $vendor){
                $vendor_names[] = User::where('id',$vendor)->first()->name;
            }
            foreach($times as $value){
                $time[] = date('Y-m-d',strtotime($value));
            }
            return response()->json(['drug_names' => $drug_names, 'drug_qty' => $drug_qty, 'vendor_names' => $vendor_names, 'time' => $time,'user' => $user]);
        }
    }

    public function getDrugPurchase($id){
        $quantities = Purchase::where('purchasedFrom',auth()->user()->id)->where('drug_id',$id)->pluck('qty');
        if(!$quantities){
            return response()->json(['error' => 'No purchase frequency found']);
        }
        $qty = 0;
        foreach($quantities as $quantity){
            $qty = $qty + $quantity;
        }
        return $qty;
    }

    public function vendors()
    {
        $vendors = DB::table('users')->join(('vendors'),function($join)
        {
            $join->on('users.id', '=' ,'vendors.store_id')
            ->where('users.priviledges', '=', '2');
        })->get();

        return response()->json(['vendors' => $vendors]);
    }

    public function customers()
    {
        $customers = User::where('priviledges',3)->get();

        return response()->json(['customers' => $customers]);
    }

    public function allVendorPurchase($id)
    {
        $purchases = User::where('id',$id)->first()->vendorSoldDrugs;
        $new = Vendor::where('store_id',$id)->first();
        $new->viewed = true;
        $new->save();
        $i=0;$j=0;
        foreach($purchases as $purchase){
            $vendorSoldDrugs[$i][$j] = Drug::where('id',$purchase->drug_id)->first()->name;
            $vendorSoldDrugs[$i][$j+1] = $purchase->qty;
            $vendorSoldDrugs[$i][$j+2] = User::where('id',$purchase->purchasedBy)->first()->name;
            $vendorSoldDrugs[$i][$j+3] = date('Y-m-d',strtotime($purchase->created_at));
            $i++;
        }
        return response()->json(['purchases' => $vendorSoldDrugs]);
    }

    public function vendorFrequency($id){
        // get all purchases made by selected vendor
        $purchases = Purchase::where('purchasedFrom',$id)->get()->groupBy('drug_id');
        $quantity = [];
        $purchase_array = [];
        
        foreach ($purchases as $key => $value) {
            $drug_key[] = $key;
            $total_qty = 0;
            foreach($value as $item){
                $total_qty = $total_qty + $item->qty;
            }
            $quantity[] = $total_qty;
        }
        $i = 1;
        $j = 0;
        $purchase_array[$i-1][$j] = 'Drugs';
        $purchase_array[$i-1][$j+1] = 'frequency';
        foreach($drug_key as $key){
            $name = Drug::where('id',$key)->first()->name;
            $purchase_array[$i][$j] = $name;
            $purchase_array[$i][$j+1] = $quantity[$i-1];
            $i++;
        }
        return $purchase_array;
    }

    public function toggleActivation($id){
        $update = User::where('id',$id)->first();
        // check if vendor is already activated
        if($update->status){
            $update->status = false;
        }
        else{
            $update->status = true;
        }
        $update->save();
        $status = $update->status ? 'true' : 'false';

        return response()->json(['status' => $status]);

    }

    // get all registered vendors who have completed shop profiles
    public function registeredVendors()
    {
        $vendors = DB::table('users')->join('vendors','vendors.store_id','=','users.id')
        ->where(['users.priviledges' => '2'])->where(['users.status' => '1'])->get();

        return $vendors;
    }

    // get all vendors drugs.....request made by customer
    public function getVendorDrugs($id)
    {
        $drugs = User::where('id',$id)->first()->drugs;

        return $drugs;
    }

    // get specified drug
    public function viewDrug($id)
    {
        $drug = Drug::findOrFail($id);

        return $drug;
    }

    // logout auth user

    public function logout()
    {
        $user = auth()->user()->token();
        $user->delete();
        return 'logged out';
    }
}
