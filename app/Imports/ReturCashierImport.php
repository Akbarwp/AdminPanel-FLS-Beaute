<?php

namespace App\Imports;

use App\Models\ReturCashier;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\TransactionHistorySell;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Carbon;

class ReturCashierImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ReturCashier([
        ]);
    }
}
