<?php

use Illuminate\Support\Facades\Route;
use App\Traits\HasAPIResponse;

Route::get('/', function () {
    $response = new class {
        use HasAPIResponse;
    };
    return $response->replyUnauthorized();
});
