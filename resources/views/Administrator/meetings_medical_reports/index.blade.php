@extends(ADL.'.master')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="btn-group">
                        <a href="{{ url(AD.'/medical_reports/create') }}" class="btn sbold green"> Add New <i
                                    class="fa fa-plus"></i></a>
                    </div>
                    <div id="dataTable-buttons" class="tools">

                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table id="data-table-medical-reports" class="dataTable table table-bordered table-hover"
                               width="100%">
                            <thead>
                            <tr>
                                <th>{{ trans('admin.id') }}</th>
                                <th>{{ trans('admin.is_approved') }}</th>
                                <th>{{ trans('admin.see_by_customer') }}</th>
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
    @include('Administrator.widgets.deleteModal', ['message' => 'are you sure you want to delete?'])
@stop

@section('script')
    <script>
        var medicalReportsDataTableURL = "{!! route('getMeetingsMedicalReportsDataTable', [ "id" => $meetingId]) !!}";
        var deletemedicalReportsURL    = "{!! route('deleteMeetingsMedicalReports') !!}";
        var csrfToken          = "{!! csrf_token() !!}";
    </script>
    <script src="{{ asset('public/js/custom/meetingsMedicalReportsDataTable.js') }}" type="text/javascript"></script>
@stop