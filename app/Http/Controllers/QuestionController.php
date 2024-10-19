<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use Dompdf\Dompdf;
use Dompdf\Options;

use App\Models\Exam;
use App\Models\QnaExam;
use App\Models\{examsAnswer,Subject,Category,Question};

class QuestionController extends Controller
{
    public function questionList($id)
    {
        return "ok";
        $examData = examsAnswer::with(['question.answers', 'answers'])->get();
       
        view()->share('employee',$examData);
        $pdf = PDF::loadView('pdf.questionBank', compact('examData'));
        return $pdf->download('questionBank.pdf');
    }

    public function questionAll()
    {
        return view('student.questionbank');
    }

    public function questionBankShow()
    {
        // $subjects = Subject::all();
        $subjects = Subject::whereHas('category.question',function($q)
        {
            $q->whereNotNull('id');
        })->get();
        return view('student.questionbank')->with('subjects',$subjects);
    }

    public function categoryQue($id)
    {
       
        $categories = Category::withCount('question')->where('subject_id',$id)->get();
        
        $totalQue = Question::whereIn('category_id', $categories->pluck('id'))->count();
        return view('student.categoryQuestion',compact('categories','totalQue'));
    }

    public function categoryQueBank($id)
    {
        $data = Question::with('answers')->where('category_id',$id)->get();

        return view('student.questionCateg')->with('questions',$data);
    }

    public function downloadQuePdf($id)
    {
        set_time_limit(300); 
        $questions = Question::with('answers')->where('category_id', $id)->get();
        $catName = Category::where('id', $id)->first()->name;
        $sanitizedCatName = preg_replace('/[^A-Za-z0-9\-]/', '_', $catName);
        $pdf = PDF::loadView('pdf.questionBank', compact('questions','catName'));

        return $pdf->download($sanitizedCatName . '.pdf');
    }
}
