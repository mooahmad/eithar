<?php

namespace App\Http\Services\Adminstrator\MedicalReportModule\ClassesReport;


use App\Helpers\Utilities;
use App\Models\BookingMedicalReportsAnswers;
use App\Models\MedicalReports;
use App\Models\MedicalReportsQuestions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

class MedicalReportClass
{

    public static function createOrUpdate(MedicalReports $medicalReport, $serviceId, $isGeneral, $isPublished, $customerCanView, $titleAr, $titleEn)
    {
        $medicalReport->service_id = $serviceId;
        $medicalReport->provider_id = Auth::id();
        $medicalReport->title_ar = $titleAr;
        $medicalReport->title_en = $titleEn;
        $medicalReport->is_general = $isGeneral;
        $medicalReport->is_published = $isPublished;
        $medicalReport->customer_can_view = $customerCanView;
        return $medicalReport->save();
    }

    public static function createOrUpdateMedicalReportQuestion(MedicalReportsQuestions $medicalReport, $request, $medicalReportId)
    {
        $medicalReport->medical_report_id = $medicalReportId;
        $medicalReport->title_ar = $request->input('title_ar');
        $medicalReport->title_en = $request->input('title_en');
        $medicalReport->type = $request->input('type');
        $medicalReport->type_description = $request->input('type_description');
        $medicalReport->is_required = $request->input('is_required');
        $medicalReport->options_ar = serialize($request->input('options_ar', ''));
        $medicalReport->options_en = serialize($request->input('options_en', ''));
        $medicalReport->pagination = $request->input('page');
        $medicalReport->order = $request->input('order');
        return $medicalReport->save();
    }

    public static function createOrUpdateMedicalReportApproveQuestion(BookingMedicalReportsAnswers $medicalReport, $request, $medicalReportId)
    {
        $medicalReport->booking_report_id = $medicalReportId;
        $medicalReport->title_ar = $request->input('title_ar');
        $medicalReport->title_en = $request->input('title_en');
        $medicalReport->type = $request->input('type');
        $medicalReport->is_required = $request->input('is_required');
        $medicalReport->options_ar = serialize($request->input('options_ar', ''));
        $medicalReport->options_en = serialize($request->input('options_en', ''));
        $medicalReport->answer = serialize($request->input('answer', ''));
        $medicalReport->pagination = $request->input('page');
        $medicalReport->order = $request->input('order');
        return $medicalReport->save();
    }

}