<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\Admin\QuestionController as AdminQuestionController;
use App\Http\Controllers\Admin\BannerController as BannerController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\Admin\ConfigurationController;

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
//     // return view('welcome');
//     return view('student.dashboardnew');
// });
Route::get('/logs', [LogController::class, 'showLogs'])->name('logs');
Route::post('/logs/clear', [LogController::class, 'clearLogs'])->name('logs.clear');

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

//================ SOCIAL LOGIN ============================//
//------------- GOOGLE ---------------//
Route::get('auth/google',[AuthController::class,'loginWithGoogle'])->name('google.login');
Route::any('auth/google/callback',[AuthController::class,'callbackFromGoogle'])->name('google.callback');

//------------- FACEBOOK ---------------//
Route::get('auth/facebook',[AuthController::class,'loginWithFacebook'])->name('facebook.login');
Route::any('auth/facebook/callback',[AuthController::class,'callbackFromFacebook'])->name('facebook.callback');



Route::group(['middleware'=>['web','checkAdmin']],function()
{
    Route::get('/admin/dashboard',[AuthController::class,'adminDashboard'])->name('admin.dashboard');

    //subjects
    Route::get('/subject',[AdminController::class,'subject'])->name('subject');
    // Route::get('/show-subject',[AdminController::class,'showSubjects'])->name('showSubjects');
    Route::post('/add-subject',[AdminController::class,'addSubject'])->name('add-subject');
    Route::post('/edit-subject',[AdminController::class,'editSubject'])->name('edit-subject');
    Route::post('/delete-subject',[AdminController::class,'deleteSubject'])->name('delete-subject');

    //subject-category
    // Route::get('/category-new/{id}',[CategoryController::class,'category'])->name('category');

    Route::get('/category',[CategoryController::class,'categoryDashboard'])->name('categoryDashboard');
    Route::post('/add-category',[CategoryController::class,'addCategory'])->name('add-category');
    Route::get('/category/subject/{id}',[CategoryController::class,'catgorySubject'])->name('catgorySubject');
    Route::post('/update-category',[CategoryController::class,'updateCategory'])->name('update-category');
    Route::post('/delete-category',[CategoryController::class,'deleteCategory'])->name('delete-category');

    //exam routes
    Route::get('/admin/exams',[AdminController::class,'examDassboard'])->name('examDassboard');
    Route::post('/add-exam',[AdminController::class,'addExam'])->name('addExam');

    Route::get('/get-exam-detail/{id}',[AdminController::class,'getExamDetail'])->name('getExamDetail');
    Route::post('/update-exam',[AdminController::class,'updateExam'])->name('updateExam');
    Route::post('/delete-exam',[AdminController::class,'deleteExam'])->name('deleteExam');

    //Question & Answer
    Route::get('/admin/qna-ans',[AdminController::class,'qnaDashboard'])->name('qnaDashboard');
    Route::post('/add-qna-ans',[AdminController::class,'addQna'])->name('addQna');
    Route::get('/get-qna-details',[AdminController::class,'getQnaDetails'])->name('getQnaDetails');
    Route::get('/delete-ans',[AdminController::class,'deleteAns'])->name('deleteAns');
    Route::post('/update-qna-ans',[AdminController::class,'updateQna'])->name('updateQna');
    Route::post('/delete-qna-ans',[AdminController::class,'deleteQna'])->name('deleteQna');
    Route::post('/import-qna-ans',[ExcelController::class,'importQna'])->name('importQna');
    Route::get('/export-qna-ans',[ExcelController::class,'exportQna'])->name('exportQna');
    Route::get('/subject/list',[AdminController::class,'getSubject'])->name('getSubject');
    Route::get('/category/list/{id}',[AdminController::class,'getCategory'])->name('getCategory');

            /* New Code for question and answers*/
    Route::get('/question/add',[AdminQuestionController::class,'index'])->name('question');
    Route::get('admin/get-categories', [AdminQuestionController::class, 'getCategories'])->name('getCategories');
    Route::post('/question/add',[AdminQuestionController::class,'store'])->name('question.store');

    

    //student routes
    Route::get('/admin/students',[AdminController::class,'studentDashboard'])->name('studentDashboard');
    Route::post('/add-students',[AdminController::class,'addStudent'])->name('addStudent');
    Route::post('/edit-students',[AdminController::class,'editStudent'])->name('editStudent');
    Route::post('/delete-students',[AdminController::class,'deleteStudent'])->name('deleteStudent');
    // Route::get('/student/export',[StudentController::class,'userExport'])->name('userExport');
    Route::get('/student/export/new',[ExcelController::class,'userExport'])->name('userExport');
    Route::post('/student/import',[ExcelController::class,'userImport'])->name('userImport');


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

    Route::get('/admin/exam/review',[AdminController::class,'examReview'])->name('examReview');
    Route::get('/admin/exam/review/{id}',[AdminController::class,'examReviewById'])->name('exam-review');
    Route::get('/admin/ansswersheet/review/{eid}/{sid}/{exid}',[AdminController::class,'answersheetReviewById'])->name('answersheet-review');

    //setting
    Route::get('/admin/setting',[CompanyController::class,'settingDashboard'])->name('settingDashboard');
    Route::post('/update-setting',[CompanyController::class,'updateSetting'])->name('updateSetting');

    //Banner
    Route::get('/admin/banner/index',[BannerController::class,'index'])->name('banner.index');
    Route::post('/banner/store',[BannerController::class,'store'])->name('banner.store');
    Route::get('/banner/edit/{id}',[BannerController::class,'editBanner'])->name('banner.edit');
    Route::post('/banner/update/{id}',[BannerController::class,'updateBanner'])->name('banner.update');
    Route::post('/banner/delete/{id}',[BannerController::class,'deleteBanner'])->name('banner.delete');

    //Config
    Route::get('/admin/config',[ConfigurationController::class,'index'])->name('config');
    Route::post('/admin/config/mail',[ConfigurationController::class,'setMail'])->name('config.mail');
    Route::post('/admin/config/google/auth',[ConfigurationController::class,'setGoogleAuth'])->name('config.google.setauth');
    Route::post('/admin/config/facebook/auth',[ConfigurationController::class,'setFacebookAuth'])->name('config.facebook.setauth');


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

    Route::get('/mock-test',[ExamController::class,'mockTest'])->name('mockTest');
    Route::get('/category/{subject_id}',[ExamController::class,'categorySubject'])->name('categorySubject');
    Route::get('/category/exam/{category_id}',[ExamController::class,'categoryExam'])->name('categoryExam');
    Route::post('/mock-test/result',[ExamController::class,'mocktestResult'])->name('mocktest.result');

    //profile
    Route::get('/student/profile',[StudentController::class,'studentProfile'])->name('studentProfile');
    Route::post('/profile/update',[StudentController::class,'profileUpdate'])->name('profileUpdate');
    //question bank
    Route::get('/question/show',[QuestionController::class,'questionBankShow'])->name('questionBankShow');


    Route::get('/question/list/{$id}',[QuestionController::class,'questionList'])->name('questionList');
    Route::get('/question/list',[QuestionController::class,'questionAll'])->name('questionAll');
    Route::get('/category/{id}',[QuestionController::class,'categoryQue'])->name('categoryQue');
    Route::get('/questionBank/{category_id}',[QuestionController::class,'categoryQueBank'])->name('categoryQueBank');
    Route::get('/questionBank/pdf/{id}',[QuestionController::class,'downloadQuePdf'])->name('downloadQuePdf');


    //payment razorpay
    Route::get('/payment-inr',[StudentController::class,'paymentInr'])->name('paymentInr');
    Route::get('/verify-payment',[StudentController::class,'verifyPayment'])->name('verifyPayment');

    //paypal route
    Route::get('/payment-status/{examid}',[StudentController::class,'paymentStatus'])->name('paymentStatus');

});

//Notification
    Route::get('/notification',[NotificationController::class,'index'])->name('notification');
    Route::post('/store-token', [NotificationController::class, 'updateDeviceToken'])->name('store.token');
    Route::post('/send-web-notification', [NotificationController::class, 'sendFcmNotification'])->name('send.web-notification');

