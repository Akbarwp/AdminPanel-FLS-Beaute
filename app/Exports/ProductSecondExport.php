<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProductSecondExport implements WithMultipleSheets
{
    /**
     * @return array
     */
    public function sheets(): array
    { 
        $id_owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'reseller')->get();

        $sheets = [new ProductListSecondExport(),];
        foreach ($id_owner as $id) {        
            $sheets[] = new ProductDetailSecondExport($id->id);   
        }

        return $sheets;
        
    }
}
