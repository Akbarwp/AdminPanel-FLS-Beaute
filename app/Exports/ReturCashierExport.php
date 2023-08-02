<?php

namespace App\Exports;

use App\Models\ReturCashierHistory;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReturCashierExport implements WithMultipleSheets
{
    protected $id;
    
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return array
     */
    public function sheets(): array
    { 
        $history = ReturCashierHistory::select('id')->where('id_owner', $this->id)->get();

        $sheets = [new ReturCashierHistoryExport(),];
        foreach ($history as $id) {        
            $sheets[] = new ReturCashierDetailExport ($id->id);   
        }

        return $sheets;
        
    }
}
