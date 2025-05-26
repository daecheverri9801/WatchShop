<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Web\BrandController;
use App\Http\Controllers\Web\ColorController;
use App\Http\Controllers\Web\MaterialController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\WelcomeController;

Route::get('/', [WelcomeController::class, 'index'])
    ->name('welcome');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('brands', BrandController::class);
    Route::resource('colors', ColorController::class);
    Route::resource('materials', MaterialController::class);
    Route::resource('categories', CategoryController::class)->parameters([
        'categories' => 'category:slug',
    ]);
    Route::resource('products', ProductController::class)->parameters([
        'products' => 'product:slug'
    ])->except(['show']);
    Route::get('/register', function () {
        return Inertia::render('Auth/Register');
    })->name('register');
});

Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
