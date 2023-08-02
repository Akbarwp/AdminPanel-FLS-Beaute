<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UserImports implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'user_position'     => $row[1],
            'id_group'    => $row[2], 
            'username'    => $row[3], 
            'image'    => $row[4], 
            'firstname'    => $row[5], 
            'lastname'    => $row[6], 
            'ktp'    => $row[7], 
            'email'    => $row[8], 
            'province_id'    => $row[9], 
            'city_id'    => $row[10], 
            'address'    => $row[11], 
            'postcode'    => $row[12], 
            'cluster'    => $row[13], 
            'tokopedia'    => $row[14], 
            'shopee'    => $row[15], 
            'lazada'    => $row[16], 
            'bukalapak'    => $row[17], 
            'blibli'    => $row[18], 
            'id_input'    => $row[19], 
            'nama_input'    => $row[20], 
            'created_at'    => $row[21], 
            'updated_at'    => $row[22], 
        ]);
    }
}
