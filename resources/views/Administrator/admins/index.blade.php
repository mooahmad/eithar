@extends(ADL.'.master')
@section('content')

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <!-- <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">Buttons &nbsp;</span>
                </div> -->
                <div class="btn-group">
                    <a href="{{ url(AD.'/admins/create') }}" class="btn sbold green"> Add New <i class="fa fa-plus"></i></a>
                </div>
                <div class="tools"> </div>
            </div>
            <div class="portlet-body">
            	@if(!empty($all) && count($all)>0)
	                <table class="table table-striped table-bordered table-hover" id="sample_1">
	                    <thead>
	                    	<tr>
					            <th>
					            	<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
		                                    <input type="checkbox" name="check_all" id="check_all" class="checkboxes"/>
		                                    <span></span>Select All &nbsp;
		                            </label>

					              	<button type="button" class="btn btn-danger delete_all_selected" data-toggle="modal" data-target="#myModalSelected" id="delete_all_selected" disabled="disabled">Delete All Selected</button>
					            </th>
				          	</tr>
	                        <tr>
	                            <th>ID</th>
					          	<th>{{ trans('admin.name') }}</th>
					          	<th>{{ trans('admin.email') }}</th>
					          	<th>{{ trans('admin.status') }}</th>
					          	<th>{{ trans('admin.action') }}</th>
	                        </tr>
	                    </thead>
	                    <tfoot>
                            <tr>
	                            <th>ID</th>
					          	<th>{{ trans('admin.name') }}</th>
					          	<th>{{ trans('admin.email') }}</th>
					          	<th>{{ trans('admin.status') }}</th>
					          	<th>{{ trans('admin.action') }}</th>
	                        </tr>
	                    </tfoot>
	                    <tbody>
	                        @foreach($all as $admin)
						        <tr id="user_{{ $admin->id }}" @if($admin->status == 0)class="danger" @endif>
						            <td>
						            	<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
		                                    <input type="checkbox" name="perm[]" class="All_Checkbox checkboxes" value="{{ $admin->id }}" />
		                                    <span></span>{{ $admin->id }}
		                                </label>
						            </td>
						            <td>{{ $admin->name }}</td>
						            <td>{{ $admin->email }}</td>
						            <td>
						                @if($admin->is_active == 1)
						                	<span class="label label-sm label-success label-mini">{{ trans('admin.on') }}</span>
						                  @else
						                  <span class="label label-sm label-danger label-mini">{{ trans('admin.off') }}</span>
						                @endif
						            </td>
						              
						            <td>
						            	<a href="{{url('Administrator/admins/'.$admin->id.'/edit')}}" class="btn btn-outline btn-circle btn-sm purple">
                                        	<i class="fa fa-edit"></i>
                                        </a>

                                        <!-- <a href="{{url('Administrator/admins/'.$admin->id)}}" class="btn btn-outline btn-circle dark btn-sm black">
                                        	<i class="fa fa-share"></i> {{ trans('admin.view') }}
                                        </a> -->

						                
						                {{--@if(auth()->user()->id != $admin->id)--}}
						                	{{--<button type="button" class="btn btn-outline btn-circle red btn-sm black delete_button" data-id="{{ $admin->id }}" data-toggle="modal" data-target="#myModal"><i class="fa fa-trash-o"></i></button>--}}
						                {{--@endif--}}
						            </td>
						        </tr>
					        @endforeach
	                    </tbody>
	                </table>
                @else
			    	<p class="text-warning">{{ trans('admin.empty_data') }}</p>
			    @endif
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
@stop