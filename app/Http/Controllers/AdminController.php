<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Answer;

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

    public function editSubject(Request $request)
    {
        try{
            $subject = Subject::find($request->id);
            $subject->name = $request->subject;
            $subject->save();
            return response()->json(['success'=>true, 'msg'=>'Subject updated successfully!']);
        }
        catch(\Exception $e)
        {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    public function deleteSubject(Request $request)
    {
        try{
            $subject = Subject::find($request->id);
            $subject->delete();
            return response()->json(['success'=>true, 'msg'=>'Subject deleted successfully!']);
        }
        catch(\Exception $e)
        {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    //load exam dashboard

    public function examDassboard()
    {
        $subjects = Subject::all();
        $exam = Exam::with('subjects')->get();
        return view('admin.exam-dashboard', ['subjects'=>$subjects, 'exams'=>$exam]);
       
    }

    //add exam

    public function addExam(Request $request)
    {
        try{
            Exam::insert([
                'exam_name' => $request->exam_name,
                'subject_id' => $request->subject_id,
                'date' => $request->date,
                'time' => $request->time,
                'attempt' => $request->attempt,
            ]);
            return response()->json(['success'=>true, 'msg'=>'Exam added successfully!']);
        }
        catch(\Exception $e)
        {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
        
    }

    //edit exam

    public function getExamDetail($id)
    {
        try{
            $exam = Exam::where('id', $id)->get();
            return response()->json(['success'=>true, 'data'=>$exam]);
        }
        catch(\Exception $e)
        {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    //update exam
     public function updateExam(Request $request)
     {
        try{
            $exam = Exam::find($request->exam_id);
            $exam->exam_name = $request->exam_name;
            $exam->subject_id = $request->subject_id;
            $exam->date = $request->date;
            $exam->time = $request->time;
            $exam->attempt = $request->attempt;
            $exam->save();
            return response()->json(['success'=>true, 'msg'=>'Exam updated successfully!']);
        }
        catch(\Exception $e)
        {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
     }

     //delete exam

     public function deleteExam(Request $req)
     {
        try{
            $exam = Exam::find($req->exam_id);
            $exam->delete();
            return response()->json(['success'=>true, 'msg'=>'Exam deleted successfully!']);
        }catch(\Exception $e)
        {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
     }

     //question dashboard
     public function qnaDashboard()
     {
       $questions =  Question::with('answers')->get();
        return view('admin.qnaDashboard',compact('questions'));
     }

     //add question
     public function addQna(Request $request)
     {
        try{
           $questionId =  Question::insertGetId([
                'question'=>$request->question,
            ]);

            foreach($request->answers as $answer)
            {
                Answer::insert([
                    'question_id'=>$questionId,
                    'answer'=>$answer,
                    'is_correct'=>$request->is_correct == $answer ? 1 : 0,
                ]);
            }
            return response()->json(['success'=>true, 'msg'=>'Question added successfully!']);
        }
        catch(\Exception $e)
        {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
     }
}
