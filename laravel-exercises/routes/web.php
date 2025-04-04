<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreateTableController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\API\Admin\ApiController;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

// Cake_Shop
Route::get('/homepage', [PageController::class,'getIndex']);
Route::get('/create-table', [CreateTableController::class, 'createAllTables']);
Route::get('/category',[PageController::class,'getLoaiSp']);
Route::get('/type/{id}', [PageController::class, 'getLoaiSp']);
Route::get('/detail/{id}', [PageController::class, 'getDetail']);
Route::get('/contact', [PageController::class, 'getContact']);
Route::get('/about', [PageController::class, 'getAbout']);
Route::get('/search', [PageController::class, 'getSearch']) -> name('search');

Route::get('add-to-cart/{id}', [PageController::class, 'getAddToCart'])->name('themgiohang');												
Route::get('del-cart/{id}', [PageController::class, 'getDelItemCart'])->name('xoagiohang');												
												


Route::get('/register', [AuthController::class, 'getRegister']) -> name('register');
Route::post('/register', [AuthController::class, 'postRegister']);

Route::get('/login', [AuthController::class, 'getLogin'])-> name('login');
Route::post('/login', [AuthController::class, 'postLogin']);

Route::get('logout', [AuthController::class, 'Logout']);


// Cake_Shop - Admin (get: create, post: store)
Route::get('/admin', [PageController::class, 'getIndexAdmin']);
// Route::get('/admin/pros', [ApiController::class, 'index']);
Route::get('/admin-export', [PageController::class, 'exportAdminProduct'])->name('export');

Route::get('/admin-add-form', [PageController::class, 'getAdminAdd'])->name('add-product');
Route::post('/admin-add-form', [ProductController::class, 'postAdminAdd']);

Route::get('/admin-edit-form/{id}', [PageController::class, 'getAdminEdit']);
Route::post('/admin-edit', [ProductController::class, 'postAdminEdit']);

Route::post('/admin-delete/{id}', [ProductController::class, 'postAdminDelete']);

// API
Route::prefix('admin')->group(function () {
    Route::get('products', [ApiController::class, 'index']);
    Route::post('products', [ApiController::class, 'store']);
    Route::get('products/{product}', [ApiController::class, 'show']);
    Route::put('products/{product}', [ApiController::class, 'update']);
    Route::delete('products/{product}', [ApiController::class, 'destroy']);
});