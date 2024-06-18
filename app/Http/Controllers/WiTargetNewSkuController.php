<?php

namespace App\Http\Controllers;



use App\Http\Requests\WiTargetNewSkuRequest;
use App\Services\WiTargetNewSkuService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class WiTargetNewSkuController extends Controller
{
    protected WiTargetNewSkuService $wiTargetNewSkuService;

    public function __construct(WiTargetNewSkuService $wiTargetNewSkuService){
        $this->wiTargetNewSkuService = $wiTargetNewSkuService;
    }

    public function convertDateTime($value): string
    {
        return Carbon::createFromFormat('Y/m', $value)->startOfMonth();
    }

    public function ListNewSku($year, $month, $cust_id): JsonResponse
    {
        try {
            $target_month = $year.'/'.$month;
            $target_month = $this->convertDateTime($target_month);
            $TargetNewSkus = $this->wiTargetNewSkuService->getWiTargetNewSku($target_month,$cust_id);
            return response()->json([
                'message' => count($TargetNewSkus) > 0 ? "Success" : "Failed",
                'ListNewSkus' => count($TargetNewSkus) > 0 ? $TargetNewSkus : [],
            ],200);
        }catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage()
            ],400);
        }
    }

    public function create(WiTargetNewSkuRequest $request): JsonResponse
    {
        try {
            $TargetNewSkus = $request->skus;
            $delete = $this->wiTargetNewSkuService->delete($TargetNewSkus[0]['new_target_month']);
            if ($delete){
                foreach ($TargetNewSkus as $TargetNewSku) {
                    $this->wiTargetNewSkuService->create($TargetNewSku);
                }
            }
            $message = "บันทึกสำเร็จ";
        }catch (\Exception $exception){
            $message = "บันทึกไม่สำเร็จ";
        }
        return response()->json([
            'message' => $message
        ]);
    }



    public function delete($id){

    }
}
