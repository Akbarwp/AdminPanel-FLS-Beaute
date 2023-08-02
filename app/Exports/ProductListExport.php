<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\ProductType;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductListExport implements FromView
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
            $position = User::where('id', $this->id)->first()->user_position;
    
            if($position == "superadmin_pabrik")
            {
                if(auth()->user()->id_group == 1)
                {
                    $pusat = User::where('id', $this->id)->first();
                    $products = Product::where('id_owner', $pusat->id)->join('product_types', 'product_types.id', '=', 'products.id_productType')->orderBy('product_types.kode_produk', 'asc')->select('products.*')->get();
                    $types = ProductType::all();
                    $stock = Product::where('id_owner', $pusat->id)->sum('stok');
                    return view('manage_product.exportXlsx', compact(['pusat', 'products', 'types', 'stock']));
                }
            }
            if($position == "superadmin_distributor")
            {
                if(auth()->user()->user_position != "reseller")
                {
                    $pusat = User::where('id', $this->id)->first();
                    $products = Product::where('id_owner', $pusat->id)->join('product_types', 'product_types.id', '=', 'products.id_productType')->orderBy('product_types.kode_produk', 'asc')->select('products.*')->get();
                    $types = ProductType::all();
                    $stock = Product::where('id_owner', $pusat->id)->sum('stok');
                    return view('manage_product.exportXlsx', compact(['pusat', 'products', 'types', 'stock']));
                }
            }
            else if($position == "reseller")
            {
                $pusat = User::where('id', $this->id)->first();
                $products = Product::where('id_owner', $this->id)->join('product_types', 'product_types.id', '=', 'products.id_productType')->orderBy('product_types.kode_produk', 'asc')->get();
                $types = ProductType::all();
                $stock = Product::where('id_owner', $this->id)->sum('stok');
                return view('manage_product.exportXlsx', compact(['pusat', 'products', 'types', 'stock']));
            }
        }
    }
}