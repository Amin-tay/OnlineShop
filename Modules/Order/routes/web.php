<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\app\Http\Controllers\OrderController;

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
Route::middleware(['auth', 'admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::resource('/orders', OrderController::class);
    Route::post('/change-order-status', [OrderController::class, 'changeOrderStatus']);
    Route::get('/showOrder/{id}', [OrderController::class, 'show']);
});

//Route::group([], function () {
//    Route::resource('order', OrderController::class)->names('order');
//});