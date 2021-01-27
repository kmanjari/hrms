<!DOCTYPE html>
<html>

<head>
    <!-- -------------- Meta and Title -------------- -->
    <meta charset="utf-8">
    <title> Human Resource Management System </title>
    <meta name="description" content="HRMS">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf_token" content="{{csrf_token()}}">

    <!-- -------------- Fonts -------------- -->
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet'
          type='text/css'>


    <!-- -------------- Icomoon -------------- -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/fonts/icomoon/icomoon.css') }}">

    <!-- -------------- FullCalendar -------------- -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/js/plugins/fullcalendar/fullcalendar.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/js/plugins/magnific/magnific-popup.css') }}">

    <!-- -------------- Plugins -------------- -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/js/plugins/c3charts/c3.min.css') }}">

    <!-- -------------- CSS - theme -------------- -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/skin/default_skin/css/theme.css') }}">


    <!-- -------------- CSS - allcp forms -------------- -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/allcp/forms/css/forms.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/allcp/forms/css/widget.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/js/plugins/select2/css/core.css') }}">
    <!-- -------------- Favicon -------------- -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/img/favicon.png') }}">

    <!--  Custom css -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/custom.css') }}">

    <!-- Sweet alert -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/sweetalert.css') }}">

@stack('styles')

    <!-- -------------- IE8 HTML5 support  -------------- -->
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js') }}"></script>
    <![endif]-->

    <style type="text/css">
        .blink {
            color:mediumblue;
        }

        .blink_second {
            color:red;
        }

        .blink_third {
            color:yellow;
        }
    </style>

</head>

<body class="dashboard-page">

<!-- -------------- Customizer -------------- -->
<div id="customizer" class="hidden-xs">
    <div class="panel">

        <div class="panel-body pn">
            <ul class="nav nav-list nav-list-sm" role="tablist">
                <li class="active">
                    <a href="customizer-header" role="tab" data-toggle="tab">Navbar</a>
                </li>
                <li>
                    <a href="customizer-sidebar" role="tab" data-toggle="tab">Sidebar</a>
                </li>
                <li>
                    <a href="customizer-settings" role="tab" data-toggle="tab">Misc</a>
                </li>
            </ul>
            <div class="tab-content p20 ptn pb15">
                <div role="tabpanel" class="tab-pane active" id="customizer-header">
                    <form id="customizer-header-skin">
                        <h6 class="mv20">Header Skins</h6>

                        <div class="customizer-sample">
                            <table>
                                <tr>
                                    <td>
                                        <div class="checkbox-custom fill checkbox-dark mb10">
                                            <input type="radio" name="headerSkin" id="headerSkin5" checked
                                                   value="bg-dark">
                                            <label for="headerSkin5">Dark</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox-custom fill checkbox-warning mb10">
                                            <input type="radio" name="headerSkin" id="headerSkin2" value="bg-warning">
                                            <label for="headerSkin2">Warning</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox-custom fill checkbox-danger mb10">
                                            <input type="radio" name="headerSkin" id="headerSkin3" value="bg-danger">
                                            <label for="headerSkin3">Danger</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox-custom fill checkbox-success mb10">
                                            <input type="radio" name="headerSkin" id="headerSkin4" value="bg-success">
                                            <label for="headerSkin4">Success</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox-custom fill checkbox-primary mb10">
                                            <input type="radio" name="headerSkin" id="headerSkin6" value="bg-primary">
                                            <label for="headerSkin6">Primary</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox-custom fill checkbox-info mb10">
                                            <input type="radio" name="headerSkin" id="headerSkin7" value="bg-info">
                                            <label for="headerSkin7">Info</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox-custom fill checkbox-alert mb10">
                                            <input type="radio" name="headerSkin" id="headerSkin8" value="bg-alert">
                                            <label for="headerSkin8">Alert</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox-custom fill checkbox-system mb10">
                                            <input type="radio" name="headerSkin" id="headerSkin9" value="bg-system">
                                            <label for="headerSkin9">System</label>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <div class="checkbox-custom checkbox-disabled fill mb10">
                                <input type="radio" name="headerSkin" id="headerSkin1" value="bgc-light">
                                <label for="headerSkin1">Light</label>
                            </div>
                        </div>
                    </form>
                    <form id="customizer-footer-skin">
                        <h6 class="mv20">Footer Skins</h6>

                        <div class="customizer-sample">
                            <table>
                                <tr>
                                    <td>
                                        <div class="checkbox-custom fill checkbox-dark mb10">
                                            <input type="radio" name="footerSkin" id="footerSkin1" checked value="">
                                            <label for="footerSkin1">Dark</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox-custom checkbox-disabled fill mb10">
                                            <input type="radio" name="footerSkin" id="footerSkin2" value="footer-light">
                                            <label for="footerSkin2">Light</label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane" id="customizer-sidebar">
                    <form id="customizer-sidebar-skin">
                        <h6 class="mv20">Sidebar Skins</h6>

                        <div class="customizer-sample">
                            <div class="checkbox-custom fill checkbox-dark mb10">
                                <input type="radio" name="sidebarSkin" checked id="sidebarSkin2" value="">
                                <label for="sidebarSkin2">Dark</label>
                            </div>
                            <div class="checkbox-custom fill checkbox-disabled mb10">
                                <input type="radio" name="sidebarSkin" id="sidebarSkin1" value="sidebar-light">
                                <label for="sidebarSkin1">Light</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane" id="customizer-settings">
                    <form id="customizer-settings-misc">
                        <h6 class="mv20 mtn">Layout Options</h6>

                        <div class="form-group">
                            <div class="checkbox-custom fill mb10">
                                <input type="checkbox" checked="" id="header-option">
                                <label for="header-option">Fixed Header</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox-custom fill mb10">
                                <input type="checkbox" checked="" id="sidebar-option">
                                <label for="sidebar-option">Fixed Sidebar</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox-custom fill mb10">
                                <input type="checkbox" id="breadcrumb-option">
                                <label for="breadcrumb-option">Fixed Breadcrumbs</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox-custom fill mb10">
                                <input type="checkbox" id="breadcrumb-hidden">
                                <label for="breadcrumb-hidden">Hide Breadcrumbs</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="form-group mn pb35 pt25 text-center">
                <a href="#" id="clearAll" class="btn btn-primary btn-bordered btn-sm">Clear All</a>
            </div>
        </div>
    </div>
</div>
<!-- -------------- /Customizer -------------- -->

<!-- -------------- Body Wrap  -------------- -->
<div id="main">

    <!-- -------------- Header  -------------- -->
    @include('hrms.layouts.header')
    <!-- -------------- /Header  -------------- -->

    <!-- -------------- Sidebar  -------------- -->
    <aside id="sidebar_left" class="nano nano-light affix">

        <!-- -------------- Sidebar Left Wrapper  -------------- -->
        <div class="sidebar-left-content nano-content">

            <!-- -------------- Sidebar Header -------------- -->
            <header class="sidebar-header">

                <!-- -------------- Sidebar - Author -------------- -->
            @include('hrms.layouts.sidebar')

            <!-- -------------- Sidebar Hide Button -------------- -->
            <div class="sidebar-toggler">
                <a href="#">
                    <span class="fa fa-arrow-circle-o-left"></span>
                </a>
            </div>
            <!-- -------------- /Sidebar Hide Button -------------- -->

        </div>
        <!-- -------------- /Sidebar Left Wrapper  -------------- -->

    </aside>

    <!-- -------------- /Sidebar -------------- -->

    <!-- -------------- Main Wrapper -------------- -->
    <section id="content_wrapper">

        <!-- -------------- Topbar Menu Wrapper -------------- -->
        <div id="topbar-dropmenu-wrapper">
            <div class="topbar-menu row">
                <div class="col-xs-4 col-sm-2">
                    <a href="#" class="service-box bg-danger">
                        <span class="fa fa-music"></span>
                        <span class="service-title">Audio</span>
                    </a>
                </div>
                <div class="col-xs-4 col-sm-2">
                    <a href="#" class="service-box bg-success">
                        <span class="fa fa-picture-o"></span>
                        <span class="service-title">Images</span>
                    </a>
                </div>
                <div class="col-xs-4 col-sm-2">
                    <a href="#" class="service-box bg-primary">
                        <span class="fa fa-video-camera"></span>
                        <span class="service-title">Videos</span>
                    </a>
                </div>
                <div class="col-xs-4 col-sm-2">
                    <a href="#" class="service-box bg-alert">
                        <span class="fa fa-envelope"></span>
                        <span class="service-title">Messages</span>
                    </a>
                </div>
                <div class="col-xs-4 col-sm-2">
                    <a href="#" class="service-box bg-system">
                        <span class="fa fa-cog"></span>
                        <span class="service-title">Settings</span>
                    </a>
                </div>
                <div class="col-xs-4 col-sm-2">
                    <a href="#" class="service-box bg-dark">
                        <span class="fa fa-user"></span>
                        <span class="service-title">Users</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- -------------- /Topbar Menu Wrapper -------------- -->

        <!-- YIELD CONTENT -->

        @yield('content')

        <!-- /YIELD CONTENT -->

        <!-- -------------- Content -------------- -->
        <section id="content" class="table-layout animated fadeIn">

            <!-- -------------- Column Right -------------- -->
            <aside class="chute chute-right chute270 pn hidden" data-chute-height="match">

                <!-- -------------- Activity Timeline -------------- -->
                <ol class="timeline-list pl5 mt5">
                    <li class="timeline-item">
                        <div class="timeline-icon bg-dark light">
                            <span class="fa fa-tags"></span>
                        </div>
                        <div class="timeline-desc">
                            <b>Genry</b> Added a new item to his store:
                            <a href="#">Ipod</a>
                        </div>
                        <div class="timeline-date">1:25am</div>
                    </li>
                    <li class="timeline-item">
                        <div class="timeline-icon bg-dark light">
                            <span class="fa fa-tags"></span>
                        </div>
                        <div class="timeline-desc">
                            <b>Lion</b> Added a new item to his store:
                            <a href="#">Notebook</a>
                        </div>
                        <div class="timeline-date">3:05am</div>
                    </li>
                    <li class="timeline-item">
                        <div class="timeline-icon bg-success">
                            <span class="fa fa-usd"></span>
                        </div>
                        <div class="timeline-desc">
                            <b>Admin</b> created a new invoice for:
                            <a href="#">Software</a>
                        </div>
                        <div class="timeline-date">4:15am</div>
                    </li>
                    <li class="timeline-item">
                        <div class="timeline-icon bg-warning">
                            <span class="fa fa-pencil"></span>
                        </div>
                        <div class="timeline-desc">
                            <b>Laura</b> edited her work experience
                        </div>
                        <div class="timeline-date">5:25am</div>
                    </li>
                    <li class="timeline-item">
                        <div class="timeline-icon bg-success">
                            <span class="fa fa-usd"></span>
                        </div>
                        <div class="timeline-desc">
                            <b>Admin</b> created a new invoice for:
                            <a href="#">Apple Inc.</a>
                        </div>
                        <div class="timeline-date">7:45am</div>
                    </li>
                    <li class="timeline-item">
                        <div class="timeline-icon bg-dark light">
                            <span class="fa fa-tags"></span>
                        </div>
                        <div class="timeline-desc">
                            <b>Genry</b> Added a new item to his store:
                            <a href="#">Ipod</a>
                        </div>
                        <div class="timeline-date">8:25am</div>
                    </li>
                    <li class="timeline-item">
                        <div class="timeline-icon bg-dark light">
                            <span class="fa fa-tags"></span>
                        </div>
                        <div class="timeline-desc">
                            <b>Lion</b> Added a new item to his store:
                            <a href="#">Watch</a>
                        </div>
                        <div class="timeline-date">9:35am</div>
                    </li>
                    <li class="timeline-item">
                        <div class="timeline-icon bg-system">
                            <span class="fa fa-fire"></span>
                        </div>
                        <div class="timeline-desc">
                            <b>Admin</b> created a new invoice for:
                            <a href="#">Software</a>
                        </div>
                        <div class="timeline-date">4:15am</div>
                    </li>
                    <li class="timeline-item">
                        <div class="timeline-icon bg-warning">
                            <span class="fa fa-pencil"></span>
                        </div>
                        <div class="timeline-desc">
                            <b>Laura</b> edited her work experience
                        </div>
                        <div class="timeline-date">5:25am</div>
                    </li>
                    <li class="timeline-item">
                        <div class="timeline-icon bg-success">
                            <span class="fa fa-usd"></span>
                        </div>
                        <div class="timeline-desc">
                            <b>Admin</b> created a new invoice for:
                            <a href="#">Software</a>
                        </div>
                        <div class="timeline-date">4:15am</div>
                    </li>
                    <li class="timeline-item">
                        <div class="timeline-icon bg-warning">
                            <span class="fa fa-pencil"></span>
                        </div>
                        <div class="timeline-desc">
                            <b>Laura</b> edited her work experience
                        </div>
                        <div class="timeline-date">5:25am</div>
                    </li>
                    <li class="timeline-item">
                        <div class="timeline-icon bg-success">
                            <span class="fa fa-usd"></span>
                        </div>
                        <div class="timeline-desc">
                            <b>Admin</b> created a new invoice for:
                            <a href="#">Apple Inc.</a>
                        </div>
                        <div class="timeline-date">7:45am</div>
                    </li>
                    <li class="timeline-item">
                        <div class="timeline-icon bg-dark light">
                            <span class="fa fa-tags"></span>
                        </div>
                        <div class="timeline-desc">
                            <b>Genry</b> Added a new item to his store:
                            <a href="#">Ipod</a>
                        </div>
                        <div class="timeline-date">8:25am</div>
                    </li>
                    <li class="timeline-item">
                        <div class="timeline-icon bg-dark light">
                            <span class="fa fa-tags"></span>
                        </div>
                        <div class="timeline-desc">
                            <b>Lion</b> Added a new item to his store:
                            <a href="#">Watch</a>
                        </div>
                        <div class="timeline-date">9:35am</div>
                    </li>
                </ol>

            </aside>
            <!-- -------------- /Column Right -------------- -->

        </section>
        <!-- -------------- /Content -------------- -->

        @if(\Route::getFacadeRoot()->current()->uri() == 'dashboard' || \Route::getFacadeRoot()->current()->uri() == 'welcome' || \Route::getFacadeRoot()->current()->uri() == 'change-password' ||
        \Route::getFacadeRoot()->current()->uri() == 'not-found' )
        <!-- -------------- Page Footer -------------- -->
        <footer id="content-footer" class="affix">
            <div class="row">
                <div class="col-md-6">
                    <span class="footer-legal">Human Resource Management System © 2016 All rights reserved. By <a
                                href="mailto:andrewarianda@gmail.com.com?Subject=HRM%20Software" target="_blank">Clint A. Andrew</a></span>
                </div>
                <div class="col-md-6 text-right">
                    <span class="footer-meta"></span>
                    <a href="#content" class="footer-return-top">
                        <span class="fa fa-angle-up"></span>
                    </a>
                </div>
            </div>
        </footer>
        <!-- -------------- /Page Footer -------------- -->
        @endif

    </section>
    <!-- -------------- /Main Wrapper -------------- -->

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
h
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





<!-- -------------- Scripts -------------- -->

<!-- -------------- jQuery -------------- -->
<script src="{{ URL::asset('assets/js/jquery/jquery-1.11.3.min.js') }}"></script>
{{--<script src="{{ URL::asset('assets/js/jquery/jquery-2.2.4.min.js') }}"></script>--}}
<script src="{{ URL::asset('assets/js/jquery/jquery_ui/jquery-ui.min.js') }}"></script>

<!-- -------------- HighCharts Plugin -------------- -->
<script src="{{ URL::asset('assets/js/plugins/highcharts/highcharts.js') }}"></script>
<script src="{{ URL::asset('assets/js/plugins/c3charts/d3.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/plugins/c3charts/c3.min.js') }}"></script>

<!-- -------------- Simple Circles Plugin -------------- -->
<script src="{{ URL::asset('assets/js/plugins/circles/circles.js') }}"></script>

<!-- -------------- Maps JSs -------------- -->
<script src="{{ URL::asset('assets/js/plugins/jvectormap/jquery.jvectormap.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/plugins/jvectormap/assets/jquery-jvectormap-us-lcc-en.js') }}"></script>

<!-- -------------- FullCalendar Plugin -------------- -->
<script src="{{ URL::asset('assets/js/plugins/fullcalendar/lib/moment.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/plugins/fullcalendar/fullcalendar.min.js') }}"></script>

<!-- -------------- Date/Month - Pickers -------------- -->
<script src="{{ URL::asset('assets/allcp/forms/js/jquery-ui-monthpicker.min.js') }}"></script>
<script src="{{ URL::asset('assets/allcp/forms/js/jquery-ui-datepicker.min.js') }}"></script>

<!-- -------------- Magnific Popup Plugin -------------- -->
<script src="{{ URL::asset('assets/js/plugins/magnific/jquery.magnific-popup.js') }}"></script>

<!-- -------------- Theme Scripts -------------- -->
<script src="{{ URL::asset('assets/js/utility/utility.js') }}"></script>
<script src="{{ URL::asset('assets/js/demo/demo.js') }}"></script>
<script src="{{ URL::asset('assets/js/main.js') }}"></script>

<!-- -------------- Widget JS -------------- -->
<script src="{{ URL::asset('assets/js/demo/widgets.js') }}"></script>
<script src="{{ URL::asset('assets/js/demo/widgets_sidebar.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/dashboard1.js') }}"></script>

<!-- Sweet alert -->
<script src="{{ URL::asset('assets/js/sweetalert.min.js') }}"></script>

@if(\Route::getFacadeRoot()->current()->uri() == 'assign-asset')
    <script src="{{ URL::asset('assets/js/pages/forms-widgets.js') }}"></script>
    <script src="{{ URL::asset('assets/js/custom.js') }}"></script>
@endif

@if(\Route::getFacadeRoot()->current()->uri() == 'assign-project')
    <script src="{{ URL::asset('assets/js/pages/forms-widgets.js') }}"></script>
    <script src="{{ URL::asset('assets/js/custom.js') }}"></script>
@endif

@if(\Route::getFacadeRoot()->current()->uri() == 'assign-award')
    <script src="{{ URL::asset('assets/js/pages/forms-widgets.js') }}"></script>
    <script src="{{ URL::asset('assets/js/custom.js') }}"></script>
@endif

@if(\Route::getFacadeRoot()->current()->uri() == 'edit-award-assignment/{id}')
    <script src="{{ URL::asset('assets/js/pages/forms-widgets.js') }}"></script>
    <script src="{{ URL::asset('assets/js/custom.js') }}"></script>
@endif

@if(\Route::getFacadeRoot()->current()->uri() == 'add-expense')
    <script src="{{ URL::asset('assets/js/pages/forms-widgets.js') }}"></script>
    <script src="{{ URL::asset('assets/js/custom.js') }}"></script>
@endif

@if(\Route::getFacadeRoot()->current()->uri() == 'attendance-manager')
    <script src="{{ URL::asset('assets/js/custom.js') }}"></script>
@endif
@if(\Route::getFacadeRoot()->current()->uri() == 'total-leave-list')
    <script src="{{ URL::asset('assets/js/custom.js') }}"></script>
@endif

@if(\Route::getFacadeRoot()->current()->uri() == 'apply-leave')
    <script src="{{ URL::asset('assets/js/function.js') }}"></script>
    <script src="{{ URL::asset('assets/js/custom.js') }}"></script>
    @endif

<script src="{{ URL::asset('assets/js/function.js') }}"></script>
@if(\Route::getFacadeRoot()->current()->uri() == 'edit-asset-assignment/{id}')
    <script src="{{ URL::asset('assets/js/pages/forms-widgets.js') }}"></script>
    <script src="{{ URL::asset('assets/js/custom.js') }}"></script>
@endif

@if(\Route::getFacadeRoot()->current()->uri() == 'promotion')
    <script src="{{ URL::asset('assets/js/pages/forms-widgets.js') }}"></script>
    <script src="{{ URL::asset('assets/js/custom.js') }}"></script>
@endif

@if(\Route::getFacadeRoot()->current()->uri() == 'edit-promotion/{id}')
    <script src="{{ URL::asset('assets/js/pages/forms-widgets.js') }}"></script>
    <script src="{{ URL::asset('assets/js/custom.js') }}"></script>
@endif

@if(\Route::getFacadeRoot()->current()->uri() == 'add-training-invite')
    <script src="{{ URL::asset('assets/js/pages/forms-widgets.js') }}"></script>
    <script src="{{ URL::asset('assets/js/custom.js') }}"></script>
@endif

@if(\Route::getFacadeRoot()->current()->uri() == 'edit-training-invite/{id}')
    <script src="{{ URL::asset('assets/js/pages/forms-widgets.js') }}"></script>
    <script src="{{ URL::asset('assets/js/custom.js') }}"></script>
@endif

@if(\Route::getFacadeRoot()->current()->uri() == 'add-training-invite')
    <script src="{{ URL::asset('assets/allcp/forms/js/bootstrap-select.js') }}"></script>
@endif
@if(\Route::getFacadeRoot()->current()->uri() == 'edit-training-invite/{id}')
    <script src="{{ URL::asset('assets/allcp/forms/js/bootstrap-select.js') }}"></script>
@endif


@if(\Route::getFacadeRoot()->current()->uri() == 'apply-leave' )
    <script src="{{ URL::asset('assets/js/custom.js') }}"></script>
    <script src="{{ URL::asset('assets/js/function.js') }}"></script>
@endif

<!-- -------------- /Scripts -------------- -->

@if(\Route::getFacadeRoot()->current()->uri() == 'add-employee' )
<script src="{{ URL::asset('assets/js/custom_form_wizard.js') }}"></script>
    @endif

    @if(\Route::getFacadeRoot()->current()->uri() == 'attendance-upload' )
        <script src="{{ URL::asset('assets/js/pages/forms-widgets.js') }}"></script>
    @endif

    @if(\Route::getFacadeRoot()->current()->uri() == 'add-team')
        <script src="{{ URL::asset('assets/allcp/forms/js/bootstrap-select.js') }}"></script>
    @endif
@if(\Route::getFacadeRoot()->current()->uri() == 'edit-team/{id}')
    <script src="{{ URL::asset('assets/allcp/forms/js/bootstrap-select.js') }}"></script>
@endif
@if(\Route::getFacadeRoot()->current()->uri() == 'create-event')
        <!-- -------------- DateTime JS -------------- -->
    <script src="{{ URL::asset('assets/js/plugins/datepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
@endif
@if(\Route::getFacadeRoot()->current()->uri() == 'create-meeting')
    <!-- -------------- DateTime JS -------------- -->
    <script src="{{ URL::asset('assets/js/plugins/datepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
@endif
    <script>
        $('#datetimepicker2').datetimepicker();


        (function($) {
            $.fn.blink = function(options) {
                var defaults = {
                    delay: 3000
                };
                var options = $.extend(defaults, options);

                return this.each(function() {
                    var obj = $(this);
                    setInterval(function() {
                        if ($(obj).css("visibility") == "visible") {
                            $(obj).css('visibility', 'hidden');
                        }
                        else {
                            $(obj).css('visibility', 'visible');
                        }
                    }, options.delay);
                });
            }
        }(jQuery))

        /////////////////////////////////////////////

        $(document).ready(function() {
            $('.blink').blink(); // default is 500ms blink interval.
            $('.blink_second').blink({
                delay: 100
            }); // causes a 100ms blink interval.
            $('.blink_third').blink({
                delay: 1500
            }); // causes a 1500ms blink interval.
        });

        /////////////////////////////////////////////

</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-108812473-2"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-108812473-2');
</script>


<script src="{{ URL::asset('assets/js/pages/allcp_forms-elements.js') }}"></script>
</body>
</html>