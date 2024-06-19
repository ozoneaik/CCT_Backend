<?php

namespace App\Http\Controllers;

use App\Services\WiTargetSkuService;
use Carbon\Carbon;

class WiTargetSkuController extends Controller
{
    protected WiTargetSkuService $wiTargetSkuService;

    public function __construct(WiTargetSkuService $wiTargetSkuService){
        $this->wiTargetSkuService = $wiTargetSkuService;
    }

    public function convertDateTime($value): string
    {
        return Carbon::createFromFormat('Y/m', $value)->startOfMonth();
    }

    public function ListTarget($year,$month,$cust_id){
        $target_month = $year . '/' . $month;
        $target_month = $this->convertDateTime($target_month);
        // แปลง target_month เป็น Carbon instance
        $carbon_target_month = Carbon::parse($target_month);
        // เก็บค่าเดือนที่หนึ่งและสองก่อนหน้า
        $target_month_one_ago = $carbon_target_month->copy()->subMonth(1);
        $target_month_two_ago = $carbon_target_month->copy()->subMonth(2);
        // แปลงค่ากลับไปเป็นรูปแบบที่ต้องการ (ถ้าจำเป็น)
        $target_month_one_ago = $target_month_one_ago->format('Y-m-d 00:00:00');
        $target_month_two_ago = $target_month_two_ago->format('Y-m-d 00:00:00');

        $TargetSkusOneAgo = $this->wiTargetSkuService->getWiTargetSkuOneAgo($target_month_one_ago,$cust_id);
        $TargetSkusTwoAgo = $this->wiTargetSkuService->getWiTargetSkuTwoAgo($target_month_two_ago,$cust_id);

        $results = [];
        $i = 0;
        foreach ($TargetSkusOneAgo['TargetNewSku'] as $index=>$TargetSku) {
            $results[$i]['cust_id'] = $TargetSku['custid'];
            $results[$i]['target_month'] = $TargetSku['new_target_month'];
            $results[$i]['target_sale'] = $TargetSku['new_target_sale'];
            $results[$i]['sku'] = $TargetSku['new_sku'];
            $i++;
        }
        foreach ($TargetSkusOneAgo['TargetSku'] as $index=>$TargetSku) {
            $results[$i]['cust_id'] = $TargetSku['custid'];
            $results[$i]['target_month'] = $TargetSku['target_month'];
            $results[$i]['target_sale'] = $TargetSku['target_sku_sale'];
            $results[$i]['sku'] = $TargetSku['target_sku_id'];
            $i++;
        }
        $resultsTwo = [];
        foreach ($TargetSkusTwoAgo as $index=>$TargetSku) {
            $resultsTwo[$index]['cust_id'] = $TargetSku['custid'];
            $resultsTwo[$index]['target_month'] = $TargetSku['target_month'];
            $resultsTwo[$index]['target_sale'] = $TargetSku['target_sku_sale'];
            $resultsTwo[$index]['sku'] = $TargetSku['target_sku_id'];
        }

        return response()->json([
            'TargetSkusOneAgo' => $results,
            'TargetSkusTwoAgo' => $resultsTwo,
        ]);
    }

    public function ListTargetNow($year,$month,$cust_id){
        $target_month = $year . '/' . $month;
        $target_month = $this->convertDateTime($target_month);
        $TargetSkuNow = $this->wiTargetSkuService->getWiTargetSkuNow($target_month,$cust_id);
        $results = [];
        foreach ($TargetSkuNow as $index=>$TargetSku) {
            $results[$index]['cust_id'] = $TargetSku['custid'];
            $results[$index]['target_month'] = $TargetSku['target_month'];
            $results[$index]['target_sale'] = $TargetSku['target_sku_sale'];
            $results[$index]['sku'] = $TargetSku['target_sku_id'];
        }

        $TargetSkuNow = $results;

        return response()->json([
            'TargetSkuNow' => $TargetSkuNow,
            'message' => 'Success'
        ],200);
    }

}
