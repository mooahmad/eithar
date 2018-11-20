@extends(FEL.'.master')

@section('content')
    <!--=02= Start Header Slider-->
    @include(FE.'.layouts.top_header')

    <!-- Start Single Page -->
    <div class="registration_content">
        <!--=03=Start Popup Sign In -->
        <div class="container">
            <!-- The Modal -->
            <div class="" id="sign_up">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <!-- Modal body -->
                        <div class="modal-body">
                            <h2 class="title">{{ trans('main.register_now') }}</h2>
                            @if(Session::has('error_login'))
                                <div class="alert alert-danger">
                                    <button class="close" data-close="alert"></button>
                                    <span>{{ session()->get('error_login') }}</span>
                                </div>
                            @endif
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
                            <!-- Start Form content-->
                            {!! Form::open(['url'=>url()->route('customer_sign_up_post'),'class'=>'glopal_form']) !!}
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <input value="" placeholder=" الاسم الاول">
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <input value="" placeholder="الاسم الثانى">
                                    </div>
                                    <div class="col-sm-12 col-md-12 ">
                                        <input value="" placeholder="الاسم الاخير ">
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <input value="" placeholder="البريد الإلكترونى">
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="custum_select">
                                            <select class="" name="">
                                                <option value=""> النوع </option>
                                                <option value=""> ذكر </option>
                                                <option value=""> أنثى </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="phone_number ">
                                            <aside class="phone_number-key"> <bdi> +966 </bdi> </aside>
                                            <input value="" type="text" placeholder="رقم الجوال">
                                        </div>

                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <input value="" type="text" placeholder="رقم الهوية">
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <input type="file" name="filename2">
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="phone_number ">
                                            <aside class="phone_number-key"> <span> المملكة العربية السعودية </span> </aside>
                                            <div class="custum_select">
                                                <select class="" name="">
                                                    <option value=""> الرياض </option>
                                                    <option value=""> جدة </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 ">
                                        <textarea name="name" rows="8" cols="80"></textarea>
                                    </div>

                                    <div class="col-sm-12 col-md-12 ">
                                        <input type="file" name="filename2" placeholder="صورة الملف الشخصى">
                                    </div>
                                </div>
                                <!-- End List icon Registration -->
                                <aside class="sign_button-content">
                                    <button class="button" type="submit">{{ trans('main.submit') }}</button>
                                </aside>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--=03=End Popup Sign In -->
    </div>
    <!-- End Single Page -->
@stop