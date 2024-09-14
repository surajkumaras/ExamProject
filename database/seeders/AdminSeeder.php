<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            'name'=>'Admin',
            'email'=>'cblsurajkumar1@gmail.com',
            'password'=>Hash::make('admin123'),
            'is_admin'=>1
        ]);
    }
}
