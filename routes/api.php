<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('user', function (Request $request) {});
});

Route::apiResource('brands', BrandController::class);
Route::apiResource('colors', ColorController::class);
Route::apiResource('materials', MaterialController::class);
Route::apiResource('categories', CategoryController::class)->parameters([
    'categories' => 'category:slug'
]);
Route::apiResource('products', ProductController::class)->parameters([
    'products' => 'product:slug'
]);

Route::post('/login', [LoginController::class, 'login']);
