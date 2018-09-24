<?php

namespace App\Http\Controllers\Administrator\Invoices;

use App\Http\Controllers\Administrator\BookingServices\BookingServicesController;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Invoices;
use App\Models\Provider;
use App\Models\Service;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class InvoicesController extends Controller
{
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
        return BookingServicesController::getBookingDetails($booking);
//        check if this meeting has generated invoice
        if (!$booking->invoice){
//            Now Generate new invoice for this meeting
            return $this->createNewInvoice($booking);
        }
        $data = [
            'booking'=>$booking
        ];
        return view(AD . '.invoices.index')->with($data);
        return $booking->invoice;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        check user credentials
        if (Gate::denies('invoices.create')){
            return response()->view('errors.403',[],403);
        }
        $data = [
            'items'=>Service::GetItemsServices()->get()->pluck('name_en','id'),
            'selected_items'=>'',
            'customers'=>Customer::GetActiveCustomers()->get()->pluck('full_name','id'),
            'providers'=>Provider::GetActiveProviders()->get()->pluck('full_name','id'),
            'formRoute' => route('promo_codes.store'),
            'required'=>'required',
            'submitBtn' => trans('admin.create')
        ];
        return view(AD . '.invoices.form')->with($data);

    }

    public function createNewInvoice($booking)
    {
        if (!$booking) return null;
        return auth()->user()->id;

        $add = new Invoice();
        $add->service_booking_id   = $booking->id;
        $add->customer_id          = $booking->customer_id;
//        login Provider ID
        $add->provider_id          = auth()->user()->id;
        $add->currency_id          = $booking->currency_id;

//        $add->amount_original      = $booking->id;
//        $add->amount_after_discount= $booking->id;
//        $add->amount_after_vat     = $booking->id;
//        $add->amount_final         = $booking->price;
//        $add->payment_method       = $booking->id;
//        $add->payment_transaction_number = $booking->id;
//        $add->provider_comment     = $booking->comment;

        $add->is_saudi_nationality = $booking->customer->is_saudi_nationality;
        $add->invoice_code         = config('constants.invoice_code').$booking->id;
        $add->admin_comment        = $booking->admin_comment;
        $add->save();
        return $add;

    }

    public function addItemsToInvoice($invoice)
    {
        if (!$invoice) return null;

        $promo_code = $invoice->booking_service->promo_code;
//        calcPercentage

    }
}
