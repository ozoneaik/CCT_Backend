<?php
namespace App\Services;

use App\Models\WiTargetBooth;

class WiTargetBoothService{
    public function getWiTargetBooth(){
        return WiTargetBooth::take(5)->get();
    }
}
