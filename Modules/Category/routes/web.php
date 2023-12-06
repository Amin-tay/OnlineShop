<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\app\Http\Controllers\CategoryController;

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

Route::middleware(['auth', 'admin'])->name('admin.categories.')->prefix('admin/categories')->group(function () {
    Route::post('/{category}/restore', [CategoryController::class, 'restore'])->withTrashed();

    Route::get('/archive', [CategoryController::class, 'archive'])->name('archive');
    Route::get('/{category}/edit', [CategoryController::class, 'edit']);
    Route::put('/{category}', [CategoryController::class, 'update']);

    Route::delete('/{category}', [CategoryController::class, 'destroy'])->withTrashed();
    Route::resource('/', CategoryController::class);
});
//Route::group([], function () {
//    Route::resource('category', CategoryController::class)->names('category');
//});
