<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GroupSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ProvinceSeeder::class);
        $this->call(CitySeeder::class);
        // $this->call(ProductTypeSeeder::class);
        // $this->call(ProductHistorySeeder::class);
        // $this->call(ProductSeeder::class);
    }
}
