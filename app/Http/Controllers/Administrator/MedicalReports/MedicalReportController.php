<?php

namespace App\Http\Controllers\Administrator\MedicalReports;


use App\Http\Controllers\Controller;
use App\Http\Requests\MedicalReports\CreateMedicalReportRequest;
use App\Http\Requests\MedicalReports\UpdateMedicalReportRequest;
use App\Http\Services\Adminstrator\MedicalReportModule\ClassesReport\MedicalReportClass;
use App\Models\MedicalReports;
use App\Models\MedicalReportsQuestions;
use App\Models\Service;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;


class MedicalReportController extends Controller
{
    /**
     * MedicalReportController constructor.
     */
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
        $services = Service::where('type', '<>', 4)->pluck('name_en', 'id')->toArray();
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
        $titleAr = $request->input('title_ar', null);
        $titleEn = $request->input('title_en', null);
        $isGeneral = $request->input('is_general', null);
        $isLap = $request->input('is_lap', null);
        $customerCanView = $request->input('customer_can_view', null);
        if ($isGeneral != null && $isGeneral != 0)
            $serviceId = null;
        elseif (($isGeneral == 0 || $isGeneral == null) && $isLap)
            $serviceId = 0;
        $medicalReport = new MedicalReports();
        MedicalReportClass::createOrUpdate($medicalReport, $serviceId, $isGeneral, 0, $customerCanView, $titleAr, $titleEn);
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
        $services = Service::where('type', '<>', 4)->pluck('name_en', 'id')->toArray();
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
        $titleAr = $request->input('title_ar', null);
        $titleEn = $request->input('title_en', null);
        $isGeneral = $request->input('is_general', null);
        $isLap = $request->input('is_lap', null);
        $customerCanView = $request->input('customer_can_view', null);
        if ($isGeneral != null && $isGeneral != 0)
            $serviceId = null;
        elseif (($isGeneral == 0 || $isGeneral == null) && $isLap)
            $serviceId = 0;
        MedicalReportClass::createOrUpdate($medicalReport, $serviceId, $isGeneral, 0, $customerCanView, $titleAr, $titleEn);
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
                $medicalReportId = $medicalReport->id;
                $editURL = url(AD . '/medical_reports/' . $medicalReportId . '/edit');
                $questionsURL = url(AD . '/medical_reports/' . $medicalReportId . '/questions');
                $addQuestionsURL = url(AD . '/medical_reports/' . $medicalReportId . '/questions/create');
                return View::make('Administrator.medical_reports.widgets.dataTableQuestionsAction', ['editURL' => $editURL,
                    'questionsURL' => $questionsURL, 'addQuestionsURL' => $addQuestionsURL]);
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
            'medicalReportId' => $id,
        ];
        return view(AD . '.medical_reports.medical_reports_question_index')->with($data);
    }

    public function createMedicalReportsQuestions(Request $request, $medicalReportId)
    {
        $pages = range(0, config('constants.max_questionnaire_pages'));
        unset($pages[0]);
        $unAvailablePages = MedicalReportsQuestions::where('medical_report_id', $medicalReportId)
            ->groupBy('pagination')
            ->havingRaw('count(pagination) >= ' . config('constants.max_questionnaire_per_page'))
            ->pluck('pagination')->toArray();
        $data = [
            'medicalReportId' => $medicalReportId,
            'pages' => $pages,
            'unAvailablePages' => $unAvailablePages,
            'formRoute' => route('storeMedicalReportsQuestions', ['medicalReportId' => $medicalReportId]),
            'submitBtn' => trans('admin.create')
        ];
        return view(AD . '.medical_reports.medical_reports_question_form')->with($data);
    }

    public function storeMedicalReportsQuestions(CreateMedicalReportRequest $request, $medicalReportId)
    {
        $medicalReportQuestion = new MedicalReportsQuestions();
        MedicalReportClass::createOrUpdateMedicalReportQuestion($medicalReportQuestion, $request, $medicalReportId);
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/medical_reports/' . $medicalReportId . '/questions');
    }

    public function editMedicalReportsQuestions(Request $request, $medicalReportId, $medicalReportQuestionId)
    {
        $pages = range(0, config('constants.max_questionnaire_pages'));
        unset($pages[0]);
        $unAvailablePages = MedicalReportsQuestions::where('medical_report_id', $medicalReportId)
            ->groupBy('pagination')
            ->havingRaw('count(pagination) >= ' . config('constants.max_questionnaire_per_page'))
            ->pluck('pagination')->toArray();
        $medicalReportQuestion = MedicalReportsQuestions::find($medicalReportQuestionId);
        $data = [
            'medicalReportId' => $medicalReportId,
            'pages' => $pages,
            'unAvailablePages' => $unAvailablePages,
            'medicalReportQuestion' => $medicalReportQuestion,
            'formRoute' => route('updateMedicalReportsQuestions', ['id' => $medicalReportId, 'medicalReportQuestionId' => $medicalReportQuestionId]),
            'submitBtn' => trans('admin.update')
        ];
        return view(AD . '.medical_reports.medical_reports_question_form')->with($data);
    }

    public function updateMedicalReportsQuestions(UpdateMedicalReportRequest $request, $medicalReportId, $medicalReportQuestionId)
    {
        $medicalReportQuestion = MedicalReportsQuestions::find($medicalReportQuestionId);
        MedicalReportClass::createOrUpdateMedicalReportQuestion($medicalReportQuestion, $request, $medicalReportId);
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/medical_reports/' . $medicalReportId . '/questions');
    }

    public function getMedicalReportsQuestionsDatatable($id)
    {
        $medicalReportsQuestions = MedicalReportsQuestions::where('medical_report_id', $id);
        $dataTable = DataTables::of($medicalReportsQuestions)
            ->addColumn('actions', function ($medicalReportsQuestion) use ($id) {
                $editURL = url(AD . '/medical_reports/' . $id . '/questions/' . $medicalReportsQuestion->id . '/edit');
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

    public function getAvailableMedicalReportsQuestionsPageOrders(Request $request, $medicalReportId, $page)
    {
        $ordersCount = range(0, config('constants.max_questionnaire_per_page'));
        unset($ordersCount[0]);
        $unAvailableOrders = MedicalReportsQuestions::where([['medical_report_id', $medicalReportId], ['pagination', $page]])
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
        $medicalReport = MedicalReportsQuestions::find($medicalReportId);
        $medicalReport->options_ar = unserialize($medicalReport->options_ar);
        $medicalReport->options_en = unserialize($medicalReport->options_en);
        return response()->json($medicalReport);
    }

}