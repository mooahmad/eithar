@extends(FEL.'.master')

@section('content')
    <!--=02= Start Header Slider-->
    @include(FE.'.layouts.top_header')

    @include(FE.'.layouts.search')

    <!--=02= End Header Slider-->
    <div class="single_page-content provider_page">
        @isset($sub_categories)
            <!--Start department Slider-->
            <div class="department_slider ">
                <div class="container">
                    <div class=" row slider_custum_button department_slider-js">
                        @foreach($sub_categories as $sub_category)
                            <!-- Start Block-->
                            <div class="col-sm ">
                                <div class="department_block" data-class="subCategory_{{$sub_category->id}}">
                                    <img alt="{{ $sub_category->{'category_name_'.LaravelLocalization::getCurrentLocale()} }}" src="{{ $sub_category->profile_picture_path }}">
                                </div>
                            </div>
                            <!-- End Block-->
                        @endforeach
                    </div>
                </div>
            </div>
            <!--End department Slider-->
        @endisset

        <!-- Start All Tabs of profile Doctor-->
            <div class="all_tabs">
                <!--=02= Start Doctor List-->
                <div class="list_doctor subCategory_10">
                    <div class="container">
                        <div class="row">
                            <!-- Start Doctor Block-->
                            <div class="col-sm-12 col-md-6 col-lg-3">
                                <div class="doctor_block">
                                    <a href="#" class="doctor_img">
                                        <span class="more_details"> التفاصيل</span>
                                        <img src="{{ asset('public/Frontend/img/doctor.png') }}" alt="">
                                    </a>
                                    <div class="doctor_description">
                                        <aside class="name">
                                            <h2> د/ حسناء محمد ابو تريكة
                                            </h2>
                                            <span> مسالك بولية</span>
                                        </aside>

                                        <div class="rate_content">
                                            <aside>
                                                <span> 50</span>
                                                <img src="{{ asset('public/Frontend/img/icon/share.png') }}" alt="">
                                            </aside>

                                            <aside>
                                                <span> 50</span>
                                                <img src="{{ asset('public/Frontend/img/icon/star.png') }}" alt="">
                                            </aside>

                                            <aside>
                                                <span> 50</span>
                                                <img src="{{ asset('public/Frontend/img/icon/like.png') }}" alt="">
                                            </aside>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Doctor Block-->

                            <!-- Start Doctor Block-->
                            <div class="col-sm-12 col-md-6 col-lg-3">
                                <div class="doctor_block">
                                    <a href="#" class="doctor_img">
                                        <span class="more_details"> التفاصيل</span>
                                        <img src="{{ asset('public/Frontend/img/doctor.png') }}" alt="">
                                    </a>
                                    <div class="doctor_description">
                                        <aside class="name">
                                            <h2> د/ حسناء محمد ابو تريكة
                                            </h2>
                                            <span> مسالك بولية</span>
                                        </aside>

                                        <div class="rate_content">
                                            <aside>
                                                <span> 50</span>
                                                <img src="{{ asset('public/Frontend/img/icon/share.png') }}" alt="">
                                            </aside>

                                            <aside>
                                                <span> 50</span>
                                                <img src="{{ asset('public/Frontend/img/icon/star.png') }}" alt="">
                                            </aside>

                                            <aside>
                                                <span> 50</span>
                                                <img src="{{ asset('public/Frontend/img/icon/like.png') }}" alt="">
                                            </aside>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Doctor Block-->
                            <!-- Start Doctor Block-->
                            <div class="col-sm-12 col-md-6 col-lg-3">
                                <div class="doctor_block">
                                    <a href="#" class="doctor_img">
                                        <span class="more_details"> التفاصيل</span>
                                        <img src="{{ asset('public/Frontend/img/doctor.png') }}" alt="">
                                    </a>
                                    <div class="doctor_description">
                                        <aside class="name">
                                            <h2> د/ حسناء محمد ابو تريكة
                                            </h2>
                                            <span> مسالك بولية</span>
                                        </aside>

                                        <div class="rate_content">
                                            <aside>
                                                <span> 50</span>
                                                <img src="{{ asset('public/Frontend/img/icon/share.png') }}" alt="">
                                            </aside>

                                            <aside>
                                                <span> 50</span>
                                                <img src="{{ asset('public/Frontend/img/icon/star.png') }}" alt="">
                                            </aside>

                                            <aside>
                                                <span> 50</span>
                                                <img src="{{ asset('public/Frontend/img/icon/like.png') }}" alt="">
                                            </aside>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Doctor Block-->
                        </div>
                    </div>
                </div>
                <!--=02= End Doctor List-->
            </div>
        <!-- End All Tabs of profile Doctor-->
    </div>
@stop
