<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MaCustomerController;
use App\Http\Controllers\MaProductController;
use App\Http\Controllers\WiTargetProController;
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

    Route::get('/me', [AuthController::class, 'me']);


    //เป้าหมายที่จะทำ
    Route::group(['prefix' => 'wi_target_sale'], function() {
        Route::get('/list-target/{year}/{month}/{cust_id}', [WiTargetSaleController::class, 'ListTarget']);
        Route::get('/list/{cust_id}',[WiTargetSaleController::class,'List']);
        Route::post('/create',[WiTargetSaleController::class,'create']);
        Route::post('/update',[WiTargetSaleController::class,'update']);
    });

    //รายการโปรโมชั่นที่นำเสนอ
    Route::group(['prefix' => 'wi_target_pro'], function() {
        Route::get('/list_target_pro/{year}/{month}/{cust_id}',[WiTargetProController::class, 'ListTargetPro']);
        Route::get('get_sku_name/{pro_sku}',[WiTargetProController::class, 'getSkuName']);
        Route::post('/create',[WiTargetProController::class,'create']);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/login',[AuthController::class,'login']);
