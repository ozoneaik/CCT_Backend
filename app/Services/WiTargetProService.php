<?php
namespace App\Services;

use App\Models\MaProduct;
use App\Models\WiTargetPro;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class WiTargetProService{
    public function getWiTargetPro($target_month,$cust_id){
        $listTargetPro = WiTargetPro::where('pro_month',$target_month)->where('custid',$cust_id)->with('SkuName')->get();
        // ตรวจสอบว่ามีผลลัพธ์หรือไม่
        if ($listTargetPro->isEmpty()) {
            return [];
        }
        // ดึงค่า pname จาก MaProduct
        $result = $listTargetPro->map(function ($item) {
            return [
                'id' => $item->id,
                'pro_month' => $item->pro_month,
                'cust_id' => $item->custid,
                'pro_sku' => $item->pro_sku,
                'pro_desc' => $item->pro_desc,
                'pro_name' => $item->skuName ? $item->skuName->pname : null,
            ];
        });

        return $result ? $result : null;
    }

    public function getSkuName($pro_sku){
        $sku_name = MaProduct::select('pname')->where('pid',$pro_sku)->first();
//        dd($sku_name['pname']);
        return $sku_name['pname'];
    }

    public function create($promotion): WiTargetPro
    {
        $promotion_create = new WiTargetPro();
        $promotion_create->pro_sku = $promotion['pro_sku'];
        $promotion_create->pro_desc = $promotion['pro_desc'];
        $promotion_create->pro_month = $promotion['pro_month'];
        $promotion_create->custid = $promotion['cust_id'];
        $promotion_create->createon = Carbon::now();
        $promotion_create->save();
        return $promotion_create;
    }

    public function update($promotion){
        $promotion_select = WiTargetPro::find($promotion['id'])->first();
        $promotion_select->pro_sku = $promotion['pro_sku'];
        $promotion_select->pro_desc = $promotion['pro_desc'];
        $promotion_select->pro_month = $promotion['pro_month'];
        $promotion_select->custid = $promotion['cust_id'];
        $promotion_select->save();
        return $promotion_select;
    }

    public function delete($target_month){
        return WiTargetPro::where('pro_month',$target_month)->delete();
    }
}
