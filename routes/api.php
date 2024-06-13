<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MaCustomerController;
use App\Http\Controllers\MaProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/ma_customer',[MaCustomerController::class,'index']);
Route::get('/ma_products' , [MaProductController::class,'index']);

Route::post('/login',[AuthController::class,'login']);
Route::get('/test-api',function (){
    dd('heleo');
});
