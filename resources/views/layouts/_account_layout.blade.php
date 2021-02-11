<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="utf-8"/>
    <title>مركز معاً | @yield('title')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css?family=El+Messiri" rel="stylesheet">

    <link href="{{asset('metronic-rtl/assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('metronic-rtl/assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}"
          rel="stylesheet" type="text/css"/>
    <link href="{{asset('metronic-rtl/assets/global/plugins/bootstrap/css/bootstrap-rtl.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('metronic-rtl/assets/global/plugins/bootstrap-switch/css/bootstrap-switch-rtl.min.css')}}"
          rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet"
          type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN THEME GLOBAL STYLES -->

    <link href="{{asset('metronic-rtl/assets/global/css/components-md-rtl.min.css')}}" rel="stylesheet"
          id="style_components" type="text/css"/>
    <link href="{{asset('metronic-rtl/assets/global/css/plugins-md-rtl.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{asset('metronic-rtl/assets/layouts/layout/css/layout-rtl.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('metronic-rtl/assets/layouts/layout/css/themes/blue-rtl.min.css')}}" rel="stylesheet"
          type="text/css" id="style_color"/>
    <link href="{{asset('metronic-rtl/assets/layouts/layout/css/custom-rtl.min.css')}}" rel="stylesheet"
          type="text/css"/>

    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="/lib/img/Group%20124.ico"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">

    <style type="text/css">
        {{--  Ask Maram--}}
        @media (min-width: 992px) {
            .page-sidebar {
                width: 275px !important;
            }
            .page-content-wrapper .page-content {
                margin-right: 280px !important;
            }
        }

        .close{
            background-image: none !important;
            background: none !important;
            text-indent:0 !important;
        }

        .datepicker{
            direction: rtl;
            padding-right: 15px;
        }


        *, h1, h3, h4 {
            font-family: 'Open Sans', sans-serif;
            font-family: 'El Messiri', sans-serif;
            letter-spacing: 0px;
        }
        *, h1, h2, h3, h4, h5 ,h6, a, span, i, small, p {
            letter-spacing: 0px;
        }
        h3 {
            / / text-align: center;
            color: #2D5F8B !important;
        }

        .breadcrumb > li, .pagination {
            display: block;
        }

        .form-error {

            border: 2px solid #e74c3c;
        }

        .page-title {
            font-size: 24px;
        }

        .panel.info-panel {
            padding: 3px 15px;
            background: #BE2D45;
            color: #fff;
        }

        .info-panel h4 {
            line-height: 1.8;
            font-size: 14px;
        }

        .adv-search {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .page-title {
            font-size: 22px;
            font-weight: 500;
        }

            .page-title i.fa {
            }

        #mybody h4, .page-content h4 {
            color: #626262;
            font-size: 16px;
        }
        /*custome style*/
        .form-inline {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            -ms-flex-flow: row wrap;
            flex-flow: row wrap;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
        }

        .table {
            border: 2px solid #eaeaea;
        }

            .table > thead > tr {
                background-color: #ed6b75;
                color: #fff !important;
            }

        .table {
            text-align: center;
        }

            .table > thead > tr > th {
                border-bottom: none;
                text-align: center;
            }

            .table > tbody > tr > td {
                border-bottom: 1px solid #F8F8F8;
                border-top: 0;
                padding: 1rem;
            }

                .table > tbody > tr > td:last-of-type {
                    text-align: right;
                }

        .table-advance thead tr th {
            background-color: #ed6b75;
            color: #fff !important;
            font-size: 14px;
            font-weight: 400;
        }

        .table > thead > tr > th {
            vertical-align: middle !important;
        }

        .table > tbody > tr > td, .table > thead > tr > th {
            font-size: 12px !important;
        }

        input.form-control, select.form-control {
            border-left: 3px solid #BE2D45 !important;
            color: #000000;
        }

        label {
            padding-right: 0px !important;
        }

        input.btn, a.btn-light {
            border-radius: .4285rem !important;
            padding: .9rem 2rem !important;
            font-size: 1.4rem !important;
        }

        .btn-light {
            border: 1px solid #BE2D45 !important;
            color: #BE2D45 !important;
        }

        .pagination > li:first-child > a, .pagination > li:first-child > span {
            margin-right: 0;
            border-bottom-right-radius: unset;
            border-top-right-radius: unset;
        }

        .pagination > .disabled > a, .pagination > .disabled > a:focus, .pagination > .disabled > a:hover, .pagination > .disabled > span, .pagination > .disabled > span:focus, .pagination > .disabled > span:hover {
            border-color: unset;
        }

        .pagination > li > a, .pagination > li > span {
            border: unset;
            border-radius: 15%;
            color: rgba(0,0,0,.6);
            font-weight: 700;
        }

        .pagination > .active > a, .pagination > .active > a:focus, .pagination > .active > a:hover, .pagination > .active > span, .pagination > .active > span:focus, .pagination > .active > span:hover {
            background-color: #2bbbab;
            border-color: #2bbbab;
            line-height: 1.2;
        }

        .page-header.navbar .top-menu .navbar-nav > li.dropdown-extended .dropdown-menu > li.external {
            background: #BE2D45 !important;
        }

            .page-header.navbar .top-menu .navbar-nav > li.dropdown-extended .dropdown-menu > li.external > a {
                color: #ffffff !important;
            }

                .page-header.navbar .top-menu .navbar-nav > li.dropdown-extended .dropdown-menu > li.external > a:hover {
                    color: #ffffff !important;
                }

            .page-header.navbar .top-menu .navbar-nav > li.dropdown-extended .dropdown-menu > li.external > h3 {
                color: #ffffff !important;
            }

        .page-header.navbar .top-menu .navbar-nav > li.dropdown-extended .dropdown-menu:after {
            border-bottom-color: #BE2D45 !important;
        }

        .page-header.navbar .top-menu .navbar-nav > li.dropdown-extended .dropdown-menu > li.external {
            text-align: center;
            color: #fff;
        }

        .page-header.navbar .top-menu .navbar-nav > li.dropdown-extended .dropdown-menu .dropdown-menu-list > li > a {
            padding: 16px 5px 10px !important;
        }

        .page-header.navbar .top-menu .navbar-nav > li.dropdown-notification .dropdown-menu .dropdown-menu-list > li > a .time {
            background: unset !important;
            color: #626262 !important;
            font-weight: 600 !important;
        }

        .page-header.navbar .top-menu .navbar-nav > li.dropdown-extended .dropdown-menu .dropdown-menu-list {
            padding: 0.3rem !important border: none !important;
            border-bottom: 1px solid #DAE1E7 !important;
        }

        .justify-content-between {
            -webkit-box-pack: justify !important;
            -webkit-justify-content: space-between !important;
            -ms-flex-pack: justify !important;
            justify-content: space-between !important;
        }

        .align-items-start {
            -webkit-box-align: start !important;
            -webkit-align-items: flex-start !important;
            -ms-flex-align: start !important;
            align-items: flex-start !important;
        }

        .d-flex {
            display: -webkit-box !important;
            display: -webkit-flex !important;
            display: -ms-flexbox !important;
            display: flex !important;
        }

        .media-list {
            max-height: 18.2rem;
        }

            .media-list .media .media-left {
                padding-left: 1rem;
            }

        .media-body {
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            -ms-flex: 1;
            flex: 1;
        }

        .ps {
            overflow: hidden !important;
            overflow-anchor: none;
            -ms-overflow-style: none;
            touch-action: auto;
            -ms-touch-action: auto;
        }

        .media-list .media .media-body .media-title {
            color: #36c6d3;
        }

        .media-list .media .media-left i {
            color: #36c6d3;
        }

        .header-navbar .navbar-container .dropdown-menu-media .dropdown-menu-footer a {
            padding: .3rem;
            border-top: 1px solid #DAE1E7;
        }
        .p-2 {
            padding: 1.5rem!important;
        }
         .dropdown-header span{
            text-align:center;
        }
        .dropdown-header span{
            color:#fff;
        }
    .dropdown-header h3{
            color:#fff !important;
            font-size:20px !important;
            margin-top:0px !important;
        }
        ::placeholder {
            color: #000000 !important;
        }
    </style>
</head>

@yield('css')

<body class="page-header-fixed page-sidebar-closed-hide-logo page-md">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="/account" target="_blank">
                <img src="/lib/img/Group%20124.svg" style="width: 30px;margin: 11px" alt="logo" class="logo-default "/>
                <span style="color: #C0E6F9;font-size: 18px" class="logo-default ">مركز معاً</span>
            </a>
            <div class="menu-toggler sidebar-toggler">
                <span></span>
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
           data-target=".navbar-collapse">
            <span></span>
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
           <!--     <li class="dropdown" style="display: inline-table;"><a href="{{url('/')}}" class="dropdown-toggle" data-hover="dropdown" target="_blank"><span style="color: #b6d0e7; margin-right: -8%; !important;">واجهة الجمهور </span></a> </li> -->
                <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                    <?php
                    $count = count(auth()->user()->notifications()->whereNull('read_at')->get()->toArray());
                    $items = auth()->user()->notifications()->take(4)->orderBy('created_at', 'desc')->get();
                    ?>
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                       data-close-others="true">
                        <i class="icon-bell"></i>
                        <span class="badge badge-default" id="num_notif"> {{$count}} </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="external">
                            <div class="dropdown-header">
                                <h3> {{$count}} جديد </h3>
{{--                                <span>--}}
{{--                                    <span class="bold">الإشعارات</span>  مقروءة--}}
{{--                                </span>--}}
                            </div>
                        </li>
                        <li>
                            <ul class="dropdown-menu-list" id="notif" style="height: 300px;" data-handle-color="#637283">
                                @foreach($items as $a)
                                    <li id="{{$a->id}}"  @if(empty($a->read_at) || is_null($a->read_at)) style="border-left: 4px solid #2d5f8b;" @endif>
                                        <a href="{{$a->link}}" class="d-flex justify-content-between">
                                            <div class="media d-flex align-items-start">
                                    <div class="media-left">
                                        <i class="icon-plus"></i>
                                    </div>

                                    <div class="media-body">
                                        <span class="media-title">
                                            {{$a->type}}</i>
                                </span>
                                <span class="details"
                                      style="display:block; max-width: 100%;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;margin-bottom: .5rem;
                                                            font-size: smaller;
                                                            color: #626262;">
                                    {{$a->title}}

                                </span>
                            </div>
                            <small><span class="time">{{$a->created_at->format('m/d/Y')}}</span></small>

                        </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="dropdown-menu-footer"><a class="dropdown-item p-1 text-center" href="/account/notifications"> عرض جميع الإشعارات </a></li>

                    </ul>
                </li>
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                       data-close-others="true">
                        <?php
                        if (!Auth::guest()) {
                            Auth::user()->account->image;
                            if (Auth::user()->account->image == null) {
                                $image = "http://placehold.it/300/300";
                            } else {
                                if (file_exists(public_path() . '/images/' . Auth::user()->account->id . '/' . Auth::user()->account->image) && Auth::user()->account->image != null)
                                    $image = asset('/images/' . Auth::user()->account->id . '/' . Auth::user()->account->image);
                                else
                                    $image = "http://placehold.it/300/300";
                            }
                        } else
                            $image = "http://placehold.it/300/300";
                        ?>
                        <span class="username username-hide-on-mobile">
                            <?php $test = Auth::user()->account->account_projects->where('project_id', "!=", "1")->groupBy('rate')?>

                             {{ Auth::user()->account->full_name }} </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">

                        <li>
                            <a href="/account/home/change-password">
                                <i class="icon-lock"></i> تغيير كلمة المرور </a>
                        </li>
                        <li>
                            <a href="/account/account/profile/{{Auth::user()->account->id}}">
                                <i class="icon-lock"></i> تعديل بياناتك </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="icon-key"></i>
                                تسجيل خروج
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"></div>
<!-- END HEADER & CONTENT DIVIDER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true"
                data-slide-speed="200" style="padding-top: 20px">
                <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                <li class="sidebar-toggler-wrapper hide">
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                    <div class="sidebar-toggler">
                        <span></span>
                    </div>
                    <!-- END SIDEBAR TOGGLER BUTTON -->
                </li>
                <?php
                $adminId = Auth::user()->account->id;
                /*$links = \DB::table("links")->where("parent_id",0)->
                    whereRaw('id in (select link_id from admin_link where admin_id=?)',$adminId)->get();*/
                $links = Auth::user()->account->links->where("show_menu", 1)->where("parent_id", 0);
                ?>
                                                    <li class="nav-item">
                                                        <a href="{{url('/account')}}" class="nav-link nav-toggle">
                                                            <i class="icon-diamond"></i>
                                                            <span class="title">الصفحة الرئيسية</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{url('/')}}" class="nav-link nav-toggle">
                                                            <i class="icon-diamond"></i>
                                                            <span class="title">واجهة الجمهور</span>
                                                        </a>
                                                    </li>

                @foreach($links as $link)
                    <?php
                    /*$sublinks = \DB::table("link")->
                        whereRaw('id in (select link_id from admin_link where admin_id=?)',$adminId)->where("parent_id",$link->id)->get();*/

                    $sublinks = Auth::user()->account->links->where("show_menu", 1)->where("parent_id", $link->id);

                    $sub_sublinks_error =\App\Link::where("parent_id", $link->id);

                    ?>
                    <li class="nav-item  {{ strstr("/".Route::getFacadeRoot()->current()->uri(),$sub_sublinks_error->first()->url)?
                                            "open":'' }} ">
                        <a href="{{$link->url}}" class="nav-link nav-toggle">
                            <i class="{{$link->icon}}"></i>
                            <span class="title">{{$link->title}}</span>
                            <span class="arrow"></span>
                        </a>

                        <ul class="sub-menu" {{ strstr("/".Route::getFacadeRoot()->current()->uri(),$sub_sublinks_error->first()->url)?"style=display:block;":'' }}>
                            @foreach($sublinks as $sublink)
                                @if($sublink->title != 'الرد على الشكاوى' && $sublink->title != 'ادارة الشكاوى')
                                    <li class="nav-item  ">
                                        <a href="{{$sublink->url}}"
                                           @if($sublink->title == 'اضافة شكوى') target="_blank" @endif
                                           class="nav-link ">
                                            <span class="title">{{$sublink->title}}</span>
                                        </a>
                                    </li>

                                    @if($sublink->id == 9 )
                                        <?php
                                        $spcial =\App\Link::where("id", 11)->first();
                                        ?>
                                        <li class="nav-item  ">
                                            <a href="{{$spcial->url}}"
                                               @if($spcial->title == 'اضافة شكوى') target="_blank" @endif
                                               class="nav-link ">
                                                <span class="title">{{$spcial->title}}</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if($sublink->id == 13 )
                                        <?php
                                        $spcial =\App\Link::where("id", 41)->first();
                                        ?>
                                        <li class="nav-item  ">
                                            <a href="{{$spcial->url}}"
                                               class="nav-link ">
                                                <span class="title">{{$spcial->title}}</span>
                                            </a>
                                        </li>
                                    @endif



                                @endif
                            @endforeach
                        </ul>

                    </li>
                @endforeach
            </ul>
            <!-- END SIDEBAR MENU -->
            <!-- END SIDEBAR MENU -->
        </div>
        <!-- END SIDEBAR -->
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="page-title"><span class='fa @yield("title_icon")' aria-hidden='true'></span>  @yield("title")
                <small>@yield("subtitle")</small>
                &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp;
                <a  style="width:220px;" title="الصلاحيات" href="/back">
                @yield("title2")
            </a>
            </h3>
                </div>
            </div>

            <!-- END PAGE TITLE-->
            <!-- BEGIN PAGE BAR -->
            <!--<div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="index.html">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span>Page Layouts</span>
                    </li>
                </ul>
            </div>-->
            @include("_msg")
            @yield('content')
        </div>
        <!-- END CONTENT BODY -->
    </div>
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="page-footer-inner"> {{date("Y")}} جميع الحقوق محفوظة &copy; .

    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>

<div class="modal fade" id="Confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">تأكيد</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                هل انت متأكد من الاستمرار في العملية
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء الامر</button>
                <a href="#" class="btn btn-danger">نعم, متأكد</a>
            </div>
        </div>
    </div>
</div>

<script src="/metronic-rtl/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/metronic-rtl/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script src="/metronic-rtl/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="/metronic-rtl/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"
        type="text/javascript"></script>
<script src="/metronic-rtl/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js"
        type="text/javascript"></script>
<script src="/metronic-rtl/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/metronic-rtl/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"
        type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="/metronic-rtl/assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="/metronic-rtl/assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
<script src="/metronic-rtl/assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
<script src="/metronic-rtl/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>

<script>
    $(function () {
        //$("#Confirm").modal("show");
        $(".Confirm").click(function () {
            $("#Confirm").modal("show");
            $("#Confirm .btn-danger").attr("href", $(this).attr("href"));
            return false;
        });
    });
</script>
<script type="text/javascript">
    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd'
    });
</script>
<script src="https://js.pusher.com/4.3/pusher.min.js"></script>
<script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('078a9e270cf0ebc41e05', {
        cluster: 'ap2',
        forceTLS: true
    });

    var channel = pusher.subscribe('my-channel');
    var user_id = '{{auth()->user()->id}}';
    channel.bind(user_id, function(data) {
        //alert(JSON.stringify(data));
        // if(data.user_id == user_id) {
        var li = document.createElement("li");
        li.innerHTML = "<a href='" + data.link + "'> <span class='time'>" + data.date + "</span>  " +
            "<span class='details' style='display:block; max-width: 100%;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;'> " +
            "<span class='label label-sm label-icon label-success'>" + data.type +"</i> " +
            "</span> " + data.title + " </span> </a>";

        document.getElementById("notif").prepend(li);
        var num_notif = document.getElementById("num_notif");
        num_notif.innerHTML = "";
        num_notif.innerHTML ="<span>" + data.num_notif + "</span>";

        var audio = new Audio('audio/unsure.mp3');
        audio.play();
        // }
    });
</script>
@yield("js")
</body>

</html>
