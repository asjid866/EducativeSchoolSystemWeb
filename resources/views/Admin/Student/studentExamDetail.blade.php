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
                    <h2 class="contact-title">Student Exam Details</h2>
                </div>
            </div>
            <div class="row" style="padding: 10px">
                <div class="col-12" style="padding-bottom: 20px">
                    <h4 class="">Student Name: <strong>{{ $studentDetails->fName . ' ' . $studentDetails->mName . ' ' . $studentDetails->lName  }}</strong></h4>
                </div>
                <div class="col-12">
                    <h5 class="">Current Class: <strong>{{ $studentDetails->currentClass  }}</strong></h5>
                </div>
            </div>

            {{------------------------------------------------------------------}}

            <form method="post" action="/admin-generateStudentResult">

                @csrf
                <input name="studentId" value="{{ $studentDetails->studentId }}" hidden>

                <div class="col-lg-12 border border-primary rounded" style="padding: 30px">

                    <div class="row" style="padding: 20px">
                        <div class="col-12">
                            <h2 class="contact-title">View Marks</h2>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="md-form">
                                <label for="examType"></label>
                                <select class="custom-select" id="examType" name="examType">
                                    <option selected disabled>Exam Or Test</option>
                                    <option>Test</option>
                                    <option>Paper</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-sm-4">
                            <div class="md-form">
                                <label for="year"></label>
                                <select class="custom-select" id="year" name="year">
                                    <option selected disabled>Select Year</option>
                                    <option>2020</option>
                                    <option>2021</option>
                                    <option>2022</option>
                                    <option>2023</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-sm-4">
                            <div class="md-form">
                                <label for="term"></label>
                                <select class="custom-select" id="term" name="term">
                                    <option selected disabled>Select Term</option>
                                    <option>First Term</option>
                                    <option>Second Term</option>
                                    <option>Final Term</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-12" style="display: inline-block; text-align: right; width: 100%">
                        <a class="center genric-btn primary circle zoom" onclick="getMarksList()">View Marks</a>
                    </div>
                </div>


                <div id="examMarksList" style="padding-top: 20px">      {{-- Exam details from javascript--}}      </div>

                <div id="resultDiv" class="col-12" style="display: none; text-align: right; width: 100%">

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="md-form">
                                <i class="fas fa-calendar-alt prefix"></i>
                                <input class="input--style-2 js-datepicker" type="text" autocomplete="off" name="resultDate" id="resultDate">
                                <label for="resultDate">Result Date</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="md-form">
                                <i class="fas fa-coins prefix"></i>
                                <input class="form-control validate" name="totalAttendanceDays" id="totalAttendanceDays" type="number">
                                <label for="totalAttendanceDays">Total Attendance Days</label>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="md-form">
                                <i class="fas fa-coins prefix"></i>
                                <input class="form-control validate" name="attendedDays" id="attendedDays" type="number">
                                <label for="attendedDays">Attended Days</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-sm-4">
                            <div class="md-form">
                                <i class="fas fa-coins prefix"></i>
                                <input class="form-control validate" name="neatnessMarks" id="neatnessMarks" type="number" max="10" min="1">
                                <label for="neatnessMarks">Neatness Marks</label>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="md-form">
                                <i class="fas fa-coins prefix"></i>
                                <input class="form-control validate" name="behaviourMarks" id="behaviourMarks" type="number" max="10" min="1">
                                <label for="behaviourMarks">Behaviour Marks</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-sm-12">
                            <div class="md-form">
                                <i class="fas fa-coins prefix"></i>
                                <input class="form-control validate" name="finalRemarks" id="finalRemarks" type="text">
                                <label for="finalRemarks">Final Remarks</label>
                            </div>
                        </div>
                    </div>

                    <button id="" class="center genric-btn primary circle zoom" type="submit">Generate Result</button>
                </div>
            </form>
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

        $startTable = " <table id=\"dtBasicExample\" class=\"table table-striped table-bordered\" cellspacing=\"0\" width=\"100%\">\n" +
            "                <thead>\n" +
            "                <tr>\n" +
            "                    <th class=\"th-sm\">Subject\n" +
            "                    </th>\n" +
            "                    <th class=\"th-sm\">Paper / Test Type\n" +
            "                    </th>\n" +
            "                    <th class=\"th-sm\">Exam / Paper Date\n" +
            "                    </th>\n" +
            "                    <th class=\"th-sm\">Total Marks\n" +
            "                    </th>\n" +
            "                    <th class=\"th-sm\">Passing Marks\n" +
            "                    </th>\n" +
            "                    <th class=\"th-sm\">Obtained Marks\n" +
            "                    </th>\n" +
            "                    <th class=\"th-sm\">Pass Status\n" +
            "                    </th>\n" +
            "                    <th class=\"th-sm\">Remarks\n" +
            "                    </th>\n" +
            "                </tr>\n" +
            "                </thead>\n" +
            "                <tbody>\n";

        $endTable = "              </tbody>\n" +
            "                <tfoot>\n" +
            "                <tr>\n" +
            "                    <th class=\"th-sm\">Subject\n" +
            "                    </th>\n" +
            "                    <th class=\"th-sm\">Paper / Test Type\n" +
            "                    </th>\n" +
            "                    <th class=\"th-sm\">Exam / Paper Date\n" +
            "                    </th>\n" +
            "                    <th class=\"th-sm\">Total Marks\n" +
            "                    </th>\n" +
            "                    <th class=\"th-sm\">Passing Marks\n" +
            "                    </th>\n" +
            "                    <th class=\"th-sm\">Obtained Marks\n" +
            "                    </th>\n" +
            "                    <th class=\"th-sm\">Pass Status\n" +
            "                    </th>\n" +
            "                    <th class=\"th-sm\">Remarks\n" +
            "                    </th>\n" +
            "                </tr>\n" +
            "                </tfoot>\n" +
            "            </table>";

        var $subjects = {!! json_encode($subjects->toArray()) !!};
        $staticExamType = ['Written', 'Oral', 'Practicle', 'Spoken'];



        // AJEX Call

        function getMarksList() {
            $studentIId = {!!  $studentDetails->studentId  !!};
            $examType = $("#examType").val();
            $year = $("#year").val();
            $term = $("#term").val();
            $("#resultDiv").hide();


            $selectedPaperType = null;
            $selectedExamType = null;

            $("#examMarksList").html('');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'POST',
                url:'/admin-marksListAjex',
                data:{
                    studentId: $studentIId,
                    examType: $examType,
                    term: $term,
                    year: $year
                },
                success:function(data) {
                    $markList = "";

                    $($subjects).each(function (index) {
                        $selectedSubject = $(this)[0].subjectTitle;
                        $($staticExamType).each(function () {

                            $selectedExamType = this;
                            $(data).each(function (index) {

                                if ($examType == 'Paper'){
                                    $selectedPaperType = $(this)[0].paperType;
                                    $paperDate = getFormattedDate($(this)[0].paperDate);
                                }else {
                                    $selectedPaperType = $(this)[0].testType;
                                    $paperDate = getFormattedDate($(this)[0].testDate);
                                }
                                if($(this)[0].subjectId == $selectedSubject && $selectedPaperType == $selectedExamType ){

                                    $markList += "<tr class='zoom-small'>"
                                        + "<td>" +       $selectedSubject   +   "</td>"
                                        + "<td>" +       $selectedPaperType     +   "</td>"
                                        + "<td>" +           $paperDate    +   "</td>"
                                        + "<td>" +       $(this)[0].totalMarks         +   "</td>"
                                        + "<td>" +       $(this)[0].passingMarks   +   "</td>"
                                        + "<td>" +       $(this)[0].obtainedMarks    +   "</td>";
                                    if($(this)[0].passStatus == 1){
                                        $markList += "<td>Pass</td>";
                                    }
                                    else{
                                        $markList += "<td>Fail</td>";
                                    }
                                    if($(this)[0].remarks == null){
                                        $markList += "<td>No Remarks</td>";
                                    }
                                    else{
                                        $markList += "<td>" +       $(this)[0].remarks       +   "</td>";

                                    }
                                    $markList += "</tr>";
                                }
                            });
                        });
                    });

                    $("#examMarksList").html($startTable.concat($markList).concat($endTable));
                    if ($examType == 'Paper'){
                        $("#resultDiv").show();
                    }
                    $markList = "";
                    $('#dtBasicExample').DataTable({
                        // "scrollX": true,
                        "autoWidth": false,
                        "ordering": false
                    });
                },
                error: function () {
                    swal("Failure", "Internal Error Occurred, Contact Support", "error");
                }
            });
        }


    </script>
@endsection






