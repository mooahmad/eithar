@extends(ADL.'.master')

@section('style')
    <link href="{{ asset('public/assets/pages/css/profile.min.css') }}" rel="stylesheet" type="text/css"/>
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
                                <ul class="nav nav-tabs">
                                    <li class="{{ ($tab=='new_user') ? 'active' : '' }}">
                                        <a href="#new_user" data-toggle="tab">Create New User</a>
                                    </li>
                                    <li class="{{ ($tab=='personal_information' && empty(session()->get('tab'))) ? 'active' : '' }}">
                                        <a href="#personal_information" data-toggle="tab">Personal Info</a>
                                    </li>
                                    <li class="{{ (session()->get('tab')=='change_password') ? 'active' : '' }}">
                                        <a href="#change_password" data-toggle="tab">Change Password</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- Create New User TAB -->
                                    <div class="tab-pane {{ ($tab=='new_user') ? 'active' : '' }}" id="new_user">
                                        {!! Form::open(['method'=>'POST','route'=>'admins.store', 'role'=>'form']) !!}

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.name') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('name',old('name'), array('id'=>'name', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.name'))) !!}
                                            @if($errors->has('name'))
                                                <span class="help-block text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="email" class="control-label">
                                                {{ trans('admin.email') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::email('email',old('email'), array('id'=>'email', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.email'))) !!}
                                            @if($errors->has('email'))
                                                <span class="help-block text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="password" class="control-label">
                                                {{ trans('admin.password') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::password('password', array('id'=>'password', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.password'))) !!}
                                            @if($errors->has('password'))
                                                <span class="help-block text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="password_confirmation" class="control-label">
                                                {{ trans('admin.password_confirmation') }} <span
                                                        class="required"> * </span>
                                            </label>
                                            {!! Form::password('password_confirmation', array('id'=>'password_confirmation', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.password_confirmation'))) !!}
                                            @if($errors->has('password_confirmation'))
                                                <span class="help-block text-danger">{{ $errors->first('password_confirmation') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="on" class="control-label">{{ trans('admin.status') }} <span
                                                        class="required"> * </span></label>
                                            <div class="mt-radio-inline">
                                                <label class="mt-radio">
                                                    {!! Form::radio('status', 1,'true',array('id'=>'on')) !!}
                                                    {{ trans('admin.on') }}
                                                    <span></span>
                                                </label>
                                                <label class="mt-radio">
                                                    {!! Form::radio('status', 0,'',array('id'=>'off')) !!}
                                                    {{ trans('admin.off') }}
                                                    <span></span>
                                                </label>
                                            </div>
                                            @if($errors->has('status'))
                                                <span class="help-block text-danger">{{ $errors->first('status') }}</span>
                                            @endif
                                        </div>

                                        <div class="margiv-top-10">
                                            {!! Form::submit(trans('admin.create'), array('class'=>'btn green')) !!}
                                            <a href="{{ url(AD.'/admins') }}"
                                               class="btn red">{{ trans('admin.cancel') }}</a>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                    <!-- END Create New User TAB -->

                                    <!-- PERSONAL INFO TAB -->
                                    <div class="tab-pane {{ ($tab=='personal_information' && empty(session()->get('tab'))) ? 'active' : '' }}"
                                         id="personal_information">
                                        @if(!empty($form_data))
                                            {!! Form::model($form_data,['method'=>'PATCH','url'=>AD.'/admins/'.$form_data->id, 'role'=>'from']) !!}
                                        @endif

                                        <div class="form-group">
                                            <label for="name_edit" class="control-label">
                                                {{ trans('admin.name') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('name',old('name'), array('id'=>'name_edit', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.name'))) !!}
                                            @if($errors->has('name'))
                                                <span class="help-block text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="email_edit" class="control-label">
                                                {{ trans('admin.email') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::email('email',old('email'), array('id'=>'email_edit', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.email'))) !!}
                                            @if($errors->has('email'))
                                                <span class="help-block text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>

                                        @if(!empty($form_data) && auth()->user()->id != $form_data->id)
                                            <div class="form-group">
                                                <label for="on_edit" class="control-label">{{ trans('admin.status') }}
                                                    <span class="required"> * </span></label>
                                                <div class="mt-radio-inline">
                                                    <label class="mt-radio">
                                                        {!! Form::radio('status', 1,'true',array('id'=>'on_edit')) !!}
                                                        {{ trans('admin.on') }}
                                                        <span></span>
                                                    </label>
                                                    <label class="mt-radio">
                                                        {!! Form::radio('status', 0,'',array('id'=>'off_edit')) !!}
                                                        {{ trans('admin.off') }}
                                                        <span></span>
                                                    </label>
                                                </div>
                                                @if($errors->has('status'))
                                                    <span class="help-block text-danger">{{ $errors->first('status') }}</span>
                                                @endif
                                            </div>
                                        @endif

                                        <div class="margiv-top-10">
                                            {!! Form::submit(trans('admin.save'), array('class'=>'btn green')) !!}
                                            <a href="{{ url(AD.'/admins') }}"
                                               class="btn red">{{ trans('admin.cancel') }}</a>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                    <!-- END PERSONAL INFO TAB -->

                                    <!-- CHANGE PASSWORD TAB -->
                                    <div class="tab-pane {{ (session()->get('tab')=='change_password') ? 'active' : '' }}"
                                         id="change_password">
                                        @if(!empty($form_data))
                                            {!! Form::model($form_data,['method'=>'PATCH','url'=>AD.'/change-password/'.$form_data->id, 'role'=>'form']) !!}
                                        @endif

                                        <div class="form-group">
                                            <label for="password_edit" class="control-label">
                                                {{ trans('admin.password') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::password('password', array('id'=>'password_edit', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.password'))) !!}
                                            @if($errors->has('password'))
                                                <span class="help-block text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="password_confirmation_edit" class="control-label">
                                                {{ trans('admin.password_confirmation') }} <span
                                                        class="required"> * </span>
                                            </label>
                                            {!! Form::password('password_confirmation', array('id'=>'password_confirmation_edit', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.password_confirmation'))) !!}
                                            @if($errors->has('password_confirmation'))
                                                <span class="help-block text-danger">{{ $errors->first('password_confirmation') }}</span>
                                            @endif
                                        </div>

                                        <div class="margiv-top-10">
                                            {!! Form::submit(trans('admin.change_password'), array('class'=>'btn green')) !!}
                                            <a href="{{ url(AD.'/admins') }}"
                                               class="btn red">{{ trans('admin.cancel') }}</a>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                    <!-- END CHANGE PASSWORD TAB -->
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
@stop