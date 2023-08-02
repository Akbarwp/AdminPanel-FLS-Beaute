<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            ['nama_group' => 'pusat'],
            // ['nama_group' => 'distributorpusat'],
            // ['nama_group' => 'jkt'],
        ];

        foreach($groups as $group){
            Group::create($group);
        }
    }
}
