<?php

namespace App\Services;

use App\Models\WiTargetBooth;
use App\Models\WiTargetBoothSku;
use Carbon\Carbon;

class WiTargetBoothService
{
    public function getWiTargetBooth($target_month, $cust_id)
    {
        $listTargetBooths = WiTargetBooth::where('custid', $cust_id)
            ->where('booth_month', $target_month)
            ->with(['GetBoothSku.GetNameSku'])->get();

        $total_skuqty = 0;
        foreach ($listTargetBooths as $targetBooth) {
            foreach ($targetBooth['GetBoothSku'] as $boothSku) {
                $total_skuqty += $boothSku['skuqty'];
                $boothSku['skuname'] = $boothSku['GetNameSku']['pname'];
                unset($boothSku['GetNameSku']);
            }
            $targetBooth['total_skuqty'] = $total_skuqty;
            $total_skuqty = 0;
        }
        return $listTargetBooths ? $listTargetBooths : [];
    }

    public function create($request,$target_month) : WiTargetBooth
    {
        $TargetBooth = new WiTargetBooth();
        $TargetBooth->startdate = $request['startdate'];

        $TargetBooth->enddate = $request['enddate'];
        $TargetBooth->custid = $request['custid'];
        $TargetBooth->booth_month = $target_month;
        $TargetBooth->createon = Carbon::now();
        $TargetBooth->save();
        return $TargetBooth;
    }

    public function delete($id) :bool
    {
        $deleteTargetBoothSku = WiTargetBoothSku::where('id_targetbooth', $id);
        $deleteTargetBoothSku->delete();
        $deleteTargetBooth = WiTargetBooth::find($id);
        if ($deleteTargetBooth->delete()) {
            return true;
        }
        return false;
    }
}
