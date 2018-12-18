        <!--Start Footer -->
        <footer>
            <div class="footer_overlay">
                <div class="container">
                    <aside class="footer_logo">
                        <img src="{{ asset('public/Frontend/img/logo.png') }}" alt="{{ trans('main.site_name') }}">
                    </aside>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <p class="paragraph_global">{{ trans('main.about_us_text') }}</p>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <h2>{{ trans('main.subscribe_to_newsletter') }}</h2>
                            {!! Form::open(['url'=>url('/')]) !!}
                                <aside class="footer_subscribe">
                                    {!! Form::text('email',old('email'),['placeholder'=>trans('main.email')]) !!}
                                    <button type="submit">{{ trans('main.send') }}</button>
                                </aside>
                            {!! Form::close() !!}
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <h2>{{ trans('main.contact_us') }}</h2>
                            <p class="paragraph_global"> {{ trans('main.hotline_text') }} <bdi>009651800082</bdi></p>
                            <ul class="list-unstyled about_us">
                                <li> {{ trans('main.reporting_service') }} <bdi> 0096597225234</bdi></li>
                                <li> {{ trans('main.technical_support_service') }} <bdi> 0096596699477</bdi> </li>
                                <li>{{ trans('main.request_special_link') }}<bdi> 0096597277745</bdi> </li>
                            </ul>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-2">
                            <h2>{{ trans('main.important_links') }}</h2>
                            <ul class="list-unstyled">
                                <li><a href="{{ url()->route('about_us') }}">{{ trans('main.about_company') }}</a></li>
                                <li><a href="{{ url()->route('privacy_and_conditions') }}">{{ trans('main.privacy_and_conditions') }}</a></li>
                                <li><a href="#">{{ trans('main.customer_terms_and_conditions') }}</a></li>
                                <li><a href="#">{{ trans('main.faq') }}</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="copyright_new">
                        <div class="container">
                            <ul class="social_media list-unstyled">
                                <li> <a href="#" target="_blank" title="Facebook" class="fab fa-facebook-f"></a></li>
                                <li> <a href="#" target="_blank" title="snapchat " class="fab fa-snapchat-ghost"></a></li>
                                <li> <a href="#" target="_blank" title="twitter " class="fab fa-twitter"></a></li>
                                <li> <a href="#" target="_blank" title="instagram" class="fab fa-instagram"></a></li>
                                <li> <a href="#" target="_blank" title="youtube" class="fab fa-youtube"></a></li>
                            </ul>
                            <span> {{ trans('main.copyrights') }} © 2018</span>
                        </div>
                    </div>
                </div>
            </div>

        </footer>
        <!-- End Footer -->

        <!--Start Button Go up-->
        <span class="go_up go_up-js fas fa-sort-up"> </span>
        <!--End Button Go up-->

        <!--=05=Start Popup accepted_code-->
        @if(Session::has('success_message'))
            <div class="sucsess_code">
                <div class="container">
                    <!-- The Modal -->
                    <div class="modal fade" id="success_message">
                        <div class="modal-dialog ">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <button class="close fas fa-times" type="button" data-dismiss="modal"> </button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body model_code">
                                    <!-- Start Form content-->
                                    <div class="form_content">
                                        <p>{{ session()->get('success_message') }}</p>
                                    </div>
                                    <!-- End  Form content-->
                                    <aside class="form_man">
                                        <img src="{{ asset('public/Frontend/img/sucsess_code.png') }}" alt="{{ trans('main.site_name') }}">
                                    </aside>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!--=05 Send Code accepted_code -->

        <!--=05=Start Popup accepted_code-->
        @if(Session::has('error_message'))
            <div class="wrrong_code">
                <div class="container">
                    <!-- The Modal -->
                    <div class="modal fade" id="wrong_code">
                        <div class="modal-dialog ">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <button class="close fas fa-times" type="button" data-dismiss="modal"> </button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body model_code">
                                    <!-- Start Form content-->
                                    <div class="form_content">
                                        <p>{{ session()->get('error_message') }}</p>
                                    </div>
                                    <!-- End  Form content-->
                                    <aside class="form_man">
                                        <img src="{{ asset('public/Frontend/img/wrrong_code.png') }}" alt="{{trans('main.site_name')}}">
                                    </aside>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!--=05 Send Code accepted_code -->

        <script src="{{ asset('public/Frontend/js/jquery-1.12.1.min.js') }}"></script>
        <script src="{{ asset('public/Frontend/js/popper.min.js') }}"></script>
        <script src="{{ asset('public/Frontend/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('public/Frontend/js/slick.js') }}"></script>
        @if(LaravelLocalization::getCurrentLocale() =='ar')
            <script src="{{ asset('public/Frontend/js/script-rtl.js') }}"></script>
            @else
            <script src="{{ asset('public/Frontend/js/script.js') }}"></script>
        @endif
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