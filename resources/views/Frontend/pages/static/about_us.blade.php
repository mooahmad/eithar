@extends(FEL.'.master')

@section('content')
    @include(FE.'.layouts.top_header')
    <!-- Start Single Page -->
    @if(LaravelLocalization::getCurrentLocale() =='ar')
            <div class="single_page-content about_us-page">
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
                                <img src="{{ asset('public/Frontend/img/about-us1.png') }}" alt="{{ trans('main.about_us') }}">
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
                                    <img src="{{ asset('public/Frontend/img/our-team.png') }}" alt="{{ trans('main.about_us') }}">
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
                                <img src="{{ asset('public/Frontend/img/about-us1.png') }}" alt="{{ trans('main.about_us') }}">
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
                            أن نكون الأفضل - نسعي دائما لتقديم أفضل النتائج التي تتجاوز توقعات عملائنا وأسرهم ومساعدتهم على تحسين حالتهم الصحية. </p>


                        <h4> أن نكون الأفضل </h4>
                        <p class="paragraph_global">
                            أن نكون الأفضل - نسعي دائما لتقديم أفضل النتائج التي تتجاوز توقعات عملائنا وأسرهم ومساعدتهم على تحسين حالتهم الصحية. </p>
                    </div>
                    <!-- End Our Mission Block-->
                </div>
            </section>
        </div>
        @else
        <div class="single_page-content about_us-page">
            <!--=01= Start About Us-->
            <section class="  aboutus_page-block1">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12  col-lg-8">
                            <aside>
                                <h2 class="home_page-title"> About Eithar</h2>
                                <p class="paragraph_global">
                                    Eithar is a Home Health Care Company that delivers unique comprehensive services, with highly skilled In-Home Health providers; General practitioners, clinical dietitians, Skilled Nurses, and rehabilitation therapists, we provide
                                    Home Care Services to patients in the comfort of their own homes. We save time and effort by providing our services anywhere instead the usual driving to the hospital.
                                    <br>
                                    Therefor we have established ourselves as an industry pioneers to deliver exceptional care to exceed our patients` expectation.
                                </p>
                            </aside>
                        </div>
                        <div class="col-sm-12  col-lg-4">
                            <aside class="about_us-img">
                                <img src="{{ asset('public/Frontend/img/about-us1.png') }}" alt="{{ trans('main.about_us') }}">
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
                                    <img src="{{ asset('public/Frontend/img/our-team.png') }}" alt="{{ trans('main.about_us') }}">
                                </aside>
                            </div>
                            <div class="col-sm-12  col-lg-8">
                                <aside>
                                    <h2 class="home_page-title"> EITHAR TEAM</h2>
                                    <p class="paragraph_global">
                                        <b>Quality Care is an unwavering commitment to our clients. </b>
                                        <br>
                                        Our home health care team is highly experienced in delivering exceptional care and support for clients – regardless of age or specific medical needs. We apply the highest clinical care standards, innovation in utilization
                                        management, and latest service delivery protocols in areas such as fall risk safety, infection control management, and multidisciplinary care coordination.
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
                                <h2 class="home_page-title"> VISION and Mission </h2>
                                <p class="paragraph_global">
                                    With passionate people we can make a difference in the Home Health Care services. We strive to be recognized as a leader in our field because of our commitment as a young Saudi citizen
                                </p>
                            </aside>
                            <!-- Start Our Mission Block-->
                            <div class="our_mission-block">
                                <h3> MISSION </h3>
                                <aside class="">
                                    <p class="paragraph_global">
                                        To be the most trusted home healthcare provider in the KSA. Our professional, compassionate healthcare team helps clients attain their highest level of independence by providing the right care and support to the client and their
                                        family at the right time and place. </p>
                                    <h4> We love improving people’s lives </h4>
                                </aside>
                            </div>
                            <!-- End Our Mission Block-->
                        </div>
                        <div class="col-sm-12  col-lg-4">
                            <aside class="about_us-img">
                                <img src="{{ asset('public/Frontend/img/about-us1.png') }}" alt="{{ trans('main.about_us') }}">
                            </aside>
                        </div>

                    </div>
                    <!-- Start Our Mission Block-->
                    <div class="our_mission-block">
                        <h3> VALUES </h3>
                        <h4> Loyalty </h4>
                        <p class="paragraph_global">
                            we believe we are committed to service the people in our community. We are loyal to our profession and our own people. "None of you believes until he loves for his brother what he loves for himself." (Mohamed Ibn Abdallah,
                            Sahih Muslim 45).
                        </p>
                        <h4> Collaboration</h4>
                        <p class="paragraph_global">
                            the client is always at the forefront of care delivery and we are committed to working in collaboration with our team members, clients and their families to enable them to make informed decisions about their care.
                        </p>
                        <h4> Excellence </h4>
                        <p class="paragraph_global">
                            Our commitment to excellence results in our team members going above and beyond to deliver the highest standards of Home Health Care.
                        </p>
                        <h4> Innovative </h4>
                        <p class="paragraph_global">
                            We believe that clinical care supported with technology will improve decision-making, guide to appropriate care, and result in optimal outcomes for our clients
                        </p>
                    </div>
                    <!-- End Our MissionQuality Care is an unwavering commitment to our clients Block-->
                </div>
            </section>
        </div>
    @endif
    <!-- End Single Page -->
@stop
