<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;

class AdminController extends Controller
{
    public function addSubject(Request $request)
    {   
        try{
            $subject = new Subject;
            $subject->name = $request->subject;
            $subject->save();
            return response()->json(['success'=>true, 'msg'=>'Subject added successfully!']);
        }
        catch(\Exception $e)
        {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
        
    }

    // public function getSubjects()
    // {
    //     $subjects = Subject::all();
    //     return view('admin.subjects', ['subjects' => $subjects]);
    // }
}
