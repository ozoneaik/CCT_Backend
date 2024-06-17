<?php

namespace App\Services;

use App\Models\WiTargetBoothSku;
use Carbon\Carbon;

class WiTargetBoothSkuService
{
    public function getWiTargetBoothSku()
    {
        return WiTargetBoothSku::take(5)->get();
    }

    public function delete($id_targetbooth)
    {
        return WiTargetBoothSku::where('id_targetbooth', $id_targetbooth)->delete();
    }

    public function create($TargetBoothSku)
    {
        $newBoothSku = new WiTargetBoothSku();
        $newBoothSku->id_targetbooth = $TargetBoothSku['id_targetbooth'];
        $newBoothSku->skucode = $TargetBoothSku['skucode'];
        $newBoothSku->skuqty = $TargetBoothSku['skuqty'];
        $newBoothSku->createon = Carbon::now();
        $newBoothSku->save();
        if ($newBoothSku) {
            return true;
        } else {
            return false;
        }
    }
}
