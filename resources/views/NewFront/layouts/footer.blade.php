        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12  col-md-4">
                        <div class="b-logo"> <img src="{{ asset('public/NewFront/images/b-logo.png') }}" class="img-fluid" alt="{{ trans('main.site_name') }}"></div>
                        <div class="caption">
                            <p>الرعاية التزام، وهذا ما نعد به دائما ملائناع يقودنا الشغف والإيمان لإحداث تغيير وتميز في الرعاية الطبية المنزلية . ونسعى دائما كي نكون القادة في تقديم الرعاية الصحية -التي تواكب رؤية 2030</p>
                        </div>
                    </div>
                    <div class="col-sm-12   col-md-3 align-self-center">
                        <div class="imp-links">
                            <div class="title">
                                <h4>روابط هامه</h4>
                            </div>
                            <ul class="list-unstyled">
                                <li><a href="#">عن الشركة</a></li>
                                <li><a href="#">سياسة الخصوصية</a></li>
                                <li><a href="#">الشروط والأحكام للعميل</a></li>
                                <li><a href="#">الأسئلة الشائعة</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-12 offset-md-1 col-md-3 align-self-center">
                        <div class="contact">
                            <div class="title">
                                <h4>الاتصــال بنا</h4>
                            </div>
                            <div class="slogan">
                                <p>دامك بخير.. احنا بخير</p>
                            </div>
                            <div class="phone">
                                خدمتك على<br> الرقم الموحد : 920010893
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <p>اشترك للحصول على النشرة الإخبارية : </p>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="newsletter">
                            <input type="email" class="form-control" placeholder="البريد الكتروني">
                            <button class="btn btn-main">ارسال</button>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <ul class="social-icons list-unstyled">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-snapchat-ghost"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

        <script src="{{ asset('public/NewFront/js/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('public/NewFront/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('public/NewFront/js/moment.min.js') }}"></script>
        <script src="{{ asset('public/NewFront/js/bootstrap-datetimepicker.min.js') }}"></script>
        <script src="{{ asset('public/NewFront/js/custom.js') }}"></script>
        <script src="{{ asset('public/NewFront/js/popper.min.js') }}"></script>
        <script src="{{ asset('public/NewFront/js/bootstrap.min.js') }}"></script>

        @yield('js')
        @if(Session::has('success_message'))
            <script>
                $('#success_message').modal('show');
            </script>
        @endif
        @if(Session::has('error_message'))
            <script>
                $('#wrong_code').modal('show');
            </script>
        @endif
    </body>
</html>