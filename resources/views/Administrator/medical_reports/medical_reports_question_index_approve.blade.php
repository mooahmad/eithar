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
                        <table id="data-table-medical_reports" class="dataTable table table-bordered table-hover"
                               width="100%">
                            <thead>
                            <tr>
                                <th>{{ trans('admin.id') }}</th>
                                <th>{{ trans('admin.title_ar') }}</th>
                                <th>{{ trans('admin.title_en') }}</th>
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
    // declaring used variables
    <script>
        var medicalReportsQuestionsDataTableURL = "{!! route('getMedicalReportsApproveQuestionsDataTable', ['id' => $medicalReportId]) !!}";
        var deleteMedicalReportsQuestionsURL    = "{!! route('deleteMedicalReportsApproveQuestions') !!}";
        var csrfToken          = "{!! csrf_token() !!}";
    </script>
    <script src="{{ asset('public/js/custom/medicalReportsQuestionsAnswersDataTable.js') }}" type="text/javascript"></script>
@stop