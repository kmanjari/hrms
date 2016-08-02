@extends('hrms.layouts.base')

@section('content')
        <!-- START CONTENT -->
<div class="content">

    <header id="topbar" class="alt">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="breadcrumb-icon">
                    <a href="/dashboard">
                        <span class="fa fa-home"></span>
                    </a>
                </li>
                <li class="breadcrumb-active">
                    <a href="/dashboard"> Dashboard </a>
                </li>
                <li class="breadcrumb-link">
                    <a href=""> Leave </a>
                </li>
                <li class="breadcrumb-current-item"> Apply Leave </li>
            </ol>
        </div>
    </header>
    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn" >
        <!-- -------------- Column Center -------------- -->
        <div class="chute-affix" data-spy="affix" data-offset-top="200">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title hidden-xs"> Apply for Leave</span>
                        </div>

                        <div class="panel-body pn">
                            <div class="table-responsive">
                                <div class="panel-body p25 pb10">
                                    @if(session('message'))
                                        {{session('message')}}
                                    @endif
                                    @if(Session::has('flash_message'))
                                        <div class="alert alert-success">
                                            {{ session::get('flash_message') }}
                                        </div>
                                    @endif
                                        {!! Form::open(['class' => 'form-horizontal']) !!}


                                        <div class="form-group">
                                            <label class="col-md-2 control-label"> Leave Type </label>
                                            <div class="col-md-10">
                                                <select class="select2-multiple form-control select-primary"
                                                        name="leave_type">
                                                    <option value="" selected>Select One</option>
                                                    @foreach($leaves as $leave)
                                                        <option value="{{$leave->id}}">{{$leave->leave_type}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="datepicker1" class="col-md-2 control-label"> Date From </label>
                                            <div class="col-md-3">


                                                    <input type="date" id="datepicker1" class="select2-single form-control" name="dateFrom"/>

                                            </div>
                                            <label for="datepicker1" class="col-md-2 control-label"> Date To </label>
                                            <div class="col-md-3">

                                                <input type="date" id="datepicker1" class="select2-single form-control" name="dateTo"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="datetimepicker5" class="col-md-2 control-label"> Time From </label>
                                            <div class="col-md-3">
                                                <input type="text"  id="datetimepicker5" class="select2-single form-control" name="dateFrom"/>
                                            </div>
                                            <label for="datetimepicker5" class="col-md-2 control-label"> Time To </label>
                                            <div class="col-md-3">
                                                <input type="text"  id="datetimepicker5" class="select2-single form-control" name="dateTo"/>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="input002" class="col-md-2 control-label"> Days </label>
                                            <div class="col-md-10">

                                                <input id= "total_days" name="number_of_days" value="" readonly="readonly" type="text" size="90" class="select2-single form-control"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="input002" class="col-md-2 control-label"> Reason </label>
                                            <div class="col-md-10">
                                                <input type="text" id="textarea1" class="select2-single form-control" name="reason"/>
                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <label class="col-md-2 control-label"></label>
                                            <div class="col-md-2">
                                                <div class="mb20">
                                                    <br /> <input type="submit" class="btn btn-bordered btn-info btn-block" value="Submit">
                                                </div>
                                            </div>
                                        </div>

                                        {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

</div>
@endsection