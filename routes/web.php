<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
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

Route::get('admin', [AdminController::class, 'index']);
Route::post('admin/auth', [AdminController::class, 'auth'])->name('admin.auth');


Route::group(['middleware' => 'admin_auth'], function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    //category
    Route::get('admin/category', [CategoryController::class, 'index'])->name('category');
    Route::get('admin/category/manage_category', [CategoryController::class, 'manage_category'])->name('manage_category');
    Route::get('admin/category/manage_category/{id}', [CategoryController::class, 'manage_category'])->name('edit');
    Route::post('admin/category/manage_category_process', [CategoryController::class, 'manage_category_process'])->name('category.manage_category_process');
    Route::get('admin/category/delete/{id}', [CategoryController::class, 'delete'])->name('delete');
    Route::get('admin/category/status/{type}/{id}', [CategoryController::class, 'status'])->name('status');

    //coupon
    Route::get('admin/coupon', [CouponController::class, 'index'])->name('coupon');
    Route::get('admin/coupon/manage_coupon', [CouponController::class, 'manage_coupon'])->name('manage_coupon');
    Route::get('admin/coupon/manage_coupon/{id}', [CouponController::class, 'manage_coupon'])->name('edit');
    Route::post('admin/coupon/manage_coupon_process', [CouponController::class, 'manage_coupon_process'])->name('coupon.manage_coupon_process');
    Route::get('admin/coupon/delete/{id}', [CouponController::class, 'delete'])->name('delete');
    Route::get('admin/coupon/status/{type}/{id}', [CouponController::class, 'status'])->name('status');

    Route::get('admin/logout', function () {
        session()->forget('ADMIN_LOGIN');
        session()->forget('ADMIN_ID');
        session()->flash('error', 'Logout Successfully');
        return redirect('admin');
    })->name('logout');
});