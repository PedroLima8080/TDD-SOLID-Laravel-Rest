<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::name('app')->middleware(['auth'])->group(function(){
    Route::post('/category', [CategoryController::class, 'store'])->name('.category.store');
    Route::get('/category', [CategoryController::class, 'index'])->name('.category.index');
    Route::get('/category/{id}', [CategoryController::class, 'edit'])->name('.category.edit');
    Route::put('/category/{id}', [CategoryController::class, 'update'])->name('.category.update');
    Route::get('/create/category', [CategoryController::class, 'create'])->name('.category.create');
    Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('.category.destroy');
    Route::get('/home', [HomeController::class, 'index'])->name('.home');

    Route::post('/logout', [UserController::class, 'logout'])->name('.logout');
});


Route::name('auth')->middleware(['guest'])->group(function(){
    Route::get('/register', [UserController::class, 'create'])->name('.create');
    Route::post('/register', [UserController::class, 'register'])->name('.register');

    Route::get('/login', [UserController::class, 'login'])->name('.login');
    Route::post('/login', [UserController::class, 'authenticate'])->name('.authenticate');
});

    