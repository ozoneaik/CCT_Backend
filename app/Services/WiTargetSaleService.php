<?php
namespace App\Services;

use App\Models\WiTargetSale;
use Carbon\Carbon;

class WiTargetSaleService{
    public function getWiTargetSale(){
        return WiTargetSale::take(5)->get();
    }

    public function create($data): WiTargetSale
    {
        $wi_target_sale = new WiTargetSale();
        $wi_target_sale->custid = $data['cust_id'];
        $wi_target_sale->target_month = $data['target_month'];
        $wi_target_sale->target_sale = $data['target_sale'];
        $wi_target_sale->createon = Carbon::now();
        $wi_target_sale->save();

        return $wi_target_sale;
    }
}
