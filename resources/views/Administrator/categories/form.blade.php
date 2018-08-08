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
                                    <span class="caption-subject font-blue-madison bold uppercase">Category</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- Create New User TAB -->
                                    <div class="tab-pane active" id="new_user">
                                        {!! Form::open(['method'=>(isset($category))? 'PUT' : 'POST','url'=> $formRoute, 'role'=>'form', 'files' => true]) !!}

                                        <div class="form-group">
                                            <label for="default_language" class="control-label">
                                                {{ trans('admin.parent_cat') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::select('parent_cat', $categories, (isset($category))? $category->category_parent_id : old('parent_cat'), array('id'=>'parent_cat', 'class'=>'form-control','required'=>'required')) !!}
                                            @if($errors->has('parent_cat'))
                                                <span class="help-block text-danger">{{ $errors->first('parent_cat') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.name_ar') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('name_ar', (isset($category))? $category->category_name_ar : old('name_ar') , array('id'=>'name_ar', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.name_ar'))) !!}
                                            @if($errors->has('name_ar'))
                                                <span class="help-block text-danger">{{ $errors->first('name_ar') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.name_en') }} <span class="required"> * </span>
                                            </label>
                                            {!! Form::text('name_en', (isset($category))? $category->category_name_en : old('name_en') , array('id'=>'name_en', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.name_en'))) !!}
                                            @if($errors->has('name_en'))
                                                <span class="help-block text-danger">{{ $errors->first('name_en') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.desc_ar') }}
                                            </label>
                                            {!! Form::textarea('desc_ar', (isset($category))? $category->description_ar : old('desc_ar'), array('id'=>'desc_ar', 'class'=>'form-control','rows' => 2)) !!}
                                            @if($errors->has('desc_ar'))
                                                <span class="help-block text-danger">{{ $errors->first('desc_ar') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">
                                                {{ trans('admin.desc_en') }}
                                            </label>
                                            {!! Form::textarea('desc_en', (isset($category))? $category->description_en : old('desc_en'), array('id'=>'desc_en', 'class'=>'form-control','rows' => 2)) !!}
                                            @if($errors->has('desc_en'))
                                                <span class="help-block text-danger">{{ $errors->first('desc_en') }}</span>
                                            @endif
                                        </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-xs-3">
                                                        <label class="control-label">
                                                            {{ trans('admin.select_avatar') }}
                                                        </label>
                                                        <div>
                                                            <div class="fileinput fileinput-new"
                                                                 data-provides="fileinput">
                                                            <span class="btn green btn-file">
                                                                <span class="fileinput-new"> Select file </span>
                                                                <span class="fileinput-exists"> Change </span>
                                                                <input type="file" name="avatar"> </span>
                                                                <span class="fileinput-filename"> </span> &nbsp;
                                                                <a href="javascript:;" class="close fileinput-exists"
                                                                   data-dismiss="fileinput"> </a>
                                                            </div>
                                                        </div>
                                                        @if($errors->has('avatar'))
                                                            <span class="help-block text-danger">{{ $errors->first('avatar') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="col-xs-2">
                                                        @if(!empty($category))

                                                        @if(!empty($category->profile_picture_path))
                                                            <img src="{{ $category->profile_picture_path }}"
                                                                 class="img-thumbnail" style="max-height: 120px">
                                                        @endif
                                                        @endif

                                                    </div>
                                                </div>
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
    <script src="{{ asset('public/assets/pages/scripts/profile.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}"
            type="text/javascript"></script>
@stop