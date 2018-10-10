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
                                    <span class="caption-subject font-blue-madison bold uppercase">Medical report</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- Create New User TAB -->
                                    <div class="tab-pane active" id="new_user">
                                        {!! Form::open(['method'=>(isset($report))? 'PUT' : 'POST','url'=> $formRoute, 'role'=>'form', 'files' => true]) !!}

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.title_ar') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('title_ar', (isset($report))? $report->title_ar : old('title_ar') , array('id'=>'title_ar', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.title_ar'))) !!}
                                            @if($errors->has('title_ar'))
                                                <span class="help-block text-danger">{{ $errors->first('title_ar') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.title_en') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('title_en', (isset($report))? $report->title_en : old('title_en') , array('id'=>'title_en', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.title_en'))) !!}
                                            @if($errors->has('title_en'))
                                                <span class="help-block text-danger">{{ $errors->first('title_en') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="on"
                                                   class="control-label">{{ trans('admin.is_general') }} </label>
                                            @php
                                                $is_general = null;
                                                if(isset($report)){
                                                $is_general = $report->is_general;
                                                }
                                            @endphp
                                            <div class="mt-radio-inline">
                                                <label class="mt-radio">
                                                    {!! Form::radio('is_general', 1, ($is_general === 1 )? 'true' : '',array('id'=>'yes-is_general')) !!}
                                                    {{ trans('admin.yes') }}
                                                    <span></span>
                                                </label>
                                                <label class="mt-radio">
                                                    {!! Form::radio('is_general', 0, ($is_general === 0 || empty($is_general))? 'true' : '',array('id'=>'no-is_general')) !!}
                                                    {{ trans('admin.no') }}
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div id="services-row"
                                             style="{{ (isset($report) && $report->is_general)? 'display:none' : ''  }}">
                                            <div class="form-group">
                                                <label for="on"
                                                       class="control-label">{{ trans('admin.is_lap') }} </label>
                                                @php
                                                    $is_lap = -1;
                                                    if(isset($report)){
                                                    $is_lap = $report->service_id;
                                                    }
                                                @endphp
                                                <div class="mt-radio-inline">
                                                    <label class="mt-radio">
                                                        {!! Form::radio('is_lap', 1, ($is_lap === 0 )? 'true' : '',array('id'=>'yes-is_lap')) !!}
                                                        {{ trans('admin.yes') }}
                                                        <span></span>
                                                    </label>
                                                    <label class="mt-radio">
                                                        {!! Form::radio('is_lap', 0, ($is_lap == -1)? 'true' : '',array('id'=>'no-is_lap')) !!}
                                                        {{ trans('admin.no') }}
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div id="services-input"
                                                 style="{{ (isset($report) && $report->service_id == 0)? 'display:none' : ''  }}"
                                                 class="form-group">
                                                <label for="default_language" class="control-label">
                                                    {{ trans('admin.service') }} <span class="required"> * </span>
                                                </label>
                                                {!! Form::select('service', $services, (isset($report))? $report->service_id : old('service'), array('id'=>'service', 'class'=>'form-control','required'=>'required')) !!}
                                                @if($errors->has('service'))
                                                    <span class="help-block text-danger">{{ $errors->first('service') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="on"
                                                   class="control-label">{{ trans('admin.customer_can_view') }} </label>
                                            @php
                                                $customer_can_view = null;
                                                if(isset($report)){
                                                $customer_can_view = $report->customer_can_view;
                                                }
                                            @endphp
                                            <div class="mt-radio-inline">
                                                <label class="mt-radio">
                                                    {!! Form::radio('customer_can_view', 1, ($customer_can_view === 1 )? 'true' : '',array('id'=>'yes-customer_can_view')) !!}
                                                    {{ trans('admin.yes') }}
                                                    <span></span>
                                                </label>
                                                <label class="mt-radio">
                                                    {!! Form::radio('customer_can_view', 0, ($customer_can_view === 0 || empty($customer_can_view))? 'true' : '',array('id'=>'no-customer_can_view')) !!}
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
    <script src="{{ asset('public/js/custom/medical-report.js') }}" type="text/javascript"></script>
@stop