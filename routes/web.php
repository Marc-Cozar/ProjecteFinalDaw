<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\CustomerController;

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

// Route::get('/', [LandingController::class, 'test'])->name('test');
Route::get('/', [FrontController::class, 'index'])->name('home');
Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['is_admin'])->group(function () {
    Route::get('/profile', [CustomerController::class, 'index'])->name('profile');
    // Route::post('/products/{product}/review', [Front::class,'store'])->name('front.reviews.store');

});
