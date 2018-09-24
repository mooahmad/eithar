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

                                        <div id="services-row" style="{{ (isset($report) && $report->is_general)? 'display:none' : ''  }}" class="form-group">
                                            <label for="default_language" class="control-label">
                                                {{ trans('admin.service') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::select('service', $services, (isset($report))? $report->service_id : old('service'), array('id'=>'service', 'class'=>'form-control','required'=>'required')) !!}
                                            @if($errors->has('service'))
                                                <span class="help-block text-danger">{{ $errors->first('service') }}</span>
                                            @endif
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

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <label class="control-label">
                                                        {{ trans('admin.select_report') }}
                                                    </label>
                                                    <div>
                                                        <div class="fileinput fileinput-new"
                                                             data-provides="fileinput">
                                                            <span class="btn green btn-file">
                                                                <span class="fileinput-new"> Select file </span>
                                                                <span class="fileinput-exists"> Change </span>
                                                                <input type="file" name="report"> </span>
                                                            <span class="fileinput-filename"> </span> &nbsp;
                                                            <a href="javascript:;" class="close fileinput-exists"
                                                               data-dismiss="fileinput"> </a>
                                                        </div>
                                                    </div>
                                                    @if($errors->has('report'))
                                                        <span class="help-block text-danger">{{ $errors->first('report') }}</span>
                                                    @endif
                                                </div>
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