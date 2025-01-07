<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductStockController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

HomeController::Routes();
ProductController::Routes();
ProductStockController::Routes();

Route::get('migrate',function(){

    Artisan::call('migrate');
    // Artisan::call('view:clear');
    // Artisan::call('route:clear');
    // Artisan::call('config:clear');
    // Artisan::call('cache:clear');
    // Artisan::call('key:generate');
});
