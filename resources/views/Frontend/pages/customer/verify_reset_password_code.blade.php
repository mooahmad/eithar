@extends(FEL.'.master')

@section('content')
    <!--=02= Start Header Slider-->
    @include(FE.'.layouts.top_header')

    <!-- Start Single Page -->
    <div class="registration_content">
        <div class="container">
            <!--=03=Start Popup Send Code -->
            <div class="send_code">
                <div class="container">
                    <!-- The Modal -->
                    <div id="send_code">
                        <div class="modal-dialog ">
                            <div class="modal-content">
                                <div class="modal-body model_code">
                                    <!-- Start Form content-->
                                    <div class="form_content">
                                        <h2 class="title">{{ trans('main.verify_sent_code') }} </h2>
                                        <p>{{ trans('main.verify_account_message') }}</p>
                                        {!! Form::open(['url'=>url()->route('customer_reset_password_verify_code_post'),'class'=>'glopal_form middel_form']) !!}
                                            <div class="phone_number ">
                                                <aside class="phone_number-key"> <bdi> +966 </bdi> </aside>
                                                {!! Form::text('mobile_number',old('mobile_number'),['placeholder'=>trans('main.mobile_number'),'required']) !!}
                                            </div>

                                            <aside class="model_code-content">
                                                {!! Form::text('forget_password_code',old('forget_password_code'),['placeholder'=>trans('main.forget_password_code'),'required','id'=>'forget_password_code']) !!}
                                            </aside>
                                            @if($errors->has('forget_password_code'))
                                                <span class="text-danger">{{ $errors->first('forget_password_code') }}</span>
                                            @endif

                                            <!-- End List icon Registration -->
                                            <aside class="sign_button-content">
                                                <button class="button" type="submit"> {{ trans('main.active') }} </button>
                                            </aside>

                                        {!! Form::close() !!}
                                    </div>
                                    <!-- End  Form content-->
                                    <aside class="form_man">
                                        <img src="{{ asset('public/Frontend/img/send_code.png') }}" alt="{{ trans('main.site_name') }}">
                                    </aside>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--=04 Send Code Send Code -->
        </div>
    </div>
    <!-- End Single Page -->
@stop