<?php

namespace App\Http\Controllers\Administrator\BookingServices;

use App\Helpers\Utilities;
use App\Http\Controllers\Controller;
use App\Models\LapCalendar;
use App\Models\Customer;
use App\Models\MedicalReports;
use App\Models\Provider;
use App\Models\ProvidersCalendar;
use App\Models\PushNotificationsTypes;
use App\Models\ServiceBooking;
use App\Models\ServicesCalendar;
use App\Notifications\AssignProviderToMeeting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;

class BookingServicesController extends Controller
{
    /**
     * BookingServicesController constructor.
     */
    public function __construct()
    {
//        $this->middleware(['ProviderAuth','AdminAuth']);
    }

    public function index(Request $request)
    {
        if (Gate::allows('meetings.view',new ServiceBooking()) || Gate::forUser(auth()->guard('provider-web')->user())->allows('provider_guard.view')){
            return view(AD.'.meetings.index');
        }
        return response()->view('errors.403',[],403);
    }

    /**
     * @param ServiceBooking $booking
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(ServiceBooking $booking)
    {
        if (Gate::allows('meetings.view',new ServiceBooking()) || Gate::forUser(auth()->guard('provider-web')->user())->allows('provider_guard.view')){
            $data = [
                'booking'=>$booking,
                'booking_details'=>$this->getBookingDetails($booking),
                'providers'=>Provider::GetActiveProviders()
                    ->GetServiceProviders()->get()->pluck('full_name','id')
            ];
            return view(AD.'.meetings.show')->with($data);
        }
        return response()->view('errors.403',[],403);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function getBookingServicesDataTable(Request $request)
    {
        $items = ServiceBooking::where('service_bookings.id', '<>', 0);
        if (auth()->guard('provider-web')->user()){
            $items->where('service_bookings.provider_id_assigned_by_admin',auth()->guard('provider-web')->user()->id)
                ->orWhere('service_bookings.provider_id',auth()->guard('provider-web')->user()->id);
        }
        $items->leftjoin('services','service_bookings.service_id','services.id')
            ->join('customers','service_bookings.customer_id','customers.id')
            ->join('currencies','service_bookings.currency_id','currencies.id')
            ->select(['service_bookings.id','service_bookings.status', 'service_bookings.unlock_request','service_bookings.price','service_bookings.status_desc','service_bookings.created_at','services.name_en','customers.first_name','customers.middle_name','customers.last_name','customers.eithar_id','customers.national_id','customers.mobile_number','currencies.name_eng']);
        $dataTable = DataTables::of($items)
            ->editColumn('name_en',function ($item){
                return ($item->name_en) ? $item->name_en : 'Lab Service';
            })
            ->editColumn('full_name',function ($item){
                return $item->first_name .' '. $item->middle_name .' '. $item->last_name;
            })
            ->editColumn('created_at',function ($item){
                return $item->created_at->format('Y-m-d h:i A');
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(service_bookings.created_at,'%m/%d/%Y') like ?", ["%$keyword%"]);
            })
            ->addColumn('status',function ($item){
                $status_type = 'warning';
                if($item->status==2){$status_type= 'success';}
                if($item->status==3){$status_type= 'danger';}
                return '<span class="label label-'.$status_type.' label-sm text-capitalize">'.$item->status_desc.'</span>';
            })
            ->editColumn('price',function ($item){
                return $item->price .' '.$item->name_eng;
            })
            ->addColumn('actions', function ($item) {
                $showURL = route('show-meeting-details',[ "id" => $item->id]);
                $URLs = [
                    ['link'=>$showURL,'icon'=>'eye','color'=>'green'],
                ];
                if($item->unlock_request == 1){
                    $unlockURL =route('approve-unlock',[$item->id]);
                    $URLs[] = ['link'=>$unlockURL,'icon'=>'check','color'=>'red'];
                }
                if (Gate::allows('medical_report.view',new MedicalReports()) || Gate::forUser(auth()->guard('provider-web')->user())->allows('provider_guard.view')){
                    $medicalReportsURL = route('showMeetingReport',[$item->id]);
                    $addMedicalReportURL = route('createMeetingReport',[$item->id]);
                    $URLs[] = ['link'=>$medicalReportsURL,'icon'=>'list'];
                    $URLs[] = ['link'=>$addMedicalReportURL,'icon'=>'plus','color'=>'blue'];
                }
                return View::make('Administrator.widgets.advancedActions', ['URLs'=>$URLs]);
            })
            ->rawColumns(['status','actions'])
            ->make(true);

        return $dataTable;
    }

    /**
     * @param $booking
     * @return array|null
     */
    public static function getBookingDetails($booking){
        if (!$booking) return null;

        $booking_details = [
            'id'=>$booking->id,
            'service_name'=>'',
            'service_id'=>'',
            'service_price'=>0,
            'is_provider'=>false,
            'provider_id'=>'',
            'original_amount'=>'',
            'promo_code_percentage'=> ($booking->promo_code) ? $booking->promo_code->discount_percentage : 0,
            'vat_percentage'=> ($booking->customer->is_saudi_nationality !=1) ? config('constants.vat_percentage') : 0,
            'start_date'=>'',
            'end_date'=>'',
            'price'=>$booking->price,
            'currency'=>$booking->currency->name_eng,
        ];
        $service = $booking->service()->withTrashed()->first();
//        in case Provider
        if (empty($booking->service_id) && !empty($booking->provider_id)  && $booking->is_lap == 0){
            $provider_calendar = ProvidersCalendar::find($booking->service_appointments->first()->slot_id);
            $booking_details['service_name']    = $booking->provider->full_name;
            $booking_details['provider_id']     = [$booking->provider->id => $booking->provider->full_name];
            $booking_details['is_provider']     = true;
            $booking_details['original_amount'] = $booking->provider->price;
            $booking_details['start_date']      = Carbon::parse($provider_calendar->start_date)->format('Y-m-d h:i A');
            $booking_details['end_date']        = Carbon::parse($provider_calendar->end_date)->format('Y-m-d h:i A');
        }

//        in case Lap Service
        if (empty($service) && $booking->is_lap==1){
            $lap_calendar = LapCalendar::findOrFail($booking->service_appointments->first()->slot_id);
            $lap_services = $booking->load('booking_lap_services.service')->booking_lap_services;
            $total_amount = 0;
            foreach ($lap_services as $key=>$lap_service){
                $booking_details['service_name']   .=  ( $key !== count( $lap_services ) -1 ) ? $lap_service->service->name_en .' & ' : $lap_service->service->name_en .' (Lab Service)';
                $total_amount += $lap_service->service->price;
                $services_ids[$lap_service->service->id]   = $lap_service->service->name_en;
                $services_price[$lap_service->service->id] = $lap_service->service->price;
            }
            $booking_details['original_amount'] = $total_amount;
            $booking_details['service_id']      = $services_ids;
            $booking_details['service_price']   = $services_price;
            $booking_details['start_date']      = Carbon::parse($lap_calendar->start_date)->format('Y-m-d h:i A');
            $booking_details['end_date']        = Carbon::parse($lap_calendar->end_date)->format('Y-m-d h:i A');
        }

//        in case one time visit and package
        if (!empty($service) && ($service->type == 1 || $service->type == 2)){
            $package_oneTime_calendar = ServicesCalendar::findOrFail($booking->service_appointments->first()->slot_id);
            $booking_details['service_name']    = $service->name_en .' ('. $service->type_desc.')';
            $booking_details['service_id']      = [$service->id => $service->name_en];
            $booking_details['service_price']   = [$service->id => $service->price];
            $booking_details['original_amount'] = $service->price;
            $booking_details['start_date']      = Carbon::parse($package_oneTime_calendar->start_date)->format('Y-m-d h:i A');
            $booking_details['end_date']        = Carbon::parse($package_oneTime_calendar->end_date)->format('Y-m-d h:i A');

        }
        return $booking_details;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function assignProviderToMeeting(Request $request){
        if (Gate::denies('meetings.view',new ServiceBooking())){
            return response()->view('errors.403',[],403);
        }
        $validator = Validator::make($request->all(), ['provider_id' => 'required|integer|min:1',]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->booking){
            $booking = ServiceBooking::findOrFail($request->booking);
            $booking->update(['provider_id_assigned_by_admin'=>$request->input('provider_id')]);
//            TODO send notification to customer that Admin generate new invoice
            $payload = PushNotificationsTypes::find(config('constants.pushTypes.assignProviderToMeeting'));
            $payload->booking_id   = $booking->id;
            $payload->language     = ($booking->customer->default_language) ? $booking->customer->default_language : 'en';
            $payload->send_at      = Carbon::now()->format('Y-m-d H:m:s');
            return $booking->assigned_provider->notify(new AssignProviderToMeeting($payload));
        }
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/meetings/'.$request->booking);
    }

    public function approveUnlock(Request $request, $bookingId)
    {
        $booking = ServiceBooking::findOrFail($bookingId);
        $booking->unlock_request = 0;
        $booking->is_locked = 0;
        $booking->save();
        return redirect()->route("meetings");
    }
}