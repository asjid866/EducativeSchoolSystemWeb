<?php

namespace App\Http\Controllers;

use App\Fee;
use App\Student;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Admission;
use Illuminate\Support\Facades\Session;

class FeeController extends BaseController
{
    function singleStudentFeeDetail(Request $request){
        $studentId = $request->get('studentId');
        $student = DB::table('students')->where(['studentId'=>$studentId])->first();

        $studentDetail = DB::table('admissions')->where(['admissionId'=>$studentId])->first();
        $studentDetail->{'currentClass'} = $student->class;
        $studentDetail->{'studentId'} = $student->studentId;


        $pendingFees = 0;
        $feeDetails = DB::table('fees')->where(['studentId'=>$studentId])->get();

        $studentDetail->{'feeDetails'} = $feeDetails;

        foreach ($feeDetails as $feeDetail){
            if ($feeDetail->paymentStatus == 'i' or $feeDetail->paymentStatus == 'n'){
                $pendingFees += ($feeDetail->feesAmount - $feeDetail->paidAmount);
            }
//            elseif ($feeDetail->paymentStatus == 'n'){
//                $pendingFees += $studentDetail->tuitionFees;
//            }
        }

        $studentDetail->{'pendingFees'} = $pendingFees;

        return view('Admin/Student/studentFeeDetail', ['studentDetails'=>$studentDetail]);

//        dump($studentDetail);die;
    }

    function feeCollectionView(){
        return view('Admin/Fee/feeCollectionView');
    }


    function addfeeforallstudents(Request $request){
        $year = $request->get('year');
        $month = $request->get('month');
        $allStudents = DB::table('students')->where(['activeStatus'=>'1'])->get();
        foreach ($allStudents as $student){
            $studentDetail = DB::table('admissions')->where(['admissionId'=>$student->admissionId])->first();
            $feeDetail = DB::table('fees')->where(['studentId'=>$student->studentId , 'feeYear'=>$year , 'feeMonth'=>$month])->first();
            if ($feeDetail == null){
                $newfee = new Fee();
                $newfee->studentId = $student->studentId;
                $newfee->feeYear = $year;
                $newfee->feeMonth = $month;
                $newfee->feesAmount = $studentDetail->tuitionFees;
                $newfee->paymentStatus = 'n';
                $newfee->save();
            }
        }
        Session::put('status', "success");
        Session::put('msg', "Fees for " . $month . " " . $year . " Added Successfully.");
        return redirect('admin-feeCollectionView');
    }


    function payStudentFees(Request $request){
        $year = $request->get('year');
        $month = $request->get('month');
        $studentId = $request->get('selectedStudentId');
        $paidFees = $request->get('paidAmount');
        $paymentStatus = 'n';

        $student = DB::table('students')->where(['studentId'=>$studentId])->first();
        $studentDetail = DB::table('admissions')->where(['admissionId'=>$student->admissionId])->first();

        $feeDetail = DB::table('fees')->where(['studentId'=>$student->studentId , 'feeYear'=>$year , 'feeMonth'=>$month])->first();

        if($feeDetail!=null){
            if($feeDetail->paymentStatus == 'p'){
                Session::put('status', "failure");
                Session::put('msg', $studentDetail->fName . " "  . $studentDetail->mName . " "  . $studentDetail->lName  . " " . "Fees for " . $month . " " . $year . " already paid.");
                return redirect('admin-feeCollectionView');
            }
            else{
                if($feeDetail->paymentStatus == 'i'){
                    $paidFees = $feeDetail->paidAmount +$paidFees;
                }
                if ($paidFees >= $studentDetail->tuitionFees ){
                    $paymentStatus = 'p';
                }
                else{
                    $paymentStatus = 'i';

                }
                $feeDetail = DB::table('fees')->where(['studentId'=>$student->studentId , 'feeYear'=>$year , 'feeMonth'=>$month])->update(['paidAmount' => $paidFees, 'paidOn' => date('Y-m-d H:i:s'), 'paymentStatus' => $paymentStatus]);
                Session::put('status', "success");
                Session::put('msg', $studentDetail->fName . " "  . $studentDetail->mName . " "  . $studentDetail->lName  . " " . "Fees for " . $month . " " . $year . " Paid Successfully.");
                return redirect('admin-feeCollectionView');
            }
        }
        else{
            Session::put('status', "failure");
            Session::put('msg', "Fees not paid");
            return redirect('admin-feeCollectionView');
        }
    }


    function payStudentFeeByFeeId(Request $request){
        $feeId = $request->get('feeId');
        $feeDetail = DB::table('fees')->where(['feeId'=>$feeId ])->first();
        if(DB::table('fees')->where(['feeId'=>$feeId ])->update(['paidAmount' => $feeDetail->feesAmount, 'paidOn' => date('Y-m-d H:i:s'), 'paymentStatus' => 'p'])){
            return response()->json("Successful", 200);
        }
        return response()->json("Failure", 500);
    }
}
