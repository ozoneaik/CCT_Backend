<?php

namespace App\Http\Controllers;



use App\Services\WiTargetNewSkuService;

class WiTargetNewSkuController extends Controller
{
    protected WiTargetNewSkuService $wiTargetNewSkuService;

    public function __construct(WiTargetNewSkuService $wiTargetNewSkuService){
        $this->wiTargetNewSkuService = $wiTargetNewSkuService;
    }

    public function index(){
        //
    }
}
