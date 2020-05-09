<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Educative | @yield('title')</title>


    <!-- Styles -->
@yield('styleLinks')
<!-- ------- -->
    <style>


        .zoom {
            padding: 50px;
            /*background-color: green;*/
            transition: transform .2s; /* Animation */
            /*width: 200px;*/
            /*height: 200px;*/
            margin: 0 auto;
        }
        .zoom:hover {
            transform: scale(1.2); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
        }

        .zoom-small {
            padding: 50px;
            /*background-color: green;*/
            transition: transform .2s; /* Animation */
            /*width: 200px;*/
            /*height: 200px;*/
            margin: 0 auto;
        }
        .zoom-small:hover {
            transform: scale(1.01); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
        }
    </style>

@yield('style')

<!-- Fonts and FontAwsomw -->
    {{--<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">--}}
    <link href="css/fontawesome/css/all.css" rel="stylesheet">



    <!-- MDB -->
    <link href="css/mdb/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mdb/css/mdb.min.css" rel="stylesheet">
    <link href="css/mdb/css/style.css" rel="stylesheet">



    {{-- Date time picker--}}
    <link href="css/datepicker/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">
    <link href="css/datepicker/css/main.css" rel="stylesheet" media="all">



    {{-- data tables--}}
    <link href="css/datatables/css/addons/datatables.min.css" rel="stylesheet">


    {{-- Theme CSS--}}
    <link rel="stylesheet" href="theme/css/style.css">

</head>

<body style="background-color: #F6FCFF">



@show
@if( !empty(Session::get('status')) )
    <div class="container">
        @if (Session::get('status') == 'success')
            <div id="successAlert" class="alert alert-success" role="alert" style="width: 100%; padding: 20px">
                <a style="float: right" class="" onclick="$('#successAlert').hide()"><i class="fas fa-times fa-2x" ></i></a>
                <strong><h4>{{  Session::get('msg') }}</h4></strong>
                {{--<div style="display: inline-block; text-align: right; width: 80%"><button type="button" class="btn btn-link" onclick="$('#successAlert').hide()">X</button></div>--}}
            </div>
        @endif

        @if(Session::get('status') == 'failure')
            <div id="failureAlert" class="alert alert-danger" role="alert" style="width: 100%; padding: 20px">
                <a style="float: right" class="" onclick="$('#failureAlert').hide()"><i class="fas fa-times fa-2x" ></i></a>
                {{--<div style="display: inline-block; width: 100%"><button type="button" style="float: right" class="btn btn-link" onclick="$('#failureAlert').hide()">X</button></div>--}}
                <strong><h4>{{  Session::get('msg') }}</h4></strong>
                {{--<button type="button" class="btn btn-link" style="align-self: left" onclick="$('#failureAlert').hide()">X</button>--}}
            </div>
        @endif
    </div>
    {{ Session::forget('status') }}
    {{ Session::forget('msg') }}
@endif

<div class="container">
    <div id="wrongInput" class="alert alert-danger" role="alert" style="width: 100%; padding: 20px; display: none">
        <a style="float: right" class="" onclick="$('#wrongInput').hide()"><i class="fas fa-times fa-2x" ></i></a>
        <div id="wrongInputMsg"> </div>
    </div>
</div>



@yield('content')

</body>

<!-- jquery -->
<script type="text/javascript" src="css/mdb/js/jquery.min.js"></script>
<script type="text/javascript" src="css/mdb/js/popper.min.js"></script>
<script type="text/javascript" src="css/mdb/js/bootstrap.min.js"></script>
<script type="text/javascript" src="css/mdb/js/mdb.min.js"></script>

{{-- Theme Jquery / JavaScript--}}

<script type="text/javascript" src="theme/js/jquery-1.12.1.min.js"></script>
{{--<script type="text/javascript" src="theme/js/jquery.magnific-popup.js"></script>--}}
<script type="text/javascript" src="theme/js/swiper.min.js"></script>
<script type="text/javascript" src="theme/js/isotope.pkgd.min.js"></script>
<script type="text/javascript" src="theme/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="theme/js/jquery.nice-select.min.js"></script>
<script type="text/javascript" src="theme/js/slick.min.js"></script>
<script type="text/javascript" src="theme/js/jquery.counterup.min.js"></script>
<script type="text/javascript" src="theme/js/waypoints.min.js"></script>
<script type="text/javascript" src="theme/js/custom.js"></script>



{{-- date picker--}}
<script src="css/datepicker/vendor/datepicker/moment.min.js"></script>
<script src="css/datepicker/vendor/datepicker/daterangepicker.js"></script>
<script src="css/datepicker/js/global.js"></script>
<script src="css/sweetalerts.js"></script>

{{-- Data Tables--}}
<script type="text/javascript" src="css/datatables/js/addons/datatables.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {

        $('#dtBasicExample').DataTable({
            // "scrollX": true,
            "autoWidth": false
        });
        $('.dataTables_length').addClass('bs-select');
    });

    function GetMonthName(monthNumber) {
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        return months[monthNumber - 1];
    }

    function getFormattedDate(sqldate) {
        $parseDate = new Date(Date.parse(sqldate));
        $returnDate = $parseDate.getDate() + '-' + GetMonthName($parseDate.getMonth()) + '-' + $parseDate.getFullYear();
        return $returnDate;
    }

    function scrollToTop() {
        $(window).scrollTop(0);
    }

    function showWrongInput($errorMsg) {
        $("#wrongInput").show();
        $("#wrongInputMsg").html($errorMsg);
        scrollToTop();
    }



</script>

@yield('script')


</html>
