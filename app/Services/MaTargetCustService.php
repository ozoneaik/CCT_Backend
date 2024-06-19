<?php

namespace App\Services;

use App\Models\MaTargetCust;

class MaTargetCustService
{
    public function getMaTargetCustList()
    {
        return MaTargetCust::take(5)->get();
    }

    public function getMaTargetCustById($username): array
    {
        $TargetCusts = MaTargetCust::where('fieldsaleid', $username)
            ->where('percentsale', '>=', 0.81)
            ->with('getCustName')->get();
        $result = [];
        foreach ($TargetCusts as $index=>$TargetCust) {
            $result[$index]['custid'] = $TargetCust->custid;
            $result[$index]['custname'] = $TargetCust->getCustName['custname'];
        }
        return $result ? $result : [];
    }

    public function getCustAllTotal($username)
    {
        $CustAllTotal = MatargetCust::where('fieldsaleid', $username)->get();
        return $CustAllTotal ? $CustAllTotal : [];
    }
}
