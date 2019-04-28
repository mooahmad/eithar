@extends(ADL.'.master')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="btn-group">

                    </div>
                    <div id="dataTable-buttons" class="tools">

                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table id="data-table-joinus" class="dataTable table table-bordered table-hover"
                               width="100%">
                            <thead>
                            <tr>
                                <th>{{ trans('admin.id') }}</th>
                                <th>{{ trans('admin.name') }}</th>
                                <th>{{ trans('admin.email') }}</th>
                                <th>Mobile</th>
                                <th>National ID</th>
                                <th>Specialty</th>
                                <th>Country</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    @include('Administrator.widgets.deleteModal', ['message' => 'are you sure you want to delete?'])
@stop

@section('script')
    <script>
        var joinusDataTableURL = "{!! route('getJoinusDataTable') !!}";
        var csrfToken          = "{!! csrf_token() !!}";
    </script>
    <script src="{{ asset('public/js/custom/joinusDataTable.js') }}" type="text/javascript"></script>
@stop