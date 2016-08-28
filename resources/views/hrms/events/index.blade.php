@extends('hrms.layouts.base')

@section('content')
        <!-- START CONTENT -->
<div class="content">

    <input type="hidden" value="{{csrf_token()}}" id="token">

    <!-- -------------- Topbar -------------- -->
    <header id="topbar" class="alt">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="breadcrumb-icon">
                    <a href="dashboard1.html">
                        <span class="fa fa-home"></span>
                    </a>
                </li>
                <li class="breadcrumb-active">
                    <a href="dashboard1.html">Dashboard</a>
                </li>
                <li class="breadcrumb-link">
                    <a href="index.html">Home</a>
                </li>
                <li class="breadcrumb-current-item">Basic Calendar</li>
            </ol>
        </div>
        <div class="topbar-right">
            <div class="ib topbar-dropdown">
                <label for="topbar-multiple" class="control-label">Reporting Period</label>
                <select id="topbar-multiple" class="hidden">
                    <optgroup label="Filter By:">
                        <option value="1-1">Last 30 Days</option>
                        <option value="1-2" selected="selected">Last 60 Days</option>
                        <option value="1-3">Last Year</option>
                    </optgroup>
                </select>
            </div>
            <div class="ml15 ib va-m" id="sidebar_right_toggle">
                <div class="navbar-btn btn-group btn-group-number mv0">
                    <button class="btn btn-sm btn-default btn-bordered prn pln">
                        <i class="fa fa-bar-chart fs22 text-default"></i>
                    </button>
                    <button class="btn btn-primary btn-sm btn-bordered hidden-xs"> 3</button>
                </div>
            </div>
        </div>
    </header>
    <!-- -------------- /Topbar -------------- -->

    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn">

        <!-- -------------- Column Center -------------- -->
        <div class="chute chute-center ph45">

            <!-- -------------- Calendar -------------- -->
            <div id="calendar" class="events-calendar"></div>

        </div>
        <!-- -------------- /Column Center -------------- -->

        <aside class="chute chute-right chute350" data-chute-mobile="#content > .chute-center"
               data-chute-height="match">

            <div class="fc-title-clone"></div>

            <div class="section allcp-form theme-primary">
                <div class="inline-mp minimal-mp center-block"></div>
            </div>

            <h5 class="mt25 ml5"> Events
                <a id="compose-event-btn" href="#calendarManagment" data-effect="mfp-flipInY">
                    <span class="fa fa-plus-square"></span>
                </a>
            </h5>

            <div id="external-events" class="bg-dotted">

                <div class='fc-event fc-event-primary' data-event="primary">
                    <div class="fc-event-icon">
                        <span class="fa fa-exclamation"></span>
                    </div>
                    <div class="fc-event-desc">
                        <b>1:25pm </b>Go to San Park
                    </div>
                </div>
                <div class='fc-event fc-event-info' data-event="info">
                    <div class="fc-event-icon">
                        <span class="fa fa-info"></span>
                    </div>
                    <div class="fc-event-desc">
                        <b>4:30pm </b>Meeting With Boss
                    </div>
                </div>
                <div class='fc-event fc-event-info' data-event="info">
                    <div class="fc-event-icon">
                        <span class="fa fa-info"></span>
                    </div>
                    <div class="fc-event-desc">
                        <b>5:00pm </b>Meeting With John Doe
                    </div>
                </div>
                <div class='fc-event fc-event-info' data-event="info">
                    <div class="fc-event-icon">
                        <span class="fa fa-info"></span>
                    </div>
                    <div class="fc-event-desc">
                        <b>6:00pm </b>Meeting With Jane Doe
                    </div>
                </div>

                <h6 class="mt30 ml10 text-muted"> Reoccuring Events: </h6>

                <div class='fc-event fc-event-alert event-recurring' data-event="alert">
                    <div class="fc-event-icon">
                        <span class="fa fa-bell"></span>
                    </div>
                    <div class="fc-event-desc">
                        <b>1:00pm </b>Take medicine
                    </div>
                </div>
                <div class='fc-event fc-event-system event-recurring' data-event="system">
                    <div class="fc-event-icon">
                        <span class="fa fa-bell"></span>
                    </div>
                    <div class="fc-event-desc">
                        <b>8:00pm </b>Security Check
                    </div>
                </div>

            </div>

        </aside>
        <!-- -------------- /Column Left -------------- -->


    </section>
    <!-- -------------- /Content -------------- -->

    </section>

    <!-- -------------- Sidebar Right -------------- -->
    <aside id="sidebar_right" class="nano affix">

        <!-- -------------- Sidebar Right Content -------------- -->
        <div class="sidebar-right-wrapper nano-content">

            <div class="sidebar-block br-n p15">

                <h6 class="title-divider text-muted mb20"> Visitors Stats
                <span class="pull-right"> 2015
                  <i class="fa fa-caret-down ml5"></i>
                </span>
                </h6>

                <div class="progress mh5">
                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="34"
                         aria-valuemin="0"
                         aria-valuemax="100" style="width: 34%">
                        <span class="fs11">New visitors</span>
                    </div>
                </div>
                <div class="progress mh5">
                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="66"
                         aria-valuemin="0"
                         aria-valuemax="100" style="width: 66%">
                        <span class="fs11 text-left">Returnig visitors</span>
                    </div>
                </div>
                <div class="progress mh5">
                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="45"
                         aria-valuemin="0"
                         aria-valuemax="100" style="width: 45%">
                        <span class="fs11 text-left">Orders</span>
                    </div>
                </div>

                <h6 class="title-divider text-muted mt30 mb10">New visitors</h6>

                <div class="row">
                    <div class="col-xs-5">
                        <h3 class="text-primary mn pl5">350</h3>
                    </div>
                    <div class="col-xs-7 text-right">
                        <h3 class="text-warning mn">
                            <i class="fa fa-caret-down"></i> 15.7% </h3>
                    </div>
                </div>

                <h6 class="title-divider text-muted mt25 mb10">Returnig visitors</h6>

                <div class="row">
                    <div class="col-xs-5">
                        <h3 class="text-primary mn pl5">660</h3>
                    </div>
                    <div class="col-xs-7 text-right">
                        <h3 class="text-success-dark mn">
                            <i class="fa fa-caret-up"></i> 20.2% </h3>
                    </div>
                </div>

                <h6 class="title-divider text-muted mt25 mb10">Orders</h6>

                <div class="row">
                    <div class="col-xs-5">
                        <h3 class="text-primary mn pl5">153</h3>
                    </div>
                    <div class="col-xs-7 text-right">
                        <h3 class="text-success mn">
                            <i class="fa fa-caret-up"></i> 5.3% </h3>
                    </div>
                </div>

                <h6 class="title-divider text-muted mt40 mb20"> Site Statistics
                    <span class="pull-right text-primary fw600">Today</span>
                </h6>
            </div>
        </div>
    </aside>
    <!-- -------------- /Sidebar Right -------------- -->

</div>
<!-- -------------- /Body Wrap  -------------- -->

<!-- -------------- Calendar Management Form -------------- -->
<div class="allcp-form theme-primary popup-basic popup-lg mfp-with-anim mfp-hide" id="calendarManagment">
    <div class="panel">
        <div class="panel-heading">
        <span class="panel-title">
          <i class="fa fa-pencil-square-o"></i>New Calendar Event
        </span>
        </div>

        <form method="post" action="/" id="calendarManagmentForm">
            <div class="panel-body p25">
                <div class="section-divider mt10 mb40">
                    <span>Event Details</span>
                </div>

                <!---------------------- Coordinator -------------------->
                <div class="section row">
                    <div class="col-md-12">
                        <label for="event_name" class="field prepend-icon">
                            <input type="text" class="form-control" id="event_name">
                        </label>
                    </div>
                </div>
                <!-- -------------- /Event Name-------------- -->


               <!---------------------- Coordinator -------------------->
                <div class="section row">
                    <div class="col-md-12">
                        <label for="firstname" class="field prepend-icon">
                            <select id="event_cordinater" class="form-control">
                                <option value="">Event Coordinator</option>
                                @foreach($coordinators as $coordinator)
                                <option value="{{$coordinator['id']}}">{{$coordinator['name']}}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                </div>

                <!-- -------------- /Coordinator -------------- -->

                <!---------------------- Date ------------------->

                <div class="section row">
                    <div class="col-md-12">
                        <div class="input-group date" id="datetimepicker2">
                                            <span class="input-group-addon cursor">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                            <input type="text" class="form-control" id="date_time">
                        </div>
                    </div>
                    </div>

                <!--------------------- /Date ------------------->

                <!-- -------------- /section -------------- -->

                <div class="section row">
                    <div class="col-md-12">
                        <label for="firstname" class="field prepend-icon">
                            <select id="event_attendees" class="form-control" multiple>
                                <option value="">Event Attendees</option>
                                @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                            </select>
                        </label>
                    </div>
                </div>
                <!-- -------------- /section -------------- -->

                <div class="section row">
                    <div class="col-xs-12">
                        <label class="field prepend-icon">
                        <textarea class="gui-textarea" id="event_description"
                                  placeholder="Event Description"></textarea>
                            <label for="comment" class="field-icon">
                                <i class="fa fa-comments"></i>
                            </label>
                            <span class="input-footer hidden">
                            <strong>Hint:</strong>Don't be negative or off topic! just be awesome...</span>
                        </label>
                    </div>
                </div>
                <!-- -------------- /section -------------- -->

                <!----------- progress bar ---------->

                <div class="section row hidden" id="status-section">
                    Working
                <div class="progress mt10 mbn">
                    <div class="progress-bar progress-bar-primary progress-bar-striped active mnw100"
                         role="progressbar"
                         aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
                         style="width: 32%">
                        <span class="sr-only">40% Complete (success)</span>
                    </div>
                </div>
                </div>

                <div class="section row hidden" id="message-section">
                    <div class="alert alert-info light alert-dismissable" id="alert-demo-1">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        Event created successfully!
                    </div>
                </div>


                <!----------- /progress bar ---------->

            </div>
            <div class="panel-footer text-right">
                <button type="button" id="create-event" class="button btn-primary">Create Event</button>
            </div>
        </form>
    </div>
</div>

<!-- -------------- Content -------------- -->
</div>
@endsection