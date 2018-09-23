<?php

namespace App\Http\Controllers\Administrator\BookingServices;

use App\Helpers\Utilities;
use App\Http\Controllers\Controller;
use App\LapCalendar;
use App\Models\Customer;
use App\Models\Provider;
use App\Models\ProvidersCalendar;
use App\Models\ServiceBooking;
use App\Models\ServicesCalendar;
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
        $this->middleware('AdminAuth');
    }

    public function index(Request $request)
    {
        if (Gate::denies('meetings.view',new ServiceBooking())){
            return response()->view('errors.403',[],403);
        }
        $data = [
            'meeting_type' => $request->segment(3)
        ];
        return view(AD.'.meetings.index')->with($data);
    }

    /**
     * @param ServiceBooking $booking
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(ServiceBooking $booking)
    {
        if (Gate::denies('meetings.view',new ServiceBooking())){
            return response()->view('errors.403',[],403);
        }

        $data = [
            'booking'=>$booking,
            'booking_details'=>$this->getBookingDetails($booking),
            'providers'=>Provider::GetActiveProviders()
                ->where('is_doctor',0)->pluck('first_name_en','id')
        ];
        return view(AD.'.meetings.show')->with($data);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function getBookingServicesDataTable(Request $request)
    {
//        By default get all upcoming meetings
        $status = [config('constants.bookingStatus.inprogress')];

        if ($request->meeting_type){
            $status = [config('constants.bookingStatus.'.$request->meeting_type)];
        }

        $items = ServiceBooking::where('service_bookings.id', '<>', 0)
            ->whereIn('service_bookings.status',$status)
            ->leftjoin('services','service_bookings.service_id','services.id')
            ->join('customers','service_bookings.customer_id','customers.id')
            ->join('currencies','service_bookings.currency_id','currencies.id')
            ->select(['service_bookings.id','service_bookings.status','service_bookings.price','service_bookings.status_desc','service_bookings.created_at','services.name_en','customers.first_name','customers.middle_name','customers.last_name','customers.national_id','customers.mobile_number','currencies.name_eng']);
        $dataTable = DataTables::of($items)
            ->editColumn('name_en',function ($item){
                return ($item->name_en) ? $item->name_en : 'Lap Service';
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
                return '<span class="label label-'.$status_type.' label-sm">'.$item->status_desc.'</span>';
            })
            ->editColumn('price',function ($item){
                return $item->price .' '.$item->name_eng;
            })
            ->addColumn('actions', function ($item) {
                $showURL = route('show-meeting-details',[$item->id]);
                $URLs = [
                    ['link'=>$showURL,'icon'=>'info'],
                ];
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
    private function getBookingDetails($booking){
        if (!$booking) return null;

        $booking_details = [
            'id'=>$booking->id,
            'service_name'=>'',
            'start_date'=>'',
            'end_date'=>'',
            'price'=>$booking->price,
            'currency'=>$booking->currency->name_eng,
        ];

//        in case Provider
        if (!empty($booking->service) && $booking->service->type == 5){
            $provider_calendar = ProvidersCalendar::find($booking->service_appointments->first()->slot_id);
            $booking_details['service_name'] = $booking->provider->full_name .' ('. $booking->service->type_desc.')';
            $booking_details['start_date']   = $provider_calendar->start_date->format('Y-m-d h:i A');
            $booking_details['end_date']     = $provider_calendar->end_date->format('Y-m-d h:i A');
        }

//        in case Lap Service
        if (empty($booking->service) && $booking->is_lap==1){
            $lap_calendar = LapCalendar::find($booking->service_appointments->first()->slot_id);
            $lap_services = $booking->load('booking_lap_services.service')->booking_lap_services;
            foreach ($lap_services as $key=>$lap_service){
                $booking_details['service_name'] .=  ( $key !== count( $lap_services ) -1 ) ? $lap_service->service->name_en .' & ' : $lap_service->service->name_en .' (Lab Service)';
            }
//            $booking_details['service_name'] = $booking->load('booking_lap_services.service')->booking_lap_services;
            $booking_details['start_date']   = $lap_calendar->start_date->format('Y-m-d h:i A');
            $booking_details['end_date']     = $lap_calendar->end_date->format('Y-m-d h:i A');
        }

//        in case one time visit and package
        if (!empty($booking->service) && ($booking->service->type == 1 || $booking->service->type == 2)){
            $package_oneTime_calendar = ServicesCalendar::find($booking->service_appointments->first()->slot_id);
            $booking_details['service_name'] = $booking->service->name_en .' ('. $booking->service->type_desc.')';
            $booking_details['start_date']   = $package_oneTime_calendar->start_date->format('Y-m-d h:i A');
            $booking_details['end_date']     = $package_oneTime_calendar->end_date->format('Y-m-d h:i A');

        }
        return $booking_details;
    }

    public function assignProviderToMeeting(Request $request){
        if (Gate::denies('meetings.view',new ServiceBooking())){
            return response()->view('errors.403',[],403);
        }
        $request->validate(['provider_id' => 'required|integer|min:1']);
        $validator = Validator::make($request->all(), ['provider_id' => 'required|integer|min:1',]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->booking){
            ServiceBooking::where('id',$request->booking)->update(['provider_id_assigned_by_admin'=>$request->input('provider_id')]);
        }
        return back();
    }
}