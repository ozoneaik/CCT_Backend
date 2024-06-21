<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class checkMonthController extends Controller
{
    public function checkTargetMonth($target_month): array
    {
        //target_month type is dateTime()
        $current_time = Carbon::now();
        $current_time = $current_time->format('Y-m-01 00:00:00');
        $message = [];
        if ($target_month->diffInMonths($current_time) !== 1) {
            $current_time_carbon = Carbon::parse($current_time);
            $next_month = $current_time_carbon->copy()->addMonth()->locale('th')->translatedFormat('F');
            $message['status'] = false;
            $message['desc'] = 'จำเป็นต้องกรอกหรือลบข้อมูลในเดือนเป้าหมายคือ ' . $next_month . ' เท่านั้น';
        }else{
            $message['status'] = true;
            $message['desc'] = 'ไม่มีปัญหา';
        }
        return $message;
    }
}
