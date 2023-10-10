<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AssetsApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CustomersApiController;
use App\Http\Controllers\Api\SuppliersApiController;
use App\Http\Controllers\Api\LocationsApiController;
use App\Http\Controllers\Api\StatusesApiController;
use App\Http\Controllers\Api\AssetTypesApiController;
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
Route::post('/verify_token',[AuthApiController::class,'verifyToken']);

// proteced routes
Route::group(['middleware' => ['api']], function() {
    // auth
    Route::post('/logout',[AuthApiController::class,'logout']);

    // asset routes
    Route::get('assets/recent',[AssetsApiController::class,'recentCreated']);
    Route::get('assets/list',[AssetsApiController::class,'list']);
    Route::resource('assets', AssetsApiController::class);

    // customers route
    Route::get('customers/list',[CustomersApiController::class,'list']);
    Route::resource('customers', CustomersApiController::class);

    // suppliers route
    Route::resource('suppliers', SuppliersApiController::class);

    // locations route
    Route::resource('locations', LocationsApiController::class);

    // status route
    Route::resource('statuses', StatusesApiController::class);

    // asset type route
    Route::resource('asset-types', AssetTypesApiController::class);

});




