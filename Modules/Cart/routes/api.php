<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Cart\app\Http\Controllers\CartApiController;

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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/add-to-cart', [CartApiController::class, 'addToCart']);
    Route::post('/remove-from-cart', [CartApiController::class, 'removeFromCart']);
    Route::get('/view-cart', [CartApiController::class, 'viewCart']);
});
