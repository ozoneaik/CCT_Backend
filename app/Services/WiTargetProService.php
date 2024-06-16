<?php
namespace App\Services;

use App\Models\WiTargetPro;

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
}
