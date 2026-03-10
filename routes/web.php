<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

Route::get('/', [OrderController::class, 'showForm'])->name('order-form');
Route::post('/', [OrderController::class, 'store']);

Route::get('products', [ProductController::class, 'index'])->name('products');
Route::get('products/{product}', [ProductController::class, 'show'])->name('product');
