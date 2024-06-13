<?php
namespace App\Services;

use App\Models\WiTargetSale;

class WiTargetSaleService{
    public function getWiTargetSale(){
        return WiTargetSale::take(5)->get();
    }
}
