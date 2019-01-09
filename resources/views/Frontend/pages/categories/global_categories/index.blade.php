@extends(FEL.'.master')

@section('content')
    <!--=02= Start Header Slider-->
    @include(FE.'.layouts.top_header')

    @include(FE.'.layouts.search')

    <!--=02= End Header Slider-->
    <div class="single_page-content pakeg_page">
        @isset($sub_categories)
            <!--Start department Slider-->
            <div class="department_slider">
                <div class="container">
                    <div class="row slider_custum_button department_slider-js">
                        @foreach($sub_categories as $sub_category)
                            <!-- Start Block-->
                            <div class="col-sm">
                                <div class="department_block doctorsSubCategory" data-class="subCategory_{{$sub_category->id}}" data-id="{{$sub_category->id}}">
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

        <!-- Start All Tabs of packages and one time visit -->
            <div class="list_doctor depart1">
                <div class="all_tabs">
                    <div class="container">
                        <ul class="packeg_visit">
                            <li data-class="one_visite"> زيارة واحدة</li>
                            <li data-class="packge"> مجموعة زيارات </li>
                        </ul>

                        <div class="all_visites">
                            <div id="PackageServices" class="row packge">
                                <!-- Start Doctor Block-->
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="doctor_block ">
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
                                                    <i class="far fa-share-square"></i>
                                                </aside>

                                                <aside>
                                                    <span> 50</span>
                                                    <i class="far fa-star"></i>
                                                </aside>

                                                <aside>
                                                    <span> 50</span>
                                                    <i class="far fa-heart"></i>
                                                </aside>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Doctor Block-->
                            </div>

                            <div id="OneTimeVisitServices" class="row one_visite">
                                <!-- Start Doctor Block-->
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="doctor_block ">
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
                                                    <i class="far fa-share-square"></i>
                                                </aside>

                                                <aside>
                                                    <span> 50</span>
                                                    <i class="far fa-star"></i>
                                                </aside>

                                                <aside>
                                                    <span> 50</span>
                                                    <i class="far fa-heart"></i>
                                                </aside>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Doctor Block-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- End All Tabs of packages and one time visit-->
    </div>
@stop

@section('js')
    <script>
        var url = "{{ url()->route('get_subcategory_global_services_list') }}";
        var _token = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('public/Frontend/custom/get_global_services.js') }}" type="text/javascript"></script>
@stop
