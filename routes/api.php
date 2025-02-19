<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AccessTokenController;


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

Route::apiResource('products', ProductController::class);

Route::post('auth/access-tokens', [AccessTokenController::class, 'store'])
    ->middleware('guest:sanctum');

    Route::delete('auth/access-tokens/{token?}', [AccessTokenController::class, 'destroy'])
    ->middleware('auth:sanctum');

