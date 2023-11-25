<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AssetsApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CustomersApiController;
use App\Http\Controllers\Api\OrdersApiController;
use App\Http\Controllers\Api\SuppliersApiController;
use App\Http\Controllers\Api\LocationsApiController;
use App\Http\Controllers\Api\StatusesApiController;
use App\Http\Controllers\Api\ReceivingsApiController;
use App\Http\Controllers\Api\ReceivingStatusApiController;
use App\Http\Controllers\Api\AssetTypesApiController;
use App\Http\Controllers\Api\ReportsApiController;
use App\Http\Controllers\Api\AuditApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\NotesApiController;
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

    // receiving status api
    Route::get('receiving-statuses',[ReceivingStatusApiController::class,'index']);

    // asset receiving api
    Route::get('receivings-statuses-stats',[ReceivingsApiController::class,'receivingStatus']);
    Route::post('receivings',[ReceivingsApiController::class,'store']);

    // retport api
    Route::get('/total-assets',[ReportsApiController::class,'totalAssets']);
    Route::get('/total-spending',[ReportsApiController::class,'totalSpending']);
    Route::get('/total-sold',[ReportsApiController::class,'totalQuantitySold']);
    Route::get('/total-requests',[ReportsApiController::class,'totalQuantityRequest']);

    // audits api
    Route::get('/audits-assets',[AuditApiController::class,'assets']);

    // user api
    Route::post('users/change-pass/{user}',[UserApiController::class,'changePassword']);

    // customer's order
    Route::get('/order-statuses',[OrdersApiController::class,'orderStatus']);
    Route::get('/customer-orders/{customer_id}',[OrdersApiController::class,'customerOders']);
    Route::get('/customer-total-cost/{customer_id}',[OrdersApiController::class,'customerTotalCost']);

    // Notes route
    Route::get('/notes/{asset_id}',[NotesApiController::class,'notes']);
    Route::post('/notes',[NotesApiController::class,'store']);
    Route::delete('/notes/{note}',[NotesApiController::class,'delete']);

});




