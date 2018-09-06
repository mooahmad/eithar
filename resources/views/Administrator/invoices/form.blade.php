@extends(ADL.'.master')

@section('style')
    <link href="{{ asset('public/assets/pages/css/profile.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}"
          rel="stylesheet" type="text/css"/>
@stop

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
                <div class="portlet-body">
                    <!-- BEGIN FORM-->
                    @if(!empty($form_data))
                        {!! Form::model($form_data,['method'=>'PATCH','url'=>$formRoute, 'id'=>'form_sample_3', 'class'=>'form-horizontal']) !!}
                    @else
                        {!! Form::open(['method'=>'POST','id'=>'form_sample_3','url'=>$formRoute, 'class'=>'form-horizontal']) !!}
                    @endif

                    <div class="form-body">

                        <div class="form-group">
                            <label for="customer_id" class="col-md-3 control-label">
                                {{ trans('admin.customers') }} <span class="required">* </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-users"></i>
                                    </span>
                                    {!! Form::select('customer_id',$customers,old('customer_id'), array('id'=>'customer_id', 'class'=>'form-control select2','required'=>'required','placeholder'=>trans('admin.customers'))) !!}
                                </div>
                                @if($errors->has('customer_id'))
                                    <span class="help-block text-danger">{{ $errors->first('customer_id') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="item_id" class="col-md-3 control-label">
                                {{ trans('admin.items') }} <span class="required">* </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-shopping-cart"></i>
                                    </span>
                                    {!! Form::select('items[]',$items,$selected_items, array('id'=>'items', 'class'=>'form-control select2-multiple','required'=>'required','multiple'=>'multiple')) !!}
                                </div>
                                @if($errors->has('items'))
                                    <span class="help-block text-danger">{{ $errors->first('items') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="provider_id" class="col-md-3 control-label">
                                {{ trans('admin.providers') }} <span class="required">* </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user-md"></i>
                                    </span>
                                    {!! Form::select('provider_id',$providers,old('provider_id'), array('id'=>'provider_id', 'class'=>'form-control select2','required'=>'required','placeholder'=>trans('admin.providers'))) !!}
                                </div>
                                @if($errors->has('provider_id'))
                                    <span class="help-block text-danger">{{ $errors->first('provider_id') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status" class="col-md-3 control-label">
                                {{ trans('admin.status') }} <span class="required">If On will *</span>
                            </label>
                            <div class="col-md-6">
                                <div class="mt-radio-inline">
                                    <label class="mt-radio">
                                        {!! Form::radio('status', '1','true',array('class'=>'status')) !!}
                                        {{ trans('admin.on') }}
                                        <span></span>
                                    </label>
                                    <label class="mt-radio">
                                        {!! Form::radio('status', '0','',array('class'=>'status')) !!}
                                        {{ trans('admin.off') }}
                                        <span></span>
                                    </label>
                                </div>
                                @if($errors->has('status'))
                                    <span class="help-block text-danger">{{ $errors->first('status') }}</span>
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                {!! Form::submit($submitBtn, array('class'=>'btn green')) !!}
                                <a href="{{ url(AD.'/faculty') }}" class="btn red">{{ trans('admin.cancel') }}</a>
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

@section('script')
    <script src="{{ asset('public/assets/pages/scripts/profile.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}"
            type="text/javascript"></script>
@stop