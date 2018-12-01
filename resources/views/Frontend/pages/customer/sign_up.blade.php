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
                            {!! Form::open(['files' => true,'url'=>url()->route('customer_sign_up_post'),'class'=>'glopal_form']) !!}
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        {!! Form::text('first_name',old('first_name'),['placeholder'=>trans('main.first_name'),'required']) !!}
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        {!! Form::text('middle_name',old('middle_name'),['placeholder'=>trans('main.middle_name'),'required']) !!}
                                    </div>
                                    <div class="col-sm-12 col-md-12 ">
                                        {!! Form::text('last_name',old('last_name'),['placeholder'=>trans('main.last_name'),'required']) !!}
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        {!! Form::text('email',old('email'),['placeholder'=>trans('main.email'),'required']) !!}
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="custum_select">
                                            {!! Form::select('gender',$gender,old('gender'),['placeholder'=>trans('main.gender'),'required']) !!}
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="phone_number ">
                                            <aside class="phone_number-key"> <bdi> +966 </bdi> </aside>
                                            {!! Form::text('mobile_number',old('mobile_number'),['placeholder'=>trans('main.mobile_number'),'required']) !!}
                                        </div>

                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        {!! Form::text('national_id',old('national_id'),['placeholder'=>trans('main.national_id'),'required']) !!}
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="phone_number">
                                            <aside class="phone_number-key">{{ trans('main.nationality_id_picture') }}</aside>
                                            {!! Form::file('nationality_id_picture',old('nationality_id_picture'),['placeholder'=>trans('main.nationality_id_picture'),'required']) !!}
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="phone_number ">
                                            <div class="custum_select">
                                                {!! Form::select('country_id',$countries,old('country_id'),['id'=>'country_id','required','onchange'=>'changeCountry(this);']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="phone_number ">
                                            <div class="custum_select">
                                                {!! Form::select('city_id',$cities,old('city_id'),['id'=>'city_id','placeholder'=>trans('main.city'),'required']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        {!! Form::text('address',old('address'),['placeholder'=>trans('main.address'),'required']) !!}
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        {!! Form::text('position',old('position'),['placeholder'=>trans('main.position'),'required']) !!}
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="phone_number">
                                            <aside class="phone_number-key">{{ trans('main.profile_picture') }}</aside>
                                            {!! Form::file('profile_picture_path',old('profile_picture_path'),['placeholder'=>trans('main.profile_picture'),'required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        {!! Form::textarea('about',old('about'),['cols'=>80,'rows'=>8,'placeholder'=>trans('main.about')]) !!}
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

@section('js')
    <script>
        function changeCountry(event) {
            var country_id = $(event).val();
            $.ajax({
                url: "{{ url()->route('get_country_cities') }}",
                type: "post",
                data:{country_id:country_id,_token:"{!! csrf_token() !!}"},
                success: function (data) {
                    if (data.result){
                        $('#city_id').empty();
                        $('#city_id').html(data.list);
                    }
                },
                error: function (data) {
                    alert('something went wrong.');
                }
            });
        }

        $(function() {
            changeCountry($("#country_id"));
        });
    </script>
@stop