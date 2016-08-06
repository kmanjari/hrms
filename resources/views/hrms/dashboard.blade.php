@extends('hrms.layouts.base')

@section('content')

        <!-- -------------- Topbar -------------- -->
<header id="topbar" class="alt">
    <div class="topbar-left">
        <ol class="breadcrumb">
            <li class="breadcrumb-icon">
                <a href="dashboard">
                    <span class="fa fa-home"></span>
                </a>
            </li>
            <li class="breadcrumb-active">
                <a href="dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-link">
                <a href="dashboard">Home</a>
            </li>
            <li class="breadcrumb-current-item">Dashboard</li>
        </ol>
    </div>

</header>
<!-- -------------- /Topbar -------------- -->

<!-- -------------- Content -------------- -->
<section id="content" class="table-layout animated fadeIn">

    <!-- -------------- Column Center -------------- -->
    <div class="chute chute-center">

        <!-- -------------- Quick Links -------------- -->
        <div class="row">
            <div class="col-sm-6 col-xl-3">
                <div class="panel panel-tile">
                    <div class="panel-body">
                        <div class="row pv10">
                            <div class="col-xs-5 ph10">
                                <img src="assets/img/pages/clipart2.png" class="img-responsive mauto" alt=""/></div>
                            <div class="col-xs-7 pl5">
                                <h3 class="text-muted"><a href="{{route('employee-manager')}}"> EMPLOYEE MANAGER</a></h3>
                                {{--<h2 class="fs50 mt5 mbn">385</h2>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="panel panel-tile">
                    <div class="panel-body">
                        <div class="row pv10">
                            <div class="col-xs-5 ph10"><img src="assets/img/pages/clipart0.png"
                                                            class="img-responsive mauto" alt=""/></div>
                            <div class="col-xs-7 pl5">
                                <h3 class="text-muted"> <a href="{{route('total-leave-list')}}"> LEAVE <br /> MANAGER </a></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="panel panel-tile">
                    <div class="panel-body">
                        <div class="row pv10">
                            <div class="col-xs-5 ph10"><img src="assets/img/pages/clipart5.png"
                                                            class="img-responsive mauto" alt=""/></div>
                            <div class="col-xs-7 pl5">
                                <h3 class="text-muted"><a href="{{route('attendance-manager')}}"> ATTENDANCE MANAGER </a></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="panel panel-tile">
                    <div class="panel-body">
                        <div class="row pv10">
                            <div class="col-xs-5 ph10"><img src="assets/img/pages/clipart6.png"
                                                            class="img-responsive mauto" alt=""/></div>
                            <div class="col-xs-7 pl5">
                                <h3 class="text-muted"><a href="{{route('hr-policy')}}"> HR POLICY </a></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>



    {{--<div class="content">
        <div class="row">
                <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12">
                    <a href="/employeelist">
                        <div class="info-box blue-bg">
                          <i class="fa fa-users fa-4x " ></i>
                           <div class="count">Employee Manager</div></br>
                        --}}{{--<div class="title">Employee Manager</div>--}}{{--
                        </div><!--/.info-box-->
                    </a>
                </div><!--/.col-->

                <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12">
                    <a href="/leavelisting">
                         <div class="info-box green-bg">
                           <i class="fa fa-envelope-o fa-4x"></i>
                             <div class="count">Leave Manager</div></br>
                        --}}{{--<div class="title">Leave manager</div>--}}{{--
                         </div><!--/.info-box-->
                    </a>
                </div><!--/.col-->

                <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12">
                    <a href="/attendancelisting">
                       <div class="info-box purple-bg">
                          <i class="fa fa-clock-o fa-4x"></i>
                            <div class="count">Attendance Manager</div></br>
                        --}}{{--<div class="title">Order</div>--}}{{--
                       </div><!--/.info-box-->
                    </a>
                </div><!--/.col-->

                <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12">
                    <a href="/#">
                    <div class="info-box coral-bg">
                        <i class="fa fa-gavel fa-4x"></i>
                        <div class="count">HR Policy</div></br>
                    </div><!--/.info-box-->
                   </a>
                </div><!--/.col-->

            </div><!--/.row-->

        </div>--}}
    @endsection