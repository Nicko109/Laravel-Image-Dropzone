<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('posts')->group(function () {
    Route::prefix('images')->group(function () {
        Route::post('/', [\App\Http\Controllers\Post\Image\StoreController::class, '__invoke']);
    });
    Route::post('/', [\App\Http\Controllers\Post\StoreController::class, '__invoke']);
    Route::get('/', [\App\Http\Controllers\Post\IndexController::class, '__invoke']);
});

