<?php

namespace App\Http\Controllers\Administrator\Customers;

use App\Helpers\Utilities;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerFamily\AddCustomerRequest;
use App\Http\Services\Adminstrator\UsersModule\ClassesUsers\CustomersClass;
use App\Models\City;
use App\Models\Country;
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
        if (Gate::denies('customers.create',new Customer())){
            return response()->view('errors.403',[],403);
        }
        $data = [
            'countries'=>Country::all()->pluck('country_name_eng','id'),
            'cities'=>City::all()->pluck('city_name_eng','id'),
            'gender_types'=>config('constants.gender_desc')
        ];
        return view(AD . '.customers.form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddCustomerRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(AddCustomerRequest $request)
    {
        if (Gate::denies('customers.create',new Customer())){
            return response()->view('errors.403',[],403);
        }
        $customer = CustomersClass::createOrUpdateCustomer(new Customer(),$request);
        if ($request->hasFile('profile_picture_path')){
            $avatar = Utilities::UploadFile($request->file('profile_picture_path'),'public/images/avatars');
            if ($avatar){
                $customer->profile_picture_path = $avatar;
                $customer->save();
            }
        }

        if ($request->hasFile('nationality_id_picture')){
            $nationality_image = Utilities::UploadFile($request->file('nationality_id_picture'),'public/images/nationalities');
            if ($nationality_image){
                $customer->nationality_id_picture = $nationality_image;
                $customer->save();
            }
        }
        session()->flash('success_msg',trans('admin.success_message'));
        return redirect()->route('show_customers');
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
        if (Gate::denies('customers.update',new Customer())){
            return response()->view('errors.403',[],403);
        }
        $data = [
            'form_data'=>Customer::findOrFail($id),
            'countries'=>Country::all()->pluck('country_name_eng','id'),
            'cities'=>City::all()->pluck('city_name_eng','id'),
            'gender_types'=>config('constants.gender_desc')
        ];
        return view(AD . '.customers.form')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AddCustomerRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(AddCustomerRequest $request, $id)
    {
        if (Gate::denies('customers.update',new Customer())){
            return response()->view('errors.403',[],403);
        }
        $customer_data = Customer::FindOrFail($id);
        $customer = CustomersClass::createOrUpdateCustomer($customer_data,$request,false);
        if ($request->hasFile('profile_picture_path')){
            $avatar = Utilities::UploadFile($request->file('profile_picture_path'),'public/images/avatars',$customer_data->profile_picture_path);
            if ($avatar){
                $customer->profile_picture_path = $avatar;
                $customer->save();
            }
        }

        if ($request->hasFile('nationality_id_picture')){
            $nationality_image = Utilities::UploadFile($request->file('nationality_id_picture'),'public/images/nationalities',$customer_data->nationality_id_picture);
            if ($nationality_image){
                $customer->nationality_id_picture = $nationality_image;
                $customer->save();
            }
        }
        session()->flash('success_msg',trans('admin.success_message'));
        return redirect()->route('show_customers');
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
                $editURL = url()->route('edit_customers',[$item->id]);
                $showURL = url()->route('profile_customers',[$item->id]);
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
        $Booking_services = ServiceBooking::where('id', '<>', 0)
            ->where('customer_id',$request->id)
            ->latest();
        $dataTable = DataTables::of($Booking_services)
            ->addColumn('actions', function ($item) {
                $showURL = route('show-meeting-details',[$item->id]);
                $URLs = [
                    ['link'=>$showURL,'icon'=>'eye','color'=>'green'],
                ];
                return View::make('Administrator.widgets.advancedActions', ['URLs'=>$URLs]);
            })
            ->addColumn('service_name',function ($item){
                return ($item->service)? $item->service->name_en. '-'.$item->service->type_desc : 'Lab Service';
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
                return '<span class="label label-'.$status_type.' label-sm text-capitalize">'.$item->status_desc.'</span>';
            })
            ->rawColumns(['service_name','price','status','actions'])
            ->make(true);
        return $dataTable;
    }

    /**
     * @param Request $request
     * @return null
     * @throws \Exception
     */
    public function getCustomerNotificationsDataTable(Request $request)
    {
        $customer = Customer::findOrFail($request->id);
        if (empty($customer->notifications)){
            return null;
        }
        $dataTable = DataTables::of($customer->notifications)
            ->addColumn('title',function ($item){
                $data = json_decode(json_encode($item->data));
                return $data->{'title_'.$data->lang};
            })
            ->addColumn('description',function ($item){
                $data = json_decode(json_encode($item->data));
                return $data->{'desc_'.$data->lang};
            })
            ->addColumn('notification_type',function ($item){
                $data = json_decode(json_encode($item->data));
                return config('constants.pushTypesDesc.'.$data->notification_type);
            })
            ->addColumn('is_smsed',function ($item){
                if($item->is_smsed==1){
                    return '<span class="label label-success label-sm">Sent</span>';
                }else{
                    return '<span class="label label-warning label-sm">Pending</span>';
                }
            })
            ->addColumn('is_pushed',function ($item){
                if($item->is_pushed==1){
                    return '<span class="label label-success label-sm">Sent</span>';
                }else{
                    return '<span class="label label-warning label-sm">Pending</span>';
                }
            })
            ->addColumn('is_emailed',function ($item){
                if($item->is_emailed==1){
                    return '<span class="label label-success label-sm">Sent</span>';
                }else{
                    return '<span class="label label-warning label-sm">Pending</span>';
                }
            })
            ->addColumn('send_at',function ($item){
                $data = json_decode(json_encode($item->data));
                return $data->send_at;
            })
            ->addColumn('read_at',function ($item){
                return $item->read_at;
            })
            ->rawColumns(['description','title','read_at','send_at','is_emailed','is_pushed','is_smsed','notification_type'])
            ->make(true);
        return $dataTable;
    }
}
