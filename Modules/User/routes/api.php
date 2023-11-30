<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\User\app\Http\Controllers\HomeApiController;

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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/testAuth', [AuthController::class, 'testAuth']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/add-to-cart', [HomeApiController::class, 'addToCart']);
    Route::post('/remove-from-cart', [HomeApiController::class, 'removeFromCart']);
    Route::get('/view-cart', [HomeApiController::class, 'viewCart']);

    Route::post('/add-discount-code', [HomeApiController::class, 'addDiscountCode']);
    Route::post('/remove-discount-code', [HomeApiController::class, 'removeDiscountCode']);

    Route::post('/order', [HomeApiController::class, 'order']);
    Route::get('/view-orders', [HomeApiController::class, 'allUserOrders']);
    Route::get('/view-orders/{id}', [HomeApiController::class, 'showUserOrder']);

});

Route::get('/categories', [HomeApiController::class, 'viewAllCategories']);
Route::get('/products', [HomeApiController::class, 'viewAllProducts']);

Route::get('/categories/{id}', [HomeApiController::class, 'viewCategory']);
Route::get('/products/{id}', [HomeApiController::class, 'viewProduct']);


Route::group(['middleware' => ['auth:sanctum', 'ApiAdmin']], function () {
    Route::get('/testAuthAdmin', [AuthController::class, 'testAuthAdmin']);
});
