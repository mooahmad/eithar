        <!--Start Footer -->
        <footer>
            <div class="footer_overlay">
                <div class="container">
                    <aside class="footer_logo">
                        <img src="{{ asset('public/Frontend/img/logo.png') }}" alt="{{ trans('main.site_name') }}">
                    </aside>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <p class="paragraph_global">
                                لوريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق "ليتراسيت" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل "ألدوس بايج مايكر" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم
                            </p>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <h2> اشترك للحصول على النشرة الإخبارية</h2>
                            <form>
                                <aside class="footer_subscribe">
                                    <input type="text" placeholder="البريد الالكترونى">
                                    <button type="submit">ارســــال </button>
                                </aside>
                            </form>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <h2> الاتصــال بنا</h2>
                            <p class="paragraph_global"> يسعدنا أن نبقيك ثابتًا وعلى خدمتك على الرقم الساخن: 009651800082</p>
                            <ul class="list-unstyled about_us">
                                <li> خدمة الإبلاغ : <bdi> 0096597225234</bdi></li>
                                <li> خدمة الدعم الفني : <bdi> 0096596699477</bdi> </li>
                                <li>طلب رابط خاص : <bdi> 0096597277745</bdi> </li>
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
                            <span> جميع الحقوق محفوظة ايثــار © 2018</span>
                        </div>
                    </div>
                </div>
            </div>



        </footer>
        <!-- End Footer -->

        <!--Start Button Go up-->
        <span class="go_up go_up-js fas fa-sort-up"> </span>
        <!--End Button Go up-->
        <!--=14= Start Copyright Section -->

        {{--<section class="copyright">--}}
            {{--<div class="container">--}}
                {{--<div class="copyright_content">--}}
                    {{--<span> جميع الحقوق محفوظة ايثــار <i class="far fa-copyright"></i> 2018 </span>--}}
                    {{--<a href="http://www.hudsystems.com" target="_blank" title="Hud Systems"> <bdi> <i class="far fa-copyright"></i> HUD Systems 2018</bdi>--}}
                    {{--</a>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</section>--}}
        <!--=14= End Copyright Section -->

        <script src="{{ asset('public/Frontend/js/jquery-1.12.1.min.js') }}"></script>
        <script src="{{ asset('public/Frontend/js/popper.min.js') }}"></script>
        <script src="{{ asset('public/Frontend/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('public/Frontend/js/slick.js') }}"></script>
        @if(session()->get('lang') =='ar')
            <script src="{{ asset('public/Frontend/js/script-rtl.js') }}"></script>
        @endif
        @yield('js')
    </body>
</html>