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
                                    <span class="caption-subject font-blue-madison bold uppercase">Settings</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- Create New User TAB -->
                                    <div class="tab-pane active" id="new_user">
                                        {!! Form::open(['method'=>(isset($settings))? 'PUT' : 'POST','url'=> $formRoute, 'role'=>'form', 'files' => true]) !!}

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.mobile_number') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('mobile_number', (isset($settings))? $settings->mobile_number : old('mobile_number') , array('id'=>'mobile_number', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.mobile_number'))) !!}
                                            @if($errors->has('mobile_number'))
                                                <span class="help-block text-danger">{{ $errors->first('mobile_number') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.whats_app_number') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('whats_app_number', (isset($settings))? $settings->whats_app_number : old('whats_app_number') , array('id'=>'whats_app_number', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.whats_app_number'))) !!}
                                            @if($errors->has('whats_app_number'))
                                                <span class="help-block text-danger">{{ $errors->first('whats_app_number') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <label class="control-label">
                                                        {{ trans('admin.customer_banner_path') }}
                                                    </label>
                                                    <div>
                                                        <div class="fileinput fileinput-new"
                                                             data-provides="fileinput">
                                                            <span class="btn green btn-file">
                                                                <span class="fileinput-new"> Select file </span>
                                                                <span class="fileinput-exists"> Change </span>
                                                                <input type="file" name="customer_banner_path"> </span>
                                                            <span class="fileinput-filename"> </span> &nbsp;
                                                            <a href="javascript:;" class="close fileinput-exists"
                                                               data-dismiss="fileinput"> </a>
                                                        </div>
                                                    </div>
                                                    @if($errors->has('customer_banner_path'))
                                                        <span class="help-block text-danger">{{ $errors->first('customer_banner_path') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-xs-2">
                                                    @if(!empty($settings))

                                                        @if(!empty($settings->customer_banner_path))
                                                            <img src="{{ $settings->customer_banner_path }}"
                                                                 class="img-thumbnail" style="max-height: 120px">
                                                        @endif
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
@stop