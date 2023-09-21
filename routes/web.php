<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\AccountsController;

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

// pages route
Route::get('/',[PagesController::class,'home'])->name('home');
Route::get('/inventory',[PagesController::class,'inventory'])->name('inventory');
Route::get('/master-data',[PagesController::class,'masterData'])->name('master-data');

// users route
Route::get('/accounts',[AccountsController::class,'index'])->name('accounts');
