<?php

namespace App\Http\Controllers;

use App\Services\MaTargetCustService;
use Illuminate\Http\JsonResponse;

class MaTargetCustController extends Controller
{
    protected MaTargetCustService $maTargetCustService;

    public function __construct(MaTargetCustService $maTargetCustService){
        $this->maTargetCustService = $maTargetCustService;
    }

    public function index(): JsonResponse
    {
        $data = $this->maTargetCustService->getMaTargetCustList();
        return response()->json($data);
    }
}
