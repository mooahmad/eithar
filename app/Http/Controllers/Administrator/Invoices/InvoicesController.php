<?php

namespace App\Http\Controllers\Administrator\Invoices;

use App\Helpers\Utilities;
use App\Http\Controllers\Administrator\BookingServices\BookingServicesController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\AddItemToInvoiceRequest;
use App\Http\Requests\Invoice\DeleteItemFromInvoiceRequest;
use App\Http\Requests\Invoice\PayInvoiceRequest;
use App\Http\Services\Adminstrator\InvoiceModule\ClassesInvoice\InvoiceClass;
use App\Listeners\PushNotificationEventListener;
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
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;

class InvoicesController extends Controller
{
    private $amount_original = 0;
    private $amount_after_discount = 0;
    private $amount_after_vat = 0;
    private $amount_final = 0;
    /**
     * InvoicesController constructor.
     */
    public function __construct()
    {
//        $this->middleware('AdminAuth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('invoices.view') || Gate::forUser(auth()->guard('provider-web')->user())->allows('provider_guard.view')) {
            return view(AD . '.invoices.invoice');
        }
        return response()->view('errors.403', [], 403);
    }

    /**
     * @param ServiceBooking $booking
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function generateInvoice(ServiceBooking $booking)
    {
        if (Gate::allows('invoices.view') || Gate::forUser(auth()->guard('provider-web')->user())->allows('provider_guard.view')) {
            $data = [
                'invoice' => $this->createNewInvoice($booking),
                'services_items' => Service::GetItemsServices()->get()->pluck('name_en', 'id'),
            ];
            return view(AD . '.invoices.profile')->with($data);
        }
        return response()->view('errors.403', [], 403);
    }

    /**
     * @param AddItemToInvoiceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addItemToInvoice(AddItemToInvoiceRequest $request)
    {
        $invoice = Invoice::findOrFail($request->input('invoice_id'));
        $item = Service::findOrFail($request->input('service_id'));

//        Save new pending item to invoice
        $invoiceClass = new InvoiceClass();
        $invoice_item = $invoiceClass->saveInvoiceItem($invoice->id, $item->name_en, $item->id, null, config('constants.items.pending'), $item->price);

        if (!$invoice_item) {
            session()->flash('error_msg', trans('admin.error_message'));
            return redirect()->back();
        }

//        Now calculate invoice amount
        $invoiceClass = new InvoiceClass();
        $booking = BookingServicesController::getBookingDetails($invoice->booking_service);


        $check_item = InvoiceItems::where('service_id',$request->input('service_id'))->where('invoice_id',$invoice->id)->first();
        if ($check_item) {
            $quantity = $check_item->quantity + 1;

            if (in_array($booking['promo_code_type'],[0,3,4])){
                $item_details =  (new InvoiceClass())->calculateItemInvoice($quantity,$booking['promo_code_percentage'],$booking['vat_percentage'],$item->price);
                $invoice_item=   InvoiceClass::updateItemsInvoice($check_item,$invoice->id, $item->name_en, $item->id, null, config('constants.items.approved'), $item->price, $quantity,$item_details['discount'],$item_details['tax'],$item_details['tax_percent'],$item_details['discount_percent'],$item_details['final_amount']);
            }else{
                $item_details =  (new InvoiceClass())->calculateItemInvoice($quantity,0,$booking['vat_percentage'],$item->price);
                $invoice_item=   InvoiceClass::updateItemsInvoice($check_item,$invoice->id, $item->name_en, $item->id, null, config('constants.items.approved'), $item->price, $quantity,$item_details['discount'],$item_details['tax'],$item_details['tax_percent'],$item_details['discount_percent'],$item_details['final_amount']);
            }
        } else {
            $invoiceClass = new InvoiceClass();
            $quantity = 1;
            if (in_array($booking['promo_code_type'],[0,3,4])){

                $item_details =  $invoiceClass->calculateItemInvoice($quantity,$booking['promo_code_percentage'],$booking['vat_percentage'],$item->price);
                $invoice_item=  $invoiceClass->saveItemsInvoice($invoice->id, $item->name_en, $item->id, null, config('constants.items.pending'), $item->price,$item_details['discount'],$item_details['tax'],$item_details['discount_percent'],$item_details['tax_percent'],$item_details['final_amount']);

            }else{
                $item_details =  $invoiceClass->calculateItemInvoice($quantity,0,$booking['vat_percentage'],$item->price);
                $invoice_item=  $invoiceClass->saveItemsInvoice($invoice->id, $item->name_en, $item->id, null, config('constants.items.pending'), $item->price,$item_details['discount'],$item_details['tax'],$item_details['discount_percent'],$item_details['tax_percent'],$item_details['final_amount']);
            }
        }


        $invoiceClass = new InvoiceClass();
        $booking = BookingServicesController::getBookingDetails($invoice->booking_service);
        $invoiceSum = $invoice->items->sum('final_amount');
        $amount = $invoiceClass->calculateInvoiceServicePrice($invoiceSum);
        $updated_invoice = $invoiceClass->updateInvoiceAmount($invoice, $amount['amount_original'], $amount['amount_after_discount'], $amount['amount_after_vat'], $amount['amount_final']);

        $customer = $updated_invoice->customer;
        //        TODO send notification to customer to approve new item added to invoice
        $payload = PushNotificationsTypes::find(config('constants.pushTypes.addItemToInvoice'));
        $payload->item_id = $invoice_item->id;
        $payload->send_at = Carbon::now()->format('Y-m-d H:m:s');
        $customer->notify(new AddItemToInvoice($payload));
        PushNotificationEventListener::fireOnModel(config('constants.customer_message_cloud'), $customer);

        session()->flash('success_msg', trans('admin.success_message'));
        return redirect()->route('generate-invoice', ['booking' => $updated_invoice->booking_service->id]);
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
        $amount = $invoiceClass->calculateInvoiceServicePrice($invoice_item->invoice->amount_original, $booking['promo_code_percentage'], $booking['vat_percentage'], $invoice_item->service->price, 'Delete');
        $updated_invoice = $invoiceClass->updateInvoiceAmount($invoice_item->invoice, $amount['amount_original'], $amount['amount_after_discount'], $amount['amount_after_vat'], $amount['amount_final']);

//        Now Delete this item
        $invoice_item->forceDelete();

        session()->flash('success_msg', trans('admin.success_message'));
        return redirect()->route('generate-invoice', ['booking' => $updated_invoice->booking_service->id]);
    }

    /**
     * @param Invoice $invoice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showPayInvoice(Invoice $invoice)
    {
        if (Gate::allows('invoices.view') || Gate::forUser(auth()->guard('provider-web')->user())->allows('provider_guard.view')) {

            if ($this->checkInvoiceItemsStatus($invoice)) {
                session()->flash('error_msg', trans('admin.invoice_items_pending'));
                return redirect()->route('generate-invoice', ['booking' => $invoice->booking_service->id]);
            }

            if ($invoice->is_paid == config('constants.invoice_paid.paid')) {
                session()->flash('success_msg', trans('admin.invoice_paid'));
                return redirect()->route('generate-invoice', ['booking' => $invoice->booking_service->id]);
            }

            $data = [
                'form_data' => $invoice,
                'payment_methods' => config('constants.payment_methods'),
                'formRoute' => route('store-pay-invoice'),
                'submitBtn' => trans('admin.save'),
            ];
            return view(AD . '.invoices.form_pay')->with($data);
        }
        return response()->view('errors.403', [], 403);
    }

    /**
     * @param PayInvoiceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePayInvoice(PayInvoiceRequest $request)
    {
        if (Gate::allows('invoices.update') || Gate::forUser(auth()->guard('provider-web')->user())->allows('provider_guard.view')) {

//        Now update invoice to be paid
            $invoice = Invoice::findOrFail($request->input('invoice_id'));
            $booking = $invoice->booking_service;
            $booking->status = config('constants.bookingStatus.confirmed');
            $booking->status_desc = "finished";
            $booking->save();
            $invoice->update([
                'is_paid' => config('constants.invoice_paid.paid'),
                'payment_method' => $request->input('payment_method'),
                'payment_transaction_number' => $request->input('payment_transaction_number'),
                'provider_comment' => $request->input('provider_comment'),
                'admin_comment' => $request->input('admin_comment'),
            ]);

            session()->flash('success_msg', trans('admin.success_message'));
            return redirect()->route('generate-invoice', ['booking' => $invoice->booking_service->id]);
        }
        return response()->view('errors.403', [], 403);
    }

    /**
     * @param $invoice
     * @param int $status
     * @return bool
     */
    public function checkInvoiceItemsStatus($invoice, $status = 1)
    {
        if (count($invoice->items->where('status', $status))) {
            return true;
        }

        return false;
    }

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

        $quantity = 1;
        $add = new Invoice();
        $add->service_booking_id = $booking->id;
        $add->customer_id = $booking->customer_id;
//        login Provider ID
        if (auth()->guard('provider-web')->user()) {
            $add->provider_id = auth()->guard('provider-web')->user()->id;
        }
        $add->currency_id = $booking->currency_id;

        $add->is_saudi_nationality = $booking->customer->is_saudi_nationality;
        $add->invoice_code = config('constants.invoice_code') . $booking->id;
        $add->admin_comment = $booking->admin_comment;
        $add->save();

        $items = BookingServicesController::getBookingDetails($booking);
        if ($items) {
            $invoiceClass = new InvoiceClass();
//            Calculate amount of this invoice
            if ($items['is_provider']) {
                foreach ($items['provider_id'] as $id => $name) {
                    $item =    $invoiceClass->calculateItemInvoice($quantity,$items['promo_code_percentage'],$items['vat_percentage'],$items['original_amount']);
                    $invoiceClass->saveItemsInvoice($add->id, $name, null, $id, config('constants.items.approved'), $items['original_amount'],$item['discount'],$item['tax'],$item['discount_percent'],$item['tax_percent'],$item['final_amount']);
                }
            }
//            in case customer book package/lap/on time visit
            if ($items['service_id']) {
                foreach ($items['service_id'] as $id => $name) {
                    if (in_array($items['promo_code_type'],[0,3,4])){
                        $item =  $invoiceClass->calculateItemInvoice($quantity,$items['promo_code_percentage'],$items['vat_percentage'],$items['service_price'][$id]);
                        $invoiceClass->saveItemsInvoice($add->id, $name, $id, null, config('constants.items.approved'), $items['service_price'][$id],$item['discount'],$item['tax'],$item['discount_percent'],$item['tax_percent'],$item['final_amount']);
                    }else{
                        $item =  $invoiceClass->calculateItemInvoice($quantity,0,$items['vat_percentage'],$items['service_price'][$id]);
                        $invoiceClass->saveItemsInvoice($add->id, $name, $id, null, config('constants.items.approved'), $items['service_price'][$id],$item['discount'],$item['tax'],$item['discount_percent'],$item['tax_percent'],$item['final_amount']);
                    }
                }
            }
        }

        $invoiceSum = $add->items->sum('final_amount');
        $amount = $this->calculateInvoiceServicePrice($invoiceSum);
        $this->updateInvoiceAmount($add, $amount['amount_original'], $amount['amount_after_discount'], $amount['amount_after_vat'], $amount['amount_final']);

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
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function getInvoicesDatatable(Request $request)
    {
     $from = Carbon::parse($request->get('from_date'))->toDateString();
     $to = Carbon::parse($request->get('to_date'))->toDateString();

        if ($request->get('from_date') || $request->get('to_date')){

           if ($request->get('pay')){
               $items = Invoice::where('invoices.id', '<>', 0)->whereBetween('invoices.invoice_date',[$from,$to])->where('invoices.payment_method',$request->get('pay'));
           }else{
               $items = Invoice::where('invoices.id', '<>', 0)->whereBetween('invoices.invoice_date',[$from,$to]);
           }
       }else{
            if ($request->get('pay')){
            $items = Invoice::where('invoices.id', '<>', 0)->where('invoices.payment_method',$request->get('pay'));
            }else{
                $items = Invoice::where('invoices.id', '<>', 0);
            }
       }

        if (auth()->guard('provider-web')->user()) {
            $items->where('invoices.provider_id', auth()->guard('provider-web')->user()->id);
        }
        $items->leftjoin('customers', 'invoices.customer_id', 'customers.id')
            ->join('currencies', 'invoices.currency_id', 'currencies.id');

        if ($request->get('bill') == 'admin') {
            $items->join('service_bookings', function ($join) {
                $join->on('invoices.service_booking_id', '=', 'service_bookings.id')
                    ->where('service_bookings.service_id', '!=', null);
            });
        } elseif ($request->get('bill') == 'provider') {
            $items->join('service_bookings', function ($join) {
                $join->on('invoices.service_booking_id', '=', 'service_bookings.id')
                    ->where('service_bookings.provider_id', '!=', null)
                    ->where('service_bookings.service_id', null);
            });
        } else {
            $items->join('service_bookings', function ($join) {
                $join->on('invoices.service_booking_id', '=', 'service_bookings.id');
            });
        }
//        }elseif($request->get('bill') == 'admin'){
//            $items->join('service_bookings', 'invoices.service_booking_id', 'service_bookings.id');
//            $items->where('service_bookings.service_id','!=',null);
    //    }
//        else{
//            $items->join('service_bookings','invoices.service_booking_id', 'service_bookings.id');
//        }

//        elseif ($request->get('bill') == 0){
//            $items->where('service_bookings.service_id','!=',null);
//        }
        $items ->select(['invoices.id', 'invoices.service_booking_id', 'invoices.is_paid', 'invoices.amount_original', 'invoices.amount_after_discount', 'invoices.amount_after_vat', 'invoices.invoice_code', 'invoices.invoice_date', 'invoices.amount_final', 'customers.first_name', 'customers.middle_name', 'customers.last_name', 'customers.eithar_id', 'customers.national_id', 'customers.mobile_number', 'currencies.name_eng']);
        $dataTable = DataTables::of($items)
            ->editColumn('full_name', function ($item) {
                return $item->first_name . ' ' . $item->middle_name . ' ' . $item->last_name;
            })
            ->editColumn('invoice_date', function ($item) {
                return Carbon::parse($item->invoice_date)->format('Y-m-d h:i A');
            })
            ->editColumn('amount_original', function ($item) {
                return $item->amount_original . ' ' . $item->name_eng;
            })
            ->editColumn('amount_after_discount', function ($item) {
                return $item->amount_after_discount . ' ' . $item->name_eng;
            })
            ->editColumn('amount_after_vat', function ($item) {
                return $item->amount_after_vat . ' ' . $item->name_eng;
            })
            ->editColumn('amount_final', function ($item) {
                return $item->amount_final . ' ' . $item->name_eng;
            })
//            ->filterColumn('invoice_date', function ($query, $keyword) {
//                $query->whereRaw("DATE_FORMAT(invoices.invoice_date,'%m/%d/%Y') like ?", ["%$keyword%"]);
//            })
            ->addColumn('is_paid', function ($item) {
                if ($item->is_paid == config('constants.invoice_paid.pending')) {
                    return '<span class="label label-warning label-sm text-capitalize">Pending</span>';
                } else {
                    return '<span class="label label-success label-sm text-capitalize">Paid</span>';
                }
            })
            ->addColumn('actions', function ($item) {
                if (Gate::allows('invoices.view') || Gate::forUser(auth()->guard('provider-web')->user())->allows('provider_guard.view')) {
                    if ($item->is_paid == config('constants.invoice_paid.pending')) {
                        $pay_invoice = route('show-pay-invoice', [$item->id]);
                        $URLs[] = ['link' => $pay_invoice, 'icon' => 'money'];
                    }

                    $showURL = route('generate-invoice', [$item->service_booking_id]);
                    $URLs[] = ['link' => $showURL, 'icon' => 'eye', 'color' => 'green'];
                    return View::make('Administrator.widgets.advancedActions', ['URLs' => $URLs]);
                }
            })
            ->rawColumns(['is_paid', 'actions'])
            ->make(true);

        return $dataTable;
    }
}
