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
                                {!! Form::open(['url'=>url()->route('home'),'method'=>'post','role'=>'form']) !!}
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
                                    <div class="wizard-inner">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active">
                                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                                                  <span class="round-tab">
                                                    <i class="fas fa-user-md"></i>
                                                  </span>
                                                </a>
                                            </li>
                                            <li role="presentation" class="disabled">
                                                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                                                  <span class="round-tab">
                                                    <i class="fas fa-user-md"></i>
                                                  </span>
                                                </a>
                                            </li>
                                            <li role="presentation" class="disabled">
                                                <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                                                  <span class="round-tab">
                                                    <i class="fas fa-user-md"></i>
                                                  </span>
                                                </a>
                                            </li>

                                            <li role="presentation" class="disabled">
                                                <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                                                  <span class="round-tab">
                                                    <i class="fas fa-user-md"></i>
                                                  </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane active" role="tabpanel" id="step1">
                                            <!-- Start Step 1-->
                                            <div class="row ">
                                                <!--Start Block 1-->
                                                <div class="col-sm-12 col-md-6 col-lg-12">
                                                    <h3> يرجى الاشارة الى المكان المصاب </h3>
                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>

                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>

                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>

                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>

                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>

                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>

                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>

                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>
                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>

                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>
                                                </div>
                                                <!-- End Block 1-->

                                                <!--Start Block 2-->
                                                <div class="col-sm-12 col-md-6 ">
                                                    <h3>غير ذالك يرجى ذكرة</h3>
                                                    <textarea name="name"></textarea>
                                                </div>
                                                <!--End Block 2-->

                                                <!--Start Block 2-->
                                                <div class="col-sm-12 col-md-6 ">
                                                    <h3>غير ذالك يرجى ذكرة</h3>
                                                    <textarea name="name"></textarea>
                                                </div>
                                                <!--End Block 2-->


                                                <!--Start Block 2-->
                                                <div class="col-sm-12 col-md-6 ">
                                                    <h3>غير ذالك يرجى ذكرة</h3>
                                                    <textarea name="name"></textarea>
                                                </div>
                                                <!--End Block 2-->

                                                <!--Start Block 2-->
                                                <div class="col-sm-12 col-md-6 ">
                                                    <h3>غير ذالك يرجى ذكرة</h3>
                                                    <textarea name="name"></textarea>
                                                </div>
                                                <!--End Block 2-->
                                            </div>
                                            <!--End Step 1-->

                                            <ul class="list-inline ">
                                                <li><button type="button" class="button next-step">حفظ واستكمال</button></li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane" role="tabpanel" id="step2">
                                            <!-- Start Step 2-->
                                            <div class="row ">
                                                <!--Start Block 1-->
                                                <div class="col-sm-12 col-md-6 col-lg-12">
                                                    <h3> يرجى الاشارة الى المكان المصاب </h3>
                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>

                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>

                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>

                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>

                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>

                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>

                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>

                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>
                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>

                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>
                                                </div>
                                                <!-- End Block 1-->

                                                <!--Start Block 2-->
                                                <div class="col-sm-12 col-md-6 ">
                                                    <h3>غير ذالك يرجى ذكرة</h3>
                                                    <textarea name="name"></textarea>
                                                </div>
                                                <!--End Block 2-->

                                                <!--Start Block 2-->
                                                <div class="col-sm-12 col-md-6 ">
                                                    <h3>غير ذالك يرجى ذكرة</h3>
                                                    <textarea name="name"></textarea>
                                                </div>
                                                <!--End Block 2-->


                                                <!--Start Block 2-->
                                                <div class="col-sm-12 col-md-6 ">
                                                    <h3>غير ذالك يرجى ذكرة</h3>
                                                    <textarea name="name"></textarea>
                                                </div>
                                                <!--End Block 2-->


                                                <!--Start Block 2-->
                                                <div class="col-sm-12 col-md-6 ">
                                                    <h3>غير ذالك يرجى ذكرة</h3>
                                                    <textarea name="name"></textarea>
                                                </div>
                                                <!--End Block 2-->
                                            </div>
                                            <!-- End  Step 2-->
                                            <ul class="list-inline ">
                                                <li><button type="button" class="btn btn-primary prev-step">Previous</button></li>
                                                <li><button type="button" class=" button next-step">حفظ واستمرار</button></li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane" role="tabpanel" id="step3">
                                            <!-- Satrts Step 3-->
                                            <div class="row ">
                                                <!--Start Block 1-->
                                                <div class="col-sm-12 col-md-6 col-lg-12">
                                                    <h3> يرجى الاشارة الى المكان المصاب </h3>
                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>

                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>

                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>

                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>

                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>

                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>

                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>

                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>
                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>

                                                    <label class="checkbox_input">
                                                        <input type="checkbox" value=""> <span>الى الخلف</span>
                                                    </label>
                                                </div>
                                                <!-- End Block 1-->

                                                <!--Start Block 2-->
                                                <div class="col-sm-12 col-md-12 ">
                                                    <textarea name="name"></textarea>
                                                </div>
                                                <!--End Block 2-->

                                                <!--Start Block 2-->
                                                <div class="col-sm-12 col-md-6 ">
                                                    <h3>: هل تتلقى أي مساعدة في مهمة يومية بما في ذلك</h3>
                                                    <!-- Start Check content-->
                                                    <div class="check_content">
                                                        <h5> الاستحمام / تواليت</h5>
                                                        <aside class="radio_input">
                                                            <label for=""> <input type="radio" name="optradio1"><span>نعم</span>
                                                            </label>
                                                            <label for=""> <input type="radio" name="optradio1"> <span> لا</span>
                                                            </label>
                                                        </aside>
                                                    </div>
                                                    <!-- End Check content-->

                                                    <!-- Start Check content-->
                                                    <div class="check_content">
                                                        <h5> الاستحمام / تواليت</h5>
                                                        <aside class="radio_input">
                                                            <label for=""> <input type="radio" name="optradio2"><span>نعم</span>
                                                            </label>
                                                            <label for=""> <input type="radio" name="optradio2"> <span> لا</span>
                                                            </label>
                                                        </aside>
                                                    </div>
                                                    <!-- End Check content-->

                                                    <!-- Start Check content-->
                                                    <div class="check_content">
                                                        <h5> الاستحمام / تواليت</h5>
                                                        <aside class="radio_input">
                                                            <label for=""> <input type="radio" name="optradio3"><span>نعم</span>
                                                            </label>
                                                            <label for=""> <input type="radio" name="optradio3"> <span> لا</span>
                                                            </label>
                                                        </aside>
                                                    </div>
                                                    <!-- End Check content-->
                                                </div>
                                                <!--End Block 2-->
                                                <!--Start Block 2-->
                                                <div class="col-sm-12 col-md-6 ">
                                                    <h3>غير ذالك يرجى ذكرة</h3>
                                                    <textarea name="name"></textarea>
                                                </div>
                                                <!--End Block 2-->





                                            </div>
                                            <!--End Step 3-->
                                            <ul class="list-inline ">
                                                <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                                                <li><button type="button" class="btn btn-default next-step">Skip</button></li>
                                                <li><button type="button" class="button btn-info-full next-step">حفظ واستمرار</button></li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane" role="tabpanel" id="complete">
                                            <!-- Start Time Booking-->
                                            <div class="booking_content">
                                                <aside class="">
                                                    <i class="far fa-calendar-alt"></i>
                                                    <span> 02 -نوفمبر - 2017 </span>
                                                </aside>

                                                <aside class="">
                                                    <i class="far fa-clock"></i>
                                                    <span> من الساعة 11 صباحا </span>
                                                </aside>
                                            </div>
                                            <!-- End Time Booking-->

                                            <!-- Start Table Details Booking-->
                                            <table class="table">
                                                <thead>

                                                <tr>
                                                    <th>الخدمــات</th>
                                                    <th>الوقت</th>
                                                    <th>السعر</th>
                                                </tr>

                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>فحص اسبوعى</td>
                                                    <td>15 دقيقة </td>
                                                    <td> <span> 200 ريال</span> </td>
                                                </tr>
                                                <tr>
                                                    <td>فحص اسبوعى</td>
                                                    <td>15 دقيقة </td>
                                                    <td> <span> 200 ريال</span> </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                            <!-- End Table Details Booking-->

                                            <div class="row">
                                                <div class="col-sm-12 col-nd-6 ">

                                                </div>
                                                <div class="col-sm-12 col-md-6 ">
                                                    <div class="input_content">
                                                        <span> رمز ترويجي</span>
                                                        <input type="text" name="" value="">
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-6 ">
                                                    <div class="input_content">
                                                        <span> رمز ترويجي</span>
                                                        <input type="text" name="" value="">
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-6 ">
                                                    <div class="input_content">
                                                        <span> رمز ترويجي</span>
                                                        <input type="text" name="" value="">
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-6 ">
                                                    <div class="input_content">
                                                        <span> رمز ترويجي</span>
                                                        <input type="text" name="" value="">
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-6 ">
                                                    <div class="input_content">
                                                        <span>القيمة المضافة</span>
                                                        <input type="text" name="" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="list-inline ">
                                                <button class="button" type="button" name="button"> تأكيد الحجز</button>

                                            </ul>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
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
