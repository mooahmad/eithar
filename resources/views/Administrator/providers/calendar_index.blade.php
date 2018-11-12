@extends(ADL.'.master')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="btn-group">
                        <a href="{{ url(AD.'/providers/'.$providerID.'/calendar/create') }}" class="btn sbold green">
                            Add New <i
                                    class="fa fa-plus"></i></a>
                    </div>
                    <div id="dataTable-buttons" class="tools">

                    </div>
                </div>
                <div class="form-group">
                    <label for="default_language" class="control-label">
                        {{ trans('admin.date_section') }}
                    </label>
                    {!! Form::select('date_section', $calendarSections, 0, array('id'=>'date_section', 'class'=>'form-control')) !!}
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table id="data-table-calendar" class="dataTable table table-bordered table-hover"
                               width="100%">
                            <thead>
                            <tr>
                                <th>{{ trans('admin.id') }}</th>
                                <th>{{ trans('admin.start_date') }}</th>
                                <th>{{ trans('admin.end_date') }}</th>
                                <th>{{ trans('admin.is_available') }}</th>
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
        var calendarDataTableURL = "{!! route('getCalendarDatatable', ['id' => $providerID]) !!}";
        var deleteCalendarURL = "{!! route('deleteCalendar') !!}";
        var csrfToken = "{!! csrf_token() !!}";
    </script>
    <script src="{{ asset('public/js/custom/calendarDataTable.js') }}" type="text/javascript"></script>
@stop