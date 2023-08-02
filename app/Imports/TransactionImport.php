<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TransactionImport  implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new TransactionHistoryImport(),
            new TransactionDetailImport(),
        ];
    }
}
