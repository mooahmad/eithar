@extends(ADL.'.master')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div id="dataTable-buttons" class="tools">

                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table id="data-table-meetings" class="table table-bordered table-hover"
                               width="100%">
                            <thead>
                                <tr>
                                    <th>{{ trans('admin.id') }}</th>
                                    <th>{{ trans('admin.service_name') }}</th>
                                    <th>{{ trans('admin.full_name') }}</th>
                                    <th>{{ trans('admin.national_id') }}</th>
                                    <th>{{ trans('admin.price') }}</th>
                                    <th>{{ trans('admin.status') }}</th>
                                    <th>{{ trans('admin.actions') }}</th>
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
@stop

@section('script')
    <script>
        var indexURL = "{!! route('get-meetings-Datatable') !!}";
        var deleteURL    = "{!! route('deleteServices') !!}";
        var csrfToken          = "{!! csrf_token() !!}";
        var meeting_type          = "{{ $meeting_type }}";
    </script>
    <script src="{{ asset('public/js/custom/meetingsDataTable.js') }}"></script>
@stop