<?php

namespace App\Services;

use App\Models\WiTargetBoothSku;
use Carbon\Carbon;

class WiTargetBoothSkuService
{

    public function delete($id_targetbooth)
    {
        try {
            return WiTargetBoothSku::where('id_targetbooth', $id_targetbooth)->delete();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function create($TargetBoothSku): bool
    {
        try {
            if (empty($TargetBoothSku['id_targetbooth']) || empty($TargetBoothSku['skucode']) || !isset($TargetBoothSku['skuqty'])) {
                return false;
            }
            $newBoothSku = new WiTargetBoothSku();
            $newBoothSku->id_targetbooth = $TargetBoothSku['id_targetbooth'];
            $newBoothSku->skucode = $TargetBoothSku['skucode'];
            $newBoothSku->skuqty = $TargetBoothSku['skuqty'];
            $newBoothSku->createon = Carbon::now();
            return $newBoothSku->save();
        } catch (\Exception $e) {
            return false;
        }
    }
}
