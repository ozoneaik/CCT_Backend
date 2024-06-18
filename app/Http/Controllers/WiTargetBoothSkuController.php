<?php

namespace App\Http\Controllers;

use App\Http\Requests\WiTargetBoothSkuRequest;
use App\Services\WiTargetBoothSkuService;
use Illuminate\Http\JsonResponse;

class WiTargetBoothSkuController extends Controller
{
    protected WiTargetBoothSkuService $wiTargetBoothSkuService;

    public function __construct(WiTargetBoothSkuService $wiTargetBoothSkuService)
    {
        $this->wiTargetBoothSkuService = $wiTargetBoothSkuService;
    }

    public function create(WiTargetBoothSkuRequest $request): JsonResponse
    {
        try {
            $targetBoothSkus = $request->boothSku;
            if (empty($targetBoothSkus) || !is_array($targetBoothSkus)) {
                return response()->json([
                    'message' => 'Invalid data provided',
                ], 400);
            }
            $idTargetBoothSku = $targetBoothSkus[0]['id_targetbooth'];
            $this->wiTargetBoothSkuService->delete($idTargetBoothSku);
            foreach ($targetBoothSkus as $targetBoothSku) {
                $this->wiTargetBoothSkuService->create($targetBoothSku);
            }
            return response()->json([
                'message' => 'บันทึกสำเร็จ'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'promotions' => [],
            ], 400);
        }
    }
}
