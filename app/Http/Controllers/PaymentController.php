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

class PaymentController extends BaseController
{
    function singleStudentPaymentDetail(Request $request){
        $studentId = $request->get('studentId');
        $student = DB::table('students')->where(['studentId'=>$studentId])->first();

        $studentDetail = DB::table('admissions')->where(['admissionId'=>$studentId])->first();
        $studentDetail->{'currentClass'} = $student->class;
        $studentDetail->{'studentId'} = $student->studentId;

        $paymentDetails = DB::table('studentpayments')->where(['studentId'=>$studentId])->get();
        $studentDetail->{'paymentDetails'} = $paymentDetails;
        $pendingPayment = 0;
        foreach ($paymentDetails as $paymentDetail){
            if ($paymentDetail->paymentStatus == 'i' or $paymentDetail->paymentStatus == 'n'){
                $pendingPayment += (($paymentDetail->quantity * $paymentDetail->unitPrice) - $paymentDetail->paidAmount);
            }
        }
        $studentDetail->{'pendingPayment'} = $pendingPayment;
        return view('Admin/Student/studentPaymentDetail', ['studentDetails'=>$studentDetail]);
    }

    function salesView(){
        $products = DB::table('products')->get();
        return view('Admin/Sales/salesView', ["products"=>$products]);
    }


    function saveStudentSales(Request $request)
    {
//        dump("in save student products controller");die;
        $productCount = $request->get('totalProducts');
        for ($i = 0; $i < $productCount + 1; $i++) {
            $initialId = $i . "-";
            if ($request->get($initialId . "product") == null || $request->get($initialId . "product") == ''){
                continue;
            }
            else{

                $studentpayments = new studentpayments();
                $studentpayments->studentId = $request->get('selectedStudentId');
                $studentpayments->title = $request->get($initialId . "product");
                $studentpayments->quantity = $request->get($initialId . "quantity");
                $studentpayments->unitPrice = $request->get($initialId . "unitPrice");
                $studentpayments->appliedOn = date('Y-m-d H:i:s');
                $studentpayments->paidAmount = $request->get($initialId . "paidAmount");
                $studentpayments->paidOn = date('Y-m-d H:i:s');

                if ($request->get($initialId . "paidAmount") == ($request->get($initialId . "total"))) {
                    $studentpayments->paymentStatus = 'p';
                } elseif ($request->get($initialId . "paidAmount") == 0) {
                    $studentpayments->paymentStatus = 'n';
                } else {
                    $studentpayments->paymentStatus = 'i';
                }
                $studentpayments->save();
            }
        }

        Session::put('status', "success");
        Session::put('msg', "Sales Added Successfully");
        return redirect('admin-salesView');
    }



    function payStudentPaymentByPaymentId(Request $request){
        $paymentId = $request->get('paymentId');
        $paymentDetail = DB::table('studentpayments')->where(['studentPaymentId'=>$paymentId ])->first();
//        dump($paymentDetail);die;
        if(DB::table('studentpayments')->where(['studentPaymentId'=>$paymentId ])->update(['paidAmount' => ($paymentDetail->unitPrice * $paymentDetail->quantity), 'paidOn' => date('Y-m-d H:i:s'), 'paymentStatus' => 'p'])){
            return response()->json("Successful", 200);
        }
        return response()->json("Failure", 500);
    }



}
