<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::name('app')->middleware(['auth'])->group(function(){
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::name('auth')->middleware(['guest'])->group(function(){
    Route::get('/register', [UserController::class, 'create'])->name('.create');
    Route::post('/register', [UserController::class, 'register'])->name('.register');

    Route::get('/login', [UserController::class, 'login'])->name('.login');
    Route::post('/login', [UserController::class, 'authenticate'])->name('.authenticate');
});

    