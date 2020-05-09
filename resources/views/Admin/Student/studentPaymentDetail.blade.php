@extends('educativeBase')

@section('title', 'Student Payment Details')

@section('style')
    <style>

    </style>


@endsection

@include('Admin/adminHeader')


@section('content')


    <div class="container-fluid">

        <div style="padding: 50px">


            <div class="row" style="padding: 20px">
                <div class="col-12">
                    <h2 class="contact-title">Student Payment Details</h2>
                </div>
            </div>

            <div class="row" style="padding: 10px">
                <div class="col-12" style="padding-bottom: 20px">
                    <h4 class="">Student Name: <strong>{{ $studentDetails->fName . ' ' . $studentDetails->mName . ' ' . $studentDetails->lName  }}</strong></h4>
                </div>
                <div class="col-12">
                    <h5 class="">Class: <strong>{{ $studentDetails->currentClass  }}</strong></h5>
                </div>
                <div class="col-12" style="display: inline-block; text-align: right; width: 100%">
                    <h5 class="">Total Pending Amount: <strong>{{ $studentDetails->pendingPayment  }}</strong></h5>
                </div>

            </div>




            <table id="dtBasicExample" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="th-sm">Title
                    </th>
                    <th class="th-sm">Applied on
                    </th>
                    <th class="th-sm">Unit Price
                    </th>
                    <th class="th-sm">Quantity
                    </th>
                    <th class="th-sm">Total Price
                    </th>
                    <th class="th-sm">Amount Paid
                    </th>
                    <th class="th-sm">Remaining Amount
                    </th>
                    <th class="th-sm">Payment Date
                    </th>
                    <th class="th-sm">Payment Status
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($studentDetails->paymentDetails as $paymentDetail)
                    <tr class="zoom-small" @if($paymentDetail->paymentStatus == 'p' ) style="background-color: #D3FFBC"  @elseif($paymentDetail->paymentStatus == 'i') style="background-color: #FDFFBC" @elseif($paymentDetail->paymentStatus == 'n') style="background-color: #FFC0C0" @endif >
                        <td>{{ $paymentDetail->title }}</td>
                        <td>{{ $paymentDetail->appliedOn }}</td>
                        <td>{{ $paymentDetail->unitPrice }}</td>
                        <td>{{ $paymentDetail->quantity }}</td>
                        <td>{{ $paymentDetail->quantity * $paymentDetail->unitPrice  }}</td>
                        <td>{{ $paymentDetail->paidAmount }}</td>
                        <td>{{ ($paymentDetail->quantity * $paymentDetail->unitPrice) - $paymentDetail->paidAmount }}</td>
                        <td>{{ $paymentDetail->paidOn }}</td>
                        @if($paymentDetail->paymentStatus == 'p' )
                            <td>Paid</td>
                            @elseif($paymentDetail->paymentStatus == 'i')
                            <td>Incomplete <div style="display: inline-block; text-align: right; width: 50%"><button class="btn-sm btn-primary" onclick="payPaymentById({{ $paymentDetail->studentPaymentId }})">Pay</button></div> </td>
                            @elseif($paymentDetail->paymentStatus == 'n')
                            <td>Un paid<div style="display: inline-block; text-align: right; width: 50%"><button class="btn-sm btn-primary" onclick="payPaymentById({{ $paymentDetail->studentPaymentId }})">Pay</button></div> </td>
                            @endif
                    </tr>
                @endforeach



                </tbody>
                <tfoot>
                <tr>
                    <th class="th-sm">Title
                    </th>
                    <th class="th-sm">Applied on
                    </th>
                    <th class="th-sm">Unit Price
                    </th>
                    <th class="th-sm">Quantity
                    </th>
                    <th class="th-sm">Total Price
                    </th>
                    <th class="th-sm">Amount Paid
                    </th>
                    <th class="th-sm">Remaining Amount
                    </th>
                    <th class="th-sm">Payment Date
                    </th>
                    <th class="th-sm">Payment Status
                    </th>
                </tr>
                </tfoot>
            </table>

        </div>
    </div>


@include('footer')

@endsection


@section('script')
<script type="text/javascript">
    function formSubmission($formId){
        var $idToSubmit = "#".concat($formId);
        $($idToSubmit).submit();
    }


    function payPaymentById($paymentId) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'POST',
            url:'/admin-payStudentPaymentByPaymentId',
            data:{
                paymentId: $paymentId
            },
            success:function(data) {
                swal("Success", "Payment made, Please Reload the paid to get Updated", "success");
            },
            error: function () {
                swal("Failure", "Internal Error Occurred, Contact Support", "error");
            }
        });
    }


</script>
@endsection






