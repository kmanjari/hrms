@extends('hrms.layouts.base')

@section('content')
        <!-- START CONTENT -->
<div class="content">

    <!-- Start Page Header -->
    <div class="page-header">
        <h1 class="title"></h1>
        <ol class="breadcrumb">
            <li><a href="/dashboard">DASHBOARD</a></li>
            <li>Leave</li>
            <li class="active">Leave Request Listing</li>
        </ol>
    </div>

    <!-- START CONTAINER -->
    <div class="container-padding">
        <div class="container-padding">
            @if(Session::has('flash_message'))
                <div class="alert alert-success">
                    {{ Session::get('flash_message') }}
                </div>
            @endif
            {{  Form::open(['files' => 'true'],['method' =>'PATCH']) }}
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-widget">
                    <div class="panel panel-default">
                        <div class="panel-title text-center">
                            <blockquote>Total Leave Request</blockquote>
                        </div>
                        <div class="form-horizontal">

                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                   <th>Leave Type</th>
                                    <th>Date From</th>
                                    <th>Date To</th>
                                    <th>Reason</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($leaves as $leave)
                                    <tr>
                                        <td>{{$leave->id}}</td>
                                        <td>{{$leave->leavetypeapply->leavetype->leave_type}}</td>
                                        <td>{{$leave->dateFrom}}</td>
                                        <td>{{$leave->dateTo}}</td>
                                        <td>{{$leave->reason}}</td>
                                        <td>
                                            <a href="/approveRequest/{{$leave->id}}" class="btn btn-rounded btn-primary">Approve</a> <a href="/rejectrequest/{{$leave->id}}" class="btn btn-rounded btn-danger">Reject</a>
                                        </td>
                                    </tr>
                                 </tbody>
                                @endforeach
                              </table>
                            {!! $leaves->render() !!}
                        </div>
                    </div>
                </div>
            </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection