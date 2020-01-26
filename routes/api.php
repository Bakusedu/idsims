<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// create a user
Route::post('user','UserController@store');
// view a user profile
Route::get('user','UserController@show')->middleware('auth:api');
// update a user
Route::put('user/{user_id}','UserController@update')->middleware('auth:api');
// delete a user
Route::delete('user/{user_id}','UserController@destroy')->middleware('auth:api');
// get all users
Route::get('/users','UserController@index')->middleware('auth:api');
// login user
Route::post('/login','UserController@login');
// create a customer
Route::post('/customer','CustomerController@store');
// show a customer profile
Route::get('/customer/{customer_id}','CustomerController@show');
// create a vendor
Route::post('/vendor','VendorController@store');
// create a drug
Route::post('/drug','DrugController@store')->middleware('auth:api');
// update a drug
Route::patch('/drug/{drug_id}','DrugController@update')->middleware('auth:api');
// get all drugs
Route::get('/drug','DrugController@index')->middleware('auth:api');
// show single drug
Route::get('/drug/{id}','DrugController@show')->middleware('auth:api');
// delete a drug
Route::delete('/drug/{drug_id}','DrugController@destroy')->middleware('auth:api');
// Search for anything related to a drug table
Route::get('/search','VendorController@search')->middleware('auth:api');
// get Customer drug history
Route::get('/customer/{phone}','UserController@customerDrugHistory')->middleware('auth:api');
// add a new purchase
Route::post('/purchase','UserController@purchase')->middleware('auth:api');
// get vendor drug purchase
Route::get('/drug_purchase/{id}','UserController@getDrugPurchase')->middleware('auth:api');
// get health information data through purchases made by customer
Route::get('/health_information','CustomerController@healthInformation')->middleware('auth:api');
// post vendor settings
Route::post('/vendor_settings','VendorController@upload')->middleware('auth:api');
// get vendor settings
Route::get('/vendor_settings','VendorController@getSettings')->middleware('auth:api');
// get all vendors registered in the db
Route::get('/vendors','UserController@vendors')->middleware('auth:api');
// get all customers registered in the db
Route::get('/customers','UserController@customers')->middleware('auth:api');
// get vendors sold drugs
Route::get('/vendor_purchases/{vendor_id}','UserController@allVendorPurchase')->middleware('auth:api');
// get vendors sold drugs
Route::get('/vendor_purchase_frequency/{vendor_id}','UserController@vendorFrequency')->middleware('auth:api');
// toggle Vendor activation status
Route::get('/toggle_status/{vendor_id}','UserController@toggleActivation')->middleware('auth:api');
