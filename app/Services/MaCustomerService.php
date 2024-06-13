<?php
namespace App\Services;

use App\Models\MaCustomer;

class MaCustomerService{

    public function getCustomerList(){
        return MaCustomer::take(5)->get();
    }

}
