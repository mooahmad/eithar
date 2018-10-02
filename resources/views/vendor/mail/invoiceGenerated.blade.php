@extends('vendor.mail.layouts.master')

@section('content')
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="90%" style="margin: auto;" class="email-container">
        <tr>
            <td bgcolor="#ffffff" style="padding: 40px 40px 20px; text-align: left;">
                <h4 style="margin: 0; font-family: sans-serif; font-size: 24px; line-height: 27px; color: #333333; font-weight: normal;"><strong>To</strong> {{ $customer->full_name }}</h4>
            </td>
            <td bgcolor="#ffffff" style="padding: 40px 40px 20px; text-align: right;">
                <h4 style="margin: 0; font-family: sans-serif; font-size: 24px; line-height: 27px; color: #333333; font-weight: normal;"><strong>From</strong>  Eithar Home Care Company
                    King Salman road<br/>
                    RIYADH RIYADH 6761-12458<br/>
                    SAUDI ARABIA<br/>
                    Telephone : +966118103234<br/>
                </h4>
            </td>
        </tr>
        <tr>
            <td bgcolor="#ffffff" style="padding: 0 40px 40px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555; text-align: left;" colspan="2">
                <h4 style="margin: 0;">
                    <strong>Invoice Number:</strong> {{ $invoice->invoice_code }}
                </h4>
                <h4 style="margin: 0;">
                    <strong>Issued:</strong> {{ $invoice->invoice_date->format('l j F Y h:i A') }}
                </h4>
            </td>
        </tr>
    </table>

    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="90%" style="margin: auto;" class="email-container">
        <thead bgcolor="#ffffff" style="padding: 40px 40px 20px; text-align: center;">
            <th><h4>Description</h4></th>
            <th><h4>Quantity</h4></th>
            <th><h4>Status</h4></th>
        </thead>
        <tbody>
            @if(!empty($invoice->items))
                @foreach($invoice->items as $item)
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 40px 40px 20px; text-align: center;">
                            <p style="margin: 0; font-family: sans-serif; font-size: 18px; line-height: 27px; color: #333333; font-weight: normal;">{{ $item->item_desc_appear_in_invoice }}</p>
                        </td>
                        <td bgcolor="#ffffff" style="padding: 40px 40px 20px; text-align: center;">
                            <p style="margin: 0; font-family: sans-serif; font-size: 18px; line-height: 27px; color: #333333; font-weight: normal;">1</p>
                        </td>
                        <td bgcolor="#ffffff" style="padding: 40px 40px 20px; text-align: center;">
                        @if(($item->status == 2))
                                <p style="margin: 0; font-family: sans-serif; font-size: 18px; line-height: 27px; color: #333333; font-weight: normal;">Approved</p>
                            @else
                                <p style="margin: 0; font-family: sans-serif; font-size: 18px; line-height: 27px; color: #333333; font-weight: normal;">Pending</p>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
            <tr>
                <td colspan="3" bgcolor="#ffffff" style="padding: 5px 40px 5px; text-align: left;">
                    <hr>
                </td>
            </tr>
            <tr>
                <td colspan="3" bgcolor="#ffffff" style="padding: 5px 40px 5px; text-align: left;">
                    <p style="margin: 0; font-family: sans-serif; font-size: 18px; line-height: 27px; color: #333333; font-weight: normal;">Original Amount: {{ $invoice->amount_original }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="3" bgcolor="#ffffff" style="padding: 5px 40px 5px; text-align: left;">
                    <p style="margin: 0; font-family: sans-serif; font-size: 18px; line-height: 27px; color: #333333; font-weight: normal;">Amount After Discount: {{ $invoice->amount_after_discount }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="3" bgcolor="#ffffff" style="padding: 5px 40px 5px; text-align: left;">
                    <p style="margin: 0; font-family: sans-serif; font-size: 18px; line-height: 27px; color: #333333; font-weight: normal;">Amount After V.A.T: {{ $invoice->amount_after_vat }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="3" bgcolor="#ffffff" style="padding: 5px 40px 5px; text-align: left;">
                    <p style="margin: 0; font-family: sans-serif; font-size: 18px; line-height: 27px; color: #333333; font-weight: normal;">Amount Due: {{ $invoice->amount_final }} {{ ($invoice->currency) ? $invoice->currency->name_eng : '' }}</p>
                </td>
            </tr>

            <tr>
                <td colspan="3" bgcolor="#ffffff" style="padding: 5px 40px 5px; text-align: left;">
                    <hr>
                </td>
            </tr>

            @if($invoice->is_paid==1)
                <tr>
                    <td colspan="3" bgcolor="#ffffff" style="padding: 5px 40px 5px; text-align: left;">
                        <p style="margin: 0; font-family: sans-serif; font-size: 18px; line-height: 27px; color: #333333; font-weight: normal;"><strong>Payment Status:</strong> Paid</p>
                    </td>
                </tr>

                <tr>
                    <td colspan="3" bgcolor="#ffffff" style="padding: 5px 40px 5px; text-align: left;">
                        <p style="margin: 0; font-family: sans-serif; font-size: 18px; line-height: 27px; color: #333333; font-weight: normal;"><strong>Payment Type:</strong> {{ config('constants.payment_methods.'.$invoice->payment_method) }}</p>
                    </td>
                </tr>

                @if($invoice->payment_method !=1)
                    <tr>
                        <td colspan="3" bgcolor="#ffffff" style="padding: 5px 40px 5px; text-align: left;">
                            <p style="margin: 0; font-family: sans-serif; font-size: 18px; line-height: 27px; color: #333333; font-weight: normal;"><strong><strong>Payment Transaction Number:</strong> {{ $invoice->payment_transaction_number }}</p>
                        </td>
                    </tr>
                @endif
                @else
                    <tr>
                        <td colspan="3" bgcolor="#ffffff" style="padding: 5px 40px 40px; text-align: left;">
                            <p style="margin: 0; font-family: sans-serif; font-size: 18px; line-height: 27px; color: #333333; font-weight: normal;"><strong>Payment Status:</strong> Pending</p>
                        </td>
                    </tr>
            @endif
        </tbody>
    </table>
@endsection
