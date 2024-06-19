<?php

namespace App\Services;

use App\Models\WiTargetNewSku;
use App\Models\WiTargetSku;

class WiTargetSkuService
{
    public function getWiTargetSku()
    {
        return WiTargetSku::take(5)->get();
    }

    public function getWiTargetSkuOneAgo($target_month, $cust_id): array
    {
        $TargetSku = WiTargetSku::where('custid', $cust_id)->where('target_month', $target_month)->get();
        $TargetNewSku = WiTargetNewSku::where('custid', $cust_id)->where('new_target_month', $target_month)->get();
        $result = [];
        $result['TargetSku'] = $TargetSku;
        $result['TargetNewSku'] = $TargetNewSku;
        return $result;
    }

    public function getWiTargetSkuTwoAgo($target_month, $cust_id)
    {
        return WiTargetSku::where('custid', $cust_id)->where('target_month', $target_month)->get();
    }

    public function getWiTargetSkuNow($target_month, $cust_id)
    {
        return WiTargetSku::where('custid', $cust_id)->where('target_month', $target_month)->get();
    }

    public function getWiTargetSkuAll($cust_id, $target_month_one_ago)
    {
        $TargetSkuAll = WiTargetSku::where('custid', $cust_id)->get();
        $TargetNewSkuAll = WiTargetNewSku::where('custid', $cust_id)
            ->where('new_target_month', $target_month_one_ago)->get();
        $result['TargetSkuAll'] = $TargetSkuAll;
        $result['TargetNewSkuAll'] = $TargetNewSkuAll;
        $TargetSkuSuperAll = [];
        $i = 0;
        foreach ($TargetSkuAll as $TargetSku) {
            $TargetSkuSuperAll[$i]['cust_id'] = $TargetSku['custid'];
            $TargetSkuSuperAll[$i]['sku_id'] = $TargetSku['target_sku_id'];
            $i++;
        }
        foreach ($TargetNewSkuAll as $TargetNewSku) {
            $TargetSkuSuperAll[$i]['cust_id'] = $TargetNewSku['custid'];
            $TargetSkuSuperAll[$i]['sku_id'] = $TargetNewSku['new_sku'];
            $i++;
        }

        return $TargetSkuSuperAll;
    }
}
