<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/register',[AuthController::class,'loadRegister'] )->name('register');
Route::post('/register',[AuthController::class,'studentRegister'] )->name('studentRegister');

Route::get('login', function()
{
    return redirect('/');
})->name('login');

Route::get('/',[AuthController::class,'loadLogin']);
Route::post('/login',[AuthController::class,'userLogin'])->name('userLogin');

Route::get('/logout',[AuthController::class,'logout']);

Route::get('/forget-password',[AuthController::class,'forgetPasswordLoad'])->name('forgotPassword');
Route::post('/forget-password',[AuthController::class,'forgetPassword'])->name('forgetPassword');
Route::get('/reset-password',[AuthController::class,'resetPasswordLoad']);
Route::post('/reset-password',[AuthController::class,'resetPassword'])->name('resetPassword');

Route::group(['middleware'=>['web','checkAdmin']],function()
{
    Route::get('/admin/dashboard',[AuthController::class,'adminDashboard'])->name('admin.dashboard');

    //subjects
    Route::post('/add-subject',[AdminController::class,'addSubject'])->name('add-subject');
    Route::post('/edit-subject',[AdminController::class,'editSubject'])->name('edit-subject');
    Route::post('/delete-subject',[AdminController::class,'deleteSubject'])->name('delete-subject');

    //subject-category
    Route::get('/category',[CategoryController::class,'categoryDashboard'])->name('categoryDashboard');
    Route::post('/add-category',[CategoryController::class,'addCategory'])->name('add-category');
    Route::get('/category/subject/{id}',[CategoryController::class,'catgorySubject'])->name('catgorySubject');
    Route::post('/update-category',[CategoryController::class,'updateCategory'])->name('update-category');
    Route::post('/delete-category',[CategoryController::class,'deleteCategory'])->name('delete-category');

    //exam routes
    Route::get('/admin/exams',[AdminController::class,'examDassboard']);
    Route::post('/add-exam',[AdminController::class,'addExam'])->name('addExam');

    Route::get('/get-exam-detail/{id}',[AdminController::class,'getExamDetail'])->name('getExamDetail');
    Route::post('/update-exam',[AdminController::class,'updateExam'])->name('updateExam');
    Route::post('/delete-exam',[AdminController::class,'deleteExam'])->name('deleteExam');

    //Question & Answer
    Route::get('/admin/qna-ans',[AdminController::class,'qnaDashboard']);
    Route::post('/add-qna-ans',[AdminController::class,'addQna'])->name('addQna');
    Route::get('/get-qna-details',[AdminController::class,'getQnaDetails'])->name('getQnaDetails');
    Route::get('/delete-ans',[AdminController::class,'deleteAns'])->name('deleteAns');
    Route::post('/update-qna-ans',[AdminController::class,'updateQna'])->name('updateQna');
    Route::post('/delete-qna-ans',[AdminController::class,'deleteQna'])->name('deleteQna');
    Route::get('/import-qna-ans',[AdminController::class,'importQna'])->name('importQna');
    Route::get('/export-qna-ans',[AdminController::class,'exportQna'])->name('exportQna');
    Route::get('/subject/list',[AdminController::class,'getSubject'])->name('getSubject');
    Route::get('/category/list/{id}',[AdminController::class,'getCategory'])->name('getCategory');

    //student routes
    Route::get('/admin/students',[AdminController::class,'studentDashboard']);
    Route::post('/add-students',[AdminController::class,'addStudent'])->name('addStudent');
    Route::post('/edit-students',[AdminController::class,'editStudent'])->name('editStudent');
    Route::post('/delete-students',[AdminController::class,'deleteStudent'])->name('deleteStudent');


    //qna 
    Route::get('/get-questions',[AdminController::class,'getQuestions'])->name('getQuestions');
    Route::post('/add-questions',[AdminController::class,'addQuestions'])->name('addQuestions');
    Route::get('/get-exam-questions',[AdminController::class,'getExamQuestions'])->name('getExamQuestions');
    Route::get('/delete-exam-questions',[AdminController::class,'deleteExamQuestions'])->name('deleteExamQuestions');
    
    //exam makrs
    Route::get('/admin/marks',[AdminController::class,'loadMarks'])->name('loadMarks');
    Route::post('/update-marks',[AdminController::class,'updateMarks'])->name('updateMarks');

    //exma review
    Route::get('/admin/review-exams',[AdminController::class,'reviewExams'])->name('reviewExams');
    Route::get('/get-reviewed-qna',[AdminController::class,'reviewQna'])->name('reviewQna');
    Route::post('/approved-qna',[AdminController::class,'approvedQna'])->name('approvedQna');
});

Route::group(['middleware'=>['web','checkStudent']],function()
{
    Route::get('/dashboard',[AuthController::class,'loadDashboard'])->name('student.dashboard');
    Route::get('/exam/{id}',[ExamController::class,'loadExamDashboard']);
    Route::post('/exam-submit',[ExamController::class,'examSubmit'])->name('examSubmit');
    Route::get('/results',[ExamController::class,'resultDashboard'])->name('resultDashboard');
    Route::get('/review-student-qna',[ExamController::class,'reviewQna'])->name('resultStudentQna');
    Route::get('/pdf/answersheet/{attempt_id}',[ExamController::class,'answersheet'])->name('answersheet');
    Route::get('/paid-exam',[StudentController::class,'examDashboard'])->name('examDashboard');

    //payment razorpay
    Route::get('/payment-inr',[StudentController::class,'paymentInr'])->name('paymentInr');
    Route::get('/verify-payment',[StudentController::class,'verifyPayment'])->name('verifyPayment');

    //paypal route
    Route::get('/payment-status/{examid}',[StudentController::class,'paymentStatus'])->name('paymentStatus');

});
