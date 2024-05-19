<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\Exam;
use App\Models\QnaExam;
use App\Models\{examsAnswer,Subject,Category,Question};

class QuestionController extends Controller
{
    public function questionList($id)
    {
        return "ok";
$category_id;
        $examData = examsAnswer::with(['question.answers', 'answers'])
                        ->get();
       
        // return $student;
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
        // $questionBank = examsAnswer::with(['question.answers', 'answers'])->get();
        $subjects = Subject::all();
        // return $subjects;
        return view('student.questionbank')->with('subjects',$subjects);
    }

    public function categoryQue($id)
    {
       
        $categories = Category::where('subject_id',$id)->get();
        $totalQue = Question::whereIn('category_id', $categories->pluck('id'))->count();
        return view('student.categoryQuestion',compact('categories','totalQue'));
    }

    public function categoryQueBank($id)
    {
        $data = Question::with('answers')->where('category_id',$id)->get();
// return $data;
        return view('student.questionCateg')->with('questions',$data);
    }

    public function downloadQuePdf($id)
    {
        $questions = Question::with('answers')->where('category_id',$id)->get();
// return $data;
        // return view('student.questionCateg')->with('questions',$data);

        view()->share('questions',$questions);
            $pdf = PDF::loadView('pdf.questionBank', compact('questions'));
            return $pdf->download('questionBank.pdf');
    }
}
