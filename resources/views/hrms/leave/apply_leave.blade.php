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
                <li class="breadcrumb-current-item"> Apply Leave</li>
            </ol>
        </div>
    </header>
    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn">
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
                                        <label for="date_from" class="col-md-2 control-label"> Date From </label>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" id="datepicker1" class="select2-single form-control"
                                                       name="dateFrom"/>
                                            </div>
                                        </div>
                                        <label for="date_to" class="col-md-2 control-label"> Date To </label>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" id="datepicker4" class="select2-single form-control"
                                                       name="dateTo"/>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="time_from" class=" col-md-2 control-label  "> Time From </label>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="imoon imoon-clock"></i>
                                                </div>
                                                <input type="text" id="timepicker1" class="select2-single form-control "
                                                       name="time_from"/>
                                            </div>
                                        </div>
                                        <label for="time_to" class="col-md-2 control-label"> Time To </label>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="imoon imoon-clock"></i>
                                                </div>
                                                <input type="text" id="timepicker4" class="select2-single form-control"
                                                       name="time_to"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input002" class="col-md-2 control-label"> Days </label>
                                        <div class="col-md-10">
                                            <input id="total_days" name="number_of_days" value="" readonly="readonly"
                                                   type="text" size="90" class="select2-single form-control"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input002" class="col-md-2 control-label"> Reason </label>
                                        <div class="col-md-10">
                                            <input type="text" id="textarea1" class="select2-single form-control"
                                                   name="reason"/>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-2 control-label"></label>
                                        <div class="col-md-2">
                                            <div class="mb20">
                                                <br/> <input type="submit" class="btn btn-bordered btn-info btn-block"
                                                             value="Submit">
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
</div>
@endsection