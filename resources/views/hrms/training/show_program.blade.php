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
                        <a href=""> Trainings </a>
                    </li>
                    <li class="breadcrumb-current-item"> Training Program Listings </li>
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
                                <span class="panel-title hidden-xs"> Training Program Lists </span>
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
                                            <th class="text-center">Training Program</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i =0;?>
                                        @foreach($programs as $program)
                                            <tr>
                                                <td class="text-center">{{$i+=1}}</td>

                                                <td class="text-center">{{$program->name}}</td>
                                                <td class="text-center">{{$program->description}}</td>
                                                <td class="text-center">
                                                    <div class="btn-group text-right">
                                                        <button type="button"
                                                                class="btn btn-success br2 btn-xs fs12 dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false"> Action
                                                            <span class="caret ml5"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a href="/edit-training-program/{{$program->id}}">Edit</a>
                                                            </li>
                                                            <li>
                                                                <a href="/delete-training-program/{{$program->id}}">Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            {!! $programs->render() !!}
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