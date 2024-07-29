<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ProductController;
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

    //size
    Route::get('admin/size', [SizeController::class, 'index'])->name('size');
    Route::get('admin/size/manage_size', [SizeController::class, 'manage_size'])->name('manage_size');
    Route::get('admin/size/manage_size/{id}', [SizeController::class, 'manage_size'])->name('edit');
    Route::post('admin/size/manage_size_process', [SizeController::class, 'manage_size_process'])->name('size.manage_size_process');
    Route::get('admin/size/delete/{id}', [SizeController::class, 'delete'])->name('delete');
    Route::get('admin/size/status/{type}/{id}', [SizeController::class, 'status'])->name('status');

    //color
    Route::get('admin/color', [ColorController::class, 'index'])->name('color');
    Route::get('admin/color/manage_color', [ColorController::class, 'manage_color'])->name('manage_color');
    Route::get('admin/color/manage_color/{id}', [ColorController::class, 'manage_color'])->name('edit');
    Route::post('admin/color/manage_color_process', [ColorController::class, 'manage_color_process'])->name('color.manage_color_process');
    Route::get('admin/color/delete/{id}', [ColorController::class, 'delete'])->name('delete');
    Route::get('admin/color/status/{type}/{id}', [ColorController::class, 'status'])->name('status');

    //product
    Route::get('admin/product', [ProductController::class, 'index'])->name('product');
    Route::get('admin/product/manage_product', [ProductController::class, 'manage_product'])->name('manage_product');
    Route::get('admin/product/manage_product/{id}', [ProductController::class, 'manage_product'])->name('edit');
    Route::post('admin/product/manage_product_process', [ProductController::class, 'manage_product_process'])->name('product.manage_product_process');
    Route::get('admin/product/delete/{id}', [ProductController::class, 'delete'])->name('delete');
    Route::get('admin/product/status/{type}/{id}', [ProductController::class, 'status'])->name('status');
    Route::get('admin/product/product_attr/delete/{pattr_id}/{id}', [ProductController::class, 'product_attr_delete'])->name('product_attr_delete');
    Route::get('admin/product/product_images/delete/{pimage_id}/{id}', [ProductController::class, 'product_image_delete'])->name('product_image_delete');


    Route::get('admin/logout', function () {
        session()->forget('ADMIN_LOGIN');
        session()->forget('ADMIN_ID');
        session()->flash('error', 'Logout Successfully');
        return redirect('admin');
    })->name('logout');
});
