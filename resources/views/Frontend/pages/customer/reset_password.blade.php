@extends(FEL.'.master')

@section('content')
    <!--=02= Start Header Slider-->
    @include(FE.'.layouts.top_header')

    <!-- Start Single Page -->
    <div class="registration_content">
        <!--=04=Start Forget password -->
        <div class="container">
            <!-- The Modal -->
            <div id="forget_password">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="form_content">
                                <h2 class="title">{{ trans('main.did_you_forget_your_password') }}</h2>
                                @if(Session::has('error_message'))
                                    <div class="alert alert-danger">
                                        <button class="close" data-close="alert"></button>
                                        <span>{{ session()->get('error_message') }}</span>
                                    </div>
                                @endif
                                @if(count($errors))
                                    <div class="alert alert-danger">
                                        <button class="close" data-close="alert"></button>
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                {!! Form::open(['url'=>url()->route('customer_reset_password_post'),'class'=>'glopal_form middel_form']) !!}
                                    <p>{{ trans('main.reset_password_test') }}</p>
                                    <div class="phone_number ">
                                        <aside class="phone_number-key"> <bdi> +966 </bdi> </aside>
                                        {!! Form::text('mobile_number',old('mobile_number'),['placeholder'=>trans('main.mobile_number'),'required']) !!}
                                    </div>
                                    <!-- End List icon Registration -->
                                    <aside class="sign_button-content">
                                        <button class="button" type="submit">{{ trans('main.send') }}</button>
                                    </aside>
                                {!! Form::close() !!}
                                <!--End Registration with Social media  -->
                            </div>
                            <aside class="form_man">
                                <img src="{{ asset('public/Frontend/img/form-man.png') }}" alt="{{ trans('main.site_name') }}">
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--=04=End Forget password -->
    </div>
    <!-- End Single Page -->
@stop