<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Subject,Category};

class QuestionController extends Controller
{
    //=============== Add Question Form ===============//
    public function index()
    {
        $subjects = Subject::all();
        return view('admin.question.add', ['subjects' => $subjects]);
    }

    //============== Get Categories =================//
    public function getCategories(Request $request)
    {
        $subjectId = $request->input('subject_id');
        $categories = Category::where('subject_id', $subjectId)->get();
        return response()->json(['success' => true, 'data' => $categories]);
    }

    //=============== Add Question ===================//
    public function store(Request $request)
    {

    }
}
