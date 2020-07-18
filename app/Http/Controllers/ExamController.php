<?php

namespace App\Http\Controllers;

use App\Paper;
use App\Result;
use App\Student;
use App\Test;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Admission;
use Illuminate\Support\Facades\Session;

class ExamController extends BaseController
{
//    function singleStudentExamDetail(Request $request){
//        $studentId = $request->get('studentId');
//        $student = DB::table('students')->where(['studentId'=>$studentId])->first();
//
//        $studentDetail = DB::table('admissions')->where(['admissionId'=>$studentId])->first();
//        $studentDetail->{'currentClass'} = $student->class;
//        $studentDetail->{'studentId'} = $student->studentId;
//
//        $paperDetails = DB::table('papers')->where(['studentId'=>$studentId])->get();
//        $resultDetails = DB::table('results')->where(['studentId'=>$studentId])->get();
//        $testDetails = DB::table('tests')->where(['studentId'=>$studentId])->get();
//
//        dump($studentDetail);die;
//    }


    function getExamView(){
        $subjects = DB::table('subjects')->get();
        return view('Admin/Exam/getExamView',['subjects'=>$subjects]);
    }

    function viewResult(){
        $subjects = DB::table('subjects')->get();
        return view('Admin/Exam/resultView',['subjects'=>$subjects]);
    }

    function addNewExam(Request $request)
    {
        $class = $request->get('class');
        $term = $request->get('term');
        $examType = $request->get('examType');
        $subject = $request->get('subject');
        $paperType = $request->get('paperType');
        $totalMarks = $request->get('totalMarks');
        $passingMarks = $request->get('passingMarks');
        $examDate = $request->get('examDate');

        $students = DB::table('students')->where(['class' => $class, 'activeStatus' => '1'])->get();
        if ($examType == "Test") {
            foreach ($students as $student) {
                $newTest = new Test();

                $newTest->studentId = $student->studentId;
                $newTest->term = $term;
                $newTest->class = $class;
                $newTest->subjectId = $subject;
                $newTest->testType = $paperType;
                $date = strtotime($examDate);
                $newTest->testDate = date("Y-m-d", strtotime(str_replace('/', '-', $examDate)));
                $newTest->totalMarks = $totalMarks;
                $newTest->obtainedMarks = $request->get('obtainedMarks' . $student->studentId);
                $newTest->passingMarks = $passingMarks;
                if ($request->get('obtainedMarks' . $student->studentId) >= $passingMarks) {
                    $newTest->passStatus = 1;
                } else {
                    $newTest->passStatus = 0;
                }
                $newTest->remarks = $request->get('remarks' . $student->studentId) != "null" ? $request->get('remarks' . $student->studentId) : "";
                $newTest->save();
            }
            Session::put('status', "success");
            Session::put('msg', $subject." Test Marks Saved Successfully");
            return redirect('/admin-studentExamView');

        } elseif ($examType == "Paper") {
            foreach ($students as $student) {
                $newPaper = new Paper();

                $newPaper->studentId = $student->studentId;
                $newPaper->term = $term;
                $newPaper->class = $class;
                $newPaper->subjectId = $subject;
                $newPaper->paperType = $paperType;
                $newPaper->paperDate = date("Y-m-d", strtotime(str_replace('/', '-', $examDate)));
                $newPaper->totalMarks = $totalMarks;
                $newPaper->obtainedMarks = $request->get('obtainedMarks' . $student->studentId);
                $newPaper->passingMarks = $passingMarks;
                if ($request->get('obtainedMarks' . $student->studentId) >= $passingMarks) {
                    $newPaper->passStatus = 1;
                } else {
                    $newPaper->passStatus = 0;
                }
                $newPaper->remarks = $request->get('remarks' . $student->studentId);
                $newPaper->save();
            }
            Session::put('status', "success");
            Session::put('msg', $subject." Paper Marks Saved Successfully");
            return redirect('/admin-studentExamView');
        }
        Session::put('status', "failure");
        Session::put('msg', "Error Occurred Try Again!");
        return redirect('/admin-studentExamView');
    }


    function singleStudentExamDetail(Request $request){
        $studentId = $request->get('studentId');
        $student = DB::table('students')->where(['studentId'=>$studentId])->first();
        $studentDetail = DB::table('admissions')->where(['admissionId'=>$studentId])->first();
        $studentDetail->{'currentClass'} = $student->class;
        $studentDetail->{'studentId'} = $student->studentId;
        $subjects = DB::table('subjects')->get();
        return view('Admin/Student/studentExamDetail',['studentDetails'=>$studentDetail, 'subjects'=>$subjects]);
    }

    function marksListAjex(Request $request){
        $studentId = $request->get('studentId');
        $examType = $request->get('examType');
        $term = $request->get('term');
        $year = $request->get('year');
        $marksList = null;
        if ($examType == 'Paper'){
            $marksList = DB::table('papers')->where(['term' => $term, 'studentId'=>$studentId])->whereYear('paperDate' , '=', date($year))->get();
        }
        elseif($examType = 'Test'){
            $marksList = DB::table('tests')->where(['term' => $term, 'studentId'=>$studentId])->whereYear('testDate' , '=', date($year))->get();
        }
        if ($marksList != null){
            return response()->json($marksList, 200);

        }
        return response()->json("Failure", 500);
    }


    function generateStudentResult(Request $request){
        $studentId = $request->get('studentId');
        $term = $request->get('term');
        $year = $request->get('year');
        $resultDate = $request->get('resultDate');

        $totalAttendanceDays = $request->get('totalAttendanceDays');
        $attendedDays = $request->get('attendedDays');
        $neatnessMarks = $request->get('neatnessMarks');
        $behaviourMarks = $request->get('behaviourMarks');
        $finalRemarks = $request->get('finalRemarks');

        $student = DB::table('students')->where(['studentId'=>$studentId])->first();
        $studentDetail = DB::table('admissions')->where(['admissionId'=>$studentId])->first();
        $studentDetail->{'currentClass'} = $student->class;
        $studentDetail->{'studentId'} = $student->studentId;

        $subjects = DB::table('subjects')->get();
        $staticExamType = ['Written', 'Oral', 'Practicle', 'Spoken'];
        $marksList = DB::table('papers')->where(['term' => $term, 'studentId'=>$studentId])->whereYear('paperDate' , '=', date($year))->get();

        $resultArray = [];

        $netTotal = 0;
        $netObtained = 0;
        $netPercentage = 0;
        $netPassStatus = 1;
        $netPassingMarks=0;
        $grade = 'A';

        foreach ($subjects as $subject){
            $totalMarks = 0;
            $passingMarks = 0;
            $obtainedMarks = 0;
            $percentage = 0;
            $passStatus = "Pass";

            foreach ($staticExamType as $staticExam){
                foreach ($marksList as $mark){
                    if ($mark->subjectId == $subject->subjectTitle && $mark->paperType == $staticExam){
                        $totalMarks += $mark->totalMarks;
                        $passingMarks += $mark->passingMarks;
                        $obtainedMarks += $mark->obtainedMarks;

                    }
                }
            }
            if ($totalMarks != 0){
                $percentage = number_format((float)($obtainedMarks / $totalMarks)*100, 2, '.', '');
                if ($percentage < 50){
                    $passStatus = "Fail";
                }
                $result = [
                    "subject" => $subject->subjectTitle,
                    "totalMarks" => $totalMarks,
                    "passingMarks" => $passingMarks,
                    "obtainedMarks" => $obtainedMarks,
                    "percentage" => $percentage,
                    "passStatus" => $passStatus
                ];
                array_push($resultArray, $result);
                $netTotal += $totalMarks;
                $netObtained += $obtainedMarks;
                $netPassingMarks += $passingMarks;
                $result = null;
            }
        }
//        dump($netTotal);die;
        $netPercentage = number_format((float)($netObtained / $netTotal)*100, 2, '.', '');
        if ($netPercentage < 50){
            $netPassStatus = 0;
        }

        if($netPercentage >= 80){
            $grade = 'A';
        }elseif($netPercentage >= 70){
            $grade = 'B';
        }elseif($netPercentage >= 60){
            $grade = 'C';
        }elseif($netPercentage >= 50){
            $grade = 'D';
        }else{
            $grade = 'F';
        }

        $result = DB::table('results')->where(['studentId'=>$studentId, 'term'=>$term, 'class'=>$student->class ])->whereYear('resultDate' , '=', date($year))->first();
        if ($result == null){
            $result = new Result();
            $result->studentId = $studentId;
            $result->term = $term;
            $result->class = $student->class;
            $result->resultDate = date("Y-m-d", strtotime(str_replace('/', '-', $resultDate)));
            $result->totalMarks = $netTotal;
            $result->obtainedMarks = $netObtained;
            $result->passStatus = $netPassStatus;
            $result->remarks = $finalRemarks;
            $result->grade = $grade;
            $result->totalAttendanceDays = $totalAttendanceDays;
            $result->attendedDays = $attendedDays;
            $result->neatnessMarks = $neatnessMarks;
            $result->behaviourMarks = $behaviourMarks;
            $result->percentage = $netPercentage;
            $result->save();
        }
        else{
            $result = DB::table('results')->where(['studentId'=>$studentId, 'term'=>$term, 'class'=>$student->class ])->whereYear('resultDate' , '=', date($year))
                ->update(['totalMarks'=>$netTotal, 'resultDate'=> date("Y-m-d", strtotime(str_replace('/', '-', $resultDate))),
                    'obtainedMarks'=>$netObtained, 'passStatus'=>$netPassStatus, 'remarks'=>$finalRemarks, 'grade'=>$grade,
                    'percentage'=>$netPercentage, 'totalAttendanceDays'=>$totalAttendanceDays, 'attendedDays'=>$attendedDays,
                    'neatnessMarks'=>$neatnessMarks, 'behaviourMarks'=>$behaviourMarks, 'passingMarks'=>$netPassingMarks]);
        }

        $allResults = DB::table('results')->where(['term'=>$term, 'class'=>$student->class ])->whereYear('resultDate' , '=', date($year))->orderBy('percentage', 'asc')->get();
        $count = 1;
        foreach ($allResults as $result){
            DB::table('results')->where(['resultId'=>$result->resultId])->update(['position'=>$count]);
            $count++;
        }

        $studentResult = DB::table('results')->where(['studentId'=>$studentId, 'term'=>$term, 'class'=>$student->class ])->whereYear('resultDate' , '=', date($year))->first();


        return view('Admin/Student/studentResult',['studentResult'=>$studentResult, 'studentDetails'=>$studentDetail, 'results'=>$resultArray]);
    }


    function showStudentResult(Request $request){

        $studentId = $request->get('selectedStudentId');
        $term = $request->get('term');
        $year = $request->get('year');
        $class = $request->get('resultClass');

        $student = DB::table('students')->where(['studentId'=>$studentId])->first();
        $studentDetail = DB::table('admissions')->where(['admissionId'=>$studentId])->first();
        $studentDetail->{'currentClass'} = $student->class;
        $studentDetail->{'studentId'} = $student->studentId;

        $subjects = DB::table('subjects')->get();
        $staticExamType = ['Written', 'Oral', 'Practicle', 'Spoken'];
        $marksList = DB::table('papers')->where(['term' => $term, 'studentId'=>$studentId])->whereYear('paperDate' , '=', date($year))->get();

        $resultArray = [];

        $netTotal = 0;
        $netObtained = 0;
        $netPercentage = 0;
        $netPassStatus = "Pass";

        foreach ($subjects as $subject){
            $totalMarks = 0;
            $passingMarks = 0;
            $obtainedMarks = 0;
            $percentage = 0;
            $passStatus = "Pass";

            foreach ($staticExamType as $staticExam){
                foreach ($marksList as $mark){
                    if ($mark->subjectId == $subject->subjectTitle && $mark->paperType == $staticExam){
                        $totalMarks += $mark->totalMarks;
                        $passingMarks += $mark->passingMarks;
                        $obtainedMarks += $mark->obtainedMarks;
                    }
                }
            }
            if ($totalMarks != 0){
                $percentage = number_format((float)($obtainedMarks / $totalMarks)*100, 2, '.', '');
                if ($percentage < 50){
                    $passStatus = "Fail";
                }
                $result = [
                    "subject" => $subject->subjectTitle,
                    "totalMarks" => $totalMarks,
                    "passingMarks" => $passingMarks,
                    "obtainedMarks" => $obtainedMarks,
                    "percentage" => $percentage,
                    "passStatus" => $passStatus
                ];
                array_push($resultArray, $result);
                $netTotal += $totalMarks;
                $netObtained += $obtainedMarks;

                $result = null;
            }
        }
//        dump($netTotal);die;
        $netPercentage = number_format((float)($netObtained / $netTotal)*100, 2, '.', '');
        if ($netPercentage < 50){
            $netPassStatus = "Fail";
        }

        $studentResult = DB::table('results')->where(['studentId'=>$studentId, 'term'=>$term, 'class'=>$student->class ])->whereYear('resultDate' , '=', date($year))->first();


        return view('Admin/Student/studentResult',['studentResult'=>$studentResult, 'studentDetails'=>$studentDetail, 'results'=>$resultArray]);

    }


//     ajec call
    function getStudentAndMarksByClass(Request $request){



        dump("email sent");die;


//        $class = $request->get('class');
//        $term = $request->get('term');
//        $examType = $request->get('examType');
//        $subject = $request->get('subject');
//        $paperType = $request->get('paperType');
//        $year = $request->get('year');
//
//        $admissionDetails = DB::table('admissions')->orderBy('fName','ASC')->get();
//        $students = DB::table('students')->where(['class'=>$class , 'activeStatus'=>'1'])->get();
//        $studentDetails = [];
//
//        foreach ($admissionDetails as $admissionDetail){
//            foreach ($students as $student){
//                if ($admissionDetail->admissionId == $student->admissionId){
//                    $admissionDetail->{'studentId'} = $student->studentId;
//                    if ($examType == "Paper"){
//                        $studentMark = DB::table('papers')->where(['studentId'=>$student->studentId, 'class'=>$class,
//                            'term' => $term, 'subjectId'=>$subject, 'paperType'=>$paperType])->whereYear('paperDate' , '=', date($year))->first();
//                        if ($studentMark != null){
//                            $admissionDetail->{'studentMark'} = $studentMark;
//                        }
//                    }
//                    array_push($studentDetails,$admissionDetail);
//                }
//            }
//        }
//        return response()->json($studentDetails, 200);

        //        $students = DB::table('students')->where(['class'=>$class , 'activeStatus'=>'1'])->get();
//        $studentDetails = [];
//        foreach ($students as $student){
//            $oneStudent = DB::table('admissions')->where(['admissionId'=>$student->admissionId])->first();
//            $oneStudent->{'studentId'} = $student->studentId;
//            array_push($studentDetails,$oneStudent);
//        }
//        return response()->json($studentDetails, 200);
    }





}
