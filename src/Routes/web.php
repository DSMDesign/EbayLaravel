<?php

use Illuminate\Support\Facades\Route;
use Mariojgt\EbayLaravel\Controllers\EbayAppAutenticateController;

// Standard
Route::group([
    'middleware' => ['web'],
], function () {
    // Login the user on the ebay and send back to the redirect url
    Route::get('/ebay-app-login', [EbayAppAutenticateController::class, 'index'])->name('ebay.demo');
    // This is the redirect url witch will get the toke valide and save in the txt file on the storage
    Route::any('/ebay-autenticate', [EbayAppAutenticateController::class, 'autenticateToken'])->name('ebay.ebay-autenticate');
});
