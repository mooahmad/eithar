<?php

namespace App\Http\Services\Adminstrator\InvoiceModule\ClassesInvoice;

use App\Helpers\Utilities;
use App\Http\Controllers\Administrator\BookingServices\BookingServicesController;
use App\Models\Invoice;
use App\Models\InvoiceItems;
use App\Models\PushNotificationsTypes;
use App\Notifications\InvoiceGenerated;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class InvoiceClass
{

    /**
     * @param $booking
     * @return Invoice|null
     */
    public function createNewInvoice($booking)
    {
//        check if empty booking details
        if (!$booking) {
            return null;
        }

//        check if booking has generated invoice
        if (!empty($booking->invoice)) {
            return $booking->invoice;
        }
        
        $add = new Invoice();
        $add->service_booking_id = $booking->id;
        $add->customer_id = $booking->customer_id;
//        login Provider ID
        $add->provider_id = Auth::id();
        $add->currency_id = $booking->currency_id;

        $add->is_saudi_nationality = $booking->customer->is_saudi_nationality;
        $add->invoice_code = config('constants.invoice_code') . $booking->id;
        $add->admin_comment = $booking->admin_comment;
        $add->save();

        $items = BookingServicesController::getBookingDetails($booking);
        if ($items) {
//            Calculate amount of this invoice
            if ($items['original_amount']) {
                $amount = $this->calculateInvoiceServicePrice($items['original_amount'], $items['promo_code_percentage'], $items['vat_percentage']);
                if (!empty($amount)) {
                    $this->updateInvoiceAmount($add, $amount['amount_original'], $amount['amount_after_discount'], $amount['amount_after_vat'], $amount['amount_final']);
                }
            }

//            in case customer book provider
            if ($items['is_provider']) {
                foreach ($items['provider_id'] as $id => $name) {
                    $this->saveInvoiceItem($add->id, $name, null, $id, config('constants.items.approved'), $items['original_amount']);
                }
            }

//            in case customer book package/lap/on time visit
            if ($items['service_id']) {
                foreach ($items['service_id'] as $id => $name) {
                    $this->saveInvoiceItem($add->id, $name, $id, null, config('constants.items.approved'), $items['service_price'][$id]);
                }
            }

        }

        $add->refresh();
        $bookingService = $booking->service;
        $serviceType = null;
        if (empty($booking->service_id) && !empty($booking->provider_id) && $booking->is_lap == 0) {
            $serviceType = 5;
        } else if (!empty($bookingService) && ($bookingService->type == 1 || $bookingService->type == 2)) {
            $serviceType = $bookingService->type;
        } else if (empty($bookingService->service) && $booking->is_lap == 1) {
            $serviceType = 4;
        }

        //        TODO send notification to customer that Admin generate new invoice
        $payload = PushNotificationsTypes::find(config('constants.pushTypes.invoiceGenerated'));
        $payload->invoice_id = $add->id;
        $payload->service_type = $serviceType;
        $payload->send_at = Carbon::now()->format('Y-m-d H:m:s');
        $add->customer->notify(new InvoiceGenerated($payload));

        return $add;
    }

    /**
     * @param $amount_original
     * @param int $discount
     * @param int $vat
     * @param int $item_price
     * @param string $operation
     * @return array
     *
     * Use Add Or Delete Text when add/delete item from invoice
     */
    public function calculateInvoiceServicePrice($amount_original, $discount = 0, $vat = 0, $item_price = 0, $operation = 'Add')
    {
        $this->amount_original = $amount_original;

        if ($operation == 'Add') {
//            When Add new item to invoice
            $this->amount_original = $this->amount_original + $item_price;
        }

        if ($operation == 'Delete') {
//            When Delete new item to invoice
            $this->amount_original = $this->amount_original - $item_price;
        }

        $this->amount_after_discount = $this->amount_original;
        $this->amount_after_vat = $this->amount_original;
        $this->amount_final = $this->amount_original;
        if ($amount_original > 0) {
            if ($discount > 0) {
                $this->amount_after_discount = $this->amount_original - Utilities::calcPercentage($this->amount_original, $discount);
                $this->amount_after_vat = $this->amount_after_discount;
                $this->amount_final = $this->amount_after_discount;
            }
            if ($vat > 0) {
                $this->amount_after_vat = $this->amount_after_discount + Utilities::calcPercentage($this->amount_after_discount, $vat);
                $this->amount_final = $this->amount_after_vat;
            }
        }
        return $data = [
            'amount_original' => $this->amount_original,
            'amount_after_discount' => $this->amount_after_discount,
            'amount_after_vat' => $this->amount_after_vat,
            'amount_final' => $this->amount_final,
        ];
    }

    /**
     * @param $invoice
     * @param $amount_original
     * @param $amount_after_discount
     * @param $amount_after_vat
     * @param $amount_final
     * @return null
     */
    public function updateInvoiceAmount($invoice, $amount_original, $amount_after_discount, $amount_after_vat, $amount_final)
    {
        if (empty($invoice)) {
            return null;
        }

        $invoice->update([
            'amount_original' => $amount_original,
            'amount_after_discount' => $amount_after_discount,
            'amount_after_vat' => $amount_after_vat,
            'amount_final' => $amount_final,
        ]);
        return $invoice;
    }

    /**
     * @param $invoice_id
     * @param $service_name
     * @param null $service_id
     * @param null $provider_id
     * @param int $status
     * @param $price
     * @return null
     */
    public function saveInvoiceItem($invoice_id, $service_name, $service_id = null, $provider_id = null, $status = 1, $price)
    {
        if (!$invoice_id) {
            return null;
        }

        return InvoiceItems::updateOrCreate([
            'invoice_id' => $invoice_id,
            'item_desc_appear_in_invoice' => $service_name,
            'service_id' => $service_id,
            'provider_id' => $provider_id,
            'status' => $status,
            'price' => $price,
        ]);
    }

}
