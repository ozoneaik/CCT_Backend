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
        $results = $this->maTargetCustService->GetList($target_month,$sale_id,$target);
        $TargetCustTotal = count($results);
        $CustAllTotal = $this->maTargetCustService->getCustAllTotal($sale_id);
        $CustAllTotal = count($CustAllTotal);

        $count_booth = 0;
        $count_train = 0;
        foreach ($results as $result) {
            if ($result['sku_booth_count'] > 0){
                $count_booth+=1;
            }
            if ($result['sku_train_count'] > 0){
                $count_train+=1;
            }
        }
        $BoothAllTotal = $count_booth;
        $TrainAllTotal = $count_train;
//        $BoothAllTotal = $this->maTargetCustService->getBoothAllTotal($target_month,$sale_id);
        return response()->json([
            'message' => 'Success',
            'TargetCust' => $results,
            'TargetCustTotal' => $TargetCustTotal,
            'CustAllTotal' => $CustAllTotal,
            'BoothAllTotal' => $BoothAllTotal,
            'TrainAllTotal' => $TrainAllTotal,
            'TargetMonth' => $target_month,
        ]);
    }

    public function getListBooth($target_month,$target): JsonResponse{
        $sale_id = Auth::user()->username;
        $results = $this->maTargetCustService->GetBoothList($target_month,$sale_id,$target);
        return response()->json([
            'message' => 'Success',
            'TargetCust' => $results,
            'TargetMonth' => $target_month,
        ]);
    }

    public function getListTrain($target_month,$target): JsonResponse{
        $sale_id = Auth::user()->username;
        $results = $this->maTargetCustService->GetTrainList($target_month,$sale_id,$target);
        return response()->json([
            'message' => 'Success',
            'TargetCust' => $results,
            'TargetMonth' => $target_month,
        ]);
    }
}
