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
                        <a href=""> Training </a>
                    </li>
                    <li class="breadcrumb-current-item"> Training Invite </li>
                </ol>
            </div>
        </header>
        <!-- -------------- Content -------------- -->
        <section id="content" class="table-layout animated fadeIn" >
            <!-- -------------- Column Center -------------- -->
            <div class="chute-affix" data-spy="affix" data-offset-top="200">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-success">
                        <div class="panel">
                            <div class="panel-heading">
                                <span class="panel-title hidden-xs"> Training Invite </span>
                            </div>

                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <div class="panel-body p25 pb10">
                                        @if(Session::has('flash_message'))
                                            <div class="alert alert-success">
                                                {{Session::get('flash_message')}}
                                            </div>
                                        @endif
                                        {!! Form::open(['class' => 'form-horizontal']) !!}

                                            <div class="form-group">
                                                <label for="multiselect2" class="col-md-3 control-label"> Select Employees </label>
                                                <div class="col-md-6">
                                                    <select id="done" class="selectpicker form-control" multiple data-done-button="true"
                                                            name="member_ids[]" required>
                                                        @foreach($emps as $emp)
                                                            <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> Select Programs </label>
                                            <div class="col-md-6">
                                                <select class="select2-multiple form-control select-primary"
                                                        name="program_id" required>
                                                    <option value="" selected>Select One</option>
                                                    @foreach($programs as $program)
                                                        <option value="{{$program->id}}">{{$program->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Description </label>
                                                <div class="col-md-6">
                                                    <input type="text" name="description" id="input002" class="select2-single form-control" placeholder="description" required>
                                                </div>
                                            </div>

                                        <div class="form-group">
                                            <label for="datepicker1" class="col-md-3 control-label"> Date From </label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar text-alert pr11"></i>
                                                    </div>
                                                    <input type="text" id="datepicker1" class="select2-single form-control" name="date_from" required>
                                                </div>
                                            </div>
                                        </div>

                                            <div class="form-group">
                                                <label for="datepicker4" class="col-md-3 control-label"> Date To </label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar text-alert pr11"></i>
                                                        </div>
                                                        <input type="text" id="datepicker4" class="select2-single form-control" name="date_to" required>
                                                    </div>
                                                </div>
                                            </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label"></label>
                                            <div class="col-md-2">
                                                <input type="submit" class="btn btn-bordered btn-info btn-block" value="Submit">
                                            </div>
                                            <div class="col-md-2"><a href="/add-training-invite" >
                                                    <input type="button" class="btn btn-bordered btn-success btn-block" value="Reset"></a></div>
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
    @push('styles')
        <link rel="stylesheet" type="text/css" href="/assets/allcp/forms/css/bootstrap-select.css">
    @endpush
@endsection