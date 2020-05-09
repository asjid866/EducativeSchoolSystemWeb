<?php

namespace App\Http\Controllers;

use App\Student;
use App\studentpayments;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Admission;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;

class NewAdmissionController extends BaseController
{
//    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    function newAdmission()
    {
        return view('Admin/Student/newAdmissionForm');
    }

    /**
     * @param Request $request
     */
    function insertNewAdmission(Request $request)
    {
        try {
            $newAdmission = new Admission();
            $newAdmission->fName = $request->get('fName');
            $newAdmission->mName = $request->get('mName');
            $newAdmission->lName = $request->get('lName');
            $dob = $request->get('dob');
            $newAdmission->dob = date("Y-m-d", strtotime(str_replace('/', '-', $dob)));
            $newAdmission->admissionInClass = $request->get('admissionInClass');
            $newAdmission->fatherName = $request->get('fatherName');
            $newAdmission->fatherCnic = $request->get('fatherCnic');
            $newAdmission->fatherOccupation = $request->get('fatherOccupation');
            $newAdmission->address = $request->get('address');
            $newAdmission->phoneNo1 = $request->get('phoneNo1');
            $newAdmission->phoneNo2 = $request->get('phoneNo2');

            $dateOfAdmission = $request->get('dateOfAdmission');
            $newAdmission->dateOfAdmission = date("Y-m-d", strtotime(str_replace('/', '-', $dateOfAdmission)));
            $newAdmission->startMonth = $request->get('startMonth');
            $newAdmission->admissionFees = $request->get('admissionFees');
            $newAdmission->tuitionFees = $request->get('tutionFees');
            $newAdmission->securityFees = $request->get('security');
//        $newAdmission->studentPic =  $request->get('fName');
//        $newAdmission->bayFormPic =  $request->get('fName');
//        $newAdmission->birthCertificatePic =  $request->get('fName');
//        $fatherCnicPic =  $request->get('fName');

            $newAdmission->save();

            $newStudent = new Student();
            $newStudent->admissionId = $newAdmission->admissionId;
            $newStudent->class = $request->get('admissionInClass');
            $newStudent->activeStatus = 1;

            $newStudent->save();

            $studentpayments = new studentpayments();
            $studentpayments->studentId = $newStudent->studentId;
            $studentpayments->title = "Admission Fees";
            $studentpayments->quantity = 1;
            $studentpayments->unitPrice = $request->get('admissionFees');
            $studentpayments->appliedOn = date('Y-m-d H:i:s');
            $studentpayments->paymentStatus = 'n';
            $studentpayments->save();

            Session::put('status', "success");
            Session::put('msg', "New Student Successfully added");
            return redirect('/admin-allstudentlist');
        }
        catch(Exception $e){
            Session::put('status', "failure");
            Session::put('msg', "Student not saved! Try Again");
            return redirect()->back();
        }
    }
}

