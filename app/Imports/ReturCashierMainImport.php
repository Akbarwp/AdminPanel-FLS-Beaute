<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReturCashierMainImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new ReturCashierHistoryImport(),
            new ReturCashierImport(),
        ];
    }
}
