<?php

namespace App\Http\Controllers\Administrator\BookingServices;

use App\Http\Controllers\Controller;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BookingServicesController extends Controller
{
    /**
     * BookingServicesController constructor.
     */
    public function __construct()
    {
        $this->middleware('AdminAuth');
    }

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
}