<?php

namespace App\Http\Controllers\Administrator\Providers;

use App\Helpers\Utilities;
use App\Http\Requests\Providers\CreateCalendarRequest;
use App\Http\Requests\Providers\CreateProviderRequest;
use App\Http\Requests\Providers\UpdateCalendarRequest;
use App\Http\Requests\Providers\UpdateProviderRequest;
use App\Http\Services\Adminstrator\ProviderModule\ClassesProvider\ProviderClass;
use App\Models\City;
use App\Models\Currency;
use App\Models\MedicalReports;
use App\Models\Provider;
use App\Models\ProvidersCalendar;
use App\Models\ProviderService;
use App\Models\Service;
use App\Models\ServiceBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;


class ProvidersController extends Controller
{
    /**
     * CategoriesController constructor.
     */
    public function __construct()
    {
//        $this->middleware('AdminAuth');
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

    public function getMeetings(Request $request,$id)
    {
        if (Gate::allows('meetings.view', new ServiceBooking()) || Gate::forUser(auth()->guard('provider-web')->user())->allows('provider_guard.view')) {
            $provider = Provider::findOrFail($id);
            $data = ['provider' =>$provider];
            return view(AD . '.providers.meetings',$data);
        }
        return response()->view('errors.403', [], 403);
    }


    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function getBookingProvidersDataTable(Request $request)
    {
        if ($request->get('filter') == 'upcoming') {
            $items = ServiceBooking::where('service_bookings.id', '<>', 0)->where('service_bookings.created_at', '>=', Carbon::now()->toDateTimeString())->where('provider_id',$request->providerId)->orderBy('service_bookings.created_at');
        } elseif ($request->get('filter') == 'old') {
            $items = ServiceBooking::where('service_bookings.id', '<>', 0)->where('service_bookings.created_at', '<', Carbon::now()->toDateTimeString())->where('provider_id',$request->providerId)->orderBy('service_bookings.created_at');
        } else {
            $items = ServiceBooking::where('service_bookings.id', '<>', 0)->where('provider_id',$request->providerId)->orderBy('service_bookings.created_at');
        }

        if (auth()->guard('provider-web')->user()) {
            $items->where('service_bookings.provider_id_assigned_by_admin', auth()->guard('provider-web')->user()->id)
                ->orWhere('service_bookings.provider_id', auth()->guard('provider-web')->user()->id);
        }
        $items->leftjoin('services', 'service_bookings.service_id', 'services.id')
            ->join('customers', 'service_bookings.customer_id', 'customers.id')
            ->join('currencies', 'service_bookings.currency_id', 'currencies.id')
            ->select(['service_bookings.id', 'service_bookings.status', 'service_bookings.provider_id', 'service_bookings.unlock_request', 'service_bookings.price', 'service_bookings.status_desc', 'service_bookings.created_at', 'services.name_en', 'customers.first_name', 'customers.middle_name', 'customers.last_name', 'customers.eithar_id', 'customers.national_id', 'customers.mobile_number', 'currencies.name_eng']);
        $dataTable = DataTables::of($items)
            ->editColumn('name_en', function ($item) {
                //  return (!empty($item->name_en)) ? $item->name_en : (!empty($item->provider_id))? Provider::find($item->provider_id)->full_name : 'Provider';

                if (!empty($item->name_en)) {
                    return $item->name_en;
                } elseif (!empty($item->provider_id)) {
                    return Provider::find($item->provider_id)->full_name;
                } else {
                    return 'Provider';
                }
            })
            ->editColumn('full_name', function ($item) {
                return $item->first_name . ' ' . $item->middle_name . ' ' . $item->last_name;
            })
            ->editColumn('created_at', function ($item) {
                return $item->created_at;
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(service_bookings.created_at,'%m/%d/%Y') like ?", ["%$keyword%"]);
            })
            ->addColumn('status', function ($item) {
                $status_type = 'warning';
                if ($item->status == 2) {
                    $status_type = 'success';
                }
                if ($item->status == 3) {
                    $status_type = 'danger';
                }
                return '<span class="label label-' . $status_type . ' label-sm text-capitalize">' . $item->status_desc . '</span>';
            })
            ->editColumn('price', function ($item) {
                return $item->price . ' ' . $item->name_eng;
            })
            ->addColumn('actions', function ($item) {
                $showURL = route('show-meeting-details', ["id" => $item->id]);
                $URLs = [
                    ['link' => $showURL, 'icon' => 'eye', 'color' => 'green'],
                ];
                if ($item->unlock_request == 1) {
                    $unlockURL = route('approve-unlock', [$item->id]);
                    $URLs[] = ['link' => $unlockURL, 'icon' => 'check', 'color' => 'red'];
                }
                if (Gate::allows('medical_report.view', new MedicalReports()) || Gate::forUser(auth()->guard('provider-web')->user())->allows('provider_guard.view')) {
                    $medicalReportsURL = route('showMeetingReport', [$item->id]);
                    $addMedicalReportURL = route('createMeetingReport', [$item->id]);
                    $URLs[] = ['link' => $medicalReportsURL, 'icon' => 'list'];
//                    $URLs[] = ['link' => $addMedicalReportURL, 'icon' => 'plus', 'color' => 'blue'];
                }
                return View::make('Administrator.widgets.advancedActions', ['URLs' => $URLs]);
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);

        return $dataTable;
    }

    /**
     *
     */
    public function getSuspendedProviders()
    {
        if (Gate::denies('provider.view', new Provider())) {
            return response()->view('errors.403', [], 403);
        }
        return view(AD . '.providers.suspended_providers');
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
        $allCities = City::all()->pluck('city_name_eng', 'id')->toArray();
        $selectedCities = [];
        $data = [
            'currencies' => $currencies,
            'allServices' => $allServices,
            'selectedServices' => $selectedServices,
            'allCities' => $allCities,
            'selectedCities' => $selectedCities,
            'formRoute' => route('providers.store'),
            'submitBtn' => trans('admin.create')
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        if (Auth::user()){
            if (Gate::denies('provider.update', new Provider())) {
                return response()->view('errors.403', [], 403);
            }
        }
        if (Auth::guard('provider-web')->user()){
            if (Gate::forUser(Auth::guard('provider-web')->user())->denies('provider_guard.view')){
                return response()->view('errors.403',[],403);
            }
        }
        $provider = Provider::FindOrFail($id);
        $currencies = Currency::all()->pluck(trans('admin.currency_name_col'), 'id')->toArray();
        $allServices = Service::all()->pluck('name_en', 'id')->toArray();
        $selectedServices = $provider->services->pluck('id')->toArray();
        $allCities = City::all()->pluck('city_name_eng', 'id')->toArray();
        $selectedCities = $provider->cities->pluck('id')->toArray();
        $data = [
            'currencies' => $currencies,
            'provider' => $provider,
            'allServices' => $allServices,
            'selectedServices' => $selectedServices,
            'allCities' => $allCities,
            'selectedCities' => $selectedCities,
            'formRoute' => route('providers.update', ['provider' => $id]),
            'submitBtn' => trans('admin.update')
        ];
        return view(AD . '.providers.form')->with($data);
    }

    /**
     * @param UpdateProviderRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(UpdateProviderRequest $request, $id)
    {
        if (Auth::user()){
            if (Gate::denies('provider.update', new Provider())) {
                return response()->view('errors.403', [], 403);
            }
        }
        if (Auth::guard('provider-web')->user()){
            if (Gate::forUser(Auth::guard('provider-web')->user())->denies('provider_guard.update')){
                return response()->view('errors.403',[],403);
            }
        }

        $provider = Provider::findOrFail($id);
        ProviderClass::createOrUpdate($provider, $request, false);
        ProviderClass::uploadImage($request, 'avatar', 'public/images/providers', $provider, 'profile_picture_path');
        session()->flash('success_msg', trans('admin.success_message'));
        if (Auth::guard('provider-web')->user()){
            return redirect()->route('edit_provider',[Auth::guard('provider-web')->user()->id]);
        }
        return redirect()->route('show_providers');
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        //
    }

    public function getSuspenedProvidersDataTable()
    {
        $providers = Provider::where('id', '<>', 0)->where('is_active',0);
        $dataTable = DataTables::of($providers)
            ->addColumn('actions', function ($provider) {
                $editURL = url(AD . '/providers/' . $provider->id . '/edit');
                $calendarURL = url(AD . '/providers/' . $provider->id . '/calendar');
                $addCalendarURL = url(AD . '/providers/' . $provider->id . '/calendar/create');
                $providermeetings= route('getProviderMeetings',$provider->id);
                return View::make('Administrator.providers.widgets.dataTableCalendarAction', ['editURL' => $editURL, 'calendarURL' => $calendarURL, 'addCalendarURL' => $addCalendarURL,'meetings'=>$providermeetings]);
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

    public function getProvidersDataTable()
    {
        $providers = Provider::where('id', '<>', 0);
        $dataTable = DataTables::of($providers)
            ->addColumn('actions', function ($provider) {
                $editURL = url(AD . '/providers/' . $provider->id . '/edit');
                $calendarURL = url(AD . '/providers/' . $provider->id . '/calendar');
                $addCalendarURL = url(AD . '/providers/' . $provider->id . '/calendar/create');
                $providermeetings= route('getProviderMeetings',$provider->id);

                return View::make('Administrator.providers.widgets.dataTableCalendarAction', ['editURL' => $editURL, 'calendarURL' => $calendarURL, 'addCalendarURL' => $addCalendarURL,'meetings'=>$providermeetings]);
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

    // calendar section

    public function showProviderCalendar($id)
    {
        if (Auth::user()){
            if (Gate::denies('provider.update', new Provider())) {
                return response()->view('errors.403', [], 403);
            }
        }
        if (Auth::guard('provider-web')->user()){
            if (Gate::forUser(Auth::guard('provider-web')->user())->denies('provider_guard.update')){
                return response()->view('errors.403',[],403);
            }
        }

        $calendarSections = config('constants.calendarSections');
        $data = [
            'providerID' => $id,
            'calendarSections' => $calendarSections
        ];
        return view(AD . '.providers.calendar_index')->with($data);
    }

    public function createProviderCalendar(Request $request, $providerId)
    {
        if (Auth::user()){
            if (Gate::denies('provider.update', new Provider())) {
                return response()->view('errors.403', [], 403);
            }
        }
        if (Auth::guard('provider-web')->user()){
            if (Gate::forUser(Auth::guard('provider-web')->user())->denies('provider_guard.update')){
                return response()->view('errors.403',[],403);
            }
        }

        $allWeekDays = ["saturday" => "saturday", "sunday" => "sunday",
            "monday" => "monday", "tuesday" => "tuesday", "wednesday" => "wednesday",
            "thursday" => "thursday", "friday" => "friday"];
        $times = Utilities::GenerateHours();
        $data = [
            'times' => $times,
            'allWeekDays' => $allWeekDays,
            'selectedWeekDays' => [],
            'formRoute' => route('storeProviderCalendar', ['provider' => $providerId]),
            'submitBtn' => trans('admin.create')
        ];
        return view(AD . '.providers.calendar_form')->with($data);
    }

    public function storeProviderCalendar(CreateCalendarRequest $request, $providerId)
    {
        if (Auth::user()){
            if (Gate::denies('provider.update', new Provider())) {
                return response()->view('errors.403', [], 403);
            }
        }
        if (Auth::guard('provider-web')->user()){
            if (Gate::forUser(Auth::guard('provider-web')->user())->denies('provider_guard.update')){
                return response()->view('errors.403',[],403);
            }
        }

        $provider = Provider::find($providerId);
        $selectedDays = $request->input('week_days');
        $numberOfWeeks = $request->input('number_of_weeks');
        $startTime = $request->input('start_time');
        $numberOfSessions = $request->input('number_of_sessions', 0);

        $allDates = [];
        $message["invalid"] = [];
        $message["valid"] = [];
        foreach ($selectedDays as $selectedDay) {
            $allDates = array_merge($allDates, Utilities::getDayDatesOfWeeks($selectedDay, $numberOfWeeks));
        }
        foreach ($allDates as $dayDate) {
            $startDate = $dayDate . ' ' . $startTime . ':00';
            for ($i = 0; $i < $numberOfSessions; $i++) {
                $endDate = Carbon::parse($startDate)->addMinutes($provider->visit_duration)->toDateTimeString();
                if (strtotime($endDate) >= strtotime($dayDate . ' ' . '23:59:00'))
                    break;
                if (ProviderClass::isExistCalendar($startDate, $endDate, $providerId)) {
                    array_push($message["invalid"], $startDate);
                } else {
                    $providerCalendar = new ProvidersCalendar();
                    ProviderClass::createOrUpdateCalendar($providerCalendar, $providerId, $startDate, $endDate, 1);
                    array_push($message["valid"], $startDate);
                }
                $startDate = Carbon::parse($endDate)->addMinutes($provider->time_before_next_visit)->toDateTimeString();
            }
        }
        if (!empty($message["invalid"]))
            return Redirect::back()->withErrors($message);
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/providers/' . $providerId . '/calendar');
    }

    public function editProviderCalendar(Request $request, $providerId, $calendarId)
    {
        if (Auth::user()){
            if (Gate::denies('provider.update', new Provider())) {
                return response()->view('errors.403', [], 403);
            }
        }
        if (Auth::guard('provider-web')->user()){
            if (Gate::forUser(Auth::guard('provider-web')->user())->denies('provider_guard.update')){
                return response()->view('errors.403',[],403);
            }
        }

        $calendar = ProvidersCalendar::find($calendarId);
        $data = [
            'calendar' => $calendar,
            'formRoute' => route('updateProviderCalendar', ['id' => $providerId, 'calendarId' => $calendarId]),
            'submitBtn' => trans('admin.update')
        ];
        return view(AD . '.providers.calendar_edit_form')->with($data);
    }

    public function updateProviderCalendar(UpdateCalendarRequest $request, $providerId, $calendarId)
    {
        if (Auth::user()){
            if (Gate::denies('provider.update', new Provider())) {
                return response()->view('errors.403', [], 403);
            }
        }
        if (Auth::guard('provider-web')->user()){
            if (Gate::forUser(Auth::guard('provider-web')->user())->denies('provider_guard.update')){
                return response()->view('errors.403',[],403);
            }
        }

        $providerCalendar = ProvidersCalendar::find($calendarId);
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $isAvailable = $request->input('is_available');
        if (ProviderClass::isExistCalendar($startDate, $endDate, $providerId, $calendarId)) {
            return Redirect::back()->withErrors(['msg' => 'The slot you have picked conflicts with another one']);
        }
        ProviderClass::createOrUpdateCalendar($providerCalendar, $providerId, $startDate, $endDate, $isAvailable);
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/providers/' . $providerId . '/calendar');
    }

    public function getCalendarDatatable($id)
    {
        $providerCalendar = ProvidersCalendar::where('provider_id', $id);
        $dataTable = DataTables::of($providerCalendar)
            ->addColumn('actions', function ($calendar) use ($id) {
                $editURL = url(AD . '/providers/' . $id . '/calendar/' . $calendar->id . '/edit');
                return View::make('Administrator.widgets.dataTablesActions', ['editURL' => $editURL]);
            })
            ->filterColumn('providers_calendars.start_date', function ($query, $keyword) {
                $now = Carbon::now()->format('Y-m-d H:m:s');
                switch ($keyword) {
                    case 0:
                        break;
                        $query->whereRaw("1 = 1");
                    case 1:
                        $query->whereRaw("end_date < ?", ["%{$now}%"]);
                        break;
                    case 2:
                        $query->whereRaw("start_date < ? AND end_date > ?", ["%{$now}%", "%{$now}%"]);
                        break;
                    case 3:
                        $query->whereRaw("start_date > ?", ["%{$now}%"]);
                        break;
                }
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
