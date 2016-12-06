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
                <li class="breadcrumb-current-item"> My Leave List</li>
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
                    <div class="box box-success">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title hidden-xs"> My Leave Lists </span>
                        </div>
                        <div class="panel-body pn">
                            @if(Session::has('flash_message'))
                                <div class="alert alert-success">
                                    {{ Session::get('flash_message') }}
                                </div>
                            @endif
                            {!! Form::open(['class' => 'form-horizontal']) !!}
                            <div class="table-responsive">
                                <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                    <thead>
                                    <tr class="bg-light">
                                        <th class="text-center">Id</th>
                                        <th class="text-center">Leave Type</th>
                                        <th class="text-center">Date From</th>
                                        <th class="text-center">Date To</th>
                                        <th class="text-center">Days</th>
                                        <th class="text-center">Remarks</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i =0;?>
                                    @foreach($leaves as $leave)
                                        <tr>
                                            <td class="text-center">{{$i+=1}}</td>
                                            <td class="text-center">{{getLeaveType($leave->leave_type_id)}}</td>
                                            <td class="text-center">{{getFormattedDate($leave->date_from)}}</td>
                                            <td class="text-center">{{getFormattedDate($leave->date_to)}}</td>
                                            <td class="text-center">{{$leave->days}}</td>
                                            <td class="text-center"></td>
                                            <td class="text-center">
                                                <div class="btn-group text-right">
                                                    @if($leave->status==0)
                                                        <button type="button"
                                                                class="btn btn-info br2 btn-xs fs12"
                                                                aria-expanded="false"> <i class="fa fa-external-link"> Pending </i>

                                                        </button>
                                                    @elseif($leave->status==1)
                                                        <button type="button"
                                                                class="btn btn-success br2 btn-xs fs12"
                                                                aria-expanded="false"> <i class="fa fa-check"> Approved </i>

                                                        </button>
                                                    @else
                                                        <button type="button"
                                                                class="btn btn-danger br2 btn-xs fs12"
                                                                aria-expanded="false"> <i class="fa fa-times"> Disapproved </i>

                                                        </button>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        {!! $leaves->render() !!}
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
            </div>
    </section>

</div>
@endsection