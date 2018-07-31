@extends(ADL.'.master')

@section('style')
    <link href="{{ asset('public/assets/pages/css/profile.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}"
          rel="stylesheet" type="text/css"/>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">

            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light ">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- Create New User TAB -->
                                    <div class="tab-pane active" id="new_user">
                                        {!! Form::open(['method'=>(isset($user))? 'PUT' : 'POST','url'=> $formRoute, 'role'=>'form', 'enctype' => "multipart/form-data"]) !!}
                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.fname') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('first_name', (isset($user))? $user->first_name : old('first_name') , array('id'=>'first_name', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.fname'))) !!}
                                            @if($errors->has('first_name'))
                                                <span class="help-block text-danger">{{ $errors->first('first_name') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.mname') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('middle_name',(isset($user))? $user->middle_name : old('middle_name'), array('id'=>'middle_name', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.mname'))) !!}
                                            @if($errors->has('middle_name'))
                                                <span class="help-block text-danger">{{ $errors->first('middle_name') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.lname') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('last_name',(isset($user))? $user->last_name : old('last_name'), array('id'=>'last_name', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.lname'))) !!}
                                            @if($errors->has('last_name'))
                                                <span class="help-block text-danger">{{ $errors->first('last_name') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="email" class="control-label">
                                                {{ trans('admin.email') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::email('email',(isset($user))? $user->email : old('email'), array('id'=>'email', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.email'))) !!}
                                            @if($errors->has('email'))
                                                <span class="help-block text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="mobile" class="control-label">
                                                {{ trans('admin.mobile') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('mobile',(isset($user))? $user->mobile_number : old('mobile'), array('id'=>'mobile', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.mobile'))) !!}
                                            @if($errors->has('mobile'))
                                                <span class="help-block text-danger">{{ $errors->first('mobile') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="password" class="control-label">
                                                {{ trans('admin.password') }}  {{  (isset($user))? '' : '<span class="required"> * </span>' }}
                                            </label>
                                            {!! Form::password('password', array('id'=>'password', 'class'=>'form-control', (isset($user))? '' : 'required'=>'required','placeholder'=>trans('admin.password'))) !!}
                                            @if($errors->has('password'))
                                                <span class="help-block text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="password_confirmation" class="control-label">
                                                {{ trans('admin.password_confirmation') }} {{  (isset($user))? '' : '<span class="required"> * </span>' }}
                                            </label>
                                            {!! Form::password('password_confirmation', array('id'=>'password_confirmation', 'class'=>'form-control', (isset($user))? '' : 'required'=>'required','placeholder'=>trans('admin.password_confirmation'))) !!}
                                            @if($errors->has('password_confirmation'))
                                                <span class="help-block text-danger">{{ $errors->first('password_confirmation') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="on" class="control-label">{{ trans('admin.userType') }} <span
                                                        class="required"> * </span></label>
                                            <div class="mt-radio-inline">
                                                @php
                                                    $userType = null;
                                                    if(isset($user)){
                                                    $userType = $user->user_type;
                                                    }
                                                @endphp
                                                <label class="mt-radio">
                                                    {!! Form::radio('user_type', config('constants.userTypes.superAdmin'),($userType == config('constants.userTypes.superAdmin') || empty($userType))? 'true' : '',array('id'=>'superAdmin')) !!}
                                                    {{ trans('admin.superAdmin') }}
                                                    <span></span>
                                                </label>
                                                <label class="mt-radio">
                                                    {!! Form::radio('user_type', config('constants.userTypes.serviceProvider'),($userType == config('constants.userTypes.serviceProvider'))? 'true' : '',array('id'=>'serviceProvider')) !!}
                                                    {{ trans('admin.serviceProvider') }}
                                                    <span></span>
                                                </label>
                                                <label class="mt-radio">
                                                    {!! Form::radio('user_type', config('constants.userTypes.customerService'),($userType == config('constants.userTypes.customerService'))? 'true' : '',array('id'=>'customerService')) !!}
                                                    {{ trans('admin.customerService') }}
                                                    <span></span>
                                                </label>
                                            </div>
                                            @if($errors->has('user_type'))
                                                <span class="help-block text-danger">{{ $errors->first('user_type') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="on" class="control-label">{{ trans('admin.gender') }} <span
                                                        class="required"> * </span></label>
                                            @php
                                                $userGender = null;
                                                if(isset($user)){
                                                $userGender = $user->gender;
                                                }
                                            @endphp
                                            <div class="mt-radio-inline">
                                                <label class="mt-radio">
                                                    {!! Form::radio('gender', config('constants.gender.male'), ($userGender == config('constants.gender.male') || empty($userGender))? 'true' : '',array('id'=>'male')) !!}
                                                    {{ trans('admin.male') }}
                                                    <span></span>
                                                </label>
                                                <label class="mt-radio">
                                                    {!! Form::radio('gender', config('constants.gender.female'), ($userGender == config('constants.gender.female'))? 'true' : '',array('id'=>'female')) !!}
                                                    {{ trans('admin.female') }}
                                                    <span></span>
                                                </label>
                                            </div>
                                            @if($errors->has('gender'))
                                                <span class="help-block text-danger">{{ $errors->first('gender') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="on"
                                                   class="control-label">{{ trans('admin.is_saudi_nationality') }} <span
                                                        class="required"> * </span></label>
                                            @php
                                                $is_saudi = null;
                                                if(isset($user)){
                                                $is_saudi = $user->is_saudi_nationality;
                                                }
                                            @endphp
                                            <div class="mt-radio-inline">
                                                <label class="mt-radio">
                                                    {!! Form::radio('is_saudi_nationality', 1, ($is_saudi == 1 || empty($is_saudi))? 'true' : '',array('id'=>'yes')) !!}
                                                    {{ trans('admin.yes') }}
                                                    <span></span>
                                                </label>
                                                <label class="mt-radio">
                                                    {!! Form::radio('is_saudi_nationality', 0, ($is_saudi == 0 )? 'true' : '',array('id'=>'no')) !!}
                                                    {{ trans('admin.no') }}
                                                    <span></span>
                                                </label>
                                            </div>
                                            @if($errors->has('is_saudi_nationality'))
                                                <span class="help-block text-danger">{{ $errors->first('is_saudi_nationality') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ trans('admin.select_avatar') }}
                                            </label>
                                            <div>
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <span class="btn green btn-file">
                                                                <span class="fileinput-new"> Select file </span>
                                                                <span class="fileinput-exists"> Change </span>
                                                                <input type="file" name="avatar"> </span>
                                                    <span class="fileinput-filename"> </span> &nbsp;
                                                    <a href="javascript:;" class="close fileinput-exists"
                                                       data-dismiss="fileinput"> </a>
                                                </div>
                                            </div>
                                            @if($errors->has('avatar'))
                                                <span class="help-block text-danger">{{ $errors->first('avatar') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ trans('admin.select_nationality') }}
                                            </label>
                                            <div>
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <span class="btn green btn-file">
                                                                <span class="fileinput-new"> Select file </span>
                                                                <span class="fileinput-exists"> Change </span>
                                                                <input type="file" name="national_id_picture"> </span>
                                                    <span class="fileinput-filename"> </span> &nbsp;
                                                    <a href="javascript:;" class="close fileinput-exists"
                                                       data-dismiss="fileinput"> </a>
                                                </div>
                                            </div>
                                            @if($errors->has('national_id_picture'))
                                                <span class="help-block text-danger">{{ $errors->first('national_id_picture') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="default_language" class="control-label">
                                                {{ trans('admin.default_language') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::select('default_language', $languages, (isset($user))? $user->default_language : old('default_language'), array('id'=>'default_language', 'class'=>'form-control','required'=>'required')) !!}
                                            @if($errors->has('default_language'))
                                                <span class="help-block text-danger">{{ $errors->first('default_language') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ trans('admin.birthdate') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('birthdate', (isset($user))? \Carbon\Carbon::parse($user->birthdate)->format('m/d/Y') : old('birthdate'), array('id'=>'birthdate', 'class'=>'form-control form-control-inline input-medium date-picker','required'=>'required', 'size' => 16, 'type' => 'text')) !!}
                                            @if($errors->has('birthdate'))
                                                <span class="help-block text-danger">{{ $errors->first('birthdate') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.national_id') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('national_id', (isset($user))? $user->national_id : old('national_id'), array('id'=>'national_id', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.national_id'))) !!}
                                            @if($errors->has('national_id'))
                                                <span class="help-block text-danger">{{ $errors->first('national_id') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.nationality_id') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::select('nationality_id', $nationalities,  (isset($user))? $user->nationality_id : old('nationality_id'), array('id'=>'nationality_id', 'class'=>'form-control','required'=>'required')) !!}

                                            @if($errors->has('nationality_id'))
                                                <span class="help-block text-danger">{{ $errors->first('nationality_id') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.about') }}
                                            </label>
                                            {!! Form::textarea('about', (isset($user))? $user->about : old('about'), array('id'=>'about', 'class'=>'form-control','rows' => 2)) !!}
                                            @if($errors->has('about'))
                                                <span class="help-block text-danger">{{ $errors->first('about') }}</span>
                                            @endif
                                        </div>

                                        <div class="margiv-top-10">
                                            {!! Form::submit($submitBtn, array('class'=>'btn green')) !!}
                                            <a href="{{ url(AD.'/admins') }}"
                                               class="btn red">{{ trans('admin.cancel') }}</a>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                    <!-- END Create New User TAB -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>
@stop

@section('script')
    <script src="{{ asset('public/assets/pages/scripts/profile.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}"
            type="text/javascript"></script>
@stop