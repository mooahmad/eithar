<?php

namespace App\Http\Services\WebApi\PromoCodesModule\AbstractPromoCodes;


use App\Helpers\Utilities;
use App\Http\Controllers\Administrator\BookingServices\BookingServicesController;
use App\Http\Services\Adminstrator\InvoiceModule\ClassesInvoice\InvoiceClass;
use App\Http\Services\WebApi\PromoCodesModule\IPromoCodes\IPromoCode;
use App\Models\Invoice;
use App\Models\InvoiceItems;
use App\Models\PromoCode;
use App\Models\Service;
use App\Models\ServiceBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class PromoCodes implements IPromoCode
{

    public function registerPromoCode(Request $request, $from = null)
    {
        $promoCode = $request->input('promocode');
        $serviceId = $request->input('serviceid');
        $total_price = $request->input('total_price');
        $now = Carbon::now()->format('Y-m-d H:m:s');
        $promoCode = PromoCode::where([['code', "$promoCode"], ['is_approved', 1]])
            ->where([['start_date', '<=', $now], ['end_date', '>', $now]])
            ->first();
        if (!$promoCode)
            return Utilities::getValidationError(config('constants.responseStatus.operationFailed'),
                new MessageBag([
                    "message" => "code not found"
                ]));
        $service_type = '';
        $invoice_items = [];
        if ($serviceId == 0) {
            $service_type = 4;
        } else {
            if ($from['provider'] == 'Provider') {
                //$invoice_item = InvoiceItems::find($serviceId);
//               if ($invoice_item){
//                   if ($invoice_item->provider){
//                       $service_type = 5;
//                   }
//                   else{
//                       $service_type = $invoice_item->service->type;
//                   }
//               }

                if ($promoCode->type == 5) {
                    $service_type = 5;
                } elseif ($promoCode->type == 3) {
                    $service_type = 3;
                } elseif ($promoCode == 0) {
                    $service_type = 0;
                }
            } else {
                $service_type = Service::find($serviceId)->type;
            }
        }
        if (!$service_type)
            return Utilities::getValidationError(config('constants.responseStatus.operationFailed'),
                new MessageBag([
                    "message" => "service not found"
                ]));
        if ($promoCode->type == 0 || $service_type == $promoCode->type) {
            if (!empty($from['booking_id'])) {
                $booking = ServiceBooking::find($from['booking_id']);
                $bookingDetails = BookingServicesController::getBookingDetails($booking);
                $invoice = $booking->invoice;
                $invoice_items = InvoiceItems::where('invoice_id', $invoice->id)->get();
                if ($booking->promo_code){
                    return Utilities::getValidationError(config('constants.responseStatus.operationFailed'),
                        new MessageBag([
                            "message" => "Sorry , there is a promo code entered once"
                        ]));
                }else{
                    if ($service_type == 0) {
                        foreach ($invoice_items as $invoice_item) {
                            $item_details = (new InvoiceClass())->calculateItemInvoice($invoice_item->quantity, $promoCode->discount_percentage, $bookingDetails['vat_percentage'], $invoice_item->price);
                            if ($invoice_item->service) {
                                $saveItem = InvoiceClass::updateItemsInvoice($invoice_item, $invoice->id, $invoice_item->item_desc_appear_in_invoice, $invoice_item->service_id, null, config('constants.items.approved'), $invoice_item->price, $invoice_item->quantity, $item_details['discount'], $item_details['tax'], $item_details['tax_percent'], $item_details['discount_percent'], $item_details['final_amount']);
                            } elseif ($invoice_item->provider) {
                                InvoiceClass::updateItemsInvoice($invoice_item, $invoice->id, $invoice_item->item_desc_appear_in_invoice, null, $invoice_item->provider_id, config('constants.items.approved'), $invoice_item->price, $invoice_item->quantity, $item_details['discount'], $item_details['tax'], $item_details['tax_percent'], $item_details['discount_percent'], $item_details['final_amount']);
                            }
                        }
                    } elseif ($service_type == 5) {
                        foreach ($invoice_items as $invoice_item) {
                            $item_details = (new InvoiceClass())->calculateItemInvoice($invoice_item->quantity, $promoCode->discount_percentage, $bookingDetails['vat_percentage'], $invoice_item->price);
                            if ($invoice_item->provider) {
                                InvoiceClass::updateItemsInvoice($invoice_item, $invoice->id, $invoice_item->item_desc_appear_in_invoice, null, $invoice_item->provider_id, config('constants.items.approved'), $invoice_item->price, $invoice_item->quantity, $item_details['discount'], $item_details['tax'], $item_details['tax_percent'], $item_details['discount_percent'], $item_details['final_amount']);
                            }
                        }
                    } elseif ($service_type == 3) {
                        foreach ($invoice_items as $invoice_item) {
                            $item_details = (new InvoiceClass())->calculateItemInvoice($invoice_item->quantity, $promoCode->discount_percentage, $bookingDetails['vat_percentage'], $invoice_item->price);
                            if ($invoice_item->service) {
                                InvoiceClass::updateItemsInvoice($invoice_item, $invoice->id, $invoice_item->item_desc_appear_in_invoice, $invoice_item->service_id, null, config('constants.items.approved'), $invoice_item->price, $invoice_item->quantity, $item_details['discount'], $item_details['tax'], $item_details['tax_percent'], $item_details['discount_percent'], $item_details['final_amount']);
                            }
                        }
                    }

                  if ($invoice){
                      $invoiceClass = new InvoiceClass();
                      $discount = $invoice->items->sum('discount');
                      $tax = $invoice->items->sum('tax');
                      $final = $invoice->items->sum('final_amount');
                      $booking->promo_code_id = $promoCode->id;
                      $booking->save();
                 //     $amount = $invoiceClass->calculateInvoiceServicePrice($in);
                      $invoiceClass->updateInvoiceAmount($invoice, $invoice->amount_original, $discount, $tax, $final);
                  }


                    return Utilities::getValidationError(config('constants.responseStatus.success'),
                        new MessageBag([
                            "total_price" => $invoice->items->sum('final_amount')
                        ]));
                }

            }else {
                return Utilities::getValidationError(config('constants.responseStatus.success'),
                    new MessageBag([
                        "total_price" => $total_price - Utilities::calcPercentage($total_price, $promoCode->discount_percentage)
                    ]));
            }
        }

        return Utilities::getValidationError(config('constants.responseStatus.operationFailed'),
            new MessageBag([
                "message" => "promo code is not valid for this service"
            ]));
    }

}