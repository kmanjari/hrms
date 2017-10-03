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
                        <a href=""> Client </a>
                    </li>
                    <li class="breadcrumb-current-item"> Edit Client</li>
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
                                    <span class="panel-title hidden-xs"> Edit {{$client->name}} </span>
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
                                                <label class="col-md-3 control-label"> Client </label>
                                                <div class="col-md-6">
                                                    <input type="text" name="name" id="input002" class="select2-single form-control" placeholder="Name" value="{{$client->name}}" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Address </label>
                                                <div class="col-md-6">
                                                    <textarea class="select2-single form-control" rows="3" id="address" placeholder="Client Address" name="address">{{$client->address}}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Company </label>
                                                <div class="col-md-6">
                                                    <input type="text" name="company" id="input002" class="select2-single form-control" placeholder="Company" value="{{$client->company}}">
                                                </div>
                                            </div>

                                            <div class="form-group code-group">
                                                <label class="col-md-3 control-label"> Code </label>
                                                <div class="col-md-6">
                                                    <input type="text" name="code" class="select2-single form-control" placeholder="Unique Code" required value="{{$client->code}}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-2">

                                                    <input type="submit" class="btn btn-bordered btn-info btn-block" value="Submit">
                                                </div>
                                                <div class="col-md-2"><a href="/add-client">
                                                        <input type="button" class="btn btn-bordered btn-success btn-block" value="Reset"></a>
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
            </div>
        </section>

    </div>
@endsection