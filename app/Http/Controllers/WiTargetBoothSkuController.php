<?php

namespace App\Http\Controllers;

use App\Services\WiTargetBoothSkuService;

class WiTargetBoothSkuController extends Controller
{
    protected WiTargetBoothSkuService $wiTargetBoothSkuService;

    public function __construct(WiTargetBoothSkuService $wiTargetBoothSkuService){
        $this->wiTargetBoothSkuService = $wiTargetBoothSkuService;
    }

    public function index(){
        //
    }
}
