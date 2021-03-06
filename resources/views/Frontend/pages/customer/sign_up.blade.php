@extends(FEL.'.master')

@section('content')
    <!--=02= Start Header Slider-->
    @include(FE.'.layouts.top_header')

    <!-- Start Single Page -->
    <div class="registration_content">
        <!--=03=Start Popup Sign In -->
        <div class="container">
            <!-- The Modal -->
            <div class="" id="sign_up">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <!-- Modal body -->
                        <div class="modal-body">
                            <h2 class="title">{{ trans('main.register_now') }}</h2>
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
                            <!-- Start Form content-->
                            {!! Form::open(['files' => true,'url'=>url()->route('customer_sign_up_post'),'class'=>'glopal_form']) !!}
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <label for="first_name">{{ trans('main.first_name') }}</label>
                                        {!! Form::text('first_name',old('first_name'),['placeholder'=>trans('main.first_name'),'required','id'=>'first_name']) !!}
                                        @if($errors->has('first_name'))
                                            <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <label for="middle_name">{{ trans('main.middle_name') }}</label>
                                        {!! Form::text('middle_name',old('middle_name'),['placeholder'=>trans('main.middle_name'),'required','id'=>'middle_name']) !!}
                                        @if($errors->has('middle_name'))
                                            <span class="text-danger">{{ $errors->first('middle_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-sm-12 col-md-12 ">
                                        <label for="last_name">{{ trans('main.last_name') }}</label>
                                        {!! Form::text('last_name',old('last_name'),['placeholder'=>trans('main.last_name'),'required','id'=>'last_name']) !!}
                                        @if($errors->has('last_name'))
                                            <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <label for="password">{{ trans('main.password') }}</label>
                                        {!! Form::password('password',['placeholder'=>trans('main.password'),'required','id'=>'password']) !!}
                                        @if($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <label for="password_confirmation">{{ trans('main.password_confirmation') }}</label>
                                        {!! Form::password('password_confirmation',['placeholder'=>trans('main.password_confirmation'),'required','id'=>'password_confirmation']) !!}
                                        @if($errors->has('password_confirmation'))
                                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <label for="email">{{ trans('main.email') }}</label>
                                        {!! Form::text('email',old('email'),['placeholder'=>trans('main.email'),'required','id'=>'email']) !!}
                                        @if($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="custum_select">
                                            <label for="gender">{{ trans('main.gender') }}</label>
                                            {!! Form::select('gender',$gender,old('gender'),['placeholder'=>trans('main.gender'),'required','id'=>'gender']) !!}
                                            @if($errors->has('gender'))
                                                <span class="text-danger">{{ $errors->first('gender') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <label for="mobile_number">{{ trans('main.mobile_number') }}</label>
                                        <div class="phone_number ">
                                            <aside class="phone_number-key"> <bdi> +966 </bdi> </aside>
                                            {!! Form::text('mobile_number',old('mobile_number'),['placeholder'=>trans('main.mobile_number'),'required','id'=>'mobile_number']) !!}
                                            @if($errors->has('mobile_number'))
                                                <span class="text-danger">{{ $errors->first('mobile_number') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <label for="national_id">{{ trans('main.national_id') }}</label>
                                        {!! Form::text('national_id',old('national_id'),['placeholder'=>trans('main.national_id'),'required','id'=>'national_id']) !!}
                                        @if($errors->has('national_id'))
                                            <span class="text-danger">{{ $errors->first('national_id') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <label for="nationality_id_picture">{{ trans('main.nationality_id_picture') }}</label>
                                        {!! Form::file('nationality_id_picture',old('nationality_id_picture'),['placeholder'=>trans('main.nationality_id_picture'),'required','id'=>'nationality_id_picture']) !!}
                                        @if($errors->has('nationality_id_picture'))
                                            <span class="text-danger">{{ $errors->first('nationality_id_picture') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <label for="country_id">{{ trans('main.country') }}</label>
                                        <div class="phone_number ">
                                            <div class="custum_select">
                                                {!! Form::select('country_id',$countries,old('country_id'),['id'=>'country_id','required','onchange'=>'changeCountry(this);']) !!}
                                                @if($errors->has('country_id'))
                                                    <span class="text-danger">{{ $errors->first('country_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <label for="city_id">{{ trans('main.city') }}</label>
                                        <div class="phone_number ">
                                            <div class="custum_select">
                                                {!! Form::select('city_id',$cities,old('city_id'),['id'=>'city_id','placeholder'=>trans('main.city'),'required']) !!}
                                                @if($errors->has('city_id'))
                                                    <span class="text-danger">{{ $errors->first('city_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        <label for="address">{{ trans('main.address') }}</label>
                                        {!! Form::text('address',old('address'),['id'=>'address','placeholder'=>trans('main.address'),'required']) !!}
                                        @if($errors->has('address'))
                                            <span class="text-danger">{{ $errors->first('address') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <label for="position">{{ trans('main.position') }}</label>
                                        {!! Form::text('position',old('position'),['id'=>'position','placeholder'=>trans('main.position'),'required']) !!}
                                        @if($errors->has('position'))
                                            <span class="text-danger">{{ $errors->first('position') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <label for="profile_picture_path">{{ trans('main.profile_picture') }}</label>
                                        {!! Form::file('profile_picture_path',old('profile_picture_path'),['placeholder'=>trans('main.profile_picture'),'required','id'=>'profile_picture_path']) !!}
                                        @if($errors->has('profile_picture_path'))
                                            <span class="text-danger">{{ $errors->first('profile_picture_path') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="about">{{ trans('main.about') }}</label>
                                        {!! Form::textarea('about',old('about'),['cols'=>80,'rows'=>8,'placeholder'=>trans('main.about'),'id'=>'about']) !!}
                                        @if($errors->has('about'))
                                            <span class="text-danger">{{ $errors->first('about') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <!-- End List icon Registration -->
                                <aside class="sign_button-content">
                                    <button class="button" type="submit">{{ trans('main.sign_up') }}</button>
                                </aside>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--=03=End Popup Sign In -->
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
                    if (position.coords.latitude && position.coords.longitude){
                        $("#position").val(position.coords.latitude +','+position.coords.longitude);
                    }else {
                        $("#position").val("{{$position}}");
                    }
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