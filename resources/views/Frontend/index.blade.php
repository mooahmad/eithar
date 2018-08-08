@extends(FEL.'.master')

@section('content')

    <!--=02= Start Header Slider-->
    <div class="header_slider header_slider-js ">
        <div class="header" data-src="{{ asset('public/Frontend/img/bg/bg-header1.png') }}">
            <aside>
                <h1>
                    <b> اسهل طريقة لحجز احسن واكبر الأطباء في الســــــــعودية </b>
                    <br> احجز أونلاين أو من التطبيق
                </h1>
            </aside>
        </div>

        <div class="header" data-src="{{ asset('public/Frontend/img/bg/bg-header1.png') }}">
            <aside>
                <h1>
                    <b> اسهل طريقة لحجز احسن واكبر الأطباء في الســــــــعودية </b>
                    <br> احجز أونلاين أو من التطبيق
                </h1>
            </aside>
        </div>

        <div class="header" data-src="{{ asset('public/Frontend/img/bg/bg-header1.png') }}">
            <aside>
                <h1>
                    <b> اسهل طريقة لحجز احسن واكبر الأطباء في الســــــــعودية </b>
                    <br> احجز أونلاين أو من التطبيق
                </h1>
            </aside>
        </div>

    </div>
    <!--=02= End Header Slider-->


    <!--=03= Start Search Subheader-->
    <div class="serach_subheader">
        <div class="container">
            <div class="serach_subheader-content">
                <form>
                    <aside class="serach_subheader-department">
                        <input type="button" class="department_button" value=" رعاية اولادي">
                        <input type="button" class="department_button" value="ممرضات ">
                        <input type="button" class="department_button" value="علاج طبيعي ">
                        <input type="button" class="department_button" value=" المـــعامل">
                        <input type="button" class="department_button" value="الأطباء ">
                    </aside>
                    <aside class="serach_subheader-searsh">
                        <button type="submit" class="fas fa-search"></button>
                        <input type="text" placeholder="بحث">
                        <div class="serach_subheader-select">
                            <select>
                                <option> دكتور</option>
                                <option> دكتور</option>
                                <option> دكتور</option>
                            </select>

                            <select>
                                <option> دكتور</option>
                                <option> دكتور</option>
                                <option> دكتور</option>
                            </select>
                        </div>

                    </aside>
                </form>
            </div>
        </div>
    </div>
    <!--=03= End Search Subheader-->

    <!--=04= Start About Us-->
    <section class="home_page-section home-page-aboutus">
        <div class="container">
            <div class="row">
                <div class="col-sm-12  col-lg-6">
                    <aside>
                        <img src="{{ asset('public/Frontend/img/bg/bg-about-us.png') }}" alt="{{ trans('main.site_name') }}">
                    </aside>
                </div>

                <div class="col-sm-12  col-lg-6">
                    <aside>
                        <h2 class="home_page-title"> من نحن ؟</h2>
                        <p class="paragraph_global">
                            لوريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق "ليتراسيت" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل "ألدوس بايج مايكر" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم
                        </p>
                        <a href="#" class="button"> المزيد</a>
                    </aside>
                </div>
            </div>

        </div>
    </section>
    <!--=04= End About Us-->

    <!--=05= Start Services-->
    <section class="home_page-section home_page-services">
        <div class="container-fluid">
            <aside class="services_title">
                <h2 class="home_page-title"> خــدمــاتنا</h2>
                <p class="paragraph_global">
                    وريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف
                </p>
            </aside>
            <div class="row">
                <!--Start Block 1-->
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="services_block">
                        <aside class="services_block-icon">
                            <img alt="{{ trans('main.site_name') }}" src="{{ asset('public/Frontend/img/icon/services-doctor.png') }}">
                        </aside>
                        <aside class="services_block-paragraph">
                            <h3> الاطباء</h3>
                            <p class="paragraph_global">
                                وريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار
                            </p>
                            <a href="#" class="button"> المزيد</a>
                        </aside>
                    </div>
                </div>
                <!--End Block 1-->

                <!--Start Block 2-->
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="services_block">
                        <aside class="services_block-icon">
                            <img alt="{{ trans('main.site_name') }}" src="{{ asset('public/Frontend/img/icon/services-lab.png') }}">
                        </aside>
                        <aside class="services_block-paragraph">
                            <h3> المعامل</h3>
                            <p class="paragraph_global">
                                وريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار
                            </p>
                            <a href="#" class="button"> المزيد</a>
                        </aside>
                    </div>
                </div>
                <!--End Block 2-->

                <!--Start Block 3-->
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="services_block">
                        <aside class="services_block-icon">
                            <img alt="{{ trans('main.site_name') }}" src="{{ asset('public/Frontend/img/icon/services-nurse.png') }}">
                        </aside>
                        <aside class="services_block-paragraph">
                            <h3> الممرضات</h3>
                            <p class="paragraph_global">
                                وريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار
                            </p>
                            <a href="#" class="button"> المزيد</a>
                        </aside>
                    </div>
                </div>
                <!--End Block 3-->

                <!--Start Block 4-->
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="services_block">
                        <aside class="services_block-icon">
                            <img alt="{{ trans('main.site_name') }}" src="{{ asset('public/Frontend/img/icon/services-therapy.png') }}">
                        </aside>
                        <aside class="services_block-paragraph">
                            <h3> علاج طبيعي</h3>
                            <p class="paragraph_global">
                                وريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار
                            </p>
                            <a href="#" class="button"> المزيد</a>
                        </aside>
                    </div>
                </div>
                <!--End Block 4-->


                <!--Start Block 5-->
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="services_block">
                        <aside class="services_block-icon">
                            <img alt="{{ trans('main.site_name') }}" src="{{ asset('public/Frontend/img/icon/services-childern.png') }}">
                        </aside>
                        <aside class="services_block-paragraph">
                            <h3> رعاية الأطفال</h3>
                            <p class="paragraph_global">
                                وريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار
                            </p>
                            <a href="#" class="button"> المزيد</a>
                        </aside>
                    </div>
                </div>
                <!--End Block 5-->
            </div>
        </div>
    </section>
    <!--=05= End Services-->

    <!--=06= Start Services Order-->
    <section class="home_page-section services_order">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-lg-6">
                    <h2 class="home_page-title">أطلب الخدمة </h2>
                    <p class="paragraph_global">
                        وريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر.
                    </p>

                    <!-- Start Glopal Form-->
                    <form class="row glopal_form">
                        <div class="col-sm-12 col-md-6 ">
                            <label>الاسم الأول :</label>
                            <input type="text" placeholder="الاسم :">
                        </div>

                        <div class="col-sm-12 col-md-6 ">
                            <label>الاسم الاخير :</label>
                            <input type="text" placeholder="الاسم الاخير :">
                        </div>

                        <div class="col-sm-12  col-md-6">
                            <label>الجوال :</label>
                            <input type="text" placeholder="الجوال :">
                        </div>

                        <div class="col-sm-12  col-md-6">
                            <label>المدينة :</label>
                            <input type="text" placeholder="المدينة :">
                        </div>

                        <div class="col-sm-12">
                            <label>العـنوان :</label>
                            <aside class="location ">

                                <input type="text" placeholder="العـنوان :">
                                <i class="fas fa-map-marker-alt"></i>
                            </aside>

                        </div>

                        <div class="col-sm-12  col-md-6">
                            <label>الخدمات </label>
                            <select>
                                <option> دكتور </option>
                                <option> معمل </option>
                            </select>
                        </div>

                        <div class="col-sm-12  col-md-6">
                            <label>الخدمات الفرعية </label>
                            <select>
                                <option> دكتور </option>
                                <option> معمل </option>
                            </select>
                        </div>

                        <button class="button-blue glopal_form-button" type="submit"> ارسال</button>
                    </form>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <aside class="services_order-img">
                        <img src="{{ asset('public/Frontend/img/services-order.png') }}" alt="{{ trans('main.site_name') }}">
                    </aside>
                </div>
            </div>
        </div>
    </section>
    <!--=06= End Services Order-->
@stop
