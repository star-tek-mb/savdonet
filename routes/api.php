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

Route::namespace('App\Http\Controllers')->group(function() {
    Route::get('/category', 'ApiController@mainCategories');
    Route::get('/category/{id}', 'ApiController@subCategories');
    Route::get('/products/latest', 'ApiController@latestProducts');
    Route::get('/products/{id}', 'ApiController@allProducts');
    Route::get('/product/{id}', 'ApiController@getInformation');
    Route::get('/cart', 'ApiController@cart');
});