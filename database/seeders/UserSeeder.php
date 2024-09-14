<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            'name'=>'Aman Gupta',
            'email'=>'suraj.enact@gmail.com',
            'password'=>Hash::make('admin123'),
            'is_admin'=>0
        ]);
    }
}
