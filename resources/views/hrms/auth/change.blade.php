@extends('hrms.layouts.base')

@section('content')
    <!-- START CONTENT -->
    <div class="content">


        <!-- -------------- Content -------------- -->
        <section id="content" class="table-layout animated fadeIn" >
            <!-- -------------- Column Center -------------- -->
            <div class="chute-affix" data-spy="affix" data-offset-top="200">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel">
                            <div class="panel-heading">

                                    <span class="panel-title hidden-xs"> Change Password </span>
                            </div>

                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <div class="panel-body p25 pb10">
                                        @if(Session::has('flash_message'))
                                            <div class="alert alert-success">
                                                {{Session::get('flash_message')}}
                                            </div>
                                        @endif
                                        {!! Form::open(['class' => 'form-horizontal', 'id' => 'passwordForm']) !!}

                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> Enter Old Password </label>
                                            <div class="col-md-6">

                                                    <input type="password" name="old" id="old_password" class="select2-single form-control" placeholder="Old password">

                                            </div>
                                        </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Enter New Passowrd </label>
                                                <div class="col-md-6">

                                                    <input type="password" name="new" id="new_password" class="select2-single form-control" placeholder="New password">

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Confirm New Password </label>
                                                <div class="col-md-6">

                                                    <input type="password" name="confirm" id="confirm_password" class="select2-single form-control" placeholder="Confirm password">

                                                </div>
                                            </div>

                                            <div class="form-group">
                                            <label class="col-md-3 control-label"></label>
                                            <div class="col-md-2">

                                                <input type="submit" class="btn btn-bordered btn-info btn-block" value="Submit">
                                            </div>
                                            <div class="col-md-2"><a href="/change-password" >
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

        </section>

    </div>
@endsection