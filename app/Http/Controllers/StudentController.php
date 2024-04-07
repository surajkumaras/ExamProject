<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;

class StudentController extends Controller
{
    //paid exam 

    public function examDashboard()
    {
        $exams =  Exam::where('plan',1)->with('subjects')->orderBy('date','DESC')->get();
        // return $exams;
        return view('student.paid-exam',['exams'=>$exams]);
    }
}
