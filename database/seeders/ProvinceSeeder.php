<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Vtiful\Kernel\Excel;
use App\Imports\ProvincesImport;
use Illuminate\Support\Facades\Schema;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        Province::truncate();
        \Maatwebsite\Excel\Facades\Excel::import(new ProvincesImport, database_path('csv/provinces.csv'));
        Schema::disableForeignKeyConstraints();

    }
}
