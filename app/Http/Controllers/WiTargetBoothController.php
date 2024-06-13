<?php

namespace App\Http\Controllers;

use App\Services\WiTargetBoothService;

class WiTargetBoothController extends Controller
{
    protected WiTargetBoothService $wiTargetBoothService;

    public function __construct(WiTargetBoothService $wiTargetBoothService){
        $this->wiTargetBoothService = $wiTargetBoothService;
    }

    public function index(){
        //
    }
}
