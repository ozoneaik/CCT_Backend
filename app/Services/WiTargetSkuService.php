<?php
namespace App\Services;

use App\Models\WiTargetNewSku;
use App\Models\WiTargetSku;

class WiTargetSkuService{
    public function getWiTargetSku(){
        return WiTargetSku::take(5)->get();
    }

    public function getWiTargetSkuOneAgo($target_month,$cust_id){
        $TargetSku = WiTargetSku::where('custid',$cust_id)->where('target_month',$target_month)->get();
        $TargetNewSku = WiTargetNewSku::where('custid',$cust_id)->where('new_target_month',$target_month)->get();
        $result = [];
        $result['TargetSku'] = $TargetSku;
        $result['TargetNewSku'] = $TargetNewSku;
        return $result;
    }

    public function getWiTargetSkuTwoAgo($target_month,$cust_id){
        $TargetSku = WiTargetSku::where('custid',$cust_id)->where('target_month',$target_month)->get();
        return $TargetSku;
    }

    public function getWiTargetSkuNow($target_month,$cust_id){
        $TargetSkuNow = WiTargetSku::where('custid',$cust_id)->where('target_month',$target_month)->get();
        return $TargetSkuNow;
    }
}
