<?php
use App\Http\Controllers\API\Admin\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('products', [ApiController::class, 'index']);
   
