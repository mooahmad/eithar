<?php

namespace App\Http\Controllers\Administrator\Services;

use App\Helpers\Utilities;
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
        $doctorID = config('constants.categories.Doctor');
        $categories = Category::doesntHave('categories')->where('id', '<>', $doctorID)->get();
        $categories = $categories->reject(function ($category, $key) use ($doctorID) {
            if($category->category_parent_id == $doctorID){
                if($category->services->isEmpty())
                    return false;
                return true;
            }
            return false;
        });
        $categories = $categories->pluck(trans('admin.cat_name_col'), 'id')->toArray();
        $countries = Country::all()->pluck(trans('admin.country_name_col'), 'id')->toArray();
        $currencies = Currency::all()->pluck(trans('admin.currency_name_col'), 'id')->toArray();
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
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/services');
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
        $doctorID = config('constants.categories.Doctor');
        $categories = Category::doesntHave('categories')->where('id', '<>', $doctorID)->get();
        $categories = $categories->reject(function ($category, $key) use ($doctorID, $service) {
            if($category->category_parent_id == $doctorID && $category->id != $service->category_id){
                if($category->services->isEmpty())
                    return false;
                return true;
            }
            return false;
        });
        $categories = $categories->pluck(trans('admin.cat_name_col'), 'id')->toArray();
        $countries = Country::all()->pluck(trans('admin.country_name_col'), 'id')->toArray();
        $currencies = Currency::all()->pluck(trans('admin.currency_name_col'), 'id')->toArray();
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
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/services');
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
                                   $editURL = url(AD . '/services/' . $service->id . '/edit');
                                   return View::make('Administrator.widgets.dataTablesActions', ['editURL' => $editURL]);
                               })
                               ->addColumn('image', function ($service) {
                                   if (!empty($service->profile_picture_path)) {
                                       $serviceImage = Utilities::getFileUrl($service->profile_picture_path);
                                       return '<td><a href="' . $serviceImage . '" data-lightbox="image-1" data-title="' . $service->id . '" class="text-success">Show <i class="fa fa-image"></a></i></a></td>';
                                   } else {
                                       return '<td><span class="text-danger">No Image</span></td>';
                                   }
                               })
                               ->rawColumns(['image', 'actions'])
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
