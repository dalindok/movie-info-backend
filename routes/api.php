<?php

use App\Http\Controllers\Api\ActorController;
use App\Http\Controllers\Api\Auth\AdminAuthController;
use App\Http\Controllers\Api\Auth\UserAuthController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WatchlistController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('admin/sign-in', [AdminAuthController::class, 'login']);
Route::post('user/sign-up', [UserAuthController::class, 'signup']);
Route::post('user/verify', [UserAuthController::class, 'verify']);
Route::post('user/sign-in', [UserAuthController::class, 'login']);
Route::post('/create-admin', [UserController::class, 'store']);

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {
    // Admin
    Route::prefix('admin')->group(function () {
        Route::get('profile', [AdminAuthController::class, 'profile']);
        Route::apiResource('movies', MovieController::class);
        Route::apiResource('genres', GenreController::class);
        Route::apiResource('actors', ActorController::class);
        Route::apiResource('users', UserController::class);
    });

    // User
    Route::prefix('user')->group(function () {
        Route::get('profile', [UserAuthController::class, 'profile']);
        Route::post('ratings', [RatingController::class, 'store']);
        Route::get('ratings/movies', [RatingController::class, 'userRatedMovies']);
        Route::get('watchlist', [WatchlistController::class, 'index']);
        Route::post('watchlist', [WatchlistController::class, 'store']);
        Route::delete('watchlist/{movie_id}', [WatchlistController::class, 'destroy']);
    });
});

// User
Route::prefix('user')->group(function () {
    Route::get('movies', [MovieController::class, 'index']);
    Route::get('movies/{movie}', [MovieController::class, 'show']);

    Route::get('genres', [GenreController::class, 'index']);
    Route::get('genres/{genre}', [GenreController::class, 'show']);

    Route::get('actors', [ActorController::class, 'index']);
    Route::get('actors/{actor}', [ActorController::class, 'show']);
});
