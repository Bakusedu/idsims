<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Drug;
use App\Purchase;
use Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // customer priviledges in users table is set to 3
    private $priviledges = 3;
     //declare rules for authentication
    public function rules()
    {
        return [
            'name' => 'required|max:45',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            // 'age' => 'required|integer',
            'phone' => 'required|max:11|unique:users',
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
    // public function create()
    // {
    //     //
    // }

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

            $token = $user->createToken('myapp')->accessToken;

            return response()->json(['token' => $token,'user' => $user,'message' => 'Customer registered successfully'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        return response()->json(['user' => auth()->user()], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //
    // }

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     //
    // }
    
    public function healthInformation(){
        // get authenticated customers id
        $id = auth()->user()->id;
        // get all purchases made by customer
        $purchases = Purchase::where('purchasedBy',$id)->get()->groupBy('drug_id');
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
    
}
