<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\examsAttempt;
use App\Models\examsAnswer;
use App\Models\Question;
use App\Models\Answer;
use App\Models\QnaExam;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Jobs\SendMailJob;


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
        // return $exam;
        return view('admin.exam-dashboard', ['subjects'=>$subjects, 'exams'=>$exam]);
       
    }

    //add exam

    public function addExam(Request $request)
    {
        try{
            $plan = $request->plan;
            $price = null;
            if(isset($request->inr) && isset($request->usd))
            {
                $price = json_encode(['INR'=>$request->inr, 'USD'=>$request->usd]);
            }

            $unique_id = uniqid('exam');
            Exam::create([
                'exam_name' => $request->exam_name,
                'subject_id' => $request->subject_id,
                'date' => $request->date,
                'time' => $request->time,
                'attempt' => $request->attempt,
                'enterance_id'=> $unique_id,
                'plan' => $plan,
                'price' => $price,
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
            $plan = $request->plan;
            $price = null;
            if(isset($request->inr) && isset($request->usd))
            {
                $price = json_encode(['INR'=>$request->inr, 'USD'=>$request->usd]);
            }

            $exam = Exam::find($request->exam_id);
            $exam->exam_name = $request->exam_name;
            $exam->subject_id = $request->subject_id;
            $exam->date = $request->date;
            $exam->time = $request->time;
            $exam->attempt = $request->attempt;
            $exam->plan = $plan;
            $exam->price = $price;
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
            $now = now();
            $questionId = Question::insertGetId([
                'question' => $request->question,
                'explaination' => $request->explaination ?? null,
                'subject_id' => $request->subject,
                'category_id' => $request->category,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            foreach($request->answers as $answer)
            {
                Answer::insert([
                    'question_id'=>$questionId,
                    'answer'=>$answer,
                    'is_correct'=>$request->is_correct == $answer ? 1 : 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
            return response()->json(['success'=>true, 'msg'=>'Question added successfully!']);
        }
        catch(\Exception $e)
        {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
     }

     //Edit qna-ans

     public function getQnaDetails(Request $request)
     {
        $qna = Question::with(['subject','category'])->where('id',$request->qid)->with('answers')->get();
        $subjects = Subject::all();
        $categories = Category::all();
        return response()->json(['success'=>true, 'data'=>$qna, 'subjects'=>$subjects, 'categories'=>$categories]);
       
     }

     //delete ans
     
     public function deleteAns(Request $request)
     {
        Answer::where('id',$request->ansId)->delete();
        return response()->json(['success'=>true, 'msg'=>'Answer deleted successfully!']);
     }

     //update qna-ans

     public function updateQna(Request $request)
     {
         try{
            Question::where('id',$request->question_id)
            ->update([
                'question'=>$request->question,
                'explaination' =>$request->explaination ?? null,
            ]);

            //old answer 
            if(isset($request->answers))
            {
                foreach($request->answers as $key => $value)
                {
                    $is_correct = 0;
                    if($request->is_correct == $value)
                    {
                        $is_correct = 1;
                    }
                    Answer::where('id',$key)
                    ->update([
                        'question_id'=>$request->question_id,
                        'answer'=>$value,
                        'is_correct'=>$is_correct,
                    ]);
                }
            }
            // new answers added

            if(isset($request->new_answers))
            {
                foreach($request->new_answers as $answer)
                {
                    $is_correct = 0;
                    if($request->is_correct == $answer)
                    {
                        $is_correct = 1;
                    }
                    Answer::insert([
                        'question_id'=>$request->question_id,
                        'answer'=>$answer,
                        'is_correct'=>$is_correct,
                    ]);
                }
            }

            
            return response()->json(['success'=>true, 'msg'=>'Question updated successfully!']);

        }catch(\Exception $e)
        {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
     }

     //delete qna
    
     public function deleteQna(Request $request)
     {
        Question::where('id', $request->id)->delete();
        Answer::where('question_id', $request->id)->delete();
        return response()->json(['success'=>true, 'msg'=>'Question deleted successfully!']);
     }

     //student dashboard

     public function studentDashboard()
     {
        $students = User::where('is_admin',0)->get();
        return view('admin.studentDashboard',compact('students'));
     }

     //add student

     public function addStudent(Request $request)
     {
        try
        {
            $password = Str::random(8);

            User::insert([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($password),
            ]);

            $url = URL::to('/');

            $data['url'] = $url;
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['password'] = $password;
            $data['title'] = "Student registration on Online Examination System";

            Mail::send('registrationMail',['data'=>$data],function($message) use($data){
                $message->to($data['email'])->subject($data['title']);
            });

            return response()->json(['success'=>true, 'msg'=>'Student added successfully!']);
        }
        catch(\Exception $e)
        {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
        
     }

     //update 

     public function editStudent(Request $request)
     { //return $request->all();
        try
        {

            $user = User::find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            $url = URL::to('/');
            $data['url'] = $url;
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['title'] = "Update Student Profile on Online Examination System";

            // Mail::send('updateProfileMail',['data'=>$data],function($message) use($data){
            //     $message->to($data['email'])->subject($data['title']);
            // });

            //=========JOB MAIL USE ==========//

            dispatch(new SendMailJob($data));

            return response()->json(['success'=>true, 'msg'=>'Student updated successfully!']);
        }
        catch(\Exception $e)
        {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
        
     }

     //delete 
     
     public function deleteStudent(Request $request)
     {
        try
        {
            $user = User::find($request->id);
            $user->delete();

            return response()->json(['success'=>true, 'msg'=>'Student deleted successfully!']);
        }
        catch(\Exception $e)
        {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
     }

     //get qna

     public function getQuestions(Request $request)
     {
        try
        {
            $questions = Question::where('subject_id','=',$request->sub_id)->get();

            if(count($questions) > 0)
            {
                $data = [];
                $counter = 0;
                foreach($questions as $question)
                {
                    $qnaExam = QnaExam::where(['exam_id'=>$request->exam_id, 'question_id'=>$question->id])->get();
                    if(count($qnaExam) == 0)
                    {
                        $data[$counter]['id'] = $question->id;
                        $data[$counter]['question'] = $question->question;
                        $counter++;
                    }
                }
                return response()->json(['success'=>true,'msg'=>'Question data!', 'data'=>$data]);
            }
            else 
            {
                return response()->json(['success'=>false,'msg'=>'Question data not Found!']);
            }
            
        }
        catch(\Exception $e)
        {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
     }

     //add qna
     public function addQuestions(Request $request)
     {
        try{
            if(isset($request->question_ids))
            {
                foreach($request->question_ids as $qid)
                {
                    QnaExam::insert([
                        'exam_id' => $request->exam_id,
                        'question_id' => $qid
                    ]);
                }
            }
            return response()->json(['success'=>true,'msg'=>'Question added successfully!']);
        }
        catch(\Exception $e)
        {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
     }

     //show questions
     public function getExamQuestions(Request $request)
     {
        try{
            $data = QnaExam::where('exam_id',$request->exam_id)->with('question')->get();
            return response()->json(['success'=>true,'msg'=>'Questions details','data'=>$data]);
        }
        catch(\Exception $e)
        {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
     }

     //delete question
     public function deleteExamQuestions(Request $request)
     {
        try{
            QnaExam::where('id',$request->id)->delete();
            return response()->json(['success'=>true,'msg'=>'Question deleted']);
        }
        catch(\Exception $e)
        {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
     }

     //load makrs

     public function loadMarks()
     {
        $exams = Exam::with('getQnaExam')->get();
        // return $exams;
        return view('admin.marksDashboard',compact('exams'));
     }

     //update marks

     public function updateMarks(Request $request)
     {
        try{
            $exam = Exam::find($request->exam_id);
            $exam->marks = $request->marks;
            $exam->pass_marks = $request->pass_marks;
            $exam->save();
            return response()->json(['success'=>true,'msg'=>'Marks updated']);
        }
        catch(\Exception $e)
        {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
     }

     //review exams

     public function reviewExams()
     {
        $attempts = examsAttempt::with(['user','exam'])->orderBy('id')->get();

        return view('admin.review-exams',compact('attempts'));
     }

     public function reviewQna(Request $request)
     { 
        try{
            $attemptData = examsAnswer::where('attempt_id',$request->attempt_id)->with(['question','answers'])->get();
            return response()->json(['success'=>true,'data'=>$attemptData]);
        }
        catch(\Exception $e)
        {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
       
     }

     public function approvedQna(Request $request)
     {
        try{
            $examData = examsAttempt::where('id',$request->attempt_id)->with(['user','exam'])->get();
            $marks = $examData[0]['exam']['marks'];
            $attemptData = examsAnswer::where('attempt_id',$request->attempt_id)->with('answers')->get();
            $totalQue = 0;
            $totalMarks = 0;
            if(count($attemptData) > 0)
            {
                foreach($attemptData as $attempt)
                {
                    if($attempt->answers->is_correct == 1)
                    {
                        $totalMarks += $marks;
                    }


                }
                $totalQue = count($attemptData);
            }
            examsAttempt::where('id',$request->attempt_id)->update(['status'=>1,'marks'=>$totalMarks]);

            //============ SEND MAIL STOP ==============//
            $url = URL::to('/');
            $data['url'] = $url.'/results';
            $data['name'] = $examData[0]['user']['name'];
            $data['user_id'] = $examData[0]['user']['id'];
            $data['email'] = $examData[0]['user']['email'];
            $data['title'] = $examData[0]['exam']['exam_name'].'Result';
            $data['exam_name'] = $examData[0]['exam']['exam_name'];
            $data['obt_marks'] = $totalMarks;
            $data['max_marks'] = $totalQue * $examData[0]['exam']['marks'];;
            $data['pass_marks'] = $examData[0]['exam']['pass_marks'];
            $data['per_qna_marks'] = $examData[0]['exam']['marks'];
            $data['date'] = $examData[0]['updated_at'];
            $data['exam_id'] = $examData[0]['exam']['id'];
//  return $data;
            // Mail::send('result-mail',['data'=>$data], function($message) use($data){
            //     $message->to($data['email'])->subject($data['title']);
            // });
            //=========== NEW SEND MAIL VIEW FILE ==========//
            // Mail::send('mail.result',['data'=>$data], function($message) use($data){
            //     $message->to($data['email'])->subject($data['title']);
            // });

            dispatch(new SendMailJob($data));
            return response()->json(['success'=>true,'msg'=>'Approved Successfully']);
        }catch(\Exception $e)
        {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
     }

     //import qna

     public function importQna(Request $request)
     {
        try{
            
        }
        catch(\Exception $e)
        {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
     }

     //export qna

     public function exportQna(Request $request)
     {
        try{
            return Excel::download(new QnaExport, 'qna.xlsx');
        }
        catch(\Exception $e)
        {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
     }

     public function getSubject()
     {
        $subjects = Subject::all();
        return response()->json(['success'=>true,'data'=>$subjects]);
     }

     public function getCategory($id)
     {
        $cats = Category::where('subject_id',$id)->get();
        return response()->json(['success'=>true,'cats'=>$cats]);
     }

     
}
