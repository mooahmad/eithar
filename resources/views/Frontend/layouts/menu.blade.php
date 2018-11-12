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

                    @if(LaravelLocalization::getCurrentLocale() == 'ar')
                        <a rel="alternate" hreflang="en" href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}" class="languge_button button">النسخة الانجليزية</a>
                        @else
                        <a rel="alternate" hreflang="ar" href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}" class="languge_button button">النسخة العربية</a>
                    @endif
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