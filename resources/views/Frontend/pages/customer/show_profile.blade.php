@extends(FEL.'.master')

@section('content')
    <!--=02= Start Header Slider-->
    @include(FE.'.layouts.top_header')

    <!-- Start Single Page -->
    <div class="single_page-content">
        <div class=" my-account">
            <div class="container-fluid">
                <div class="row">
                    <!-- Start Profile Menue-->
                    <div class="col-sm-12 col-md-4 col-lg-3">
                        <div class="profile_menu">
                            <aside class="show_menu"><i class="fas fa-chevron-left"></i></aside>
                            <div class="add_image">
                                <aside class="profile_image" data-src="{{ ($customer->profile_picture_path) ? $customer->profile_image : asset('public/Frontend/img/icon/avatar.png') }}">
                                </aside>
                                <h4 class="user_name">{{ $customer->full_name }}</h4>
                                <h5 class="user_email">{{ $customer->email }}</h5>
                            </div>
                            <div class="profile_menu-list">
                                <ul class="menu_list list-unstyled">
                                    <!---Update Profile-->
                                    <li data-id="#EditProfile">
                                        <a href="#">
                                            <i class="fas fa-user-edit"></i>
                                            <span>{{ trans('main.update_information') }} </span>
                                        </a>
                                    </li>
                                    <!---Update Profile-->

                                    <!---Change Password-->
                                    <li data-id="#ForgotPassword">
                                        <a href="#">
                                            <i class="fas fa-unlock"></i>
                                            <span>{{ trans('main.change_password') }}</span>
                                        </a>
                                    </li>
                                    <!---Change Password-->

                                    <li data-id="#meating">
                                        <a href="#">
                                            <i class="fas fa-hand-holding-heart"></i>
                                            <span> upcoming meeting</span>
                                        </a>
                                    </li>


                                    <li data-id="#meating">
                                        <a href="#">
                                            <i class="fas fa-hand-holding-heart"></i>
                                            <span> Old Meeting</span>
                                        </a>
                                    </li>

                                    <li data-id="#wallt">
                                        <a href="#">
                                            <i class="fas fa-file-medical-alt"></i>
                                            <span> Medical Reports </span>
                                        </a>

                                    </li>

                                    <li data-id="#favorite">
                                        <a href="#">
                                            <i class="fas fa-bookmark"></i>
                                            <span> Bookmark </span>
                                        </a>
                                    </li>

                                    <li data-id="#book_mark">
                                        <a href="#">
                                            <i class="fas fa-briefcase-medical"></i>
                                            <span> meeting detials </span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url()->route('customer_logout') }}">
                                            <i class="fas fa-sign-out-alt"></i>
                                            <span>{{ trans('main.logout') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- End Profile Menu-->
                    <div class="col-sm-12 col-md-8 col-lg-9">
                        <div class="">
                            @if(count($errors))
                                <div class="alert alert-danger">
                                    <button class="close" data-close="alert"></button>
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="all_tabs">
                                <!--Start Edit Profile-->
                                <div id="EditProfile">
                                    <!-- Start Single Page -->
                                    <div class="single_page-content ediating_profile">
                                        <!-- Start My Account Pages-->
                                        <div class="">
                                            {!! Form::model($customer,['files' => true,'url'=>url()->route('customer_update_profile_post',['id'=>$customer->id,'name'=>\App\Helpers\Utilities::beautyName($customer->full_name)])]) !!}
                                            <div class="row">
                                                    <div class="col-sm-12 ">
                                                        <div class="profile_form">
                                                            <h2 class="form_title">{{ trans('main.update_information') }}</h2>
                                                            <div class="glopal_form row" get="post">
                                                                <div class="col-sm-12 col-md-6 col-lg-4">
                                                                    <label for="first_name">{{ trans('main.first_name') }}</label>
                                                                    {!! Form::text('first_name',old('first_name'),['placeholder'=>trans('main.first_name'),'required','id'=>'first_name']) !!}
                                                                    @if($errors->has('first_name'))
                                                                        <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                                                    @endif
                                                                </div>

                                                                <div class="col-sm-12 col-md-6 col-lg-4">
                                                                    <label for="middle_name">{{ trans('main.middle_name') }}</label>
                                                                    {!! Form::text('middle_name',old('middle_name'),['placeholder'=>trans('main.middle_name'),'required','id'=>'middle_name']) !!}
                                                                    @if($errors->has('middle_name'))
                                                                        <span class="text-danger">{{ $errors->first('middle_name') }}</span>
                                                                    @endif
                                                                </div>

                                                                <div class="col-sm-12 col-md-6 col-lg-4">
                                                                    <label for="last_name">{{ trans('main.last_name') }}</label>
                                                                    {!! Form::text('last_name',old('last_name'),['placeholder'=>trans('main.last_name'),'required','id'=>'last_name']) !!}
                                                                    @if($errors->has('last_name'))
                                                                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                                                    @endif
                                                                </div>

                                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                                    <label for="email">{{ trans('main.email') }}</label>
                                                                    {!! Form::text('email',old('email'),['placeholder'=>trans('main.email'),'required','id'=>'email']) !!}
                                                                    @if($errors->has('email'))
                                                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                                                    @endif
                                                                </div>

                                                                <div class="col-sm-12 col-lg-6">
                                                                    <aside class="slect_Your-twon">
                                                                        <label for="gender">{{ trans('main.gender') }}</label>
                                                                        <div class="custum_select">
                                                                            {!! Form::select('gender',$gender,old('gender'),['required','id'=>'gender']) !!}
                                                                            @if($errors->has('gender'))
                                                                                <span class="text-danger">{{ $errors->first('gender') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </aside>
                                                                </div>

                                                                <div class="col-sm-12 col-lg-6">
                                                                    <label for="mobile_number">{{ trans('main.mobile_number') }} <bdi> +966 </bdi></label>
                                                                    <div class="phone_number ">
                                                                        {!! Form::text('mobile_number',$mobile,['placeholder'=>trans('main.mobile_number'),'required','id'=>'mobile_number']) !!}
                                                                        @if($errors->has('mobile_number'))
                                                                            <span class="text-danger">{{ $errors->first('mobile_number') }}</span>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 col-lg-6">
                                                                    <label for="national_id">{{ trans('main.national_id') }}</label>
                                                                    {!! Form::text('national_id',old('national_id'),['placeholder'=>trans('main.national_id'),'required','id'=>'national_id']) !!}
                                                                    @if($errors->has('national_id'))
                                                                        <span class="text-danger">{{ $errors->first('national_id') }}</span>
                                                                    @endif
                                                                </div>

                                                                <div class="col-sm-12 col-md-6  col-lg-6">
                                                                    <label for="profile_picture_path">{{ trans('main.profile_picture') }}</label>
                                                                    <lable class="button" id="upload_imag" type="file"> <i class="fas fa-upload"> </i>
                                                                        <span>{{ trans('main.profile_picture') }}</span>
                                                                        {!! Form::file('profile_picture_path',old('profile_picture_path'),['placeholder'=>trans('main.profile_picture'),'required','id'=>'profile_picture_path']) !!}
                                                                    </lable>
                                                                    @if($errors->has('profile_picture_path'))
                                                                        <span class="text-danger">{{ $errors->first('profile_picture_path') }}</span>
                                                                    @endif
                                                                </div>

                                                                <div class="col-sm-12 col-md-6  col-lg-6">
                                                                    <label for="nationality_id_picture">{{ trans('main.nationality_id_picture') }}</label>
                                                                    <lable class="button" id="upload_imag" type="file"> <i class="fas fa-upload"> </i>
                                                                        <span>{{ trans('main.nationality_id_picture') }}</span>
                                                                        {!! Form::file('nationality_id_picture',old('nationality_id_picture'),['placeholder'=>trans('main.nationality_id_picture'),'required','id'=>'nationality_id_picture']) !!}
                                                                    </lable>
                                                                    @if($errors->has('nationality_id_picture'))
                                                                        <span class="text-danger">{{ $errors->first('nationality_id_picture') }}</span>
                                                                    @endif
                                                                </div>

                                                                <div class="col-sm-12 col-lg-6">
                                                                    <aside class="slect_Your-twon">
                                                                        <label for="country_id">{{ trans('main.country') }}</label>
                                                                        <div class="custum_select">
                                                                            {!! Form::select('country_id',$countries,old('country_id'),['id'=>'country_id','required','onchange'=>'changeCountry(this);']) !!}
                                                                            @if($errors->has('country_id'))
                                                                                <span class="text-danger">{{ $errors->first('country_id') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </aside>
                                                                </div>

                                                                <div class="col-sm-12 col-lg-6">
                                                                    <aside class="slect_Your-twon">
                                                                        <label for="city_id">{{ trans('main.city') }}</label>
                                                                        <div class="custum_select">
                                                                            {!! Form::select('city_id',$cities,old('city_id'),['id'=>'city_id','placeholder'=>trans('main.city'),'required']) !!}
                                                                            @if($errors->has('city_id'))
                                                                                <span class="text-danger">{{ $errors->first('city_id') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </aside>
                                                                </div>

                                                                <div class="col-sm-12 col-lg-6">
                                                                    <label for="address">{{ trans('main.address') }}</label>
                                                                    {!! Form::text('address',old('address'),['id'=>'address','placeholder'=>trans('main.address'),'required']) !!}
                                                                    @if($errors->has('address'))
                                                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                                                    @endif
                                                                </div>

                                                                <div class="col-sm-12 col-md-6">
                                                                    <label for="position">{{ trans('main.position') }}</label>
                                                                    {!! Form::text('position',old('position'),['id'=>'position','placeholder'=>trans('main.position'),'required','readonly']) !!}
                                                                    @if($errors->has('position'))
                                                                        <span class="text-danger">{{ $errors->first('position') }}</span>
                                                                    @endif
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <label for="about">{{ trans('main.about') }}</label>
                                                                    {!! Form::textarea('about',old('about'),['cols'=>80,'rows'=>8,'placeholder'=>trans('main.about'),'id'=>'about']) !!}
                                                                    @if($errors->has('about'))
                                                                        <span class="text-danger">{{ $errors->first('about') }}</span>
                                                                    @endif
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <button class="button" type="submit">{{ trans('main.update') }}</button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            {!! Form::close() !!}
                                        </div>
                                        <!-- End My Account Pages-->
                                    </div>
                                    <!-- End Single Page -->
                                </div>

                                <!-- Start Meeting-->
                                <div id="meating">
                                    <!-- Start Speacial Seation-->
                                    <section class="speacial_section">
                                        <h3 class="all_tabs-title">جلسات خاصة</h3>
                                        <div class="list_coaches">
                                            <div class="">
                                                <div class="row">
                                                    <!--Start Block -->
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="coach_block" data-src="img/avatar_coach.png">
                                                            <div class="coach_block-description">
                                                                <h3>Life Coatch</h3>
                                                                <h4>18 /9 /2018</h4>
                                                                <h5>علاقات زوجية</h5><a class="button" href="#">ابدأ الان</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--End Block -->
                                                    <!--Start Block -->
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="coach_block" data-src="img/bg/consult1.png">
                                                            <div class="coach_block-description">
                                                                <h3>Life Coatch</h3>
                                                                <h4>18 /9 /2018</h4>
                                                                <h5>علاقات زوجية</h5><a class="button" href="#">ابدأ الان</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--End Block-->
                                                    <!--Start Block -->
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="coach_block" data-src="img/bg/consult1.png">
                                                            <div class="coach_block-description">
                                                                <h3>Life Coatch</h3>
                                                                <h4>18 /9 /2018</h4>
                                                                <h5>علاقات زوجية</h5><a class="button" href="#">ابدأ الان</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--End Block-->
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <!-- End Speacial Seation-->
                                    <!-- Start Programing -->
                                    <section class="programing_subscribe">
                                        <h3 class="all_tabs-title">جلسات خاصة</h3>
                                        <div class="list_cources-content">
                                            <div class="">
                                                <div class="row">
                                                    <!--Start Block -->
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="coach_block" data-src="img/bg/consult1.png">
                                                            <div class="coach_block-description">
                                                                <h3>Life Coatch</h3>
                                                                <h4>18 /9 /2018</h4>
                                                                <h5>علاقات زوجية</h5><a class="button" href="#">ابدأ الان</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--End Block-->
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <!-- End Programing-->
                                    <!-- Start Packedg Subscrib-->
                                    <section class="pakedge_subscribe">
                                        <h3 class="all_tabs-title"> دورات تدريبية</h3>
                                        <div class="">
                                            <div class="row">
                                                <!-- Start Blok-->
                                                <div class="col-sm-12">
                                                    <div class="myaccount_empty-blok"><a class="fas fa-plus add_button" href="#"></a>
                                                        <p>لا يوجد لديك دورات تدريبيه, <a href="#"> اضف الان</a></p>
                                                    </div>
                                                </div>
                                                <!-- End Blok-->
                                            </div>
                                        </div>
                                    </section>
                                    <!-- End  Packedg Subscrib-->
                                    <!-- Start Packedg Subscrib-->
                                    <section class="pakedge_subscribe">
                                        <h3 class="all_tabs-title"> دورات تدريبية</h3>
                                        <div class="
                      ">
                                            <div class="row">
                                                <!-- Start Blok-->
                                                <div class="col-sm-12">
                                                    <div class="myaccount_empty-blok"><a class="fas fa-plus add_button" href="#"></a>
                                                        <p>لا يوجد لديك دورات تدريبيه, <a href="#"> اضف الان</a></p>
                                                    </div>
                                                </div>
                                                <!-- End Blok-->
                                            </div>
                                        </div>
                                    </section>
                                    <!-- End  Packedg Subscrib-->
                                </div>
                                <!-- End Meeting-->

                                <!-- Start favorite-->
                                <div id="favorite">
                                    <!-- Start Speacial Seation-->
                                    <section class="speacial_section">
                                        <h3 class="all_tabs-title">دورات تدريبيه</h3>
                                        <!-- Start List of Coaches-->
                                        <div class="list_cources-content">
                                            <div class="">
                                                <div class="row">
                                                    <!--Start Block -->
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="coach_block" data-src="img/bg/cources1.png">
                                                            <div class="coach_block-description">
                                                                <h3>Detox Your Mind – التشوهات الفكريه</h3>
                                                                <h6>Life Coaching</h6>
                                                                <h4>Friday, October 19, 2018 , 21:00 PM</h4>
                                                                <h5>ثمن الجلسه فى الساعه االواحدة </h5><span>600 جنية</span>
                                                                <aside class="button_content"><a class="button" href="#">التفاصيل</a><a class="button"
                                                                                                                                        href="#">اشترك
                                                                        الان</a></aside>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--End Block -->
                                                    <!--Start Block -->
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="coach_block" data-src="img/bg/cources1.png">
                                                            <div class="coach_block-description">
                                                                <h3>Detox Your Mind – التشوهات الفكريه</h3>
                                                                <h6>Life Coaching</h6>
                                                                <h4>Friday, October 19, 2018 , 21:00 PM</h4>
                                                                <h5>ثمن الجلسه فى الساعه االواحدة </h5><span>600 جنية</span>
                                                                <aside class="button_content"><a class="button" href="#">التفاصيل</a><a class="button"
                                                                                                                                        href="#">اشترك
                                                                        الان</a></aside>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--End Block -->
                                                    <!--Start Block -->
                                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                                        <div class="coach_block" data-src="img/bg/cources1.png">
                                                            <div class="coach_block-description">
                                                                <h3>Detox Your Mind – التشوهات الفكريه</h3>
                                                                <h6>Life Coaching</h6>
                                                                <h4>Friday, October 19, 2018 , 21:00 PM</h4>
                                                                <h5>ثمن الجلسه فى الساعه االواحدة </h5><span>600 جنية</span>
                                                                <aside class="button_content"><a class="button" href="#">التفاصيل</a><a class="button"
                                                                                                                                        href="#">اشترك
                                                                        الان</a></aside>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--End Block -->
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <!-- End Speacial Seation -->
                                    <!-- Start Speacial Seation -->
                                    <section class="speacial_section ">
                                        <h3 class="all_tabs-title">مقالات
                                            <!-- Satrt Articl Block-->
                                        </h3>
                                    </section>
                                    <div class="articl_block">
                                        <div class="row">
                                            <!--Start Articl Image-->
                                            <div class="col-sm-12 col-lg-6 col-xl-3">
                                                <aside class="article_image" data-src="img/bg/category3.png"></aside>
                                            </div>
                                            <!--End Articl Image -->
                                            <!--Start Article Description -->
                                            <div class="col-sm-12 col-lg-6 col-xl-6">
                                                <div class="article_description">
                                                    <h3 class="article_title"> <a href="#">متي يبدء التخطيط المهني ودور الأسرة والمدرسة فيه</a></h3>
                                                    <p class="paragraph_global">أنسب وقت يبدء فيه الطالب وضع خطة مهنية وهو عنده 15 سنه - تقريبا
                                                        3
                                                        أعدادي أو أولي ثانوي - وده لأن كل قرار ابتداء في المرحلة بيؤثر في تشكيل وتوجيه مسارنا
                                                        المهني
                                                        علي مدار حياتنا. في أوروبا والدور المتقدمة :D عشان #مراكز_التوجيه_المهني في #المدارس
                                                        تساعد
                                                        الطلاب علي أتخاذ قرار مهني بتشجع الطلاب علي تطو...</p>
                                                    <!-- ٍStart Flowers details-->
                                                    <ul class="list_inline flowers_list">
                                                        <li><i class="fas fa-newspaper"></i><span>مقالة</span></li>
                                                        <li><i class="far fa-clock"> </i><span>نشر فى 18 /11 /2019 </span></li>
                                                        <li><i class="fas fa-bars"></i><span>Career Coaching</span></li>
                                                    </ul>
                                                    <!-- End Flowers details       -->
                                                </div>
                                            </div>
                                            <!--End Article Description-->
                                            <!-- Start Articls Subscribtion-->
                                            <div class="col-sm-12 col-xl-3">
                                                <div class="articls_subscription">
                                                    <ul class="favorite_buttons">
                                                        <li><i class="far fa-heart"></i></li>
                                                        <li><i class="far fa-bookmark"> </i></li>
                                                    </ul>
                                                    <div class="articl_writer-content">
                                                        <p>ايه أحمد حجازى</p>
                                                        <aside> <img src="img/bg/consult2.png"></aside>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Articls Subscribtion-->
                                        </div>
                                        <div class="row">
                                            <!--Start Articl Image-->
                                            <div class="col-sm-12 col-lg-6 col-xl-3">
                                                <aside class="article_image" data-src="img/bg/category3.png"></aside>
                                            </div>
                                            <!--End Articl Image -->
                                            <!--Start Article Description -->
                                            <div class="col-sm-12 col-lg-6 col-xl-6">
                                                <div class="article_description">
                                                    <h3 class="article_title"> <a href="#">متي يبدء التخطيط المهني ودور الأسرة والمدرسة فيه</a></h3>
                                                    <p class="paragraph_global">أنسب وقت يبدء فيه الطالب وضع خطة مهنية وهو عنده 15 سنه - تقريبا
                                                        3
                                                        أعدادي أو أولي ثانوي - وده لأن كل قرار ابتداء في المرحلة بيؤثر في تشكيل وتوجيه مسارنا
                                                        المهني
                                                        علي مدار حياتنا. في أوروبا والدور المتقدمة :D عشان #مراكز_التوجيه_المهني في #المدارس
                                                        تساعد
                                                        الطلاب علي أتخاذ قرار مهني بتشجع الطلاب علي تطو...</p>
                                                    <!-- ٍStart Flowers details-->
                                                    <ul class="list_inline flowers_list">
                                                        <li><i class="fas fa-newspaper"></i><span>مقالة</span></li>
                                                        <li><i class="far fa-clock"> </i><span>نشر فى 18 /11 /2019 </span></li>
                                                        <li><i class="fas fa-bars"></i><span>Career Coaching</span></li>
                                                    </ul>
                                                    <!-- End Flowers details       -->
                                                </div>
                                            </div>
                                            <!--End Article Description-->
                                            <!-- Start Articls Subscribtion-->
                                            <div class="col-sm-12 col-xl-3">
                                                <div class="articls_subscription">
                                                    <ul class="favorite_buttons">
                                                        <li><i class="far fa-heart"></i></li>
                                                        <li><i class="far fa-bookmark"> </i></li>
                                                    </ul>
                                                    <div class="articl_writer-content">
                                                        <p>ايه أحمد حجازى</p>
                                                        <aside> <img src="img/bg/consult2.png"></aside>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Articls Subscribtion-->
                                        </div>
                                    </div>
                                    <!-- End  Articl Block -->
                                    <!-- End Speacial Seation                -->
                                </div>
                                <!-- End BookMark-->

                                <!-- End favorite-->
                                <div id="ForgotPassword">
                                    {!! Form::open(['url'=>url()->route('customer_update_password_post')]) !!}
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                <div class="profile_form">
                                                    <h2 class="form_title">{{ trans('main.change_password') }}</h2>
                                                    <div class="glopal_form row">
                                                       <div class="col-sm-12 col-md-4 col-lg-4">
                                                            <label for="old_password">{{ trans('main.old_password') }}</label>
                                                            {!! Form::password('old_password',['placeholder'=>trans('main.old_password'),'id'=>'old_password','required']) !!}
                                                            @if($errors->has('old_password'))
                                                            <span class="text-danger">{{ $errors->first('old_password') }}</span>
                                                            @endif
                                                        </div>

                                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                                            <label for="password">{{ trans('main.password') }}</label>
                                                            {!! Form::password('password',['placeholder'=>trans('main.password'),'id'=>'password','required']) !!}
                                                            @if($errors->has('password'))
                                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                                            @endif
                                                        </div>

                                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                                            <label for="password_confirmation">{{ trans('main.password_confirmation') }}</label>
                                                            {!! Form::password('password_confirmation',['placeholder'=>trans('main.password_confirmation'),'id'=>'password_confirmation','required']) !!}
                                                            @if($errors->has('password_confirmation'))
                                                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                                            @endif
                                                        </div>

                                                        <button class="button" type="submit">{{ trans('main.update') }} </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    {!! Form::close() !!}



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End Single Page -->
@stop
@section('js')
    <script>
        var url = "{{ url()->route('get_country_cities') }}";
        var _token = "{!! csrf_token() !!}";
    </script>
    <script src="{{ asset('public/Frontend/custom/get_cities.js') }}" type="text/javascript"></script>

    <script>
        var map, infoWindow,geocoder;
        function initMap() {
            infoWindow = new google.maps.InfoWindow;
            geocoder = new google.maps.Geocoder;

            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    $("#position").val(position.coords.latitude +','+position.coords.longitude);
                    getLocation(pos);
                }, function() {
                    handleLocationError(true, infoWindow, map.getCenter());
                });
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }
        }

        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                'Error: The Geolocation service failed.' :
                'Error: Your browser doesn\'t support geolocation.');
            infoWindow.open(map);
        }

        function getLocation(location) {
            geocoder.geocode({'location': location}, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        $("#address").val(results[0].formatted_address);
                    } else {
                        window.console.log('No results found');
                    }
                } else {
                    window.console.log('Geocoder failed due to: ' + status);
                }
            });
        }
    </script>

    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCrBse-5RbQCnVPcez1IadNvKUkNQwgudE&callback=initMap">
    </script>

    <script src="{{ asset('public/Frontend/js/my-account.js') }}"></script>
@stop