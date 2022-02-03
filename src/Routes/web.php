<?php

use Illuminate\Support\Facades\Route;
use Mariojgt\EbayLaravel\Controllers\EbayDemoController;

// Standard
Route::group([
    'middleware' => ['web'],
], function () {
    // Example page not required to be login
    Route::get('/ebay-demo', [EbayDemoController::class, 'index'])->name('ebay.demo');
});
