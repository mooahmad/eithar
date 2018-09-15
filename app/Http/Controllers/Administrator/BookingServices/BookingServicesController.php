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

    public function index()
    {
        if (Gate::denies('booking.view',new ServiceBooking())){
            return response()->view('errors.403',[],403);
        }
        $data = [
            'booking' => ServiceBooking::first()
        ];
        return view(AD.'.booking.index')->with($data);
    }

    /**
     * @param ServiceBooking $booking
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(ServiceBooking $booking)
    {
        if (Gate::denies('booking.view',new ServiceBooking())){
            return response()->view('errors.403',[],403);
        }
        $data = [
            'booking'=>$booking
        ];
        return view(AD.'.booking.show')->with($data);
    }

    /**
     * @return mixed
     */
    public function getBookingServicesDataTable()
    {
        $items = Customer::where('id', '<>', 0);
        $dataTable = DataTables::of($items)
            ->addColumn('actions', function ($item) {
                $showURL = url(AD . '/customers/' . $item->id);

                $URLs = [
                    ['link'=>$showURL],
                ];
                return View::make('Administrator.widgets.advancedActions', ['URLs'=>$URLs]);
            })
            ->addColumn('image', function ($item) {
                if (!empty($item->profile_picture_path)) {
                    $Image = Utilities::getFileUrl($item->profile_picture_path);
                    return '<td><a href="' . $Image . '" data-lightbox="image-1" data-title="' . $item->id . '" class="text-success">Show <i class="fa fa-image"></i></a></td>';
                } else {
                    return '<td><span class="text-danger">No Image</span></td>';
                }
            })
            ->addColumn('full_name',function ($item){
                return $item->full_name;
            })
            ->addColumn('country',function ($item){
                return $item->country->country_name_eng .' - '. $item->city->city_name_eng;
            })
            ->rawColumns(['image','full_name','actions'])
            ->make(true);
        return $dataTable;
    }

}