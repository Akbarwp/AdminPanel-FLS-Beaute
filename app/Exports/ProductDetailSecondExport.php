<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductDetailSecondExport implements FromView
{
    protected $id;
    
    public function __construct(int $id)
    {
        $this->id = $id;
    } 

    public function view(): View
    {
        if(auth()->user()->lihat_barang == 1)
        {
            $owner = User::where('id', $this->id)->first();
            $products = Product::where('id_owner', $this->id)->select('products.*')->selectRaw('stok * harga_modal as nilaiStok')->get();
            $totalStok = $products->sum('stok');
            $totalNilaiStok = $products->sum('nilaiStok');

            if(auth()->user()->id_group == 1)
            {
                return view('manage_product.second.exportDetailXlsx', compact(['owner','products','totalStok','totalNilaiStok']));
            }
            else if(auth()->user()->user_position != "reseller")
            {
                return view('manage_product.second.exportDetailXlsx', compact(['owner','products','totalStok','totalNilaiStok']));
            }
        }
    }
}
