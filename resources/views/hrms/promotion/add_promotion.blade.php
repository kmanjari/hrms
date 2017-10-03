@extends('hrms.layouts.base')

@section('content')
    <!-- START CONTENT -->
    <div class="content">

        <input type="hidden" value="{{csrf_token()}}" id="token">

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
                            <a href=""> Promotion </a>
                        </li>
                        <li class="breadcrumb-current-item"> Promote  </li>
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
                                        <span class="panel-title hidden-xs"> Promote </span>
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
                                                <label class="col-md-3 control-label"> Select Employee </label>
                                                <div class="col-md-6">
                                                    <select class="select2-single form-control select-primary"
                                                            name="emp_id" id="promotion_emp_id" required>
                                                        <option value="" selected>Select One</option>
                                                        @foreach($emps as $emp)
                                                            <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"> Old Designation </label>
                                                    <div class="col-md-6">
                                                            <input type="text" id="old_designation" class="form-control" name="old_designation" readonly required>
                                                    </div>
                                                </div>



                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Select New Designation </label>
                                                <div class="col-md-6">
                                                    <select class="select2-multiple
                                                    form-control select-primary"
                                                            name="new_designation" required>
                                                        <option value="" selected>Select One</option>
                                                        @foreach($roles as $role)
                                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>


                                                <div class="form-group">
                                                    <label for="datepicker1" class="col-md-3 control-label"> Old Salary </label>
                                                    <div class="col-md-6">
                                                            <input type="text" id="old_salary" class="form-control" name="old_salary" readonly required>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="datepicker1" class="col-md-3 control-label">Enter New Salary </label>
                                                    <div class="col-md-6">
                                                            <input type="text" id="new_salary" class="form-control" name="new_salary" required>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                <label for="datepicker1" class="col-md-3 control-label"> Date of Promotion </label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar text-alert pr11"></i>
                                                        </div>
                                                            <input type="text" id="datepicker1" class="select2-single form-control" name="date_of_promotion" required>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-2">

                                                    <input type="submit" class="btn btn-bordered btn-info btn-block" value="Submit">
                                                </div>
                                                <div class="col-md-2"><a href="/promotion" >
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
@endsection