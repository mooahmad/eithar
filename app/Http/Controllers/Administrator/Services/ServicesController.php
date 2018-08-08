<?php

namespace App\Http\Controllers\Administrator\Services;

use App\Http\Requests\Services\CreateServiceRequest;
use App\Http\Requests\Services\UpdateServiceRequest;
use App\Http\Services\Adminstrator\ServiceModule\ClassesService\ServiceClass;
use App\Models\Category;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;


class ServicesController extends Controller
{
    /**
     * CategoriesController constructor.
     */
    public function __construct()
    {

    }

    /**
     *
     */
    public function index()
    {
        if (Gate::denies('service.view', new Service())) {
            return response()->view('errors.403', [], 403);
        }
        return view(AD . '.services.index');
    }

    /**
     *
     */
    public function create()
    {
        if (Gate::denies('service.create', new Service())) {
            return response()->view('errors.403', [], 403);
        }
        $categories = Category::all()->pluck(__('admin.cat_name_col'), 'id')->toArray();
        $countries = Country::all()->pluck(__('admin.country_name_col'), 'id')->toArray();
        $currencies = Currency::all()->pluck(__('admin.currency_name_col'), 'id')->toArray();
        $types = config('constants.serviceTypes');
        $data = [
            'categories' => $categories,
            'countries'  => $countries,
            'currencies' => $currencies,
            'types'      => $types,
            'formRoute'  => route('services.store'),
            'submitBtn'  => trans('admin.create')
        ];
        return view(AD . '.services.form')->with($data);
    }

    /**
     * @param Request $request
     */
    public function store(CreateServiceRequest $request)
    {
        if (Gate::denies('service.create', new Service())) {
            return response()->view('errors.403', [], 403);
        }
        $service = new Service();
        ServiceClass::createOrUpdate($service, $request);
        ServiceClass::uploadImage($request, 'avatar', 'public/images/services', $service, 'profile_picture_path');
        ServiceClass::uploadVideo($request, 'video', 'public/images/services/videos', $service, 'profile_video_path');
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(SRV . '/services');
    }

    /**
     * @param $id
     */
    public function show($id)
    {
        //
    }

    /**
     * @param $id
     */
    public function edit($id)
    {
        if (Gate::denies('service.update', new Service())) {
            return response()->view('errors.403', [], 403);
        }
        $service = Service::FindOrFail($id);
        $categories = Category::all()->pluck(__('admin.cat_name_col'), 'id')->toArray();
        $countries = Country::all()->pluck(__('admin.country_name_col'), 'id')->toArray();
        $currencies = Currency::all()->pluck(__('admin.currency_name_col'), 'id')->toArray();
        $types = config('constants.serviceTypes');
        $data = [
            'categories' => $categories,
            'countries'  => $countries,
            'currencies' => $currencies,
            'types'      => $types,
            'service'    => $service,
            'formRoute'  => route('services.update', ['service' => $id]),
            'submitBtn'  => trans('admin.update')
        ];
        return view(AD . '.services.form')->with($data);
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(UpdateServiceRequest $request, $id)
    {
        if (Gate::denies('service.update', new Service())) {
            return response()->view('errors.403', [], 403);
        }
        $service = Service::findOrFail($id);
        ServiceClass::createOrUpdate($service, $request, false);
        ServiceClass::uploadImage($request, 'avatar', 'public/images/services', $service, 'profile_picture_path');
        ServiceClass::uploadVideo($request, 'video', 'public/images/services/videos', $service, 'profile_video_path');
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(SRV . '/services');
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        //
    }

    public function getServicesDataTable()
    {
        $services = Service::where('id', '<>', 0);
        $dataTable = DataTables::of($services)
                               ->addColumn('actions', function ($service) {
                                   $editURL = url('Services/services/' . $service->id . '/edit');
                                   return View::make('Administrator.widgets.dataTablesActions', ['editURL' => $editURL]);
                               })
                               ->rawColumns(['actions'])
                               ->make(true);
        return $dataTable;
    }

    public function deleteServices(Request $request)
    {
        if (Gate::denies('service.delete', new Service())) {
            return response()->view('errors.403', [], 403);
        }
        $ids = $request->input('ids');
        return Service::whereIn('id', $ids)->delete();
    }

}
