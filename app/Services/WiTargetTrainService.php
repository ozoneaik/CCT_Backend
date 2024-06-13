<?php
namespace App\Services;

use App\Models\WiTargetTrain;

class WiTargetTrainService{
    public function getWiTargetTrain(){
        return WiTargetTrain::take(5)->get();
    }
}
