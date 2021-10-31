<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
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

Route::name('product.')->prefix('product')->group(function () {
    Route::get('index', [ProductController::class, 'index'])->name('list');
    Route::get('id/{id}', [ProductController::class, 'show'])->name('show');
    Route::get('create', [ProductController::class, 'create'])->name('create');
    Route::post('create', [ProductController::class, 'store']);
    Route::get('edit/{id}', [ProductController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [ProductController::class, 'update'])->name('update');
    Route::post('delete/{id}', [ProductController::class, 'destroy'])->name('destroy');
});

Route::name('category.')->prefix('category')->group(function(){
    Route::get('index', [CategoryController::class, 'index'])->name('list');
    Route::get('id/{id}', [CategoryController::class, 'show'])->name('show');
    Route::get('create', [CategoryController::class, 'create'])->name('create');
    Route::post('create', [CategoryController::class, 'store']);
    Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [CategoryController::class, 'update'])->name('update');
    Route::post('delete/{id}', [CategoryController::class, 'destroy'])->name('destroy');
});

Route::name('supplier.')->prefix('supplier')->group(function(){
    Route::get('index', [CategoryController::class, 'index'])->name('list');
    Route::get('id/{id}', [CategoryController::class, 'show'])->name('show');
    Route::get('create', [CategoryController::class, 'create'])->name('create');
    Route::post('create', [CategoryController::class, 'store']);
    Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [CategoryController::class, 'update'])->name('update');
    Route::post('delete/{id}', [CategoryController::class, 'destroy'])->name('destroy');
});
