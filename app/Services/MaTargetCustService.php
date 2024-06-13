<?php
namespace App\Services;

use App\Models\MaTargetCust;

class MaTargetCustService{
    public function getMaTargetCustList(){
        return MaTargetCust::take(5)->get();
    }
}
