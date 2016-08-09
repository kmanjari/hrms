@extends('hrms.layouts.base')

@section('content')

    <section id="content" class="animated fadeIn">

        <div class="row" >

            <!-- -------------- FAQ Left Column -------------- -->
            <div class="col-md-12">

                <div class="panel bg-gradient">

                    <div class="mt40">
                        <h2 class="text-muted mb20 mtn"> Policies </h2>

                       {{-- {!! Form::open(['class' => 'form-horizontal','readonly']) !!}--}}
                        <div class="panel-group accordion" id="accordion1">
                            <div class="panel">
                                <div class="panel-heading">
                                    <a class="accordion-toggle accordion-icon link-unstyled collapsed"
                                       data-toggle="collapse"
                                       data-parent="#accordion1" href="#accordion1_1">
                                        1. Code of Conduct
                                    </a>
                                </div>
                                <div id="accordion1_1" class="panel-collapse collapse" style="height: 0px;">
                                    <div class="panel-body">
                                        <iframe src="/HTML/5_1A_Code_of_conduct/index.html" width="100%"
                                                height="400px"></iframe>
                                    </div>
                                </div>
                            </div>

                            <div class="panel">
                                <div class="panel-heading">
                                    <a class="accordion-toggle accordion-icon link-unstyled collapsed"
                                       data-toggle="collapse"
                                       data-parent="#accordion1" href="#accordion1_2">
                                        2. Drug and Alcohol Policy </a>
                                </div>
                                <div id="accordion1_2" class="panel-collapse collapse" style="height: 0px;">
                                    <div class="panel-body">
                                        <iframe src="/HTML/5_1C_Drug_and_Alcohol_Policy/index.html" width="100%"
                                                height="400px"></iframe>
                                    </div>
                                </div>
                            </div>

                            <div class="panel">
                                <div class="panel-heading">
                                    <a class="accordion-toggle accordion-icon link-unstyled collapsed"
                                       data-toggle="collapse"
                                       data-parent="#accordion1" href="#accordion1_3">
                                        3. Probation Policy </a>
                                </div>
                                <div id="accordion1_3" class="panel-collapse collapse" style="height: 0px;">
                                    <div class="panel-body">

                                        <iframe src="/HTML/5_2A_Probation_Policy/index.html" width="100%"
                                                height="400px"></iframe>

                                    </div>
                                </div>
                            </div>

                            <div class="panel">
                                <div class="panel-heading">
                                    <a class="accordion-toggle accordion-icon link-unstyled collapsed"
                                       data-toggle="collapse"
                                       data-parent="#accordion2" href="#accordion2_1">
                                        4. Resignation and Exit Policy </a>
                                </div>
                                <div id="accordion2_1" class="panel-collapse collapse" style="height: 0px;">
                                    <div class="panel-body">

                                        <iframe src="/HTML/5_2B_Resignation_and_Exit_Policy/index.html" width="100%"
                                                height="400px"></iframe>

                                    </div>
                                </div>
                            </div>

                            <div class="panel">
                                <div class="panel-heading">
                                    <a class="accordion-toggle accordion-icon link-unstyled collapsed"
                                       data-toggle="collapse"
                                       data-parent="#accordion2" href="#accordion2_2">
                                        5. Joining Policy </a>
                                </div>
                                <div id="accordion2_2" class="panel-collapse collapse" style="height: 0px;">
                                    <div class="panel-body">

                                        <iframe src="/HTML/5_2D_Joining_Policy/index.html" width="100%"
                                                height="400px"></iframe>

                                    </div>
                                </div>
                            </div>

                            <div class="panel">
                                <div class="panel-heading">
                                    <a class="accordion-toggle accordion-icon link-unstyled collapsed"
                                       data-toggle="collapse"
                                       data-parent="#accordion2" href="#accordion2_3">
                                        6. Recruitment Selection Policy </a>
                                </div>
                                <div id="accordion2_3" class="panel-collapse collapse" style="height: 0px;">
                                    <div class="panel-body">

                                        <iframe src="/HTML/5_2E_Recruitment__Selection_Policy/index.html" width="100%"
                                                height="400px"></iframe>

                                    </div>
                                </div>
                            </div>

                            <div class="panel">
                                <div class="panel-heading">
                                    <a class="accordion-toggle accordion-icon link-unstyled collapsed"
                                       data-toggle="collapse"
                                       data-parent="#accordion2" href="#accordion2_4">
                                        7. Office Timings Policy </a>
                                </div>
                                <div id="accordion2_4" class="panel-collapse collapse" style="height: 0px;">
                                    <div class="panel-body">

                                        <iframe src="/HTML/5_3A_Office_Timings_Policy/index.html" width="100%"
                                                height="400px"></iframe>

                                    </div>
                                </div>
                            </div>

                            <div class="panel">
                                <div class="panel-heading">
                                    <a class="accordion-toggle accordion-icon link-unstyled collapsed"
                                       data-toggle="collapse"
                                       data-parent="#accordion2" href="#accordion2_5">
                                        8. Leave Policy </a>
                                </div>
                                <div id="accordion2_5" class="panel-collapse collapse" style="height: 0px;">
                                    <div class="panel-body">

                                        <iframe src="/HTML/5_3B_Leave_Policy/index.html" width="100%"
                                                height="400px"></iframe>

                                    </div>
                                </div>
                            </div>

                            <div class="panel">
                                <div class="panel-heading">
                                    <a class="accordion-toggle accordion-icon link-unstyled collapsed"
                                       data-toggle="collapse"
                                       data-parent="#accordion2" href="#accordion2_6">
                                        9. Employee Welfare Scheme </a>
                                </div>
                                <div id="accordion2_6" class="panel-collapse collapse" style="height: 0px;">
                                    <div class="panel-body">

                                        <iframe src="/HTML/5_4E_Employee_Welfare_Scheme/index.html" width="100%"
                                                height="400px"></iframe>

                                    </div>
                                </div>
                            </div>

                            <div class="panel">
                                <div class="panel-heading">
                                    <a class="accordion-toggle accordion-icon link-unstyled collapsed"
                                       data-toggle="collapse"
                                       data-parent="#accordion2" href="#accordion2_7">
                                        10. Dress Code </a>
                                </div>
                                <div id="accordion2_7" class="panel-collapse collapse" style="height: 0px;">
                                    <div class="panel-body">

                                        <iframe src="/HTML/5_5_Dress_Code/index.html" width="100%"
                                                height="400px"></iframe>

                                    </div>
                                </div>
                            </div>

                            <div class="panel">
                                <div class="panel-heading">
                                    <a class="accordion-toggle accordion-icon link-unstyled collapsed"
                                       data-toggle="collapse"
                                       data-parent="#accordion2" href="#accordion2_8">
                                        11. Confidentiality Policy </a>
                                </div>
                                <div id="accordion2_8" class="panel-collapse collapse" style="height: 0px;">
                                    <div class="panel-body">

                                        <iframe src="/HTML/5_8B_Confidentiality_Policy/index.html" width="100%"
                                                height="400px"></iframe>

                                    </div>
                                </div>
                            </div>

                            <div class="panel">
                                <div class="panel-heading">
                                    <a class="accordion-toggle accordion-icon link-unstyled collapsed"
                                       data-toggle="collapse"
                                       data-parent="#accordion2" href="#accordion2_9">
                                        12. Assets Policy </a>
                                </div>
                                <div id="accordion2_9" class="panel-collapse collapse" style="height: 0px;">
                                    <div class="panel-body">

                                        <iframe src="/HTML/Assets_Policy/index.html" width="100%"
                                                height="400px"></iframe>

                                    </div>
                                </div>
                            </div>

                        </div>
                        {{--{!! Form::close() !!}--}}
                    </div>


                    {{--<div class="table-layout br-t">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-muted pl5 mt40 mb20"> Typical Questions </h5>
                                <ul class="fs15 list-splitter mb30">
                                    <li>
                                        <a class="link-unstyled" href="#" title="">
                                            <i class="fa fa-question text-alert pr10"></i> How do I
                                            recover or change my
                                            password?</a>
                                    </li>
                                    <li>
                                        <a class="link-unstyled" href="#" title="">
                                            <i class="fa fa-question text-alert pr10"></i> How do I
                                            track a subdomain?</a>
                                    </li>
                                    <li>
                                        <a class="link-unstyled" href="#" title="">
                                            <i class="fa fa-question text-alert pr10"></i> Can I use
                                            my data outside of
                                            ThemeREX?</a>
                                    </li>
                                    <li>
                                        <a class="link-unstyled" href="#" title="">
                                            <i class="fa fa-question text-alert pr10"></i> What does
                                            it mean when my Data
                                            doesn't ...</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-muted pl5 mt40 mb20"> Best Answers </h5>
                                <ul class="fs15 list-splitter mb30">
                                    <li>
                                        <a class="link-unstyled" href="#" title="">
                                            <i class="fa fa-exclamation text-success pr10"></i> How
                                            do I recover or change my
                                            password?</a>
                                    </li>
                                    <li>
                                        <a class="link-unstyled" href="#" title="">
                                            <i class="fa fa-exclamation text-success pr10"></i> How
                                            do I track a
                                            subdomain?</a>
                                    </li>
                                    <li>
                                        <a class="link-unstyled" href="#" title="">
                                            <i class="fa fa-exclamation text-success pr10"></i> Can I
                                            use my data outside of
                                            ThemeREX?</a>
                                    </li>
                                    <li>
                                        <a class="link-unstyled" href="#" title="">
                                            <i class="fa fa-exclamation text-success pr10"></i> What
                                            does it mean when my
                                            Data doesn't ...</a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>--}}
                </div>
            </div>
        </div>
        <!-- -------------- FAQ Right Column -------------- -->
        </div>

    </section>
    <!-- -------------- /Content -------------- -->

    </section>





@endsection