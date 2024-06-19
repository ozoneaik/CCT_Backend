<?php
namespace App\Services;

use App\Models\WiTargetTrain;
use Carbon\Carbon;

class WiTargetTrainService{
    public function getWiTargetTrain($target_month,$cust_id){
        $TargetTrains = WiTargetTrain::where('custid' ,$cust_id)->where('train_month' , $target_month)->get();
        return count($TargetTrains) > 0 ? $TargetTrains : [];
    }

    public function create($TargetTrain) : bool{
        try {
            $newWiTargetTrain = new WiTargetTrain();
            $newWiTargetTrain->custid = $TargetTrain['cust_id'];
            $newWiTargetTrain->trainstart = $TargetTrain['trainstart'];
            $newWiTargetTrain->trainend = $TargetTrain['trainend'];
            $newWiTargetTrain->train_desc = $TargetTrain['train_desc'];
            $newWiTargetTrain->train_month = $TargetTrain['target_month'];
            $newWiTargetTrain->createon = Carbon::now();
            $newWiTargetTrain->save();
            return true;
        }catch (\Exception $exception){
            return false;
        }
    }

    public function update($id,$desc): bool
    {
        try {
            $TargetTrain = WiTargetTrain::where('id' , $id)->first();
            $TargetTrain->train_desc = $desc;
            $TargetTrain->save();
            return true;
        }catch (\Exception $exception){
            return false;
        }
    }

    public function delete($id) : bool{
        try {
            $TargetTrainDelete = WiTargetTrain::where('id',$id)->first();
            $TargetTrainDelete->delete();
            return true;
        }catch (\Exception $e){
            return false;
        }
    }
}
