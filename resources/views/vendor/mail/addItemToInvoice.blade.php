@extends('vendor.mail.layouts.master')

@section('content')
    @if($lang == 'ar')
        <!-- Start Table Header-->
        <table border="0" cellspacing="0" align="center" style="background-color:#07A7E2; min-width:750px;text-align:center;color:#fff; padding: 20px 0;">
            <thead>
            <tr>
                <th>
                    <span> <img src="{{ asset('public/email/customer.png') }}" alt="Eithar"> </span>
                    <p> Services added </p>
                    <p>شكراً لاختيارك خدمات إيثار </p>
                </th>
            </tr>
            </thead>
        </table>
        <!-- End Table Header-->

        <!--Start Table Body-->
        @if(!empty($item))
            <table border="0" cellspacing="0" align="center" style="text-align:center; background-color:#fff; min-width:750px; padding:20px 0;">
                <!--Start Row Title-->
                <tr style="text-align:center;">
                    <td colspan="2">
                        <p style="font-size:20px; color:#07A7E2;">
                            تم إضافة هذه الخدمات على الفاتورة
                        </p>
                    </td>
                </tr>
                <!--End Row Title-->
                <!-- Start Table Services Added-->
                <tr>
                    <td colspan=" 2"> <span style="font-size:20px;display:block;padding-top:20px;padding-bottom:5px;color:#000;"> تم إضافة هذه الخدمات على الفاتورة </span> </td>
                </tr>
                <tr>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->item_desc_appear_in_invoice }}</td>
                </tr>
                <!-- End Table Services Added-->

                <!--Start Row Sub Title-->
                <tr style="text-align:center;">
                    <td colspan="2">
                        <p style="font-size:20px;line-height: 28px;">
                            يرجى الضغط على <a href="#" style="color:#07A7E2; display:inline-block"> هذا الرابط</a> للموافقة على هذه الخدمات
                        </p>
                    </td>
                </tr>
                <!--End Row Sub Title-->
            </table>
        @endif
        <!--End Table Body-->

        @else
        <!-- Start Table Header-->
        <table border="0" cellspacing="0" align="center" style="background-color:#07A7E2; min-width:750px;text-align:center;color:#fff; padding: 20px 0;">
            <thead>
            <tr>
                <th>
                    <span> <img src="{{ asset('public/email/customer.png') }}" alt="Eithar"> </span>
                    <p> Services added </p>
                    <p>Thank you for using Eithar</p>
                </th>
            </tr>
            </thead>
        </table>
        <!-- End Table Header-->

        <!--Start Table Body-->
        @if(!empty($item))
            <table border="0" cellspacing="0" align="center" style="text-align:center; background-color:#fff; min-width:750px; padding:20px 0;">
                <!--Start Row Title-->
                <tr style="text-align:center;">
                    <td colspan="2">
                        <p style="font-size:20px; color:#07A7E2;">
                            تم إضافة هذه الخدمات على الفاتورة
                        </p>
                    </td>
                </tr>
                <!--End Row Title-->
                <!-- Start Table Services Added-->
                <tr>
                    <td colspan=" 2"> <span style="font-size:20px;display:block;padding-top:20px;padding-bottom:5px;color:#000;"> تم إضافة هذه الخدمات على الفاتورة </span> </td>
                </tr>
                <tr>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->item_desc_appear_in_invoice }}</td>
                </tr>
                <!-- End Table Services Added-->

                <!--Start Row Sub Title-->
                <tr style="text-align:center;">
                    <td colspan="2">
                        <p style="font-size:20px;line-height: 28px;">
                            يرجى الضغط على <a href="#" style="color:#07A7E2; display:inline-block"> هذا الرابط</a> للموافقة على هذه الخدمات
                        </p>
                    </td>
                </tr>
                <!--End Row Sub Title-->
            </table>
        @endif
        <!--End Table Body-->
    @endif
@endsection
