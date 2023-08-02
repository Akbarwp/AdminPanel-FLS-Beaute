<?php

namespace App\Imports;

use App\Models\ReturCashierHistory;
use App\Models\TransactionHistorySell;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Carbon;

class ReturCashierHistoryImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
            return new ReturCashierHistory([
                //
            ]);

    }
}
