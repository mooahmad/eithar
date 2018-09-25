<?php

namespace App\Http\Controllers\Administrator\Invoices;

use App\Helpers\Utilities;
use App\Http\Controllers\Administrator\BookingServices\BookingServicesController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\AddItemToInvoiceRequest;
use App\Http\Requests\Invoice\DeleteItemFromInvoiceRequest;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItems;
use App\Models\Invoices;
use App\Models\Provider;
use App\Models\PushNotificationsTypes;
use App\Models\Service;
use App\Models\ServiceBooking;
use App\Notifications\AddItemToInvoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class InvoicesController extends Controller
{
    private $amount_original =0;
    private $amount_after_discount =0;
    private $amount_after_vat =0;
    private $amount_final =0;
    /**
     * InvoicesController constructor.
     */
    public function __construct()
    {
        $this->middleware('AdminAuth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ServiceBooking $booking)
    {
        $data = [
            'invoice'=>$this->createNewInvoice($booking),
//            'services_items'=>Service::GetItemsServices()->get()->pluck('name_en','id')
            'services_items'=>Service::get()->pluck('name_en','id')
        ];
//        return $data['invoice']->items;
        return view(AD . '.invoices.index')->with($data);
    }

    /**
     * @param AddItemToInvoiceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addItemToInvoice(AddItemToInvoiceRequest $request)
    {
        $invoice = Invoice::findOrFail($request->input('invoice_id'));
        $item    = Service::findOrFail($request->input('service_id'));

//        Save new pending item to invoice
        $this->saveInvoiceItem($invoice->id,$item->name_en,$item->id);

//        Now calculate invoice amount
        $booking = BookingServicesController::getBookingDetails($invoice->booking_service);
        $amount = $this->calculateInvoiceServicePrice($invoice->amount_original,$booking['promo_code_percentage'],$booking['vat_percentage'],$item->price);
        $updated_invoice = $this->updateInvoiceAmount($invoice,$amount['amount_original'],$amount['amount_after_discount'],$amount['amount_after_vat'],$amount['amount_final']);

//        TODO send notification to customer to approve new item added to invoice
        $payload = PushNotificationsTypes::find(config('constants.pushTypes.addItemToInvoice'));
        $payload->invoice_id = $updated_invoice->id;
        $payload->send_at    = Carbon::now();
        $updated_invoice->customer->notify(new AddItemToInvoice($payload));

        session()->flash('success_msg', trans('admin.success_message'));
        return redirect()->route('generate-invoice',['booking'=>$updated_invoice->booking_service->id]);
    }

    /**
     * @param DeleteItemFromInvoiceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteItemToInvoice(DeleteItemFromInvoiceRequest $request)
    {
        $invoice_item = InvoiceItems::findOrFail($request->input('invoice_item_id'));

//        Now calculate invoice amount
        $booking = BookingServicesController::getBookingDetails($invoice_item->invoice->booking_service);
        $amount = $this->calculateInvoiceServicePrice($invoice_item->invoice->amount_original,$booking['promo_code_percentage'],$booking['vat_percentage'],$invoice_item->service->price,'Delete');
        $updated_invoice = $this->updateInvoiceAmount($invoice_item->invoice,$amount['amount_original'],$amount['amount_after_discount'],$amount['amount_after_vat'],$amount['amount_final']);

//        Now Delete this item
        $invoice_item->forceDelete();

        session()->flash('success_msg', trans('admin.success_message'));
        return redirect()->route('generate-invoice',['booking'=>$updated_invoice->booking_service->id]);
    }

    /**
     * @param $booking
     * @return Invoice|null
     */
    public function createNewInvoice($booking)
    {
//        check if empty booking details
        if (!$booking) return null;
//        check if booking has generated invoice
        if (!empty($booking->invoice)) return $booking->invoice;

        $add = new Invoice();
        $add->service_booking_id   = $booking->id;
        $add->customer_id          = $booking->customer_id;
//        login Provider ID
        $add->provider_id          = auth()->user()->id;
        $add->currency_id          = $booking->currency_id;

//        $add->payment_method       = $booking->id;
//        $add->payment_transaction_number = $booking->id;
//        $add->provider_comment     = $booking->comment;

        $add->is_saudi_nationality = $booking->customer->is_saudi_nationality;
//        $add->invoice_date         = '';
        $add->invoice_code         = config('constants.invoice_code').$booking->id;
        $add->admin_comment        = $booking->admin_comment;
        $add->save();

        $items = BookingServicesController::getBookingDetails($booking);
        if ($items){
//            Calculate amount of this invoice
            if ($items['original_amount']){
                $amount = $this->calculateInvoiceServicePrice($items['original_amount'],$items['promo_code_percentage'],$items['vat_percentage']);
                if (!empty($amount)){
                    $this->updateInvoiceAmount($add,$amount['amount_original'],$amount['amount_after_discount'],$amount['amount_after_vat'],$amount['amount_final']);
                }
            }

//            in case customer book provider
            if ($items['is_provider']){
                foreach ($items['provider_id'] as $id=>$name){
                    $this->saveInvoiceItem($add->id,$name,null,$id,2);
                }
            }

//            in case customer book package/lap/on time visit
            if ($items['service_id']){
                foreach ($items['service_id'] as $id=>$name){
                    $this->saveInvoiceItem($add->id,$name,$id,null,2);
                }
            }
        }
        return $add->refresh();
    }

    /**
     * @param $invoice_id
     * @param $service_name
     * @param null $service_id
     * @param null $provider_id
     * @param int $status
     * @return bool|null
     */
    public function saveInvoiceItem($invoice_id,$service_name,$service_id=null,$provider_id=null,$status=1)
    {
        if (!$invoice_id) return null;
        return InvoiceItems::updateOrCreate([
            'invoice_id'=>$invoice_id,
            'item_desc_appear_in_invoice'=>$service_name,
            'service_id'=>$service_id,
            'provider_id'=>$provider_id,
            'status'=>$status,
        ]);
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
    public function calculateInvoiceServicePrice($amount_original,$discount=0,$vat=0,$item_price=0,$operation='Add')
    {
        $this->amount_original       = $amount_original;

        if ($operation == 'Add'){
//            When Add new item to invoice
            $this->amount_original       = $this->amount_original + $item_price;
        }

        if ($operation == 'Delete'){
//            When Delete new item to invoice
            $this->amount_original       = $this->amount_original - $item_price;
        }

        $this->amount_after_discount = $this->amount_original;
        $this->amount_after_vat      = $this->amount_original;
        $this->amount_final          = $this->amount_original;
        if ($amount_original>0){
            if ($discount>0){
                $this->amount_after_discount = $this->amount_original - Utilities::calcPercentage($this->amount_original,$discount);
                $this->amount_after_vat      = $this->amount_after_discount;
                $this->amount_final          = $this->amount_after_discount;
            }
            if ($vat>0){
                $this->amount_after_vat = $this->amount_after_discount + Utilities::calcPercentage($this->amount_after_discount,$vat);
                $this->amount_final     = $this->amount_after_vat;
            }
        }
        return $data = [
            'amount_original'=>$this->amount_original,
            'amount_after_discount'=>$this->amount_after_discount,
            'amount_after_vat'=>$this->amount_after_vat,
            'amount_final'=>$this->amount_final,
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
    public function updateInvoiceAmount($invoice,$amount_original,$amount_after_discount,$amount_after_vat,$amount_final)
    {
        if (empty($invoice)) return null;

        $invoice->update([
            'amount_original'       => $amount_original,
            'amount_after_discount' => $amount_after_discount,
            'amount_after_vat'      => $amount_after_vat,
            'amount_final'          => $amount_final,
        ]);
        return $invoice;
    }
}
