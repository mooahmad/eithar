<?php

namespace App\Http\Controllers\Administrator\Providers;

use App\Helpers\Utilities;
use App\Http\Requests\Providers\CreateProviderRequest;
use App\Http\Requests\Providers\UpdateProviderRequest;
use App\Http\Services\Adminstrator\ProviderModule\ClassesProvider\ProviderClass;
use App\Models\Currency;
use App\Models\Provider;
use App\Models\ProvidersCalendar;
use App\Models\ProviderService;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;


class ProvidersController extends Controller
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
        if (Gate::denies('provider.view', new Provider())) {
            return response()->view('errors.403', [], 403);
        }
        return view(AD . '.providers.index');
    }

    /**
     *
     */
    public function create()
    {
        if (Gate::denies('provider.create', new Provider())) {
            return response()->view('errors.403', [], 403);
        }
        $currencies = Currency::all()->pluck(trans('admin.currency_name_col'), 'id')->toArray();
        $allServices = Service::all()->pluck('name_en', 'id')->toArray();
        $selectedServices = [];
        $data = [
            'currencies'       => $currencies,
            'allServices'      => $allServices,
            'selectedServices' => $selectedServices,
            'formRoute'        => route('providers.store'),
            'submitBtn'        => trans('admin.create')
        ];
        return view(AD . '.providers.form')->with($data);
    }

    /**
     * @param Request $request
     */
    public function store(CreateProviderRequest $request)
    {
        if (Gate::denies('provider.create', new Provider())) {
            return response()->view('errors.403', [], 403);
        }
        $provider = new Provider();
        ProviderClass::createOrUpdate($provider, $request);
        ProviderClass::uploadImage($request, 'avatar', 'public/images/providers', $provider, 'profile_picture_path');
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/providers');
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
        if (Gate::denies('provider.update', new Provider())) {
            return response()->view('errors.403', [], 403);
        }
        $provider = Provider::FindOrFail($id);
        $currencies = Currency::all()->pluck(trans('admin.currency_name_col'), 'id')->toArray();
        $allServices = Service::all()->pluck('name_en', 'id')->toArray();
        $selectedServices = $provider->services->pluck('id')->toArray();
        $data = [
            'currencies'       => $currencies,
            'provider'         => $provider,
            'allServices'      => $allServices,
            'selectedServices' => $selectedServices,
            'formRoute'        => route('providers.update', ['provider' => $id]),
            'submitBtn'        => trans('admin.update')
        ];
        return view(AD . '.providers.form')->with($data);
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(UpdateProviderRequest $request, $id)
    {
        if (Gate::denies('provider.update', new Provider())) {
            return response()->view('errors.403', [], 403);
        }
        $provider = Provider::findOrFail($id);
        ProviderClass::createOrUpdate($provider, $request, false);
        ProviderClass::uploadImage($request, 'avatar', 'public/images/providers', $provider, 'profile_picture_path');
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/providers');
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        //
    }

    public function getProvidersDataTable()
    {
        $providers = Provider::where('id', '<>', 0);
        $dataTable = DataTables::of($providers)
                               ->addColumn('actions', function ($provider) {
                                   $editURL = url(AD . '/providers/' . $provider->id . '/edit');
                                   $calendarURL = url(AD . '/providers/' . $provider->id . '/calendar');
                                   $addCalendarURL = url(AD . '/providers/' . $provider->id . '/calendar/create');
                                   return View::make('Administrator.providers.widgets.dataTableCalendarAction', ['editURL' => $editURL, 'calendarURL' => $calendarURL, 'addCalendarURL' => $addCalendarURL]);
                               })
                               ->addColumn('image', function ($provider) {
                                   if (!empty($provider->profile_picture_path)) {
                                       return '<td><a href="' . $provider->profile_picture_path . '" data-lightbox="image-1" data-title="' . $provider->id . '" class="text-success">Show <i class="fa fa-image"></a></i></a></td>';
                                   } else {
                                       return '<td><span class="text-danger">No Image</span></td>';
                                   }
                               })
                               ->rawColumns(['image', 'actions'])
                               ->make(true);
        return $dataTable;
    }

    public function deleteProviders(Request $request)
    {
        if (Gate::denies('provider.delete', new Provider())) {
            return response()->view('errors.403', [], 403);
        }
        $ids = $request->input('ids');
        return Provider::whereIn('id', $ids)->delete();
    }

    public function showProviderCalendar($id)
    {
        return view(AD . '.providers.calendar_index')->with(['providerID' => $id]);
    }

    public function createProviderCalendar(Request $request, $providerId)
    {
        $data = [
            'formRoute' => route('storeProviderCalendar', ['provider' => $providerId]),
            'submitBtn' => trans('admin.update')
        ];
        return view(AD . '.providers.calendar_form')->with($data);
    }

    public function storeProviderCalendar(Request $request, $providerID)
    {

    }

    public function editProviderCalendar(Request $request, $providerID)
    {

    }

    public function getCalendarDatatable($id)
    {
        $providerCalendar = ProvidersCalendar::where('provider_id', $id);
        $dataTable = DataTables::of($providerCalendar)
                               ->addColumn('actions', function ($calendar) {
                                   $editURL = url(AD . '/providers/calendar/' . $calendar->id . '/edit');
                                   return View::make('Administrator.widgets.dataTablesActions', ['editURL' => $editURL]);
                               })
                               ->rawColumns(['actions'])
                               ->make(true);
        return $dataTable;
    }

    public function deleteCalendar(Request $request)
    {
        if (Gate::denies('provider.delete', new Provider())) {
            return response()->view('errors.403', [], 403);
        }
        $ids = $request->input('ids');
        return ProvidersCalendar::whereIn('id', $ids)->delete();
    }

}
