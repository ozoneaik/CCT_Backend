<?php
namespace App\Services;

use App\Models\WiTargetSku;

class WiTargetSkuService{
    public function getWiTargetSku(){
        return WiTargetSku::take(5)->get();
    }
}
