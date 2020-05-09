@extends('educativeBase')

@section('title', 'New Exam Details')

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
                    <h2 class="contact-title">Select Exam Details</h2>
                </div>
            </div>

            <form id="admissionForm" method="post" action="/admin-addNewExam">
                @csrf

                <div class="row">

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
                                <option selected disabled>Term</option>
                                <option>First Term</option>
                                <option>Second Term</option>
                                <option>Final Term</option>
                            </select>
                        </div>
                    </div>

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
                </div>


                <div class="row">
                    <div class="col-sm-4">
                        <div class="md-form">
                            <label for="class"></label>
                            <select class="custom-select" onchange="classChanged()" id="class" name="class">
                                <option selected disabled>Select Class</option>
                                <option>Play Group</option>
                                <option>Nursury</option>
                                <option>Prep</option>
                                <option>One</option>
                                <option>Two</option>
                                <option>Three</option>
                                <option>Four</option>
                                <option>Five</option>
                                <option>Six</option>
                                <option>Seven</option>
                                <option>Eight</option>
                            </select>
                        </div>
                    </div>


                    <div class="col-sm-4">
                        <div class="md-form">
                            <label for="subject"></label>
                            <select class="custom-select" id="subject" name="subject">
                                <option selected disabled>Subject</option>
                                @foreach($subjects as $subject)
                                    <option>{{ $subject->subjectTitle }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="col-sm-4">
                        <div class="md-form">
                            <label for="paperType"></label>
                            <select class="custom-select" id="paperType" name="paperType">
                                <option selected disabled>Paper/Test Type</option>
                                <option>Written</option>
                                <option>Oral</option>
                                <option>Practicle</option>
                                <option>Spoken</option>
                            </select>
                        </div>
                    </div>
                </div>


                <div style="padding-right: 20px; padding-top: 10px; width: 100%; padding-bottom: 50px;">
                    <button class="center genric-btn primary circle zoom" style = "float: right" onclick="ajexCall()" type = "button">Next</button>
        </div>

        <div class="row" id="markingDetails"></div>


        <hr><hr><hr><hr><hr><hr><hr><hr><hr><hr>

        <div id="studentMarks"> {{-- Student form Jquery --}} </div>

        </form>
    </div>
    </div>


    @include('footer')

@endsection


@section('script')
    <script type="text/javascript">

        function classChanged() {
            $("#studentMarks").html('');
            $("#markingDetails").html('');
        }

        function ajexCall(){
            var $class  = $("#class").val();
            var $term  = $("#term").val();
            var $examType  = $("#examType").val();
            var $subject  = $("#subject").val();
            var $paperType  = $("#paperType").val();
            var $year  = $("#year").val();
            $("#studentMarks").html('');
            $("#markingDetails").html('');

            $studentList = '';
            $totalMarks1 = '';
            $passingMarks1 = '';
            $paperDate1 = '';


            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'POST',
                url:'/admin-getStudentAndMarksByClass',
                data:{
                    class: $class,
                    term : $term,
                    examType : $examType,
                    subject: $subject,
                    paperType: $paperType,
                    year: $year
                },
                success:function(data) {
                    $(data).each(function (index) {

                        if($(this)[0].studentMark != null){
                            $totalMarks1 = $(this)[0].studentMark.totalMarks;
                            $passingMarks1 = $(this)[0].studentMark.passingMarks;
                            $paperDate1 = $(this)[0].studentMark.$paperDate;
                            return false;
                        }
                    });
                    $htmlMarkingDetails = "                    <div class=\"col-sm-4\">\n" +
                        "                        <div class=\"md-form\">\n" +
                        "                            <i class=\"fas fa-copy prefix\"></i>\n" +
                        "                            <input class=\"form-control validate\" name=\"totalMarks\" id=\"totalMarks\" type=\"number\"  value='"+ $totalMarks1 +"'  >\n" +
                        "                            <label class='active' for=\"totalMarks\">Total Marks</label>\n" +
                        "                        </div>\n" +
                        "                    </div>\n" +
                        "\n" +
                        "                    <div class=\"col-sm-4\">\n" +
                        "                        <div class=\"md-form\">\n" +
                        "                            <i class=\"fas fa-check-double prefix\"></i>\n" +
                        "                            <input class=\"form-control validate\" name=\"passingMarks\" id=\"passingMarks\" type=\"number\" value='"+ $passingMarks1 +"' >\n" +
                        "                            <label class='active' for=\"passingMarks\">Passing Marks</label>\n" +
                        "                        </div>\n" +
                        "                    </div>\n" +
                        "\n" +
                        "\n" +
                        "                    <div class=\"col-sm-4\">\n" +
                        "                        <div class=\"md-form\">\n" +
                        "                            <i class=\"fas fa-calendar-alt prefix\"></i>\n" +
                        "                            <input class=\"input--style-2 js-datepicker\" type=\"text\" autocomplete=\"off\" name=\"examDate\" id=\"examDate\" >\n" +
                        "                            <label class='active' for=\"examDate\">Exam Date</label>\n" +
                        "                        </div>\n" +
                        "                    </div>\n";
                    $("#markingDetails").append($htmlMarkingDetails);

                    $html = "                <div class=\"row\" style=\"padding: 10px\">\n" +
                        "                    <div class=\"col-4\">\n" +
                        "                        <h3 class=\"font-weight-bold card-title\">Student Name</h3>\n" +
                        "                    </div>\n" +
                        "                    <div class=\"col-4\">\n" +
                        "                        <h3 class=\"font-weight-bold card-title\">Obtained Marks</h3>\n" +
                        "                    </div>\n" +
                        "                    <div class=\"col-4\">\n" +
                        "                        <h3 class=\"font-weight-bold card-title\">Remarks (Optional)</h3>\n" +
                        "                    </div>\n" +
                        "                </div>\n";
                    $("#studentMarks").append($html);

                    $(data).each(function (index) {

                        $html = "<div class=\"row\" style=\"padding: 20px\">\n" +
                            "                    <div class=\"col-4\">\n";
                        if($(this)[0].mName != null){
                            $html += "<h4 class=\"font-weight-bold card-title\">"+ (index+1) +".    "+ $(this)[0].fName +" "+ $(this)[0].mName +" "+ $(this)[0].lName +"</h4>\n";
                        }
                        else {
                            $html += "<h4 class=\"font-weight-bold card-title\">"+ (index+1) +".    "+ $(this)[0].fName +" "+ $(this)[0].lName +"</h4>\n";
                        }
                        $html +=  "                    </div>\n" +
                            "                    <div class=\"col-4\">\n" +
                            "                        <input class=\"form-control validate\" name=\"obtainedMarks"+$(this)[0].studentId + "\" id=\"obtainedMarks"+$(this)[0].studentId + "\" type=\"number\" ";
                            if ($(this)[0].studentMark != null){
                                $html+= " value = '"+ $(this)[0].studentMark.obtainedMarks +"'";

                            }
                            $html += ">                    </div>\n" +
                            "                    <div class=\"col-4\">\n" +
                            "                        <input class=\"form-control validate\" name=\"remarks"+$(this)[0].studentId + "\" id=\"remarks"+$(this)[0].studentId + "\" type=\"text\" ";
                        if ($(this)[0].studentMark != null){
                            $html+= " value = '"+ $(this)[0].studentMark.remarks +"'";
                        }
                        $html+= ">\n" +
                            "                    </div>\n" +
                            "                </div><hr>";

                        $("#studentMarks").append($html);

                    });

                    $html = "                                <hr><hr><hr><hr><hr><hr><hr><hr><hr><hr>" +
                        "<div style=\"padding-right: 20px; padding-top: 10px; width: 100%; padding-bottom: 50px;\">\n" +
                        "                    <button class=\"center genric-btn primary circle zoom\" style=\"float: right\" type=\"submit\">Submit</button>\n" +
                        "                </div>\n";

                    $("#studentMarks").append($html);

                }
            });
        }

    </script>
@endsection






