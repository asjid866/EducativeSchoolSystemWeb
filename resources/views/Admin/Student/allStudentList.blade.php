@extends('educativeBase')

@section('title', 'Student Details')

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
                    <h2 class="contact-title">Student Details</h2>
                </div>
            </div>

            <table id="dtBasicExample" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="th-sm">Student Name
                    </th>
                    <th class="th-sm">Class
                    </th>
                    <th class="th-sm">Father Name
                    </th>
                    <th class="th-sm">Phone No
                    </th>
                    <th class="th-sm">Address
                    </th>
                    <th class="th-sm">Date Of Birth
                    </th>
                    <th class="th-sm">Father CNIC
                    </th>
                    <th class="th-sm">Father Occupation
                    </th>
                    <th class="th-sm">Date of Addmission
                    </th>

                    <th class="th-sm">Fee Details
                    </th>

                    <th class="th-sm">Payment Details
                    </th>

                    <th class="th-sm">Exam Details
                    </th>

                </tr>
                </thead>
                <tbody>
                @foreach($studentDetails as $student)
                    <tr class="zoom-small">
                        <td><strong><form id="{{ 'form'.$student->studentId }}" method="post" action="\admin-studentDetails">@csrf<a onclick="formSubmission('form'.concat({{$student->studentId}}) )">{{ $student->fName . ' ' . $student->mName . ' ' . $student->lName  }}</a> <input hidden name="studentId" value="{{ $student->studentId }}"> </form></strong></td>
                        {{--                        <td>{{ $student->fName . ' ' . $student->mName . ' ' . $student->lName  }}</td>--}}
                        <td>{{ $student->currentClass  }}</td>
                        <td>{{ $student->fatherName  }}</td>
                        <td>{{ $student->phoneNo1 . ' , ' . $student->phoneNo2  }}</td>
                        <td>{{ $student->address  }}</td>
                        <td>{{ date('d-M-Y', strtotime($student->dob))   }}</td>
                        <td>{{ $student->fatherCnic  }}</td>
                        <td>{{ $student->fatherOccupation  }}</td>
                        <td>{{ date('d-M-Y', strtotime($student->DateOfAdmission))   }}</td>

                        <td><form method="post" action="\admin-studentFeeDetails">@csrf<input hidden name="studentId"  value="{{ $student->studentId }}"> <button class="btn-sm btn-primary" type="submit">Fees</button> </form> </td>
                        <td><form method="post" action="\admin-studentPaymentDetails">@csrf<input hidden name="studentId"  value="{{ $student->studentId }}"> <button class="btn-sm btn-warning" type="submit">Payment</button> </form> </td>
                        <td><form method="post" action="\admin-studentExamDetails">@csrf<input hidden name="studentId"  value="{{ $student->studentId }}"> <button class="btn-sm btn-info" type="submit">Exams</button> </form> </td>

                    </tr>
                @endforeach



                </tbody>
                <tfoot>
                <tr>
                    <th class="th-sm">Student Name
                    </th>
                    <th class="th-sm">Class
                    </th>
                    <th class="th-sm">Father Name
                    </th>
                    <th class="th-sm">Phone No
                    </th>
                    <th class="th-sm">Address
                    </th>
                    <th class="th-sm">Date Of Birth
                    </th>
                    <th class="th-sm">Father CNIC
                    </th>
                    <th class="th-sm">Father Occupation
                    </th>
                    <th class="th-sm">Date of Addmission
                    </th>

                    <th class="th-sm">Fee Details
                    </th>
                    <th class="th-sm">Payment Details
                    </th>
                    <th class="th-sm">Exam Details
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

    </script>
@endsection






