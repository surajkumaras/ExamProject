<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use App\Imports\{UsersImport,QuestionImport};
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

    //================ Import qna ================//

    public function importQna(Request $request)
    {
       try{
           if ($request->hasFile('file')) 
           {
               $file = $request->file('file');
               Excel::import(new QuestionImport, $file);
               return back()->with('success', 'Products imported successfully.');
           } 
           else 
           {
               return response()->json(['success' => false, 'msg' => 'No file uploaded']);
           }
       }
       catch(\Exception $e)
       {
           return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
       }
    }
}
