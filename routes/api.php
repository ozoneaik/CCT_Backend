<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MaCustomerController;
use App\Http\Controllers\MaProductController;
use App\Http\Controllers\WiTargetSaleController;
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

    //เป้าหมายที่จะทำ
    Route::group(['prefix' => 'wi_target_sale'], function() {
        Route::get('/list/{year}/{month}/{cust_id}',[WiTargetSaleController::class,'index']);
        Route::post('/create',[WiTargetSaleController::class,'create']);
    });




    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/ma_customer',[MaCustomerController::class,'index']);
Route::get('/ma_products' , [MaProductController::class,'index']);

Route::post('/login',[AuthController::class,'login']);
Route::get('/test-api',function (){
    dd('heleo');
});
