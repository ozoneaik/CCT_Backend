<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MaTargetCustController;
use App\Http\Controllers\WiTargetBoothController;
use App\Http\Controllers\WiTargetBoothSkuController;
use App\Http\Controllers\WiTargetNewSkuController;
use App\Http\Controllers\WiTargetProController;
use App\Http\Controllers\WiTargetSaleController;
use App\Http\Controllers\WiTargetSkuController;
use App\Http\Controllers\WiTargetTrainController;
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

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', [AuthController::class, 'me']);

    //จำนวนร้านค้าทั้งหมด
    Route::group(['prefix' => 'ma_target_cust'], function () {
        Route::get('list/{target_month}/{target}',[MaTargetCustController::class,'getListTarget']);
        Route::get('booth_list/{target_month}/{target}',[MaTargetCustController::class,'getListBooth']);
        Route::get('train_list/{target_month}/{target}',[MaTargetCustController::class,'getListTrain']);
    });

    //เป้าหมายที่จะทำ
    Route::group(['prefix' => 'wi_target_sale'], function () {
        Route::get('/list-target/{year}/{month}/{cust_id}', [WiTargetSaleController::class, 'ListTarget']);
        Route::get('/list/{cust_id}', [WiTargetSaleController::class, 'List']);
        Route::post('/create', [WiTargetSaleController::class, 'create']);
        Route::put('/update', [WiTargetSaleController::class, 'update']);
    });

    //รายการสินค้าที่จะสั่งซ้ำ
    Route::group(['prefix' => 'wi_target_sku'], function () {
       Route::get('/list_target_sku/{year}/{month}/{cust_id}', [WiTargetSkuController::class, 'ListTarget']);
       Route::get('/list_target_sku_now/{year}/{month}/{cust_id}', [WiTargetSkuController::class, 'ListTargetNow']);
       Route::post('/create/{cust_id}', [WiTargetSkuController::class, 'create']);
    });

    //รายการสินค้านำเสนอใหม่
    Route::group(['prefix' => 'wi_target_new_sku'], function () {
        Route::get('list_target_new_sku/{year}/{month}/{cust_id}', [WiTargetNewSkuController::class, 'ListNewSku']);
        Route::post('/create', [WiTargetNewSkuController::class, 'create']);
    });

    //รายการโปรโมชั่นที่นำเสนอ
    Route::group(['prefix' => 'wi_target_pro'], function () {
        Route::get('/list_target_pro/{year}/{month}/{cust_id}', [WiTargetProController::class, 'ListTargetPro']);
        Route::get('get_sku_name/{pro_sku}', [WiTargetProController::class, 'getSkuName']);
        Route::post('/create', [WiTargetProController::class, 'create']);
    });

    //ระยะเวลาออกบูธ
    Route::group(['prefix' => 'wi_target_booth'], function () {
        Route::get('/list_target_booth/{year}/{month}/{cust_id}', [WiTargetBoothController::class, 'ListTargetBooth']);
        Route::post('/create', [WiTargetBoothController::class, 'create']);
        Route::delete('/delete/{id}', [WiTargetBoothController::class, 'delete']);
        Route::post('/create-boothSku', [WiTargetBoothSkuController::class, 'create']);
    });

    //ระยะเวลาอบรม
    Route::group(['prefix' => 'wi_target_train'], function () {
        Route::get('/list_target_train/{year}/{month}/{cust_id}', [WiTargetTrainController::class, 'ListTargetTrain']);
        Route::post('/create', [WiTargetTrainController::class, 'create']);
        Route::put('/update/{id}', [WiTargetTrainController::class, 'update']);
        Route::delete('delete/{id}', [WiTargetTrainController::class, 'delete']);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/login', [AuthController::class, 'login']);

