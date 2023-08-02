<?php

namespace App\Exports;

use App\Models\TransactionHistorySell;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TransactionSellExport implements WithMultipleSheets
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
        $history = TransactionHistorySell::select('id')->where('id_owner', $this->id)->get();

        $sheets = [new TransactionSellHistoryExport(),];
        foreach ($history as $id) {        
            $sheets[] = new TransactionSellDetailExport($id->id);   
        }

        return $sheets;
        
    }
}
