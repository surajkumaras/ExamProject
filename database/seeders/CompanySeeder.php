<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = new Company();
        $company->name = 'ExamManagement';
        $company->email = 'suraj.enact@gmail.com';
        $company->phone = '8360666189';
        $company->address = 'Sector 45';
        $company->country = 'India';
        $company->state = 'Chandigarh';
        $company->city = 'Chandigarh';
        $company->zip = '160047';
        $company->save();
    }
}
