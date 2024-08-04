<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new \App\Models\Subject();
        $data->name = "Root";
        $data->parent_id = 1;
        $data->status = 1;
        $data->save();
    }
}
