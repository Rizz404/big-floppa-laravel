<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\User\RecommendationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, "index"]);

Route::prefix("recommendations")->name('recommendations.')->group(function () {
  Route::get("/", [RecommendationController::class, 'index'])->name("index");
  Route::get("/create", [RecommendationController::class, 'create'])->name("create");
  Route::post("/store", [RecommendationController::class, 'store'])->name("store");
});
