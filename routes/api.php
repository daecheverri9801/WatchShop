<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\LoginController;


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('user', function (Request $request) {
        Route::apiResource('brands', BrandController::class);
        Route::apiResource('colors', ColorController::class);
        Route::apiResource('materials', MaterialController::class);
    });
});

Route::post('/login', [LoginController::class, 'login']);
