@extends(ADL.'.master')

@section('style')
    <link href="{{ asset('public/assets/pages/css/invoice.min.css') }}" rel="stylesheet" type="text/css"/>
@stop

@section('content')

    @if(!empty($booking))
        <div class="invoice">
            <div class="row invoice-logo">
                <div class="col-xs-6 invoice-logo-space">
                    {{--<img src="{{ \App\Helpers\Utilities::getFileUrl($meetings->customer->image) }}" class="img-responsive" alt="" /> </div>--}}
                    <img src="{{ asset('public/assets/layouts/layout/img/logo.png') }}" class="img-responsive" alt="" /> </div>
                <div class="col-xs-6">
                    <p> #{{ $booking->id }} / {{ $booking->created_at->format('l j F Y h:i A') }}
                        <strong class="text-info">{{ $booking->status_desc }}</strong>
                    </p>
                </div>
            </div>
            <hr/>
            <div class="row">
                @if(!empty($booking->customer))
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
                @endif

                @if(!empty($booking->family_member))
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
                            <strong>V.A.T:</strong> {{ ($booking->customer->is_saudi_nationality ==1) ? 0 : config('constants.vat_percentage') }} %
                        </li>
                        <li>
                            <strong>Promo Code:</strong> {{ ($booking->promo_code) ? $booking->promo_code->name_en .'-('.$booking->promo_code->code .')-'.$booking->promo_code->discount_percentage.'%' : 'No' }}
                        </li>
                        <li>
                            <strong>Currency:</strong> {{ ($booking->currency) ? $booking->currency->name_eng : '' }}
                        </li>
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
                            <th class="hidden-xs"> Start Date </th>
                            <th class="hidden-xs"> End Date </th>
                            <th class="hidden-xs"> Price </th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(!empty($booking_details))
                                <tr>
                                    <td> {{ $booking_details['id'] }} </td>
                                    <td> {{ $booking_details['service_name'] }} </td>
                                    <td> {{ $booking_details['start_date'] }} </td>
                                    <td> {{ $booking_details['end_date'] }} </td>
                                    <td class="hidden-xs"> {{ $booking_details['price'] }} {{ $booking_details['currency'] }} </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <div class="well">
                        <ul class="list-unstyled">
                            @if(!empty($booking->comment))
                                <li>
                                    <strong>Customer Comment:</strong> {{ $booking->comment }}
                                </li>
                            @endif

                            @if(!empty($booking->admin_comment))
                                <li>
                                    <strong>Admin Comment:</strong> {{ $booking->admin_comment }}
                                </li>
                            @endif

                            @if(!empty($booking->provider_id_assigned_by_admin))
                                <li>
                                    <strong>Assigned Provider:</strong> {{ $booking->assigned_provider->full_name }}
                                </li>
                                @else
                                @if(!empty($providers))
                                    {!! Form::open(['method'=>'POST','url'=>'Administrator/meetings/'.$booking->id.'/assign-provider']) !!}
                                            <label for="name" class="control-label">
                                                Assign Provider To Meeting <span class="required"> * </span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-icon">
                                                    {!! Form::select('provider_id',$providers,'',['class'=>'form-control select2','required'=>'required']) !!}
                                                </div>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-success" type="submit">
                                                        <i class="fa fa-user-md"></i> Assign
                                                    </button>
                                                </span>
                                            </div>
                                            @if($errors->has('provider_id'))
                                                <span class="help-block text-danger">{{ $errors->first('provider_id') }}</span>
                                            @endif
                                    {!! Form::close() !!}
                                @endif
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 invoice-block">
                    <ul class="list-unstyled amounts">
                        <li>
                            <strong>Sub - Total amount:</strong> {{ $booking_details['price'] }} {{ $booking_details['currency'] }} </li>
                        <li>
                            <strong>Discount:</strong> {{ ($booking->promo_code) ? $booking->promo_code->name_en .'-('.$booking->promo_code->code .')-'.$booking->promo_code->discount_percentage : '0' }} %</li>
                        <li>
                            <strong>VAT:</strong> {{ ($booking->customer->is_saudi_nationality ==1) ? 0 : config('constants.vat_percentage') }} % </li>
                        <li>
                            <strong>Grand Total:</strong> {{ $booking_details['price'] }} {{ $booking_details['currency'] }} </li>
                    </ul>
                    <br/>
                    <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();"> Print
                        <i class="fa fa-print"></i>
                    </a>
                    <a class="btn btn-lg green hidden-print margin-bottom-5" href="{{ route('generate-invoice',['booking'=>$booking->id]) }}"> {{ ($booking->invoice) ? 'Show ' : 'Generate ' }} Invoice
                        <i class="fa fa-check"></i>
                    </a>
                </div>
            </div>
        </div>
    @endif
@stop