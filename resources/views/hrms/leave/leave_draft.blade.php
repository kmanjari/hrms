@extends('hrms.layouts.base')

@section('content')
        <!-- START CONTENT -->
<div class="content">

    <!-- Start Page Header -->
    <div class="page-header">

        <h1 class="title">Leave Draft</h1>
        <ol class="breadcrumb">
            <li><a href="/dashboard">DASHBOARD</a></li>
            <li class="active">Leave Draft</li>
        </ol>
    </div>
    {{-- <!-- Start Page Header Right Div -->
     <div class="right">
         <div class="btn-group" role="group" aria-label="...">
             <a href="dashboard" class="btn btn-light">Dashboard</a>
             <a href="#" class="btn btn-light"><i class="fa fa-refresh"></i></a>
             <a href="#" class="btn btn-light"><i class="fa fa-search"></i></a>
         </div>
     </div>
     <!-- End Page Header Right Div -->
--}}

            <!-- End Page Header -->

    <!-- //////////////////////////////////////////////////////////////////////////// -->
    <!-- START CONTAINER -->
    <div class="container-padding">
        @if(session('message'))
            {{session('message')}}
        @endif
        @if(Session::has('flash_message'))
            <div class="alert alert-success">
                {{ session::get('flash_message') }}
            </div>
            @endif
                    <!-- Start Row -->
            {{  Form::open(['files' => 'true']) }}
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-title text-center">
                            <blockquote>Leave Draft</blockquote>
                        </div>
                        </br>
                        <div class="form-horizontal">

                            <div class="form-group">
                                <label for="input002" class="col-sm-2 control-label form-label">Subject</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="subject" placeholder="Enter subject here">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input002" class="col-sm-2 control-label form-label">Body</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" rows="2" id="textarea1" placeholder="apply reason for leave" name="body"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input002" class="col-sm-2 control-label form-label">Leave Type</label>
                                <div class="col-md-10">
                                    <select class ="form-control" name="leave_type">
                                        <option value="null">Select Leave Type</option>
                                        @foreach($leaves as $leave)
                                            <option value="{{$leave->id}}">{{$leave->leave_type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="input002" class="col-sm-2 control-label form-label"></label>
                                <div class="col-md-10">
                                    <input type="submit" class="btn btn-default" value="Submit">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
    </div>
</div>

<!-- ================================================
jQuery Library
================================================ -->
<script type="text/javascript" src="js/jquery.min.js"></script>

<!-- ================================================
Bootstrap Core JavaScript File
================================================ -->
<script src="js/bootstrap/bootstrap.min.js"></script>

<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="js/plugins.js"></script>

<!-- ================================================
Bootstrap Select
================================================ -->
<script type="text/javascript" src="js/bootstrap-select/bootstrap-select.js"></script>

<!-- ================================================
Bootstrap Toggle
================================================ -->
<script type="text/javascript" src="js/bootstrap-toggle/bootstrap-toggle.min.js"></script>

<!-- ================================================
Moment.js
================================================ -->
<script type="text/javascript" src="js/moment/moment.min.js"></script>

<!-- ================================================
Bootstrap Date Range Picker
================================================ -->
<script type="text/javascript" src="js/date-range-picker/daterangepicker.js"></script>


<!-- Basic Date Range Picker -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#date-range-picker').daterangepicker(null, function (start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
        });
    });
</script>

<!-- Basic Single Date Picker -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#date-picker1').daterangepicker({singleDatePicker: true}, function (start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#date-picker2').daterangepicker({singleDatePicker: true}, function (start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
        });
    });
</script>



<!-- Date Range and Time Picker -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#date-range-and-time-picker').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            format: 'MM/DD/YYYY h:mm A'
        }, function (start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
        });
    });
</script>

@endsection