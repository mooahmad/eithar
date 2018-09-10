@extends(ADL.'.master')

@section('style')
    <link href="{{ asset('public/assets/pages/css/invoice.min.css') }}" rel="stylesheet" type="text/css"/>
@stop

@section('content')

    <div class="invoice">
        <div class="row invoice-logo">
            <div class="col-xs-6 invoice-logo-space">
                {{--<img src="{{ \App\Helpers\Utilities::getFileUrl($booking->customer->image) }}" class="img-responsive" alt="" /> </div>--}}
                <img src="{{ asset('public/assets/layouts/layout/img/logo.png') }}" class="img-responsive" alt="" /> </div>
            <div class="col-xs-6">
                <p> #{{ $booking->id }} / {{ $booking->created_at->format('l j F Y h:i A') }}
                    <strong class="text-info">{{ $booking->status_desc }}</strong>
                    <span class="muted"> {{ $booking->customer->full_name }} </span>
                </p>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-xs-4">
                <h3>Customer Details:</h3>
                <ul class="list-unstyled">
                    <li> {{ $booking->customer->full_name }} </li>
                    <li> {{ $booking->customer->national_id }} </li>
                    <li> {{ $booking->customer->mobile_number }} </li>
                    <li> {{ $booking->customer->email }} </li>
                    <li> {{ $booking->customer->address }} </li>
                    <li> {{ ($booking->customer->country) ? $booking->customer->country->country_name_eng : '' }}  - {{ ($booking->customer->city) ? $booking->customer->city->city_name_eng : '' }}</li>
                </ul>
            </div>

            @if(count($booking->family_member))
                <div class="col-xs-4">
                    <h3>Family Member:</h3>
                    <ul class="list-unstyled">
                        <li> {{ $booking->family_member->full_name }} ({{ config('constants.MemberRelations_desc.'.$booking->family_member->relation_type) }})</li>
                        <li> {{ $booking->family_member->national_id }} </li>
                        <li> {{ config('constants.gender_desc.'.$booking->family_member->gender) }}</li>
                        <li> {{ $booking->family_member->mobile_number }} </li>
                        <li> {{ $booking->family_member->address }} </li>
                    </ul>
                </div>
            @endif
            <div class="col-xs-4 invoice-payment">
                <h3>Payment Details:</h3>
                <ul class="list-unstyled">
                    <li>
                        <strong>V.A.T:</strong> {{ ($booking->customer->is_saudi_nationality ==1) ? 0 : config('constants.vat_percentage') }} %</li>
                    <li>
                        <strong>Promo Code:</strong> {{ ($booking->promo_code) ? $booking->promo_code->name_en .'-('.$booking->promo_code->code .')-'.$booking->promo_code->discount_percentage.'%' : 'No' }} </li>
                    <li>
                        <strong>Currency:</strong> {{ ($booking->currency) ? $booking->currency->name_eng : '' }} </li>
                    <li>
                        <strong>Customer Comment:</strong> {{ $booking->comment }} </li>
                    <li>
                        <strong>Admin Comment:</strong> {{ $booking->admin_comment }} </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th> # </th>
                        <th> Service Name </th>
                        <th class="hidden-xs"> Description </th>
                        <th class="hidden-xs"> Price </th>
                        <th class="hidden-xs"> Unit Cost </th>
                        <th> Total </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($booking->is_lap ==1)
                        <tr>
                            <td> {{ $booking->service->id }} </td>
                            <td> {{ $booking->service->name_en }} </td>
                            <td class="hidden-xs"> {{ $booking->service->desc_en }} </td>
                            <td class="hidden-xs"> {{ $booking->service->price }} </td>
                            <td class="hidden-xs"> {{ $booking->service->visit_duration }} </td>
                            <td> $2152 </td>
                        </tr>
                    @else
                        <tr>
                            <td> {{ $booking->service->id }} </td>
                            <td> {{ $booking->service->name_en }} {{ ($booking->provider) ? $booking->provider->full_name : '' }}</td>
                            <td class="hidden-xs"> {{ $booking->service->desc_en }} </td>
                            <td class="hidden-xs"> {{ $booking->service->price }} </td>
                            <td class="hidden-xs"> {{ $booking->service->visit_duration }} </td>
                            <td> $2152 </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <div class="well">
                    <address>
                        <strong>Loop, Inc.</strong>
                        <br/> 795 Park Ave, Suite 120
                        <br/> San Francisco, CA 94107
                        <br/>
                        <abbr title="Phone">P:</abbr> (234) 145-1810 </address>
                    <address>
                        <strong>Full Name</strong>
                        <br/>
                        <a href="mailto:#"> first.last@email.com </a>
                    </address>
                </div>
            </div>
            <div class="col-xs-8 invoice-block">
                <ul class="list-unstyled amounts">
                    <li>
                        <strong>Sub - Total amount:</strong> $9265 </li>
                    <li>
                        <strong>Discount:</strong> 12.9% </li>
                    <li>
                        <strong>VAT:</strong> ----- </li>
                    <li>
                        <strong>Grand Total:</strong> $12489 </li>
                </ul>
                <br/>
                <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();"> Print
                    <i class="fa fa-print"></i>
                </a>
                <a class="btn btn-lg green hidden-print margin-bottom-5"> Submit Your Invoice
                    <i class="fa fa-check"></i>
                </a>
            </div>
        </div>
    </div>

@stop

@section('script')
    {{--<script src="{{ asset('public/js/custom/customerAppointmentsDataTable.js') }}" type="text/javascript"></script>--}}
@stop