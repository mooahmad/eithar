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
                <div class="portlet-body">
                    <!-- BEGIN FORM-->
                    {!! Form::model($form_data,['method'=>'POST','url'=>$formRoute, 'id'=>'form_sample_3', 'class'=>'form-horizontal']) !!}

                    <div class="form-body">

                        <div class="form-group">
                            <label for="payment_method" class="col-md-3 control-label">
                                {{ trans('admin.payment_method') }} <span class="required">* </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-credit-card"></i>
                                    </span>
                                    {!! Form::select('payment_method',$payment_methods,old('customer_id'), array('id'=>'payment_method', 'class'=>'form-control select2','required'=>'required','placeholder'=>trans('admin.payment_method'))) !!}
                                </div>
                                @if($errors->has('payment_method'))
                                    <span class="help-block text-danger">{{ $errors->first('payment_method') }}</span>
                                @endif
                            </div>
                            {!! Form::hidden('invoice_id',$form_data->id) !!}
                        </div>

                        <div id="payment_transaction_dev" class="form-group hidden">
                            <label for="payment_transaction_number" class="col-md-3 control-label">
                                {{ trans('admin.payment_transaction_number') }} <span class="required">* </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-shopping-cart"></i>
                                    </span>
                                    {!! Form::text('payment_transaction_number',old('payment_transaction_number'), array('id'=>'payment_transaction_number', 'class'=>'form-control','placeholder'=>trans('admin.payment_transaction_number'))) !!}
                                </div>
                                @if($errors->has('payment_transaction_number'))
                                    <span class="help-block text-danger">{{ $errors->first('payment_transaction_number') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="provider_comment" class="col-md-3 control-label">
                                {{ trans('admin.provider_comment') }} <span class="required">* </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user-md"></i>
                                    </span>
                                    {!! Form::textarea('provider_comment',old('provider_comment'), array('id'=>'provider_comment', 'class'=>'form-control','placeholder'=>trans('admin.provider_comment'),'required'=>'required')) !!}
                                </div>
                                @if($errors->has('provider_comment'))
                                    <span class="help-block text-danger">{{ $errors->first('provider_comment') }}</span>
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
    <script>
        changePaymentMethod($('#payment_method option:selected').val());

        $('#payment_method').on('change',function () {
            changePaymentMethod($('#payment_method option:selected').val());
        });

        function changePaymentMethod(type){
            if(type != 1 && type !== null && type !== ''){
                $('#payment_transaction_number').attr('required','required');

                $('#payment_transaction_dev').removeClass('hidden');
            }else {
                $('#payment_transaction_number').removeAttr('required');
                $('#payment_transaction_dev').addClass('hidden');
            }
        }
    </script>
@stop