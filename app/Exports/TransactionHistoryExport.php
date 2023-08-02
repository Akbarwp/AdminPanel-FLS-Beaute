<?php

namespace App\Exports;

use App\Models\TransactionHistory;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TransactionHistoryExport implements WithMultipleSheets
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
        $history = TransactionHistory::select('id')->where('id_owner', $this->id)->get();

        $sheets = [new TransactionBuyHistoryExport(),];
        foreach ($history as $id) {        
            $sheets[] = new TransactionDetailBuyHistoryExport($id->id);   
        }

        return $sheets;
        
    }
}
