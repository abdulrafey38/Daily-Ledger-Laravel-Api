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
//Route::post('token','api\AuthController@tokenbahir');



Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', 'api\AuthController@logout');
    Route::post('/update', 'api\AuthController@update');
    Route::get('monthDT/{id}', 'TransactionController@monthDT');
    Route::get('dailyTransaction', 'TransactionController@daily');
    Route::get('getSupplierProducts/{id}', 'ProductController@getSupplierProducts');
    Route::get('monthlySpendAmount/{id}', 'TransactionController@monthlySpendAmount');
    Route::get('allProducts', 'DashBoardController@allProducts');
    Route::get('allSuppliers', 'DashBoardController@allSuppliers');
    Route::get('totalAmountSpend', 'DashBoardController@totalAmountSpend');
    Route::get('allTransactions', 'DashBoardController@allTransaction');
    Route::post('token', 'api\AuthController@token');



    //=================================================================
    Route::resource('/product', 'ProductController');
    //=================================================================
    //=================================================================
    Route::resource('/supplier', 'SupplierController');

    //=================================================================
    //=================================================================
    Route::resource('/month', 'MonthController');

    //=================================================================
    //=================================================================
    Route::resource('/transaction', 'TransactionController');

    //=================================================================


});
