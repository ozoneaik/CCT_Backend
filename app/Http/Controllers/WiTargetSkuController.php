<?php

namespace App\Http\Controllers;

use App\Services\WiTargetSkuService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WiTargetSkuController extends Controller
{
    protected WiTargetSkuService $wiTargetSkuService;

    public function __construct(WiTargetSkuService $wiTargetSkuService)
    {
        $this->wiTargetSkuService = $wiTargetSkuService;
    }

    public function convertDateTime($value): string
    {
        return Carbon::createFromFormat('Y/m', $value)->startOfMonth();
    }

    public function ListTarget($year, $month, $cust_id): JsonResponse
    {
        try {
            $target_month = $year . '/' . $month;
            $target_month = $this->convertDateTime($target_month);
            $carbon_target_month = Carbon::parse($target_month);
            $target_month_one_ago = $carbon_target_month->copy()->subMonth(1);
            $target_month_two_ago = $carbon_target_month->copy()->subMonth(2);
            $target_month_one_ago = $target_month_one_ago->format('Y-m-d 00:00:00');
            $target_month_two_ago = $target_month_two_ago->format('Y-m-d 00:00:00');
            $TargetSkusOneAgo = $this->wiTargetSkuService->getWiTargetSkuOneAgo($target_month_one_ago, $cust_id);
            $TargetSkusTwoAgo = $this->wiTargetSkuService->getWiTargetSkuTwoAgo($target_month_two_ago, $cust_id);
            $TargetSkusAll = $this->wiTargetSkuService->getWiTargetSkuAll($cust_id, $target_month);
            return response()->json([
                'TargetSkusAll' => $TargetSkusAll,
                'TargetSkusOneAgo' => $TargetSkusOneAgo,
                'TargetSkusTwoAgo' => $TargetSkusTwoAgo,
                'message' => 'success'
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'TargetSkusAll' => [],
                'TargetSkusOneAgo' => [],
                'TargetSkusTwoAgo' => [],
            ], 400);
        }
    }


    public function ListTargetNow($year, $month, $cust_id): JsonResponse
    {
        try {
            $target_month = $year . '/' . $month;
            $target_month = $this->convertDateTime($target_month);
            $TargetSkuNow = $this->wiTargetSkuService->getWiTargetSkuNow($target_month, $cust_id);
            $results = [];
            foreach ($TargetSkuNow as $index => $TargetSku) {
                $results[$index]['cust_id'] = $TargetSku['custid'];
                $results[$index]['target_month'] = $TargetSku['target_month'];
                $results[$index]['target_sale'] = $TargetSku['target_sku_sale'];
                $results[$index]['sku'] = $TargetSku['target_sku_id'];
            }
            $TargetSkuNow = $results;
            return response()->json([
                'TargetSkuNow' => $TargetSkuNow,
                'message' => 'Success'
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'TargetSkuNow' => [],
                'message' => $exception->getMessage(),
            ], 400);
        }
    }

    public function create($cust_id, Request $request,checkMonthController $checkMonthController): JsonResponse
    {
        try {
            $target_month = Carbon::parse($this->convertDateTime($request['target_month']))->startOfMonth();
            $check = $checkMonthController->checkTargetMonth($target_month);
            if(!$check['status']){
                return response()->json([
                    'message' => $check['desc']
                ], 400);
            }

            $target_month = $request['target_month'];
            $CurrentSKu = $request['currentSku'];
            $target_month = $this->convertDateTime($target_month);
            $delete_sku = $this->wiTargetSkuService->delete($cust_id, $target_month);
            foreach ($CurrentSKu as $target_sale) {
                $createTargetSku = $this->wiTargetSkuService->create($cust_id, $target_month, [
                    'sku_id' => $target_sale['sku'],
                    'target_sale' => $target_sale['target_sale'],
                ]);
            }

            return response()->json([
                'message' => 'สร้างรายการสินค้าสั่งซ้ำสำเร็จ'
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
