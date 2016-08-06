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
                    <a href=""> Leaves </a>
                </li>
                <li class="breadcrumb-current-item"> Total Leave Requests </li>
            </ol>
        </div>
    </header>


    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn">

        <!-- -------------- Column Center -------------- -->
        <div class="chute chute-center">

            <!-- -------------- Products Status Table -------------- -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title hidden-xs"> Total Leave Lists </span><br />
                        </div><br />
                        <div class="panel-menu allcp-form theme-primary mtn">
                             <div class="row">
                                {!! Form::open() !!}
                                  <div class="col-md-3">
                                    <input type="text" class="field form-control" placeholder="query string" style="height:40px" name="string">
                                  </div>
                                   <div class="col-md-3">
                                     <label class="field select">
                                         <select id="column" name="column">
                                            <option value="">Filter by</option>
                                            <option value="name">Name</option>
                                            <option value="code">Code</option>
                                            <option value="days">Days</option>
                                            <option value="leave_type">Leave type</option>
                                            <option value="status">Status</option>
                                        </select>
                                        <i class="arrow double"></i>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="submit" value="Search" name="button" class="btn btn-primary">
                                </div>

                                <div class="col-md-2">
                                    <input type="submit" value="Export" name="button" class="btn btn-primary">
                                </div>
                                {!! Form::close() !!}
                                <div class="col-md-2">
                                    <a href="/total-leave-list" >
                                        <input type="submit" value="Reset" class="btn btn-primary"></a>
                                </div>
                                    </div>
                                    </div>
                        <div class="panel-body pn">
                            @if(Session::has('flash_message'))
                                <div class="alert alert-success">
                                    {{ Session::get('flash_message') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                    <thead>
                                    <tr class="bg-light">
                                        <th>Id</th>
                                        <th>Employee</th>
                                        <th>Code</th>
                                        <th>Leave Type</th>
                                        <th>Date From</th>
                                        <th>Date To</th>
                                        <th>Days</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($leaves as $leave)
                                        <tr>
                                            <td>{{$leave->id}}</td>
                                            <td>{{(isset($post))? $leave->name : $leave->user->name}}</td>
                                            <td>{{(isset($post))? $leave->code : $leave->user->employee->code}}</td>
                                            <td>{{(isset($post))? $leave->leave_type : getLeaveType($leave->leave_type_id)}}</td>
                                            <td>{{getFormattedDate($leave->date_from)}}</td>
                                            <td>{{getFormattedDate($leave->date_to)}}</td>
                                            <td>{{$leave->days}}</td>
                                            <td>{{($leave->status == '0') ? 'Unapproved' : 'Approved'}}</td>
                                        </tr>
                                    @endforeach
                                    <tr><td colspan="8">
                                        {!! $leaves->render() !!}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection