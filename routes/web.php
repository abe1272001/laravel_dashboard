<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
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
    return view('home');
})->name('home');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::get('/login/refreshToke', [LoginController::class, 'update'])->name('refreshToken');

Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/search', [DashboardController::class, 'search'])->name('search');

//爬資料
Route::get('/dashboard/catch', [UserController::class, 'store'])->name('catchData');
Route::get('/dashboard/delete', [UserController::class, 'destroy'])->name('tableDelete');
