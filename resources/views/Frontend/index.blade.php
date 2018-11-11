@extends(FEL.'.master')

@section('content')

    <!--=02= Start Header Slider-->
    <div class="header_slider header_slider-js ">
        <div class="header" data-src="{{ asset('public/Frontend/img/bg/bg-header1.png') }}">
            <aside>
                <h1>
                    <b>{{ trans('main.slider_txt') }}</b>
                </h1>
            </aside>
        </div>

        <div class="header" data-src="{{ asset('public/Frontend/img/bg/bg-header1.png') }}">
            <aside>
                <h1>
                    <b>{{ trans('main.slider_txt') }}</b>
                </h1>
            </aside>
        </div>

        <div class="header" data-src="{{ asset('public/Frontend/img/bg/bg-header1.png') }}">
            <aside>
                <h1>
                    <b>{{ trans('main.slider_txt') }}</b>
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
                        <p class="paragraph_global">{!! trans('main.who_we_are_text') !!}</p>
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
                <p class="paragraph_global">{!! trans('main.our_services_text') !!}</p>
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
                            <p class="paragraph_global">{{ trans('main.doctors_desc') }}</p>
                            <a href="{{ url()->route('doctors_category') }}" class="button">{{ trans('main.more') }}</a>
                            {{--<a href="#" class="button">{{ trans('main.more') }}</a>--}}
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
                            <p class="paragraph_global">{{ trans('main.lap_desc') }}</p>
{{--                            <a href="{{ url()->route('lap_category') }}" class="button">{{ trans('main.more') }}</a>--}}
                            <a href="#" class="button">{{ trans('main.more') }}</a>
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
                            <p class="paragraph_global">{{ trans('main.nurse_desc') }} </p>
{{--                            <a href="{{ url()->route('nurse_category') }}" class="button">{{ trans('main.more') }}</a>--}}
                            <a href="#" class="button">{{ trans('main.more') }}</a>
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
                            <p class="paragraph_global">{{ trans('main.physiotherapy_desc') }}</p>
{{--                            <a href="{{ url()->route('physiotherapy_category') }}" class="button">{{ trans('main.more') }}</a>--}}
                            <a href="#" class="button">{{ trans('main.more') }}</a>
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
                            <p class="paragraph_global">{{ trans('main.women_desc') }}</p>
{{--                            <a href="{{ url()->route('women_category') }}" class="button">{{ trans('main.more') }}</a>--}}
                            <a href="#" class="button">{{ trans('main.more') }}</a>
                        </aside>
                    </div>
                </div>
                <!--End Women-->
            </div>
        </div>
    </section>
    <!--=05= End Services-->
@stop
