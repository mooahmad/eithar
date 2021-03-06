<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> إيثار </title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('public/Frontend/img/fivicon.png') }}"/>

    <link rel="stylesheet" href="{{ asset('public/Frontend/css/fontawesome-all.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/Frontend/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/Frontend/css/bootstrap-rtl.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/Frontend/css/slick.css') }}" />

    <link rel="stylesheet" href="{{ asset('public/Frontend/css/them.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/Frontend/css/them.rtl.css') }}" />

    <!--Fonts-->
    <link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<!--=02= Start Header Slider-->
<div class="header_slider single_page-head landing_page ">
    <div class="header" data-src="{{ asset('public/Frontend/img/bg/bg-header1.png') }}">
        <!-- Start Head of Comming Soon-->
        <div class="container">
            <div class="landing_header-content">


                <div class="logo">
                    <img src="{{ asset('public/Frontend/img/logo/logo.png') }}" alt="">
                </div>
                <h1> دامك بخير
                    <br>
                    ايثار بخير
                </h1>
                <p> قريباً </p>

                <div class="header_button-content">
                    <a href="#services" class="button"> خدماتنا </a>
                    <a href="#about-us" class="button"> من نحن </a>
                </div>

                <ul class="social_media list-unstyled">
                    <li> تواصل معنا </li>
                    <li> <a href="https://wa.me/966505998864" target="_blank" title="whatsapp " class="fab  fa-whatsapp"></a></li>
                    <li> <a href="https://twitter.com/EitharHomeCare" target="_blank" title="twitter " class="fab fa-twitter"></a></li>
                    <li> <a href="https://www.instagram.com/EitharHomeCare" target="_blank" title="instagram" class="fab fa-instagram"></a></li>
                    <li> <a href="tel:920010893" target="_blank" title="Phone Number" class="fas fa-phone"></a></li>
                </ul>
                <!-- End Head of Comming Soon-->
            </div>
        </div>
        <div class="down_icon">
            <i class="fas fa-arrow-down"></i>
        </div>

    </div>
</div>
<!--=02= End Header Slider-->

<!--=05= Start Services-->
<section id="services" class="home_page-section home_page-services">
    <div class="container-fluid">
        <aside class="services_title">
            <h2 class="home_page-title"> خــدمــاتنا</h2>
            <p class="paragraph_global">
                خدمات إيثار الطبية سوف توفر عليك الوقت الجهد حيث إن خدماتنا منزلية ولا يتطلب الخروج من المنزل.
                <br>
                اختر من التخصصات التالية، واحجز ميعادك ليصلك مندوب ايثار:
            </p>

        </aside>
        <div class="row">

            <!--Start Block 1-->
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="services_block">
                    <aside class="services_block-icon">
                        <img alt="Servises icon" src="{{ asset('public/Frontend/img/icon/services-doctor.png') }}">
                    </aside>
                    <aside class="services_block-paragraph">
                        <h3> الاطباء</h3>
                        <p class="paragraph_global">
                            تتميز إيثار بتوفير استشاريين من تخصصات مختلفة وتحديد المواعيد مع الاستشاري المختص بالحالة, كما نقدم خدمات الرعاية الأولية المنزلية بجودة ونوعية تضاهي ما يقدم في مراكز الرعاية الأولية </p>

                    </aside>


                </div>
            </div>
            <!--End Block 1-->

            <!--Start Block 2-->
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="services_block">
                    <aside class="services_block-icon">
                        <img alt="Servises icon" src="{{ asset('public/Frontend/img/icon/services-lab.png') }}">
                    </aside>
                    <aside class="services_block-paragraph">
                        <h3> خدمات المختبر </h3>
                        <p class="paragraph_global">
                            نضمن لك وصول العينات بشكل سليم للمختبر وسرعة اظهار النتيجة. والمتابعة المباشرة والفورية من الفريق المختص حين ظهور النتائج.
                        </p>

                    </aside>
                </div>
            </div>
            <!--End Block 2-->

            <!--Start Block 3-->
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="services_block">
                    <aside class="services_block-icon">
                        <img alt="Servises icon" src="{{ asset('public/Frontend/img/icon/services-nurse.png') }}">
                    </aside>
                    <aside class="services_block-paragraph">
                        <h3> خدمات التمريض</h3>
                        <p class="paragraph_global">
                            ايثار تقدم خدمات الزيارات التمريضية المستمرة والتي تشمل على العناية الشخصية للمريض وقياس العلامات الجسم الحيوية ومتابعة النظام الصحي والغذائي للمريض.
                        </p>

                    </aside>
                </div>
            </div>
            <!--End Block 3-->


            <!--Start Block 4-->
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="services_block">
                    <aside class="services_block-icon">
                        <img alt="Servises icon" src="{{ asset('public/Frontend/img/icon/services-therapy.png') }}">
                    </aside>
                    <aside class="services_block-paragraph">
                        <h3> العلاج الطبيعي والتأهيل </h3>
                        <p class="paragraph_global">
                            تتميز ايثار بالتخصصات الدقيقة في علوم العلاج الطبيعي والتأهيل. يعمل أخصائيو العلاج الطبيعي على القدرة الحركية مثل الجلوس و الوقوف و المشي و كما يعملون أيضا على قوة العضلات و مرونتها. </p>

                    </aside>
                </div>
            </div>
            <!--End Block 4-->


            <!--Start Block 5-->
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="services_block">
                    <aside class="services_block-icon">
                        <img alt="Servises icon" src="{{ asset('public/Frontend/img/icon/services-childern.png') }}">
                    </aside>
                    <aside class="services_block-paragraph">
                        <h3> رعاية الام والطفل</h3>
                        <p class="paragraph_global">
                            لدينا فريق من القابلات والمتخصصات المؤهلات لتقديم كل ما يخص الام والطفل بعد الولادة من فحوصات للأم والطفل، وتقديم النصائح للعناية بالطفل وكذلك التشجيع وتذليل المشاكل المتعلقة بالرضاعة الطبيعية </p>

                    </aside>
                </div>
            </div>
            <!--End Block 5-->



        </div>
    </div>
</section>
<!--=05= End Services-->
<!-- Start Single Page -->
<div id="about-us" class="single_page-content about_us-page">
    <!--=01= Start About Us-->
    <section class="  aboutus_page-block1">
        <div class="container">
            <div class="row">
                <div class="col-sm-12  col-lg-8">
                    <aside>
                        <h2 class="home_page-title"> من نحن ؟</h2>
                        <p class="paragraph_global">
                            إيثار هي شركة سعودية تسعى أن تكون من رواد تقديم الخدمات الطبية المنزلية بأعلى جودة في العديد من النواحي بفريقها الطبي المتكامل المكون من نخبة من الأطباء ومتخصصين العلاج الطبيعي , التغذية ، التمريض والعديد من التخصصات التي تضمن تقديم
                            الرعاية التامة للمريض داخل المنزل.
                            <br>
                            خدماتنا توفر لهم الوقت والجهد كما تشمل خدماتنا أعلى مستوى من الرعاية للأمهات الحوامل والمرضعات، والرعاية ما بعد العمليات الجراحية.
                            <br>
                            إيثار هي الرائدة في مجال الرعاية الصحية المنزلية التي تتجاوز توقعات المرضى.
                        </p>
                    </aside>
                </div>

                <div class="col-sm-12  col-lg-4">
                    <aside class="about_us-img">
                        <img src="{{ asset('public/Frontend/img/about-us1.png') }}" alt="About Us Bg">
                    </aside>
                </div>


            </div>
        </div>
    </section>
    <!--=01= End About Us-->
    <!--=01= Start About Us-->
    <section class=" aboutus_page-block2">
        <div class="container">
            <div class="our_team-container">


                <div class="row">
                    <div class="col-sm-12  col-lg-4">
                        <aside class="about_us-img">
                            <img src="{{ asset('public/Frontend/img/our-team.png') }}" alt="About Us Bg">
                        </aside>
                    </div>

                    <div class="col-sm-12  col-lg-8">
                        <aside>
                            <h2 class="home_page-title"> فريق إيثار</h2>
                            <p class="paragraph_global">
                                <b> الرعاية التزام، وهذا ما نعد به دائما عملائنا </b>
                                <br>
                                فريقنا مدرب على أعلى مستوى ويتميز بالخبرة الكبيرة في تقديم الرعاية الفائقة والدعم بغض النظر عن السن أو الجنس أو الحالة الصحية.
                                <br>
                                ودائما حريصين على اعتماد أعلى معايير الرعاية الطبية، والابتكار في الاستخدام بما يتناسب مع جميع العملاء.
                                <br>
                                كما اننا نراعى استخدام أحدث البروتوكولات للعديد من الخدمات مثل إدارة مخاطر السقوط ومكافحة العدوى والرعاية متعددة التخصصات.
                            </p>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=01= End About Us-->
    <!-- Start Section 3-->
    <section class=" aboutus_page-block1">
        <div class="container">
            <div class="row">
                <div class="col-sm-12  col-lg-8">
                    <aside>
                        <h2 class="home_page-title"> رؤيتنا و اهدافنا</h2>
                        <p class="paragraph_global">
                            يقودنا الشغف والإيمان لإحداث تغيير وتميز في الرعاية الطبية المنزلية . ونسعى دائما كي نكون القادة في تقديم الرعاية الصحية -التي تواكب رؤية 2030-

                        </p>
                    </aside>
                    <!-- Start Our Mission Block-->
                    <div class="our_mission-block">
                        <h3>هدفنا </h3>
                        <aside class="">
                            <p class="paragraph_global">
                                أن نكون الأفضل والأكثر ثقة من عملائنا في تقديم الرعاية الصحية المستحقة. حيث يحرص خبرائنا على دعم المرضى وتحقيق أعلى معدلات الاستقلالية من خلال تقديم المساعدة لهم ولأسرهم فى الوقت المناسب.
                            </p>
                            <h4>غايتنا تغير حياة المرضى للأفضل.</h4>
                        </aside>
                    </div>
                    <!-- End Our Mission Block-->

                </div>

                <div class="col-sm-12  col-lg-4">
                    <aside class="about_us-img">
                        <img src="{{ asset('public/Frontend/img/vision.png') }}" alt="About Us Bg">
                    </aside>
                </div>

            </div>

            <!-- Start Our Mission Block-->
            <div class="our_mission-block">
                <h3>قيمنا </h3>

                <h4>الولاء</h4>
                <p class="paragraph_global">
                    ندين بالولاء لمهنتنا و ملتزمون بتقديم الرعاية الصحية لجميع مرضي مجتمعنا.
                </p>




                <h4>التعاون</h4>
                <p class="paragraph_global">
                    نضع نصب أعيننا راحة المريض ورعايته بما يتناسب مع حالته الصحية، لذلك نعمل دائما على التعاون مع الفريق الطبي وأسرة المريض حتى نوفر كافة احتياجات المريض فى كل الاوقات.
                </p>




                <h4> أن نكون الأفضل </h4>
                <p class="paragraph_global">
                    نسعي دائما لتقديم أفضل النتائج التي تتجاوز توقعات عملائنا وأسرهم ومساعدتهم على تحسين حالتهم الصحية.
                </p>





            </div>
            <!-- End Our Mission Block-->

        </div>
    </section>
    <!--End Section 3-->
    <!-- Start Contact with us Content-->
    <!-- <div class="contactus_section">
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
    </div> -->
    <!--End Contact with us Content -->


</div>
<!-- End Single Page -->


<!--Start Footer -->
<footer>

    <div class="footer_overlay">

        <div class="container">
            <aside class="footer_logo">
                <img src="{{ asset('public/Frontend/img/logo/logo.png') }}">
            </aside>
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <p class="paragraph_global">
                        الرعاية التزام، وهذا ما نعد به دائما عملائنا يقودنا الشغف والإيمان لإحداث تغيير وتميز في الرعاية الطبية المنزلية . ونسعى دائما كي نكون القادة في تقديم الرعاية الصحية -التي تواكب رؤية 2030
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
                    <p class="paragraph_global">

                        يسعدنا أن نبقيك ثابتًا وعلى خدمتك على الرقم الساخن:
                        <bdi> 920010893</bdi>
                    </p>
                    <ul class="list-unstyled about_us">
                        <li> خدمة الدعم الفني : <bdi> 966505998864 </bdi> </li>
                    </ul>

                </div>
            </div>


            <div class="copyright_new">
                <div class="container">
                    <ul class="social_media list-unstyled">

                        <li> <a href="https://wa.me/966505998864" target="_blank" title="whatsapp " class="fab  fa-whatsapp"></a></li>
                        <li> <a href="https://twitter.com/EitharHomeCare" target="_blank" title="twitter " class="fab fa-twitter"></a></li>
                        <li> <a href="https://www.instagram.com/EitharHomeCare" target="_blank" title="instagram" class="fab fa-instagram"></a></li>
                        <li> <a href="tel:920010893" target="_blank" title="Phone Number" class="fas fa-phone"></a></li>
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



<!--
<section class="copyright">
  <div class="container">
      <div class="copyright_content">
          <span> جميع الحقوق محفوظة ايثــار <i class="far fa-copyright"></i> 2018 </span>

          <a href="http://www.hudsystems.com" target="_blank" title="Hud Systems"> <bdi> <i class="far fa-copyright"></i> HUD Systems 2018</bdi>
              </a>
      </div>
  </div>
</section>
-->

<!--=14= End Copyright Section -->



<script src="{{ asset('public/Frontend/js/jquery-1.12.1.min.js') }}"></script>
<script src="{{ asset('public/Frontend/js/popper.min.js') }}"></script>
<script src="{{ asset('public/Frontend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/Frontend/js/slick.js') }}"></script>
<!--    <script src="js/script.js"></script>-->
<script src="{{ asset('public/Frontend/js/script-rtl.js') }}"></script>

</body>

</html>