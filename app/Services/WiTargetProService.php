<?php
namespace App\Services;

use App\Models\WiTargetPro;

class WiTargetProService{
    public function getWiTargetPro(){
        return WiTargetPro::take(5)->get();
    }
}
