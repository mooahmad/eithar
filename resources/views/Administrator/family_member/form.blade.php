@extends(ADL.'.master')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN VALIDATION STATES-->
            <div class="portlet light portlet-fit portlet-form bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase">{{ Route::currentRouteName() }}</span>
                    </div>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="portlet-body">
                    <!-- BEGIN FORM-->
                    @if(!empty($form_data))
                        {!! Form::model($form_data,['files'=>true,'method'=>'PATCH','url'=>route('family-members',[$form_data->id]), 'id'=>'form_sample_3', 'class'=>'form-horizontal']) !!}
                    @else
                        {!! Form::open(['files'=>true,'method'=>'POST','id'=>'form_sample_3','route'=>'family-members.store', 'class'=>'form-horizontal']) !!}
                    @endif

                    <div class="form-body">

                        <div class="form-group">
                            <label for="user_parent_id" class="col-md-3 control-label">
                                {{ trans('admin.customers') }} <span class="required">* </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    {!! Form::select('user_parent_id',$customers,old('user_parent_id'), array('id'=>'user_parent_id', 'class'=>'form-control select2','required'=>'required','placeholder'=>trans('admin.customers'))) !!}
                                </div>
                                @if($errors->has('user_parent_id'))
                                    <span class="help-block text-danger">{{ $errors->first('user_parent_id') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="first_name" class="col-md-3 control-label">
                                {{ trans('admin.first_name') }} <span class="required"> * </span>
                            </label>

                            <div class="col-md-6">
                                <div class="input-group">
                            		<span class="input-group-addon">
	                                    <i class="fa fa-file-text"></i>
	                                </span>
                                    {!! Form::text('first_name',old('first_name'), array('id'=>'first_name', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.first_name'))) !!}
                                </div>
                                @if($errors->has('first_name'))
                                    <span class="help-block text-danger">{{ $errors->first('first_name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="middle_name" class="col-md-3 control-label">
                                {{ trans('admin.middle_name') }} <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </span>
                                    {!! Form::text('middle_name',old('middle_name'), array('id'=>'middle_name', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.middle_name'))) !!}
                                </div>
                                @if($errors->has('middle_name'))
                                    <span class="help-block text-danger">{{ $errors->first('middle_name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="last_name" class="col-md-3 control-label">
                                {{ trans('admin.last_name') }} <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-file-text"></i>
                                    </span>
                                    {!! Form::text('last_name',old('last_name'), array('id'=>'last_name', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.last_name'))) !!}
                                </div>
                                @if($errors->has('last_name'))
                                    <span class="help-block text-danger">{{ $errors->first('last_name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="relation_type" class="col-md-3 control-label">
                                {{ trans('admin.relation_type') }} <span class="required">* </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    {!! Form::select('relation_type',$relation_types,old('relation_type'), array('id'=>'relation_type', 'class'=>'form-control select2','required'=>'required','placeholder'=>trans('admin.relation_type'))) !!}
                                </div>
                                @if($errors->has('relation_type'))
                                    <span class="help-block text-danger">{{ $errors->first('relation_type') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mobile_number" class="col-md-3 control-label">
                                {{ trans('admin.mobile_number') }} <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-mobile-phone"></i>
                                    </span>
                                    {!! Form::text('mobile_number',old('mobile_number'), array('id'=>'mobile_number', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.mobile_number'))) !!}
                                </div>
                                @if($errors->has('mobile_number'))
                                    <span class="help-block text-danger">{{ $errors->first('mobile_number') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="national_id" class="col-md-3 control-label">
                                {{ trans('admin.national_id') }} <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-credit-card"></i>
                                    </span>
                                    {!! Form::text('national_id',old('national_id'), array('id'=>'national_id', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.national_id'))) !!}
                                </div>
                                @if($errors->has('national_id'))
                                    <span class="help-block text-danger">{{ $errors->first('national_id') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="col-md-3 control-label">
                                {{ trans('admin.address') }} <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-location-arrow"></i>
                                    </span>
                                    {!! Form::text('address',old('address'), array('id'=>'address', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.address'))) !!}
                                </div>
                                @if($errors->has('address'))
                                    <span class="help-block text-danger">{{ $errors->first('address') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="birthdate" class="col-md-3 control-label">
                                {{ trans('admin.birthdate') }}
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    {!! Form::text('birthdate',old('birthdate'), array('id'=>'birthdate', 'class'=>'form-control date_picker','placeholder'=>trans('admin.birthdate'))) !!}
                                </div>
                                @if($errors->has('birthdate'))
                                    <span class="help-block text-danger">{{ $errors->first('birthdate') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="profile_picture_path" class="col-md-3 control-label">
                                {{ trans('admin.profile_picture') }}
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-image"></i>
                                    </span>
                                    {!! Form::file('profile_picture_path', array('id'=>'profile_picture_path', 'class'=>'form-control','placeholder'=>trans('admin.profile_picture'))) !!}
                                </div>
                                <div class="margin-bottom-25">
                                    <span class="note note-warning">Dimensions min width =<strong>100</strong> & min height =<strong>100</strong></span>
                                </div>
                                @if($errors->has('profile_picture_path'))
                                    <span class="help-block text-danger">{{ $errors->first('profile_picture_path') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="gender" class="col-md-3 control-label">
                                {{ trans('admin.gender') }} <span class="required">* </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    {!! Form::select('gender',$gender_types,old('gender'), array('id'=>'gender', 'class'=>'form-control select2','required'=>'required','placeholder'=>trans('admin.gender'))) !!}
                                </div>
                                @if($errors->has('gender'))
                                    <span class="help-block text-danger">{{ $errors->first('gender') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status" class="col-md-3 control-label">
                                {{ trans('admin.is_active') }} <span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <div class="mt-radio-inline">
                                    <label class="mt-radio">
                                        {!! Form::radio('is_active', '1','true') !!}
                                        {{ trans('admin.yes') }}
                                        <span></span>
                                    </label>
                                    <label class="mt-radio">
                                        {!! Form::radio('is_active', '0','') !!}
                                        {{ trans('admin.no') }}
                                        <span></span>
                                    </label>
                                </div>
                                @if($errors->has('is_active'))
                                    <span class="help-block text-danger">{{ $errors->first('is_active') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="is_saudi_nationality" class="col-md-3 control-label">
                                {{ trans('admin.is_saudi_nationality') }} <span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <div class="mt-radio-inline">
                                    <label class="mt-radio">
                                        {!! Form::radio('is_saudi_nationality', '1','true') !!}
                                        {{ trans('admin.yes') }}
                                        <span></span>
                                    </label>
                                    <label class="mt-radio">
                                        {!! Form::radio('is_saudi_nationality', '0','') !!}
                                        {{ trans('admin.no') }}
                                        <span></span>
                                    </label>
                                </div>
                                @if($errors->has('is_saudi_nationality'))
                                    <span class="help-block text-danger">{{ $errors->first('is_saudi_nationality') }}</span>
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                {!! Form::submit(trans('admin.save'), array('class'=>'btn green')) !!}
                                <a href="{{ url()->route('all_family_members') }}" class="btn red">{{ trans('admin.cancel') }}</a>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                <!-- END FORM-->
                </div>
                <!-- END VALIDATION STATES-->
            </div>
        </div>
    </div>

@stop