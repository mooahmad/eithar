@extends(ADL.'.master')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div id="dataTable-buttons" class="tools"></div>
                    {{--<div class="col-12">--}}
                        {{--<form method="POST" id="search-form" class="form-inline" role="form">--}}
                            {{--<div class="input-group input-large date-picker input-daterange" data-date-format="yyyy-mm-dd">--}}
                                {{--<input type="text" class="form-control" name="from_date" placeholder="From Date" id="from_date" required>--}}
                                {{--<span class="input-group-addon"> to </span>--}}
                                {{--<input type="text" class="form-control" name="to_date" placeholder="To Date" id="to_date">--}}
                            {{--</div>--}}
                            {{--<button type="submit" class="btn btn-primary">Search</button>--}}
                            {{--<span class="help-block"> Filter By Date </span>--}}
                        {{--</form>--}}
                    {{--</div>--}}
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
                                    <th>{{ trans('admin.full_name') }}</th>
                                    <th>{{ trans('admin.full_name') }}</th>
                                    <th>{{ trans('admin.national_id') }}</th>
                                    <th>{{ trans('admin.eithar_id') }}</th>
                                    <th>{{ trans('admin.mobile') }}</th>
                                    <th>{{ trans('admin.price') }}</th>
                                    <th>{{ trans('admin.status') }}</th>
                                    <th>{{ trans('admin.unlock_request') }}</th>
                                    <th>{{ trans('admin.submitted_at') }}</th>
                                    <th>{{ trans('admin.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>{{ trans('admin.id') }}</th>
                                    <th>{{ trans('admin.service_name') }}</th>
                                    <th>{{ trans('admin.full_name') }}</th>
                                    <th>{{ trans('admin.full_name') }}</th>
                                    <th>{{ trans('admin.full_name') }}</th>
                                    <th>{{ trans('admin.national_id') }}</th>
                                    <th>{{ trans('admin.eithar_id') }}</th>
                                    <th>{{ trans('admin.mobile') }}</th>
                                    <th>{{ trans('admin.price') }}</th>
                                    <th>{{ trans('admin.status') }}</th>
                                    <th>{{ trans('admin.unlock_request') }}</th>
                                    <th>{{ trans('admin.submitted_at') }}</th>
                                    <th>{{ trans('admin.actions') }}</th>
                                </tr>
                            </tfoot>
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
    </script>
    <script src="{{ asset('public/js/custom/meetingsDataTable.js') }}"></script>
@stop