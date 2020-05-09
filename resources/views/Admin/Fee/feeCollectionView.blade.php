@extends('educativeBase')

@section('title', 'Admin-Login')

@section('styleLinks')

@endsection

@section('style')
@endsection

@include('Admin/adminHeader')

@section('content')



    <div class="container" style="padding: 20px">


        <div class="col-lg-12 border border-primary rounded" style="padding: 30px">

            <div class="row" style="padding: 20px">
                <div class="col-12">
                    <h2 class="contact-title">Fee Collection</h2>
                </div>
            </div>


            {{--<h5>Select Class and Student name to pay the fees</h5>--}}


            <form id="studentFeeCollection" action="/admin-payStudentFees" method="post">
                @csrf

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


                    <div class="col-sm-4" id="studentList">  {{-- Student List from Javascript--}}   </div>

                </div>

                <div class="row">
                    <div class="col-sm-12" id="studentFeeDetails">  {{-- Student List from Javascript--}}   </div>
                </div>


                <div style="display: none" id="feeDetails">

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
                                <label for="month"></label>
                                <select class="custom-select" id="month" name="month">
                                    <option selected disabled>Select Month</option>
                                    <option>January</option>
                                    <option>February</option>
                                    <option>March</option>
                                    <option>April</option>
                                    <option>May</option>
                                    <option>June</option>
                                    <option>July</option>
                                    <option>August</option>
                                    <option>September</option>
                                    <option>October</option>
                                    <option>November</option>
                                    <option>December</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-sm-4">
                            <div class="md-form">
                                <i class="fas fa-coins prefix"></i>
                                <input class="form-control validate" name="paidAmount" id="paidAmount" type="number">
                                <label for="paidAmount">Paid Amount</label>
                            </div>
                        </div>

                    </div>


                    <div class="form-group"  style="padding-top: 10px;">
                        <div class="col-12" style="display: inline-block; text-align: right; width: 100%">
                            <button type="submit" class="center genric-btn primary circle zoom">Pay Fees</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>




        <div class="col-lg-12 border border-primary rounded" style="padding: 30px">

            <div class="row" style="padding: 20px">
                <div class="col-12">
                    <h2 class="contact-title">Add Tuition Fees for all Students</h2>
                </div>
            </div>
            <form method="post" action="/admin-addfeeforallstudents">
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
                            <label for="month"></label>
                            <select class="custom-select" id="month" name="month">
                                <option selected disabled>Select Month</option>
                                <option>January</option>
                                <option>February</option>
                                <option>March</option>
                                <option>April</option>
                                <option>May</option>
                                <option>June</option>
                                <option>July</option>
                                <option>August</option>
                                <option>September</option>
                                <option>October</option>
                                <option>November</option>
                                <option>December</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group"  style="padding-top: 10px;">
                    <div class="col-12" style="display: inline-block; text-align: right; width: 100%">
                        <button class="center genric-btn primary circle zoom" type="submit" onclick="">Add Fees</button>
                    </div>
                </div>
            </form>
        </div>
    </div>







@endsection

@section('script')
    <script type="text/javascript">

        var $studentDetails = "";

        function classChanged(){
            var $class  = $("#class").val();
            $("#studentList").html('');
            studentDetails = "";
            $("#studentId").val(' ');
            $("#feeDetails").hide();
            $("#studentFeeDetails").html(' ');


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
                        "                    <select class=\"custom-select\" onchange=\"studentChanged()\" id=\"selectedStudentId\" name=\"selectedStudentId\">\n" +
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


        function studentChanged() {
            $("#studentId").val('');
            var $selectedStudentId  = $("#selectedStudentId").val();
            $("#studentFeeDetails").html('');
            $(studentDetails).each(function (index) {
                if ($(this)[0].studentId == $selectedStudentId){
                    $html = "<div id='totalFeesShow' style=\"float: right\"<h3><strong>Total Tuition Fees = "+ $(this)[0].tuitionFees + "  </strong></h3></div>";
                    $("#feeDetails").show();
                    return $("#studentFeeDetails").html($html);

                }
            });
        }




    </script>
    @include('footer')
@endsection