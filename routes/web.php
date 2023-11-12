<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiscountCodeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $categories = \App\Models\Category::all();
    //    $categories = \App\Models\Category::take(3)->get();
    return view('welcome', compact('categories'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('addToCart', [HomeController::class, 'addToCart']);

    Route::get('viewCart', [HomeController::class, 'viewCart']);
    Route::get('viewOrders', [HomeController::class, 'viewOrders']);
    Route::get('viewOrders/{id}', [HomeController::class, 'showOrder']);
    Route::post('addDiscountCode', [HomeController::class, 'addDiscountCode']);
    Route::post('removeDiscountCode', [HomeController::class, 'removeDiscountCode']);

    Route::post('order', [HomeController::class, 'order']);

    Route::get('thank_you', [HomeController::class, 'thankYou']);
});
Route::middleware(['auth', 'admin'])->name('admin.')->prefix('admin')->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('index');

    Route::resource('/categories', CategoryController::class);
    Route::resource('/products', ProductController::class);
    Route::resource('/orders', OrderController::class);
    Route::resource('/discountCodes', DiscountCodeController::class);

    Route::post('/change-order-status', [OrderController::class, 'changeOrderStatus']);
    Route::get('/showOrder/{id}', [OrderController::class, 'show']);
    
});
Route::get('/categories/{id}', [HomeController::class, 'viewCategory']);
Route::get('/products/{id}', [HomeController::class, 'viewProduct']);
require __DIR__ . '/auth.php';
