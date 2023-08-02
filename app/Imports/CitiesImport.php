<?php

namespace App\Imports;

use App\Models\City;
use Maatwebsite\Excel\Concerns\ToModel;

class CitiesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new City([
            'id'              => $row[0],
            'province_id'     => $row[1],
            'name'            => $row[2],
        ]);
    }
}
