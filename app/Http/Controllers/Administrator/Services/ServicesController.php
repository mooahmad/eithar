<?php

namespace App\Http\Controllers\Administrator\Services;

use App\Helpers\Utilities;
use App\Http\Requests\Providers\CreateCalendarRequest;
use App\Http\Requests\Providers\UpdateCalendarRequest;
use App\Http\Requests\Services\CreateQuestionaireRequest;
use App\Http\Requests\Services\CreateServiceRequest;
use App\Http\Requests\Services\UpdateQuestionnaireRequest;
use App\Http\Requests\Services\UpdateServiceRequest;
use App\Http\Services\Adminstrator\ServiceModule\ClassesService\ServiceClass;
use App\LapCalendar;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Questionnaire;
use App\Models\Service;
use App\Models\ServicesCalendar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
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
        $nursingID = config('constants.categories.Nursing');
        $physioID = config('constants.categories.Physiotherapy');
        $womanID = config('constants.categories.WomanAndChild');
        $categories = Category::doesntHave('categories')
            ->where('id', '<>', $doctorID)
            ->where('id', '<>', $nursingID)
            ->where('id', '<>', $physioID)
            ->where('id', '<>', $womanID)
            ->get();
        $categories = $categories->reject(function ($category, $key) use ($doctorID) {
            if ($category->category_parent_id == $doctorID) {
                if ($category->services->isEmpty())
                    return false;
                return true;
            }
            return false;
        });
        $categories = $categories->pluck(trans('admin.cat_name_col'), 'id')->toArray();
        $countries = Country::all()->pluck(trans('admin.country_name_col'), 'id')->toArray();
        $currencies = Currency::all()->pluck(trans('admin.currency_name_col'), 'id')->toArray();
        $types = [];
        $data = [
            'categories' => $categories,
            'countries' => $countries,
            'currencies' => $currencies,
            'types' => $types,
            'formRoute' => route('services.store'),
            'submitBtn' => trans('admin.create')
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
        $nursingID = config('constants.categories.Nursing');
        $physioID = config('constants.categories.Physiotherapy');
        $womanID = config('constants.categories.WomanAndChild');
        $categories = Category::doesntHave('categories')
            ->where('id', '<>', $doctorID)
            ->where('id', '<>', $nursingID)
            ->where('id', '<>', $physioID)
            ->where('id', '<>', $womanID)
            ->get();
        $categories = $categories->reject(function ($category, $key) use ($doctorID, $service) {
            if ($category->category_parent_id == $doctorID && $category->id != $service->category_id) {
                if ($category->services->isEmpty())
                    return false;
                return true;
            }
            return false;
        });
        $categories = $categories->pluck(trans('admin.cat_name_col'), 'id')->toArray();
        $countries = Country::all()->pluck(trans('admin.country_name_col'), 'id')->toArray();
        $currencies = Currency::all()->pluck(trans('admin.currency_name_col'), 'id')->toArray();
        $types = [];
        $data = [
            'categories' => $categories,
            'countries' => $countries,
            'currencies' => $currencies,
            'types' => $types,
            'service' => $service,
            'formRoute' => route('services.update', ['service' => $id]),
            'submitBtn' => trans('admin.update')
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
                if ($service->type != 4) {
                    $editURL = url(AD . '/services/' . $service->id . '/edit');
                    $questionnaireURL = url(AD . '/services/' . $service->id . '/questionnaire');
                    $addQuestionnaireURL = url(AD . '/services/' . $service->id . '/questionnaire/create');
                    $calendarURL = "";
                    $addCalendarURL = "";
                    if($service->type == 1 || $service->type == 2){
                        $calendarURL = url(AD . '/services/' . $service->id . '/calendar');
                        $addCalendarURL = url(AD . '/services/' . $service->id . '/calendar/create');
                    }
                    return View::make('Administrator.services.widgets.dataTableQuestionnaireAction', ['editURL' => $editURL, 'questionnaireURL' => $questionnaireURL, 'addQuestionnaireURL' => $addQuestionnaireURL, "calendarURL" => $calendarURL, "addCalendarURL" => $addCalendarURL]);
                }
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

    public function getServicesTypes(Request $request, $categoryId)
    {
        $allTypes = config('constants.serviceTypes');
        $category = Category::find($categoryId);
        if($category->category_parent_id == config('constants.categories.Doctor')) {
            unset($allTypes[1]);
            unset($allTypes[2]);
            unset($allTypes[3]);
            unset($allTypes[4]);
        }elseif ($categoryId == config('constants.categories.Lap')) {
            unset($allTypes[1]);
            unset($allTypes[2]);
            unset($allTypes[3]);
            unset($allTypes[5]);
        } elseif ($category->category_parent_id == config('constants.categories.Physiotherapy') || $category->category_parent_id == config('constants.categories.Nursing') || $category->category_parent_id == config('constants.categories.WomanAndChild')) {
            unset($allTypes[3]);
            unset($allTypes[4]);
            unset($allTypes[5]);
        }
        return response()->json($allTypes);
    }

    // questionnaire section

    public function showServiceQuestionnaire($id)
    {
        $data = [
            'serviceId' => $id,
        ];
        return view(AD . '.services.questionnaire_index')->with($data);
    }

    public function createServiceQuestionnaire(Request $request, $serviceId)
    {
        $pages = range(0, config('constants.max_questionnaire_pages'));
        unset($pages[0]);
        $unAvailablePages = Questionnaire::where('service_id', $serviceId)
            ->groupBy('pagination')
            ->havingRaw('count(pagination) >= ' . config('constants.max_questionnaire_per_page'))
            ->pluck('pagination')->toArray();
        $data = [
            'serviceId' => $serviceId,
            'pages' => $pages,
            'unAvailablePages' => $unAvailablePages,
            'formRoute' => route('storeServiceQuestionnaire', ['serviceId' => $serviceId]),
            'submitBtn' => trans('admin.create')
        ];
        return view(AD . '.services.questionnaire_form')->with($data);
    }

    public function storeServiceQuestionnaire(CreateQuestionaireRequest $request, $serviceId)
    {
        $serviceId = ($serviceId == 0)? null : $serviceId;
        $questionnaire = new Questionnaire();
        ServiceClass::createOrUpdateQuestionnaire($questionnaire, $request, $serviceId);
        session()->flash('success_msg', trans('admin.success_message'));
        $serviceId = ($serviceId == null)? 0 : $serviceId;
        return redirect(AD . '/services/' . $serviceId . '/questionnaire');
    }

    public function editServiceQuestionnaire(Request $request, $serviceId, $questionnaireId)
    {
        $serviceId = ($serviceId == 0)? null : $serviceId;
        $pages = range(0, config('constants.max_questionnaire_pages'));
        unset($pages[0]);
        $unAvailablePages = Questionnaire::where('service_id', $serviceId)
            ->groupBy('pagination')
            ->havingRaw('count(pagination) >= ' . config('constants.max_questionnaire_per_page'))
            ->pluck('pagination')->toArray();
        $questionnaire = Questionnaire::find($questionnaireId);
        $serviceId = ($serviceId == null)? 0 : $serviceId;
        $data = [
            'serviceId' => $serviceId,
            'pages' => $pages,
            'unAvailablePages' => $unAvailablePages,
            'questionnaire' => $questionnaire,
            'formRoute' => route('updateServiceQuestionnaire', ['id' => $serviceId, 'questionnaireId' => $questionnaireId]),
            'submitBtn' => trans('admin.update')
        ];
        return view(AD . '.services.questionnaire_form')->with($data);
    }

    public function updateServiceQuestionnaire(UpdateQuestionnaireRequest $request, $serviceId, $questionnaireId)
    {
        $serviceId = ($serviceId == 0)? null : $serviceId;
        $questionnaire = Questionnaire::find($questionnaireId);
        ServiceClass::createOrUpdateQuestionnaire($questionnaire, $request, $serviceId);
        session()->flash('success_msg', trans('admin.success_message'));
        $serviceId = ($serviceId == null)? 0 : $serviceId;
        return redirect(AD . '/services/' . $serviceId . '/questionnaire');
    }

    public function getQuestionnaireDatatable($id)
    {
        $id = ($id == 0)? null : $id;
        $questionnaire = Questionnaire::where('service_id', $id);
        $dataTable = DataTables::of($questionnaire)
            ->addColumn('actions', function ($questionnaire) use ($id) {
                $id = ($id == null)? 0 : $id;
                $editURL = url(AD . '/services/' . $id . '/questionnaire/' . $questionnaire->id . '/edit');
                return View::make('Administrator.widgets.dataTablesActions', ['editURL' => $editURL]);
            })
            ->rawColumns(['actions'])
            ->make(true);
        return $dataTable;
    }

    public function deleteQuestionnaire(Request $request)
    {
        if (Gate::denies('service.delete', new Service())) {
            return response()->view('errors.403', [], 403);
        }
        $ids = $request->input('ids');
        return Questionnaire::whereIn('id', $ids)->delete();
    }

    public function getAvailablePageOrders(Request $request, $serviceId, $page)
    {
        $serviceId = ($serviceId == 0)? null : $serviceId;
        $ordersCount = range(0, config('constants.max_questionnaire_per_page'));
        unset($ordersCount[0]);
        $unAvailableOrders = Questionnaire::where([['service_id', $serviceId], ['pagination', $page]])
            ->pluck('order')->toArray();
        $data = [
            'ordersCount' => $ordersCount,
            'unAvailableOrders' => $unAvailableOrders
        ];
        return response()->json($data);
    }

    public function getQuestionnaireOptions(Request $request)
    {
        $questionnaireId = $request->input('id');
        $questionnaire = Questionnaire::find($questionnaireId);
        $questionnaire->options_ar = unserialize($questionnaire->options_ar);
        $questionnaire->options_en = unserialize($questionnaire->options_en);
        return response()->json($questionnaire);
    }

    public function getSymbolLevels(Request $request, $type)
    {
        $levels = 0;
        switch ($type) {
            case 0:
                $levels = config('constants.ratingSymbols.stars.max_rating_level');
                break;
            case 1:
                $levels = config('constants.ratingSymbols.numeric.max_rating_level');
                break;
        }
        $data = [
            "levels" => $levels
        ];
        return response()->json($data);
    }

    // calendar section

    public function showServiceCalendar($id)
    {
        $calendarSections = config('constants.calendarSections');
        $data = [
            'serviceID'       => $id,
            'calendarSections' => $calendarSections
        ];
        return view(AD . '.services.calendar_index')->with($data);
    }

    public function createServiceCalendar(Request $request, $serviceId)
    {
        $allCities = City::all()->pluck('city_name_eng', 'id')->toArray();
        $data = [
            'allCities' => $allCities,
            'formRoute' => route('storeServiceCalendar', ['service' => $serviceId]),
            'submitBtn' => trans('admin.create')
        ];
        return view(AD . '.services.calendar_form')->with($data);
    }

    public function storeServiceCalendar(CreateCalendarRequest $request, $serviceId)
    {
        $serviceCalendar = new ServicesCalendar();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $cityID = $request->input('city_id');
        if(ServiceClass::isExistCalendar($startDate, $endDate, $serviceId, false, $cityID)){
            return Redirect::back()->withErrors(['msg' => 'The slot you have picked conflicts with another one']);
        }
        ServiceClass::createOrUpdateCalendar($serviceCalendar, $request, $serviceId);
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/services/' . $serviceId . '/calendar');
    }

    public function editServiceCalendar(Request $request, $serviceId, $calendarId)
    {
        $calendar = ServicesCalendar::find($calendarId);
        $allCities = City::all()->pluck('city_name_eng', 'id')->toArray();
        $data = [
            'allCities' => $allCities,
            'calendar'  => $calendar,
            'formRoute' => route('updateServiceCalendar', ['id' => $serviceId, 'calendarId' => $calendarId]),
            'submitBtn' => trans('admin.update')
        ];
        return view(AD . '.services.calendar_form')->with($data);
    }

    public function updateServiceCalendar(UpdateCalendarRequest $request, $serviceId, $calendarId)
    {
        $serviceCalendar = ServicesCalendar::find($calendarId);
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $cityID = $request->input('city_id');
        if(ServiceClass::isExistCalendar($startDate, $endDate, $serviceId, $calendarId, $cityID)){
            return Redirect::back()->withErrors(['msg' => 'The slot you have picked conflicts with another one']);
        }
        ServiceClass::createOrUpdateCalendar($serviceCalendar, $request, $serviceId);
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/services/' . $serviceId . '/calendar');
    }

    public function getCalendarDatatable($id)
    {
        $serviceCalendar = ServicesCalendar::where('service_id', $id);
        $dataTable = DataTables::of($serviceCalendar)
            ->addColumn('actions', function ($calendar) use ($id) {
                $editURL = url(AD . '/services/' . $id . '/calendar/' . $calendar->id . '/edit');
                return View::make('Administrator.widgets.dataTablesActions', ['editURL' => $editURL]);
            })
            ->filterColumn('services_calendars.start_date', function ($query, $keyword) {
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
        if (Gate::denies('service.delete', new Service())) {
            return response()->view('errors.403', [], 403);
        }
        $ids = $request->input('ids');
        return ServicesCalendar::whereIn('id', $ids)->delete();
    }

    // Lap calendar section

    public function showServiceLapCalendar()
    {
        $calendarSections = config('constants.calendarSections');
        $data = [
            'calendarSections' => $calendarSections
        ];
        return view(AD . '.services.lap_calendar_index')->with($data);
    }

    public function createServiceLapCalendar(Request $request)
    {
        $allCities = City::all()->pluck('city_name_eng', 'id')->toArray();
        $data = [
            'allCities' => $allCities,
            'formRoute' => route('storeServiceLapCalendar'),
            'submitBtn' => trans('admin.create')
        ];
        return view(AD . '.services.lap_calendar_form')->with($data);
    }

    public function storeServiceLapCalendar(CreateCalendarRequest $request)
    {
        $lapCalendar = new LapCalendar();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $cityID = $request->input('city_id');
        if(ServiceClass::isExistLapCalendar($startDate, $endDate, false, $cityID)){
            return Redirect::back()->withErrors(['msg' => 'The slot you have picked conflicts with another one']);
        }
        ServiceClass::createOrUpdateLapCalendar($lapCalendar, $request);
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/lap/calendar');
    }

    public function editServiceLapCalendar(Request $request, $calendarId)
    {
        $calendar = LapCalendar::find($calendarId);
        $allCities = City::all()->pluck('city_name_eng', 'id')->toArray();
        $data = [
            'allCities' => $allCities,
            'calendar'  => $calendar,
            'formRoute' => route('updateServiceLapCalendar', ['calendarId' => $calendarId]),
            'submitBtn' => trans('admin.update')
        ];
        return view(AD . '.services.Lap_calendar_form')->with($data);
    }

    public function updateServiceLapCalendar(UpdateCalendarRequest $request, $calendarId)
    {
        $lapCalendar = LapCalendar::find($calendarId);
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        if(ServiceClass::isExistLapCalendar($startDate, $endDate, $calendarId)){
            return Redirect::back()->withErrors(['msg' => 'The slot you have picked conflicts with another one']);
        }
        ServiceClass::createOrUpdateLapCalendar($lapCalendar, $request);
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/lap/calendar');
    }

    public function getLapCalendarDatatable()
    {
        $serviceCalendar = LapCalendar::where('id', '<>', 0);
        $dataTable = DataTables::of($serviceCalendar)
            ->addColumn('actions', function ($calendar) {
                $editURL = url(AD . '/lap/calendar/' . $calendar->id . '/edit');
                return View::make('Administrator.widgets.dataTablesActions', ['editURL' => $editURL]);
            })
            ->filterColumn('lap_calendars.start_date', function ($query, $keyword) {
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

    public function deleteLapCalendar(Request $request)
    {
        if (Gate::denies('service.delete', new Service())) {
            return response()->view('errors.403', [], 403);
        }
        $ids = $request->input('ids');
        return LapCalendar::whereIn('id', $ids)->delete();
    }
}
