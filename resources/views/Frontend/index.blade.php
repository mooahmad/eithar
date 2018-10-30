@extends(FEL.'.master')

@section('content')

    <!--=02= Start Header Slider-->
    <div class="header_slider header_slider-js ">
        <div class="header" data-src="{{ asset('public/Frontend/img/bg/bg-header1.png') }}">
            <aside>
                <h1>
                    <b> اسهل طريقة لحجز احسن واكبر الأطباء في الســــــــعودية </b>
                    <br> احجز أونلاين أو من التطبيق
                </h1>
            </aside>
        </div>

        <div class="header" data-src="{{ asset('public/Frontend/img/bg/bg-header1.png') }}">
            <aside>
                <h1>
                    <b> اسهل طريقة لحجز احسن واكبر الأطباء في الســــــــعودية </b>
                    <br> احجز أونلاين أو من التطبيق
                </h1>
            </aside>
        </div>

        <div class="header" data-src="{{ asset('public/Frontend/img/bg/bg-header1.png') }}">
            <aside>
                <h1>
                    <b> اسهل طريقة لحجز احسن واكبر الأطباء في الســــــــعودية </b>
                    <br> احجز أونلاين أو من التطبيق
                </h1>
            </aside>
        </div>

    </div>
    <!--=02= End Header Slider-->


    <!--=03= Start Search Subheader-->
    @include(FE.'.layouts.search')
    <!--=03= End Search Subheader-->

    <!--=04= Start About Us-->
    <section class="home_page-section home-page-aboutus">
        <div class="container">
            <div class="row">
                <div class="col-sm-12  col-lg-6">
                    <aside>
                        <img src="{{ asset('public/Frontend/img/bg/bg-about-us.png') }}" alt="{{ trans('main.site_name') }}">
                    </aside>
                </div>
                <div class="col-sm-12  col-lg-6">
                    <aside>
                        <h2 class="home_page-title">{{ trans('main.who_we_are') }}</h2>
                        <p class="paragraph_global">{{ trans('main.who_we_are_text') }}</p>
                        <a href="{{ url(LaravelLocalization::getCurrentLocale()) }}" class="button">{{ trans('main.more') }}</a>
                    </aside>
                </div>
            </div>
        </div>
    </section>
    <!--=04= End About Us-->

    <!--=05= Start Services-->
    <section class="home_page-section home_page-services">
        <div class="container-fluid">
            <aside class="services_title">
                <h2 class="home_page-title">{{ trans('main.our_services') }}</h2>
                <p class="paragraph_global">{{ trans('main.our_services_text') }}</p>
            </aside>
            <div class="row">
                {{--@isset($main_categories)--}}
                    {{--@foreach($main_categories as $main_category)--}}
                        {{--<div class="col-sm-12 col-md-6 col-lg-4">--}}
                            {{--<div class="services_block">--}}
                                {{--<aside class="services_block-icon">--}}
                                    {{--<img alt="{{ $main_category->{'category_name_'.LaravelLocalization::getCurrentLocale()} }}" src="{{ $main_category->profile_picture_path }}">--}}
                                {{--</aside>--}}
                                {{--<aside class="services_block-paragraph">--}}
                                    {{--<h3>{{ $main_category->{'category_name_'.LaravelLocalization::getCurrentLocale()} }}</h3>--}}
                                    {{--<p class="paragraph_global">{{ $main_category->{'description_'.LaravelLocalization::getCurrentLocale()} }}</p>--}}
                                    {{--<a href="{{ url(LaravelLocalization::getCurrentLocale().'/categories/'.$main_category->id.'/'.str_replace(' ','-',$main_category->{'category_name_'.LaravelLocalization::getCurrentLocale()})) }}" class="button">{{ trans('main.more') }}</a>--}}
                                {{--</aside>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--@endforeach--}}
                {{--@endisset--}}

                <!--Start Doctors-->
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="services_block">
                        <aside class="services_block-icon">
                            <img alt="{{ trans('main.doctors') }}" src="{{ asset('public/Frontend/img/icon/services-doctor.png') }}">
                        </aside>
                        <aside class="services_block-paragraph">
                            <h3>{{ trans('main.doctors') }}</h3>
                            <p class="paragraph_global">
                                وريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار
                            </p>
                            <a href="{{ url()->route('doctors_category') }}" class="button">{{ trans('main.more') }}</a>
                        </aside>
                    </div>
                </div>
                <!--End Doctors-->

                <!--Start Lap-->
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="services_block">
                        <aside class="services_block-icon">
                            <img alt="{{ trans('main.lap') }}" src="{{ asset('public/Frontend/img/icon/services-lab.png') }}">
                        </aside>
                        <aside class="services_block-paragraph">
                            <h3>{{ trans('main.lap') }}</h3>
                            <p class="paragraph_global">
                                وريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار
                            </p>
                            <a href="{{ url()->route('lap_category') }}" class="button">{{ trans('main.more') }}</a>
                        </aside>
                    </div>
                </div>
                <!--End Lap-->

                <!--Start Nurse-->
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="services_block">
                        <aside class="services_block-icon">
                            <img alt="{{ trans('main.nurse') }}" src="{{ asset('public/Frontend/img/icon/services-nurse.png') }}">
                        </aside>
                        <aside class="services_block-paragraph">
                            <h3>{{ trans('main.nurse') }}</h3>
                            <p class="paragraph_global">
                                وريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار
                            </p>
                            <a href="{{ url()->route('nurse_category') }}" class="button">{{ trans('main.more') }}</a>
                        </aside>
                    </div>
                </div>
                <!--End Nurse-->

                <!--Start Physiotherapy-->
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="services_block">
                        <aside class="services_block-icon">
                            <img alt="{{ trans('main.physiotherapy') }}" src="{{ asset('public/Frontend/img/icon/services-therapy.png') }}">
                        </aside>
                        <aside class="services_block-paragraph">
                            <h3>{{ trans('main.physiotherapy') }}</h3>
                            <p class="paragraph_global">
                                وريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار
                            </p>
                            <a href="{{ url()->route('physiotherapy_category') }}" class="button">{{ trans('main.more') }}</a>
                        </aside>
                    </div>
                </div>
                <!--End Physiotherapy-->

                <!--Start Women-->
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="services_block">
                        <aside class="services_block-icon">
                            <img alt="{{ trans('main.women') }}" src="{{ asset('public/Frontend/img/icon/services-childern.png') }}">
                        </aside>
                        <aside class="services_block-paragraph">
                            <h3>{{ trans('main.women') }}</h3>
                            <p class="paragraph_global">
                                وريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار
                            </p>
                            <a href="{{ url()->route('women_category') }}" class="button">{{ trans('main.more') }}</a>
                        </aside>
                    </div>
                </div>
                <!--End Women-->
            </div>
        </div>
    </section>
    <!--=05= End Services-->

    <!--=06= Start Services Order-->
    <section class="home_page-section services_order">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-lg-6">
                    <h2 class="home_page-title">أطلب الخدمة </h2>
                    <p class="paragraph_global">
                        وريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر.
                    </p>

                    <!-- Start Glopal Form-->
                    <form class="row glopal_form">
                        <div class="col-sm-12 col-md-6 ">
                            <label>الاسم الأول :</label>
                            <input type="text" placeholder="الاسم :">
                        </div>

                        <div class="col-sm-12 col-md-6 ">
                            <label>الاسم الاخير :</label>
                            <input type="text" placeholder="الاسم الاخير :">
                        </div>

                        <div class="col-sm-12  col-md-6">
                            <label>الجوال :</label>
                            <input type="text" placeholder="الجوال :">
                        </div>

                        <div class="col-sm-12  col-md-6">
                            <label>المدينة :</label>
                            <input type="text" placeholder="المدينة :">
                        </div>

                        <div class="col-sm-12">
                            <label>العـنوان :</label>
                            <aside class="location ">

                                <input type="text" placeholder="العـنوان :">
                                <i class="fas fa-map-marker-alt"></i>
                            </aside>

                        </div>

                        <div class="col-sm-12  col-md-6">
                            <label>الخدمات </label>
                            <select>
                                <option> دكتور </option>
                                <option> معمل </option>
                            </select>
                        </div>

                        <div class="col-sm-12  col-md-6">
                            <label>الخدمات الفرعية </label>
                            <select>
                                <option> دكتور </option>
                                <option> معمل </option>
                            </select>
                        </div>

                        <button class="button-blue glopal_form-button" type="submit"> ارسال</button>
                    </form>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <aside class="services_order-img">
                        <img src="{{ asset('public/Frontend/img/services-order.png') }}" alt="{{ trans('main.site_name') }}">
                    </aside>
                </div>
            </div>
        </div>
    </section>
    <!--=06= End Services Order-->
@stop
