<?php
namespace App\Services;

use App\Models\WiTargetBoothSku;

class WiTargetBoothSkuService{
    public function getWiTargetBoothSku(){
        return WiTargetBoothSku::take(5)->get();
    }
}
