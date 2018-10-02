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
                                    <span class="caption-subject font-blue-madison bold uppercase">Providers</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- Create New User TAB -->
                                    <div class="tab-pane active" id="new_user">
                                        {!! Form::open(['method'=>(isset($provider))? 'PUT' : 'POST','url'=> $formRoute, 'role'=>'form', 'files' => true]) !!}

                                        <div class="form-group">
                                            <label for="default_language" class="control-label">
                                                {{ trans('admin.currency') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::select('currency_id', $currencies, (isset($provider))? $provider->currency_id : old('currency_id'), array('id'=>'currency_id', 'class'=>'form-control','required'=>'required')) !!}
                                            @if($errors->has('currency_id'))
                                                <span class="help-block text-danger">{{ $errors->first('currency_id') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="default_language" class="control-label">
                                                {{ trans('admin.services') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::select('services[]', $allServices, $selectedServices, array('id'=>'services', 'class'=>'form-control select2-multiple','required'=>'required', 'multiple' => 'multiple')) !!}
                                            @if($errors->has('services'))
                                                <span class="help-block text-danger">{{ $errors->first('services') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="default_language" class="control-label">
                                                {{ trans('admin.cities') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::select('cities[]', $allCities, $selectedCities, array('id'=>'cities', 'class'=>'form-control select2-multiple','required'=>'required', 'multiple' => 'multiple')) !!}
                                            @if($errors->has('cities'))
                                                <span class="help-block text-danger">{{ $errors->first('cities') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ trans('admin.title_ar') }} <span style="color: grey;">Ex: در, .مهندس.</span></span><span class="required"> * </span>
                                            </label>
                                            {!! Form::text('title_ar', (isset($provider))? $provider->title_ar : old('title_ar'), array('id'=>'title_ar', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.title_ar'))) !!}
                                            @if($errors->has('title_ar'))
                                                <span class="help-block text-danger">{{ $errors->first('title_ar') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ trans('admin.title_en') }} <span style="color: grey;">Ex: Dr., Mr.</span><span class="required"> * </span>
                                            </label>
                                            {!! Form::text('title_en', (isset($provider))? $provider->title_en : old('title_en'), array('id'=>'title_en', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.title_en'))) !!}
                                            @if($errors->has('title_en'))
                                                <span class="help-block text-danger">{{ $errors->first('title_en') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ trans('admin.first_name_ar') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('first_name_ar', (isset($provider))? $provider->first_name_ar : old('first_name_ar'), array('id'=>'first_name_ar', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.first_name_ar'))) !!}
                                            @if($errors->has('first_name_ar'))
                                                <span class="help-block text-danger">{{ $errors->first('first_name_ar') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ trans('admin.first_name_en') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('first_name_en', (isset($provider))? $provider->first_name_en : old('first_name_en'), array('id'=>'first_name_en', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.first_name_en'))) !!}
                                            @if($errors->has('first_name_en'))
                                                <span class="help-block text-danger">{{ $errors->first('first_name_en') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ trans('admin.last_name_ar') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('last_name_ar', (isset($provider))? $provider->last_name_ar : old('last_name_ar'), array('id'=>'last_name_ar', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.last_name_ar'))) !!}
                                            @if($errors->has('last_name_ar'))
                                                <span class="help-block text-danger">{{ $errors->first('last_name_ar') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ trans('admin.last_name_en') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('last_name_en', (isset($provider))? $provider->last_name_en : old('last_name_en'), array('id'=>'last_name_en', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.last_name_en'))) !!}
                                            @if($errors->has('last_name_en'))
                                                <span class="help-block text-danger">{{ $errors->first('last_name_en') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ trans('admin.email') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('email', (isset($provider))? $provider->email : old('email'), array('id'=>'email', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.email'))) !!}
                                            @if($errors->has('email'))
                                                <span class="help-block text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ trans('admin.mobile_number') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('mobile_number', (isset($provider))? $provider->mobile_number : old('mobile_number'), array('id'=>'mobile_number', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.mobile_number'))) !!}
                                            @if($errors->has('mobile_number'))
                                                <span class="help-block text-danger">{{ $errors->first('mobile_number') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ trans('admin.password') }} {!! (isset($provider))? '' : "<span class='required'> * </span>" !!}
                                            </label>
                                            {!! Form::password('password', array('id'=>'password', 'class'=>'form-control',(isset($provider))? '' : 'required'=>'required','placeholder'=>trans('admin.password'))) !!}
                                            @if($errors->has('password'))
                                                <span class="help-block text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ trans('admin.password_confirmation') }} {!! (isset($provider))? '' : "<span class='required'> * </span>" !!}
                                            </label>
                                            {!! Form::password('password_confirmation', array('id'=>'password_confirmation', 'class'=>'form-control',(isset($provider))? '' : 'required'=>'required','placeholder'=>trans('admin.password_confirmation'))) !!}
                                            @if($errors->has('password_confirmation'))
                                                <span class="help-block text-danger">{{ $errors->first('password_confirmation') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ trans('admin.speciality_area_ar') }} <span
                                                        class="required"> * </span>
                                            </label>
                                            {!! Form::text('speciality_area_ar', (isset($provider))? $provider->speciality_area_ar : old('speciality_area_ar'), array('id'=>'speciality_area_ar', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.speciality_area_ar'))) !!}
                                            @if($errors->has('speciality_area_ar'))
                                                <span class="help-block text-danger">{{ $errors->first('speciality_area_ar') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ trans('admin.speciality_area_en') }} <span
                                                        class="required"> * </span>
                                            </label>
                                            {!! Form::text('speciality_area_en', (isset($provider))? $provider->speciality_area_en : old('speciality_area_en'), array('id'=>'speciality_area_en', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.speciality_area_en'))) !!}
                                            @if($errors->has('speciality_area_en'))
                                                <span class="help-block text-danger">{{ $errors->first('speciality_area_en') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <label class="control-label">
                                                        {{ trans('admin.select_avatar') }}
                                                    </label>
                                                    <div>
                                                        <div class="fileinput fileinput-new"
                                                             data-provides="fileinput">
                                                            <span class="btn green btn-file">
                                                                <span class="fileinput-new"> Select file </span>
                                                                <span class="fileinput-exists"> Change </span>
                                                                <input type="file" name="avatar"> </span>
                                                            <span class="fileinput-filename"> </span> &nbsp;
                                                            <a href="javascript:;" class="close fileinput-exists"
                                                               data-dismiss="fileinput"> </a>
                                                        </div>
                                                        <span class="help-block">Image dimensions(min width=100, min height=200)</span>
                                                    </div>
                                                    @if($errors->has('avatar'))
                                                        <span class="help-block text-danger">{{ $errors->first('avatar') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-xs-2">
                                                    @if(!empty($provider))

                                                        @if(!empty($provider->profile_picture_path))
                                                            @php
                                                                $providerImage = \App\Helpers\Utilities::getFileUrl($provider->profile_picture_path);
                                                            @endphp
                                                            <img src="{{ $providerImage }}"
                                                                 class="img-thumbnail" style="max-height: 120px">
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ trans('admin.video') }} <span class="required"> * </span>
                                        </label>
                                        {!! Form::text('video', (isset($provider))? $provider->video : old('video'), array('id'=>'video', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.video'))) !!}
                                        @if($errors->has('video'))
                                            <span class="help-block text-danger">{{ $errors->first('video') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="control-label">
                                            {{ trans('admin.price') }} <span class="required"> * </span>
                                        </label>
                                        {!! Form::number('price', (isset($provider))? $provider->price : old('price') , array('id'=>'price', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.price'))) !!}
                                        @if($errors->has('price'))
                                            <span class="help-block text-danger">{{ $errors->first('price') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="control-label">
                                            {{ trans('admin.rating') }} <span class="required"> * </span>
                                        </label>
                                        {!! Form::number('rating', (isset($provider))? $provider->rating : old('rating') , array('id'=>'rating', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.rating'))) !!}
                                        @if($errors->has('rating'))
                                            <span class="help-block text-danger">{{ $errors->first('rating') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="control-label">
                                            {{ trans('admin.about_ar') }}
                                        </label>
                                        {!! Form::textarea('about_ar', (isset($provider))? $provider->about_ar : old('about_ar'), array('id'=>'about_ar', 'class'=>'form-control','rows' => 2)) !!}
                                        @if($errors->has('about_ar'))
                                            <span class="help-block text-danger">{{ $errors->first('about_ar') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="control-label">
                                            {{ trans('admin.about_en') }}
                                        </label>
                                        {!! Form::textarea('about_en', (isset($provider))? $provider->about_en : old('about_en'), array('id'=>'about_en', 'class'=>'form-control','rows' => 2)) !!}
                                        @if($errors->has('about_en'))
                                            <span class="help-block text-danger">{{ $errors->first('about_en') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="control-label">
                                            {{ trans('admin.experience_ar') }}
                                        </label>
                                        {!! Form::textarea('experience_ar', (isset($provider))? $provider->experience_ar : old('experience_ar'), array('id'=>'experience_ar', 'class'=>'form-control','rows' => 2)) !!}
                                        @if($errors->has('experience_ar'))
                                            <span class="help-block text-danger">{{ $errors->first('experience_ar') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="control-label">
                                            {{ trans('admin.experience_en') }}
                                        </label>
                                        {!! Form::textarea('experience_en', (isset($provider))? $provider->experience_en : old('experience_en'), array('id'=>'experience_en', 'class'=>'form-control','rows' => 2)) !!}
                                        @if($errors->has('experience_en'))
                                            <span class="help-block text-danger">{{ $errors->first('experience_en') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="control-label">
                                            {{ trans('admin.education_ar') }}
                                        </label>
                                        {!! Form::textarea('education_ar', (isset($provider))? $provider->education_ar : old('education_ar'), array('id'=>'education_ar', 'class'=>'form-control','rows' => 2)) !!}
                                        @if($errors->has('education_ar'))
                                            <span class="help-block text-danger">{{ $errors->first('education_ar') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="control-label">
                                            {{ trans('admin.education_en') }}
                                        </label>
                                        {!! Form::textarea('education_en', (isset($provider))? $provider->education_en : old('education_en'), array('id'=>'education_en', 'class'=>'form-control','rows' => 2)) !!}
                                        @if($errors->has('education_en'))
                                            <span class="help-block text-danger">{{ $errors->first('education_en') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="on"
                                               class="control-label">{{ trans('admin.is_active') }} </label>
                                        @php
                                            $is_active = null;
                                            if(isset($provider)){
                                            $is_active = $provider->is_active;
                                            }
                                        @endphp
                                        <div class="mt-radio-inline">
                                            <label class="mt-radio">
                                                {!! Form::radio('is_active', 1, ($is_active === 1 || empty($is_active))? 'true' : '',array('id'=>'yes-active')) !!}
                                                {{ trans('admin.yes') }}
                                                <span></span>
                                            </label>
                                            <label class="mt-radio">
                                                {!! Form::radio('is_active', 0, ($is_active === 0 )? 'true' : '',array('id'=>'no-active')) !!}
                                                {{ trans('admin.no') }}
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="on"
                                               class="control-label">{{ trans('admin.is_doctor') }} </label>
                                        @php
                                            $is_doctor = null;
                                            if(isset($provider)){
                                            $is_doctor = $provider->is_doctor;
                                            }
                                        @endphp
                                        <div class="mt-radio-inline">
                                            <label class="mt-radio">
                                                {!! Form::radio('is_doctor', 1, ($is_doctor === 1 || empty($is_doctor))? 'true' : '',array('id'=>'yes-doctor')) !!}
                                                {{ trans('admin.yes') }}
                                                <span></span>
                                            </label>
                                            <label class="mt-radio">
                                                {!! Form::radio('is_doctor', 0, ($is_doctor === 0 )? 'true' : '',array('id'=>'no-doctor')) !!}
                                                {{ trans('admin.no') }}
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ trans('admin.contract_start_date') }} <span class="required"> * </span>
                                        </label>
                                        {!! Form::text('contract_start_date', (isset($provider))? $provider->contract_start_date : old('contract_start_date'), array('id'=>'contract_start_date', 'class'=>'form-control form-control-inline input-medium date_time_picker','required'=>'required', 'size' => 16, 'type' => 'text')) !!}
                                        @if($errors->has('contract_start_date'))
                                            <span class="help-block text-danger">{{ $errors->first('contract_start_date') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ trans('admin.contract_expiry_date') }} <span class="required"> * </span>
                                        </label>
                                        {!! Form::text('contract_expiry_date', (isset($provider))? $provider->contract_expiry_date : old('contract_expiry_date'), array('id'=>'contract_expiry_date', 'class'=>'form-control form-control-inline input-medium date_time_picker','required'=>'required', 'size' => 16, 'type' => 'text')) !!}
                                        @if($errors->has('contract_expiry_date'))
                                            <span class="help-block text-danger">{{ $errors->first('contract_expiry_date') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="control-label">
                                            {{ trans('admin.visit_duration') }} <span class="required"> * </span>
                                        </label>
                                        {!! Form::number('visit_duration', (isset($provider))? $provider->visit_duration : old('visit_duration') , array('id'=>'visit_duration', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.visit_duration'))) !!}
                                        @if($errors->has('visit_duration'))
                                            <span class="help-block text-danger">{{ $errors->first('visit_duration') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="control-label">
                                            {{ trans('admin.time_before_next_visit') }} <span
                                                    class="required"> * </span>
                                        </label>
                                        {!! Form::number('time_before_next_visit', (isset($provider))? $provider->time_before_next_visit : old('time_before_next_visit') , array('id'=>'time_before_next_visit', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.time_before_next_visit'))) !!}
                                        @if($errors->has('time_before_next_visit'))
                                            <span class="help-block text-danger">{{ $errors->first('time_before_next_visit') }}</span>
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