<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\app\Http\Controllers\ProductController;

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

Route::middleware(['auth', 'admin'])->name('admin.products.')->prefix('admin/products')->group(function () {
    Route::get('/archive', [ProductController::class, 'archive'])->name('archive');

    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{product}/edit', [ProductController::class, 'edit']);
    Route::put('/{product}', [ProductController::class, 'update']);
    Route::post('/{product}/restore', [ProductController::class, 'restore'])->withTrashed();
//    Route::post('/{product}/restore', [ProductController::class, 'restore'])->withTrashed();
    Route::delete('/{product}', [ProductController::class, 'destroy'])->withTrashed();
    Route::resource('/', ProductController::class);
});

//
//Route::group([], function () {
//
//    Route::resource('product', ProductController::class)->names('product');
//});
