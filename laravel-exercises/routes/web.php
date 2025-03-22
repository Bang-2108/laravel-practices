<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CreateTableController;
use App\Http\Controllers\ProductController;

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

Route::get('/register', [PageController::class, 'getRegister']) -> name('register');
Route::post('/register', [PageController::class, 'postRegister']);

Route::get('/login', [PageController::class, 'getLogin']);
Route::post('/login', [PageController::class, 'postLogin']);

Route::get('logout', [PageController::class, 'Logout']);

// Cake_Shop - Admin (get: create, post: store)
Route::get('/admin', [PageController::class, 'getIndexAdmin']);
Route::get('/admin-export', [PageController::class, 'exportAdminProduct'])->name('export');

Route::get('/admin-add-form', [PageController::class, 'getAdminAdd'])->name('add-product');
Route::post('/admin-add-form', [ProductController::class, 'postAdminAdd']);

Route::get('/admin-edit-form/{id}', [PageController::class, 'getAdminEdit']);
Route::post('/admin-edit', [ProductController::class, 'postAdminEdit']);

Route::post('/admin-delete/{id}', [ProductController::class, 'postAdminDelete']);