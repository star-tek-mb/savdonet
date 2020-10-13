<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::namespace('App\Http\Controllers')->group(function() {
    Route::get('/', 'SiteController@index')->name('home');
    Route::get('/category/{id}', 'SiteController@category')->name('category.show');
    Route::get('/product/{id}', 'SiteController@product')->name('product.show');
    Route::get('/cart', 'CartController@index')->name('cart.index');
    Route::get('/cart/clear', 'CartController@clear')->name('cart.clear');
    Route::get('/cart/{id}', 'CartController@store')->name('cart.store');
    Route::post('/order', 'CartController@makeOrder')->name('order');
});

Route::prefix('backend')->namespace('App\Http\Controllers\Auth')->group(function() {
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');
});

Route::name('backend.')->prefix('backend')->namespace('App\Http\Controllers\Backend')
                    ->middleware('auth', 'role:admin')->group(function() {
    Route::get('/', function() {
        return redirect()->route('backend.dashboard');
    });
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('categories', 'CategoryController')->only(['index', 'store', 'destroy']);
    Route::name('options.')->prefix('options')->group(function() {
        Route::get('/', 'OptionController@index')->name('index');
        Route::post('/', 'OptionController@store')->name('store');
        Route::delete('/{option}', 'OptionController@destroy')->name('destroy');
        Route::post('/value/{option}', 'OptionController@storeValue')->name('storeValue');
        Route::delete('/value/{value}', 'OptionController@destroyValue')->name('destroyValue');
    });
    Route::name('products.')->prefix('products')->group(function() {
        Route::get('/create/single', 'ProductController@createSingle')->name('create.single');
        Route::get('/create/variable', 'ProductController@createVariable')->name('create.variable');
        Route::get('/', 'ProductController@index')->name('index');
        Route::post('/', 'ProductController@store')->name('store');
        Route::get('/edit/{id}', 'ProductController@edit')->name('edit');
        Route::put('/{id}', 'ProductController@update')->name('update');
        Route::delete('/{id}', 'ProductController@destroy')->name('destroy');
        Route::post('/{id}/dropzone', 'ProductController@dropzoneUpload')->name('dropzone.upload');
        Route::get('/{id}/dropzone', 'ProductController@dropzoneInit')->name('dropzone.init');
        Route::delete('/{id}/dropzone', 'ProductController@dropzoneDelete')->name('dropzone.delete');
    });
    Route::name('orders.')->prefix('orders')->group(function() {
        Route::get('/', 'OrderController@index')->name('index');
    });
    Route::get('/settings', 'SettingController@index')->name('settings');
});
