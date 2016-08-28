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
            @if(Auth::user()->isHR())
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
            @endif
@if(!Auth::user()->isHR())
                <div class="col-sm-6 col-xl-3">
                    <div class="panel panel-tile">
                        <div class="panel-body">
                            <div class="row pv10">
                                <div class="col-xs-5 ph10"><img src="assets/img/pages/clipart0.png"
                                                                class="img-responsive mauto" alt=""/></div>
                                <div class="col-xs-7 pl5">
                                    <h3 class="text-muted"><a href="{{route('my-leave-list')}}"> LEAVES </a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

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
    @endsection