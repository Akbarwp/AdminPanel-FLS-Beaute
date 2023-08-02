<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TransactionSellImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new TransactionHistorySellImport(),
            new TransactionDetailSellImport(),
        ];
    }
}
