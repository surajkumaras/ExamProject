<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\{UsersExport, QuestionExport};
use App\Imports\{UsersImport,QuestionImport};
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;

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

    //================= Export qna ================//
    public function exportQna()
    {
        try
        {
            return Excel::download(new QuestionExport, 'questions_' . date('Y-m-d_H-i-s') . '.xlsx');
        }
        catch(\Exception $e)
        {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }
}
