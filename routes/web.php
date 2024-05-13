<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\ComboController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\Login\LoginController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\ItemController as ControllersItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController as ControllersProductController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('admin/users/login', [LoginController::class, 'index'])->name('login');
Route::post('admin/users/login/store', [LoginController::class, 'store']);
Route::get('admin/users/signup', [LoginController::class, 'signup'])->name('signup');
Route::post('admin/users/signup/register', [LoginController::class, 'register']);
Route::get('/verify-account/{email}', [LoginController::class, 'verify'])->name('verify');
Route::get('/forgot-password', [LoginController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [LoginController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}/{email}', [LoginController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [LoginController::class, 'resetPassword'])->name('password.update');
Route::get('/change-password', [LoginController::class, 'showChangePasswordForm'])->name('change-password-form');
Route::post('/change-password', [LoginController::class, 'changePassword'])->name('change-password');
// Route cho đăng xuất web
Route::post('/logout', [LoginController::class, 'logoutWeb'])->name('web.logout');





Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')->group(function () {

       /*  Route::post('/statistics', [StatisticController::class, 'statistics'])->name('statistics'); */
        
        Route::get('/', [MainController::class, 'index'])->name('admin');
        Route::get('main', [MainController::class, 'index']);
        Route::get('welcome', [MainController::class, 'index']);
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

        #Customer
        Route::get('customers/show', [CustomerController::class, 'show']);

        #Statistics
        /* Route::post('/statistics', [StatisticController::class, 'statistics'])->name('statistics'); */


        #Menu
        Route::prefix('menus')->group(function () {
            Route::get('add', [MenuController::class, 'create']);
            Route::post('add', [MenuController::class, 'store']);
            Route::get('list', [MenuController::class, 'index']);
            Route::get('edit/{menu}', [MenuController::class, 'edit']);
            Route::post('edit/{menu}', [MenuController::class, 'update']);
            Route::delete('destroy', [MenuController::class, 'destroy']);
        });

        #Product
        Route::prefix('products')->group(function () {
            Route::get('add', [ProductController::class, 'create']);
            Route::post('add', [ProductController::class, 'store']);
            Route::get('list', [ProductController::class, 'index']);
            Route::get('edit/{product}', [ProductController::class, 'edit']);
            Route::post('edit/{product}', [ProductController::class, 'update']);
            Route::DELETE('destroy', [ProductController::class, 'destroy']);
        });

        #Table
        Route::prefix('tables')->group(function () {
            Route::get('add', [TableController::class, 'create']);
            Route::post('add', [TableController::class, 'store']);
            Route::get('list', [TableController::class, 'index']);
            Route::get('edit/{table}', [TableController::class, 'edit']);
            Route::post('edit/{table}', [TableController::class, 'update']);
            Route::DELETE('destroy', [TableController::class, 'destroy']);
            Route::post('/update-status/{id}', [TableController::class, 'updateStatus']);
        });

        #Slider
        Route::prefix('sliders')->group(function () {
            Route::get('add', [SliderController::class, 'create']);
            Route::post('add', [SliderController::class, 'store']);
            Route::get('list', [SliderController::class, 'index']);
            Route::get('edit/{slider}', [SliderController::class, 'edit']);
            Route::post('edit/{slider}', [SliderController::class, 'update']);
            Route::DELETE('destroy', [SliderController::class, 'destroy']);
        });

        #Item
        Route::prefix('items')->group(function () {
            Route::get('add', [ItemController::class, 'create']);
            Route::post('add', [ItemController::class, 'store']);
            Route::get('list', [ItemController::class, 'index']);
            Route::get('edit/{item}', [ItemController::class, 'edit']);
            Route::post('edit/{item}', [ItemController::class, 'update']);
            Route::DELETE('destroy', [ItemController::class, 'destroy']);
        });

        #Account
        Route::prefix('accounts')->group(function () {
            Route::get('add', [AccountController::class, 'create']);
            Route::post('add', [AccountController::class, 'store']);
            Route::get('list', [AccountController::class, 'index']);
            Route::get('edit/{account}', [AccountController::class, 'edit']);
            Route::post('edit/{account}', [AccountController::class, 'update']);
            Route::DELETE('destroy', [AccountController::class, 'destroy']);
            Route::get('/profile/create', [AccountController::class, 'information']);
            Route::post('/profile/store', [AccountController::class, 'save_infor'])->name('save-infor');
        });

        #Upload
        Route::post('upload/services', [UploadController::class, 'store']);

        #Cart
        Route::prefix('customers')->group(function () {
            Route::get('processing', [CartController::class, 'index']);
            Route::get('view/{customer}', [CartController::class, 'show']);
            Route::get('waiting', [CartController::class, 'waiting']);
            Route::get('cancel', [CartController::class, 'cancel']);
            Route::get('history', [CartController::class, 'history']);
            Route::get('/order-history', [CartController::class, 'orderHistory'])->name('order-history');
        });

        Route::prefix('carts')->group(function () {
            Route::post('update-status', [CartController::class, 'updateStatus'])->name('carts.update_status');
            Route::post('select-table', [CartController::class, 'selectTableForCustomer']);
            Route::post('pay', [CartController::class, 'savePaymentOption']);
        });

        Route::prefix('reviews')->group(function () {
            Route::post('/review', [ReviewController::class, 'store'])->name('review');
            Route::get('list',[ReviewController::class, 'index']);
            Route::DELETE('destroy', [ReviewController::class, 'destroy']);
            Route::post('update-status', [ReviewController::class, 'updateStatus'])->name('reviews.update_status');
            Route::get('waiting', [ReviewController::class, 'waiting']);
            Route::get('cancel', [ReviewController::class, 'cancel']);
        });

    });

    Route::get('/invoices/{customerId}/generate-pdf', [InvoiceController::class, 'generatePDF']);
    Route::match(['get', 'post'], '/admin/statistics', [StatisticController::class, 'statistics'])->name('statistics');

});

Route::get('/', [App\Http\Controllers\MainController::class, 'index'])->name('home');
Route::post('/services/load-product', [App\Http\Controllers\MainController::class, 'loadProduct']);
Route::get('danh-muc/{id}-{slug}.html', [App\Http\Controllers\MenuController::class, 'index']);
Route::get('san-pham/{id}-{slug}.html', [App\Http\Controllers\ProductController::class, 'index']);
/* Route::view('/lien-he', 'contact'); */
Route::get('/search', [SearchController::class, 'index'])->name('search.index');

Route::get('account', [LoginController::class, 'infor'])->name('account');
Route::get('web-item', [App\Http\Controllers\ItemController::class, 'showItem']);

Route::post('add-cart', [App\Http\Controllers\CartController::class, 'index']);
Route::get('carts', [App\Http\Controllers\CartController::class, 'show']);
Route::post('update-cart', [App\Http\Controllers\CartController::class, 'update']);
Route::get('carts/delete/{id}', [App\Http\Controllers\CartController::class, 'remove']);
Route::post('carts', [App\Http\Controllers\CartController::class, 'addCart']);
Route::get('/orders/{id}', [App\Http\Controllers\CartController::class, 'summary'])->name('order.summary');

Route::post('/vnpay_payment',[PaymentController::class, 'vnpay_payment']);