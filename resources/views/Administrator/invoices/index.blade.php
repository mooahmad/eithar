@extends(ADL.'.master')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div id="dataTable-buttons" class="tools"></div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table id="data-table-invoices" class="table table-bordered table-hover"
                               width="100%">
                            <thead>
                                <tr>
                                    <th>{{ trans('admin.id') }}</th>
                                    <th>{{ trans('admin.full_name') }}</th>
                                    <th>{{ trans('admin.national_id') }}</th>
                                    <th>{{ trans('admin.eithar_id') }}</th>
                                    <th>{{ trans('admin.invoice_code') }}</th>
                                    <th>{{ trans('admin.mobile') }}</th>
                                    <th>{{ trans('admin.amount_original') }}</th>
                                    <th>{{ trans('admin.amount_after_discount') }}</th>
                                    <th>{{ trans('admin.amount_after_vat') }}</th>
                                    <th>{{ trans('admin.amount_final') }}</th>
                                    <th>{{ trans('admin.is_paid') }}</th>
                                    <th>{{ trans('admin.invoice_date') }}</th>
                                    <th>{{ trans('admin.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{ trans('admin.id') }}</th>
                                <th>{{ trans('admin.full_name') }}</th>
                                <th>{{ trans('admin.national_id') }}</th>
                                <th>{{ trans('admin.eithar_id') }}</th>
                                <th>{{ trans('admin.invoice_code') }}</th>
                                <th>{{ trans('admin.mobile') }}</th>
                                <th>{{ trans('admin.amount_original') }}</th>
                                <th>{{ trans('admin.amount_after_discount') }}</th>
                                <th>{{ trans('admin.amount_after_vat') }}</th>
                                <th>{{ trans('admin.amount_final') }}</th>
                                <th>{{ trans('admin.is_paid') }}</th>
                                <th>{{ trans('admin.invoice_date') }}</th>
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
        var indexURL = "{!! route('get-invoices-Datatable') !!}";
        var csrfToken          = "{!! csrf_token() !!}";
    </script>
    <script src="{{ asset('public/js/custom/invoicesDataTable.js') }}"></script>
@stop