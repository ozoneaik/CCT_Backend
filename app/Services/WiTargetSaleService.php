<?php
namespace App\Services;

use App\Models\WiTargetSale;
use Carbon\Carbon;

class WiTargetSaleService{
    public function listTarget($target_month,$cust_id){
        $listTarget = WiTargetSale::where('target_month',$target_month)->where('custid',$cust_id)->first();
        return $listTarget ? $listTarget : false;
    }

    public function list($cust_id){
        $list = WiTargetSale::where('custid',$cust_id)->get();
        return $list ? $list : false;
    }

    public function create($data): ?WiTargetSale
    {
        $wi_target_sale = new WiTargetSale();
        $wi_target_sale->custid = $data['cust_id'];
        $wi_target_sale->target_month = $data['target_month'];
        $wi_target_sale->target_sale = $data['target_sale'];
        $wi_target_sale->createon = Carbon::now();
        return $wi_target_sale->save() ? $wi_target_sale : null;
    }

    public function check($target_month, $cust_id)
    {
        $check = WiTargetSale::where('target_month', $target_month)->where('custid', $cust_id)->first();
        if ($check){
            return $check;
        }
        return false;
    }

    public function update($data){
        $wi_target_sale = WiTargetSale::where('target_month', $data['target_month'])->where('custid', $data['cust_id'])->first();
        $wi_target_sale->custid = $data['cust_id'];
        $wi_target_sale->target_month = $data['target_month'];
        $wi_target_sale->target_sale = $data['target_sale'];
        return $wi_target_sale->save() ? $wi_target_sale : null;
    }
}
