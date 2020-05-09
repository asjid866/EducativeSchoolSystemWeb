
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
                    <h2 class="contact-title">Select Result Details</h2>
                </div>
            </div>

            <form id="admissionForm" method="post" action="/admin-showStudentResult">
                @csrf

                <div class="row">
                    <div class="col-sm-4">
                        <div class="md-form">
                            <label for="class"></label>
                            <select class="custom-select" onchange="classChanged()" id="class" name="class">
                                <option selected disabled>Select Current Class</option>
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

                    <div class="col-sm-4" id="studentList" id="studentList">  {{-- Student List from Javascript--}}   </div>
                </div>


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
                            <label for="resultClass"></label>
                            <select class="custom-select" onchange="" id="resultClass" name="resultClass">
                                <option selected disabled>Select Class for Result</option>
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
                </div>

                <div class="form-group"  style="padding-top: 10px;">
                    <div class="col-12" style="display: inline-block; text-align: right; width: 100%">
                        <button class="center genric-btn primary circle zoom" type="submit" onclick="">Show Result</button>
                    </div>
                </div>




            </form>
        </div>
    </div>


    @include('footer')

@endsection


@section('script')
    <script type="text/javascript">

        function classChanged(){
            var $class  = $("#class").val();
            $("#studentList").html('');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'POST',
                url:'/admin-getStudentByClass',
                data:{
                    class: $class
                },
                success:function(data) {
                    studentDetails = data;
                    $html = "";

                    $html = "                <div class=\"md-form\">\n" +
                        "                    <label for=\"class\"></label>\n" +
                        "                    <select class=\"custom-select\" onchange=\"\" id=\"selectedStudentId\" name=\"selectedStudentId\">\n" +
                        "                        <option selected disabled>Select Student</option>\n";

                    // $("#studentList").append($html);

                    $(data).each(function (index) {
                        if ($(this)[0].mName != null){
                            $html += "<option value='"+ $(this)[0].studentId+ "'>" + $(this)[0].fName +" "+ $(this)[0].mName +" "+ $(this)[0].lName +"</option>";
                        }
                        else {
                            $html += "<option value='"+ $(this)[0].studentId+ "'>" + $(this)[0].fName +" "+ $(this)[0].lName +"</option>";
                        }

                        // $("#studentList").append($html);
                    });

                    $html += "             </select>\n" +
                        "                </div>\n";
                    $("#studentList").append($html);
                }
            });
        }

    </script>
@endsection






