<!-- Modal to delete single item -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{trans('admin.confirm_delete')}}</h4>
            </div>
            <div class="modal-body">
                {{ Form::open(['route' => [$route, '1'],'method'=>'DELETE','role'=>'form', 'class'=>'form-horizontal', 'id'=>'Delete_form']) }}
                {!! Form::submit(trans('admin.delete'), array('class'=>'btn btn-danger')) !!}
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{trans('admin.cancel')}}</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>