<!DOCTYPE html>
<html>

<head>
    <!-- -------------- Meta and Title -------------- -->
    <meta charset="utf-8">
    <title> HRMS </title>
    <meta name="keywords" content="HTML5, Bootstrap 3, Admin Template, UI Theme"/>
    <meta name="description" content="Alliance - A Responsive HTML5 Admin UI Framework">
    <meta name="author" content="ThemeREX">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- -------------- Fonts -------------- -->
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet'
          type='text/css'>


    <!-- -------------- Icomoon -------------- -->
    {!! Html::style('/assets/fonts/icomoon/icomoon.css') !!}

            <!-- -------------- CSS - theme -------------- -->
    {!! Html::style('/assets/skin/default_skin/css/theme.css') !!}

            <!-- -------------- CSS - allcp forms -------------- -->
    {!! Html::style('/assets/allcp/forms/css/forms.css') !!}

    {!! Html::style('/assets/custom.css') !!}

            <!-- -------------- Favicon -------------- -->
    <link rel="shortcut icon" href="/assets/img/favicon.png">

    <!-- -------------- IE8 HTML5 support  -------------- -->
    <!--[if lt IE 9]>
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js') !!}
    <![endif]-->

</head>

<body class="forms-wizard">

<!-- -------------- Customizer -------------- -->
<div id="customizer">
    <div class="panel">
        <div class="panel-heading">
        <span class="panel-icon">
          <i class="fa fa-cogs"></i>
        </span>
            <span class="panel-title"> Theme Options</span>
        </div>
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


                @include('hrms.layouts.sidebar')

                        <!-- -------------- Sidebar Hide Button -------------- -->
                <div class="sidebar-toggler">
                    <a href="/dashboard">
                        <span class="fa fa-arrow-circle-o-left"></span>
                    </a>
                </div>
                <!-- -------------- /Sidebar Hide Button -------------- -->

            </header>
        </div>
        <!-- -------------- /Sidebar Left Wrapper  -------------- -->

    </aside>

    <!-- -------------- Main Wrapper -------------- -->
    <section id="content_wrapper">

        <!-- -------------- Topbar -------------- -->
        <header id="topbar" class="alt">

            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')

                <div class="topbar-left">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-icon">
                            <a href="/dashboard">
                                <span class="fa fa-home"></span>
                            </a>
                        </li>
                        {{-- <li class="breadcrumb-active">
                             <a href="#"> Edit Details</a>
                         </li>--}}
                        <li class="breadcrumb-link">
                            <a href="/dashboard"> Employees </a>
                        </li>
                        <li class="breadcrumb-current-item"> Edit details of {{$emps->name}} </li>
                    </ol>
                </div>

            @else

                <div class="topbar-left">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-icon">
                            <a href="/dashboard">
                                <span class="fa fa-home"></span>
                            </a>
                        </li>
                        <li class="breadcrumb-active">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                        <li class="breadcrumb-link">
                            <a href="/add-employee"> Employees </a>
                        </li>
                        <li class="breadcrumb-current-item"> Add Details</li>
                    </ol>
                </div>

            @endif
        </header>
        <!-- -------------- /Topbar -------------- -->

        <!-- -------------- Content -------------- -->
        <section id="content" class="animated fadeIn">

            <div class="mw1000 center-block">
                @if(session('message'))
                    {{session('message')}}
                @endif
                @if(Session::has('flash_message'))
                    <div class="alert alert-success">
                        {{ session::get('flash_message') }}
                    </div>
                    @endif

                            <!-- -------------- Wizard -------------- -->
                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">

                        <form method="post" action="/" id="custom-form-wizard">
                            <div class="wizard steps-bg steps-left">

                                <!-- -------------- step 1 -------------- -->
                                <h4 class="wizard-section-title">
                                    <i class="fa fa-user pr5"></i> Personal Details</h4>
                                <section class="wizard-section">
                                    <div class="section">
                                        <label for="photo-upload"><h6 class="mb20 mt40"> Photo </h6></label>
                                        <label class="field prepend-icon append-button file">
                                            <span class="button">Choose File</span>
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="hidden" value="edit-emp/{{$emps->id}}" id="url">

                                                <input type="file" class="gui-file" name="photo" id="photo_upload"
                                                       value="@if($emps && $emps->photo){{$emps->photo}}@endif"
                                                       onChange="document.getElementById('uploader1').value = this.value;">
                                                <input type="text" class="gui-input" id="uploader1"
                                                       placeholder="Select File">
                                                <label class="field-icon">
                                                    <i class="fa fa-cloud-upload"></i>
                                                </label>
                                            @else
                                                <input type="hidden" value="add-employee" id="url">
                                                <input type="file" class="gui-file" name="photo" id="photo_upload"
                                                       onChange="document.getElementById('uploader1').value = this.value;">
                                                <input type="text" class="gui-input" id="uploader1"
                                                       placeholder="Select File">
                                                <label class="field-icon">
                                                    <i class="fa fa-cloud-upload"></i>
                                                </label>
                                            @endif
                                        </label>
                                    </div>

                                    <!-- -------------- /section -------------- -->

                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40">Employee Code</h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" name="emp_code" id="emp_code" class="gui-input"
                                                       value="@if($emps && $emps->employee->code){{$emps->employee->code}}@endif" required>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-barcode"></i>
                                                </label>
                                            @else
                                                <input type="text" name="emp_code" id="emp_code" class="gui-input"
                                                       placeholder="employee code..." required>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-barcode"></i>
                                                </label>
                                            @endif
                                        </label>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40">Employee Name </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" name="emp_name" id="emp_name" class="gui-input"
                                                       value="@if($emps && $emps->employee->name){{$emps->employee->name}}@endif" required>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-user"></i>
                                                </label>
                                            @else
                                                <input type="text" name="emp_name" id="emp_name" class="gui-input"
                                                       placeholder="employee name..." required>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-user"></i>
                                                </label>
                                            @endif
                                        </label>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40">Employment Status </h6></label>
                                        <div class="option-group field">
                                            <label class="field option mb5">
                                                @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="radio" name="emp_status" id="emp_status" value="1"
                                                       @if(isset($emps))@if($emps->employee->status == '1') checked @endif @endif>
                                                <span class="radio"></span>Present</label>
                                            <label class="field option mb5">
                                                <input type="radio" name="emp_status" id="emp_status" value="0"
                                                       @if(isset($emps))@if($emps->employee->status == '0') checked @endif @endif>
                                                <span class="radio"></span>Ex</label>
                                            @else
                                                <input type="radio" name="emp_status" id="emp_status" value="1">
                                                <span class="radio"></span>Present</label>
                                                <label class="field option mb5">
                                                    <input type="radio" name="emp_status" id="emp_status" value="0" checked>
                                                    <span class="radio"></span>Ex</label>
                                            @endif
                                        </div>
                                    </div>

                                        <div class="section">
                                            <label for="input002"><h6 class="mb20 mt40"> Role </h6></label>
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <select class="select2-single form-control" name="role" id="role" readonly required>
                                                    <option value="">Select role</option>
                                                    @foreach($roles as $role)
                                                        @if($emps->role->role->id == $role->id)
                                                            <option value="{{$role->id}}" selected>{{$role->name}}</option>
                                                        @endif
                                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                                    @endforeach
                                                </select>
                                                @else
                                                <select class="select2-single form-control" name="role" id="role">
                                                    <option value="">Select role</option>
                                                    @foreach($roles as $role)
                                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>

                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Gender </h6></label>
                                        <div class="option-group field">
                                            <label class="field option mb5">
                                                <input type="radio" value="0" name="gender" id="gender"
                                                       @if(isset($emps))@if($emps->employee->gender == '0')checked @endif @endif>
                                                <span class="radio"></span>Male</label>
                                            <label class="field option mb5">
                                                <input type="radio" value="1" name="gender" id="gender"
                                                       @if(isset($emps))@if($emps->employee->gender == '1')checked @endif @endif>
                                                <span class="radio"></span>Female</label>
                                        </div>
                                    </div>


                                    <div class="section">
                                        <label for="datepicker1" class="field prepend-icon mb5"><h6 class="mb20 mt40">
                                                Date of Birth </h6></label>

                                        <div class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" id="datepicker1" class="gui-input fs13" name="dob"
                                                       value="@if($emps && $emps->employee->date_of_birth){{$emps->employee->date_of_birth}}@endif" required>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            @else
                                                <input type="text" id="datepicker1" class="gui-input fs13" name="dob" required>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="section">
                                        <label for="datepicker4" class="field prepend-icon mb5"><h6 class="mb20 mt40">
                                                Date of Joining </h6></label>

                                        <div class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" id="datepicker4" class="gui-input fs13" name="doj"
                                                       value="@if($emps && $emps->employee->date_of_joining){{$emps->employee->date_of_joining}}@endif" required>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            @else
                                                <input type="text" id="datepicker4" class="gui-input fs13" name="doj" required>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Mobile Number </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="number" name="mob_number" id="mobile_phone"
                                                       class="gui-input phone-group" maxlength="10" minlength="10" required
                                                       value="@if($emps && $emps->employee->number){{$emps->employee->number}}@endif">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-mobile-phone"></i>
                                                </label>
                                            @else
                                                <input type="number" name="mob_number" id="mobile_phone"
                                                       class="gui-input phone-group" maxlength="10" minlength="10" required
                                                       placeholder="mobile number...">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-mobile-phone"></i>
                                                </label>
                                            @endif
                                        </label>
                                    </div>

                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Qualification </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')

                                                {!! Form::select('qualification_list', qualification(),$emps->employee->qualification, ['class' => 'select2-single form-control qualification_select', 'id' => 'qualification']) !!}
                                                <input type="text" id="qualification" class="gui-input form-control hidden qualification_text" placeholder="enter other qualification" value="{{$emps->employee->qualification}}"/>

                                            @else
                                               {!! Form::select('qualification_list', qualification(),'', ['class' => 'select2-single form-control qualification_select', 'id' => 'qualification']) !!}
                                               <input type="text" id="qualification" class="gui-input form-control hidden qualification_text" placeholder="enter other qualification"/>
                                            @endif
                                            </label>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Emergency Number </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="number" name="emer_number" id="emergency_number"
                                                       class="gui-input phone-group" maxlength="10" minlength="10"
                                                       value="@if($emps && $emps->employee->emergency_number){{$emps->employee->emergency_number}}@endif">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-mobile-phone"></i>
                                                </label>
                                            @else
                                                <input type="number" name="emer_number" id="emergency_number"
                                                       class="gui-input phone-group" maxlength="10" minlength="10"
                                                       placeholder="Emergency number">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-mobile-phone"></i>
                                                </label>
                                            @endif
                                        </label>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> PAN Number </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" name="pan_number" id="pan_number" class="gui-input"
                                                       value="@if($emps && $emps->employee->pan_number){{$emps->employee->pan_number}}@endif">
                                            @else
                                                <input type="text" placeholder="PAN" name="pan_number"
                                                       id="pan_number" class="gui-input">

                                            @endif
                                        </label>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Father's Name </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" name="father_name" id="father_name" class="gui-input"
                                                       value="@if($emps && $emps->employee->father_name){{$emps->employee->father_name}}@endif">

                                            @else
                                                <input type="text" placeholder="Employees' father name"
                                                       name="father_name" id="father_name" class="gui-input">

                                            @endif
                                        </label>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Current Address </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" name="address" id="address" class="gui-input"
                                                       value="@if($emps && $emps->employee->current_address){{$emps->employee->current_address}}@endif">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-map-marker"></i>
                                                </label>
                                            @else
                                                <input type="text" placeholder="current address..." name="address"
                                                       id="address" class="gui-input">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-map-marker"></i>
                                                </label>
                                            @endif
                                        </label>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Permanent Address </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" name="permanent_address" id="permanent_address"
                                                       class="gui-input"
                                                       value="@if($emps && $emps->employee->permanent_address){{$emps->employee->permanent_address}}@endif">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-location-arrow"></i>
                                                </label>
                                            @else
                                                <input type="text" placeholder="permanent address..."
                                                       name="permanent_address" id="permanent_address"
                                                       class="gui-input">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-location-arrow"></i>
                                                </label>
                                            @endif
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->
                                </section>

                                <!-- -------------- step 2 -------------- -->
                                <h4 class="wizard-section-title">
                                    <i class="fa fa-user-secret pr5"></i> Employment details</h4>
                                <section class="wizard-section">
                                    <!-- -------------- /section -------------- -->
                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Joining Formalities </h6></label>

                                        <div class="option-group field">
                                            <label class="field option mb5">
                                                <input type="radio" value="1" name="formalities"
                                                       id="formalities"
                                                       @if(isset($emps))@if($emps->employee->formalities == '1')checked @endif @endif>
                                                <span class="radio"></span>Completed</label>
                                            <label class="field option mb5">
                                                <input type="radio" value="0" name="formalities" id="formalities"
                                                       @if(isset($emps))@if($emps->employee->formalities == '0')checked @endif @endif>
                                                <span class="radio"></span>Pending</label>
                                        </div>
                                    </div>

                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Offer Acceptance </h6></label>

                                        <div class="option-group field">
                                            <label class="field option mb5">
                                                <input type="radio" value="1" name="offer_acceptance"
                                                       id="offer_acceptance"
                                                       @if(isset($emps))@if($emps->employee->offer_acceptance == '1')checked @endif @endif>
                                                <span class="radio"></span>Completed</label>
                                            <label class="field option mb5">
                                                <input type="radio" value="0" name="offer_acceptance"
                                                       id="offer_acceptance"
                                                       @if(isset($emps))@if($emps->employee->offer_acceptance == '0')checked @endif @endif>
                                                <span class="radio"></span>Pending</label>
                                        </div>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Probation Period </h6></label>

                                                @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                            <select class="select2-single form-control probation_select" name="prob_period" id="probation_period" >
                                                <option value="">Select probation period</option>
                                                    @if($emps->employee->probation_period == '0')
                                                        <option value="0" selected>0 days</option>
                                                        <option value="90">90 days</option>
                                                        <option value="180">180 days</option>
                                                        <option value="Other">Other</option>
                                                    @elseif($emps->employee->probation_period == '90')
                                                        <option value="0">0 days</option>
                                                        <option value="90" selected>90 days</option>
                                                        <option value="180">180 days</option>
                                                        <option value="Other">Other</option>
                                                    @elseif($emps->employee->probation_period == '180')
                                                        <option value="0">0 days</option>
                                                        <option value="90">90 days</option>
                                                        <option value="180" selected>180 days</option>
                                                        <option value="Other">Other</option>
                                                     @else
                                                        <option value="0">0 days</option>
                                                        <option value="90">90 days</option>
                                                        <option value="180">180 days</option>
                                                        <option value="Other" selected>Other</option>

                                                    @endif
                                            </select>
                                                    <input type="text" class="form-control probation_text hidden" id="probation_text" value={{$emps->employee->probation_period}}>
                                                @else
                                                    <select class="select2-single form-control probation_select" name="prob_period" id="probation_period" >
                                                    <option value="">Select probation period</option>
                                                    <option value="0">0 days</option>
                                                    <option value="90">90 days</option>
                                                    <option value="180">180 days</option>
                                                    <option value="Other">Other</option>
                                                    </select>
                                            <input type="text" class="form-control probation_text hidden" id="probation_text">
                                                @endif


                                    </div>



                                    <div class="section">
                                        <label for="datepicker5" class="field prepend-icon mb5"><h6 class="mb20 mt40">
                                                Date of Confirmation </h6></label>

                                        <div class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" id="datepicker5" class="gui-input fs13" name="doc"
                                                       value="@if($emps && $emps->employee->date_of_confirmation){{$emps->employee->date_of_confirmation}}@endif"/>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            @else
                                                <input type="text" id="datepicker5" class="gui-input fs13" name="doc"/>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Department </h6></label>
                                            <select class="select2-single form-control" name="department" id="department">
                                                <option value="">Select department</option>
                                                @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                    @if($emps->employee->department == 'Marketplace')
                                                        <option value="Marketplace" selected>Marketplace</option>
                                                        <option value="Social Media">Social Media</option>
                                                        <option value="IT">IT</option>
                                                    @elseif($emps->employee->department == 'Social Media')
                                                        <option value="Marketplace">Marketplace</option>
                                                        <option value="Social Media" selected>Social Media</option>
                                                        <option value="IT">IT</option>
                                                    @else
                                                        <option value="Marketplace">Marketplace</option>
                                                        <option value="Social Media">Social Media</option>
                                                        <option value="IT" selected>IT</option>
                                                    @endif
                                                @else
                                                    <option value="Marketplace">Marketplace</option>
                                                    <option value="Social Media">Social Media</option>
                                                    <option value="IT">IT</option>
                                                @endif
                                            </select>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Salary on Confirmation </h6>
                                        </label>
                                        <label for="input002" class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" name="salary" id="salary" class="gui-input"
                                                       value="@if($emps && $emps->employee->salary){{$emps->employee->salary}}@endif" readonly>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-inr"></i>
                                                </label>
                                            @else
                                                <input type="text" placeholder="e.g 12000" name="salary"
                                                       id="salary" class="gui-input">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-inr"></i>
                                                </label>
                                            @endif
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->


                                </section>

                                <!-- -------------- step 3 -------------- -->
                                <h4 class="wizard-section-title">
                                    <i class="fa fa-file-text pr5"></i> Banking Details</h4>
                                <section class="wizard-section">


                                    <!-- -------------- /section -------------- -->


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Bank Account Number </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" name="account_number" id="bank_account_number"
                                                       class="gui-input"
                                                       value="@if($emps && $emps->employee->account_number){{$emps->employee->account_number}}@endif">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-list"></i>
                                                </label>
                                            @else
                                                <input type="text" placeholder="Bank account number"
                                                       name="account_number" id="bank_account_number" class="gui-input">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-list"></i>
                                                </label>
                                            @endif
                                        </label>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Bank Name </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" name="bank_name" id="bank_name" class="gui-input"
                                                       value="@if($emps && $emps->employee->bank_name){{$emps->employee->bank_name}}@endif">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-columns"></i>
                                                </label>
                                            @else
                                                <input type="text" placeholder="name of bank..." name="bank_name"
                                                       id="bank_name" class="gui-input">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-columns"></i>
                                                </label>
                                            @endif
                                        </label>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> IFSC Code </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" name="ifsc_code" id="ifsc_code" class="gui-input"
                                                       value="@if($emps && $emps->employee->ifsc_code){{$emps->employee->ifsc_code}}@endif">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-font"></i>
                                                </label>
                                            @else
                                                <input type="text" placeholder="ifsc code..." name="ifsc_code"
                                                       id="ifsc_code" class="gui-input">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-font"></i>
                                                </label>
                                            @endif
                                        </label>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> PF Account Number </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" name="pf_account_number" id="pf_account_number"
                                                       class="gui-input"
                                                       value="@if($emps && $emps->employee->pf_account_number){{$emps->employee->pf_account_number}}@endif">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-list"></i>
                                                </label>
                                            @else
                                                <input type="text" placeholder="PF account number..."
                                                       name="pf_account_number" id="pf_account_number"
                                                       class="gui-input">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-list"></i>
                                                </label>
                                            @endif
                                        </label>
                                    </div>

                                   <div class="section">
                                       <label for="input002"><h6 class="mb20 mt40"> UN Number</h6></label>
                                       <label for="input002" class="field prepend-icon">
                                           @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                              <input type="text" name="un_number" id="un_number" class="gui-input"
                                              value="@if($emps && $emps->employee->un_number){{$emps->employee->un_number}}@endif">
                                               <label for="input002" class="field-icon">
                                                   <i class="fa fa-list"></i>
                                               </label>
                                           @else
                                             <input type="text" placeholder="UN Number" name="un_number" id="un_number" class="gui-input">
                                              <label for="input002" class="field-icon">
                                                  <i class="fa fa-list"></i>
                                              </label>
                                           @endif
                                       </label>
                                   </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> PF Status </h6></label>

                                        <div class="option-group field">
                                            <label class="field option mb5">
                                                <input type="radio" value="1" name="pf_status" id="pf_status"
                                                       @if(isset($emps))@if($emps->employee->pf_status == '1')checked @endif @endif>
                                                <span class="radio"></span>Active</label>
                                            <label class="field option mb5">
                                                <input type="radio" value="0" name="pf_status" id="pf_status"
                                                       @if(isset($emps))@if($emps->employee->pf_status == '0')checked @endif @endif>
                                                <span class="radio"></span>Inactive</label>
                                        </div>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                </section>


                                <h4 class="wizard-section-title">
                                    <i class="fa fa-file-text pr5"></i> Ex Employment Details </h4>
                                <section class="wizard-section">


                                    <div class="section">
                                        <label for="datepicker6" class="field prepend-icon mb5"><h6 class="mb20 mt40">
                                                Date of Resignation </h6></label>

                                        <div class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" id="datepicker6" class="gui-input fs13" name="dor"
                                                       value="@if($emps && $emps->employee->date_of_resignation){{$emps->employee->date_of_resignation}}@endif"/>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            @else
                                                <input type="text" id="datepicker6" class="gui-input fs13" name="dor"/>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Notice Period </h6></label>
                                            <select class="select2-single form-control" name="notice_period" id="notice_period">
                                                <option value="">Select notice period</option>
                                                @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                    @if($emps->employee->notice_period == '1')
                                                        <option value="1" selected>1 Month</option>
                                                        <option value="2">2 Months</option>
                                                    @else
                                                        <option value="1">1 Month</option>
                                                        <option value="2" selected>2 Months</option>
                                                    @endif
                                                @else
                                                    <option value="1">1 Month</option>
                                                    <option value="2">2 Months</option>
                                                @endif
                                            </select>
                                    </div>


                                    <div class="section">
                                        <label for="datepicker7" class="field prepend-icon mb5"><h6 class="mb20 mt40">
                                                Last Working Day </h6></label>

                                        <div class="field prepend-icon">
                                            @if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}')
                                                <input type="text" id="datepicker7" class="gui-input fs13"
                                                       name="last_working_day"
                                                       value="@if($emps && $emps->employee->last_working_day){{$emps->employee->last_working_day}} @endif"/>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            @else
                                                <input type="text" id="datepicker7" class="gui-input fs13"
                                                       name="last_working_day"/>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Full & Final </h6></label>

                                        <div class="option-group field">
                                            <label class="field option mb5">
                                                <input type="hidden" value="{!! csrf_token() !!}" id="token">
                                                <input type="radio" value="1" name="full_final" id="full_final"
                                                       @if(isset($emps))@if($emps->employee->full_final == '1')checked @endif @endif>
                                                <span class="radio"></span>Yes</label>
                                            <label class="field option mb5">
                                                <input type="radio" value="0" name="full_final" id="full_final"
                                                       @if(isset($emps))@if($emps->employee->full_final == '0')checked @endif @endif>
                                                <span class="radio"></span>No</label>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <!-- -------------- /Wizard -------------- -->

                        </form>
                        <!-- -------------- /Form -------------- -->

                    </div>
                    <!-- -------------- /Spec Form -------------- -->

            </div>

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

<!-- Notification modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="notification-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="modal-header" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- /Notification Modal -->
<style>
    /*page demo styles*/
    .wizard .steps .fa,
    .wizard .steps .glyphicon,
    .wizard .steps .glyphicon {
        display: none;
    }
</style>

<!-- -------------- Scripts -------------- -->

<!-- -------------- jQuery -------------- -->
{!! Html::script('/assets/js/jquery/jquery-1.11.3.min.js') !!}
{!! Html::script('/assets/js/jquery/jquery_ui/jquery-ui.min.js') !!}

        <!-- -------------- HighCharts Plugin -------------- -->
{!! Html::script('/assets/js/plugins/highcharts/highcharts.js') !!}

        <!-- -------------- MonthPicker JS -------------- -->
{!! Html::script('/assets/allcp/forms/js/jquery-ui-monthpicker.min.js') !!}
{!! Html::script('/assets/allcp/forms/js/jquery-ui-datepicker.min.js') !!}
{!! Html::script('/assets/allcp/forms/js/jquery.spectrum.min.js') !!}
{!! Html::script('/assets/allcp/forms/js/jquery.stepper.min.js') !!}


        <!-- -------------- Plugins -------------- -->
{!! Html::script('/assets/allcp/forms/js/jquery.validate.min.js') !!}
{!! Html::script('/assets/allcp/forms/js/jquery.steps.min.js') !!}

        <!-- -------------- Theme Scripts -------------- -->
{!! Html::script('/assets/js/utility/utility.js') !!}
{!! Html::script('/assets/js/demo/demo.js') !!}
{!! Html::script('/assets/js/main.js') !!}
{!! Html::script('/assets/js/demo/widgets_sidebar.js') !!}

{!! Html::script('/assets/js/custom_form_wizard.js') !!}

{!!  Html::script ('/assets/js/pages/forms-widgets.js')!!}

        <!-- -------------- Select2 JS -------------- -->
<script src="/assets/js/plugins/select2/select2.min.js"></script>
<script src="/assets/js/function.js"></script>


<!-- -------------- /Scripts -------------- -->

</body>

</html>