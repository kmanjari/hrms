<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Kode is a Premium Bootstrap Admin Template, It's responsive, clean coded and mobile friendly">
    <meta name="keywords" content="bootstrap, admin, dashboard, flat admin template, responsive," />
    <title>Digital IP Insights - HRMS</title>

    <!-- ========== Css Files ========== -->
    <style type="text/css">
        body{background: #F5F5F5;}
    </style>
</head>
<body style="background-image: url('img/bg-9-full.jpg');">

<div class="login-form">
    {!! Form::open() !!}
    <div class="top">
        <img src="{{ URL::asset('assets/img/sipi_7.jpg') }}" alt="icon" class="icon">
        <h1>Digital IP</h1>
        <h4>Human Resource Management System</h4>
    </div>
    <div class="form-area">
        <div class="group">
            <input type="text" class="form-control" placeholder="Username">
            <i class="fa fa-user"></i>
        </div>
        <div class="group">
            <input type="text" class="form-control" placeholder="E-mail">
            <i class="fa fa-envelope-o"></i>
        </div>
        <div class="group">
            <input type="password" class="form-control" placeholder="Password">
            <i class="fa fa-key"></i>
        </div>
        <div class="group">
            <input type="password" class="form-control" placeholder="Password again">
            <i class="fa fa-key"></i>
        </div>
        <button type="submit" class="btn btn-default btn-block">REGISTER NOW</button>
    </div>
    {!! Form::close() !!}
    {{--<div class="footer-links row">
        <div class="col-xs-6"><a href="#"><i class="fa fa-external-link"></i><span style="color:#FFFFFF"> Register Now</span></a></div>
        <div class="col-xs-6 text-right"><a href="#"><i class="fa fa-lock"></i><span style="color:#FFFFFF"> Forgot password</span></a></div>
    </div>--}}
</div>
</body>
</html>