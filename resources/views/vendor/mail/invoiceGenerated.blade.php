@extends('vendor.mail.layouts.master')

@section('content')
    <!-- Start Table Header-->
    <table border="0" cellspacing="0" align="center"
           style="background-color:#fff;border-radius:10px; min-width:750px;  padding:20px;">
        <!-- Start Head-->
        <tr>
            <th style=" width:30%"></th>
            <!--Logo-->
            <th>
                <a href="{{ url('/') }}"> <img src="{{ asset('public/email/logo2.png') }}" alt="Eithar" style="
                   height:40px;
                   width:80px;
                 "></a>
            </th>
            <th>Receipt</th>
        </tr>
        <!-- End Head-->
        <!-- Start Sub Header-->
        <tr>
            <td>
                <span>{{ $customer->full_name }}</span>
            </td>
            <td></td>
            <td>
                @if($lang == 'ar')
                    <ul style="list-style: none outside none;">
                        <li><span>من/ شركة ايثار الأولى للخدمات الطبية</span></li>
                        <li><span>طريق الملك سلمان حي الملقا</span></li>
                        <li><span><bdi>+966118103234 </bdi> هاتف</span></li>
                    </ul>
                @else
                    <ul style="list-style: none outside none;">
                        <li><span>From/ Eithar Home Care Company</span></li>
                        <li><span>King Salman road RIYADH RIYADH 6761-12458 SAUDI ARABIA</span></li>
                        <li><span>Telephone: <bdi>+966118103234 </bdi></span></li>
                    </ul>
                @endif
            </td>
        </tr>
        <!-- End Sub Header-->
        <!--Start -->
        <tr>
            <td></td>
            <td></td>
            <td>
                <ul style="list-style: none outside none;">
                    <li>
                        <span style="color:#07A7E2">{{ $invoice->invoice_code }}</span>
                        @if($lang == 'ar')
                            <span style="font-size:22px; color:#000; font-weight:600;padding:14px 0;"> رقم الفاتورة </span>
                            @else
                            <span style="font-size:22px; color:#000; font-weight:600;padding:14px 0;"> Invoice Number: </span>
                        @endif
                    </li>
                    <li>
                        <span style="color:#07A7E2">{{ $invoice->invoice_date->format('l j F Y h:i A') }}</span>
                        @if($lang == 'ar')
                            <span style="font-size:22px; color:#000; font-weight:600;padding:14px 0;"> تاريخ الفاتورة </span>
                        @else
                            <span style="font-size:22px; color:#000; font-weight:600;padding:14px 0;">Issued Date:</span>
                        @endif
                    </li>
                </ul>
            </td>
        </tr>
        <!--End -->
    </table>
    <!--End Table Header-->

    <!-- Start Price Table -->
    @if($lang == 'ar')
        <table border="0" cellspacing="0" align="center" style="text-align:center;background-color:#fff; min-width:750px;  padding:20px;">
        <thead style="text-align:center">
            <tr>
                <th style="padding:10px; border:1px solid #ddd">وصف</th>
                <th style="border:1px solid #ddd">العدد</th>
                <th style="border:1px solid #ddd">سعر الوحدة</th>
                <th style="border:1px solid #ddd">الحالة</th>
            </tr>
        </thead>
        <tbody style="
          text-align:center">
        @if(!empty($invoice->items))
            @foreach($invoice->items as $item)
                <tr>
                    <td style="padding:10px;border:1px solid #ddd">{{ $item->item_desc_appear_in_invoice }}</td>
                    <td style="border:1px solid #ddd">1</td>
                    <td style="border:1px solid #ddd">{{ $item->price }}</td>
                    <td style="border:1px solid #ddd">
                        @if(($item->status == 2))
                            تمت الموافقة
                        @else
                            قيد الانتظار
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif

        <tr style="margin:30px;
      display:flex;
    justify-content: space-between;
       font-weight:600; font-size:24px;
;
       ">
            <td> <span style="color:#07A7E2"><bdi> {{ $invoice->amount_original }} {{ ($invoice->currency) ? $invoice->currency->name_eng : '' }}</bdi></span></td>
            <td></td>
            <td></td>
            <td>السعر الأساسي</td>
        </tr>

        <tr style="margin:30px;
      display:flex;
    justify-content: space-between;
       font-weight:600; font-size:24px;
;
       ">
            <td> <span style="color:#07A7E2"><bdi> {{ ($invoice->booking_service->promo_code) ? $invoice->booking_service->promo_code->discount_percentage .' %' : '0 %'}}</bdi></span></td>
            <td></td>
            <td></td>
            <td>الخصم</td>
        </tr>

        <tr style="margin:30px;
      display:flex;
    justify-content: space-between;
       font-weight:600; font-size:24px;
;
       ">
            <td> <span style="color:#07A7E2"><bdi> {{ $invoice->amount_after_discount }} {{ ($invoice->currency) ? $invoice->currency->name_eng : '' }}</bdi></span></td>
            <td></td>
            <td></td>
            <td>السعر بعد الخصم</td>
        </tr>

        <tr style="margin:30px;
      display:flex;
    justify-content: space-between;
       font-weight:600; font-size:24px;
;
       ">
            <td> <span style="color:#07A7E2"><bdi> {{ ($invoice->is_saudi_nationality == 1) ? 'معفاة من الضرائب' : config('constants.vat_percentage').' %' }}</bdi></span></td>
            <td></td>
            <td></td>
            <td>الضرائب</td>
        </tr>

        <tr style="margin:30px;
      display:flex;
    justify-content: space-between;
       font-weight:600; font-size:24px;
;
       ">
            <td> <span style="color:#07A7E2"><bdi> {{ $invoice->amount_after_vat }} {{ ($invoice->currency) ? $invoice->currency->name_eng : '' }}</bdi></span></td>
            <td></td>
            <td></td>
            <td> السعر بعد الضرائب</td>
        </tr>

        <tr style="margin:30px;
      display:flex;
    justify-content: space-between;
       font-weight:600; font-size:24px;
;
       ">
            <td> <span style="color:#07A7E2"><bdi> {{ $invoice->amount_final }} {{ ($invoice->currency) ? $invoice->currency->name_eng : '' }}</bdi></span></td>
            <td></td>
            <td></td>
            <td>السعر النهائي</td>
        </tr>

        </tbody>
    </table>
    @else
        <table border="0" cellspacing="0" align="center" style="text-align:center;background-color:#fff; min-width:750px;  padding:20px;">
            <thead style="text-align:center">
            <tr>
                <th style="padding:10px; border:1px solid #ddd">Description</th>
                <th style="border:1px solid #ddd">Quantity</th>
                <th style="border:1px solid #ddd">Unit Price</th>
                <th style="border:1px solid #ddd">Status</th>
            </tr>
            </thead>
            <tbody style="
          text-align:center">
            @if(!empty($invoice->items))
                @foreach($invoice->items as $item)
                    <tr>
                        <td style="padding:10px;border:1px solid #ddd">{{ $item->item_desc_appear_in_invoice }}</td>
                        <td style="border:1px solid #ddd">1</td>
                        <td style="border:1px solid #ddd">{{ $item->price }}</td>
                        <td style="border:1px solid #ddd">
                            @if(($item->status == 2))
                                Approved
                            @else
                                Pending
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif

            <tr style="margin:30px;
      display:flex;
    justify-content: space-between;
       font-weight:600; font-size:24px;
;
       ">
                <td> <span style="color:#07A7E2"><bdi> {{ $invoice->amount_original }} {{ ($invoice->currency) ? $invoice->currency->name_eng : '' }}</bdi></span></td>
                <td></td>
                <td></td>
                <td>Original Amount:</td>
            </tr>

            <tr style="margin:30px;
      display:flex;
    justify-content: space-between;
       font-weight:600; font-size:24px;
;
       ">
                <td> <span style="color:#07A7E2"><bdi> {{ ($invoice->booking_service->promo_code) ? $invoice->booking_service->promo_code->discount_percentage .' %' : '0 %'}}</bdi></span></td>
                <td></td>
                <td></td>
                <td>Discount:</td>
            </tr>

            <tr style="margin:30px;
      display:flex;
    justify-content: space-between;
       font-weight:600; font-size:24px;
;
       ">
                <td> <span style="color:#07A7E2"><bdi> {{ $invoice->amount_after_discount }} {{ ($invoice->currency) ? $invoice->currency->name_eng : '' }}</bdi></span></td>
                <td></td>
                <td></td>
                <td>Amount After Discount</td>
            </tr>

            <tr style="margin:30px;
      display:flex;
    justify-content: space-between;
       font-weight:600; font-size:24px;
;
       ">
                <td> <span style="color:#07A7E2"><bdi> {{ ($invoice->is_saudi_nationality == 1) ? 'معفاة من الضرائب' : config('constants.vat_percentage').' %' }}</bdi></span></td>
                <td></td>
                <td></td>
                <td>Tax:</td>
            </tr>

            <tr style="margin:30px;
      display:flex;
    justify-content: space-between;
       font-weight:600; font-size:24px;
;
       ">
                <td> <span style="color:#07A7E2"><bdi> {{ $invoice->amount_after_vat }} {{ ($invoice->currency) ? $invoice->currency->name_eng : '' }}</bdi></span></td>
                <td></td>
                <td></td>
                <td>Amount After V.A.T:</td>
            </tr>

            <tr style="margin:30px;
      display:flex;
    justify-content: space-between;
       font-weight:600; font-size:24px;
;
       ">
                <td> <span style="color:#07A7E2"><bdi> {{ $invoice->amount_final }} {{ ($invoice->currency) ? $invoice->currency->name_eng : '' }}</bdi></span></td>
                <td></td>
                <td></td>
                <td>Amount Due:</td>
            </tr>

            </tbody>
        </table>
    @endif
    <!-- End Price Table -->
@endsection
