@extends(FEL.'.master')
@section('style')
    <link href="{{ asset('public/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css"/>
@stop
@section('content')
    <!--=02= Start Header Slider-->
    @include(FE.'.layouts.top_header')

    @include(FE.'.layouts.search')

    @if(!empty($provider))
        <!-- Start Single Page -->
        <div class="single_page-content profile-doctor">
            <!--=01=Start Doctor Profile -->
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <!--=01=Start Doctor Profile-->
                    <div class="col-sm-12 col-md-6 col-lg-3">
                        @include(FE.'.pages.providers.right_section')
                    </div>
                    <!--=01=End Doctor Profile-->

                    <!--=02=Start Doctor Profile-->
                    <div class="col-sm-12 col-md-6 col-lg-9">
                        <!--Start Form Wizard-->
                        <section>
                            <div class="wizard">
                                <!-- Start Form-->
                                {!! Form::open(['url'=>url()->route('book_provider_meeting'),'method'=>'post','role'=>'form','id'=>'QuestionnaireForm']) !!}
                                    <div class="row">
                                        <!-- Start Select-->
                                        <div class="col-sm-12 col-md-4 ">
                                            <span class="tag_name">{{ trans('main.family_member') }} :</span>
                                            <div class="custum_select">
                                                {!! Form::select('family_member_id',$family_members,old('family_member_id'),['placeholder'=>trans('main.family_member')]) !!}
                                            </div>
                                        </div>
                                        <!-- End Select-->
                                        <!-- Start Input-->
                                        <div class="col-sm-12 col-md-4 ">
                                            <span class="tag_name">{{ trans('main.address') }} :</span>
                                            <aside class="your_map">
                                                {!! Form::text('address',old('address')) !!}
                                                {!! Form::hidden('provider_id',$provider->id) !!}
                                                {!! Form::hidden('subcategory_id',$subcategory->id) !!}
                                                <button class="open_your-map" type="button">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </button>
                                            </aside>
                                        </div>
                                        <!-- End Input-->

                                        <!-- End Input-->
                                        <div class="col-sm-12  col-lg-7">
                                            <!-- Start Custom Calender-->
                                            <div class="calender_content block">
                                                <h6 class="time">{{ trans('main.timezone') }} <span>( {{ trans('main.KSA') }} )</span></h6>
                                                <div id="calender-wrapper">
                                                    <div class="disable-select flex row center-v around" id="calender-title">
                                                        <div class="flex row center-vh" id="left"><span class="arrow"><</span></div>
                                                        <p class="flex row center-vh"></p>
                                                        <div class="flex row center-vh" id="right"><span class="arrow">></span></div>
                                                    </div>
                                                    <div class="flex row center-vh colorRed disable-select" id="days"></div>
                                                    <div class="flex row wrap disable-select" id="calender-content"> </div>
                                                </div>
                                                <div class="available_dates-list">
                                                    <h5 class="available_dates-title"></h5>
                                                    <ul id="SlotsList" class="list-unstyled">
                                                    </ul>
                                                </div>
                                            </div>
                                            <!--End Calender For Programing-->
                                        </div>
                                    </div>

                                    @include(FE.'.pages.providers.draw_questionnaire')
                                {!! Form::close() !!}
                                <!-- End Form-->
                            </div>
                        </section>
                        <!--End Wizard-->
                    </div>
                    <!--=02=End Doctor Profile-->
                </div>
                <!--=02=Start Doctor Profile -->
            </div>
        </div>
        <!-- End Single Page -->

        <!--=01=Start Popup confirmation_code-->
        <div class="confirmation_code">
            <div class="container">
                <!-- The Modal -->
                <div class="modal fade" id="reservation_confirmation">
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
                                    <form class="glopal_form middel_form ">
                                        <h5 class="send_code"> {{ trans('main.press_confirm_appointment') }} </h5>
                                        <!-- End List icon Registration -->
                                        <aside class="sign_button-content">
                                            <button class="button" type="button" onclick="submitQuestionnaireForm();">{{ trans('main.confirm_appointment') }}</button>
                                        </aside>
                                    </form>
                                </div>
                                <!-- End  Form content-->
                                <aside class="form_man">
                                    <img src="{{ asset('public/Frontend/img/confirm.png') }}" alt="{{ trans('main.site_name') }}">
                                </aside>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--=01= Send Code confirmation_code -->

        <!--=02=Start Popup successful_confirmatione-->
        <div class="successful_confirmation">
            <div class="container">
                <!-- The Modal -->
                <div class="modal fade" id="successful_confirmation">
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
                                    <form class="glopal_form middel_form">
                                        @if(session()->has('success_message'))
                                            <h5 class="send_code">{{ session()->get('success_message') }}</h5>
                                        @endif
                                        <!-- End List icon Registration -->
                                        {{--<aside class="sign_button-content">--}}
                                            {{--<button class="button" type="submit"> تم التأكيد بنجاح</button>--}}
                                        {{--</aside>--}}
                                    </form>
                                </div>
                                <!-- End  Form content-->
                                <aside class="form_man">
                                    <img src="{{ asset('public/Frontend/img/successful_code.png') }}" alt="{{ trans('main.site_name') }}">
                                </aside>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--=02= Send Code successful_confirmation -->
    @endif
@stop

@section('js')
    <script>
        var getCalendarDaysURL = "{{ url()->route('getCalendarDays') }}",
            getAvailableSlotsURL = "{{ url()->route('getAvailableSlots') }}",
            CheckPromoCodeURL = "{{ url()->route('checkPromoCode') }}",
            _token = "{{ csrf_token() }}",
            provider_id = "{{ $provider->id }}";
            var transMonthNames = "{{ implode(',',config('constants.monthNames_'.LaravelLocalization::getCurrentLocale())) }}";
            var transdayNames = "{{ implode(',',config('constants.dayNames_'.LaravelLocalization::getCurrentLocale())) }}";
    </script>
{{--    <script src="{{ asset('public/Frontend/js/custum-calender.js') }}" type="text/javascript"></script>--}}
    <script src="{{ asset('public/Frontend/custom/dev-calender.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/Frontend/js/rating.js') }}" type="text/javascript"></script>

    <script src="{{ asset('public/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
    <script>
        $(".date_picker").datepicker({
            format: "yyyy-mm-dd"
        });
    </script>
    @if(session()->has('success_message'))
        <script>
            $('#successful_confirmation').modal('show');
        </script>
    @endif
@stop
