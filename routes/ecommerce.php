<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductVariantController;


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('products')->as('products.')->group(function () {
        Route::resource('attributes', AttributeController::class)->names('attributes');
        Route::resource('categories', CategoryController::class)->names('categories');
        Route::resource('{product}/variants', ProductVariantController::class)->names('variants');
    });
    Route::resource('products', ProductController::class);
});

