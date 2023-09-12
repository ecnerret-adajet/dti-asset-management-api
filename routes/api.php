<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AssetsApiController;
use App\Http\Controllers\Api\AuthApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// public routes
Route::post('/register',[AuthApiController::class,'register']);
Route::post('/login',[AuthApiController::class,'login']);

// proteced routes
Route::group(['middleware' => ['auth:sanctum']], function() {
    // auth
    Route::post('/logout',[AuthApiController::class,'logout']);

    // asset routes
    Route::resource('assets', AssetsApiController::class);
});




