<?php

namespace App\Services;

use App\Models\MaTargetCust;
use App\Models\WiTargetBooth;
use Illuminate\Support\Facades\DB;

class MaTargetCustService
{
    public function getCustAllTotal($username)
    {
        $CustAllTotal = MatargetCust::where('fieldsaleid', $username)->get();
        return $CustAllTotal ? $CustAllTotal : [];
    }

    public function getBoothAllTotal($target_month, $sale_id): int
    {
        $result = DB::table('wi_target_booth as wb')
            ->select('wb.custid')
            ->leftJoin('ma_target_cust as ma', function($join) use ($sale_id) {
                $join->on('ma.custid', '=', 'wb.custid')
                    ->where('ma.fieldsaleid', 'like', $sale_id);
            })
            ->where('wb.booth_month', 'like', $target_month)
            ->groupBy('wb.custid')
            ->get();

        return $result->count();
    }

    public function GetList($target_month,$sale_id,$target){
        if ($target == 1){
            $target = 0.81;
        }else{
            $target = 1;
        }
        return MaTargetCust::select([
            'ma_target_cust.custid',
            'ma_customer.custname',
            DB::raw('COALESCE(wi_target_sale.target_sale, 0) AS target_sale'),
            DB::raw('COUNT(DISTINCT CASE WHEN wi_target_sku.target_month = "'.$target_month.'" THEN wi_target_sku.id END) AS sku_count'),
            DB::raw('COUNT(DISTINCT CASE WHEN wi_target_newsku.new_target_month = "'.$target_month.'" THEN wi_target_newsku.id END) AS new_sku_count'),
            DB::raw('COUNT(DISTINCT CASE WHEN wi_target_pro.pro_month = "'.$target_month.'" THEN wi_target_pro.id END) AS sku_pro_count'),
            DB::raw('COUNT(DISTINCT CASE WHEN wi_target_booth.booth_month = "'.$target_month.'" THEN wi_target_booth.id END) AS sku_booth_count'),
            DB::raw('COUNT(DISTINCT CASE WHEN wi_target_train.train_month = "'.$target_month.'" THEN wi_target_train.id END) AS sku_train_count')
        ])
            ->join('ma_customer', 'ma_target_cust.custid', '=', 'ma_customer.custid')
            ->leftJoin('wi_target_sale', function($join) use ($target_month) {
                $join->on('ma_target_cust.custid', '=', 'wi_target_sale.custid')
                    ->where('wi_target_sale.target_month', '=', $target_month);
            })
            ->leftJoin('wi_target_sku', 'ma_target_cust.custid', '=', 'wi_target_sku.custid')
            ->leftJoin('wi_target_newsku', 'ma_target_cust.custid', '=', 'wi_target_newsku.custid')
            ->leftJoin('wi_target_pro', 'ma_target_cust.custid', '=', 'wi_target_pro.custid')
            ->leftJoin('wi_target_booth', 'ma_target_cust.custid', '=', 'wi_target_booth.custid')
            ->leftJoin('wi_target_train', 'ma_target_cust.custid', '=', 'wi_target_train.custid')
            ->where('ma_target_cust.fieldsaleid', 'LIKE', $sale_id)
            ->where('ma_target_cust.percentsale', '<=', $target)
            ->groupBy('ma_target_cust.custid', 'ma_customer.custname', 'wi_target_sale.target_sale')
            ->orderBy('ma_target_cust.custid', 'asc')
            ->get();
    }

    public function GetBoothList($target_month,$sale_id){
        return MaTargetCust::select([
            'ma_target_cust.custid',
            'ma_customer.custname',
            DB::raw('COALESCE(wi_target_sale.target_sale, 0) AS target_sale'),
            DB::raw('COUNT(DISTINCT CASE WHEN wi_target_sku.target_month = "'.$target_month.'" THEN wi_target_sku.id END) AS sku_count'),
            DB::raw('COUNT(DISTINCT CASE WHEN wi_target_newsku.new_target_month = "'.$target_month.'" THEN wi_target_newsku.id END) AS new_sku_count'),
            DB::raw('COUNT(DISTINCT CASE WHEN wi_target_pro.pro_month = "'.$target_month.'" THEN wi_target_pro.id END) AS sku_pro_count'),
            DB::raw('COUNT(DISTINCT CASE WHEN wi_target_booth.booth_month = "'.$target_month.'" THEN wi_target_booth.id END) AS sku_booth_count'),
            DB::raw('COUNT(DISTINCT CASE WHEN wi_target_train.train_month = "'.$target_month.'" THEN wi_target_train.id END) AS sku_train_count')
        ])
            ->join('ma_customer', 'ma_target_cust.custid', '=', 'ma_customer.custid')
            ->leftJoin('wi_target_sale', function($join) use ($target_month) {
                $join->on('ma_target_cust.custid', '=', 'wi_target_sale.custid')
                    ->where('wi_target_sale.target_month', '=', $target_month);
            })
            ->leftJoin('wi_target_sku', 'ma_target_cust.custid', '=', 'wi_target_sku.custid')
            ->leftJoin('wi_target_newsku', 'ma_target_cust.custid', '=', 'wi_target_newsku.custid')
            ->leftJoin('wi_target_pro', 'ma_target_cust.custid', '=', 'wi_target_pro.custid')
            ->leftJoin('wi_target_booth', 'ma_target_cust.custid', '=', 'wi_target_booth.custid')
            ->leftJoin('wi_target_train', 'ma_target_cust.custid', '=', 'wi_target_train.custid')
            ->where('ma_target_cust.fieldsaleid', 'LIKE', $sale_id)
            ->where('wi_target_booth.id','>',0)
            ->where('wi_target_booth.booth_month','=',$target_month)
            ->groupBy('ma_target_cust.custid', 'ma_customer.custname', 'wi_target_sale.target_sale')
            ->orderBy('ma_target_cust.custid', 'asc')
            ->get();
    }

    public function GetTrainList($target_month,$sale_id){
        return MaTargetCust::select([
            'ma_target_cust.custid',
            'ma_customer.custname',
            DB::raw('COALESCE(wi_target_sale.target_sale, 0) AS target_sale'),
            DB::raw('COUNT(DISTINCT CASE WHEN wi_target_sku.target_month = "'.$target_month.'" THEN wi_target_sku.id END) AS sku_count'),
            DB::raw('COUNT(DISTINCT CASE WHEN wi_target_newsku.new_target_month = "'.$target_month.'" THEN wi_target_newsku.id END) AS new_sku_count'),
            DB::raw('COUNT(DISTINCT CASE WHEN wi_target_pro.pro_month = "'.$target_month.'" THEN wi_target_pro.id END) AS sku_pro_count'),
            DB::raw('COUNT(DISTINCT CASE WHEN wi_target_booth.booth_month = "'.$target_month.'" THEN wi_target_booth.id END) AS sku_booth_count'),
            DB::raw('COUNT(DISTINCT CASE WHEN wi_target_train.train_month = "'.$target_month.'" THEN wi_target_train.id END) AS sku_train_count')
        ])
            ->join('ma_customer', 'ma_target_cust.custid', '=', 'ma_customer.custid')
            ->leftJoin('wi_target_sale', function($join) use ($target_month) {
                $join->on('ma_target_cust.custid', '=', 'wi_target_sale.custid')
                    ->where('wi_target_sale.target_month', '=', $target_month);
            })
            ->leftJoin('wi_target_sku', 'ma_target_cust.custid', '=', 'wi_target_sku.custid')
            ->leftJoin('wi_target_newsku', 'ma_target_cust.custid', '=', 'wi_target_newsku.custid')
            ->leftJoin('wi_target_pro', 'ma_target_cust.custid', '=', 'wi_target_pro.custid')
            ->leftJoin('wi_target_booth', 'ma_target_cust.custid', '=', 'wi_target_booth.custid')
            ->leftJoin('wi_target_train', 'ma_target_cust.custid', '=', 'wi_target_train.custid')
            ->where('ma_target_cust.fieldsaleid', 'LIKE', $sale_id)
            ->where('wi_target_train.id','>',0)
            ->where('wi_target_train.train_month','=',$target_month)
            ->groupBy('ma_target_cust.custid', 'ma_customer.custname', 'wi_target_sale.target_sale')
            ->orderBy('ma_target_cust.custid', 'asc')
            ->get();
    }

    public function getTotalBoothAndTran($target_month,$sale_id){

    }
}
