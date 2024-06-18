<?php
namespace App\Services;

use App\Models\WiTargetNewSku;
use Carbon\Carbon;

class WiTargetNewSkuService{
    public function getWiTargetNewSku($target_month, $cust_id) {
        try {
            $TargetNewSkus = WiTargetNewSku::where('custid', $cust_id)
                ->where('new_target_month', $target_month)
                ->with('SkuName')
                ->get();
            $result = [];
            if ($TargetNewSkus) {
                $result = $TargetNewSkus->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'cust_id' => $item->custid,
                        'new_sku' => $item->new_sku,
                        'new_target_sale' => $item->new_target_sale,
                        'sku_name' => $item->skuName ? $item->skuName->pname : null,
                        'new_target_month' => $item->new_target_month,
                        'createon' => $item->createon
                    ];
                });
            }
            $TargetNewSkus = $result;
            return $TargetNewSkus ? $TargetNewSkus->toArray() : [];
        } catch (\Exception $exception) {
            return [];
        }
    }

    public function create($TargetNewSku) : bool{
        try {
            $new_TargetNewSku = new WiTargetNewSku();
            $new_TargetNewSku->custid = $TargetNewSku['cust_id'];
            $new_TargetNewSku->new_sku = $TargetNewSku['new_sku'];
            $new_TargetNewSku->new_target_sale = $TargetNewSku['new_target_sale'];
            $new_TargetNewSku->new_target_month = $TargetNewSku['new_target_month'];
            $new_TargetNewSku->createon = Carbon::now();
            $new_TargetNewSku->save();
            return true;
        }catch (\Exception $exception){
            return false;
        }
    }

    public function update($id,$TargetNewSku) : bool{
        try {
            $update_TargetSku = WiTargetNewSku::find($id)->first();
            $update_TargetSku->custid = $TargetNewSku['cust_id'];
            $update_TargetSku->new_sku = $TargetNewSku['new_sku'];
            $update_TargetSku->new_target_sale = $TargetNewSku['new_target_sale'];
            $update_TargetSku->save();
            return true;
        }catch (\Exception $exception){
            return false;
        }
    }

    public function delete($id) : bool {
        try {
            $update_TargetSku = WiTargetNewSku::where('new_target_month',$id)->delete();
            return true;
        }catch (\Exception $exception){
            return false;
        }

    }
}
