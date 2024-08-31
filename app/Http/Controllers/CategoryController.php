<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Category;

class CategoryController extends Controller
{
    //Category show
    public function categoryDashboard()
    {
        $categories = Category::with('subject')->get();
        // return $categories;
        return view('admin.category',compact('categories'));
    }

    //================ Add Category ================//
    public function addCategory(Request $request)
    {
        try{
            Category::create([
                'subject_id'=>$request->subject,
                'name'=>$request->catName
            ]);
            return response()->json(['status'=>true,'msg'=>'Category Added Successfully']);
        }  
        catch(\Exception $e)
        {
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
        
    }

    //=============== Edit Subject List ===================//
    public function catgorySubject($id)
    {
        $subjs = Subject::all();

        $cats = Category::with('subject')->where('id',$id)->get();

        return response()->json(['status'=>true,'cats'=>$cats,'subjs'=>$subjs]);
    }

    //=============== Delete Category ================//
    public function deleteCategory(Request $request)
    {  
        $category = Category::find($request->id);
        if($category)
        {
            $category->delete();
            return response()->json(['status'=>true,'msg'=>'Category Deleted Successfully']);
        }
    }

    //=============== Edit and Update ================//
    // public function editCategory(Request $request)
    // {   return $request->all(); 
    //     if($request->id)
    //     {
    //         $category = Category::find($request->id);
    //         if($category)
    //         {
    //             return response()->json(['status'=>true,'data'=>$category]);
    //         }
    //         else
    //         {
    //             return response()->json(['status'=>false,'msg'=>'Category Not Found']);
    //         }
    //     }
    // }

    //=============== Update Category ================//
    public function updateCategory(Request $request)
    {   
        try
        {
            $category = Category::find($request->id);
            if($category)
            {
                $category->subject_id = $request->subject;
                $category->name = $request->category;
                $category->save();
                return response()->json(['status'=>true,'msg'=>'Category Updated Successfully']);
            }
            else
            {
                return response()->json(['status'=>false,'msg'=>'Category Not Found']);
            }
        }
        catch(\Exception $e)
        {
            return response()->json(['status'=>false,'message'=>'Something went wrong']);
        }
        
    }
}
