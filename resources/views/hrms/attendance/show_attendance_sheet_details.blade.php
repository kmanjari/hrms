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
                        <a href=""> Attendance </a>
                    </li>
                    <li class="breadcrumb-current-item"> Attendance Manager</li>
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
                                <span class="panel-title hidden-xs"> Attendance Details </span><br />
                            </div><br />
                            <div class="panel-menu allcp-form theme-primary mtn">
                                <div class="row">
                                    {!! Form::open() !!}
                                    <div class="col-md-3">
                                        <input type="text" class="field form-control" placeholder="query string" style="height:40px" value="{{$string}}" name="string">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="field select">
                                            {!! Form::select('column', getAttendanceDropDown(),$column) !!}
                                            <i class="arrow double"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" id="datepicker1" class="select2-single form-control"
                                               name="dateFrom" value="{{$dateFrom}}" placeholder="date from"/>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" id="datepicker4" class="select2-single form-control"
                                               name="dateTo" value="{{$dateTo}}" placeholder="date to"/>
                                    </div>


                                    <div class="col-md-2"><br />
                                        <input type="submit" value="Search" name="button" class="btn btn-primary">
                                    </div>


                                    <div class="col-md-2"><br />
                                        <a href="/export">
                                        <input type="submit" value="Export" name="button" class="btn btn-success"></a>
                                    </div>
                                    {!! Form::close() !!}

                                    <div class="col-md-2"><br />
                                        <a href="/attendance-manager" >
                                            <input type="submit" value="Reset" class="btn btn-warning"></a>
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
                                        @if(count($attendances))
                                        <thead>
                                        <tr class="bg-light">
                                            <th class="text-center">Id</th>
                                            <th class="text-center">Code</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Day</th>
                                            <th class="text-center">In Time</th>
                                            <th class="text-center">Out Time</th>
                                            <th class="text-center">Hours Worked</th>
                                            <th class="text-center">Difference</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Leave Status</th>
                                            {{--<th class="text-center">Action</th>--}}
                                        </tr>
                                        </thead>
                                            @else
                                            <h2>Nothing to show</h2>
                                        @endif
                                        <tbody>
                                        <?php $i =0;?>
                                        @foreach($attendances as $attendance)
                                            <tr>
                                                <td class="text-center">{{$i+=1}}</td>
                                                <td class="text-center">{{$attendance->code}}</td>
                                                <td class="text-center">{{$attendance->name}}</td>
                                                <td class="text-center">{{getFormattedDate($attendance->date)}}</td>
                                                <td class="text-center">{{$attendance->day}}</td>
                                                <td class="text-center">{{$attendance->in_time}}</td>
                                                <td class="text-center">{{$attendance->out_time}}</td>
                                                <td class="text-center">{{round($attendance->hours_worked,2)}}</td>
                                                <td class="text-center">{{$attendance->difference}}</td>
                                                <td class="text-center">{{convertAttendanceFrom($attendance->status)}}</td>
                                                <td class="text-center">{{$attendance->leave_status}}</td>
                                                {{--<td class="text-center">--}}
                                                    {{--<div class="btn-group text-center">--}}
                                                        {{--<button type="button"--}}
                                                                {{--class="btn btn-info br2 btn-xs fs12 dropdown-toggle"--}}
                                                                {{--data-toggle="dropdown" aria-expanded="false"> Action--}}
                                                            {{--<span class="caret ml5"></span>--}}
                                                        {{--</button>--}}
                                                        {{--<ul class="dropdown-menu" role="menu">--}}
                                                            {{--<li>--}}
                                                                {{--<a href="">Edit</a>--}}
                                                            {{--</li>--}}
                                                            {{--<li>--}}
                                                                {{--<a href="">Delete</a>--}}
                                                            {{--</li>--}}
                                                        {{--</ul>--}}
                                                    {{--</div>--}}
                                                {{--</td>--}}
                                            </tr>
                                        @endforeach
                                        <tr><td colspan="11">
                                                {!! $attendances->render() !!}
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
            </div>
        </section>

    </div>
@endsection
@push('scripts')
    <script src="/assets/js/custom.js"></script>
@endpush