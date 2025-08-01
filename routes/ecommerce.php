<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('products')->as('products.')->group(function () {
        Route::resource('attributes', AttributeController::class)->names('attributes');
        Route::resource('categories', CategoryController::class)->names('categories');
        Route::resource('{product}/variants', ProductVariantController::class)->names('variants');
    });
    Route::resource('products', ProductController::class);
});



Route::get('/products', [FrontendProductController::class, 'index'])->name('frontend.pages.index');
Route::get('/products/{slug}', [FrontendProductController::class, 'show'])->name('frontend.products.show');


// Cart routes
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('frontend.cart.index');
    Route::post('add', [CartController::class, 'add'])->name('frontend.cart.add');
    Route::post('remove', [CartController::class, 'remove'])->name('frontend.cart.remove');
    Route::post('update', [CartController::class, 'update'])->name('frontend.cart.update');
});

Route::get('/checkout', [CartController::class, 'checkout'])->name('frontend.checkout.index');
