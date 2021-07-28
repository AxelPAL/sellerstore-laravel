<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SellerController;

Route::name('home')->get('/', [HomeController::class, 'index']);
Route::name('catalog')->get('categories', [CategoryController::class, 'index']);
Route::name('category')->get('category/{id}', [CategoryController::class, 'index']);
Route::name('categoryWithPage')->get('category/{id}/{page}', [CategoryController::class, 'index']);
Route::name('product')->get('products/{id}', [ProductController::class, 'product']);
Route::name('buy-product')->get('buy-product', [ProductController::class, 'buy']);
Route::name('seller')->get('seller/{id}', [SellerController::class, 'index']);
Route::name('sellerGoods')->get('seller/{id}/goods', [SellerController::class, 'goods']);
Route::name('sellerResponses')->get('seller/{id}/responses', [SellerController::class, 'responses']);
Route::name('search')->get('search', [SearchController::class, 'index']);
Route::name('searchSlug')->get('search/{q}', [SearchController::class, 'index']);
Route::name('predictSearch')->get('search/predict/{q}', [SearchController::class, 'predict']);

Route::group(['prefix' => 'admin'], static function () {
    Voyager::routes();
});

Route::get('{slug}', 'PageController@show');
