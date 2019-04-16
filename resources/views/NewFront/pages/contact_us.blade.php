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
                    <form>
                        <label><strong>الاسم</strong></label>
                        <div class="form-group">
                            <input type="text" class="form-control">
                        </div>
                        <label><strong>البريد الالكتروني</strong></label>
                        <div class="form-group">
                            <input type="email" class="form-control">
                        </div>
                        <label><strong>رقم الهاتف</strong></label>
                        <div class="form-group">
                            <input type="number" class="form-control">
                        </div>
                        <label><strong>الرساله</strong></label>
                        <div class="form-group">
                            <textarea rows="6" class="form-control"></textarea>
                        </div>
                        <button class="btn btn-main">أرسال</button>
                    </form>
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