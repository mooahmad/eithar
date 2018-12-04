@extends(FEL.'.master')

@section('content')
    <!--=02= Start Header Slider-->
    @include(FE.'.layouts.top_header')

    <!-- Start Single Page -->
    <div class="registration_content">
        <div class="container">
            @if(Session::has('error_login'))
                <div class="alert alert-danger">
                    <button class="close" data-close="alert"></button>
                    <span>{{ session()->get('error_login') }}</span>
                </div>
            @endif
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

                                        {!! Form::open(['url'=>url()->route('verify_sent_code_post',['id'=>$id,'name'=>$name]),'class'=>'glopal_form middel_form']) !!}
                                            <aside class="model_code-content">
                                                {!! Form::text('mobile_code',old('mobile_code'),['placeholder'=>trans('main.mobile_code'),'required','id'=>'mobile_code']) !!}
                                                {!! Form::hidden('customer_id',$id) !!}
                                                @if($errors->has('mobile_code'))
                                                    <span class="text-danger">{{ $errors->first('mobile_code') }}</span>
                                                @endif
                                            </aside>

                                            <!-- End List icon Registration -->
                                            <aside class="sign_button-content">
                                                <button class="button" type="submit"> {{ trans('main.send') }} </button>
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