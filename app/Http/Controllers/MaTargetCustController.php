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

    public function list(): JsonResponse
    {
        try {
            $user = Auth::user();
            $username = !empty($user->username) ? $user->username : '';

            $TargetCust = $this->maTargetCustService->getMaTargetCustById($username);
            $TargetCustTotal = count($TargetCust);
            $CustAllTotal = $this->maTargetCustService->getCustAllTotal($username);
            $CustAllTotal = count($CustAllTotal);

            return response()->json([
                'message' => 'Success',
                'TargetCust' => $TargetCust,
                'TargetCustTotal' => $TargetCustTotal,
                'CustAllTotal' => $CustAllTotal,
            ],200);
        }catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage()
            ],400);
        }
    }

    public function getListTarget($target_month,$target){
        $cust_id = Auth::user()->username;
        $results = $this->maTargetCustService->GetList($target_month,$cust_id,$target);
        $TargetCustTotal = count($results);
        $CustAllTotal = $this->maTargetCustService->getCustAllTotal($cust_id);
        $CustAllTotal = count($CustAllTotal);
        return response()->json([
            'message' => 'Success',
            'TargetCust' => $results,
            'TargetCustTotal' => $TargetCustTotal,
            'CustAllTotal' => $CustAllTotal,
        ]);
    }
}
