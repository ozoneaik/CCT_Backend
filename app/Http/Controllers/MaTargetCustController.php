<?php

namespace App\Http\Controllers;

use App\Models\MaTargetCust;
use App\Services\MaTargetCustService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MaTargetCustController extends Controller
{
    protected MaTargetCustService $maTargetCustService;

    public function __construct(MaTargetCustService $maTargetCustService){
        $this->maTargetCustService = $maTargetCustService;
    }

    public function getListTarget($target_month,$target): JsonResponse
    {
        $sale_id = Auth::user()->username;
        $results = $this->maTargetCustService->GetList($target_month,$sale_id);
        return response()->json([
            'message' => 'Success',
            'TargetCust' => $results,
            'TargetMonth' => $target_month,
        ]);
    }
}
