@extends('master')

@section('title', 'Dashboard')

@section('content')
    <section id="content">
        <div class="container">
            <div class="mini-charts">
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <div class="mini-charts-item bgm-cyan">
                            <div class="clearfix">
                                <div class="chart stats-bar"></div>
                                <div class="count">
                                    <small>New Users</small>
                                    <h2>98</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-3">
                        <div class="mini-charts-item bgm-lightgreen">
                            <div class="clearfix">
                                <div class="chart stats-bar-2"></div>
                                <div class="count">
                                    <small>New Questions</small>
                                    <h2>30</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-3">
                        <div class="mini-charts-item bgm-orange">
                            <div class="clearfix">
                                <div class="chart stats-line"></div>
                                <div class="count">
                                    <small>Current Answers</small>
                                    <h2>298</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-3">
                        <div class="mini-charts-item bgm-bluegray">
                            <div class="clearfix">
                                <div class="chart stats-line-2"></div>
                                <div class="count">
                                    <small>All Users</small>
                                    <h2>856</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dash-widgets">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div id="site-visits" class="dash-widget-item bgm-teal">
                            <div class="dash-widget-header">
                                <div class="p-20">
                                    <div class="dash-widget-visits"></div>
                                </div>
                                
                                <div class="dash-widget-title">For the past 30 days</div>
                                
                                <!-- <ul class="actions actions-alt">
                                    <li class="dropdown">
                                        <a href="#" data-toggle="dropdown">
                                            <i class="zmdi zmdi-more-vert"></i>
                                        </a>
                                        
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a href="#">Refresh</a>
                                            </li>
                                            <li>
                                                <a href="#">Manage Widgets</a>
                                            </li>
                                            <li>
                                                <a href="#">Widgets Settings</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul> -->
                            </div>
                            
                            <div class="p-20">
                                
                                <small>All Users</small>
                                <h3 class="m-0 f-400">47,896</h3>
                                
                                <br/>
                                
                                <small>All Questions</small>
                                <h3 class="m-0 f-400">24,45</h3>
                                
                                <br/>
                                
                                <small>All Answers</small>
                                <h3 class="m-0 f-400">1358</h3>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-sm-6">
                        <div class="card">
                            <div class="listview">
                                <div class="lv-header">
                                    Messages
                                </div>
                                <div class="lv-body">
                                    @for($i=0; $i <= 4; $i++)
                                    <a class="lv-item" href="#">
                                        <div class="media">
                                            <div class="pull-left">
                                                <img class="lv-img-sm" src="{{Request::root()}}/img/headers/sm/7.png" alt="">
                                            </div>
                                            <div class="media-body">
                                                <div class="lv-title">David Belle</div>
                                                <small class="lv-small">Cum sociis natoque penatibus et magnis dis parturient montes</small>
                                            </div>
                                        </div>
                                    </a>
                                    @endfor
                                    <a class="lv-footer" href="#">
                                        View All 
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>                        

                    <div class="col-md-4 col-sm-6">
                        <div id="best-selling" class="dash-widget-item">
                            <div class="dash-widget-header">
                                <div class="dash-widget-title">Title</div>
                                <img src="{{Request::root()}}/img/headers/sm/3.png" alt="">
                                <div class="main-item">
                                    <small>Sub Title .....</small>
                                    <h2></h2>
                                </div>
                            </div>
                        
                            <div class="listview p-t-5">
                                <a class="lv-item" href="#">
                                    <div class="media">
                                        <div class="pull-left">
                                            <img class="lv-img-sm" src="{{Request::root()}}/img/headers/sm/3.png" alt="">
                                        </div>
                                        <div class="media-body">
                                            <div class="lv-title">New Title .....</div>
                                            <small class="lv-small">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</small>
                                        </div>
                                    </div>
                                </a>
                                <a class="lv-item" href="#">
                                    <div class="media">
                                        <div class="pull-left">
                                            <img class="lv-img-sm" src="{{Request::root()}}/img/headers/sm/3.png" alt="">
                                        </div>
                                        <div class="media-body">
                                            <div class="lv-title">New Title .....</div>
                                            <small class="lv-small">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</small>
                                        </div>
                                    </div>
                                </a>
                                <a class="lv-item" href="#">
                                    <div class="media">
                                        <div class="pull-left">
                                            <img class="lv-img-sm" src="{{Request::root()}}/img/headers/sm/3.png" alt="">
                                        </div>
                                        <div class="media-body">
                                            <div class="lv-title">New Title .....</div>
                                            <small class="lv-small">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</small>
                                        </div>
                                    </div>
                                </a>
                                
                                <a class="lv-footer" href="#">
                                    View All
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
	@parent
        <script src="{{Request::root()}}/vendors/sparklines/jquery.sparkline.min.js"></script>
        <script src="{{Request::root()}}/js/charts.js"></script>
@endsection