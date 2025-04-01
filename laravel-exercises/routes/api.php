<?php

use App\Http\Controllers\API\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
});
