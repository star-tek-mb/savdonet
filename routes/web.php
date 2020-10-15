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

Route::prefix('backend')->namespace('App\Http\Controllers\Auth')->group(function() {
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');
});

Route::name('backend.')->prefix('backend')->namespace('App\Http\Controllers\Backend')
                    ->middleware('auth', 'role:admin', 'setlocale')->group(function() {
    Route::get('/', function() {
        return redirect()->route('backend.dashboard');
    });
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('categories', 'CategoryController')->except(['show']);
    Route::resource('suppliers', 'SupplierController');
    Route::name('options.')->prefix('options')->group(function() {
        Route::get('/', 'OptionController@index')->name('index');
        Route::post('/', 'OptionController@store')->name('store');
        Route::put('/{option}', 'OptionController@update')->name('update');
        Route::delete('/{option}', 'OptionController@destroy')->name('destroy');
        Route::post('/value/{option}', 'OptionController@storeValue')->name('value.store');
        Route::put('/value/{value}', 'OptionController@updateValue')->name('value.update');
        Route::delete('/value/{value}', 'OptionController@destroyValue')->name('value.destroy');
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
        Route::get('/{id}', 'OrderController@show')->name('show');
        Route::put('/status/{id}', 'OrderController@updateStatus')->name('status.update');
    });
    Route::get('/settings', 'SettingController@index')->name('settings');
    Route::post('/settings', 'SettingController@store')->name('settings.store');
});

Route::prefix('{locale}')->where(['locale' => '(' . implode('|', config('app.locales')) . ')'])
        ->middleware('setlocale')->namespace('App\Http\Controllers')->group(function() {
    Route::get('/', 'SiteController@index')->name('home');
    Route::get('/category/{id}', 'SiteController@category')->name('category.show');
    Route::get('/product/{id}', 'SiteController@product')->name('product.show');
    Route::get('/search', 'SiteController@search')->name('search');
    Route::get('/cart', 'CartController@index')->name('cart.index');
    Route::get('/cart/clear', 'CartController@clear')->name('cart.clear');
    Route::get('/cart/{id}', 'CartController@store')->name('cart.store');
    Route::post('/order', 'CartController@makeOrder')->name('order');
});

Route::get('/', function() {
    return redirect(config('app.locale'));
});