<?php

use App\Http\Controllers\api\v1\UserAPIController;
use App\Http\Controllers\api\v1\CategoryAPIController;
use App\Http\Controllers\api\v1\ProductAPIController;
use App\Http\Controllers\api\v1\ProviderAPIController;
use App\Http\Controllers\api\v1\ProductImgAPIController;
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

Route::group(['prefix' => 'v1'], function() {
    Route::get('user/{user}', [UserAPIController::class, 'show']);

    Route::get('category/{category}', [CategoryAPIController::class, 'show']);

    Route::get('provider/{provider}', [ProviderAPIController::class, 'show']);

    Route::get('product/list', [ProductAPIController::class, 'index']);
    Route::get('product/{product}', [ProductAPIController::class, 'show']);
    Route::patch('product/update/{product}', [ProductAPIController::class, 'update']);
    Route::delete('product/delete/{product}', [ProductAPIController::class, 'delete']);

    Route::delete('product-img/delete/{img}', [ProductImgAPIController::class, 'delete']);
});