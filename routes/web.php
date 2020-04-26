<?php

Route::name('home')->get('/', 'HomeController@index');
Route::name('catalog')->get('categories', 'CategoryController@index');
Route::name('category')->get('category/{id}', 'CategoryController@index');
Route::name('categoryWithPage')->get('category/{id}/{page}', 'CategoryController@index');
Route::name('product')->get('products/{id}', 'ProductController@product');
Route::name('buy-product')->get('buy-product', 'ProductController@buy');
Route::name('seller')->get('seller/{id}', 'SellerController@index');
Route::name('sellerGoods')->get('seller/{id}/goods', 'SellerController@goods');
Route::name('sellerResponses')->get('seller/{id}/responses', 'SellerController@responses');
Route::name('search')->get('search', 'SearchController@index');
Route::name('searchSlug')->get('search/{q}', 'SearchController@index');
Route::name('searchSlug')->get('search/predict/{q}', 'SearchController@predict');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
