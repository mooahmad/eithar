@extends(ADL.'.master')

@section('style')
    <link href="{{ asset('public/assets/pages/css/invoice.min.css') }}" rel="stylesheet" type="text/css"/>
@stop

@section('content')

    @if(!empty($invoice))
        <div class="invoice">
            <div class="row invoice-logo">
                <div class="col-xs-6" style="width: 293px;">



                    @if(!empty($invoice->customer))<p>

                    <ul class="list-unstyled">
                        <li style="margin-bottom: 35px; font-size: 22px;">Receipt</li>
                        <li><h4>{{ $invoice->customer->full_name }}</h4></li>

                    @endif
                    <div class="row">
                          <div class="col-xs-12" style="margin-bottom: 5px"> Invoice Number : {{ $invoice->invoice_code }}
                          </div>
                        <div class="col-xs-12" style="margin-bottom: 5px"> Acount Number : {{ $invoice->customer->eithar_id }}
                        </div>

                          <div class="col-xg-12">


                                  <span class="" style="margin-left: 12px;"> Issued : {{ $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('l-j-F-Y / h:i A') : ''}}</span>

                          </div>
                      </div>
                    </ul>
                </div>
                <div class="col-xs-6 invoice-logo-space">
                    <div class=" invoice-logo-eithar" style="">
                        <img src="{{ asset('public/NewFront/images/logo.png') }}" class="img-responsive" alt=""/>
                    </div>
                    <h4>From :</h4>
                    Eithar Home Care Company,
                    King Salman road,
                    RIYADH RIYADH 5136-13525,
                    SAUDI ARABIA
                    Telephone : +966118103234


                </div>
            </div>

            <hr/>

            <div class="row">
                <div class="col-xs-12">
                    <h3>Payment Details:</h3>
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th><strong>Service Discription</strong> </th>
                            <th><strong>Quantity</strong> </th>
                            <th><strong>Unit Price</strong></th>
                            <th><strong>Discount </strong></th>
                            <th><strong>Tax:</strong></th>
                            <th><strong>Amount SAR:</strong></th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($invoice->items as $item)
                            <tr>
                                <td>{{$item->item_desc_appear_in_invoice}}</td>
                                <td>{{$item->quantity}}</td>
                                <td>{{$item->price}}</td>
                                <td>{{$item->discount_percent ? $item->discount_percent.'%' : '0%'  }}</td>
                                <td>{{$item->tax_percent ? $item->tax_percent.'%' : '0%'}}</td>
                                <td>{{$item->final_amount}}</td>
                            </tr>
                            <tr>
                                <hr />
                                <td colspan="4" style="border: none;">Subtotal (includes a discount of {{$item->discount_percent}})	</td>
                                <td colspan="2" style="border: none;">Subtotal (includes a discount of {{$item->final_amount}})	</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <hr/>

            <div class="row">
                <div class="col-xs-6" style="width: 70px;">
                    Amount Due
                </div>
                <div class="col-xs-6 invoice-logo-space" width="120" style="padding-left: 350px;  margin-bottom: 15px;  width: 30%; left: 490px">
                    @if(!empty($invoice))
                        {{$invoice->amount_final}}
                    @endif
                </div>
            </div>
<br>


            @if($invoice->is_paid==1)
                <div>
                    <strong>Payment
                        Method:</strong> {{ config('constants.payment_methods.'.$invoice->payment_method) }}
                </div>
                </br>
                @if($invoice->payment_method !=1)

                    <strong>Payment Transaction
                        Number : {{ $invoice->payment_transaction_number }}
                    </strong></th>
                    <br/>

                @endif
            @endif

            <strong>
                VAT Number: 310192853900003
            </strong>
            <hr/>
            {{--<div class="row">--}}
                {{--@if(!empty($invoice->customer))--}}
                    {{--<div class="col-xs-5">--}}
                        {{--<h3>Customer Details:</h3>--}}
                        {{--<ul class="list-unstyled">--}}
                            {{--<li> {{ $invoice->customer->national_id }} </li>--}}
                            {{--<li>mobile : {{ $invoice->customer->mobile_number }} </li>--}}
                            {{--<li> email :{{ $invoice->customer->email }} </li>--}}
                            {{--<li> address :{{ $invoice->customer->address }} </li>--}}
                            {{--<li>country : {{ ($invoice->customer->country) ? $invoice->customer->country->country_name_eng : '' }}--}}
                                {{--- {{ ($invoice->customer->city) ? $invoice->customer->city->city_name_eng : '' }}</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--@endif--}}
                {{--@if(!empty($invoice->booking_service->family_member))--}}
                    {{--<div class="col-xs-3">--}}
                        {{--<h3>Family Member Details:</h3>--}}
                        {{--<ul class="list-unstyled">--}}
                            {{--<li> {{ $invoice->booking_service->family_member->getFullNameAttribute()}} </li>--}}
                            {{--<li> {{ $invoice->booking_service->family_member->national_id}} </li>--}}
                            {{--<li> {{ $invoice->booking_service->family_member->address}} </li>--}}

                        {{--</ul>--}}
                    {{--</div>--}}
                {{--@endif--}}


            </div>

            {{--@if(!empty($invoice->items))--}}
                {{--<div class="row">--}}
                    {{--<div class="col-xs-12">--}}
                        {{--<table class="table table-striped table-hover">--}}
                            {{--<thead>--}}
                            {{--<tr>--}}
                                {{--<th> # </th>--}}
                                {{--<th> Service/Provider Name </th>--}}
                                {{--<th> Status</th>--}}
                                {{--<th> Created At</th>--}}
                            {{--</tr>--}}
                            {{--</thead>--}}
                            {{--<tbody>--}}
                            {{--@foreach($invoice->items as $item)--}}
                                {{--<tr>--}}
                                    {{--<td> {{ $item->id }} </td>--}}
                                    {{--<td> {{ $item->item_desc_appear_in_invoice }} </td>--}}
                                    {{--<td>--}}
                                        {{--@if(($item->status == 2))--}}
                                            {{--<span class="label label-success label-sm"> Approved </span>--}}
                                        {{--@else--}}
                                            {{--<span class="label label-warning label-sm"> Pending </span>--}}

                                            {{--{!! Form::open(['method'=>'POST','route'=>['delete-item-to-invoice']]) !!}--}}
                                            {{--{!! Form::hidden('invoice_item_id',$item->id) !!}--}}
                                            {{--<button class="btn btn-danger" type="submit">--}}
                                                {{--<i class="fa fa-close"></i> Delete--}}
                                            {{--</button>--}}
                                            {{--{!! Form::close() !!}--}}

                                        {{--@endif--}}
                                    {{--</td>--}}
                                    {{--<td>{{ $item->created_at }}</td>--}}
                                {{--</tr>--}}
                            {{--@endforeach--}}
                            {{--</tbody>--}}
                        {{--</table>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--@endif--}}

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
                    {{--<ul class="list-unstyled amounts">--}}
                        {{--<li>--}}
                            {{--<strong>Amount Original:</strong>{{ $invoice->amount_original }}--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<strong>Amount After Discount:</strong>{{ $invoice->amount_after_discount }}--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<strong>Amount After V.A.T:</strong>{{ $invoice->amount_after_vat }}--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<strong>Amount Final:</strong> {{ $invoice->amount_final }}--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<strong>Currency:</strong> {{ ($invoice->currency) ? $invoice->currency->name_eng : '' }}--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                    <br/>
                    <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();"> Print
                        <i class="fa fa-print"></i>
                    </a>
                    @if($invoice->is_paid==1)
                        <a class="btn btn-lg green hidden-print margin-bottom-5" onclick="return false" href="#">
                            Paid <i class="fa fa-check"></i>
                        </a>
                    @else
                        <a class="btn btn-lg green hidden-print margin-bottom-5"
                           href="{{ route('show-pay-invoice',['invoice'=>$invoice->id]) }}">
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