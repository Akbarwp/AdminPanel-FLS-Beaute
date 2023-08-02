<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'kode_produk' => 'PA_AM_6',
                'nama_produk' => 'PARFUM ASTANA AQUA MAN 6 ML',
            ],
            [
                'kode_produk' => 'PA_BR_6',
                'nama_produk' => 'PARFUM ASTANA BRITISH ROSE 6 ML',
            ],
            [
                'kode_produk' => 'PA_SB_6',
                'nama_produk' => 'PARFUM ASTANA SUGAR BABY 6 ML',
            ],
            [
                'kode_produk' => 'PA_AB_6',
                'nama_produk' => 'PARFUM ASTANA ANGEL BLOSSOM 6 ML',
            ],
            [
                'kode_produk' => 'PA_V_6',
                'nama_produk' => 'PARFUM ASTANA VANILLA 6 ML',
            ],
        ];

        foreach($types as $type){
            ProductType::create($type);
        }
    }
}
