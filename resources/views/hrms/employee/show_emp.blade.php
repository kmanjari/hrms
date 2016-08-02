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
                    <a href=""> Employees </a>
                </li>
                <li class="breadcrumb-current-item"> Employee Manager</li>
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
                            <span class="panel-title hidden-xs">Employee Lists</span>
                        </div>
                        <div class="panel-body pn">
                            <div class="table-responsive">
                                <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                    <thead>
                                    <tr class="bg-light">
                                        <th>Id</th>
                                        <th>Select</th>
                                        <th>Emp Code</th>
                                        <th>Emp Name</th>
                                        <th>Emp Status</th>
                                        <th>Role</th>
                                        <th>Joining Date</th>
                                        <th>Address</th>
                                        <th>Mobile Number</th>
                                        <th>Department</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($emps as $emp)
                                    <tr>
                                        <td>{{$emp->id}}</td>
                                        <td class="text-center">
                                            <label class="option block mn">
                                                <input type="checkbox" name="inputname" value="FR">
                                                <span class="checkbox mn"></span>
                                            </label>
                                        </td>
                                        <td>{{$emp->emp_code}}</td>
                                        <td>{{$emp->emp_name}}</td>
                                        <td>{{convertStatusBack($emp->emp_status)}}</td>
                                        <td>{{$emp->userrole->role['name']}}</td>
                                        <td>{{$emp->doj}}</td>
                                        <td>{{$emp->address}}</td>
                                        <td>{{$emp->mob_number}}</td>
                                        <td>{{$emp->department}}</td>
                                        <td class="text-right">
                                            <div class="btn-group text-right">
                                                <button type="button"
                                                        class="btn btn-info br2 btn-xs fs12 dropdown-toggle"
                                                        data-toggle="dropdown" aria-expanded="false"> Action
                                                    <span class="caret ml5"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>
                                                        <a href="#">Edit</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                            {!! $emps->render() !!}
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