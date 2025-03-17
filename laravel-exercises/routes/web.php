<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CreateTableController;

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