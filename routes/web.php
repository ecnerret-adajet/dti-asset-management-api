<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AssetsController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\AssetTypesController;
use App\Http\Controllers\StatusesController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\Auth\LoginController;

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

// public routes
Route::get('/login',[LoginController::class,'login'])->name('login');
Route::post('/login',[LoginController::class,'auth'])->name('login-auth');


// proteced routes
Route::group(['middleware' => ['auth']], function() {

    // pages route
    Route::get('/',[PagesController::class,'home'])->name('home');
    Route::get('/inventory',[PagesController::class,'inventory'])->name('inventory');
    Route::get('/master-data',[PagesController::class,'masterData'])->name('master-data');
    Route::get('/accounts',[PagesController::class,'accounts'])->name('accounts');

    // asset routes
    Route::get('/inventory/create',[AssetsController::class,'create'])->name('inventory-create');
    Route::post('/inventory',[AssetsController::class,'store'])->name('inventory');
    Route::get('/inventory/{asset_id}',[AssetsController::class,'edit'])->name('inventory-edit');
    Route::patch('/inventory/{asset}',[AssetsController::class,'update'])->name('inventory-update');

    // users route
    Route::get('/users',[UsersController::class,'index'])->name('users');

    // locations pages
    Route::get('/master-data/locations',[LocationsController::class,'index'])->name('locations');
    Route::post('/locations',[LocationsController::class,'store'])->name('locations-store');
    Route::patch('/locations/{location}',[LocationsController::class,'update'])->name('locations-update');

    // asset type
    Route::get('/master-data/asset-types',[AssetTypesController::class,'index'])->name('asset-types');
    Route::post('/asset-types',[AssetTypesController::class,'store'])->name('asset-types-store');
    Route::patch('/asset-types/{assetType}',[AssetTypesController::class,'update'])->name('asset-types-update');

    // statuses
    Route::get('/master-data/statuses',[StatusesController::class,'index'])->name('astatuses');
    Route::post('/statuses',[StatusesController::class,'store'])->name('statuses-store');
    Route::patch('/statuses/{status}',[StatusesController::class,'update'])->name('statuses-update');

    // customer
    Route::get('/accounts/customers',[CustomersController::class,'index'])->name('customers');
    Route::get('/accounts/customers/create',[CustomersController::class,'create'])->name('customers-create');
    Route::get('/accounts/customers/{customer}',[CustomersController::class,'show'])->name('customers-show');
    Route::post('/customers',[CustomersController::class,'store'])->name('customers-store');
    Route::patch('/customers/{customer}',[CustomersController::class,'update'])->name('customers-update');

    // suppliers
    Route::get('/accounts/suppliers',[SuppliersController::class,'index'])->name('suppliers');
    Route::get('/accounts/suppliers/create',[SuppliersController::class,'create'])->name('suppliers-create');
    Route::get('/accounts/suppliers/{supplier}',[SuppliersController::class,'show'])->name('suppliers-show');
    Route::post('/suppliers',[SuppliersController::class,'store'])->name('suppliers-store');
    Route::patch('/suppliers/{supplier}',[SuppliersController::class,'update'])->name('suppliers-update');

});
