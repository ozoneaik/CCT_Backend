<?php

namespace App\Http\Controllers;

use App\Http\Requests\WiTargetProRequest;
use App\Services\WiTargetProService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WiTargetProController extends Controller
{
    protected WiTargetProService $wiTargetProService;

    public function __construct(WiTargetProService $wiTargetProService){
        $this->wiTargetProService = $wiTargetProService;
    }

    public function convertDateTime($value): string
    {
        return Carbon::createFromFormat('Y/m', $value)->startOfMonth();
    }

    public function ListTargetPro($year,$month,$cust_id): JsonResponse
    {
        $target_month = $this->convertDateTime($year . '/' . $month);
        $listTargetPro = $this->wiTargetProService->getWiTargetPro($target_month,$cust_id);
        return response()->json([
            'listTargetPro' => $listTargetPro ? $listTargetPro->toArray() : [],
            'message' => 'success',
        ],$listTargetPro ? 200 : 400);
    }

    public function getSkuName($pro_sku): JsonResponse{
        $sku_name = $this->wiTargetProService->getSkuName($pro_sku);
        return response()->json($sku_name);
    }

    public function create(WiTargetProRequest $request): JsonResponse
    {
        $promotions = $request->all();
        if (!count($promotions) <= 0){
            $this->wiTargetProService->delete($promotions[0]['pro_month']);
        }
        try {
            foreach ($promotions as $index=>$promotion){
                $this->wiTargetProService->create($promotion);
            }
            $date = new \DateTime($promotions[0]['pro_month']);
            $validatedData = $date->format('Y/m');
            $target_month = $this->convertDateTime($validatedData);
            $promotions = $this->wiTargetProService->getWiTargetPro($target_month,$promotions[0]['cust_id']);
            return response()->json([
                'promotions' => $promotions,
                'message' => 'success',
            ],200);
        }catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage(),
                'promotions' => [],
            ],400);
        }

    }
}
