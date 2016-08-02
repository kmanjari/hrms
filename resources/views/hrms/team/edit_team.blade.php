@extends('hrms.layouts.base')

@section('content')
        <!-- START CONTENT -->
<div class="content">

    <!-- Start Page Header -->
    <div class="page-header">
        <h1 class="title">Edit Team</h1>
        <ol class="breadcrumb">
            <li><a href="/dashboard">Dashboard</a></li>
            {{--<li><a href="#">Forms</a></li>--}}
            <li class="active">Edit {{$edit[0]->name}}</li>
        </ol>
    </div>

    <!-- START CONTAINER -->
    <div class="container-padding">
        @if(Session::has('flash_message'))
            <div class="alert alert-success">
                {{ Session::get('flash_message') }}
            </div>
        @endif
        {{  Form::open(['files' => 'true']) }}
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-title text-center">
                        <blockquote>Edit Team</blockquote>
                    </div>
                    <div class="form-horizontal">

                        <div class="form-group">
                            <label for="input002" class="col-sm-3 control-label form-label">Team Name</label>
                            <div class="col-sm-3">
                                <input type="text" name="team_name" value="{{$edit[0]->name}}" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input002" class="col-sm-3 control-label form-label">Select Team Manager</label>
                            <div class="col-md-8">
                                <select class="selectpicker" data-live-search="true" data-style="btn-primary"
                                        name="manager_id">
                                    <option value="" selected>Select One</option>
                                    @foreach($managers as $manager)
                                        @if($edit[0]->manager->id == $manager->id)
                                            <option value="{{$manager->id}}" selected>{{$manager->emp_name}}</option>
                                        @else
                                            <option value="{{$manager->id}}">{{$manager->emp_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input002" class="col-sm-3 control-label form-label">Select Team Leader</label>
                            <div class="col-md-8">
                                <select class="selectpicker" data-live-search="true" data-style="btn-primary"
                                        name="leader_id">
                                    <option value="" selected>Select One</option>
                                    @foreach($leaders as $leader)
                                        @if($edit[0]->leader->id == $leader->id)
                                        <option value="{{$leader->id}}" selected>{{$leader->emp_name}}</option>
                                        @else
                                            <option value="{{$leader->id}}">{{$leader->emp_name}}</option>
                                            @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="input002" class="col-sm-3 control-label form-label">Select Team Members</label>
                            <div class="col-md-8">
                                <select class="selectpicker" data-live-search="true" name="member_id[]" multiple>
                                    @foreach($emps as $emp)
                                        @if(in_array($emp->id,$team_member))
                                        <option value="{{$emp->id}}" selected>{{$emp->emp_name}}</option>
                                        @else
                                            <option value="{{$emp->id}}">{{$emp->emp_name}}</option>
                                         @endif
                                            @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="input002" class="col-sm-3 control-label form-label"></label>
                            <div class="col-md-8">
                                <input type="submit" class="btn btn-default" value="Submit">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}

@endsection