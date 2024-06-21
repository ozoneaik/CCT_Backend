<?php

namespace App\Http\Controllers;

use App\Http\Requests\WiTargetBoothRequest;
use App\Services\WiTargetBoothService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class WiTargetBoothController extends Controller
{
    protected WiTargetBoothService $wiTargetBoothService;

    public function __construct(WiTargetBoothService $wiTargetBoothService){
        $this->wiTargetBoothService = $wiTargetBoothService;
    }

    public function convertDateTime($value): string
    {
        return Carbon::createFromFormat('Y/m', $value)->startOfMonth();
    }

    public function ListTargetBooth($year,$month,$cust_id) : JsonResponse{
        $target_month = $this->convertDateTime($year.'/'.$month);
        $listTargetBooths = $this->wiTargetBoothService->getWiTargetBooth($target_month,$cust_id);
        return response()->json([
            'listTargetBooths' => $listTargetBooths,
            'message' => 'Success',
        ]);
    }

    public function create(WiTargetBoothRequest $request,checkMonthController $checkMonthController): JsonResponse
    {
        $target_month = Carbon::parse($this->convertDateTime($request->booth_month))->startOfMonth();
        $check = $checkMonthController->checkTargetMonth($target_month);
        if(!$check['status']){
            return response()->json([
                'message' => $check['desc']
            ], 400);
        }

        $TargetBooth = $this->wiTargetBoothService->create($request->all(),$target_month);
        return response()->json([
            'TargetBooth' => $TargetBooth,
            'message' => 'Success',
        ],200);
    }

    public function delete($id,$year,$month,checkMonthController $checkMonthController) : JsonResponse{
        $target_month = $year.'/'.$month;
        $target_month = Carbon::parse($this->convertDateTime($target_month))->startOfMonth();
        $check = $checkMonthController->checkTargetMonth($target_month);
        if(!$check['status']){
            return response()->json([
                'message' => $check['desc']
            ], 400);
        }
        $deleteWiTargetBooth = $this->wiTargetBoothService->delete($id);
        return response()->json([
            'message' => $deleteWiTargetBooth ? 'ลบสำเร็จ' : 'ลบไม่สำเร็จ',
        ],$deleteWiTargetBooth ? 200 : 400);
    }
}
