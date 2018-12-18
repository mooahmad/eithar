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

        <!-- Start All Tabs of profile Doctor-->
            <div id="DoctorsList" class="all_tabs">

            </div>
        <!-- End All Tabs of profile Doctor-->
    </div>
@stop

@section('js')
    <script>
        var url = "{{ url()->route('get_subcategory_providers_list') }}";
        var _token = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('public/Frontend/custom/get_providers.js') }}" type="text/javascript"></script>
@stop
