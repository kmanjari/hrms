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
                            <a href=""> Assets </a>
                        </li>
                        <li class="breadcrumb-current-item"> Edit Award </li>
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
                                    <span class="panel-title hidden-xs"> Edit Award</span>
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
                                                <label class="col-md-3 control-label"> Award </label>
                                                <div class="col-md-6">
                                                    <input type="text" name="name" id="input002" class="select2-single form-control" value="@if($awards){{$awards->name}}@endif" required>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Description </label>
                                                <div class="col-md-6">
                                                    <textarea class="select2-single form-control" rows="3" id="textarea1" name="description" required>@if($awards && $awards->description){{$awards->description}}@endif </textarea>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-md-3 control-label"></label>
                                                <div class="col-md-2">

                                                    <input type="submit" class="btn btn-bordered btn-info btn-block" value="Submit">

                                                </div>
                                                <div class="col-md-2"><a href="/edit-award/{id}" >
                                                        <input type="button" class="btn btn-bordered btn-success btn-block" value="Reset"></a></div>
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