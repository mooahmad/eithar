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
                                <span>{{ $subcategory->name }}</span>
                                <h3>{{ trans('main.KSA') }}</h3>
                                <span>{{ $provider->speciality_area }}</span>
                                <div class="social_media-content">
                                    <ul class="social_media list-unstyled">
                                        <li> <a href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}" target="_blank" title="Facebook" class="fab fa-facebook-f"></a></li>
                                        <li> <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}&title={{ $provider->full_name }}&summary={{ \App\Helpers\Utilities::beautyName($provider->about) }}&source={{ trans('main.site_name') }}" target="_blank" title="{{ trans('main.site_name') }}" class="fab fa-linkedin-in"></a></li>
                                        <li> <a href="https://twitter.com/share?url={{ url()->current() }}" target="_blank" title="twitter " class="fab fa-twitter"></a></li>
                                        <li> <a href="https://plus.google.com/share?url={{url()->current()}}" target="_blank" title="GooglePlus" class="fab fa-google-plus-g"></a></li>
                                    </ul>
                                </div>
                                <div class="rate_content">
                                    <aside>
                                        <span>{{ $provider->no_of_views }}</span>
                                        <i class="far fa-share-square"></i>
                                    </aside>

                                    <aside>
                                        <span>{{ $provider->no_of_ratings }}</span>
                                        <i class="far fa-star"></i>
                                    </aside>

                                    <aside>
                                        <span>{{ $provider->no_of_likes }}</span>
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
                                        <h2 class="title">{{ trans('main.experience') }}</h2>
                                        <p class="list-info">{{ $provider->experience }}</p>
                                    </div>
                                    <!-- End Docotor Skills-->

                                    <!-- Start Docotor Skills-->
                                    <div class="doctor_education">
                                        <h2 class="title">{{ trans('main.education') }}</h2>
                                        <p class="list-info">{{ $provider->education }}</p>
                                    </div>
                                    <!-- End Docotor Skills-->
                                </div>
                                @if($provider->video)
                                    <div class="col-sm-12 col-md-2">
                                        <div class="doctor_video">
                                            <!-- Button to Open the Modal -->
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                                <img src="{{ asset('public/Frontend/img/icon/play-video.png') }}" alt="{{ $provider->full_name }}">
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
                                                            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/{{ $provider->video }}?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Model-->
                                            </div>
                                        </div>
                                    </div>
                                @endif
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
    {{--<script>--}}
        {{--var url = "{{ url()->route('get_subcategory_providers_list') }}";--}}
        {{--var _token = "{{ csrf_token() }}";--}}
    {{--</script>--}}
    {{--<script src="{{ asset('public/Frontend/custom/get_providers.js') }}" type="text/javascript"></script>--}}
@stop
