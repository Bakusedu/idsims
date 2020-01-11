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
Route::get('/customer','CustomerController@store');
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
