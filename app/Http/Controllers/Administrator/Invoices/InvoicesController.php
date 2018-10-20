<?php

namespace App\Http\Controllers\Administrator\Invoices;

use App\Helpers\Utilities;
use App\Http\Controllers\Administrator\BookingServices\BookingServicesController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\AddItemToInvoiceRequest;
use App\Http\Requests\Invoice\DeleteItemFromInvoiceRequest;
use App\Http\Requests\Invoice\PayInvoiceRequest;
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
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;

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
    public function index()
    {
        if (Gate::denies('invoices.view',new ServiceBooking())){
            return response()->view('errors.403',[],403);
        }
        return view(AD . '.invoices.index');
    }

    /**
     * @param ServiceBooking $booking
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function generateInvoice(ServiceBooking $booking)
    {
        $data = [
            'invoice'=>$this->createNewInvoice($booking),
            'services_items'=>Service::GetItemsServices()->get()->pluck('name_en','id')
        ];
        return view(AD . '.invoices.profile')->with($data);
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
        $invoice_item = $this->saveInvoiceItem($invoice->id,$item->name_en,$item->id,null,config('constants.items.pending'),$item->price);

        if (!$invoice_item){
            session()->flash('error_msg', trans('admin.error_message'));
            return redirect()->back();
        }

//        Now calculate invoice amount
        $booking = BookingServicesController::getBookingDetails($invoice->booking_service);
        $amount = $this->calculateInvoiceServicePrice($invoice->amount_original,$booking['promo_code_percentage'],$booking['vat_percentage'],$item->price);
        $updated_invoice = $this->updateInvoiceAmount($invoice,$amount['amount_original'],$amount['amount_after_discount'],$amount['amount_after_vat'],$amount['amount_final']);

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
        $booking = BookingServicesController::getBookingDetails($invoice_item->invoice->booking_service);
        $amount = $this->calculateInvoiceServicePrice($invoice_item->invoice->amount_original,$booking['promo_code_percentage'],$booking['vat_percentage'],$invoice_item->service->price,'Delete');
        $updated_invoice = $this->updateInvoiceAmount($invoice_item->invoice,$amount['amount_original'],$amount['amount_after_discount'],$amount['amount_after_vat'],$amount['amount_final']);

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

        $add->is_saudi_nationality = $booking->customer->is_saudi_nationality;
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
                    $this->saveInvoiceItem($add->id,$name,null,$id,config('constants.items.approved'),$items['original_amount']);
                }
            }

//            in case customer book package/lap/on time visit
            if ($items['service_id']){
                foreach ($items['service_id'] as $id=>$name){
                    $this->saveInvoiceItem($add->id,$name,$id,null,config('constants.items.approved'),$items['service_price'][$id]);
                }
            }
        }

        $add->refresh();

//        TODO send notification to customer that Admin generate new invoice
        $payload = PushNotificationsTypes::find(config('constants.pushTypes.invoiceGenerated'));
        $payload->invoice_id   = $add->id;
        $payload->send_at      = Carbon::now()->format('Y-m-d H:m:s');
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
    public function saveInvoiceItem($invoice_id,$service_name,$service_id=null,$provider_id=null,$status=1 ,$price)
    {
        if (!$invoice_id) return null;
        return InvoiceItems::updateOrCreate([
            'invoice_id'=>$invoice_id,
            'item_desc_appear_in_invoice'=>$service_name,
            'service_id'=>$service_id,
            'provider_id'=>$provider_id,
            'status'=>$status,
            'price'=>$price,
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
            $this->amount_original   = $this->amount_original + $item_price;
        }

        if ($operation == 'Delete'){
//            When Delete new item to invoice
            $this->amount_original   = $this->amount_original - $item_price;
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

    public function getInvoicesDatatable(Request $request)
    {
        $items = Invoice::where('invoices.id', '<>', 0)
            ->leftjoin('customers','invoices.customer_id','customers.id')
            ->join('currencies','invoices.currency_id','currencies.id')
            ->select(['invoices.id','invoices.service_booking_id','invoices.is_paid','invoices.amount_original','invoices.amount_after_discount','invoices.amount_after_vat','invoices.invoice_code','invoices.invoice_date','invoices.amount_final','customers.first_name','customers.middle_name','customers.last_name','customers.eithar_id','customers.national_id','customers.mobile_number','currencies.name_eng']);
        $dataTable = DataTables::of($items)
            ->editColumn('full_name',function ($item){
                return $item->first_name .' '. $item->middle_name .' '. $item->last_name;
            })
            ->editColumn('invoice_date',function ($item){
                return $item->invoice_date->format('Y-m-d h:i A');
            })
            ->editColumn('amount_original',function ($item){
                return $item->amount_original .' '.$item->name_eng;
            })
            ->editColumn('amount_after_discount',function ($item){
                return $item->amount_after_discount .' '.$item->name_eng;
            })
            ->editColumn('amount_after_vat',function ($item){
                return $item->amount_after_vat .' '.$item->name_eng;
            })
            ->editColumn('amount_final',function ($item){
                return $item->amount_final .' '.$item->name_eng;
            })
            ->filterColumn('invoice_date', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(invoices.invoice_date,'%m/%d/%Y') like ?", ["%$keyword%"]);
            })
            ->addColumn('status',function ($item){
                if($item->is_paid==0){
                    return '<span class="label label-warning label-sm text-capitalize">Pending</span>';
                }else{
                    return '<span class="label label-success label-sm text-capitalize">Paid</span>';
                }
            })
            ->addColumn('actions', function ($item) {
                $showURL = route('generate-invoice',[$item->service_booking_id]);
                $URLs = [
                    ['link'=>$showURL,'icon'=>'eye','color'=>'green'],
                ];
                if (Gate::allows('invoices.view')){
                    $pay_invoice = route('show-pay-invoice',[$item->id]);
                    $URLs[] = ['link'=>$pay_invoice,'icon'=>'money','color'=>'green'];
                }
                return View::make('Administrator.widgets.advancedActions', ['URLs'=>$URLs]);
            })
            ->rawColumns(['status','actions'])
            ->make(true);

        return $dataTable;
    }
}
