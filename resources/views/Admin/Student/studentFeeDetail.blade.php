@extends('educativeBase')

@section('title', 'Student Fee Details')

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
                    <h2 class="contact-title">Student Fee Details</h2>
                </div>
            </div>
            <div class="row" style="padding: 20px">
                <div class="col-12" style="padding-bottom: 10px">
                    <h4 class="">Student Name: <strong>{{ $studentDetails->fName . ' ' . $studentDetails->mName . ' ' . $studentDetails->lName  }}</strong></h4>
                </div>
                <div class="col-12">
                    <h5 class="">Class: <strong>{{ $studentDetails->currentClass  }}</strong></h5>
                </div>
                <div class="col-12" style="display: inline-block; text-align: right; width: 100%; padding-bottom: 10px">
                    <h5 class="">Total Tuition Fees: <strong>{{ $studentDetails->tuitionFees }}</strong></h5>
                </div>

                <div class="col-12" style="display: inline-block; text-align: right; width: 100%">
                    <h5 class="">Total Pending Fees: <strong>{{ $studentDetails->pendingFees  }}</strong></h5>
                </div>
            </div>
            <table id="dtBasicExample" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="th-sm">Year
                    </th>
                    <th class="th-sm">Month
                    </th>
                    <th class="th-sm">Fees Amount
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
                @foreach($studentDetails->feeDetails as $feeDetail)
                    <tr class="zoom-small" @if($feeDetail->paymentStatus == 'p' ) style="background-color: #D3FFBC"  @elseif($feeDetail->paymentStatus == 'i') style="background-color: #FDFFBC" @elseif($feeDetail->paymentStatus == 'n') style="background-color: #FFC0C0" @endif >
                        <td>{{ $feeDetail->feeYear }}</td>
                        <td>{{ $feeDetail->feeMonth }}</td>
                        <td>{{ $feeDetail->feesAmount }}</td>
                        <td>{{ $feeDetail->paidAmount }}</td>
                        <td>{{ $feeDetail->feesAmount - $feeDetail->paidAmount }}</td>
                        <td>{{ $feeDetail->paidOn }}</td>
                        @if($feeDetail->paymentStatus == 'p' )
                            <td>Paid</td>
                        @elseif($feeDetail->paymentStatus == 'i')
                            <td>Incomplete<div style="display: inline-block; text-align: right; width: 50%"><button class="btn-sm btn-primary" onclick="payFeesById({{ $feeDetail->feeId }})">Pay</button></div> </td>
                        @elseif($feeDetail->paymentStatus == 'n')
                            <td>Un paid<div style="display: inline-block; text-align: right; width: 50%"><button class="btn-sm btn-primary" onclick="payFeesById({{ $feeDetail->feeId }})">Pay</button></div> </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th class="th-sm">Year
                    </th>
                    <th class="th-sm">Month
                    </th>
                    <th class="th-sm">Fees Amount
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

        function payFeesById($feeId) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'POST',
                url:'/admin-payStudentFeeByFeeId',
                data:{
                    feeId: $feeId
                },
                success:function(data) {
                    swal("Success", "Fees paid, Please Reload the paid to get Updated", "success");
                },
                error: function () {
                    swal("Failure", "Fees not paid! Internal Error Occurred, Contact Support", "error");
                }
            });
        }

    </script>
@endsection