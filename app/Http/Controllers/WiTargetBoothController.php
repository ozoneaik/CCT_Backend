<?php

namespace App\Http\Controllers;

use App\Http\Requests\WiTargetBoothRequest;
use App\Services\WiTargetBoothService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function create(WiTargetBoothRequest $request): JsonResponse
    {
        $target_month = $this->convertDateTime($request->booth_month);
        $TargetBooth = $this->wiTargetBoothService->create($request->all(),$target_month);
        return response()->json([
            'TargetBooth' => $TargetBooth,
            'message' => 'Success',
        ],200);
    }

    public function update(){

    }

    public function delete($id) : JsonResponse{
        $deleteWiTargetBooth = $this->wiTargetBoothService->delete($id);
        return response()->json([
            'message' => $deleteWiTargetBooth ? 'ลบสำเร็จ' : 'ลบไม่สำเร็จ',
        ],$deleteWiTargetBooth ? 200 : 400);
    }
}
