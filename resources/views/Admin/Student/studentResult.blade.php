@extends('educativeBase')

@section('title', 'Student Payment Details')

@section('style')
    <style>

    </style>


@endsection

@include('Admin/adminHeader')


@section('content')


    <div class="container" style="padding-bottom: 50px; padding-top: 70px">

        <div style="height:150px; width:100%; clear:both;"></div>

        <div>
            <div class="row">
                <div class="col-6">
                    <h3><strong>Name: &nbsp; {{ $studentDetails->fName . ' ' . $studentDetails->mName . ' ' . $studentDetails->lName  }} </strong></h3>
                </div>
                <div class="col-6">
                    <h5 style="text-align: right"><strong>Result Date: &nbsp; {{ date('d-M-Y', strtotime($studentResult->resultDate)) }}</strong></h5>
                </div>
            </div>

            <div class="row" style="padding-top: 10px">
                <div class="col-12">
                    <h3><strong>Class: &nbsp; {{ $studentResult->class }} </strong></h3>
                </div>
            </div>


            <div class="row" style=" margin-top: -10px;">
                <div class="col-12">
                    <h2 class="contact-title" style="text-align: center"><strong>{{ $studentResult->term }} Result</strong></h2>
                </div>
            </div>
        </div>


        <div style=" margin-top: -10px;">
            <table  style="border:3px solid black;" class="table table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="th-sm" style="font-size: 20px; border: 2px solid black; text-align: center"><strong>Subject</strong>
                    </th>
                    <th class="th-sm" style="font-size: 20px; border: 2px solid black; text-align: center"><strong>Total Marks</strong>
                    </th>
                    <th class="th-sm" style="font-size: 20px; border: 2px solid black; text-align: center"><strong>Passing Marks</strong>
                    </th>
                    <th class="th-sm" style="font-size: 20px; border: 2px solid black; text-align: center"><strong>Obtained Marks</strong>
                    </th>
                    <th class="th-sm" style="font-size: 20px; border: 2px solid black; text-align: center"><strong>Percentage</strong>
                    </th>
                    <th class="th-sm" style="font-size: 20px; border: 2px solid black; text-align: center"><strong>Status</strong>
                    </th>
                </tr>
                </thead>
                <tbody>

                @foreach($results as $result)
                    <tr style="border: 2px solid black;">
                        <td style="font-size: 17px;border: 2px solid black; text-align: center"><strong>{{ $result['subject'] }}</strong></td>
                        <td style="font-size: 17px;border: 2px solid black; text-align: center"><strong>{{ $result['totalMarks'] }}</strong></td>
                        <td style="font-size: 17px;border: 2px solid black; text-align: center"><strong>{{ $result['passingMarks'] }}</strong></td>
                        <td style="font-size: 17px;border: 2px solid black; text-align: center"><strong>{{ $result['obtainedMarks'] }}</strong></td>
                        <td style="font-size: 17px;border: 2px solid black; text-align: center"><strong>{{ $result['percentage'] }} %</strong></td>
                        <td style="font-size: 17px;border: 2px solid black; text-align: center"><strong>{{ $result['passStatus'] }}</strong></td>
                    </tr>
                @endforeach

                <tr style="border: 2px solid black;">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr style="border: 2px solid black;">
                    <td style="font-size: 25px;border: 2px solid black; text-align: center"><strong>Total</strong></td>
                    <td style="font-size: 25px;border: 2px solid black; text-align: center"><strong>{{ $studentResult->totalMarks }}</strong></td>
                    <td style="font-size: 25px;border: 2px solid black; text-align: center"><strong>{{ $studentResult->passingMarks }}</strong></td>
                    <td style="font-size: 25px;border: 2px solid black; text-align: center"><strong>{{ $studentResult->obtainedMarks }}</strong></td>
                    <td style="font-size: 25px;border: 2px solid black; text-align: center"><strong>{{ $studentResult->percentage }} %</strong></td>
                    <td style="font-size: 25px;border: 2px solid black; text-align: center"><strong>{{ $studentResult->passStatus == 1 ?'Pass' : 'Fail' }}</strong></td>
                </tr>

                </tbody>
                <tfoot>
                </tfoot>
            </table>


            <div style="padding-left: 70px; margin-top: -15px;">
                <table class="table" style="border-color: transparent; ">
                    <tr>
                        <td style="border-color: transparent;"><h4><strong>  </strong></h4></td>
                        <td style="border-color: transparent;"><h4><strong>Grade: &nbsp; {{ $studentResult->grade }} </strong></h4></td>
                        <td style="border-color: transparent;"><h4><strong>Position in Class: &nbsp; {{ $studentResult->position }} </strong> </h4></td>
                    </tr>
                    <tr>
                        <td style="border-color: transparent;"><h4><strong>Attendance: &nbsp; {{ ($studentResult->attendedDays  /  $studentResult->totalAttendanceDays) * 100 }} %   </strong> </h4></td>
                        <td style="border-color: transparent;"><h4><strong>Neatness: &nbsp; {{ $studentResult->neatnessMarks }} / 10</strong> </h4></td>
                        <td style="border-color: transparent;"><h4><strong>Behaviour: &nbsp; {{ $studentResult->behaviourMarks }} / 10</strong> </h4></td>
                    </tr>

                    <tr aria-colspan="3">
                        <td style="border-color: transparent"><h4><strong>Teacher Remarks: &nbsp; {{ $studentResult->remarks }} </strong> </h4></td>
                    </tr>

                    <tr>
                        <td style="border-color: transparent"><h4><strong>Teacher's Sign.:_________________________</strong> </h4></td>
                        <td style="border-color: transparent"><h4><strong>Principal Sign.:_________________________</strong> </h4></td>
                        <td style="border-color: transparent"><h4><strong>Parent's Sign.:_________________________</strong> </h4></td>
                    </tr>

                </table>

                {{--<table class="table" style="border-color: transparent; margin-top: -20px;">--}}
                {{--<tr aria-colspan="3">--}}
                {{--<td style="border-color: transparent"><h4><strong>Teacher Remarks: &nbsp; {{ $studentResult->remarks }} </strong> </h4></td>--}}
                {{--</tr>--}}
                {{--</table>--}}

                {{--<table class="table" style="border-color: transparent; margin-top: -20px;">--}}
                {{--<tr>--}}
                {{--<td style="border-color: transparent"><h4><strong>Teacher's Sign.:_________________________</strong> </h4></td>--}}
                {{--<td style="border-color: transparent"><h4><strong>Principal Sign.:_________________________</strong> </h4></td>--}}
                {{--<td style="border-color: transparent"><h4><strong>Parent's Sign.:_________________________</strong> </h4></td>--}}
                {{--</tr>--}}
                {{--</table>--}}

            </div>

        </div>


        @endsection

        @section('script')
            <script type="text/javascript">


            </script>
@endsection






