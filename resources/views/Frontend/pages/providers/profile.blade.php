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
                        <div class="doctor_info-block">
                            <div class="doctor_pic">
                                <img src="{{ $provider->profile_picture_path }}" alt="{{ $provider->full_name }}">
                            </div>
                            <div class="doctor_info-description">
                                <h2>{{ $provider->full_name }}</h2>
                                <span>{{ $provider->speciality_area }}</span>
                                <h3>{{ trans('main.KSA') }}</h3>
                                <span>{{ $provider->speciality_area }}</span>
                                <div class="social_media-content">
                                    <ul class="social_media list-unstyled">
                                        <li> <a href="#" target="_blank" title="Facebook" class="fab fa-facebook-f"></a></li>
                                        <li> <a href="#" target="_blank" title="snapchat " class="fab fa-snapchat-ghost"></a></li>
                                        <li> <a href="#" target="_blank" title="twitter " class="fab fa-twitter"></a></li>
                                        <li> <a href="#" target="_blank" title="instagram" class="fab fa-instagram"></a></li>
                                        <li> <a href="#" target="_blank" title="youtube" class="fab fa-youtube"></a></li>
                                    </ul>
                                </div>
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

                                <div class="rate_area">
                                    <ul class="list-unstyled rate_area-stars">
                                        <li> <img src="img/icon/star_rate.png" alt=""> </li>
                                        <li> <img src="img/icon/star_rate.png" alt=""> </li>
                                        <li> <img src="img/icon/star_rate.png" alt=""> </li>
                                        <li> <img src="img/icon/star_rate.png" alt=""> </li>
                                        <li> <img src="img/icon/star_rate.png" alt=""> </li>
                                    </ul>
                                    <span>4.5 of 5 (رؤية الملف 250 )</span>
                                </div>
                            </div>
                        </div>

                        <!-- Button Rgister-->
                        <a href="#" class="button register_button">احجز الان</a>
                    </div>
                    <!--=01=End Doctor Profile-->

                    <!--=02=Start Doctor Profile-->
                    <div class="col-sm-12 col-md-6 col-lg-9">
                        <div class="doctor_description">
                            <div class="about_doctor">
                                <h2 class="title">{{ trans('main.about_provider') }}</h2>
                                <p class="description">{{ $provider->about }}</div>
                            <div class="row">
                                <div class="col-sm-12 col-md-10">

                                    <!-- Start Docotor Skills-->
                                    <div class="doctor_education">
                                        <h2 class="title"> الخبرات والمهارات</h2>
                                        <p class="list_info"> تخصص الطب؛ قد يقول البعض تخصصًا فرعيًا للطب الباطني ، الذي يتعامل مع تشخيص وعلاج الأمراض المرتبطة بالهرمونات.
                                        </p>
                                    </div>
                                    <!-- End Docotor Skills-->

                                    <!-- Start Docotor Skills-->
                                    <div class="doctor_education">
                                        <h2 class="title"> الخبرات والمهارات</h2>
                                        <p class="list-info"> تخصص الطب؛ قد يقول البعض تخصصًا فرعيًا للطب الباطني ، الذي يتعامل مع تشخيص وعلاج الأمراض المرتبطة بالهرمونات.
                                        </p>
                                    </div>
                                    <!-- End Docotor Skills-->

                                    <!-- Start Docotor Skills-->
                                    <div class="doctor_education">
                                        <h2 class="title"> الخبرات والمهارات</h2>
                                        <p class="list-info"> تخصص الطب؛ قد يقول البعض تخصصًا فرعيًا للطب الباطني ، الذي يتعامل مع تشخيص وعلاج الأمراض المرتبطة بالهرمونات.
                                        </p>
                                    </div>
                                    <!-- End Docotor Skills-->

                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <div class="doctor_video">
                                        <!-- Button to Open the Modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                            <img src="img/icon/play-video.png" alt="">
                                        </button>

                                        <!-- The Modal -->
                                        <div class="modal" id="myModal">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/23ruEfLScnM?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe> </div>
                                                </div>
                                            </div>
                                            <!-- End Model-->
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>
                        <!--=02=End Doctor Profile-->
                    </div>
                </div>
                <!--=02=Start Doctor Profile -->
            </div>
        </div>
        <!-- End Single Page -->
    @endif
@stop

@section('js')
    <script>
        var url = "{{ url()->route('get_subcategory_providers_list') }}";
        var _token = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('public/Frontend/custom/get_providers.js') }}" type="text/javascript"></script>
@stop
