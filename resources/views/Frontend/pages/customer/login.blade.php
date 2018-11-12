@extends(FEL.'.master')

@section('content')
    <!--=02= Start Header Slider-->
    @include(FE.'.layouts.top_header')

    <!-- Start Single Page -->
    <div class="registration_content">
        <!--=03=Start Popup Sign In -->
        <div class="container">
            <!-- The Modal -->
            <div id="sign_in">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                            <!-- Start Form content-->
                            <div class="form_content">
                                <h2 class="title">{{ trans('main.login') }}</h2>
                                {!! Form::open(['url'=>url()->route('customer_login_post'),'class'=>'glopal_form middel_form']) !!}
                                    <div class="phone_number">
                                        <aside class="phone_number-key"> <bdi> +966 </bdi> </aside>
                                        {!! Form::text('mobile_number',old('mobile_number'),['placeholder'=>trans('main.mobile_number'),'required']) !!}
                                    </div>
                                    <div>
                                        {!! Form::password('password',['placeholder'=>trans('main.password'),'required']) !!}
                                    </div>
                                    <div class="forget_rememper">
                                        <aside class="checkbox_button-content">
                                            {!! Form::checkbox('remember_me',1) !!}
                                            <span> {{ trans('main.remember_me') }} </span>
                                        </aside>
                                        <p> <a href="{{ url()->route('home') }}"> {{ trans('main.forget_password') }} </a></p>

                                    </div>
                                    <!-- End List icon Registration -->
                                    <aside class="sign_button-content">
                                        <button class="button" type="submit">{{ trans('main.submit') }}</button>
                                    </aside>
                                    <p class="paragraph_link">{{ trans('main.no_have_account') }}<a href="{{ url()->route('home') }}"> {{ trans('main.register') }}</a></p>
                                {!! Form::close() !!}
                            </div>
                            <!-- End  Form content-->
                            <aside class="form_man">
                                <img src="{{ asset('public/Frontend/img/form-man.png') }}" alt="{{ trans('main.site_name') }}">
                            </aside>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--=03=End Popup Sign In -->

    </div>
    <!-- End Single Page -->

@stop