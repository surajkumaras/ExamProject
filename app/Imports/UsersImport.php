<?php

namespace App\Imports;
use ZipArchive;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    // public function __construct()
    // {
    //     // Delete all existing users before inserting new data
    //     User::truncate();
    // }

    public function model(array $row)
    {
        return new User([
                'name' => $row['1'],
                'email' => $row['2'],
                'gender' => $row['4'],
                'phone' => $row['5'],
                'address' => $row['6'],
                'city' => $row['7'],
                'state' => $row['8'],
                'country' => $row['9'],
                'zip_code' => $row['10'],
                'is_admin' => $row['12'] == 1 ? 1:0,
                'password' => Hash::make('Admin123'),
                'social_id' => $row['13'],
                'social_type' => $row['14'],
                'created_at' => $row['16'],
                'updated_at' => $row['17']
        ]);
    }
}
