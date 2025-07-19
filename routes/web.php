<?php

use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\User\AboutController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\User\RecommendationController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
  Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
  Route::post('/register', [AuthController::class, 'register'])->name('register');
  Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
  Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/', [LandingController::class, "index"])->name('landing');
Route::get('/about', [AboutController::class, "index"])->name('about');
Route::get('/contact', [ContactController::class, "index"])->name('contact');

Route::prefix("recommendations")->name('recommendations.')->group(function () {
  Route::get("/create", [RecommendationController::class, 'create'])->name("create");
  Route::post("/store", [RecommendationController::class, 'store'])->name("store");

  // * Route dengan parameter dinamis diletakkan anak kontol
  Route::get("/{session}", [RecommendationController::class, 'index'])->name("index");
});

Route::prefix('cats')->name('cats.')->group(function () {
  Route::get('/', [ListingController::class, 'index'])->name('index');
  Route::get('/{listing}', [ListingController::class, 'show'])->name('show');
});

// * Auth
Route::middleware('auth')->group(function () {
  // * Cart
  Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/', [CartController::class, 'store'])->name('store');
    Route::delete('/', [CartController::class, 'destroy'])->name('destroy');
  });

  // * Profile
  Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [UserProfileController::class, 'showProfile'])->name('show');
    Route::put('/', [UserProfileController::class, 'updateProfile'])->name('update');
    Route::put('/password', [UserProfileController::class, 'updatePassword'])->name('password.update');

    Route::patch('addresses/{address}/set-primary', [UserAddressController::class, 'setPrimary'])->name('addresses.setPrimary');
    Route::resource('addresses', UserAddressController::class);
  });

  // * Order
  Route::prefix('orders')->name("orders.")->group(function () {
    Route::get('/create', [OrderController::class, 'create'])->name('create');
    Route::post('/prepare', [OrderController::class, 'prepareCheckout'])->name('prepare');
    Route::post('/', [OrderController::class, 'store'])->name('store');
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/{order}', [OrderController::class, 'show'])->name('show');
  });
});
