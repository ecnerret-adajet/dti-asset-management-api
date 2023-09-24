<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\AssetsController;
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

    // asset routes
    Route::get('/inventory/create',[AssetsController::class,'create'])->name('inventory-create');
    Route::post('/inventory',[AssetsController::class,'store'])->name('inventory');

    // users route
    Route::get('/accounts',[AccountsController::class,'index'])->name('accounts');

});
