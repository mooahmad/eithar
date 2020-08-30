@extends(NFEL.'.master')

@section('content')
    <!-- start breadcrumb-->
    <nav class="bread" aria-label="breadcrumb">
        <div class="bg-image" style=" background: url({{ asset('public/NewFront/images/site-images/breadcrumb.jpg') }});"></div>
        <div class="container">
            <div class="title">
                <h2>{{ trans('main.about_us') }}</h2>
            </div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url()->route('home') }}">{{ trans('main.home') }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ trans('main.about_us') }}</li>
            </ol>
        </div>
    </nav>

    <!-- end breadcrumb -->
    <!-- start about-us-->
    <section class="about-us">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="description">
                        <p>إيثار هي شركة سعودية تسعى أن تكون من رواد تقديم الخدمات الطبية المنزلية بأعلى جودة في العديد من النواحي بفريقها الطبي المتكامل المكون من نخبة من الأطباء ومتخصصين العلاج الطبيعي , التغذية ، التمريض والعديد من التخصصات التي تضمن تقديم خدماتنا توفر لهم الوقت والجهد كما تشمل خدماتنا أعلى مستوى من الرعاية للأمهات الحوامل والمرضعات، والرعاية ما بعد العمليات الجراحية.الرعاية التامة للمريض داخل المنزل. إيثار هي الرائدة في مجال الرعاية الصحية المنزلية التي تتجاوز توقعات المرضى. إيثار هي شركة سعودية تسعى أن تكون من رواد تقديم الخدمات الطبية المنزلية بأعلى جودة في العديد من النواحي بفريقها الطبي المتكامل المكون من نخبة من الأطباء ومتخصصين العلاج الطبيعي , التغذية ، التمريض والعديد من التخصصات التي تضمن تقديم خدماتنا توفر لهم الوقت والجهد كما تشمل خدماتنا أعلى مستوى من الرعاية للأمهات الحوامل والمرضعات، والرعاية ما بعد العمليات الجراحية.الرعاية التامة للمريض داخل المنزل. إيثار هي الرائدة في مجال الرعاية الصحية المنزلية التي تتجاوز توقعات المرضى.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end about-us-->

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
@stop