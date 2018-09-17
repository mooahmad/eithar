<?php

namespace App\Http\Controllers\Administrator\BookingServices;

use App\Helpers\Utilities;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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

    public function indexUpComingMeetings()
    {
        if (Gate::denies('meetings.view',new ServiceBooking())){
            return response()->view('errors.403',[],403);
        }
        $data = [
            'meeting_type' => 'upcoming'
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
            'meetings'=>$booking
        ];
        return view(AD.'.meetings.show')->with($data);
    }

    /**
     * @return mixed
     */
    public function getBookingServicesDataTable(Request $request)
    {
//        By default get all upcoming meetings
        $status = [config('constants.bookingStatus.inprogress'), config('constants.bookingStatus.confirmed')];

        if ($request->meeting_type && $request->meeting_type == 'upcoming'){
//            return upcoming meetings
            $status = [config('constants.bookingStatus.inprogress'), config('constants.bookingStatus.confirmed')];
        }

        if ($request->meeting_type && $request->meeting_type == 'old'){
//            return upcoming meetings
            $status = [config('constants.bookingStatus.completed')];
        }
//        dd($status);
        $items = ServiceBooking::where('service_bookings.id', '<>', 0)->whereIn('service_bookings.status',$status)
            ->join('services','service_bookings.service_id','services.id')
            ->join('customers','service_bookings.customer_id','customers.id')
            ->join('currencies','service_bookings.currency_id','currencies.id')
            ->select(['service_bookings.id','service_bookings.status','service_bookings.price','service_bookings.status_desc','services.name_en','customers.first_name','customers.middle_name','customers.last_name','customers.national_id','currencies.name_eng']);
        $dataTable = DataTables::of($items)
            ->editColumn('full_name',function ($item){
                return $item->first_name .' '. $item->middle_name .' '. $item->last_name;
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
                $showURL = url(AD . '/meetings/' . $item->id);

                $URLs = [
                    ['link'=>$showURL],
                ];
                return View::make('Administrator.widgets.advancedActions', ['URLs'=>$URLs]);
            })
            ->rawColumns(['status','actions'])
            ->make(true);
        return $dataTable;
    }
}