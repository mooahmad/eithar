@extends(ADL.'.master')
@section('content')

<script type="text/javascript">
  $(document).ready(function(){
    $(".change_password_link").click(function(){
      $(".change_password_div").hide();
      $("#password").attr("required","required");
      $("#password_confirmation").attr("required","required");
      $(".change_password").removeClass('hidden');
    });
  });
</script>

@if($errors->has('password') || $errors->has('password_confirmation'))
<script type="text/javascript">
  $(document).ready(function(){
    $(".change_password_div").hide();
    $(".change_password").removeClass('hidden');
  });
</script>
@endif

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet light portlet-fit portlet-form bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase">{{ Route::currentRouteName() }}</span>
                </div>
            </div>
            <div class="portlet-body">
                <!-- BEGIN FORM-->
                @if(!empty($form_data))
			        {!! Form::model($form_data,['method'=>'PATCH','url'=>'/Administrator/admins/'.$form_data->id, 'id'=>'form_sample_3', 'class'=>'form-horizontal']) !!}
			        @else
			          {!! Form::open(['method'=>'POST','id'=>'form_sample_3','route'=>'admins.store', 'class'=>'form-horizontal']) !!}
			    @endif

                    <div class="form-body">        
                        <div class="form-group">
                        	<label for="name" class="col-md-3 control-label">
                        		{{ trans('admin.name') }} <span class="required"> * </span>
                            </label>

                            <div class="col-md-6">
                            	<div class="input-group">
                            		<span class="input-group-addon">
	                                    <i class="fa fa-user"></i>
	                                </span>
					            	{!! Form::text('name',old('name'), array('id'=>'name', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.name'))) !!}
                            	</div>
                            	@if($errors->has('name'))
						          <span class="help-block text-danger">{{ $errors->first('name') }}</span>
						        @endif
					        </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-3 control-label">
                            	{{ trans('admin.email') }} <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                    {!! Form::text('email',old('email'), array('id'=>'email', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.email'))) !!}
                                </div>
                                @if($errors->has('email'))
						          <span class="help-block text-danger">{{ $errors->first('email') }}</span>
						        @endif
                            </div>
                        </div>

                        @if(!empty($form_data)) 
						    <div class="form-group change_password_div">
						        <label  class="col-md-3 control-label">{{trans('admin.change_password')}}
						        </label>
						        <div class="col-md-6">
						          <a class="btn btn-primary change_password_link" >{{trans('admin.change_password')}}</a>
						        </div>
						    </div>
					      	<div class="form-group hidden change_password">
	                            <label for="password" class="col-md-3 control-label">
	                            	{{ trans('admin.password') }} <span class="required"> * </span>
	                            </label>
	                            <div class="col-md-6">
	                                <div class="input-group">
	                                    <span class="input-group-addon">
	                                        <i class="fa fa-lock"></i>
	                                    </span>
	                                    {!! Form::password('password', array('id'=>'password', 'class'=>'form-control','placeholder'=>trans('admin.password'))) !!}
	                                </div>
	                                @if($errors->has('password'))
							          <span class="help-block text-danger">{{ $errors->first('password') }}</span>
							        @endif
	                            </div>
	                        </div>
	                        <div class="form-group hidden change_password">
	                            <label for="password_confirmation" class="col-md-3 control-label">
	                            	{{ trans('admin.password_confirmation') }} <span class="required"> * </span>
	                            </label>
	                            <div class="col-md-6">
	                                <div class="input-group">
	                                    <span class="input-group-addon">
	                                        <i class="fa fa-lock"></i>
	                                    </span>
	                                    {!! Form::password('password_confirmation', array('id'=>'password_confirmation', 'class'=>'form-control','placeholder'=>trans('admin.password_confirmation'))) !!}
	                                </div>
	                                @if($errors->has('password_confirmation'))
							          <span class="help-block text-danger">{{ $errors->first('password_confirmation') }}</span>
							        @endif
	                            </div>
	                        </div>
					      @else
						    <div class="form-group">
	                            <label for="password" class="col-md-3 control-label">
	                            	{{ trans('admin.password') }} <span class="required"> * </span>
	                            </label>
	                            <div class="col-md-6">
	                                <div class="input-group">
	                                    <span class="input-group-addon">
	                                        <i class="fa fa-lock"></i>
	                                    </span>
	                                    {!! Form::password('password', array('id'=>'password', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.password'))) !!}
	                                </div>
	                                @if($errors->has('password'))
							          <span class="help-block text-danger">{{ $errors->first('password') }}</span>
							        @endif
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <label for="password_confirmation" class="col-md-3 control-label">
	                            	{{ trans('admin.password_confirmation') }} <span class="required"> * </span>
	                            </label>
	                            <div class="col-md-6">
	                                <div class="input-group">
	                                    <span class="input-group-addon">
	                                        <i class="fa fa-lock"></i>
	                                    </span>
	                                    {!! Form::password('password_confirmation', array('id'=>'password_confirmation', 'class'=>'form-control','required'=>'required','placeholder'=>trans('admin.password_confirmation'))) !!}
	                                </div>
	                                @if($errors->has('password_confirmation'))
							          <span class="help-block text-danger">{{ $errors->first('password_confirmation') }}</span>
							        @endif
	                            </div>
	                        </div>
					    @endif

                        @if(!empty($form_data) && auth()->user()->id != $form_data->id)
					      <div class="form-group">
					        {!! Form::label('status_admin', trans('admin.status'), array('class'=>'control-label col-md-3')) !!}
					        <div class="col-md-6">
					            <div class="mt-radio-inline">
					              <label class="mt-radio">
					                {!! Form::radio('status', '1','true',array('class'=>'input_status_admin')) !!}
					                {{ trans('admin.on') }}
					                <span></span>
					              </label>
					              <label class="mt-radio">
					                {!! Form::radio('status', '0','',array('class'=>'input_status_admin')) !!}
					                {{ trans('admin.off') }}
					                <span></span>
					              </label>
					            </div>
					            @if($errors->has('status'))
						          <span class="help-block text-danger">{{ $errors->first('status') }}</span>
						        @endif
					        </div>
					      </div>
					      @elseif($type==='add')
					      <div class="form-group">
					        {!! Form::label('status_admin', trans('admin.status'), array('class'=>'control-label col-md-3')) !!}
					        <div class="col-md-6">
					            <div class="mt-radio-inline">
					              <label class="mt-radio">
					                {!! Form::radio('status', '1','true',array('class'=>'input_status_admin')) !!}
					                {{ trans('admin.on') }}
					                <span></span>
					              </label>
					              <label class="mt-radio">
					                {!! Form::radio('status', '0','',array('class'=>'input_status_admin')) !!}
					                {{ trans('admin.off') }}
					                <span></span>
					              </label>
					            </div>
					            @if($errors->has('status'))
						          <span class="help-block text-danger">{{ $errors->first('status') }}</span>
						        @endif
					        </div>
					      </div>
					    @endif

                        <!-- <div class="form-group">
                            <label class="control-label col-md-3">Services
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <div class="mt-checkbox-inline" data-error-container="#form_2_services_error">
                                    <label class="mt-checkbox">
                                        <input type="checkbox" value="1" name="service" /> Service 1
                                        <span></span>
                                    </label>
                                    <label class="mt-checkbox">
                                        <input type="checkbox" value="2" name="service" /> Service 2
                                        <span></span>
                                    </label>
                                    <label class="mt-checkbox">
                                        <input type="checkbox" value="3" name="service" /> Service 3
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                            	{!! Form::submit($submit_button, array('class'=>'btn green')) !!}
								<a href="{{ url(AD.'/admins') }}" class="btn red">{{ trans('admin.cancel') }}</a>
							</div>
                        </div>
                    </div>
                {!! Form::close() !!}
                <!-- END FORM-->
            </div>
            <!-- END VALIDATION STATES-->
        </div>
    </div>
</div>

@stop