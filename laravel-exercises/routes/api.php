<?php
use App\Http\Controllers\API\Admin\ApiController;
use Illuminate\Support\Facades\Route;
Route::prefix('admin')->group(function () {
    Route::get('products', [ApiController::class, 'index']);
    Route::post('products', [ApiController::class, 'store']);
    Route::get('products/{product}', [ApiController::class, 'show']);
    Route::put('products/{product}', [ApiController::class, 'update']);
    Route::delete('products/{product}', [ApiController::class, 'destroy']);
});
