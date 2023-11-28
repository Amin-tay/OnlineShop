<?php

use Illuminate\Support\Facades\Route;
use Modules\DiscountCode\app\Http\Controllers\DiscountCodeController;

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
    Route::resource('/discountCodes', DiscountCodeController::class);
});
//Route::group([], function () {
//    Route::resource('discountcode', DiscountCodeController::class)->names('discountcode');
//});
