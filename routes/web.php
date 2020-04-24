<?php

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

Route::name('home')->get('/', 'HomeController@index');
Route::name('catalog')->get('categories', 'CategoryController@index');
Route::name('category')->get('category/{id}', 'CategoryController@index');
Route::name('categoryWithPage')->get('category/{id}/{page}', 'CategoryController@index');
Route::name('product')->get('products/{id}', 'ProductController@product');
Route::name('buy-product')->get('buy-product', 'ProductController@buy');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
