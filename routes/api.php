<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'api\AuthController@register');
Route::post('login', 'api\AuthController@login');




Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('logout', 'api\AuthController@logout');
    Route::post('/update', 'api\AuthController@update');
    Route::get('monthDT/{id}','TransactionController@monthDT');
    Route::get('dailyTransaction','TransactionController@daily');
    Route::get('getSupplierProducts/{id}','ProductController@getSupplierProducts');

//=================================================================
Route::resource('/product', 'ProductController');
Route::post('/product/{id}','ProductController@update');
//=================================================================
//=================================================================
Route::resource('/supplier', 'SupplierController');
Route::post('/supplier/{id}','SupplierController@update');
//=================================================================
//=================================================================
Route::resource('/month', 'MonthController');
Route::post('/month/{id}','MonthController@update');
//=================================================================
//=================================================================
Route::resource('/transaction', 'TransactionController');
Route::post('/transaction/{id}','TransactionController@update');
//=================================================================


});