<!-- start navbar -->
<header>
    <div class="top-nav ">
        <div class="sign">
            <div class="login">
                <!-- Button trigger modal -->
                <a href="#" class="" data-toggle="modal" data-target="#register"> التسجيل الدخول  </a>
            </div>
            <span class="slash"> / </span>
            <div class="register">
                <!-- Button trigger modal -->
                <a href="#" class="" data-toggle="modal" data-target="#login"> التسجيل </a>
            </div>
        </div>
        <div class="lang">
            <i class="fas fa-globe-africa"></i>
            @if(LaravelLocalization::getCurrentLocale() == 'ar')
                <a href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}" class="languge_button button languge">EN</a>
            @else
                <a href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}" class="languge_button button languge">AR</a>
            @endif
        </div>

        <div class="phone">
            <p><i class="fas fa-phone"></i> 920010893</p>
        </div>
    </div>
    <!-- Register Modal -->
    <div class="register-model modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="{{ asset('public/NewFront/images/logo.png') }}" alt="{{ trans('main.site_name') }}">
                </div>
                <div class="modal-body">
                    <h5>تسجيل الدخول</h5>
                    <form>

                        <div class="group">
                            <input type="number" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <div class="label">رقم الجوال</div>
                        </div>

                        <div class="group">
                            <input type="password" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <div class="label">كلمه المرور</div>
                        </div>
                        <button class="btn btn-main btn-block">دخول</button>
                        <div class="form-check">
                            <input class="check-box form-check-input" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">تذكرني دائما</label>
                        </div>
                        <a href="#" class="reset">نسيت كلمه المرور</a>
                    </form>
                </div>
                <div class="modal-footer text-center">
                    <span>لا تملك حساب بعد ؟</span>
                    <a href="#">انشاء حسابك</a>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar  navbar-expand-lg navbar-light bg-light ">
        <div class="container">
            <!--white background-->
            <a class="navbar-brand  d-md-block d-lg-none" href="{{ url()->route('home') }}">
                <img src="{{ asset('public/NewFront/images/b-logo.png') }}">
            </a>
            <!--dark background-->
            <a class="navbar-brand d-none d-md-block" href="{{ url()->route('home') }}"><img src="{{ asset('public/NewFront/images/logo.png') }}"></a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse  " id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url()->route('home') }}">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">عن ايثار</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact-us">الخدمات </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact-us">العلاج الطبيعي</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact-us">التغذية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact-us">الاطباء</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact-us">التمريض</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact-us">حجز موعد</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact-us">اتصل بنا</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<!-- end navbar -->