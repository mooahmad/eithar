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
                                        {!! Form::open(['url'=>url()->route('verify_sent_code_post',['mobile'=>$mobile]),'class'=>'glopal_form middel_form']) !!}
                                            <aside class="model_code-content">
                                                {!! Form::text('mobile_code',old('mobile_code'),['placeholder'=>trans('main.mobile_code'),'required','id'=>'mobile_code']) !!}
                                                {!! Form::hidden('mobile_number',$mobile) !!}
                                            </aside>
                                            @if($errors->has('mobile_code'))
                                                <span class="text-danger">{{ $errors->first('mobile_code') }}</span>
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
                                <h2 class="title">{{ trans('main.mobile_code') }}</h2>
                                @if(Session::has('error_message'))
                                    <p>{{ session()->get('error_message') }}</p>
                                @endif
                                <aside class="sign_button-content">
                                    <a class="button" type="button" href="{{ url()->route('resend_verify_code') }}"> {{ trans('main.resend') }} </a>
                                </aside>
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

    <!--=05=Start Popup accepted_code-->
    <div class="sucsess_code">
        <div class="container">
            <!-- The Modal -->
            <div class="modal fade" id="sucsess_code">
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
                                @if(Session::has('code_sent_successfully'))
                                    <p>{{ session()->get('code_sent_successfully') }}</p>
                                @endif
                            </div>
                            <!-- End  Form content-->
                            <aside class="form_man">
                                <img src="{{ asset('public/Frontend/img/sucsess_code.png') }}" alt="{{ trans('main.site_name') }}">
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

    @if(Session::has('code_sent_successfully'))
        <script>
            $('#sucsess_code').modal('show');
        </script>
    @endif
@stop