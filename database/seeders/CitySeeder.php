<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Imports\CitiesImport;
use App\Models\City;
use Illuminate\Support\Facades\Schema as FacadesSchema;


class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FacadesSchema::disableForeignKeyConstraints();
        City::truncate();
        \Maatwebsite\Excel\Facades\Excel::import(new CitiesImport, database_path('csv/cities.csv'));
        FacadesSchema::enableForeignKeyConstraints();

    }
}
