<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title>{{ trans('main.'.Route::currentRouteName()) }} | {{ trans('main.site_name') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Tajawal:400,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/NewFront/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/NewFront/css/bootstrap/rtl/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/NewFront/css/bootstrap/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/NewFront/css/bootstrap/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/NewFront/css/bootstrap/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/NewFront/css/bootstrap/owl.theme.green.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/NewFront/css/style.css') }}">

    {{--@if(LaravelLocalization::getCurrentLocale() =='ar')--}}
    {{--@endif--}}

    <!--[if lt IE 9]>
    <script src="{{ asset('public/NewFront/js/html5shiv.min') }}"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    {{--Meta tags for sharing on social media--}}
    <meta property="og:url"           content="{{ url()->current() }}" />
    <meta property="og:type"          content="article" />
    <meta property="og:title"         content="@if(session()->has('share_title')) {{ session()->get('share_title') }} @endif" />
    <meta property="og:description"   content="@if(session()->has('share_description')) {{ session()->get('share_description') }} @endif" />
    <meta property="og:image"         content="@if(session()->has('share_image')) {{ session()->get('share_image') }} @endif" />

    <link rel="shortcut icon" type="image/png" href="{{ asset('public/NewFront/images/favicon.ico') }}"/>
    @yield('style')

</head>
<body>