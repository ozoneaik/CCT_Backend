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
        $r1 = [];
        $i = 0;
        foreach ($TargetSku as $t) {
            $r1[$i]['sku_id'] = $t['target_sku_id'];
            $r1[$i]['sku_sale'] = $t['target_sku_sale'];
            $r1[$i]['target_month'] = $target_month;
            $i++;
        }
        foreach ($TargetNewSku as $t) {
            $r1[$i]['sku_id'] = $t['new_sku'];
            $r1[$i]['sku_sale'] = $t['new_target_sale'];
            $r1[$i]['target_month'] = $target_month;
            $i++;
        }
        return $r1;
    }

    public function getWiTargetSkuTwoAgo($target_month, $cust_id)
    {
        $Target = WiTargetSku::where('custid', $cust_id)->where('target_month', $target_month)->get();
        $TargetNewSku = WiTargetNewSku::where('custid', $cust_id)->where('new_target_month', $target_month)->get();
        $r2 = [];
        $i = 0;
        foreach ($Target as $t) {
            $r2[$i]['sku_id'] = $t['target_sku_id'];
            $r2[$i]['sku_sale'] = $t['target_sku_sale'];
            $r2[$i]['target_month'] = $target_month;
            $i++;
        }
        foreach ($TargetNewSku as $t) {
            $r2[$i]['sku_id'] = $t['new_sku'];
            $r2[$i]['sku_sale'] = $t['new_target_sale'];
            $r2[$i]['target_month'] = $target_month;
            $i++;
        }
        return $r2;
    }

    public function getWiTargetSkuNow($target_month, $cust_id)
    {
        return WiTargetSku::where('custid', $cust_id)->where('target_month', $target_month)->get();
    }

    public function getWiTargetSkuAll($cust_id, $target_month): array
    {
        $TargetSkuAll = WiTargetSku::where('custid', $cust_id)->with('SkuName')->get();
        $TargetNewSkuAll = WiTargetNewSku::where('custid', $cust_id)
            ->where('new_target_month','!=',$target_month)->with('SkuName')->get();
        $TargetSkuSuperAll = [];

        foreach ($TargetSkuAll as $index=>$TargetSku) {
            $sku_id = $TargetSku['target_sku_id'];
            if (!isset($TargetSkuSuperAll[$sku_id])) {
                $TargetSkuSuperAll[$sku_id] = [
                    'cust_id' => $TargetSku['custid'],
                    'sku_id' => $sku_id,
                    'sku_name' => $TargetSku['SkuName']['pname'],
                ];
            }
        }
        foreach ($TargetNewSkuAll as $index=>$TargetNewSku) {
            $sku_id = $TargetNewSku['new_sku'];
            if (!isset($TargetSkuSuperAll[$sku_id])) {
                $TargetSkuSuperAll[$sku_id] = [
                    'cust_id' => $TargetNewSku['custid'],
                    'sku_id' => $sku_id,
                    'sku_name' => $TargetNewSku['SkuName']['pname'],
                ];
            }
        }

        // Convert associative array back to indexed array
        $TargetSkuSuperAll = array_values($TargetSkuSuperAll);

        return $TargetSkuSuperAll;
    }
}
