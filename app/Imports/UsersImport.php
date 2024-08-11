<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
                'name' => $row['0'],
                'email' => $row['1'],
                'gender' => $row['3'],
                'phone' => $row['4'],
                'address' => $row['5'],
                'city' => $row['6'],
                'state' => $row['7'],
                'country' => $row['8'],
                'zip_code' => $row['9'],
                'is_admin' => $row['11'],
                'password' => Hash::make($row['12'],),
                'social_id' => $row['13'],
                'social_type' => $row['14'],
                'created_at' => $row['16'],
                'updated_at' => $row['17'],
        ]);
    }
}
