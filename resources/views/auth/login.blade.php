<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>{{ Route::currentRouteName() }} | {{ config('app.name') }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="Preview page of HUD Systems Admin Theme #1 for " name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ asset('public/assets/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ asset('public/assets/global/css/components.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ asset('public/assets/global/css/plugins.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="{{ asset('public/assets/pages/css/login.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="{{ asset('public/assets/layouts/layout/img/logo_icon.ico') }}" /> </head>
<!-- END HEAD -->

<body class=" login">
<!-- BEGIN LOGO -->
<div class="logo">
    <img src="{{ asset('public/assets/layouts/layout/img/logo.png')}}" alt="{{ config('app.name') }}" />
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    {!! Form::open(['url'=>'login', 'class'=>'login-form']) !!}
    <h3 class="form-title font-green">{{ trans('admin.signin') }}</h3>
    @if(Session::has('error_login'))
        <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
            <span>{{ session()->get('error_login') }}</span>
        </div>
    @endif

    @if(count($errors))
        <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="form-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">{{ trans('admin.email') }}</label>
        {!! Form::email('email', old('email'), array('class'=>'form-control form-control-solid placeholder-no-fix','placeholder'=>trans('admin.enter_email'),'required'=>'required', 'autocomplete'=>'off')) !!}
    </div>

    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">{{ trans('admin.password') }}</label>
        {!! Form::password('password', array('class'=>'form-control form-control-solid placeholder-no-fix','placeholder'=>trans('admin.enter_password'),'required'=>'required', 'autocomplete'=>'off')) !!}
    </div>

    <div class="form-actions">
        {!! Form::submit(trans('admin.login'), array('class'=>'btn green uppercase')) !!}
        <label class="rememberme check mt-checkbox mt-checkbox-outline">
            <input type="checkbox" name="remember" value="1" />{{ trans('admin.remember') }}
            <span></span>
        </label>
        {{--<a href="{{ url('/password/reset') }}" id="forget-password" class="forget-password">{{ trans('admin.forgot_password') }}</a>--}}
    </div>
    {!! Form::close() !!}
<!-- END LOGIN FORM -->
    <!-- BEGIN FORGOT PASSWORD FORM -->
    {!! Form::open(['url'=>'admins/forget', 'class'=>'forget-form']) !!}
    <h3 class="font-green">{{ trans('admin.forgot_password') }}</h3>
    <p> {{ trans('admin.forgot_password_msg') }} </p>
    <div class="form-group">
        {!! Form::email('email', old('email'), array('class'=>'form-control placeholder-no-fix','placeholder'=>trans('admin.enter_email'),'required'=>'required', 'autocomplete'=>'off')) !!}
    </div>
    <div class="form-actions">
        <button type="button" id="back-btn" class="btn green btn-outline">{{ trans('admin.back') }}</button>

        {!! Form::submit(trans('admin.submit'), array('class'=>'btn btn-success uppercase pull-right')) !!}
    </div>
{!! Form::close() !!}
<!-- END FORGOT PASSWORD FORM -->
</div>
<div class="copyright">
    {{ date('Y') }} &copy; Made by <i class="fa fa-heart text-danger"></i>
    <a target="_blank" href="http://hudsystems.com/">HUD Systems</a>
</div>
<!--[if lt IE 9]>
<script src="{{ asset('public/assets/global/plugins/respond.min.js')}}"></script>
<script src="{{ asset('public/assets/global/plugins/excanvas.min.js')}}"></script>
<script src="{{ asset('public/assets/global/plugins/ie8.fix.min.js')}}"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="{{ asset('public/assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('public/assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('public/assets/global/plugins/js.cookie.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('public/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('public/assets/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('public/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ asset('public/assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('public/assets/global/plugins/jquery-validation/js/additional-methods.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('public/assets/global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{ asset('public/assets/global/scripts/app.min.js')}}" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ asset('public/assets/pages/scripts/login.min.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- END THEME LAYOUT SCRIPTS -->
</body>

</html>