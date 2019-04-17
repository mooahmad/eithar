@extends(NFEL.'.master')

@section('content')
    <!-- start breadcrumb-->
    <nav class="bread" aria-label="breadcrumb">
        <div class="bg-image" style=" background: url({{ asset('public/NewFront/images/site-images/breadcrumb.jpg') }});"></div>
        <div class="container">
            <div class="title">
                <h2>{{ trans('main.contact_us') }}</h2>
            </div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url()->route('home') }}">{{ trans('main.home') }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ trans('main.contact_us') }}</li>
            </ol>
        </div>
    </nav>

    <!-- start contact-us-->
    <section class="contact-us">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    @if(session()->has('contact_success'))
                        <div class="alert alert-success">
                            <button class="close" data-close="alert"></button> {{ session()->get('contact_success') }}
                        </div>
                    @endif
                    {!! Form::open(['method'=>'POST','url'=>url()->route('save_contact_us')]) !!}

                        <label for="#name"><strong>{{ trans('main.name') }}</strong></label>
                        <div class="form-group">
                            {{ Form::text('name',old('name'),['id'=>'name','class'=>'form-control','placeholder'=>trans('main.name'),'required'=>'required']) }}
                            @if($errors->has('name'))
                                <p class="text-danger">{{ $errors->first('name') }}</p>
                            @endif
                        </div>

                        <label for="#email"><strong>{{ trans('main.email') }}</strong></label>
                        <div class="form-group">
                            {{ Form::text('email',old('email'),['id'=>'email','class'=>'form-control','placeholder'=>trans('main.email'),'required'=>'required']) }}
                            @if($errors->has('email'))
                                <p class="text-danger">{{ $errors->first('email') }}</p>
                            @endif
                        </div>

                        <label for="#phone_number"><strong>{{ trans('main.phone_number') }}</strong></label>
                        <div class="form-group">
                            {{ Form::text('phone_number',old('phone_number'),['id'=>'phone_number','class'=>'form-control','placeholder'=>trans('main.phone_number'),'required'=>'required']) }}
                            @if($errors->has('phone_number'))
                                <p class="text-danger">{{ $errors->first('phone_number') }}</p>
                            @endif
                        </div>

                        <label for="#comment"><strong>{{ trans('main.your_message') }}</strong></label>
                        <div class="form-group">
                            {!! Form::textarea('message',old('message'),['id'=>'comment','rows'=>5,'class'=>'form-control','placeholder'=>trans('main.your_message')]) !!}
                            @if($errors->has('message'))
                                <p class="text-danger">{{ $errors->first('message') }}</p>
                            @endif
                        </div>

                        <button class="btn btn-main">أرسال</button>
                    {!! Form::close() !!}
                </div>
                <div class="col-sm-12 offset-md-1 col-md-5 ">
                    <ul class="contact-info list-unstyled">
                        <li><i class="fas fa-map-marker-alt"></i> العنوان :</li>
                        <p>المملكة العربية السعودية</p>
                        <li><i class="fas fa-phone"></i> ارقام التواصل :</li>
                        <p>0505998864 - 920010893</p>
                        <li><i class="fas fa-envelope"></i> البريد الالكتروني :</li>
                        <p>eithar@eithar.sa</p>
                        <li>تواصل معنا عبر :</li>
                        <ul class="social-icons list-unstyled">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-snapchat-ghost"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                        </ul>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div id="map-canvas"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- end contact-us-->
@stop
@section('js')
    <script>
        var map;
        function initMap() {
            var mapOptions = {
                zoom: 20,
                center: new google.maps.LatLng(30.111450, 31.317068)
            };
            map = new google.maps.Map(document.getElementById('map-canvas'),
                mapOptions);
            var marker = new google.maps.Marker({
                map: map,
                icon: "https://cdn0.iconfinder.com/data/icons/small-n-flat/24/678111-map-marker-32.png ",
                title: "Mi marcador ",
                position: map.getCenter()
            });
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDRepp3ynJPNyNPSiBKPRaJMQ88fHPQ34w&callback=initMap " type="text/javascript "></script>
@stop