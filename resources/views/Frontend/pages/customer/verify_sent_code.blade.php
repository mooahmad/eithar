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
                                        <p> إذا لم يتم الوصول إلى رمز التفعيل في </p>

                                        {!! Form::open(['files' => true,'url'=>url()->route('customer_sign_up_post'),'class'=>'glopal_form middel_form']) !!}
                                            <aside class="model_code-content">
                                                <input type="number" name="" value="" maxlength="1">
                                                <input type="number" name="" value="" maxlength="1">
                                                <input type="number" name="" value="" maxlength="1">
                                                <input type="number" name="" value="" maxlength="1">
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