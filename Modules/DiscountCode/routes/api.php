<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\DiscountCode\app\Http\Controllers\DiscountCodeApiController;

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
    Route::post('/discount-codes/update/{id}', [DiscountCodeApiController::class, 'update']);
    Route::resource('/discount-codes', DiscountCodeApiController::class);
});
