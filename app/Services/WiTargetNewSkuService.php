<?php
namespace App\Services;

use App\Models\WiTargetNewSku;

class WiTargetNewSkuService{
    public function getWiTargetNewSku(){
        return WiTargetNewSku::take(5)->get();
    }
}
