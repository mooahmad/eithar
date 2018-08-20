<!DOCTYPE html>
<!--
Template Name: Admin Template - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.7
Version: 4.7.1
Author: ConsulTrust
Website: https://consultrustpro.com
Contact: support@consultrustpro.com
Follow: https://twitter.com/Consultrust
Linkedin: https://www.linkedin.com/company/22328290/
Like: https://www.facebook.com/consultrust/
-->
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8"/>
    <title>{{ Route::currentRouteName() }} | {{ config('app.name') }} Dashboard</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="Preview page of HUD Systems Admin Theme #1 for statistics, charts, recent events and reports"
          name="description"/>
    <meta content="HUD Systems" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="lang" content="{{ \Illuminate\Support\Facades\App::getLocale()  }}">

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('public/assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('public/assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('public/assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('public/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ asset('public/assets/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('public/assets/global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet"
          type="text/css"/>

    <link href="{{ asset('public/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}"
          rel="stylesheet" type="text/css"/>

    <link href="{{ asset('public/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css')}}" rel="stylesheet"
          type="text/css"/>

    <link href="{{ asset('public/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css')}}"
          rel="stylesheet" type="text/css"/>

    <link href="{{ asset('public/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}"
          rel="stylesheet" type="text/css"/>

    <link href="{{ asset('public/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}"
          rel="stylesheet" type="text/css"/>

    <link href="{{ asset('public/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}"
          rel="stylesheet" type="text/css"/>

    <link href="{{ asset('public/assets/global/plugins/clockface/css/clockface.css')}}" rel="stylesheet"
          type="text/css"/>

    <link href="{{ asset('public/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('public/assets/global/plugins/morris/morris.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('public/assets/global/plugins/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet"
          type="text/css"/>
    {{--lightbox--}}
    <link href="{{ asset('public/assets/global/css/lightbox.min.css')}}" rel="stylesheet" type="text/css"/>

    {{----}}
    <link href="{{ asset('public/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('public/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css') }}"
          rel="stylesheet" type="text/css"/>

    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ asset('public/assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components"
          type="text/css"/>
    <link href="{{ asset('public/assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{ asset('public/assets/layouts/layout/css/layout.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('public/assets/layouts/layout/css/themes/darkblue.min.css') }}" rel="stylesheet"
          type="text/css" id="style_color"/>
    <link href="{{ asset('public/assets/layouts/layout/css/custom.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="{{ asset('public/assets/layouts/layout/img/logo_icon.ico') }}"/>
    <!-- DataTables STYLES -->
    <link href="{{ asset('public/DataTables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('public/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('public/DataTables/Buttons-1.5.2/css/buttons.jqueryui.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('public/DataTables/Select-1.2.6/css/select.jqueryui.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Modals STYLES -->
    <link href="{{ asset('public/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css') }}" rel="stylesheet" type="text/css" />

    <!-- For All App STYLES keep it last file -->
    <link href="{{ asset('public/css/custom/app.css') }}" rel="stylesheet" type="text/css"/>

</head>


@yield('style')

<!-- END HEAD -->
<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
<div class="page-wrapper">
    <!-- BEGIN HEADER -->
    <div class="page-header navbar navbar-fixed-top">
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner ">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a target="_blank" href="{{ url('/') }}">
                    <img height="30" width="80" src="{{ asset('public/assets/layouts/layout/img/logo.png') }}"
                         alt="{{ config('app.name') }}" class="logo-default"/> </a>
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
        @include(ADL.'.top-menu')
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
    @include(ADL.'.menu')
    <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <!-- BEGIN PAGE HEADER-->
                <!-- BEGIN THEME PANEL -->
            {{--                        @include(ADL.'.theme-panel')--}}
            <!-- END THEME PANEL -->
                <!-- BEGIN PAGE BAR -->
            @include(ADL.'.page-bar')
            <!-- END PAGE BAR -->
                <!-- BEGIN PAGE TITLE-->
                <h1 class="page-title"> {{ config('app.name') }} Dashboard
                    <small>statistics, charts, recent events and reports</small>
                </h1>
                <!-- END PAGE TITLE-->
                <!-- END PAGE HEADER-->