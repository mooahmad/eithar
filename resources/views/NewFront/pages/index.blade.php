@extends(NFEL.'.master')

@section('content')
    <!-- start slider-->
    <section class="slider">
        <div class="bd-example">
            <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('public/NewFront/images/Slider/slider1.jpg')}}" class="d-block w-100" alt="{{ trans('main.site_name') }}">
                        <div class="carousel-caption d-none d-md-block">
                            <h1><strong> آهلاً وسهلاً في إيثار </strong> </h1>
                            <p>الرعاية التزام وهذا ما نعد بيه دائما عملائنا</p>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </section>
    <!-- end slider-->

    <!--    start search-->
    <section class="search">
        <div class="container">
            <form>
                <div class="row ">
                    <div class="col-md-12 col-lg">
                        <label>التخصص</label>
                        <div class="form-group">
                            <select class="form-control">
                                <option value="" disabled selected>اختر التخصص</option>
                                <option value="1">1</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg">
                        <label>تاريخ الموعد</label>
                        <input type='text' class="form-control" placeholder="اختر التاريخ" id='datetimepicker1' />
                    </div>
                    <div class="col-md-12 col-lg">
                        <label>المدينة</label>
                        <div class="form-group">
                            <select class="form-control">
                                <option value="" disabled selected>اختر المدينة</option>
                                <option value="1">1</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg">
                        <label>الطبيب/التمريض</label>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="ادخل الاسم هنا">
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-1 align-self-center">
                        <button class="btn btn-main"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!--    end search-->
    <!-- start about-us-->
    <section class="about-us">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <img src="{{ asset('public/NewFront/images/site-images/about.jpg') }}" class="img-fluid" alt="{{ trans('main.site_name') }}">
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="title">
                        <h2>من نحن</h2>
                    </div>
                    <div class="description">
                        <p>إيثار هي شركة سعودية تسعى أن تكون من رواد تقديم الخدمات الطبية المنزلية بأعلى جودة في العديد من النواحي بفريقها الطبي المتكامل المكون من نخبة من الأطباء ومتخصصين العلاج الطبيعي , التغذية ، التمريض والعديد من التخصصات التي تضمن تقديم خدماتنا توفر لهم الوقت والجهد كما تشمل خدماتنا أعلى مستوى من الرعاية للأمهات الحوامل والمرضعات، والرعاية ما بعد العمليات الجراحية.الرعاية التامة للمريض داخل المنزل. إيثار هي الرائدة في مجال الرعاية الصحية المنزلية التي تتجاوز توقعات المرضى.
                        </p>
                    </div>
                    <a href="#" class="r-more btn-main">اقرأ المزيد</a>
                </div>
            </div>
        </div>
    </section>
    <!-- end about-us-->
    <!-- start services-->
    <section class="services">
        <div class="container">
            <div class="title text-center">
                <h2>خدماتنا</h2>
            </div>
            <div class="description">
                <p>
                    خدمات إيثار الطبية سوف توفر عليك الوقت الجهد حيث إن خدماتنا منزلية ولا يتطلب الخروج من المنزل. اختر من التخصصات التالية، واحجز ميعادك ليصلك مندوب ايثار:
                </p>
            </div>
            <div class="owl-carousel ">
                <div class="item">
                    <div class="icon"><img src="{{ asset('public/NewFront/images/icons/avatar.png') }}" alt="{{ trans('main.site_name') }}"></div>
                    <div class="title">
                        <h5>العلاج الطبيعي والتأهيل</h5>
                    </div>
                    <div class="desc">
                        <p>تتميز ايثار بالتخصصات الدقيقة في علوم العلاج الطبيعي والتأهيل. يعمل أخصائيو العلاج الطبيعي على القدرة الحركية مثل الجلوس و الوقوف
                        </p>
                    </div>
                    <div class="read-more text-center">
                        <a href="#" class=" r-more btn-main">اقرأ المزيد</a>
                    </div>
                </div>
                <div class="item">
                    <div class="icon"><img src="{{ asset('public/NewFront/images/icons/flask.png') }}" alt="{{ trans('main.site_name') }}"></div>
                    <div class="title">
                        <h5>الأطباء</h5>
                    </div>
                    <div class="desc">
                        <p>تتميز إيثار بتوفير استشاريين من تخصصات مختلفة وتحديد المواعيد مع الاستشاري المختص بالحالة, كما نقدم خدمات الرعاية الأولية المنزلية بجودة ونوعية تضاهي
                        </p>
                    </div>
                    <div class="read-more text-center">
                        <a href="#" class=" r-more btn-main">اقرأ المزيد</a>
                    </div>
                </div>
                <div class="item">
                    <div class="icon"><img src="{{ asset('public/NewFront/images/icons/nurse.png') }}" alt="{{ trans('main.site_name') }}"></div>
                    <div class="title">
                        <h5>خدمات المختبر</h5>
                    </div>
                    <div class="desc">
                        <p>نضمن لك وصول العينات بشكل سليم للمختبر وسرعة اظهار النتيجة. والمتابعة المباشرة والفورية من الفريق المختص حين ظهور النتائج.
                        </p>
                    </div>
                    <div class="read-more text-center">
                        <a href="#" class=" r-more btn-main">اقرأ المزيد</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end services-->
    <!-- start after-visit-->
    <section class="visit text-center">
        <div class="bg-image"><img src="{{ asset('public/NewFront/images/back-ground/hand.jpg') }}" alt="{{ trans('main.site_name') }}"></div>
        <div class="container">
            <div class="title">
                <h2>لماذا نحن مستمرون معك</h2>
            </div>
            <div class="hint">
                <p>بعد زيارة المختص لك تصلك</p>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="image"><img class="img-fluid" src="{{ asset('public/NewFront/images/avatar/workout.png') }}" alt="{{ trans('main.site_name') }}"></div>
                    <div class="title">
                        <h3>التمارين المنزلية</h3>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="image"><img class="img-fluid" src="{{ asset('public/NewFront/images/avatar/doctor.png') }}" alt="{{ trans('main.site_name') }}"></div>
                    <div class="title">
                        <h3>التقارير الطبية</h3>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="image"><img class="img-fluid" src="{{ asset('public/NewFront/images/avatar/medicine.jpg') }}" alt="{{ trans('main.site_name') }}"></div>
                    <div class="title">
                        <h3>مشاركة الخطة العلاجية</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- start after-visit-->
    <!-- start terms-->
    <section class="terms text-center">
        <p>سياسة الاسترجاع بامكانك إيقاف الخدمة واسترجاع قيمة ما تبقى من الجلسات</p>
        <div class="read-more text-center">
            <a href="#" class=" r-more btn-main">اقرأ المزيد</a>
        </div>
    </section>
    <!-- end terms-->
    <!--    start certification-->
    <section class="certification text-center">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="certf">
                        <img src="{{ asset('public/NewFront/images/icons/beat.png') }}" alt="{{ trans('main.site_name') }}">
                        <p>معتمد من قبل وزارة الصحة الرعاية المنزلية المتخصصة </p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="certf">
                        <img src="{{ asset('public/NewFront/images/icons/logo.png') }}" alt="{{ trans('main.site_name') }}">
                        <p>جميع الأخصائيين والأطباء معتمدين من هيئة التخصصات الطبية </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--    end certification-->
    <!--    start blog-->
    <section class="blog">
        <div class="title text-center">
            <h2>آخر النصائح و الأخبار الطبية</h2>
        </div>
        <div class="container">
            <div class="row">

                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="artical">
                        <div class="img">
                            <a href="#">
                                <img class="img-fluid" src="{{ asset('public/NewFront/images/blog/bitmap-2.png') }}" alt="{{ trans('main.site_name') }}">
                            </a>
                        </div>
                        <div class="blog-caption">
                            <div class="art-title text-center">
                                <a href="#">
                                    <h4> إيثار الطبية سوف توفر عليك الوقت الجهد</h4>
                                </a>
                            </div>
                            <div class="sm-desc">
                                <p>ايثار تقدم خدمات الزيارات التمريضية المستمرة والتي تشمل على العناية الشخصية للمريض وقياس العلامات الجسم الحيوية ومتابعة النظام الصحي والغذائي للمريض.
                                </p>
                            </div>
                            <div class="read-more text-center">
                                <a href="#" class=" r-more btn-main">اقرأ المزيد</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="artical">
                        <div class="img">
                            <a href="#">
                                <img class="img-fluid" src="{{ asset('public/NewFront/images/blog/bitmap-1.png') }}" alt="{{ trans('main.site_name') }}">
                            </a>
                        </div>
                        <div class="blog-caption">
                            <div class="art-title text-center">
                                <a href="#">
                                    <h4> إيثار الطبية سوف توفر عليك الوقت الجهد</h4>
                                </a>
                            </div>
                            <div class="sm-desc">
                                <p>ايثار تقدم خدمات الزيارات التمريضية المستمرة والتي تشمل على العناية الشخصية للمريض وقياس العلامات الجسم الحيوية ومتابعة النظام الصحي والغذائي للمريض.
                                </p>
                            </div>
                            <div class="read-more text-center">
                                <a href="#" class=" r-more btn-main">اقرأ المزيد</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="artical">
                        <div class="img">
                            <a href="#">
                                <img class="img-fluid" src="{{ asset('public/NewFront/images/blog/bitmap.png') }}" alt="{{ trans('main.site_name') }}">
                            </a>
                        </div>
                        <div class="blog-caption">
                            <div class="art-title text-center">
                                <a href="#">
                                    <h4> إيثار الطبية سوف توفر عليك الوقت الجهد</h4>
                                </a>
                            </div>
                            <div class="sm-desc">
                                <p>ايثار تقدم خدمات الزيارات التمريضية المستمرة والتي تشمل على العناية الشخصية للمريض وقياس العلامات الجسم الحيوية ومتابعة النظام الصحي والغذائي للمريض.
                                </p>
                            </div>
                            <div class="read-more text-center">
                                <a href="#" class=" r-more btn-main">اقرأ المزيد</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--    end blog-->
    <!--    start partners-->
    <section class="partners">
        <div class="container">
            <div class="title text-center">
                <h2>شركاؤنا</h2>
            </div>
            <div class="owl-carousel ">
                <div class="item">
                    <img src="{{ asset('public/NewFront/images/partners/pr1.png') }}" alt="{{ trans('main.site_name') }}">
                </div>
                <div class="item">
                    <img src="{{ asset('public/NewFront/images/partners/pr2.png') }}" alt="{{ trans('main.site_name') }}">
                </div>
            </div>
        </div>
    </section>
    <!--    end partners-->
@stop

@section('js')
    @if(Session::has('account_activate'))
        <script>
            $('#sucsess_code').modal('show');
        </script>
    @endif
@stop