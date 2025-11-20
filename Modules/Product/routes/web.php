<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\ProductController;
use Modules\Product\Http\Controllers\CategoryController;
use Modules\Product\Http\Controllers\ReviewController;

// Public routes - anyone can view
Route::middleware(['web'])->group(function () {
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
});

// User routes - only users with 'user' role can manage CRUD
Route::middleware(['auth', 'check.user.role'])->group(function () {
    // Product management
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    
    // Category management
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::get('categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
    Route::put('categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

// Public product show - must be after specific routes like 'create'
Route::middleware(['web'])->group(function () {
    Route::get('products/{id}', [ProductController::class, 'show'])->name('products.show');
});

// Customer routes - only customers can write reviews
Route::middleware(['auth', 'check.customer.role'])->group(function () {
    Route::get('products/{productId}/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');
});
