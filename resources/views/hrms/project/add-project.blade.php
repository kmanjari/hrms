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
                        <a href=""> Project </a>
                    </li>
                    <li class="breadcrumb-current-item"> Add Project </li>
                </ol>
            </div>
        </header>
        <!-- -------------- Content -------------- -->
        <section id="content" class="table-layout animated fadeIn">
            <!-- -------------- Column Center -------------- -->
            <div class="chute-affix" data-spy="affix" data-offset-top="200">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-success">
                            <div class="panel">
                                <div class="panel-heading">
                                    <span class="panel-title hidden-xs"> Add Project </span>
                                </div>

                                <div class="panel-body pn">
                                    <div class="table-responsive">
                                        <div class="panel-body p25 pb10">

                                            @if(Session::has('flash_message'))
                                                <div class="alert alert-success">
                                                    {{ Session::get('flash_message') }}
                                                </div>
                                            @endif
                                            {{--<form class="form-horizontal" role="form">--}}
                                            {!! Form::open(['class' => 'form-horizontal']) !!}
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Project Name </label>
                                                <div class="col-md-6">
                                                    <input type="text" placeholder="project name..." name="project_name"
                                                           id="input002" value="{{ isset($result) ? $result->name : '' }}" class="select2-single form-control" required>
                                                </div>
                                            </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"> Description </label>
                                                    <div class="col-md-6">

                                                        @if(\Route::getFacadeRoot()->current()->uri() == 'edit-project/{id}')
                                                            <textarea class="select2-single form-control" rows="3" id="textarea1" name="description" required>
                                                                @if($result && $result->description){{$result->description}}
                                                                @endif</textarea>
                                                        @else
                                                            <textarea class="select2-single form-control" rows="3" id="textarea1" placeholder="Project Description" name="description" required></textarea>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group code-group">
                                                    <label class="col-md-3 control-label"> Code </label>
                                                    <div class="col-md-6">
                                                        <input type="text" name="code" id="code" value="{{ isset($result) ? $result->code : '' }}" class="select2-single form-control" placeholder="Code" required>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"> Select Client </label>
                                                    <div class="col-md-6">
                                                        {!! Form::select('client_id', $clients, null, ['class' => 'selectpicker form-control', 'data-done-button' => 'true']) !!}
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-2"><a href="/add-project" >
                                                        <input type="submit" class="btn btn-bordered btn-info btn-block" value="Submit"></a>
                                                </div>
                                                <div class="col-md-2"><a href="/add-project" >
                                                        <input type="button" class="btn btn-bordered btn-success btn-block" value="Reset"></a></div>
                                            </div>
                                            {!! Form::close() !!}
                                            {{--</form>--}}
                                        </div>
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
