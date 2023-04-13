<?php

use App\Http\Controllers\AdminUserLogin;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::post('login', AdminUserLogin::class)->name('login');
    });
});
