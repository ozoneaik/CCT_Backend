<?php

namespace App\Http\Controllers;


use App\Services\WiTargetSaleService;

class WiTargetSaleController extends Controller
{
    protected WiTargetSaleService $wiTargetSaleService;

    public function __construct(WiTargetSaleService $wiTargetSaleService){
        $this->wiTargetSaleService = $wiTargetSaleService;
    }

    public function index(){
        //
    }
}
