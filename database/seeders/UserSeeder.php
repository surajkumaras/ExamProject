<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            'name'=>'Aman Gupta',
            'email'=>'aman@gmail.com',
            'password'=>Hash::make('admin123'),
            'is_admin'=>0
        ]);
    }
}
