@extends('vendor.mail.layouts.master')

@section('content')
    <tr>
        <td bgcolor="#ffffff" style="padding: 40px 40px 20px; text-align: center;">
            <h1 style="margin: 0; font-family: sans-serif; font-size: 24px; line-height: 27px; color: #333333; font-weight: normal;">{{ $customer->full_name }}</h1>
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" style="padding: 0 40px 40px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555; text-align: center;">
            <p style="margin: 0;">
                {{ $notification->send_at }}
            </p>
        </td>
    </tr>
@endsection
