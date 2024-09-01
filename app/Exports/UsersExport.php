<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'Student ID',
            'Name',
            'Email',
            'Image',
            'Gender',
            'Phone',
            'Address',
            'City',
            'State',
            'Country',
            'Pin',
            'Role',
            'Created At',
        ];

    }

    public function collection()
    {
        $users = User::select('id', 'name', 'email', 'image', 'gender', 'phone', 'address', 'city', 'state', 'country', 'zip_code', 'is_admin', 'created_at')->get();

        $users->transform(function ($user) 
        {
            $user->is_admin = $user->is_admin == 1 ? 'Admin' : 'Student';
            return $user;
        });

        return $users;
    }
}
