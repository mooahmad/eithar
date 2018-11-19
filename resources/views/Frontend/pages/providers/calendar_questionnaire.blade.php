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
                                            {!! Form::text('address',old('address')) !!}
                                            {{--<input type="text" name="" value="">--}}
                                        </div>
                                        <!-- End Input-->

                                        <!-- Start Input-->
                                        <div class="col-sm-12 col-md-6 col-lg-4">
                                            <span class="button"> اختر المعاد الذى يناسبك
                                              <i class="fas fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <!-- End Input-->
                                        <!-- Start Input-->
                                        <div class="col-sm-12  col-lg-7">
                                            <!-- Start Custum Calender-->
                                            <div id="calender-wrapper">
                                                <div id="calender-title" class="disable-select flex row center-v around">
                                                    <div id="left" class="flex row center-vh">
                                                        <span class="arrow"><</span>
                                                    </div>
                                                    <p class="flex row center-vh">
                                                    </p>
                                                    <div id="right" class="flex row center-vh">
                                                        <span class="arrow">></span>
                                                    </div>
                                                </div>
                                                <div id="days" class="flex row center-vh colorRed disable-select">
                                                    <p>MON</p>
                                                    <p>TUE</p>
                                                    <p>WEDS</p>
                                                    <p>THURS</p>
                                                    <p>FRI</p>
                                                    <p>SAT</p>
                                                    <p>SUN</p>
                                                </div>
                                                <div id="calender-content" class="flex row wrap disable-select">
                                                </div>


                                            </div>
                                            <!-- End Custum Calender-->
                                        </div>
                                        <!-- End Input-->
                                        <!-- Start Block For Apper Booking Date-->
                                        <div class="colsm-12 col-lg-5">
                                            <div class="booking_date-time">
                                                <ul class="booke list-unstyled">
                                                    <li>
                                                        <span>
                                                          <i class="far fa-calendar-alt"></i>
                                                          14 / 10 /2018
                                                        </span>
                                                        <span>
                                                          <i class="far fa-clock"></i>
                                                          20:00 am
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- End Block For Apper Booking Date-->
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
    {{--<script>--}}
        {{--var url = "{{ url()->route('get_subcategory_providers_list') }}";--}}
        {{--var _token = "{{ csrf_token() }}";--}}
    {{--</script>--}}
    {{--<script src="{{ asset('public/Frontend/custom/get_providers.js') }}" type="text/javascript"></script>--}}
@stop
