<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReceivedNoteController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Models\Order;
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

Route::post('/report', [DashboardController::class, 'report']);
Route::get('/report', [DashboardController::class, 'report']);
Route::get('/report/download', [DashboardController::class, 'reportDownload']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::middleware('admin')->name('product.')->prefix('/product')->group(function () {
    Route::get('index', [ProductController::class, 'index'])->name('list');
    Route::get('id/{id}', [ProductController::class, 'show'])->name('show');
    Route::get('create', [ProductController::class, 'create'])->name('create');
    Route::post('create', [ProductController::class, 'store']);
    Route::get('edit/{id}', [ProductController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [ProductController::class, 'update'])->name('update');
    Route::post('delete/{id}', [ProductController::class, 'destroy'])->name('destroy');
});
Route::post('product/ajax', [ProductController::class, 'ajax'])->name('product.ajax');

Route::name('category.')->prefix('/category')->group(function () {
    Route::get('index', [CategoryController::class, 'index'])->name('list');
    Route::get('id/{id}', [CategoryController::class, 'show'])->name('show');
    Route::get('create', [CategoryController::class, 'create'])->name('create');
    Route::post('create', [CategoryController::class, 'store']);
    Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [CategoryController::class, 'update'])->name('update');
    Route::post('delete/{id}', [CategoryController::class, 'destroy'])->name('destroy');
});

Route::name('supplier.')->prefix('/supplier')->group(function () {
    Route::get('index', [SupplierController::class, 'index'])->name('list');
    Route::get('id/{id}', [SupplierController::class, 'show'])->name('show');
    Route::get('create', [SupplierController::class, 'create'])->name('create');
    Route::post('create', [SupplierController::class, 'store']);
    Route::get('edit/{id}', [SupplierController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [SupplierController::class, 'update'])->name('update');
    Route::post('delete/{id}', [SupplierController::class, 'destroy'])->name('destroy');
    Route::post('ajax', [SupplierController::class, 'ajax'])->name('ajax');
});

Route::name('order.')->prefix('/order')->group(function () {
    Route::get('index', [OrderController::class, 'index'])->name('list');
    Route::get('id/{id}', [OrderController::class, 'show'])->name('show');
    Route::get('create', [OrderController::class, 'create'])->name('create');
    Route::post('create', [OrderController::class, 'store']);
    Route::get('edit/{id}', [OrderController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [OrderController::class, 'update'])->name('update');
    Route::post('delete/{id}', [OrderController::class, 'destroy'])->name('destroy');
    Route::post('cancel', [OrderController::class, 'cancel'])->name('cancel');
    Route::post('done', [OrderController::class, 'done'])->name('done');
});

Route::middleware('admin')->name('coupon.')->prefix('/coupon')->group(function () {
    Route::get('index', [CouponController::class, 'index'])->name('list');
    Route::get('id/{id}', [CouponController::class, 'show'])->name('show');
    Route::get('create', [CouponController::class, 'create'])->name('create');
    Route::post('create', [CouponController::class, 'store']);
    Route::get('edit/{id}', [CouponController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [CouponController::class, 'update'])->name('update');
    //Route::post('delete/{id}', [CouponController::class, 'destroy'])->name('destroy');
});
Route::post('coupon/ajax', [CouponController::class, 'ajax'])->name('coupon.ajax');

Route::name('received-note.')->prefix('/receive-note')->group(function () {
    Route::get('index', [ReceivedNoteController::class, 'index'])->name('list');
    Route::get('id/{id}', [ReceivedNoteController::class, 'show'])->name('show');
    Route::get('create', [ReceivedNoteController::class, 'create'])->name('create');
    Route::post('create', [ReceivedNoteController::class, 'store']);
    Route::get('edit/{id}', [ReceivedNoteController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [ReceivedNoteController::class, 'update'])->name('update');
});

Route::name('user.')->prefix('/user')->group(function () {
    Route::get('/index', [UserController::class, 'index'])->name('list');
    Route::post('/update', [UserController::class, 'update'])->name('update');
    Route::post('/delete', [UserController::class, 'destroy'])->name('destroy');
});
