<?php

namespace App\Http\Controllers;

use App\Services\WiTargetProService;
use Carbon\Carbon;
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

    public function ListTargetPro($year,$month,$cust_id){
        $target_month = $this->convertDateTime($year . '/' . $month);
        $listTargetPro = $this->wiTargetProService->getWiTargetPro($target_month,$cust_id);
        return response()->json([
            'listTargetPro' => $listTargetPro ? $listTargetPro->toArray() : [],
            'message' => 'success',
        ],$listTargetPro ? 200 : 400);
    }
}
