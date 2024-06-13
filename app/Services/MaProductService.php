<?php
namespace App\Services;

use App\Models\MaProduct;

class MaProductService{
    public function getMaProductList(){
        return MaProduct::take(5)->get();
    }
}
