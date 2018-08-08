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
                                    <span class="caption-subject font-blue-madison bold uppercase">Service</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- Create New User TAB -->
                                    <div class="tab-pane active" id="new_user">
                                        {!! Form::open(['method'=>(isset($service))? 'PUT' : 'POST','url'=> $formRoute, 'role'=>'form', 'files' => true]) !!}

                                        <div class="form-group">
                                            <label for="default_language" class="control-label">
                                                {{ trans('admin.currency') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::select('currency_id', $currencies, (isset($service))? $service->currency_id : old('currency_id'), array('id'=>'currency_id', 'class'=>'form-control','required'=>'required')) !!}
                                            @if($errors->has('currency_id'))
                                                <span class="help-block text-danger">{{ $errors->first('currency_id') }}</span>
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
                                                    </div>
                                                    @if($errors->has('avatar'))
                                                        <span class="help-block text-danger">{{ $errors->first('avatar') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-xs-2">
                                                    @if(!empty($service))

                                                        @if(!empty($service->profile_picture_path))
                                                            @php
                                                                $serviceImage = \App\Helpers\Utilities::getFileUrl($service->profile_picture_path);
                                                            @endphp
                                                            <img src="{{ $serviceImage }}"
                                                                 class="img-thumbnail" style="max-height: 120px">
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="control-label">
                                            {{ trans('admin.price') }} <span class="required"> * </span>
                                        </label>
                                        {!! Form::number('price', (isset($service))? $service->price : old('price') , array('id'=>'price', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.price'))) !!}
                                        @if($errors->has('price'))
                                            <span class="help-block text-danger">{{ $errors->first('price') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="control-label">
                                            {{ trans('admin.visit_duration') }} <span class="required"> * </span>
                                        </label>
                                        {!! Form::number('visit_duration', (isset($service))? $service->visit_duration : old('visit_duration') , array('id'=>'visit_duration', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.visit_duration'))) !!}
                                        @if($errors->has('visit_duration'))
                                            <span class="help-block text-danger">{{ $errors->first('visit_duration') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="control-label">
                                            {{ trans('admin.time_before_next_visit') }} <span
                                                    class="required"> * </span>
                                        </label>
                                        {!! Form::number('time_before_next_visit', (isset($service))? $service->time_before_next_visit : old('time_before_next_visit') , array('id'=>'time_before_next_visit', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.time_before_next_visit'))) !!}
                                        @if($errors->has('time_before_next_visit'))
                                            <span class="help-block text-danger">{{ $errors->first('time_before_next_visit') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">
                                            {{ trans('admin.expire_date') }} <span class="required"> * </span>
                                        </label>
                                        {!! Form::text('expire_date', (isset($service))? $service->expiry_date : old('expire_date'), array('id'=>'expire_date', 'class'=>'form-control form-control-inline input-medium date_time_picker','required'=>'required', 'size' => 16, 'type' => 'text')) !!}
                                        @if($errors->has('expire_date'))
                                            <span class="help-block text-danger">{{ $errors->first('expire_date') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="on"
                                               class="control-label">{{ trans('admin.is_active') }} </label>
                                        @php
                                            $is_active = null;
                                            if(isset($service)){
                                            $is_active = $service->is_active_service;
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