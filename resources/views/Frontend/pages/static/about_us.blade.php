@extends(FEL.'.master')

@section('content')
    @include(FE.'.layouts.top_header')
    <!-- Start Single Page -->
    <div class="single_page-content about_us-page">
        <!--=01= Start About Us-->
        <section class=" home-page-aboutus aboutus_page-block1">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12  col-lg-8">
                        <aside>
                            <h2 class="home_page-title"> من نحن ؟</h2>
                            <p class="paragraph_global">
                                لوريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف
                                بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع
                                إصدار
                                رقائق "ليتراسيت" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل "ألدوس بايج مايكر" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم
                            </p>
                        </aside>
                    </div>

                    <div class="col-sm-12  col-lg-4">
                        <aside class="about_us-img">
                            <img src="{{ asset('public/Frontend/img/about-us1.png') }}" alt=" من نحن">
                        </aside>
                    </div>


                </div>
            </div>
        </section>
        <!--=01= End About Us-->
        <!--=01= Start About Us-->
        <section class=" home-page-aboutus aboutus_page-block2">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12  col-lg-4">
                        <aside class="about_us-img">
                            <img src="{{ asset('public/Frontend/img/about-us2.png') }}" alt=" من نحن">
                        </aside>
                    </div>

                    <div class="col-sm-12  col-lg-8">
                        <aside>
                            <h2 class="home_page-title"> من نحن ؟</h2>
                            <p class="paragraph_global">
                                لوريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف
                                بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع
                                إصدار
                                رقائق "ليتراسيت" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل "ألدوس بايج مايكر" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم
                            </p>
                        </aside>
                    </div>
                </div>
            </div>
        </section>
        <!--=01= End About Us-->

        <!--Start Contact with us Content-->
        <div class="contactus_section">
            <div class="container">
                <h2 class="home_page-title"> كن دائما على اتصال بنا</h2>
                <ul class="list_inline">

                    <li>
                        <a href="#"><i class="fas fa-phone"></i></a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </li>
                    <li>
                        <a href="#"> <i class="fab fa-facebook-f"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fab fa-twitter"></i> </a>
                    </li>

                    <li>
                        <a href="#"> <i class="fab fa-instagram"></i></a>
                    </li>
                </ul>
            </div>
        </div>
        <!--End Contact with us Content-->
    </div>
    <!-- End Single Page -->
@stop
