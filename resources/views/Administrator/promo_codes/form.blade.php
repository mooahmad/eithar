@extends(ADL.'.master')

@section('style')
    <link href="{{ asset('public/assets/pages/css/profile.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}"
          rel="stylesheet" type="text/css"/>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">

            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light ">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">Promo Code</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- Create New User TAB -->
                                    <div class="tab-pane active" id="new_user">
                                        {!! Form::open(['method'=>'POST','url'=> $formRoute, 'role'=>'form', 'files' => true]) !!}

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.name_ar') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('name_ar', (isset($promoCode))? $promoCode->name_ar : old('name_ar') , array('id'=>'name_ar', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.name_ar'))) !!}
                                            @if($errors->has('name_ar'))
                                                <span class="help-block text-danger">{{ $errors->first('name_ar') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.name_en') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('name_en', (isset($promoCode))? $promoCode->name_en : old('name_en') , array('id'=>'name_en', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.name_en'))) !!}
                                            @if($errors->has('name_en'))
                                                <span class="help-block text-danger">{{ $errors->first('name_en') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.desc_ar') }}
                                            </label>
                                            {!! Form::textarea('desc_ar', (isset($promoCode))? $promoCode->description_ar : old('desc_ar'), array('id'=>'desc_ar', 'class'=>'form-control','rows' => 2)) !!}
                                            @if($errors->has('desc_ar'))
                                                <span class="help-block text-danger">{{ $errors->first('desc_ar') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.desc_en') }}
                                            </label>
                                            {!! Form::textarea('desc_en', (isset($promoCode))? $promoCode->description_en : old('desc_en'), array('id'=>'desc_en', 'class'=>'form-control','rows' => 2)) !!}
                                            @if($errors->has('desc_en'))
                                                <span class="help-block text-danger">{{ $errors->first('desc_en') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ trans('admin.start_date') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('start_date', (isset($promoCode))? $promoCode->start_date : old('start_date'), array('id'=>'start_date', 'class'=>'form-control form-control-inline input-medium date_time_picker','required'=>'required', 'size' => 16, 'type' => 'text')) !!}
                                            @if($errors->has('start_date'))
                                                <span class="help-block text-danger">{{ $errors->first('start_date') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ trans('admin.end_date') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('end_date', (isset($promoCode))? $promoCode->end_date : old('end_date'), array('id'=>'end_date', 'class'=>'form-control form-control-inline input-medium date_time_picker','required'=>'required', 'size' => 16, 'type' => 'text')) !!}
                                            @if($errors->has('end_date'))
                                                <span class="help-block text-danger">{{ $errors->first('end_date') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="default_language" class="control-label">
                                                {{ trans('admin.type') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::select('type', $types, (isset($promoCode))? $promoCode->type : old('type'), array('id'=>'type', 'class'=>'form-control','required'=>'required')) !!}
                                            @if($errors->has('type'))
                                                <span class="help-block text-danger">{{ $errors->first('type') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.type_desc') }}
                                            </label>
                                            {!! Form::textarea('type_desc', (isset($promoCode))? $promoCode->type_desc : old('type_desc'), array('id'=>'type_desc', 'class'=>'form-control','rows' => 2)) !!}
                                            @if($errors->has('type_desc'))
                                                <span class="help-block text-danger">{{ $errors->first('type_desc') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.code_ar') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('code_ar', (isset($promoCode))? $promoCode->code_ar : old('code_ar') , array('id'=>'code_ar', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.code_ar'))) !!}
                                            @if($errors->has('code_ar'))
                                                <span class="help-block text-danger">{{ $errors->first('code_ar') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.code_en') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('code_en', (isset($promoCode))? $promoCode->code_en : old('code_en') , array('id'=>'code_en', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.code_en'))) !!}
                                            @if($errors->has('code_en'))
                                                <span class="help-block text-danger">{{ $errors->first('code_en') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.discount_percentage') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::number('discount_percentage', (isset($service))? $service->discount_percentage : old('discount_percentage') , array('id'=>'discount_percentage', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.discount_percentage' ), 'min'=> 0, 'max'=> 100)) !!}
                                            @if($errors->has('discount_percentage'))
                                                <span class="help-block text-danger">{{ $errors->first('discount_percentage') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.comment') }}
                                            </label>
                                            {!! Form::textarea('comment', (isset($promoCode))? $promoCode->comment : old('comment'), array('id'=>'comment', 'class'=>'form-control','rows' => 2)) !!}
                                            @if($errors->has('comment'))
                                                <span class="help-block text-danger">{{ $errors->first('comment') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="on"
                                                   class="control-label">{{ trans('admin.is_approved') }} </label>
                                            @php
                                                $is_approved = null;
                                                if(isset($promoCode)){
                                                $is_approved = $promoCode->is_approved;
                                                }
                                            @endphp
                                            <div class="mt-radio-inline">
                                                <label class="mt-radio">
                                                    {!! Form::radio('is_approved', 1, ($is_approved === 1 || empty($is_approved))? 'true' : '',array('id'=>'yes-approved')) !!}
                                                    {{ trans('admin.yes') }}
                                                    <span></span>
                                                </label>
                                                <label class="mt-radio">
                                                    {!! Form::radio('is_approved', 0, ($is_approved === 0 )? 'true' : '',array('id'=>'no-approved')) !!}
                                                    {{ trans('admin.no') }}
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="margiv-top-10">
                                            {!! Form::submit($submitBtn, array('class'=>'btn green')) !!}
                                            <a href="{{ url(AD.'/promo_codes') }}"
                                               class="btn red">{{ trans('admin.cancel') }}</a>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                    <!-- END Create New User TAB -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>
@stop

@section('script')
    <script src="{{ asset('public/assets/pages/scripts/profile.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}"
            type="text/javascript"></script>
@stop