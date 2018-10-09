<?php

namespace App\Http\Controllers\Administrator\MedicalReports;


use App\Helpers\Utilities;
use App\Http\Controllers\Controller;
use App\Http\Requests\MedicalReports\CreateMedicalReportRequest;
use App\Http\Requests\MedicalReports\UpdateMedicalReportRequest;
use App\Http\Services\Adminstrator\MedicalReportModule\ClassesReport\MedicalReportClass;
use App\Models\MedicalReports;
use App\Models\Service;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;


class MedicalReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('AdminAuth');
    }

    public function index()
    {
        if (Gate::denies('medical_report.view', new MedicalReports())) {
            return response()->view('errors.403', [], 403);
        }
        return view(AD . '.medical_reports.index');
    }

    /**
     *
     */
    public function create()
    {
        if (Gate::denies('medical_report.create', new MedicalReports())) {
            return response()->view('errors.403', [], 403);
        }
        $services = Service::all()->pluck('name_en', 'id')->toArray();
        $data = [
            'services' => $services,
            'formRoute' => route('medical_reports.store'),
            'submitBtn' => trans('admin.create')
        ];
        return view(AD . '.medical_reports.form')->with($data);
    }

    /**
     * @param Request $request
     */
    public function store(CreateMedicalReportRequest $request)
    {
        if (Gate::denies('medical_report.create', new MedicalReports())) {
            return response()->view('errors.403', [], 403);
        }
        $serviceId = $request->input('service', null);
        $isGeneral = $request->input('is_general', null);
        $customerCanView = $request->input('customer_can_view', null);
        $fileDirectory = 'public/services/' . $serviceId . '/reports';
        if ($isGeneral == 1) {
            $serviceId = null;
            $fileDirectory = 'public/services/general/reports';
        }
        $filePath = Utilities::UploadFile($request->file('report'), $fileDirectory);
        $fileOriginalName = $request->file('report')->getClientOriginalName();
        $medicalReport = new MedicalReports();
        MedicalReportClass::createOrUpdate($medicalReport, $serviceId, $isGeneral, 0, $customerCanView, $filePath, $fileOriginalName);
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/medical_reports');
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
        if (Gate::denies('medical_report.update', new MedicalReports())) {
            return response()->view('errors.403', [], 403);
        }
        $report = MedicalReports::FindOrFail($id);
        $services = Service::all()->pluck('name_en', 'id')->toArray();
        $data = [
            'report' => $report,
            'services' => $services,
            'formRoute' => route('medical_reports.update', ['medical_report' => $id]),
            'submitBtn' => trans('admin.update')
        ];
        return view(AD . '.medical_reports.form')->with($data);
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(UpdateMedicalReportRequest $request, $id)
    {
        if (Gate::denies('medical_report.update', new MedicalReports())) {
            return response()->view('errors.403', [], 403);
        }
        $medicalReport = MedicalReports::findOrFail($id);
        $serviceId = $request->input('service', null);
        $isGeneral = $request->input('is_general', null);
        $customerCanView = $request->input('customer_can_view', null);
        $fileDirectory = 'public/services/' . $serviceId . '/reports';
        if ($isGeneral == 1) {
            $serviceId = null;
            $fileDirectory = 'public/services/general/reports';
        }
        $filePath = $medicalReport->file_path;
        $fileOriginalName = $medicalReport->original_name;
        if ($request->hasFile('report')) {
            $filePath = Utilities::UploadFile($request->file('report'), $fileDirectory);
            $fileOriginalName = $request->file('report')->getClientOriginalName();
        }
        MedicalReportClass::createOrUpdate($medicalReport, $serviceId, $isGeneral, 0, $customerCanView, $filePath, $fileOriginalName);
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/medical_reports');
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        //
    }

    public function getMedicalReportsDataTable()
    {
        $medicalReports = MedicalReports::where('id', '<>', null);
        $dataTable = DataTables::of($medicalReports)
            ->addColumn('actions', function ($medicalReport) {
                $editURL = url(AD . '/medical_reports/' . $medicalReport->id . '/edit');
                return View::make('Administrator.widgets.dataTablesActions', ['editURL' => $editURL]);
            })
            ->rawColumns(['actions'])
            ->make(true);
        return $dataTable;
    }

    public function deleteMedicalReports(Request $request)
    {
        if (Gate::denies('medical_report.delete', new MedicalReports())) {
            return response()->view('errors.403', [], 403);
        }
        $ids = $request->input('ids');
        return MedicalReports::whereIn('id', $ids)->delete();
    }

    // medical reports questions section

    public function showMedicalReportsQuestions($id)
    {
        $data = [
            'serviceId' => $id,
        ];
        return view(AD . '.services.medical_reports_index')->with($data);
    }

    public function createMedicalReportsQuestions(Request $request, $serviceId)
    {
        $pages = range(0, config('constants.max_questionnaire_pages'));
        unset($pages[0]);
        $unAvailablePages = MedicalReports::where('service_id', $serviceId)
            ->groupBy('pagination')
            ->havingRaw('count(pagination) >= ' . config('constants.max_questionnaire_per_page'))
            ->pluck('pagination')->toArray();
        $data = [
            'serviceId' => $serviceId,
            'pages' => $pages,
            'unAvailablePages' => $unAvailablePages,
            'formRoute' => route('storeMedicalReports', ['serviceId' => $serviceId]),
            'submitBtn' => trans('admin.create')
        ];
        return view(AD . '.services.medical_reports_form')->with($data);
    }

    public function storeMedicalReportsQuestions(CreateMedicalReportRequest $request, $serviceId)
    {
        $serviceId = ($serviceId == "lap") ? null : $serviceId;
        $medicalReport = new MedicalReports();
        ServiceClass::createOrUpdateMedicalReport($medicalReport, $request, $serviceId);
        session()->flash('success_msg', trans('admin.success_message'));
        $serviceId = ($serviceId == null) ? "lap" : $serviceId;
        return redirect(AD . '/services/' . $serviceId . '/medical_reports');
    }

    public function editMedicalReportsQuestions(Request $request, $serviceId, $medicalReportId)
    {
        $serviceId = ($serviceId == "lap") ? null : $serviceId;
        $pages = range(0, config('constants.max_questionnaire_pages'));
        unset($pages[0]);
        $unAvailablePages = MedicalReports::where('service_id', $serviceId)
            ->groupBy('pagination')
            ->havingRaw('count(pagination) >= ' . config('constants.max_questionnaire_per_page'))
            ->pluck('pagination')->toArray();
        $medicalReport = MedicalReports::find($medicalReportId);
        $serviceId = ($serviceId == null) ? "lap" : $serviceId;
        $data = [
            'serviceId' => $serviceId,
            'pages' => $pages,
            'unAvailablePages' => $unAvailablePages,
            'medicalReport' => $medicalReport,
            'formRoute' => route('updateMedicalReports', ['id' => $serviceId, 'medicalReportId' => $medicalReportId]),
            'submitBtn' => trans('admin.update')
        ];
        return view(AD . '.services.medical_reports_form')->with($data);
    }

    public function updateMedicalReportsQuestions(UpdateMedicalReportRequest $request, $serviceId, $medicalReportId)
    {
        $serviceId = ($serviceId == "lap") ? null : $serviceId;
        $medicalReport = MedicalReports::find($medicalReportId);
        ServiceClass::createOrUpdateMedicalReport($medicalReport, $request, $serviceId);
        session()->flash('success_msg', trans('admin.success_message'));
        $serviceId = ($serviceId == null) ? "lap" : $serviceId;
        return redirect(AD . '/services/' . $serviceId . '/medical_reports');
    }

    public function getMedicalReportsQuestionsDatatable($id)
    {
        $id = ($id == "lap") ? null : $id;
        $medicalReports = MedicalReports::where('service_id', $id);
        $dataTable = DataTables::of($medicalReports)
            ->addColumn('actions', function ($medicalReport) use ($id) {
                $id = ($id == null) ? "lap" : $id;
                $editURL = url(AD . '/services/' . $id . '/medical_reports/' . $medicalReport->id . '/edit');
                return View::make('Administrator.widgets.dataTablesActions', ['editURL' => $editURL]);
            })
            ->rawColumns(['actions'])
            ->make(true);
        return $dataTable;
    }

    public function deleteMedicalReportsQuestions(Request $request)
    {
        if (Gate::denies('service.delete', new Service())) {
            return response()->view('errors.403', [], 403);
        }
        $ids = $request->input('ids');
        return MedicalReports::whereIn('id', $ids)->delete();
    }

    public function getAvailableMedicalReportsQuestionsPageOrders(Request $request, $serviceId, $page)
    {
        $serviceId = ($serviceId == "lap") ? null : $serviceId;
        $ordersCount = range(0, config('constants.max_questionnaire_per_page'));
        unset($ordersCount[0]);
        $unAvailableOrders = MedicalReports::where([['service_id', $serviceId], ['pagination', $page]])
            ->pluck('order')->toArray();
        $data = [
            'ordersCount' => $ordersCount,
            'unAvailableOrders' => $unAvailableOrders
        ];
        return response()->json($data);
    }

    public function getMedicalReportsQuestionsOptions(Request $request)
    {
        $medicalReportId = $request->input('id');
        $medicalReport = MedicalReports::find($medicalReportId);
        $medicalReport->options_ar = unserialize($medicalReport->options_ar);
        $medicalReport->options_en = unserialize($medicalReport->options_en);
        return response()->json($medicalReport);
    }

}