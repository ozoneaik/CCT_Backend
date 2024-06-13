<?php

namespace App\Http\Controllers;

use App\Services\MaCustomerService;
use Illuminate\Http\JsonResponse;

class MaCustomerController extends Controller
{
    protected MaCustomerService $maCustomerService;

    public function __construct(MaCustomerService $maCustomerService){
        $this->maCustomerService = $maCustomerService;
    }

    public function index(): JsonResponse
    {
        $customers = $this->maCustomerService->getCustomerList();
        return response()->json($customers);
    }

}
