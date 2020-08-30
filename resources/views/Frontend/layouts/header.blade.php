<!DOCTYPE html>
<html lang="{{LaravelLocalization::getCurrentLocale()}}" dir="{{LaravelLocalization::getCurrentLocaleDirection()}}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ trans('main.'.Route::currentRouteName()) }} | {{ trans('main.site_name') }}</title>

    {{--Meta tags for sharing on social media--}}
    <meta property="og:url"           content="{{ url()->current() }}" />
    <meta property="og:type"          content="article" />
    <meta property="og:title"         content="@if(session()->has('share_title')) {{ session()->get('share_title') }} @endif" />
    <meta property="og:description"   content="@if(session()->has('share_description')) {{ session()->get('share_description') }} @endif" />
    <meta property="og:image"         content="@if(session()->has('share_image')) {{ session()->get('share_image') }} @endif" />

    <link rel="stylesheet" href="{{ asset('public/Frontend/css/fontawesome-all.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/Frontend/css/bootstrap.min.css') }}" />
    @if(LaravelLocalization::getCurrentLocale() =='ar')
        <link rel="stylesheet" href="{{ asset('public/Frontend/css/bootstrap-rtl.min.css') }}" />
    @endif
    <link rel="stylesheet" href="{{ asset('public/Frontend/css/slick.css') }}" />

    <link rel="stylesheet" href="{{ asset('public/Frontend/css/them.css') }}" />
    @if(LaravelLocalization::getCurrentLocale() =='ar')
        <link rel="stylesheet" href="{{ asset('public/Frontend/css/them.rtl.css') }}" />
    @endif

    <!--Fonts-->
    <link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js') }}"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js') }}"></script>
    <![endif]-->

    <link rel="shortcut icon" type="image/png" href="{{ asset('public/Frontend/img/fivicon.png') }}"/>

    @yield('style')

</head>
<body>