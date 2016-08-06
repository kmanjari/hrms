<header class="navbar navbar-fixed-top bg-dark">
    <div class="navbar-logo-wrapper">
        <a class="navbar-logo-text" href="#">
            <b> Digital IP Insights </b>
        </a>
        <span id="sidebar_left_toggle" class="ad ad-lines"></span>
    </div>
    <ul class="nav navbar-nav navbar-left">
        <li class="hidden-xs">
            <a class="navbar-fullscreen toggle-active" href="#">
                <span class="glyphicon glyphicon-fullscreen"></span>
            </a>
        </li>
    </ul>
    <form class="navbar-form navbar-left search-form square" role="search">
        <div class="input-group add-on">

            <input type="text" class="form-control" placeholder="Search..." onfocus="this.placeholder=''"
                   onblur="this.placeholder='Search...'">

            <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
            </div>

        </div>
    </form>
    <ul class="nav navbar-nav navbar-right">

        <li class="dropdown dropdown-fuse">
            <div class="navbar-btn btn-group">

        <li class="dropdown dropdown-fuse">
            <a href="#" class="dropdown-toggle fw600" data-toggle="dropdown">
                <span class="hidden-xs"><name>{{Auth::user()->name}}</name> </span>
                <span class="fa fa-caret-down hidden-xs mr15"></span>
                <img src="/assets/img/avatars/profile_pic.png" alt="avatar" class="mw55">
            </a>
            </a>
            <ul class="dropdown-menu list-group keep-dropdown w250" role="menu">

                <li class="list-group-item">
                    <a href="#" class="animated animated-short fadeInUp">
                        <span class="fa fa-cogs"></span> Settings </a>
                </li>
                <li class="dropdown-footer text-center">
                    <a href="/logout" class="btn btn-primary btn-sm btn-bordered">
                        <span class="fa fa-power-off pr5"></span> Logout </a>
                </li>
            </ul>
        </li>
    </ul>
</header>