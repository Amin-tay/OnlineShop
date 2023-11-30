<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Category\app\Http\Controllers\CategoryApiController;


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
    Route::post('/categories/update/{id}', [CategoryApiController::class,'update']);
    Route::resource('/categories', CategoryApiController::class);

});
