<?php

use Illuminate\Support\Facades\Route;
use EbayIntegration\EbayLaravel\Controllers\EbayDemoController;

// Standard
Route::group([
    'middleware' => ['web'],
], function () {
    // Demo route to create new products on ebay
    Route::get('/ebay/demo/product', [EbayDemoController::class, 'index'])->name('ebay.demo.product');
    // Save demo prodcuts on ebay
    Route::post('/ebay/demo/product/store', [EbayDemoController::class, 'store'])->name('ebay.demo.product.store');
});
