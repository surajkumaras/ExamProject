<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\QnaExam;
use App\Models\examsAttempt;
use App\Models\examsAnswer;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function loadExamDashboard($id)
    {
        $qnaExam = Exam::where('enterance_id',$id)->with('getQnaExam')->get();
        if(count($qnaExam)>0)
        {
            $attemptCount = examsAttempt::where(['exam_id'=>$qnaExam[0]['id'],'user_id'=>auth()->user()->id])->count();
            if($attemptCount >= $qnaExam[0]['attempt'])
            {
                return view('student.exam-dashboard',['success'=>false, 'msg'=>'Your exam attemption has been completed! ','exam'=>$qnaExam]);

            }
            else if($qnaExam[0]['date'] == date('Y-m-d'))
            {
                if(count($qnaExam[0]['getQnaExam']) > 0)
                {
                    $qna = QnaExam::where('exam_id',$qnaExam[0]['id'])->with(['question','answers'])->inRandomOrder()->get();    
                    // return $qna;
                    return view('student.exam-dashboard',['success'=>true,'exam'=>$qnaExam,'qna'=>$qna]);

                }
                else 
                {
                    return view('student.exam-dashboard',['success'=>false, 'msg'=>'This exam is not availabele for now! ','exam'=>$qnaExam]);

                }
            }
            else if($qnaExam[0]['date'] > date('Y-m-d'))
            {
                return view('student.exam-dashboard',['success'=>false, 'msg'=>'This exam will be start on '.$qnaExam[0]['date'],'exam'=>$qnaExam]);
            }
            else 
            {
                return view('student.exam-dashboard',['success'=>false, 'msg'=>'This exam has been expaired on'.$qnaExam[0]['date'],'exam'=>$qnaExam]);

            }
        }
        else 
        {
            return view('404');
        }
    }

    public function examSubmit(Request $request)
    {
        //  return $request->all();

       $attempt_id = examsAttempt::insertGetId([
            'exam_id'=>$request->exam_id,
            'user_id'=>Auth::user()->id,
        ]);

        $qcount = count($request->q);

        if($qcount > 0)
        {
            for($i=0; $i<$qcount; $i++)
            {
                if(!empty($request->input('ans_'.($i+1))))
                {
                    examsAnswer::insert([
                        'attempt_id' => $attempt_id,
                        'question_id' => $request->q[$i],
                        'answer_id' => request()->input('ans_'.$i+1)
                    ]);
                }
            }
        }

        return view('thank-you');
    }

    //result 
    public function resultDashboard()
    {
        $attempts = examsAttempt::where('user_id',Auth::user()->id)->with('exam')->orderBy('updated_at')->get();
        //  return $attempts;
        return view('student.results',compact('attempts'));
    }

    //review exam
    public function reviewQna(Request $request)
    {
        try 
        {
            $examData = examsAnswer::where('attempt_id',$request->attempt_id)->with(['question','answers'])->get();
            return response()->json(['success'=>true,'msg'=>'data found','data'=>$examData]);
        }
        catch(\Exception $e)
        {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }
}
