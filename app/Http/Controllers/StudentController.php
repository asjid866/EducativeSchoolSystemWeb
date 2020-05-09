<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Admission;

class StudentController extends BaseController
{

    function allStudentList(){

        $allStudents = DB::table('students')->where(['activeStatus'=>'1'])->get();
        $studentDetails = [];

        foreach ($allStudents as $student){
            $oneStudent = DB::table('admissions')->where(['admissionId'=>$student->admissionId])->first();
            $oneStudent->{'currentClass'} = $student->class;
            $oneStudent->{'studentId'} = $student->studentId;
            array_push($studentDetails,$oneStudent);
        }
//        dump($studentDetails);die;
        return view('Admin/Student/allStudentList', ['studentDetails'=>$studentDetails]);
    }

    function singleStudentDetail(Request $request){
        $studentId = $request->get('studentId');
        $student = DB::table('students')->where(['studentId'=>$studentId])->first();

        $studentDetail = DB::table('admissions')->where(['admissionId'=>$studentId])->first();
        $studentDetail->{'currentClass'} = $student->class;
        $studentDetail->{'studentId'} = $student->studentId;

        dump("In single student detail" . "    " . $studentId);die;
    }


    function getStudentByClass(Request $request){

        $class = $request->get('class');

        $admissionDetails = DB::table('admissions')->orderBy('fName','ASC')->get();
        $students = DB::table('students')->where(['class'=>$class , 'activeStatus'=>'1'])->get();
        $studentDetails = [];

        foreach ($admissionDetails as $admissionDetail){
            foreach ($students as $student){
                if ($admissionDetail->admissionId == $student->admissionId){
                    $admissionDetail->{'studentId'} = $student->studentId;
                    array_push($studentDetails,$admissionDetail);
                }
            }
        }
        return response()->json($studentDetails, 200);

        //        $students = DB::table('students')->where(['class'=>$class , 'activeStatus'=>'1'])->get();
//        $studentDetails = [];
//        foreach ($students as $student){
//            $oneStudent = DB::table('admissions')->where(['admissionId'=>$student->admissionId])->first();
//            $oneStudent->{'studentId'} = $student->studentId;
//            array_push($studentDetails,$oneStudent);
//        }
//        return response()->json($studentDetails, 200);
    }

//    function getStudentByClass(){
//
//        $class = "Play Group";
//
//        $admissionDetails = DB::table('admissions')->orderBy('fName','ASC')->get();
//        $students = DB::table('students')->where(['class'=>$class , 'activeStatus'=>'1'])->get();
//        $studentDetails = [];
//
//        foreach ($admissionDetails as $admissionDetail){
//            foreach ($students as $student){
//                if ($admissionDetail->admissionId == $student->admissionId){
//                    $admissionDetail->{'studentId'} = $student->studentId;
//                    array_push($studentDetails,$admissionDetail);
//                }
//            }
//        }
//        return response()->json($studentDetails, 200);
//    }





}
