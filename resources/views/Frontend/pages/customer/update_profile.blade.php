@extends(FEL.'.master')

@section('content')
    <!--=02= Start Header Slider-->
    @include(FE.'.layouts.top_header')

    <!-- Start Single Page -->
    <div class="single_page-content ediating_profile">
        <!-- Satrt My Aaccount Pages-->
        <div class="container">
            {!! Form::model($customer,['files' => true,'url'=>url()->route('customer_update_profile_post')]) !!}
                <div class="row">
                    <div class="col-sm-12 col-lg-4">
                        <div class="add_image">
                            <aside class="profile_image">
                                @if(!empty($customer->profile_picture_path))
                                    <img src="{{ \App\Helpers\Utilities::getFileUrl($customer->profile_picture_path) }}">
                                @else
                                    <img src="{{ asset('public/Frontend/img/icon/avatar.png') }}">
                                @endif

                            </aside>
                            <lable class="button" id="profile_picture_path" type="file">
                                <i class="fas fa-upload"> </i><span>{{ trans('main.profile_picture') }}</span>
                                {!! Form::file('profile_picture_path',old('profile_picture_path'),['placeholder'=>trans('main.profile_picture'),'id'=>'profile_picture_path']) !!}
                                @if($errors->has('profile_picture_path'))
                                    <span class="text-danger">{{ $errors->first('profile_picture_path') }}</span>
                                @endif
                            </lable>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-8">
                        <div class="profile_form">
                            <h2 class="form_title">{{ trans('main.update_information') }}</h2>
                            @if(count($errors))
                                <div class="alert alert-danger">
                                    <button class="close" data-close="alert"></button>
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="glopal_form row" get="post">
                                <div class="col-sm-12 col-lg-4">
                                    <label for="first_name">{{ trans('main.first_name') }}</label>
                                    {!! Form::text('first_name',old('first_name'),['placeholder'=>trans('main.first_name'),'required','id'=>'first_name']) !!}
                                    @if($errors->has('first_name'))
                                        <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>

                                <div class="col-sm-12 col-lg-4">
                                    <label for="middle_name">{{ trans('main.middle_name') }}</label>
                                    {!! Form::text('middle_name',old('middle_name'),['placeholder'=>trans('main.middle_name'),'required','id'=>'middle_name']) !!}
                                    @if($errors->has('middle_name'))
                                        <span class="text-danger">{{ $errors->first('middle_name') }}</span>
                                    @endif
                                </div>

                                <div class="col-sm-12 col-lg-4">
                                    <label for="last_name">{{ trans('main.last_name') }}</label>
                                    {!! Form::text('last_name',old('last_name'),['placeholder'=>trans('main.last_name'),'required','id'=>'last_name']) !!}
                                    @if($errors->has('last_name'))
                                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>

                                <div class="col-sm-12 col-lg-6">
                                    <label for="email">{{ trans('main.email') }}</label>
                                    {!! Form::text('email',old('email'),['placeholder'=>trans('main.email'),'required','id'=>'email']) !!}
                                    @if($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="col-sm-12 col-lg-6">
                                    <aside class="slect_Your-twon">
                                        <label for="gender">{{ trans('main.gender') }}</label>
                                        <div class="custum_select">
                                            {!! Form::select('gender',$gender,old('gender'),['placeholder'=>trans('main.gender'),'required','id'=>'gender']) !!}
                                            @if($errors->has('gender'))
                                                <span class="text-danger">{{ $errors->first('gender') }}</span>
                                            @endif
                                        </div>
                                    </aside>
                                </div>

                                <div class="col-sm-12 col-lg-6">
                                    <label for="mobile_number">{{ trans('main.mobile_number') }} <bdi> +966 </bdi></label>
                                    <div class="phone_number ">
                                        {!! Form::text('mobile_number',$mobile,['placeholder'=>trans('main.mobile_number'),'required','id'=>'mobile_number']) !!}
                                        @if($errors->has('mobile_number'))
                                            <span class="text-danger">{{ $errors->first('mobile_number') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-sm-12 col-lg-6">
                                    <label for="national_id">{{ trans('main.national_id') }}</label>
                                    {!! Form::text('national_id',old('national_id'),['placeholder'=>trans('main.national_id'),'required','id'=>'national_id']) !!}
                                    @if($errors->has('national_id'))
                                        <span class="text-danger">{{ $errors->first('national_id') }}</span>
                                    @endif
                                </div>

                                <div class="col-sm-12 col-lg-6">
                                    <label for="nationality_id_picture">{{ trans('main.nationality_id_picture') }}</label>
                                    {!! Form::file('nationality_id_picture',old('nationality_id_picture'),['placeholder'=>trans('main.nationality_id_picture'),'required','id'=>'nationality_id_picture']) !!}
                                    @if($errors->has('nationality_id_picture'))
                                        <span class="text-danger">{{ $errors->first('nationality_id_picture') }}</span>
                                    @endif
                                </div>

                                <div class="col-sm-12 col-lg-6">
                                    <aside class="slect_Your-twon">
                                        <label for="country_id">{{ trans('main.country') }}</label>
                                        <div class="custum_select">
                                            {!! Form::select('country_id',$countries,old('country_id'),['id'=>'country_id','required','onchange'=>'changeCountry(this);']) !!}
                                            @if($errors->has('country_id'))
                                                <span class="text-danger">{{ $errors->first('country_id') }}</span>
                                            @endif
                                        </div>
                                    </aside>
                                </div>

                                <div class="col-sm-12 col-lg-6">
                                    <aside class="slect_Your-twon">
                                        <label for="city_id">{{ trans('main.city') }}</label>
                                        <div class="custum_select">
                                            {!! Form::select('city_id',$cities,old('city_id'),['id'=>'city_id','placeholder'=>trans('main.city'),'required']) !!}
                                            @if($errors->has('city_id'))
                                                <span class="text-danger">{{ $errors->first('city_id') }}</span>
                                            @endif
                                        </div>
                                    </aside>
                                </div>

                                <div class="col-sm-12 col-lg-6">
                                    <label for="address">{{ trans('main.address') }}</label>
                                    {!! Form::text('address',old('address'),['id'=>'address','placeholder'=>trans('main.address'),'required']) !!}
                                    @if($errors->has('address'))
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <label for="position">{{ trans('main.position') }}</label>
                                    {!! Form::text('position',old('position'),['id'=>'position','placeholder'=>trans('main.position'),'required','readonly']) !!}
                                    @if($errors->has('position'))
                                        <span class="text-danger">{{ $errors->first('position') }}</span>
                                    @endif
                                </div>

                                <div class="col-sm-12">
                                    <label for="about">{{ trans('main.about') }}</label>
                                    {!! Form::textarea('about',old('about'),['cols'=>80,'rows'=>8,'placeholder'=>trans('main.about'),'id'=>'about']) !!}
                                    @if($errors->has('about'))
                                        <span class="text-danger">{{ $errors->first('about') }}</span>
                                    @endif
                                </div>

                                <div class="col-sm-12">
                                    <h3 class="sub_title">{{ trans('main.change_password') }}</h3>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <label for="password">{{ trans('main.password') }}</label>
                                    {!! Form::password('password',['placeholder'=>trans('main.password'),'id'=>'password']) !!}
                                    @if($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <label for="password_confirmation">{{ trans('main.password_confirmation') }}</label>
                                    {!! Form::password('password_confirmation',['placeholder'=>trans('main.password_confirmation'),'id'=>'password_confirmation']) !!}
                                    @if($errors->has('password_confirmation'))
                                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                    @endif
                                </div>
                                <button class="button" type="submit">{{ trans('main.update') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
        <!-- End My Aaccount Pages-->
    </div>
    <!-- End Single Page -->
@stop

@section('js')
    <script>
        var url = "{{ url()->route('get_country_cities') }}";
        var _token = "{!! csrf_token() !!}";
    </script>
    <script src="{{ asset('public/Frontend/custom/get_cities.js') }}" type="text/javascript"></script>

    <script>
        var map, infoWindow,geocoder;
        function initMap() {
            infoWindow = new google.maps.InfoWindow;
            geocoder = new google.maps.Geocoder;

            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    $("#position").val(position.coords.latitude +','+position.coords.longitude);
                    getLocation(pos);
                }, function() {
                    handleLocationError(true, infoWindow, map.getCenter());
                });
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }
        }

        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                'Error: The Geolocation service failed.' :
                'Error: Your browser doesn\'t support geolocation.');
            infoWindow.open(map);
        }

        function getLocation(location) {
            geocoder.geocode({'location': location}, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        $("#address").val(results[0].formatted_address);
                    } else {
                        window.console.log('No results found');
                    }
                } else {
                    window.console.log('Geocoder failed due to: ' + status);
                }
            });
        }
    </script>

    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCrBse-5RbQCnVPcez1IadNvKUkNQwgudE&callback=initMap">
    </script>
@stop