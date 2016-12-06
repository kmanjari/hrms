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
                    <a href=""> Assigned Assets </a>
                </li>
                <li class="breadcrumb-current-item"> Assignment Listings </li>
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
                            <span class="panel-title hidden-xs"> Asset Assignment Listings </span>
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
                                    <th class="text-center">Employee</th>
                                    <th class="text-center">Asset</th>
                                        <th class="text-center">Issuing Authority</th>
                                    <th class="text-center">Date of Assignment</th>
                                    <th class="text-center">Date of Release</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i =0;?>
                                @foreach($assets as $asset)
                                    <tr>
                                        <td class="text-center">{{$i+=1}}</td>
                                        <td class="text-center">{{$asset->employee->name}}</td>
                                        <td class="text-center">{{$asset->asset->name}}</td>
                                        <td class="text-center">{{$asset->authority->name}}</td>
                                        <td class="text-center">{{getFormattedDate($asset->date_of_assignment)}}</td>
                                        <td class="text-center">{{getFormattedDate($asset->date_of_release)}}</td>
                                        <td class="text-center">
                                            <div class="btn-group text-right">
                                                <button type="button"
                                                        class="btn btn-success br2 btn-xs fs12 dropdown-toggle"
                                                        data-toggle="dropdown" aria-expanded="false"> Action
                                                    <span class="caret ml5"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>
                                                        <a href="/edit-asset-assignment/{{$asset->id}}">Edit</a>
                                                    </li>
                                                    <li>
                                                        <a href="/delete-asset-assignment/{{$asset->id}}">Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    {!! $assets->render() !!}
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