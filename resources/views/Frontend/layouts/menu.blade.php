<!--=01= Start Navbar-->
<nav class="navbar">
    <div class="container">
        <div class=" navbar_content">
            <a class="navbar_brand" href="{{ url(session()->get('lang')) }}">
                <img src="{{ asset('public/Frontend/img/logo/logoColor.png') }}" alt="{{ trans('main.site_name') }}">
            </a>

            <!--Start Navbar Menu-->
            <div class="navbar_overlay">
                <ul class="navbar_menu list-unstyled ">
                    <li><a href="#" title="Home">{{ trans('main.home') }}</a></li>
                    <li><a href="#" title="Home">من نحن</a></li>
                    <li><a href="#" title="Home">خدماتنا</a></li>
                    <li><a href="#" title=""> اتصل بنا </a></li>

                </ul>
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