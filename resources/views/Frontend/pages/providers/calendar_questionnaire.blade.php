@extends(FEL.'.master')

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
                                {!! Form::open(['url'=>url()->route('book_provider_meeting'),'method'=>'post','role'=>'form']) !!}
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
                                                    <div class="flex row center-vh colorRed disable-select" id="days">
                                                        <p>MON</p>
                                                        <p>TUE</p>
                                                        <p>WEDS</p>
                                                        <p>THURS</p>
                                                        <p>FRI</p>
                                                        <p>SAT</p>
                                                        <p>SUN</p>
                                                    </div>
                                                    <div class="flex row wrap disable-select" id="calender-content"> </div>
                                                </div>
                                                <div class="available_dates-list">
                                                    <h5 class="available_dates-title"></h5>
                                                    <ul id="SlotsList" class="list-unstyled">
                                                    </ul>
                                                </div>
                                                {{--<div class="menu_selected-dates">--}}
                                                    {{--<h2 class="home_page-title">{{ trans('main.appointment_selected_list') }}</h2>--}}
                                                    {{--<ul class="list-unstyled"> </ul>--}}
                                                {{--</div>--}}
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
    @endif
@stop

@section('js')
    <script>
        var getCalendarDaysURL = "{{ url()->route('getCalendarDays') }}",
            getAvailableSlotsURL = "{{ url()->route('getAvailableSlots') }}",
            _token = "{{ csrf_token() }}",
            provider_id = "{{ $provider->id }}";
            var transMonthNames = "{{ implode(',',config('constants.monthNames_'.LaravelLocalization::getCurrentLocale())) }}";
            var transdayNames = "{{ implode(',',config('constants.dayNames_'.LaravelLocalization::getCurrentLocale())) }}";
    </script>
{{--    <script src="{{ asset('public/Frontend/js/custum-calender.js') }}" type="text/javascript"></script>--}}
    <script src="{{ asset('public/Frontend/js/dev-calender.js') }}" type="text/javascript"></script>
@stop
