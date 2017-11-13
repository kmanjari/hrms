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
                    <a href=""> Teams </a>
                </li>
                <li class="breadcrumb-current-item"> Edit Team </li>
            </ol>
        </div>
    </header>
    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn">
        <!-- -------------- Column Center -------------- -->
        <div class="chute-affix" data-spy="affix" data-offset-top="200">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-success">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title hidden-xs"> Edit Team </span>
                        </div>

                        <div class="panel-body pn">
                            <div class="table-responsive">
                                <div class="panel-body p25 pb10">

                                    @if(Session::has('flash_message'))
                                        <div class="alert alert-success">
                                            {{ Session::get('flash_message') }}
                                        </div>
                                    @endif
                                    {!! Form::open(['class' => 'form-horizontal']) !!}
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> Team Name </label>
                                            <div class="col-md-6">
                                                <input type="text" placeholder="name of team..." name="team_name"
                                                       value="{{$edit[0]->name}}" class="select2-single form-control" required>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> Select Team Manager</label>
                                            <div class="col-md-6">
                                                <select class="selectpicker form-control" data-done-button="true"
                                                        name="manager_id" required>
                                                    <option value="" selected>Select One</option>
                                                    @foreach($managers as $manager)
                                                        @if($edit[0]->manager->id == $manager->id)
                                                            <option value="{{$manager->id}}" selected>{{$manager->name}}</option>
                                                        @else
                                                            <option value="{{$manager->id}}">{{$manager->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> Select Team Leader</label>
                                            <div class="col-md-6">
                                                <select class="selectpicker form-control" data-done-button="true"
                                                        name="leader_id" required>
                                                    <option value="" selected>Select One</option>
                                                    @foreach($leaders as $leader)
                                                        @if($edit[0]->leader->id == $leader->id)
                                                            <option value="{{$leader->id}}" selected>{{$leader->name}}</option>
                                                        @else
                                                            <option value="{{$leader->id}}">{{$leader->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> Select Team Members </label>
                                            <div class="col-md-6">
                                                <select id="done" class="selectpicker form-control"
                                                        multiple data-done-button="true" name="member_id[]" required>
                                                    @foreach($emps as $emp)
                                                        @if(in_array($emp->id,$team_member))
                                                            <option value="{{$emp->id}}" selected>{{$emp->name}}</option>
                                                        @else
                                                            <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-md-3 control-label"></label>
                                            <div class="col-md-2">

                                                    <input type="submit" class="btn btn-bordered btn-info btn-block" value="Submit">
                                            </div>
                                            <div class="col-md-2">
                                                <a href="/edit-team/{id}" >

                                                    <input type="button" value="Reset" class="btn btn-bordered btn-success btn-block"></a>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                        {{--</form>--}}
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
@push('scripts')
    <script src="/assets/allcp/forms/js/bootstrap-select.js"></script>
@endpush