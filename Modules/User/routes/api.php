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
    Route::post('/remove-from-cart',[HomeApiController::class,'removeFromCart']);
    Route::get('/view-cart', [HomeApiController::class, 'viewCart']);

});
Route::group(['middleware' => ['auth:sanctum', 'ApiAdmin']], function () {
    Route::get('/testAuthAdmin', [AuthController::class, 'testAuthAdmin']);
});

//Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
//    Route::get('user', fn(Request $request) => $request->user())->name('user');
//});
