<?php

namespace App\Exports;

use App\Models\ReturHistory;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReturExport implements WithMultipleSheets
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
        $history = ReturHistory::select('id')->where('id_owner', $this->id)->get();

        $sheets = [new ReturHistoryExport(),];
        foreach ($history as $id) {        
            $sheets[] = new ReturDetailHistoryExport($id->id);   
        }

        return $sheets;
        
    }
}