@extends('vendor.mail.layouts.master')

@section('content')
    @if($lang == 'ar')
        <!-- Start Table Header-->
        <table border="0" cellspacing="0" align="center" style="background-color:#07A7E2; min-width:750px;text-align:center;color:#fff; padding: 20px 0;">
            <thead>
            <tr>
                <th>
                    <span> <img src="{{ asset('public/email/cancel.png') }}" alt="Eithar"> </span>
                    <p>Appointment Canceled</p>
                    <p>شكراً لاختيارك خدمات إيثار </p>
                </th>
            </tr>
            </thead>
        </table>
        <!-- End Table Header-->

        <!--Start Table Body-->
        <table border="0" cellspacing="0" align="center" style="text-align:center; background-color:#fff; min-width:750px; padding:20px 0;">
            <!--Start Row Title-->
            <tr style="text-align:center;">
                <td colspan="2">
                    <p style="font-size:20px; color:#07A7E2;">
                        تم إلغاء الزيارة
                    </p>
                </td>
            </tr>
            <!--End Row Title-->
        </table>
        <!--End Table Body-->

    @else
        <!-- Start Table Header-->
        <table border="0" cellspacing="0" align="center" style="background-color:#07A7E2; min-width:750px;text-align:center;color:#fff; padding: 20px 0;">
            <thead>
            <tr>
                <th>
                    <span> <img src="{{ asset('public/email/cancel.png') }}" alt="Eithar"> </span>
                    <p> Appointment Canceled</p>
                    <p>Thank you for using Eithar </p>
                </th>
            </tr>
            </thead>
        </table>
        <!-- End Table Header-->

        <!--Start Table Body-->
        <table border="0" cellspacing="0" align="center" style="text-align:center; background-color:#fff; min-width:750px; padding:20px 0;">
            <!--Start Row Title-->
            <tr style="text-align:center;">
                <td colspan="2">
                    <p style="font-size:20px; color:#07A7E2;">
                        Appointment Canceled
                    </p>
                </td>
            </tr>
            <!--End Row Title-->
        </table>
        <!--End Table Body-->
    @endif
@endsection