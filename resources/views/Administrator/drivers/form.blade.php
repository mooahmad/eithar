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
                                    <span class="caption-subject font-blue-madison bold uppercase">Driver</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- Create New User TAB -->
                                    <div class="tab-pane active" id="new_user">
                                        {!! Form::open(['method'=>(isset($driver))? 'PUT' : 'POST','url'=> $formRoute, 'role'=>'form', 'files' => true]) !!}

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.name_en') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('name', (isset($driver))? $driver->name : old('name') , array('id'=>'name_en', 'maxlength' => 50, 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.name_en'))) !!}
                                            @if($errors->has('name'))
                                                <span class="help-block text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="identity" class="control-label">
                                                {{ trans('admin.identity') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('identity', (isset($driver))? $driver->identity : old('identity') , array('id'=>'identity', 'maxlength' => 50, 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.identity'))) !!}
                                            @if($errors->has('identity'))
                                                <span class="help-block text-danger">{{ $errors->first('identity') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="nationalId" class="control-label">
                                                {{ trans('admin.nationalId') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('nationalId', (isset($driver))? $driver->national_id : old('nationalId') , array('id'=>'nationalId', 'maxlength' => 50, 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.nationalId'))) !!}
                                            @if($errors->has('nationalId'))
                                                <span class="help-block text-danger">{{ $errors->first('nationalId') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.carType') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('carType', (isset($driver))? $driver->car_type : old('carType') , array('id'=>'carType', 'maxlength' => 50, 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.carType'))) !!}
                                            @if($errors->has('carType'))
                                                <span class="help-block text-danger">{{ $errors->first('carType') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="carColor" class="control-label">
                                                {{ trans('admin.carColor') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('carColor', (isset($driver))? $driver->car_color : old('carColor') , array('id'=>'carColor', 'maxlength' => 50, 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.carColor'))) !!}
                                            @if($errors->has('carColor'))
                                                <span class="help-block text-danger">{{ $errors->first('carColor') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="carPlateNumber" class="control-label">
                                                {{ trans('admin.carPlateNumber') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('carPlateNumber', (isset($driver))? $driver->car_plate_number : old('carPlateNumber') , array('id'=>'carPlateNumber', 'maxlength' => 50, 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.carPlateNumber'))) !!}
                                            @if($errors->has('carPlateNumber'))
                                                <span class="help-block text-danger">{{ $errors->first('carPlateNumber') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="on"
                                                   class="control-label">{{ trans('admin.is_active') }} </label>
                                            @php
                                                $is_active = null;
                                                if(isset($driver)){
                                                $is_active = ($driver->status === 1)? 1 : 0;
                                                }
                                            @endphp
                                            <div class="mt-radio-inline">
                                                <label class="mt-radio">
                                                    {!! Form::radio('status', 1, ($is_active === 1 || empty($is_active))? 'true' : '',array('id'=>'yes-active')) !!}
                                                    {{ trans('admin.yes') }}
                                                    <span></span>
                                                </label>
                                                <label class="mt-radio">
                                                    {!! Form::radio('status', 0, ($is_active === 0 )? 'true' : '',array('id'=>'no-active')) !!}
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