<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\CustomerController;
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

    //brand
    Route::get('admin/brand', [BrandController::class, 'index'])->name('brand');
    Route::get('admin/brand/manage_brand', [BrandController::class, 'manage_brand'])->name('manage_brand');
    Route::get('admin/brand/manage_brand/{id}', [BrandController::class, 'manage_brand'])->name('edit');
    Route::post('admin/brand/manage_brand_process', [BrandController::class, 'manage_brand_process'])->name('brand.manage_brand_process');
    Route::get('admin/brand/delete/{id}', [BrandController::class, 'delete'])->name('delete');
    Route::get('admin/brand/status/{type}/{id}', [BrandController::class, 'status'])->name('status');

    //product
    Route::get('admin/product', [ProductController::class, 'index'])->name('product');
    Route::get('admin/product/manage_product', [ProductController::class, 'manage_product'])->name('manage_product');
    Route::get('admin/product/manage_product/{id}', [ProductController::class, 'manage_product'])->name('edit');
    Route::post('admin/product/manage_product_process', [ProductController::class, 'manage_product_process'])->name('product.manage_product_process');
    Route::get('admin/product/delete/{id}', [ProductController::class, 'delete'])->name('delete');
    Route::get('admin/product/status/{type}/{id}', [ProductController::class, 'status'])->name('status');
    Route::get('admin/product/product_attr/delete/{pattr_id}/{id}', [ProductController::class, 'product_attr_delete'])->name('product_attr_delete');
    Route::get('admin/product/product_images/delete/{pimage_id}/{id}', [ProductController::class, 'product_image_delete'])->name('product_image_delete');

    //tax
    Route::get('admin/tax', [TaxController::class, 'index'])->name('tax');
    Route::get('admin/tax/manage_tax', [TaxController::class, 'manage_tax'])->name('manage_tax');
    Route::get('admin/tax/manage_tax/{id}', [TaxController::class, 'manage_tax'])->name('edit');
    Route::post('admin/tax/manage_tax_process', [TaxController::class, 'manage_tax_process'])->name('tax.manage_tax_process');
    Route::get('admin/tax/delete/{id}', [TaxController::class, 'delete'])->name('delete');
    Route::get('admin/tax/status/{type}/{id}', [TaxController::class, 'status'])->name('status');

    //customer
    Route::get('admin/customer', [CustomerController::class, 'index'])->name('customer');
    Route::get('admin/customer/manage_customer', [CustomerController::class, 'manage_customer'])->name('manage_customer');
    Route::get('admin/customer/manage_customer/{id}', [CustomerController::class, 'manage_customer'])->name('edit');
    Route::post('admin/customer/manage_customer_process', [CustomerController::class, 'manage_customer_process'])->name('customer.manage_customer_process');
    Route::get('admin/customer/delete/{id}', [CustomerController::class, 'delete'])->name('delete');
    Route::get('admin/customer/status/{type}/{id}', [CustomerController::class, 'status'])->name('status');


    Route::get('admin/logout', function () {
        session()->forget('ADMIN_LOGIN');
        session()->forget('ADMIN_ID');
        session()->flash('error', 'Logout Successfully');
        return redirect('admin');
    })->name('logout');
});