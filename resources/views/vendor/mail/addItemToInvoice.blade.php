@extends('vendor.mail.layouts.master')

@section('content')
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="90%" style="margin: auto;" class="email-container">
        <tr>
            <td align="top" bgcolor="#ffffff" style="padding: 20px 20px 20px; text-align: left;">
                <h4 style="margin: 0; font-family: sans-serif; line-height: 15px; color: #333333; font-weight: normal;"><strong>To</strong> {{ $customer->full_name }}</h4>
            </td>
            <td bgcolor="#ffffff" style="padding: 40px 40px 20px; text-align: right;">
                <h4 style="margin: 0; font-family: sans-serif; line-height: 17px; color: #333333; font-weight: normal;"><strong>From</strong>  Eithar Home Care Company
                    King Salman road<br/>
                    RIYADH RIYADH 6761-12458<br/>
                    SAUDI ARABIA<br/>
                    Telephone : +966118103234<br/>
                </h4>
            </td>
        </tr>
        <tr>
            <td colspan="2" bgcolor="#ffffff" style="padding: 20px 20px 20px; text-align: left;">
                <h4 style="margin: 0; font-family: sans-serif; line-height: 15px; color: #333333; font-weight: normal;">Dear {{ $customer->full_name }},</h4>
            </td>
        </tr>
        <tr>
            <td colspan="2" bgcolor="#ffffff" style="padding: 20px 20px 20px; text-align: left;">
                <h4 style="margin: 0; font-family: sans-serif; line-height: 15px; color: #333333; font-weight: normal;">Please confirm this item</h4>
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
            @if(!empty($item))
                <tr>
                    <td bgcolor="#ffffff" style="padding: 20px 20px 20px; text-align: center;">
                        <p style="margin: 0; font-family: sans-serif; font-size: 18px; line-height: 27px; color: #333333; font-weight: normal;">{{ $item->item_desc_appear_in_invoice }}</p>
                    </td>
                    <td bgcolor="#ffffff" style="padding: 20px 20px 20px; text-align: center;">
                        <p style="margin: 0; font-family: sans-serif; font-size: 18px; line-height: 27px; color: #333333; font-weight: normal;">1</p>
                    </td>
                    <td bgcolor="#ffffff" style="padding: 20px 20px 20px; text-align: center;">
                        @if(($item->status == 2))
                            <p style="margin: 0; font-family: sans-serif; font-size: 18px; line-height: 27px; color: #333333; font-weight: normal;">Approved</p>
                        @else
                            <p style="margin: 0; font-family: sans-serif; font-size: 18px; line-height: 27px; color: #333333; font-weight: normal;">Pending</p>
                        @endif
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
@endsection
