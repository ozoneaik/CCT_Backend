<?php

namespace App\Http\Controllers;

use App\Http\Requests\WiTargetSaleRequest;
use App\Services\WiTargetSaleService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class WiTargetSaleController extends Controller
{
    protected WiTargetSaleService $wiTargetSaleService;

    public function __construct(WiTargetSaleService $wiTargetSaleService)
    {
        $this->wiTargetSaleService = $wiTargetSaleService;
    }

    public function convertDateTime($value): string
    {
        return Carbon::createFromFormat('Y/m', $value)->startOfMonth();
    }

    public function ListTarget($year, $month, $cust_id): JsonResponse
    {
        $target_month = $this->convertDateTime($year . '/' . $month);
        $listTarget = $this->wiTargetSaleService->listTarget($target_month, $cust_id);
        return response()->json([
            'listTarget' => $listTarget ? [$listTarget] : [],
            'message' => $listTarget ? 'ดึงข้อมูลสำเร็จ' : 'ไม่สามารถดึงข้อมูลได้'
        ]);
    }

    public function List($cust_id): JsonResponse
    {
        $list = $this->wiTargetSaleService->list($cust_id);
        return response()->json([
            'list' => $list ? $list : [],
            'message' => $list ? 'ดึงข้อมูลสำเร็จ' : 'ไม่สามารถดึงข้อมูลได้'
        ]);
    }


    public function create(WiTargetSaleRequest $request,checkMonthController $check): JsonResponse
    {
        $target_month = Carbon::parse($this->convertDateTime($request['target_month']))->startOfMonth();
        $check = $check->checkTargetMonth($target_month);
        if(!$check['status']){
            return response()->json([
                'message' => $check['desc']
            ], 400);
        }


        $data = $request->all();
        $targetMonth = $this->convertDateTime($data['target_month']);
        $data['target_month'] = $targetMonth;
        try {
            $targetCheck = $this->wiTargetSaleService->check($data['target_month'], $data['cust_id']);
            if (!$targetCheck) {
                $wi_target_sale = $this->wiTargetSaleService->create($data);
                if ($wi_target_sale) {
                    return response()->json([
                        'wi_target_sale' => $wi_target_sale,
                        'message' => 'สร้างเป้าหมาย ' . $request->target_month . ' ของลูกค้ารหัส ' . $request->cust_id . ' แล้ว'
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'บันทึกข้อมูลไม่สำเร็จ'
                    ], 400);
                }
            } else {
                return response()->json([
                    'wi_target_sale' => $targetCheck,
                    'message' => 'เคยบันทึกเป้าหมาย ' . $request->target_month . ' ของลูกค้ารหัส ' . $request->cust_id . ' แล้ว',
                ], 422);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'เกิดข้อผิดพลาดในระบบ'
            ], 500);
        }
    }

    public function update(WiTargetSaleRequest $request): JsonResponse
    {
        $data = $request->all();
        try {
            $wi_target_sale = $this->wiTargetSaleService->update($data);
            if ($wi_target_sale) {
                return response()->json([
                    'wi_target_sale' => $wi_target_sale,
                    'message' => 'อัพเดทเป้าหมาย ' . $request->target_month . ' ของลูกค้ารหัส ' . $request->cust_id . ' แล้ว'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'บันทึกข้อมูลไม่สำเร็จ'
                ], 400);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'เกิดข้อผิดพลาดในระบบ'
            ], 500);
        }

    }
}
