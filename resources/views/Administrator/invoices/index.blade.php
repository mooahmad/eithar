@extends(ADL.'.master')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div id="dataTable-buttons" class="tools"></div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>From: </label>
                            <div class="form-group">
                                <div class="input-group date" data-provide="datepicker"  >
                                    <input type="text"  name="from_date" class="form-control"  id="from_date" >
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label>To: </label>
                            <div class="form-group">
                                <div class="input-group date" data-provide="datepicker"  >
                                    <input type="text"  name="to_date" class="form-control"  id="to_date" >
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                             <label>Bills from</label>
                                <select name="bill" id="bill"  class="form-control">
                                    <option value="">All Bills</option>
                                    <option value="provider">Provider</option>
                                    <option value="admin">Assigned by Admin</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Pay Method</label>
                                <select name="pay" id="pay"  class="form-control" required>
                                    <option value="">All</option>
                                    <option value="1">Cash</option>
                                    <option value="2">Credit</option>
                                    <option value="3">Debit Card</option>
                                    <option value="4">Mada</option>
                                </select>
                            </div>
                        </div>

                    </div>


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
    <script src="{{ asset('public/js/custom/invoiceData.js') }}"></script>


@stop