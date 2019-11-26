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
Route::get('user/{user_id}','UserController@show')->middleware('auth:api');
// update a user
Route::put('user','UserController@update')->middleware('auth:api');
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
