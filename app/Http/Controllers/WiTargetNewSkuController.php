<?php

namespace App\Http\Controllers;


use App\Http\Requests\WiTargetNewSkuRequest;
use App\Models\WiTargetSku;
use App\Services\WiTargetNewSkuService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class WiTargetNewSkuController extends Controller
{
    protected WiTargetNewSkuService $wiTargetNewSkuService;

    public function __construct(WiTargetNewSkuService $wiTargetNewSkuService)
    {
        $this->wiTargetNewSkuService = $wiTargetNewSkuService;
    }

    public function convertDateTime($value): string
    {
        return Carbon::createFromFormat('Y/m', $value)->startOfMonth();
    }

    public function ListNewSku($year, $month, $cust_id): JsonResponse
    {
        try {
            $target_month = $year . '/' . $month;
            $target_month = $this->convertDateTime($target_month);
            $TargetNewSkus = $this->wiTargetNewSkuService->getWiTargetNewSku($target_month, $cust_id);
            return response()->json([
                'message' => count($TargetNewSkus) > 0 ? "Success" : "Failed",
                'ListNewSkus' => count($TargetNewSkus) > 0 ? $TargetNewSkus : [],
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 400);
        }
    }


    public function create(WiTargetNewSkuRequest $request): JsonResponse
    {
        try {
            $TargetNewSkus = $request->skus;
            $sku_already = '';
            $existingSkus = $this->wiTargetNewSkuService->CheckSku($TargetNewSkus);
            $duplicateFound = false;
            foreach ($TargetNewSkus as $TargetNewSku) {
                foreach ($existingSkus as $existingSku) {
                    if ($existingSku->custid == $TargetNewSku['cust_id'] && $existingSku->target_sku_id == $TargetNewSku['new_sku']) {
                        $duplicateFound = true;
                        $sku_already = 'รหัสสินค้าที่ซ้ำ '.$existingSku->target_sku_id;
                        break 2;
                    }
                }
            }
            if ($duplicateFound) {
                return response()->json([
                    'subMessage' => "ตรวจพบรหัสสินค้า ".$sku_already." ซ้ำในรายการสินค้าที่จะสั่งซ้ำ",
                    'message' => 'เกิดข้อผิดพลาด'
                ], 400);
            } else {
                $delete = $this->wiTargetNewSkuService->delete($TargetNewSkus[0]['new_target_month']);
                if ($delete) {
                    foreach ($TargetNewSkus as $TargetNewSku) {
                        $this->wiTargetNewSkuService->create($TargetNewSku);
                    }
                }
                return response()->json([
                    'message' => "บันทึกสำเร็จ"
                ], 200);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 400);
        }
    }


    public function delete($id)
    {

    }
}
