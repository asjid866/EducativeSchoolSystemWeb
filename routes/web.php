<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});


Route::get('/home', function () {
    return view('index');
});

Route::get('/admin-login', function () {
    return view('Admin/adminLogin');
});



Route::get('/onlineclasses', 'OnlineClassesController@onlineClassesIndex');



Route::get('/admin-home', function (\Illuminate\Http\Request $request) {
//    if ($request->get('username') == "admin" && $request->get('password') == "Admin123"){
    return view('Admin/adminMain');
//    }
//    else{
//        return view('Admin/adminLogin');
//    }
});





// Admission
Route::get('/admin-newAdmission', 'NewAdmissionController@newAdmission');
Route::post('/admin-insertNewAdmission', 'NewAdmissionController@insertNewAdmission');


// Students
Route::get('/admin-allstudentlist', 'StudentController@allStudentList');
Route::post('/admin-studentDetails', 'StudentController@singleStudentDetail');


// Fees
Route::get('/admin-feeCollectionView', 'FeeController@feeCollectionView');
Route::post('/admin-studentFeeDetails', 'FeeController@singleStudentFeeDetail');
Route::post('/admin-addfeeforallstudents', 'FeeController@addfeeforallstudents');
Route::post('/admin-payStudentFees', 'FeeController@payStudentFees');
Route::post('/admin-payStudentFeeByFeeId', 'FeeController@payStudentFeeByFeeId');


// Payments and sales
Route::post('/admin-studentPaymentDetails', 'PaymentController@singleStudentPaymentDetail');
Route::get('/admin-salesView', 'PaymentController@salesView');
Route::post('/admin-saveStudentSales', 'PaymentController@saveStudentSales');
Route::post('/admin-payStudentPaymentByPaymentId', 'PaymentController@payStudentPaymentByPaymentId');
//Route::get('/admin-payStudentPaymentByPaymentId', 'PaymentController@payStudentPaymentByPaymentId');


// Exams
Route::post('/admin-studentExamDetails', 'ExamController@singleStudentExamDetail');
Route::get('/admin-studentExamView', 'ExamController@getExamView');
Route::post('/admin-getStudentByClass', 'StudentController@getStudentByClass');
Route::post('/admin-getStudentAndMarksByClass', 'ExamController@getStudentAndMarksByClass');
Route::post('/admin-addNewExam', 'ExamController@addNewExam');
Route::post('/admin-marksListAjex', 'ExamController@marksListAjex');
Route::post('/admin-generateStudentResult', 'ExamController@generateStudentResult');
Route::post('/admin-showStudentResult', 'ExamController@showStudentResult');
Route::get('/admin-viewResult', 'ExamController@viewResult');



