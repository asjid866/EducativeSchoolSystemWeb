@extends('educativeBase')

@section('title', 'New Admission Form')

@section('style')
@endsection

@include('Admin/adminHeader')


@section('content')


    <div class="container-fluid">
        {{--style="background-color: #0A0264;"--}}

    <div class="container" style="padding: 20px">

        {{--style="background-color: #5AB7F3;"--}}
            {{--<div class="form-background">--}}


            <div class="col-lg-12 border border-primary rounded" style="padding: 30px">


                <div class="row" style="padding: 20px">
                    <div class="col-12">
                        <h2 class="contact-title">Add New Admission Details</h2>
                    </div>
                </div>




                <form id="admissionForm" method="post" action="/admin-insertNewAdmission">
                    @csrf

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="md-form">
                                <i class="fas fa-user prefix"></i>
                                <input class="form-control validate" name="fName" id="fName" type="text" required>
                                <label for="fName">First Name</label>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="md-form">
                                <i class="fas fa-user prefix"></i>
                                <input class="form-control validate" name="mName" id="mName" type="text">
                                <label for="mName">Middle Name</label>
                            </div>


                        </div>
                        <div class="col-sm-4">
                            <div class="md-form">
                                <i class="fas fa-user prefix"></i>
                                <input class="form-control validate" name="lName" id="lName" type="text" required>
                                <label for="lName">Last Name</label>
                            </div>
                        </div>
                    </div>


                    {{--///////////////////////////////////////////////////////////////////////////////////////////////--}}


                    <div class="row">
                        <div class="col-sm-4">
                            <div class="md-form">
                                <i class="fas fa-user prefix"></i>
                                <input class="form-control validate" name="fatherName" id="fatherName" type="text" required>
                                <label for="fatherName">Father Name</label>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="md-form">
                                <i class="fas fa-address-card prefix"></i>
                                <input class="form-control validate" name="fatherCnic" id="fatherCnic" type="number" maxlength="13">
                                <label for="fatherCnic">Father Cnic</label>
                            </div>


                        </div>
                        <div class="col-sm-4">
                            <div class="md-form">
                                <i class="fas fa-briefcase prefix"></i>
                                <input class="form-control validate" name="fatherOccupation" id="fatherOccupation" type="text">
                                <label for="fatherOccupation">Father Occupation</label>
                            </div>
                        </div>
                    </div>

                    {{--///////////////////////////////////////////////////////////////////////////////////////////////--}}

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="md-form">
                                <i class="fas fa-phone prefix"></i>
                                <input class="form-control validate" name="phoneNo1" id="phoneNo1" type="number" maxlength="11" >
                                <label for="phoneNo1">Enter Phone No. 1</label>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="md-form">
                                <i class="fas fa-phone prefix"></i>
                                <input class="form-control validate" name="phoneNo2" id="phoneNo2" type="number" maxlength="11">
                                <label for="phoneNo2">Enter Phone No. 2</label>
                            </div>
                        </div>
                    </div>

                    {{--///////////////////////////////////////////////////////////////////////////////////////////////--}}

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="md-form">
                                <i class="fas fa-map-marker-alt prefix"></i>
                                <input class="form-control validate" name="address" id="address" type="text">
                                <label for="address">Address</label>
                            </div>
                        </div>
                    </div>


                    {{--///////////////////////////////////////////////////////////////////////////////////////////////--}}
                    {{--<div class="input-group">--}}
                        {{--<input class="input--style-2 js-datepicker" type="text" placeholder="Birthdate" name="birthday">--}}
                        {{--<i class="zmdi zmdi-calendar-note input-icon js-btn-calendar"></i>--}}
                    {{--</div>--}}



                    <div class="row">
                        <div class="col-sm-4">
                            <div class="md-form">
                                <i class="fas fa-calendar-alt prefix"></i>
                                <input class="input--style-2 js-datepicker" type="text" autocomplete="off" name="dob" id="dob">
                                <label for="dob">Date of Birth</label>
                            </div>
                        </div>


                        <div class="col-sm-4">
                            <div class="md-form">
                                <label for="class"></label>
                                <select class="custom-select" id="admissionInClass" name="admissionInClass" required>
                                    <option selected disabled>Admission In Class</option>
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


                        {{--<div class="col-sm-4">--}}
                            {{--<div class="md-form">--}}
                                {{--<i class="fas fa-school prefix"></i>--}}
                                {{--<input class="form-control validate" name="admissionInClass" id="admissionInClass" type="number">--}}
                                {{--<label for="admissionInClass">Admission In Class</label>--}}
                            {{--</div>--}}
                        {{--</div>--}}


                        <div class="col-sm-4">
                            <div class="md-form">
                                <i class="fas fa-calendar-alt prefix"></i>
                                <input class="input--style-2 js-datepicker" type="text" autocomplete="off" name="dateOfAdmission" id="dateOfAdmission" required>
                                <label for="dateOfAdmission">Date Of Admission</label>
                            </div>
                        </div>
                    </div>


                    {{--///////////////////////////////////////////////////////////////////////////////////////////////--}}

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="md-form">
                                <i class="fas fa-coins prefix"></i>
                                <input class="form-control validate" name="admissionFees" id="admissionFees" type="number" maxlength="4">
                                <label for="admissionFees">Admission Fees</label>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="md-form">
                                <i class="fas fa-coins prefix"></i>
                                <input class="form-control validate" name="tutionFees" id="tutionFees" type="number" required min="100" maxlength="4">
                                <label for="tutionFees">Monthly Fees</label>
                            </div>


                        </div>
                        {{--<div class="col-sm-4">--}}
                            {{--<div class="md-form">--}}
                                {{--<i class="fas fa-coins prefix"></i>--}}
                                {{--<input class="form-control validate" name="security" id="security" type="number">--}}
                                {{--<label for="security">Security</label>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>


                    {{--///////////////////////////////////////////////////////////////////////////////////////////////--}}

                    <div class="row">


                        {{--<div class="col-sm-4">--}}
                            {{--<div class="md-form">--}}
                                {{--<label for="class"></label>--}}
                                {{--<select class="custom-select" id="startMonth" name="startMonth">--}}
                                    {{--<option selected disabled>Select Start Month</option>--}}
                                    {{--<option>January</option>--}}
                                    {{--<option>February</option>--}}
                                    {{--<option>March</option>--}}
                                    {{--<option>April</option>--}}
                                    {{--<option>May</option>--}}
                                    {{--<option>June</option>--}}
                                    {{--<option>July</option>--}}
                                    {{--<option>August</option>--}}
                                    {{--<option>September</option>--}}
                                    {{--<option>October</option>--}}
                                    {{--<option>November</option>--}}
                                    {{--<option>December</option>--}}
                                {{--</select>--}}
                            {{--</div>--}}
                        {{--</div>--}}



                        {{--<div class="col-sm-4">--}}
                            {{--<div class="md-form">--}}
                                {{--<i class="fas fa-calendar-alt prefix"></i>--}}
                                {{--<input class="input--style-2 js-datepicker" type="text" autocomplete="off" name="startMonth" id="startMonth">--}}
                                {{--<i class="zmdi zmdi-calendar-note input-icon js-btn-calendar"></i>--}}
                                {{--<label for="startMonth">Start Month</label>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>

                    {{--///////////////////////////////////////////////////////////////////////////////////////////////--}}



                        <div class="form-group"  style="padding-top: 30px;">
                            <div class="col-12" style="display: inline-block; text-align: right; width: 100%">
                                <a class="center genric-btn primary circle zoom" onclick="validateFormandSubmit()">Submit</a>
                            </div>
                        </div>

                </form>
            </div>
            </div>
        </div>



@include('footer')

@endsection


@section('script')
    <script type="text/javascript">

        function validateFormandSubmit() {
            if ($("#fName").val == '' || $("#fName").val().length < 4){
                showWrongInput("Error in First Name")
            }
            else if( $("#lName").val() == '' || $("#lName").val().length < 5){
                showWrongInput("Error in Last Name")
            }
            else if( $("#fatherName").val()  == '' || $("#fatherName").val().length < 5){
                showWrongInput("Error in Father Name")
            }
            else if( $("#fatherCnic").val().length > 13 ){
                showWrongInput("Error in Father CNIC")
            }
            else if( $("#dob").val() == '' ){
                showWrongInput("Error in Date of Birth")
            }
            else if(  $("#admissionInClass").val() == null ){
                showWrongInput("Error in admission in class")
            }
            else if(   $("#dateOfAdmission").val()  == '' ){
                showWrongInput("Error in date of admission")
            }
            else if( $("#tutionFees").val()  == '' ){
                showWrongInput("Error in tuition fees")
            }
            else {
                $(admissionForm).submit();
            }
        }

    </script>
@endsection






