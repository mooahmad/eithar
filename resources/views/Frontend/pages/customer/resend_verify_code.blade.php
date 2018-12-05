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
                                        <h2 class="title">{{ trans('main.resend_verify_code') }} </h2>
                                        <p>{{ trans('main.resend_verify_code_message') }}</p>
                                        {!! Form::open(['url'=>url()->route('resend_verify_code_post'),'class'=>'glopal_form middel_form']) !!}
                                            <aside class="model_code-content">
                                                {!! Form::text('mobile_number',old('mobile_number'),['placeholder'=>trans('main.mobile_number'),'required','id'=>'mobile_number']) !!}
                                            </aside>
                                            @if($errors->has('mobile_number'))
                                                <span class="text-danger">{{ $errors->first('mobile_number') }}</span>
                                            @endif

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

    <!--=05=Start Popup accepted_code-->
    <div class="wrrong_code">
        <div class="container">
            <!-- The Modal -->
            <div class="modal fade" id="wrong_code">
                <div class="modal-dialog ">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <button class="close fas fa-times" type="button" data-dismiss="modal"> </button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body model_code">
                            <!-- Start Form content-->
                            <div class="form_content">
                                @if(Session::has('error_message'))
                                    <p>{{ session()->get('error_message') }}</p>
                                @endif
                            </div>
                            <!-- End  Form content-->
                            <aside class="form_man">
                                <img src="{{ asset('public/Frontend/img/wrrong_code.png') }}" alt="{{trans('main.site_name')}}">
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--=05 Send Code accepted_code -->
@stop

@section('js')
    @if(Session::has('error_message'))
        <script>
            $('#wrong_code').modal('show');
        </script>
    @endif
@stop