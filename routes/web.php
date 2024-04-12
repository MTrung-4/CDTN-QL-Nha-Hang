<?php

use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\Login\LoginController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\UploadController;
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

Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')->group(function () {

        Route::get('/', [MainController::class, 'index'])->name('admin');
        Route::get('main', [MainController::class, 'index']);
        Route::get('users/calendar', [MainController::class, 'index']);
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

        #Customer
        Route::get('customers/show', [CustomerController::class, 'show']);
        Route::get('statistics', [StatisticController::class, 'statistics']);
        

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

        #Upload
        Route::post('upload/services', [UploadController::class, 'store']);

        #Cart
        Route::prefix('customers')->group(function () {
            Route::get('processing', [CartController::class, 'index']);
            Route::get('view/{customer}', [CartController::class, 'show']);
            Route::get('waiting', [CartController::class, 'waiting']);
            Route::get('cancel', [CartController::class, 'cancel']);
            Route::get('history', [CartController::class, 'history']);
        });

        Route::prefix('carts')->group(function () {
            Route::post('update-status', [CartController::class, 'updateStatus'])->name('carts.update_status');
            Route::post('select-table', [CartController::class, 'selectTableForCustomer']);
            Route::post('pay', [CartController::class, 'savePaymentOption']);
        });
    });

    Route::get('/invoices/{customerId}/generate-pdf', [InvoiceController::class, 'generatePDF']);
});

Route::get('/', [App\Http\Controllers\MainController::class, 'index']);
Route::post('/services/load-product', [App\Http\Controllers\MainController::class, 'loadProduct']);
Route::get('danh-muc/{id}-{slug}.html', [App\Http\Controllers\MenuController::class, 'index']);
Route::get('san-pham/{id}-{slug}.html', [App\Http\Controllers\ProductController::class, 'index']);
/* Route::view('/lien-he', 'contact'); */
Route::get('/search', [SearchController::class, 'index'])->name('search.index');



Route::post('add-cart', [App\Http\Controllers\CartController::class, 'index']);
Route::get('carts', [App\Http\Controllers\CartController::class, 'show']);
Route::post('update-cart', [App\Http\Controllers\CartController::class, 'update']);
Route::get('carts/delete/{id}', [App\Http\Controllers\CartController::class, 'remove']);
Route::post('carts', [App\Http\Controllers\CartController::class, 'addCart']);
