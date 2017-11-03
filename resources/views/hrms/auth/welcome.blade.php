@extends('hrms.layouts.base')

@section('content')
        <!-- START CONTENT -->
<div class="content">
    <section id="content" class="pn animated fadeIn">

    <div class="center-block mt100 mw800 text-center p20">
        <img src="{{ URL::asset('assets/img/HRMS.png') }}" alt="" class="img-responsive mauto"/>
        <h4 class="mt40 mb10"> Welcome! </h4>
        <div>
            <div class="col-md-6">
            <h2 class="mt40 mb20"><a href="/dashboard"><i class="fa fa-arrow-circle-o-left"> Dashboard </i></a></h2>
            </div>
            <div class="col-md-6">
            <h2 class="mt40 mb20"><a href="/profile"> Profile <i class="fa fa-arrow-circle-o-right"> </i></a></h2>
            </div>
        </div>
    </div>
   </section>
</div>
@endsection