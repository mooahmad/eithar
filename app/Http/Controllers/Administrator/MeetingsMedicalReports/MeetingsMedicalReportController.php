<?php

namespace App\Http\Controllers\Administrator\MeetingsMedicalReports;


use App\Helpers\Utilities;
use App\Http\Controllers\Controller;
use App\Http\Requests\MeetingsMedicalReports\CreateMeetingMedicalReportRequest;
use App\Http\Requests\MeetingsMedicalReports\UpdateMeetingMedicalReportRequest;
use App\Http\Services\Adminstrator\MedicalReportModule\ClassesReport\MedicalReportClass;
use App\Http\Services\WebApi\UsersModule\AbstractUsers\Provider;
use App\Models\BookingMedicalReports;
use App\Models\MedicalReports;
use App\Models\Service;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;


class MeetingsMedicalReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('AdminAuth')->except(['index','getMedicalReportsDataTable']);
    }

    public function index($id)
    {
        if (Gate::allows('medical_report.view', new MedicalReports()) || Gate::forUser(auth()->guard('provider-web')->user())->allows('provider_guard.view')) {
            return view(AD . '.meetings_medical_reports.index', ["meetingId" => $id]);
        }
        return response()->view('errors.403', [], 403);
    }

    /**
     *
     */
    public function create($id)
    {
        if (Gate::denies('medical_report.create', new MedicalReports())) {
            return response()->view('errors.403', [], 403);
        }
        $reports = [];
        $availableReports = (new Provider())->getBookingAvailableReports(null, $id)->errorMessages->get('reports');
        foreach ($availableReports as $availableReport) {
            $availableReport = json_decode($availableReport);
            $reports[$availableReport->id] = $availableReport->original_name;
        }
        $data = [
            'meetingId' => $id,
            'availableReports' => $reports,
            'formRoute' => route('storeMeetingReport', ["id" => $id]),
            'submitBtn' => trans('admin.create')
        ];
        return view(AD . '.meetings_medical_reports.form')->with($data);
    }

    /**
     * @param Request $request
     */
    public function store(CreateMeetingMedicalReportRequest $request)
    {
        if (Gate::denies('medical_report.create', new MedicalReports())) {
            return response()->view('errors.403', [], 403);
        }
        $serviceId = $request->input('service', null);
        $isGeneral = $request->input('is_general', null);
        $customerCanView = $request->input('customer_can_view', null);
        $fileDirectory = 'public/bookings/' . '$bookingId' . '/reports';
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
    public function update(UpdateMeetingMedicalReportRequest $request, $id)
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

    public function getMedicalReportsDataTable($id)
    {
        $medicalReports = BookingMedicalReports::where('service_booking_id', $id);
        $dataTable = DataTables::of($medicalReports)
            ->addColumn('actions', function ($medicalReport) use ($id) {
                $editURL = url(AD . '/meetings/' . $id . '/report/' . $medicalReport->id . '/edit');
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
        return BookingMedicalReports::whereIn('id', $ids)->delete();
    }

}