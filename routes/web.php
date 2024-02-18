<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register',[AuthController::class,'loadRegister'] );
Route::post('/register',[AuthController::class,'studentRegister'] )->name('studentRegister');

Route::get('login', function()
{
    return redirect('/');
});

Route::get('/',[AuthController::class,'loadLogin']);
Route::post('/login',[AuthController::class,'userLogin'])->name('userLogin');

Route::get('logout',[AuthController::class,'logout']);

Route::get('/forget-password',[AuthController::class,'forgetPasswordLoad']);
Route::post('/forget-password',[AuthController::class,'forgetPassword'])->name('forgetPassword');
Route::get('/reset-password',[AuthController::class,'resetPasswordLoad']);
Route::post('/reset-password',[AuthController::class,'resetPassword'])->name('resetPassword');

Route::group(['middleware'=>['web','checkAdmin']],function()
{
    Route::get('/admin/dashboard',[AuthController::class,'adminDashboard'])->name('admin.dashboard');

    // Add subjects
    Route::post('/add-subject',[AdminController::class,'addSubject'])->name('add-subject');
    // Edit subject
    Route::post('/edit-subject',[AdminController::class,'editSubject'])->name('edit-subject');
    // Delete subject
    Route::post('/delete-subject',[AdminController::class,'deleteSubject'])->name('delete-subject');

    //exam routes
    Route::get('/admin/exams',[AdminController::class,'examDassboard']);
    Route::post('/add-exam',[AdminController::class,'addExam'])->name('addExam');

    Route::get('/get-exam-detail/{id}',[AdminController::class,'getExamDetail'])->name('getExamDetail');
    Route::post('/update-exam',[AdminController::class,'updateExam'])->name('updateExam');
    Route::post('/delete-exam',[AdminController::class,'deleteExam'])->name('deleteExam');

    //Question & Answer
    Route::get('/admin/qna-ans',[AdminController::class,'qnaDashboard']);
    Route::post('/add-qna-ans',[AdminController::class,'addQna'])->name('addQna');



});

Route::group(['middleware'=>['web','checkStudent']],function()
{
    Route::get('/dashboard',[AuthController::class,'loadDashboard'])->name('student.dashboard');
    
});