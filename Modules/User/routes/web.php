<?php

use Illuminate\Support\Facades\Route;
use Modules\User\app\Http\Controllers\AdminController;
use Modules\User\app\Http\Controllers\HomeController;


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
Route::middleware('auth')->group(function () {


    Route::post('addToCart', [HomeController::class, 'addToCart']);
    Route::get('viewCart', [HomeController::class, 'viewCart']);


    Route::get('viewOrders', [HomeController::class, 'viewOrders']);
    Route::get('viewOrders/{id}', [HomeController::class, 'showOrder']);
    Route::post('addDiscountCode', [HomeController::class, 'addDiscountCode']);
    Route::post('removeDiscountCode', [HomeController::class, 'removeDiscountCode']);

    Route::post('order', [HomeController::class, 'order']);

    Route::get('thank_you', [HomeController::class, 'thankYou']);
});

Route::middleware(['auth', 'admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
});

Route::get('/categories/{id}', [HomeController::class, 'viewCategory']);
Route::get('/products/{id}', [HomeController::class, 'viewProduct']);
