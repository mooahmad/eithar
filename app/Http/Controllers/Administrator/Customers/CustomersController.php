<?php

namespace App\Http\Controllers\Administrator\Customers;

use App\Helpers\Utilities;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class CustomersController extends Controller
{
    /**
     * CustomersController constructor.
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
//        Check Credentials
        if (Gate::denies('customers.view',new Customer())){
            return response()->view('errors.403',[],403);
        }
        return view(AD . '.customers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Customer $customer
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Customer $customer)
    {
        $data = [
            'customer'=>$customer
        ];
        return \view(AD.'.customers.profile')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * get all customers data to dataTable
     *
     * @return mixed
     * @throws \Exception
     */
    public function getCustomersDataTable()
    {
        $customers = Customer::where('id', '<>', 0);
        $dataTable = DataTables::of($customers)
            ->addColumn('actions', function ($item) {
                $editURL = url(AD . '/customers/' . $item->id . '/edit');
                $showURL = url(AD . '/customers/' . $item->id);
                return View::make('Administrator.widgets.dataTablesActions', ['editURL' => $editURL, 'showURL' => $showURL]);
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

    /**
     * Get All Services Booked by Customer ID
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function getCustomerAppointmentsDataTable(Request $request)
    {
        $Booking_services = ServiceBooking::where('id', '<>', 0)->where('customer_id',$request->id);
        $dataTable = DataTables::of($Booking_services)
            ->addColumn('actions', function ($item) {
                $showURL = url(AD . '/booking-services/' . $item->id);
                return View::make('Administrator.widgets.dataTablesActions', ['showURL' => $showURL]);
            })
            ->addColumn('service_name',function ($item){
                return ($item->service)? $item->service->name_en. '-'.$item->service->type_desc : '';
            })
            ->addColumn('price',function ($item){
                $price = $item->price .' ';
                $price.= ($item->currency)? $item->currency->name_eng :" ";
                return $price;
            })
            ->addColumn('status',function ($item){
                $status_type = 'warning';
                if($item->status==2){$status_type= 'success';}
                if($item->status==3){$status_type= 'danger';}
                return '<span class="label label-'.$status_type.' label-sm">'.$item->status_desc.'</span>';
            })
            ->rawColumns(['service_name','price','status','actions'])
            ->make(true);
        return $dataTable;
    }
}
