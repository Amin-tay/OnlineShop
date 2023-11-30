<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Order\app\Http\Controllers\OrderApiController;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/
Route::prefix('admin')->middleware(['auth:sanctum', 'ApiAdmin'])->group(function () {
    Route::get('/orders', [OrderApiController::class, 'allOrders']);
    Route::get('/orders/{id}', [OrderApiController::class, 'showOrder']);
    Route::post('/change-order-status/{id}', [OrderApiController::class, 'changeOrderStatus']);
});

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/order', [OrderApiController::class, 'order']);
    Route::get('/view-orders', [OrderApiController::class, 'allUserOrders']);
    Route::get('/view-orders/{id}', [OrderApiController::class, 'showUserOrder']);

});
