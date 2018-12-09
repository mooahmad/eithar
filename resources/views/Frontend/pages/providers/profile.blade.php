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
                        <!-- Button Book Now-->
                        @if(auth()->guard('customer-web')->check())
                            <a href="{{ url()->route('doctor_booking_meeting',['subcategory_id'=>$subcategory->id,'subcategory_name'=>\App\Helpers\Utilities::beautyName($subcategory->name),'provider_id'=>$provider->id,'provider_name'=>\App\Helpers\Utilities::beautyName($provider->full_name) ]) }}" class="button register_button">{{ trans('main.book_now') }}</a>
                        @else
                            <a href="{{ url()->route('customer_login') }}" class="button register_button">{{ trans('main.book_now') }}</a>
                        @endif
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
                                    <div class="doctor_education">
                                        <h2 class="title">{{ trans('main.experience') }}</h2>
                                        <p class="list-info">{{ $provider->experience }}</p>
                                    </div>

                                    <div class="doctor_education">
                                        <h2 class="title">{{ trans('main.education') }}</h2>
                                        <p class="list-info">{{ $provider->education }}</p>
                                    </div>
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
    <script>
        var url = "{{ url()->route('like_provider_transaction') }}";
        var _token = "{{ csrf_token() }}";
        var provider_id = "{{ $provider->id }}";
    </script>
    <script src="{{ asset('public/Frontend/custom/provider_transactions.js') }}" type="text/javascript"></script>
@stop
