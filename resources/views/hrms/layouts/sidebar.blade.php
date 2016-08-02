<!-- -------------- Sidebar - Author -------------- -->
<div class="sidebar-widget author-widget">
    <div class="media">
        <a class="media-left">
            <img src="assets/img/avatars/profile_pic.png" class="img-responsive">
        </a>

        <div class="media-body">
            <div class="media-author">{{Auth::user()->name}}</div>
        </div>
    </div>
</div>

<!-- -------------- Sidebar Menu  -------------- -->
<ul class="nav sidebar-menu">
    <li class="active">
        <a class="accordion-toggle menu-open" href="dashboard">
            <a href="dashboard">
            <span class="fa fa-dashboard"></span>
            <span class="sidebar-title">Dashboard</span>
        </a>
        </a>
    </li>
    <li>
        <a class="accordion-toggle" href="#">
            <span class="fa fa-share-square-o"></span>
            <span class="sidebar-title">Employees</span>
            <span class="caret"></span>
        </a>
        <ul class="nav sub-nav">
            <li>
                <a href="{{route('add-employee')}}">
                    <span class="glyphicon glyphicon-tags"></span> Add Employee </a>
            </li>
            <li>
                <a href="{{route('employee-manager')}}">
                    <span class="glyphicon glyphicon-tags"></span> Employee Listing </a>
            </li>
           <li>
                <a href="{{route('upload-emp')}}">
                    <span class="glyphicon glyphicon-tags"></span> Upload </a>
            </li>
        </ul>
    </li>

    <li>
        <a class="accordion-toggle" href="#">
            <span class="fa fa-wrench"></span>
            <span class="sidebar-title">Teams</span>
            <span class="caret"></span>
        </a>
        <ul class="nav sub-nav">
            <li>
                <a href="{{route('add-team')}}">
                    <span class="glyphicon glyphicon-book"></span> Add Team </a>
            </li>
            <li>
                <a href="{{route('team-listing')}}">
                    <span class="glyphicon glyphicon-modal-window"></span> Team Listings </a>
            </li>
        </ul>
    </li>

    <li>
        <a class="accordion-toggle" href="#">
            <span class="fa fa-wrench"></span>
            <span class="sidebar-title">Roles</span>
            <span class="caret"></span>
        </a>
        <ul class="nav sub-nav">
            <li>
                <a href="{{route('add-role')}}">
                    <span class="glyphicon glyphicon-book"></span> Add Role </a>
            </li>
            <li>
                <a href="{{route('role-list')}}">
                    <span class="glyphicon glyphicon-modal-window"></span> Role Listings </a>
            </li>
        </ul>
    </li>
    <li>
        <a class="accordion-toggle" href="#">
            <span class="fa fa-check-square-o"></span>
            <span class="sidebar-title">Assets</span>
            <span class="caret"></span>
        </a>
        <ul class="nav sub-nav">
            <li>
                <a href="{{route('add-asset')}}">
                    <span class="glyphicon glyphicon-shopping-cart"></span> Add Asset </a>
            </li>
            <li>
                <a href="{{route('asset-listing')}}">
                    <span class="glyphicon glyphicon-calendar"></span> Asset Listings </a>
            </li>
            <li>
                <a href="{{route('assign-asset')}}">
                    <span class="fa fa-desktop"></span> Assign Asset </a>
            </li>
            <li>
                <a href="{{route('assignment-listing')}}">
                    <span class="fa fa-clipboard"></span> Assignment Listings </a>
            </li>
        </ul>
    </li>

    <li>
        <a class="accordion-toggle" href="#">
            <span class="fa fa-check-square-o"></span>
            <span class="sidebar-title">Leaves</span>
            <span class="caret"></span>
        </a>
        <ul class="nav sub-nav">
            <li>
                <a href="{{route('apply-leave')}}">
                    <span class="glyphicon glyphicon-shopping-cart"></span> Apply Leave </a>
            </li>
            <li>
                <a href="#">
                    <span class="glyphicon glyphicon-calendar"></span> My Leave List </a>
            </li>
            <li>
                <a href="{{route('add-leave-type')}}">
                    <span class="fa fa-desktop"></span> Add Leave Type </a>
            </li>
            <li>
                <a href="{{route('leave-type-listing')}}">
                    <span class="fa fa-clipboard"></span> Leave Type Listings </a>
            </li>
            <li>
                <a href="{{route('leave-listing')}}">
                    <span class="fa fa-clipboard"></span> Total Leave Listings </a>
            </li>
        </ul>
    </li>

    <li class="sidebar-label pt30"> Extras </li>

    <li>
        <a href="#">
            <span class="fa fa-envelope-o"></span>
            <span class="sidebar-title"> Calendar </span>
        </a>
    </li>
    <li>
        <a href="#">
            <span class="fa fa-book"></span>
            <span class="sidebar-title"> Forms </span>
        </a>
    </li>
    <li>
        <a href="#">
            <span class="fa fa-book"></span>
            <span class="sidebar-title"> Documentation </span>
        </a>
    </li>
</ul>
<!-- -------------- /Sidebar Menu  -------------- -->