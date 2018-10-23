<?php

namespace App\Http\Controllers\Administrator\Invoices;

use App\Helpers\Utilities;
use App\Http\Controllers\Administrator\BookingServices\BookingServicesController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\AddItemToInvoiceRequest;
use App\Http\Requests\Invoice\DeleteItemFromInvoiceRequest;
use App\Http\Requests\Invoice\PayInvoiceRequest;
use App\Http\Services\Adminstrator\InvoiceModule\ClassesInvoice\InvoiceClass;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItems;
use App\Models\Invoices;
use App\Models\Provider;
use App\Models\PushNotificationsTypes;
use App\Models\Service;
use App\Models\ServiceBooking;
use App\Notifications\AddItemToInvoice;
use App\Notifications\InvoiceGenerated;
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
        $invoicClass = new InvoiceClass();
        $data = [
            'invoice'=>$invoicClass->createNewInvoice($booking),
//            'services_items'=>Service::GetItemsServices()->get()->pluck('name_en','id')
            'services_items'=>Service::GetItemsServices()->get()->pluck('name_en','id')
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
        $invoiceClass = new InvoiceClass();
        $invoice_item = $invoiceClass->saveInvoiceItem($invoice->id,$item->name_en,$item->id,null,config('constants.items.pending'),$item->price);

        if (!$invoice_item){
            session()->flash('error_msg', trans('admin.error_message'));
            return redirect()->back();
        }

//        Now calculate invoice amount
        $invoiceClass = new InvoiceClass();
        $booking = BookingServicesController::getBookingDetails($invoice->booking_service);
        $amount = $invoiceClass->calculateInvoiceServicePrice($invoice->amount_original,$booking['promo_code_percentage'],$booking['vat_percentage'],$item->price);
        $updated_invoice = $invoiceClass->updateInvoiceAmount($invoice,$amount['amount_original'],$amount['amount_after_discount'],$amount['amount_after_vat'],$amount['amount_final']);

//        TODO send notification to customer to approve new item added to invoice
        $payload = PushNotificationsTypes::find(config('constants.pushTypes.addItemToInvoice'));
        $payload->item_id   = $invoice_item->id;
        $payload->send_at   = Carbon::now()->format('Y-m-d H:m:s');
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
        $invoiceClass = new InvoiceClass();
        $booking = BookingServicesController::getBookingDetails($invoice_item->invoice->booking_service);
        $amount = $invoiceClass->calculateInvoiceServicePrice($invoice_item->invoice->amount_original,$booking['promo_code_percentage'],$booking['vat_percentage'],$invoice_item->service->price,'Delete');
        $updated_invoice = $invoiceClass->updateInvoiceAmount($invoice_item->invoice,$amount['amount_original'],$amount['amount_after_discount'],$amount['amount_after_vat'],$amount['amount_final']);

//        Now Delete this item
        $invoice_item->forceDelete();

        session()->flash('success_msg', trans('admin.success_message'));
        return redirect()->route('generate-invoice',['booking'=>$updated_invoice->booking_service->id]);
    }

    /**
     * @param Invoice $invoice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showPayInvoice(Invoice $invoice)
    {
        if ($this->checkInvoiceItemsStatus($invoice)){
            session()->flash('error_msg', trans('admin.invoice_items_pending'));
            return redirect()->route('generate-invoice',['booking'=>$invoice->booking_service->id]);
        }

        $data = [
            'form_data'=>$invoice,
            'payment_methods'=>config('constants.payment_methods'),
            'formRoute'=>route('store-pay-invoice'),
            'submitBtn'=>trans('admin.save')
        ];
        return view(AD . '.invoices.form_pay')->with($data);
    }

    /**
     * @param PayInvoiceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePayInvoice(PayInvoiceRequest $request)
    {
//        Now update invoice to be paid
        $invoice = Invoice::findOrFail($request->input('invoice_id'));
        $invoice->update([
           'is_paid'=>1,
           'payment_method'=>$request->input('payment_method'),
           'payment_transaction_number'=>$request->input('payment_transaction_number'),
           'provider_comment'=>$request->input('provider_comment'),
        ]);

        session()->flash('success_msg', trans('admin.success_message'));
        return redirect()->route('generate-invoice',['booking'=>$invoice->booking_service->id]);
    }

    /**
     * @param $invoice
     * @param int $status
     * @return bool
     */
    public function checkInvoiceItemsStatus($invoice,$status=1)
    {
        if (count($invoice->items->where('status',$status))) return true;
        return false;
    }

}
