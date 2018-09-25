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

}