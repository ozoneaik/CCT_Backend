<?php

namespace App\Http\Controllers;


use App\Http\Requests\WiTargetSaleRequest;
use App\Services\WiTargetSaleService;
use Carbon\Carbon;

class WiTargetSaleController extends Controller
{
    protected WiTargetSaleService $wiTargetSaleService;

    public function __construct(WiTargetSaleService $wiTargetSaleService){
        $this->wiTargetSaleService = $wiTargetSaleService;
    }

    public function index($year,$month){
        dd($year,$month);
    }

    public function create(WiTargetSaleRequest $request){
        // รับข้อมูลทั้งหมดจาก request
        $data = $request->all();
        // แปลง target_month เป็นวันที่
        $targetMonth = Carbon::createFromFormat('Y/m', $data['target_month'])->startOfMonth();
        // อัพเดทข้อมูลใน array ด้วย target_month ที่แปลงแล้ว
        $data['target_month'] = $targetMonth;

        $wi_target_sale = $this->wiTargetSaleService->create($data);

        dd($wi_target_sale);
    }
}
