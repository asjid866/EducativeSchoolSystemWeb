@extends('educativeBase')

@section('title', 'Admin-Login')

@section('styleLinks')

@endsection




@section('style')
    <style>
        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            /*width: 50%;*/
        }

    </style>

@endsection


@section('content')

    <div class="container" style="padding-left: 10%; padding-right: 10%; padding-top: 5%;padding-bottom: 10%; ">

        <div class="col-12">
            <img class="center" style="" src="theme/img/educative-logo.png" height="150" width="150" alt="logo">
        </div>

        <div class="col-12">
            <h1 class="text-center contact-title display-4" style="padding-top: 20px"><strong>Educative Admin Panel</strong></h1>
        </div>

    <form class="text-center border border-light p-5" action="admin-home" method="post">
        @csrf

        <p class="h4 mb-4">Sign in</p>

        <input type="text" name="username" id="defaultLoginFormEmail" class="form-control mb-4" placeholder="User Name">

        <input type="password" name="password" id="defaultLoginFormPassword" class="form-control mb-4"  placeholder="Password">

        <div class="d-flex justify-content-around">
            <div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="defaultLoginFormRemember">
                    <label class="custom-control-label" for="defaultLoginFormRemember">Remember me</label>
                </div>
            </div>
            <div>
                <a href="">Forgot password?</a>
            </div>
        </div>
        <button class="btn btn-info btn-block my-4" type="submit">Sign in</button>
        <p>Not a member?
            <a href="">Register</a>
        </p>
    </form>
    </div>

@endsection

@section('script')
<script type="text/javascript">

</script>

@endsection