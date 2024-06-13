<?php

namespace App\Http\Controllers;

use App\Services\WiTargetProService;
use Illuminate\Http\Request;

class WiTargetProController extends Controller
{
    protected WiTargetProService $wiTargetProService;

    public function __construct(WiTargetProService $wiTargetProService){
        $this->wiTargetProService = $wiTargetProService;
    }
}
