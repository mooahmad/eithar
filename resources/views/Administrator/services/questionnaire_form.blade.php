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
                                    <span class="caption-subject font-blue-madison bold uppercase">Questionnaire</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- Create New User TAB -->
                                    <div class="tab-pane active" id="new_user">
                                        {!! Form::open(['method'=>'POST','url'=> $formRoute, 'role'=>'form', 'files' => true]) !!}
                                        <input name="id" type="hidden" value="{{ isset($questionnaire)? $questionnaire->id: '' }}">
                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.title_ar') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('title_ar', (isset($questionnaire))? $questionnaire->title_ar : old('title_ar') , array('id'=>'title_ar', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.title_ar'))) !!}
                                            @if($errors->has('title_ar'))
                                                <span class="help-block text-danger">{{ $errors->first('title_ar') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.title_en') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('title_en', (isset($questionnaire))? $questionnaire->title_en : old('title_en') , array('id'=>'title_en', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.title_en'))) !!}
                                            @if($errors->has('title_en'))
                                                <span class="help-block text-danger">{{ $errors->first('title_en') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.subtitle_ar') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('subtitle_ar', (isset($questionnaire))? $questionnaire->subtitle_ar : old('subtitle_ar') , array('id'=>'subtitle_ar', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.subtitle_ar'))) !!}
                                            @if($errors->has('subtitle_ar'))
                                                <span class="help-block text-danger">{{ $errors->first('subtitle_ar') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.subtitle_en') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('subtitle_en', (isset($questionnaire))? $questionnaire->subtitle_en : old('subtitle_en') , array('id'=>'subtitle_en', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.subtitle_en'))) !!}
                                            @if($errors->has('subtitle_en'))
                                                <span class="help-block text-danger">{{ $errors->first('subtitle_en') }}</span>
                                            @endif
                                        </div>
                                        <div id="app">

                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.type_description') }}
                                            </label>
                                            {!! Form::textarea('type_description', (isset($questionnaire))? $questionnaire->type_description : old('type_description'), array('id'=>'type_description', 'class'=>'form-control','rows' => 2)) !!}
                                            @if($errors->has('type_description'))
                                                <span class="help-block text-danger">{{ $errors->first('type_description') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="on"
                                                   class="control-label">{{ trans('admin.is_required') }} </label>
                                            @php
                                                $is_required = null;
                                                if(isset($questionnaire)){
                                                $is_required = $questionnaire->is_required;
                                                }
                                            @endphp
                                            <div class="mt-radio-inline">
                                                <label class="mt-radio">
                                                    {!! Form::radio('is_required', 1, ($is_required === 1 || empty($is_required))? 'true' : '',array('id'=>'yes-required')) !!}
                                                    {{ trans('admin.yes') }}
                                                    <span></span>
                                                </label>
                                                <label class="mt-radio">
                                                    {!! Form::radio('is_required', 0, ($is_required === 0 )? 'true' : '',array('id'=>'no-required')) !!}
                                                    {{ trans('admin.no') }}
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="default_language" class="control-label">
                                                {{ trans('admin.page') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::select('page', $pages, (isset($questionnaire))? $questionnaire->pagination : old('page'), array('id'=>'page', 'class'=>'form-control','required'=>'required')) !!}
                                            @if($errors->has('page'))
                                                <span class="help-block text-danger">{{ $errors->first('page') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="default_language" class="control-label">
                                                {{ trans('admin.order_on_page') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::select('order', [], (isset($questionnaire))? $questionnaire->order : old('order'), array('id'=>'order', 'class'=>'form-control', (!isset($questionnaire))? 'required':"")) !!}
                                            @if($errors->has('order'))
                                                <span class="help-block text-danger">{{ $errors->first('order') }}</span>
                                            @endif
                                        </div>
                                        <div class="margiv-top-10">
                                            {!! Form::submit($submitBtn, array('class'=>'btn green')) !!}
                                            <a href="{{ url(AD.'/admins') }}"
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
    <script>
        var unAvailablePages = "{{json_encode($unAvailablePages)}}";
        var serviceId = "{{$serviceId}}";
        var questionnaireCurrentOrder = "{{ (isset($questionnaire))? $questionnaire->order : ''}}";
        var questionnaireCurrentSymbol = "{{ (isset($questionnaire))? $questionnaire->rating_symbol : ''}}";
        var questionnaireCurrentLevels = "{{ (isset($questionnaire))? $questionnaire->rating_levels : ''}}";
    </script>
    <script src="{{ asset('public/assets/pages/scripts/profile.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/js/preprocessor/questionnaire.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/custom/questionnaire.js') }}" type="text/javascript"></script>
@stop