<!--=01= Start Navbar-->
<nav class="navbar">
    <div class="container">
        <div class="navbar_content">
            <a class="navbar_brand" href="{{ url(LaravelLocalization::getCurrentLocale()) }}">
                <img src="{{ asset('public/Frontend/img/logo/logoColor.png') }}" class="logo_color" alt="{{ trans('main.site_name') }}">
                <img src="{{ asset('public/Frontend/img/logo/logo.png') }}" class="logo_white" alt="{{ trans('main.site_name') }}">
            </a>

            <!--Start Navbar Menu-->
            <div class="navbar_overlay">
                <div class="menu_content">
                    <ul class="navbar_menu list-unstyled ">
                        <li><a href="{{ url()->route('home') }}" title="{{ trans('main.home') }}">{{ trans('main.home') }}</a></li>
                        <li><a href="{{ url()->route('about_us') }}" title="{{ trans('main.about_us') }}">{{ trans('main.about_us') }}</a></li>
                        <li><a href="{{ url()->route('home') }}" title="{{ trans('main.contact_us') }}">{{ trans('main.our_services') }}</a></li>
                        <li><a href="{{ url()->route('home') }}" title="{{ trans('main.contact_us') }}">{{ trans('main.contact_us') }}</a></li>
                    </ul>

                    <!-- Start Notification Area-->
                    <div class="login_area-content">
                        <!-- Start Notification Area-->
                        <div class="notification_area ">
                            <aside class="notification_button new_notification ">
                                <i class="far fa-bell"></i>
                            </aside>
                            <ul class="notification_area-list">
                                <li class="title"><span>الاشعارات</span></li>
                                <!-- Notification List   -->
                                <li><span class="notification-date">الأربعاء 25 سبتمبر . 2:30 مساء</span><a href="">اكمل شراء دوره
                                        "التشوهات
                                        الفكريه" واحصل %علي خصم 25</a>
                                </li>
                                <!-- Notification List-->
                                <!-- Notification List   -->
                                <li><span class="notification-date">الأربعاء 25 سبتمبر . 2:30 مساء</span><a href="">اكمل شراء دوره
                                        "التشوهات
                                        الفكريه" واحصل %علي خصم 25</a></li>
                                <!-- Notification List-->
                                <!-- Notification List   -->
                                <li><span class="notification-date">الأربعاء 25 سبتمبر . 2:30 مساء</span><a href="">اكمل شراء دوره
                                        "التشوهات
                                        الفكريه" واحصل %علي خصم 25</a></li>
                                <!-- Notification List-->
                                <!-- Notification List   -->
                                <li class="active"><span class="notification-date">الأربعاء 25 سبتمبر . 2:30 مساء</span><a href="">اكمل
                                        شراء دوره
                                        "التشوهات الفكريه" واحصل %علي خصم 25</a></li>
                                <!-- Notification List-->
                            </ul>
                        </div>
                        <!-- End Notification Area-->

                        @if(auth()->guard('customer-web')->check())
{{--                            <li><a href="{{ url()->route('customer_logout') }}" title="{{ trans('main.logout') }}">{{ trans('main.logout') }}</a></li>--}}
                            <a class="login_button" href="{{ url()->route('show_customer_profile',['id'=>auth()->guard('customer-web')->user()->id,'name'=>\App\Helpers\Utilities::beautyName(auth()->guard('customer-web')->user()->full_name)]) }}">
                                <aside class="avatar_img">
                                    <i class="fas fa-user-tie"></i>
                                </aside>
                            </a>
                            <span>{{ auth()->guard('customer-web')->user()->first_name }}</span>
                        @else
                            <a class="login_button" href="{{ url()->route('customer_login') }}">
                                <aside class="avatar_img">
                                    <i class="fas fa-user-tie"></i>
                                </aside>
                            </a>
                            <span>{{ trans('main.login') }}</span>
                        @endif

                        @if(LaravelLocalization::getCurrentLocale() == 'ar')
                            <a rel="alternate" hreflang="en" href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}" class="languge_button button languge">النسخة الانجليزية</a>
                        @else
                            <a rel="alternate" hreflang="ar" href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}" class="languge_button button languge">النسخة العربية</a>
                        @endif
                    </div>
                </div>
            </div>
            <!--End Navbar Menu-->

            <!--Navbar Button-->
            <div class="navbar_button">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </div>
</nav>
<!--=01= Start Navbar-->