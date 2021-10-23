<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
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

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::prefix('product')->group(function () {
    Route::get('index', [ProductController::class, 'index'])->name('list-product');
    Route::get('id/{id}', [ProductController::class, 'show'])->name('show-product');
    Route::get('create', [ProductController::class, 'create'])->name('create-product');
    Route::post('create', [ProductController::class, 'store']);
    Route::get('edit/{id}', [ProductController::class, 'edit'])->name('edit-product');
    Route::post('update/{id}', [ProductController::class, 'update'])->name('update-product');
    Route::post('delete/{id}', [ProductController::class, 'destroy'])->name('destroy-product');
});
