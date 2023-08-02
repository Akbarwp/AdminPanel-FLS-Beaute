<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\ProductType;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProductExport implements WithMultipleSheets
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
        $id_product = Product::select('id')->where('id_owner', $this->id)->get();
        $sheets = [new ProductListExport($this->id),];
        foreach ($id_product as $id) {        
            $sheets[] = new ProductDetailExport($id->id);   
        }

        return $sheets;
        
    }
}
