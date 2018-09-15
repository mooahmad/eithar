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
                                    <span class="caption-subject font-blue-madison bold uppercase">Provider calendar</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- Create New User TAB -->
                                    <div class="tab-pane active" id="new_user">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-12 text-center">
                                                @if($errors->any())
                                                    <h4 class="alert alert-danger">{{$errors->first()}}</h4>
                                                @endif
                                            </div>
                                        </div>
                                        {!! Form::open(['method'=> 'POST','url'=> $formRoute, 'role'=>'form', 'files' => true]) !!}
                                        <input name="id" type="hidden"
                                               value="{{ isset($calendar)? $calendar->id: '' }}">

                                        <div class="form-group">
                                            <label for="default_language" class="control-label">
                                                {{ trans('admin.select_week_days') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::select('week_days[]', $allWeekDays, $selectedWeekDays, array('id'=>'week_days', 'class'=>'form-control select2-multiple','required'=>'required', 'multiple' => 'multiple')) !!}
                                            @if($errors->has('week_days'))
                                                <span class="help-block text-danger">{{ $errors->first('week_days') }}</span>
                                            @endif
                                        </div>

                                        <div id="no-of-visits-per-week" class="form-group">
                                            <label for="default_language" class="control-label">
                                                {{ trans('admin.number_of_weeks') }}
                                            </label>
                                            {!! Form::number('number_of_weeks', old('number_of_weeks') , array('id'=>'number_of_weeks', 'class'=>'form-control','placeholder'=>trans('admin.number_of_weeks'))) !!}
                                            @if($errors->has('number_of_weeks'))
                                                <span class="help-block text-danger">{{ $errors->first('number_of_weeks') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ trans('admin.start_time') }} <span
                                                        class="required"> * </span>
                                            </label>
                                            {!! Form::select('start_time', $times, 0, array('id'=>'date_section', 'class'=>'form-control')) !!}
                                            @if($errors->has('start_time'))
                                                <span class="help-block text-danger">{{ $errors->first('start_time') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ trans('admin.is_available') }} <span
                                                        class="required"> * </span>
                                            </label>
                                            @php
                                                $is_available = null;
                                                if(isset($calendar)){
                                                $is_available = $calendar->is_available;
                                                }
                                            @endphp
                                            <div class="mt-radio-inline">
                                                <label class="mt-radio">
                                                    {!! Form::radio('is_available', 1, ($is_available === 1 || empty($is_available))? 'true' : '',array('id'=>'yes-active')) !!}
                                                    {{ trans('admin.yes') }}
                                                    <span></span>
                                                </label>
                                                <label class="mt-radio">
                                                    {!! Form::radio('is_available', 0, ($is_available === 0 )? 'true' : '',array('id'=>'no-active')) !!}
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