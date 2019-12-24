<?php

namespace App\Http\Controllers;

use App\Drug;
use Illuminate\Http\Request;
use Validator;
class DrugController extends Controller
{

    // rules for drugs
    public function rules()
    {
        return [
            'name' => 'required|min:4',
            'company' => 'required|min:4',
            'price' => 'required|integer',
            'cure' => 'required|min:10',
            'qty' => 'required|integer'
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate drug request
        $rules = $this->rules();
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()],400);
        }
        else{
            //create a new drug
            $drug = Drug::create([
                'name' => $request->name,
                'company' => $request->company,
                'price' => $request->price,
                'effects' => $request->effects,
                'interaction' => $request->interaction,
                'cure' => $request->cure,
                'vendor_id' => auth()->user()->id,
                'qty' => $request->qty,
                'overdose' => $request->overdose,
                'hcpi' => $request->hcpi,
                'active_ingredients' => $request->active_ingredients,
                'drug_type' => $request->drug_type,
                'dosage' => $request->dosage,
                'note' => $request->note
            ]);
        return response()->json(['drug' => $drug], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Drug  $drug
     * @return \Illuminate\Http\Response
     */
    public function show(Drug $drug)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Drug  $drug
     * @return \Illuminate\Http\Response
     */
    public function edit(Drug $drug)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Drug  $drug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validate drug request
        $rules = $this->rules();
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()],400);
        }
        else {
            $drug = Drug::find($id)->fill($request->all());
            if($drug->update()){
                return response()->json(['drug' => $drug], 200);
            }
            else {
                return response()->json(['message' => 'bad request'],400);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Drug  $drug
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $drug = Drug::find($id);
        $drug->delete();
        return response()->json(['drug' => $drug], 200);
    }
}
