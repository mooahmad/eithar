@extends(ADL.'.master')

@section('style')
    <link href="{{ asset('public/assets/pages/css/invoice.min.css') }}" rel="stylesheet" type="text/css"/>
@stop

@section('content')

    @if(!empty($invoice))
        <div class="invoice">
            <div class="row invoice-logo">
                <div class="col-xs-6 invoice-logo-space">
                    <img src="{{ asset('public/assets/layouts/layout/img/logo.png') }}" class="img-responsive" alt="" /> </div>
                <div class="col-xs-6">
                    <p> ID => {{ $invoice->invoice_code }} <span class="fa fa-calendar"> {{ $invoice->invoice_date->format('l j F Y h:i A') }}</span></p>
                </div>
            </div>
            <hr/>
            <div class="row">
                @if(!empty($invoice->customer))
                    <div class="col-xs-6">
                        <h3>Customer Details:</h3>
                        <ul class="list-unstyled">
                            <li> {{ $invoice->customer->full_name }} </li>
                            <li> {{ $invoice->customer->national_id }} </li>
                            <li> {{ $invoice->customer->mobile_number }} </li>
                            <li> {{ $invoice->customer->email }} </li>
                            <li> {{ $invoice->customer->address }} </li>
                            <li> {{ ($invoice->customer->country) ? $invoice->customer->country->country_name_eng : '' }}  - {{ ($invoice->customer->city) ? $invoice->customer->city->city_name_eng : '' }}</li>
                        </ul>
                    </div>
                @endif

                <div class="col-xs-6 invoice-payment">
                    <h3>Payment Details:</h3>
                    <ul class="list-unstyled">
                        <li>
                            <strong>Amount Original:</strong>{{ $invoice->amount_original }}
                        </li>
                        <li>
                            <strong>Amount After Discount:</strong>{{ $invoice->amount_after_discount }}
                        </li>
                        <li>
                            <strong>Amount After V.A.T:</strong>{{ $invoice->amount_after_vat }}
                        </li>
                        <li>
                            <strong>Amount Final:</strong> {{ $invoice->amount_final }}
                        </li>
                        <li>
                            <strong>Currency:</strong> {{ ($invoice->currency) ? $invoice->currency->name_eng : '' }}
                        </li>
                        @if($invoice->is_paid==1)
                            <li>
                                <strong>Payment Method:</strong> {{ config('constants.payment_methods.'.$invoice->payment_method) }}
                            </li>

                            @if($invoice->payment_method !=1)
                                <li>
                                    <strong>Payment Transaction Number:</strong> {{ $invoice->payment_transaction_number }}
                                </li>
                            @endif
                        @endif
                    </ul>
                </div>
            </div>

            @if(!empty($invoice->items))
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th> # </th>
                                <th> Service/Provider Name </th>
                                <th> Status</th>
                                <th> Created At</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice->items as $item)
                                    <tr>
                                        <td> {{ $item->id }} </td>
                                        <td> {{ $item->item_desc_appear_in_invoice }} </td>
                                        <td>
                                            @if(($item->status == 2))
                                                    <span class="label label-success label-sm"> Approved </span>
                                                @else
                                                    <span class="label label-warning label-sm"> Pending </span>

                                                    {!! Form::open(['method'=>'POST','route'=>['delete-item-to-invoice']]) !!}
                                                        {!! Form::hidden('invoice_item_id',$item->id) !!}
                                                        <button class="btn btn-danger" type="submit">
                                                            <i class="fa fa-close"></i> Delete
                                                        </button>
                                                {!! Form::close() !!}

                                            @endif
                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-xs-4">
                    <div class="well">
                        <ul class="list-unstyled">
                            @if(!empty($invoice->provider_comment))
                                <li>
                                    <strong>Provider Comment:</strong> {{ $invoice->provider_comment }}
                                </li>
                            @endif

                            @if(!empty($invoice->admin_comment))
                                <li>
                                    <strong>Admin Comment:</strong> {{ $invoice->admin_comment }}
                                </li>
                            @endif

                            @if(!empty($services_items) && $invoice->is_paid ==0)
                                {!! Form::open(['method'=>'POST','route'=>['add-item-to-invoice']]) !!}
                                    <label for="service_id" class="control-label">
                                        Add Item To Invoice <span class="required"> * </span>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-icon">
                                            {!! Form::select('service_id',$services_items,'',['class'=>'form-control select2','required'=>'required']) !!}
                                            {!! Form::hidden('invoice_id',$invoice->id) !!}
                                        </div>
                                        <span class="input-group-btn">
                                            <button class="btn btn-success" type="submit">
                                                <i class="fa fa-check-circle"></i> Add
                                            </button>
                                        </span>
                                    </div>
                                    @if($errors->has('invoice_id'))
                                        <span class="help-block text-danger">{{ $errors->first('invoice_id') }}</span>
                                    @endif
                                    @if($errors->has('service_id'))
                                        <span class="help-block text-danger">{{ $errors->first('service_id') }}</span>
                                    @endif
                                {!! Form::close() !!}
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 invoice-block">
                    <ul class="list-unstyled amounts">
                        <li>
                            <strong>Amount Original:</strong>{{ $invoice->amount_original }}
                        </li>
                        <li>
                            <strong>Amount After Discount:</strong>{{ $invoice->amount_after_discount }}
                        </li>
                        <li>
                            <strong>Amount After V.A.T:</strong>{{ $invoice->amount_after_vat }}
                        </li>
                        <li>
                            <strong>Amount Final:</strong> {{ $invoice->amount_final }}
                        </li>
                        <li>
                            <strong>Currency:</strong> {{ ($invoice->currency) ? $invoice->currency->name_eng : '' }}
                        </li>
                    </ul>
                    <br/>
                    <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();"> Print
                        <i class="fa fa-print"></i>
                    </a>
                    @if($invoice->is_paid==1)
                            <a class="btn btn-lg green hidden-print margin-bottom-5" onclick="return false" href="#">
                                Paid <i class="fa fa-check"></i>
                            </a>
                        @else
                            <a class="btn btn-lg green hidden-print margin-bottom-5" href="{{ route('show-pay-invoice',['invoice'=>$invoice->id]) }}">
                                Pay Invoice <i class="fa fa-check"></i>
                            </a>
                    @endif
                </div>
            </div>
        </div>
    @endif
@stop

@section('script')
    {{--    <script src="{{ asset('public/assets/pages/scripts/ui-modals.min.js') }}" type="text/javascript"></script>--}}

    {{--<script src="{{ asset('public/js/custom/customerAppointmentsDataTable.js') }}" type="text/javascript"></script>--}}
@stop