<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    //========= User Export ===========//
    public function userExport()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    //========= User Import ===========//
    public function userImport(Request $request)
    {
        return $request->all();
        Excel::import(new UsersImport, $request->file('file'));
        return redirect()->back()->with('success', 'Data Imported Successfully.');
    }
}
