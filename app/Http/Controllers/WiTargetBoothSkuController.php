<?php

namespace App\Http\Controllers;

use App\Http\Requests\WiTargetBoothSkuRequest;
use App\Services\WiTargetBoothSkuService;

class WiTargetBoothSkuController extends Controller
{
    protected WiTargetBoothSkuService $wiTargetBoothSkuService;

    public function __construct(WiTargetBoothSkuService $wiTargetBoothSkuService)
    {
        $this->wiTargetBoothSkuService = $wiTargetBoothSkuService;
    }

    public function index()
    {
        //
    }

    public function create(WiTargetBoothSkuRequest $request)
    {
        try {
            $IdTargetBoothSku = $request['boothSku'][0]['id_targetbooth'];
            $TargetBoothSkus = $request->boothSku;
            $TargetBoothSkuDelete = $this->wiTargetBoothSkuService->delete($IdTargetBoothSku);
            foreach ($TargetBoothSkus as $index=>$targetBoothSku) {
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
