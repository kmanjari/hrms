@extends('hrms.layouts.base')

@section('content')
        <!-- START CONTENT -->
    <div class="content">


        <!-- //////////////////////////////////////////////////////////////////////////// -->
        <!-- START CONTAINER -->
        <div class="calendar-layout clearfix">

            <div class="col-md-2">

                <div id='external-events'>
                    <h6 class="font-title"><i class="fa fa-arrows"></i>Tasks</h6>
                    <p>Drag into calendar</p>
                    <div class='fc-event'>Meeting </div>
                    <div class='fc-event'>Party</div>
                    <div class='fc-event'>Invoices</div>
                    <div class='fc-event'>Call </div>
                    <div class='fc-event'>Meeting with Customers</div>
                    <div class='fc-event'>X</div>
                    <div class='fc-event'>Y</div>
                    <div class='fc-event'>Z</div>

                </div>

            </div>

            <div class="col-md-10">
                <div id='calendar'></div>
            </div>


        </div>
        <!-- END CONTAINER -->
        <!-- //////////////////////////////////////////////////////////////////////////// -->


        {{--<!-- Start Footer -->
        <div class="row footer">
            <div class="col-md-6 text-left">
                Copyright © 2015 <a href="http://themeforest.net/user/egemem/portfolio" target="_blank">Egemem</a> All rights reserved.
            </div>
            <div class="col-md-6 text-right">
                Design and Developed by <a href="http://themeforest.net/user/egemem/portfolio" target="_blank">Egemem</a>
            </div>
        </div>--}}
        <!-- End Footer -->


    </div>
    <!-- End Content -->
    <!-- //////////////////////////////////////////////////////////////////////////// -->


    <!-- //////////////////////////////////////////////////////////////////////////// -->



    <!-- ================================================
    jQuery Library
    ================================================ -->
    <script type="text/javascript" src="js/jquery.min.js"></script>

    <!-- ================================================
    Bootstrap Core JavaScript File
    ================================================ -->
    <script src="js/bootstrap/bootstrap.min.js"></script>

    <!-- ================================================
    Plugin.js - Some Specific JS codes for Plugin Settings
    ================================================ -->
    <script type="text/javascript" src="js/plugins.js"></script>

    <!-- ================================================
    jQuery UI
    ================================================ -->
    <script type="text/javascript" src="js/jquery-ui/jquery-ui.min.js"></script>

    <!-- ================================================
    Moment.js
    ================================================ -->
    <script type="text/javascript" src="js/moment/moment.min.js"></script>

    <!-- ================================================
    Full Calendar
    ================================================ -->
    <script type="text/javascript" src="js/full-calendar/fullcalendar.js"></script>


    <script>

        $(document).ready(function() {


            /* initialize the external events
             -----------------------------------------------------------------*/
            $('#external-events .fc-event').each(function() {

                // store data so the calendar knows to render an event upon drop
                $(this).data('event', {
                    title: $.trim($(this).text()), // use the element's text as the event title
                    stick: true // maintain when user navigates (see docs on the renderEvent method)
                });

                // make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 999,
                    revert: true,      // will cause the event to go back to its
                    revertDuration: 0  //  original position after the drag
                });

            });


            /* initialize the calendar
             -----------------------------------------------------------------*/
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                defaultDate: '2016-05-01',
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar
                eventLimit: true, // allow "more" link when too many events
                /*events: [
                    {
                        title: 'All Day Event',
                        start: '2016-05-01',
                        color: '#9A80B9'
                    },
                    {
                        id: 999,
                        title: 'Repeating Event',
                        start: '2016-05-22T16:00:00'
                    },

                    {
                        title: 'Conference',
                        start: '2016-05-11',
                        end: '2016-05-14',
                        color: '#E99844'
                    },
                ]*/
            });

        });


    </script>

@endsection