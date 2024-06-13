<?php

namespace App\Http\Controllers;

use App\Services\MaProductService;
use Illuminate\Http\JsonResponse;

class MaProductController extends Controller
{
    protected MaProductService $maProductService;

    public function __construct(MaProductService $maProductService){
        $this->maProductService = $maProductService;
    }

    public function index(): JsonResponse
    {
        $products = $this->maProductService->getMaProductList();
        return response()->json($products);
    }
}
