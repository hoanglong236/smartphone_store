<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductDetailController;
use App\Http\Controllers\Admin\SliderController;

use  App\Http\Controllers\Consumer\ConsumerController;
use App\Models\Slider;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('admin',[AdminController::class, 'index'])->name('admin');
Route::post('admin/auth',[AdminController::class, 'auth'])->name('admin.auth');

Route::get('admin/register',[AdminController::class, 'register'])->name('admin.register');
Route::post('admin/registerhandle',[AdminController::class, 'register_handle'])->name('admin.register_handle');

Route::group(['middleware'=>'admin_auth'], function(){

    Route::get('admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('admin/category', [CategoryController::class, 'index'])->name('admin.category');
    Route::get('admin/category/add_category', [CategoryController::class, 'add_category'])->name('admin.category.add_category');
    Route::post('admin/category/add_category_handle', [CategoryController::class, 'add_category_handle'])->name('admin.category.add_category_handle');
    Route::get('admin/category/delete_category/{category_id}', [CategoryController::class, 'delete_category'])->name('admin.category.delete_category');
    Route::get('admin/category/update_category/{category_id}', [CategoryController::class, 'update_category'])->name('admin.category.update_category');
    Route::post('admin/category/update_category_handle', [CategoryController::class, 'update_category_handle'])->name('admin.category.update_category_handle');
    Route::get('admin/category/change_display/{category_id}', [CategoryController::class, 'change_display'])->name('admin.category.change_display');

    Route::get('admin/brand', [BrandController::class, 'index'])->name('admin.brand');
    Route::get('admin/brand/add_brand', [BrandController::class, 'add_brand'])->name('admin.brand.add_brand');
    Route::post('admin/brand/add_brand_handle', [BrandController::class, 'add_brand_handle'])->name('admin.brand.add_brand_handle');
    Route::get('admin/brand/delete_brand/{brand_id}', [BrandController::class, 'delete_brand'])->name('admin.brand.delete_brand');
    Route::get('admin/brand/update_brand/{brand_id}', [BrandController::class, 'update_brand'])->name('admin.brand.update_brand');
    Route::post('admin/brand/update_brand_handle', [BrandController::class, 'update_brand_handle'])->name('admin.brand.update_brand_handle');
    Route::get('admin/brand/change_display/{brand_id}', [BrandController::class, 'change_display'])->name('admin.brand.change_display');

    Route::get('admin/coupon', [CouponController::class, 'index'])->name('admin.coupon');
    Route::get('admin/coupon/add_coupon', [CouponController::class, 'add_coupon'])->name('admin.coupon.add_coupon');
    Route::post('admin/coupon/add_coupon_handle', [CouponController::class, 'add_coupon_handle'])->name('admin.coupon.add_coupon_handle');
    Route::get('admin/coupon/delete_coupon/{coupon_id}', [CouponController::class, 'delete_coupon'])->name('admin.coupon.delete_coupon');
    Route::get('admin/coupon/update_coupon/{coupon_id}', [CouponController::class, 'update_coupon'])->name('admin.coupon.update_coupon');
    Route::post('admin/coupon/update_coupon_handle', [CouponController::class, 'update_coupon_handle'])->name('admin.coupon.update_coupon_handle');
    
    Route::get('admin/product', [ProductController::class, 'index'])->name('admin.product');
    Route::get('admin/product/add_product', [ProductController::class, 'add_product'])->name('admin.product.add_product');
    Route::post('admin/product/add_product_handle', [ProductController::class, 'add_product_handle'])->name('admin.product.add_product_handle');
    Route::get('admin/product/delete_product/{product_id}', [ProductController::class, 'delete_product'])->name('admin.product.delete_product');
    Route::get('admin/product/update_product/{product_id}', [ProductController::class, 'update_product'])->name('admin.product.update_product');
    Route::post('admin/product/update_product_handle', [ProductController::class, 'update_product_handle'])->name('admin.product.update_product_handle');
    
    Route::get('admin/product_detail/{product_id}', [ProductDetailController::class, 'index'])->name('admin.product_detail');
    Route::get('admin/product_detail/add_product_detail/{product_id}', [ProductDetailController::class, 'add_product_detail'])->name('admin.product_detail.add_product_detail');
    Route::post('admin/product_detail/add_product_detail_handle', [ProductDetailController::class, 'add_product_detail_handle'])->name('admin.product_detail.add_product_detail_handle');
    Route::get('admin/product_detail/delete_product_detail_option/{product_detail_id}', [ProductDetailController::class, 'delete_product_detail_option'])->name('admin.product_detail.delete_product_detail_option');
    Route::get('admin/product_detail/add_product_detail_option/{product_detail_id}', [ProductDetailController::class, 'add_product_detail_option'])->name('admin.product_detail.add_product_detail_option');
    Route::post('admin/product_detail/add_product_detail_option_handle', [ProductDetailController::class, 'add_product_detail_option_handle'])->name('admin.product_detail.add_product_detail_option_handle');
    Route::get('admin/product_detail/update_product_detail/{product_detail_id}', [ProductDetailController::class, 'update_product_detail'])->name('admin.product_detail.update_product_detail');
    Route::post('admin/product_detail/update_product_detail_handle', [ProductDetailController::class, 'update_product_detail_handle'])->name('admin.product_detail.update_product_detail_handle');
    Route::get('admin/product_detail/add_product_detail_option_value/{product_detail_id}', [ProductDetailController::class, 'add_product_detail_option_value'])->name('admin.product_detail.add_product_detail_option_value');
    Route::post('admin/product_detail/add_product_detail_option_value_handle', [ProductDetailController::class, 'add_product_detail_option_value_handle'])->name('admin.product_detail.add_product_detail_option_value_handle');
    Route::get('admin/product_detail/add_product_images/{product_id}', [ProductDetailController::class, 'add_product_images'])->name('admin.product_detail.add_product_images');
    Route::post('admin/product_detail/add_product_images_handle', [ProductDetailController::class, 'add_product_images_handle'])->name('admin.product_detail.add_product_images_handle');
    Route::get('admin/product_detail/delete_product_image/{product_image_id}', [ProductDetailController::class, 'delete_product_image'])->name('admin.product_detail.delete_product_image');
    
    Route::get('admin/customer', [CustomerController::class, 'index'])->name('admin.customer');
    Route::get('admin/customer/delete_customer/{customer_id}', [CustomerController::class, 'delete_customer'])->name('admin.customer.delete_customer');
    Route::get('admin/customer/change_status/{customer_id}', [CustomerController::class, 'change_status'])->name('admin.customer.change_status');
    Route::get('admin/customer/customer_detail/{customer_id}', [CustomerController::class, 'customer_detail'])->name('admin.customer.customer_detail');
    
    Route::get('admin/order', [OrderController::class, 'index'])->name('admin.order');
    Route::get('admin/order/update_order_status/{order_id}/{status}', [OrderController::class, 'update_order_status'])->name('admin.order.update_order_status');
    Route::post('admin/order/delete_order/{order_id}', [OrderController::class, 'delete_order'])->name('admin.order.delete_order');
    Route::get('admin/order_detail/{order_id}', [OrderController::class, 'order_detail'])->name('admin.order_detail');

    Route::get('admin/slider', [SliderController::class, 'index'])->name('admin.slider');
    Route::get('admin/slider/add_slider', [SliderController::class, 'add_slider'])->name('admin.slider.add_slider');
    Route::post('admin/slider/add_slider_handle', [SliderController::class, 'add_slider_handle'])->name('admin.slider.add_slider_handle');
    Route::get('admin/slider/delete_slider/{slider_id}', [SliderController::class, 'delete_slider'])->name('admin.slider.delete_slider');
    Route::get('admin/slider/update_slider/{slider_id}', [SliderController::class, 'update_slider'])->name('admin.slider.update_slider');
    Route::post('admin/slider/update_slider_handle', [SliderController::class, 'update_slider_handle'])->name('admin.slider.update_slider_handle');
    
});


Route::get('/', [ConsumerController::class, 'index'])->name('/');
Route::get('/product_detail/{product_slug}', [ConsumerController::class, 'product_detail'])->name('product_detail');
Route::post('/product_detail/{product_id}/get_product_detail_option_1', [ConsumerController::class, 'get_product_detail_option_1']);
Route::post('/product_detail/{product_id}/get_product_detail_option_2', [ConsumerController::class, 'get_product_detail_option_2']);
Route::post('/product_detail/{product_id}/get_product_detail_option_3', [ConsumerController::class, 'get_product_detail_option_3']);
Route::post('/product_detail/{product_id}/get_product_detail', [ConsumerController::class, 'get_product_detail']);

Route::get('/register', [ConsumerController::class, 'register'])->name('register');
Route::post('/register_handle', [ConsumerController::class, 'register_handle'])->name('register_handle');
Route::post('/auth', [ConsumerController::class, 'auth'])->name('auth');
Route::get('/get_stock_quantity/{product_detail_id}', [ConsumerController::class, 'get_stock_quantity'])->name('get_stock_quantity');
Route::post('/add_to_cart', [ConsumerController::class, 'add_to_cart']);

Route::get('/category_page/{category_slug}/{page_index}/{page_size}', [ConsumerController::class, 'category_page'])->name('category_page');
Route::get('/search_result_page/{key_word}/{page_index}/{page_size}', [ConsumerController::class, 'search_result_page']);


Route::group(['middleware'=>'customer_auth'], function(){
    Route::get('/logout', [ConsumerController::class, 'logout'])->name('logout');
    Route::get('/profile', [ConsumerController::class, 'profile'])->name('profile');
    Route::post('/update_profile_handle', [ConsumerController::class, 'update_profile_handle'])->name('update_profile_handle');
    Route::get('/profile/add_address', [ConsumerController::class, 'add_address'])->name('profile.add_address');
    Route::post('/profile/add_address_handle', [ConsumerController::class, 'add_address_handle'])->name('profile.add_address_handle');
    Route::get('/cart', [ConsumerController::class, 'cart'])->name('cart');
    Route::get('/delete_cart_detail/{cart_detail_id}', [ConsumerController::class, 'delete_cart_detail'])->name('delete_cart_detail');
    Route::get('/update_cart_detail_quantity/{cart_detail_id}/{quantity}', [ConsumerController::class, 'update_cart_detail_quantity'])->name('update_cart_detail_quantity');
    Route::post('/create_session_checkout', [ConsumerController::class, 'create_session_checkout'])->name('create_session_checkout');
    Route::get('/checkout', [ConsumerController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/check_order_detail_quantity', [ConsumerController::class, 'check_order_detail_quantity']);
    Route::post('/place_order', [ConsumerController::class, 'place_order']);
    Route::get('/my_order/{type}', [ConsumerController::class, 'my_order'])->name('my_order');
    Route::post('/cancel_order/{order_id}', [ConsumerController::class, 'cancel_order']);
});
