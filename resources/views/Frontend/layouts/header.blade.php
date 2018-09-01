<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ trans('main.'.Route::currentRouteName()) }} | {{ trans('main.site_name') }}</title>

    {{--Meta tags for sharing on social media--}}
    <meta property="og:url"           content="{{ url()->current() }}" />
    <meta property="og:type"          content="article" />
    <meta property="og:title"         content="@if(session()->has('share-title')) {{ session()->get('share-title') }} @endif" />
    <meta property="og:description"   content="@if(session()->has('share-description')) {{ session()->get('share-description') }} @endif" />
    <meta property="og:image"         content="@if(session()->has('share-image')) {{ session()->get('share-image') }} @endif" />

    <link rel="stylesheet" href="{{ asset('public/Frontend/css/fontawesome-all.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/Frontend/css/bootstrap.min.css') }}" />
    @if(session()->get('lang') =='ar')
        <link rel="stylesheet" href="{{ asset('public/Frontend/css/bootstrap-rtl.min.css') }}" />
    @endif
    <link rel="stylesheet" href="{{ asset('public/Frontend/css/slick.css') }}" />

    <link rel="stylesheet" href="{{ asset('public/Frontend/css/them.css') }}" />
    @if(session()->get('lang') =='ar')
        <link rel="stylesheet" href="{{ asset('public/Frontend/css/them.rtl.css') }}" />
    @endif

    <!--Fonts-->
    <link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js') }}"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js') }}"></script>
    <![endif]-->

    <link rel="shortcut icon" type="image/png" href="{{ asset('public/assets/layouts/layout/img/logo_icon.ico') }}"/>

    @yield('style')

</head>
<body>