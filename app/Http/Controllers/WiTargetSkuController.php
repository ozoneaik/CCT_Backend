<?php

namespace App\Http\Controllers;

use App\Services\WiTargetSkuService;

class WiTargetSkuController extends Controller
{
    protected WiTargetSkuService $wiTargetSkuService;

    public function __construct(WiTargetSkuService $wiTargetSkuService){
        $this->wiTargetSkuService = $wiTargetSkuService;
    }

    public function index(){
        //
    }
}
