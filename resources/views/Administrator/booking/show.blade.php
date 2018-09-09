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
                <p> #{{ $booking->id }} / {{ $booking->created_at->toFormattedDateString() }}
                    <span class="muted"> {{ $booking->customer->full_name }} </span>
                </p>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-xs-4">
                <h3>Client:</h3>
                <ul class="list-unstyled">
                    <li> {{ $booking->customer->full_name }} </li>
                    <li> {{ $booking->customer->national_id }} </li>
                    <li> {{ $booking->customer->mobile_number }} </li>
                    <li> {{ $booking->customer->email }} </li>
                    <li> {{ $booking->customer->address }} </li>
                    <li> {{ ($booking->customer->country) ? $booking->customer->country->country_name_eng : '' }}  - {{ ($booking->customer->city) ? $booking->customer->city->city_name_eng : '' }}</li>
                    <li>  </li>
                </ul>
            </div>
            <div class="col-xs-4">
                <h3>About:</h3>
                <ul class="list-unstyled">
                    <li> Drem psum dolor sit amet </li>
                    <li> Laoreet dolore magna </li>
                    <li> Consectetuer adipiscing elit </li>
                    <li> Magna aliquam tincidunt erat volutpat </li>
                    <li> Olor sit amet adipiscing eli </li>
                    <li> Laoreet dolore magna </li>
                </ul>
            </div>
            <div class="col-xs-4 invoice-payment">
                <h3>Payment Details:</h3>
                <ul class="list-unstyled">
                    <li>
                        <strong>V.A.T Reg #:</strong> 542554(DEMO)78 </li>
                    <li>
                        <strong>Account Name:</strong> FoodMaster Ltd </li>
                    <li>
                        <strong>SWIFT code:</strong> 45454DEMO545DEMO </li>
                    <li>
                        <strong>Account Name:</strong> FoodMaster Ltd </li>
                    <li>
                        <strong>SWIFT code:</strong> 45454DEMO545DEMO </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th> # </th>
                        <th> Item </th>
                        <th class="hidden-xs"> Description </th>
                        <th class="hidden-xs"> Quantity </th>
                        <th class="hidden-xs"> Unit Cost </th>
                        <th> Total </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td> 1 </td>
                        <td> Hardware </td>
                        <td class="hidden-xs"> Server hardware purchase </td>
                        <td class="hidden-xs"> 32 </td>
                        <td class="hidden-xs"> $75 </td>
                        <td> $2152 </td>
                    </tr>
                    <tr>
                        <td> 2 </td>
                        <td> Furniture </td>
                        <td class="hidden-xs"> Office furniture purchase </td>
                        <td class="hidden-xs"> 15 </td>
                        <td class="hidden-xs"> $169 </td>
                        <td> $4169 </td>
                    </tr>
                    <tr>
                        <td> 3 </td>
                        <td> Foods </td>
                        <td class="hidden-xs"> Company Anual Dinner Catering </td>
                        <td class="hidden-xs"> 69 </td>
                        <td class="hidden-xs"> $49 </td>
                        <td> $1260 </td>
                    </tr>
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