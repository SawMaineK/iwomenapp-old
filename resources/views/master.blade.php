<!DOCTYPE html>
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title') i-Women Administration </title>
        
        <!-- Vendor CSS -->
        <link href="{{Request::root()}}/vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
        <link href="{{Request::root()}}/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
        <link href="{{Request::root()}}/vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.css" rel="stylesheet">
        <link href="{{Request::root()}}/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
        
        @yield('style')
        <!-- CSS -->
        <link href="{{Request::root()}}/css/app.min.1.css" rel="stylesheet">
        <link href="{{Request::root()}}/css/app.min.2.css" rel="stylesheet">
       

    </head>
    <body>
        <header id="header">
            <ul class="header-inner">
                <li id="menu-trigger" data-trigger="#sidebar">
                    <div class="line-wrap">
                        <div class="line top"></div>
                        <div class="line center"></div>
                        <div class="line bottom"></div>
                    </div>
                </li>
            
                <li class="logo hidden-xs">
                    <a href="/admin/users">i-Women Administration</a>
                </li>
                
                <li class="pull-right">
                <ul class="top-menu">
                    
                    <!-- <li id="top-search">
                        <a class="tm-search" href="#"></a>
                    </li> -->
                    <li class="dropdown">
                        <a data-toggle="" class="" href="#" style="opacity:0">
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg pull-right">
                            
                        </div>
                    </li>
                    <li id="toggle-width">  
                        <label style="color:white;top:-14px; position:relative; margin-right:8px;">Menu On/Off</label>
                        <div class="toggle-switch">
                            <input id="tw-switch" type="checkbox" hidden="hidden">
                            <label for="tw-switch" class="ts-helper"></label>
                        </div>
                    </li>
                </li>
            </ul>
            
            <!-- Top Search Content -->
            <div id="top-search-wrap">
                <input type="text">
                <i id="top-search-close">&times;</i>
            </div>
        </header>
        
        <section id="main">
            <aside id="sidebar">
                <div class="sidebar-inner c-overflow">
                    <div class="profile-menu">
                        <a href="#">
                            <div class="profile-pic">
                                <img src="{{Request::root()}}/img/profile-pics/4.jpg" alt="">
                            </div>

                            <div class="profile-info">
                                Welcome {{@Auth::user()->first_name.' '. @Auth::user()->last_name}}
                                <i class="zmdi zmdi-arrow-drop-down  zmdi-settings"></i>
                            </div>
                        </a>

                        <ul class="main-menu">
                            <li>
                                <a href="#"><i class="zmdi zmdi-account"></i> View Profile</a>
                            </li>
                            <li>
                                <a href="/admin/logout"><i class="zmdi zmdi-time-restore"></i> Logout</a>
                            </li>
                        </ul>
                    </div>

                    <ul class="main-menu">
                        <li><a href="/admin/dashboard"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li><a href="/admin/users"><i class="zmdi zmdi zmdi-accounts"></i>Admin Users</a></li>
                        <li><a href="/admin/competition-question"><i class="zmdi zmdi zmdi zmdi-collection-text"></i>Competition Questions</a></li>
                        <!-- <li><a href="/admin/competition-answers"><i class="zmdi zmdi zmdi zmdi-layers"></i>Competition Answers</a></li> -->
                        <li class="sub-menu @if(isset($title)) toggled @endif">
                            <a href="#"><i class="zmdi zmdi zmdi zmdi-layers"></i>Competition Answers</a>

                            <ul @if(isset($title)) style="display: block;" @endif>
                                <li><a @if(isset($title) && $title=='Competition Answer List (Submitted)') class="active" @endif href="/admin/competition-answers">Submitted Answers</a></li>
                                <li><a @if(isset($title) && $title=='Competition Answer List (Unsubmitted)') class="active" @endif href="/admin/competition-answers?q=unsubimt">Unsubmitted Answers</a></li>
                            </ul>
                        </li>
                        <li><a href="/admin/group-users"><i class="zmdi zmdi zmdi zmdi-accounts-add"></i>Competition Group Users</a></li>

                        <!-- <li class="sub-menu">
                            <a href="#"><i class="zmdi zmdi-widgets"></i> Widgets</a>

                            <ul>
                                <li><a href="widget-templates.html">Templates</a></li>
                                <li><a class="active" href="widgets.html">Widgets</a></li>
                            </ul>
                        </li> -->
                        
                    </ul>
                </div>
            </aside>

            @yield('content')
        </section>

    </body>
  
   <script src="{{Request::root()}}/vendors/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="{{Request::root()}}/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <script src="{{Request::root()}}/vendors/bower_components/jquery.nicescroll/jquery.nicescroll.min.js"></script>
    <script src="{{Request::root()}}/vendors/bower_components/Waves/dist/waves.min.js"></script>
    <script src="{{Request::root()}}/vendors/bootstrap-growl/bootstrap-growl.min.js"></script>
    <script src="{{Request::root()}}/vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.min.js"></script>  
    <script src="{{Request::root()}}/vendors/bootgrid/jquery.bootgrid.min.js"></script>

    @yield('script')
    
    <script src="{{Request::root()}}/js/functions.js"></script>
    <script src="{{Request::root()}}/js/demo.js"></script>
    
</html>