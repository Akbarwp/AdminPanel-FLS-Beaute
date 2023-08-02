<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReturImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new ReturHistoryImport(),
            new ReturDetailImport(),
        ];
    }
}
