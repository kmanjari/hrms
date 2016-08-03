@extends('hrms.layouts.base')

@section('content')
        <!-- START CONTENT -->
<div class="content">

    <header id="topbar" class="alt">
        <div class="topbar-left">
            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-asset-assignment/{id}')
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
                        <a href=""> Assets </a>
                    </li>
                    <li class="breadcrumb-current-item"> Edit {{$assets->name}} </li>
                </ol>


            @else
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
                    <a href=""> Assets </a>
                </li>
                <li class="breadcrumb-current-item"> Assign Assets </li>
            </ol>
            @endif
        </div>
    </header>
    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn" >
        <!-- -------------- Column Center -------------- -->
        <div class="chute-affix" data-spy="affix" data-offset-top="200">
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel">
                        <div class="panel-heading">
                            @if(\Route::getFacadeRoot()->current()->uri() == 'editassetassignment/{id}')
                                <span class="panel-title hidden-xs"> Edit Asset Assignment </span>
                            @else
                                <span class="panel-title hidden-xs"> Assign Asset</span>
                            @endif
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
                                                <select class="select2-multiple form-control select-primary"
                                                        name="emp_id">
                                                    <option value="" selected>Select One</option>
                                                    @foreach($emps as $emp)
                                                        <option value="{{$emp->id}}">{{$emp->emp_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> Select Asset </label>
                                            <div class="col-md-6">
                                                <select class="select2-multiple form-control select-primary"
                                                        name="asset_id">
                                                    <option value="" selected>Select One</option>
                                                    @foreach($assets as $asset)
                                                        <option value="{{$asset->id}}">{{$asset->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                        <label for="datepicker1" class="col-md-3 control-label"> Date of Assignment </label>
                                            <div class="col-md-6">
                                                {{--@if(\Route::getFacadeRoot()->current()->uri() == 'edit-assignment/{id}')
                                                <input type="date" id="datepicker1" class="select2-single form-control" name="doa" value="@if($emps && $emps->doa){{$emps->doa}}@endif"/>
                                                @else
                                                <input type="date" id="datepicker1" class="select2-single form-control" name="doa"/>
                                                @endif--}}
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        @if(\Route::getFacadeRoot()->current()->uri() == 'edit-assignment/{id}')
                                                        <input type="text" id="datepicker1" class="select2-single form-control" name="doa" value="@if($emps && $emps->doa){{$emps->doa}}@endif"/>
                                                        @else
                                                            <input type="text" id="datepicker1" class="select2-single form-control" name="doa"/>
                                                            @endif
                                                    </div>
                                            </div>
                                            </div>



                                        <div class="form-group">
                                            <label for="datepicker1" class="col-md-3 control-label"> Date of Release </label>
                                            <div class="col-md-6">
                                                {{--@if(\Route::getFacadeRoot()->current()->uri() == 'edit-assignment/{id}')

                                                    <input type="date" id="datepicker1" class="select2-single form-control" name="dor" value="@if($emps && $emps->dor){{$emps->dor}}@endif"/>

                                                @else

                                                    <input type="date" id="datepicker1" class="select2-single form-control" name="dor"/>

                                                @endif--}}
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    @if(\Route::getFacadeRoot()->current()->uri() == 'edit-assignment/{id}')
                                                        <input type="text" id="datepicker4" class="select2-single form-control" name="dor" value="@if($emps && $emps->dor){{$emps->dor}}@endif"/>
                                                    @else
                                                        <input type="text" id="datepicker4" class="select2-single form-control" name="dor"/>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <label class="col-md-3 control-label"></label>
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