<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $products = [
            [
                'id_productType' => 1,
                'id_group' => 1,
                'id_owner' => 1,
                'stok' => 0,
                'harga_jual' => 10000,
                'harga_modal' => 5000,
                'keterangan' => 'Kosong',
            ],
            [
                'id_productType' => 2,
                'id_group' => 1,
                'id_owner' => 1,
                'stok' => 0,
                'harga_jual' => 11000,
                'harga_modal' => 5000,
                'keterangan' => 'Kosong',
            ],
            [
                'id_productType' => 3,
                'id_group' => 1,
                'id_owner' => 1,
                'stok' => 0,
                'harga_jual' => 12000,
                'harga_modal' => 5000,   
                'keterangan' => 'Kosong',
            ],
            [
                'id_productType' => 4,
                'id_group' => 1,
                'id_owner' => 1,
                'stok' => 0,
                'harga_jual' => 13000,
                'harga_modal' => 5000,   
                'keterangan' => 'Kosong',
            ],
            [
                'id_productType' => 5,
                'id_group' => 1,
                'id_owner' => 1,
                'stok' => 0,
                'harga_jual' => 14000,
                'harga_modal' => 5000,   
                'keterangan' => 'Kosong',
            ],
            [
                'id_productType' => 1,
                'id_group' => 2,
                'id_owner' => 5,
                'stok' => 0,
                'harga_jual' => 20000,
                'harga_modal' => 10000,
                'keterangan' => 'Kosong',
            ],
            [
                'id_productType' => 2,
                'id_group' => 2,
                'id_owner' => 5,
                'stok' => 0,
                'harga_jual' => 21000,
                'harga_modal' => 11000,
                'keterangan' => 'Kosong',
            ],
            [
                'id_productType' => 3,
                'id_group' => 2,
                'id_owner' => 5,
                'stok' => 0,
                'harga_jual' => 22000,
                'harga_modal' => 12000,   
                'keterangan' => 'Kosong',
            ],
            [
                'id_productType' => 4,
                'id_group' => 2,
                'id_owner' => 5,
                'stok' => 0,
                'harga_jual' => 23000,
                'harga_modal' => 13000,   
                'keterangan' => 'Kosong',
            ],
            [
                'id_productType' => 5,
                'id_group' => 2,
                'id_owner' => 5,
                'stok' => 0,
                'harga_jual' => 24000,
                'harga_modal' => 14000,   
                'keterangan' => 'Kosong',
            ],
            [
                'id_productType' => 1,
                'id_group' => 3,
                'id_owner' => 7,
                'stok' => 0,
                'harga_jual' => 20000,
                'harga_modal' => 10000,
                'keterangan' => 'Kosong',
            ],
            [
                'id_productType' => 2,
                'id_group' => 3,
                'id_owner' => 7,
                'stok' => 0,
                'harga_jual' => 22000,
                'harga_modal' => 11000,
                'keterangan' => 'Kosong',
            ],
            [
                'id_productType' => 3,
                'id_group' => 3,
                'id_owner' => 7,
                'stok' => 0,
                'harga_jual' => 24000,
                'harga_modal' => 12000,   
                'keterangan' => 'Kosong',
            ],
            [
                'id_productType' => 4,
                'id_group' => 3,
                'id_owner' => 7,
                'stok' => 0,
                'harga_jual' => 26000,
                'harga_modal' => 13000,   
                'keterangan' => 'Kosong',
            ],
            [
                'id_productType' => 5,
                'id_group' => 3,
                'id_owner' => 7,
                'stok' => 0,
                'harga_jual' => 28000,
                'harga_modal' => 14000,   
                'keterangan' => 'Kosong',
            ],
            [
                'id_productType' => 1,
                'id_group' => 3,
                'id_owner' => 9,
                'stok' => 0,
                'harga_jual' => 40000,
                'harga_modal' => 20000,   
                'keterangan' => 'Kosong',
            ],
            [
                'id_productType' => 2,
                'id_group' => 3,
                'id_owner' => 9,
                'stok' => 0,
                'harga_jual' => 44000,
                'harga_modal' => 22000,   
                'keterangan' => 'Kosong',
            ],
            [
                'id_productType' => 3,
                'id_group' => 3,
                'id_owner' => 9,
                'stok' => 0,
                'harga_jual' => 48000,
                'harga_modal' => 24000,   
                'keterangan' => 'Kosong',
            ],
            [
                'id_productType' => 4,
                'id_group' => 3,
                'id_owner' => 9,
                'stok' => 0,
                'harga_jual' => 52000,
                'harga_modal' => 26000,   
                'keterangan' => 'Kosong',
            ],
            [
                'id_productType' => 5,
                'id_group' => 3,
                'id_owner' => 9,
                'stok' => 0,
                'harga_jual' => 56000,
                'harga_modal' => 28000,   
                'keterangan' => 'Kosong',
            ],
            [
                'id_productType' => 1,
                'id_group' => 3,
                'id_owner' => 10,
                'stok' => 0,
                'harga_jual' => 30000,
                'harga_modal' => 20000,   
                'keterangan' => 'Kosong',
            ],
            [
                'id_productType' => 2,
                'id_group' => 3,
                'id_owner' => 10,
                'stok' => 0,
                'harga_jual' => 32000,
                'harga_modal' => 22000,   
                'keterangan' => 'Kosong',
            ],
            [
                'id_productType' => 3,
                'id_group' => 3,
                'id_owner' => 10,
                'stok' => 0,
                'harga_jual' => 34000,
                'harga_modal' => 24000,   
                'keterangan' => 'Kosong',
            ],
            [
                'id_productType' => 4,
                'id_group' => 3,
                'id_owner' => 10,
                'stok' => 0,
                'harga_jual' => 36000,
                'harga_modal' => 26000,   
                'keterangan' => 'Kosong',
            ],
            [
                'id_productType' => 5,
                'id_group' => 3,
                'id_owner' => 10,
                'stok' => 0,
                'harga_jual' => 38000,
                'harga_modal' => 28000,   
                'keterangan' => 'Kosong',
            ],
        ];
        

        foreach($products as $product){
            Product::create($product);
        }
    }
}
