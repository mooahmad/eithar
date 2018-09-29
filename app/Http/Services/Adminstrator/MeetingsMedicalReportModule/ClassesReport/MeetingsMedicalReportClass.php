<?php

namespace App\Http\Services\Adminstrator\MeetingsMedicalReportModule\ClassesReport;


use App\Helpers\Utilities;
use App\Models\MedicalReports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

class MeetingsMedicalReportClass
{

    public static function createOrUpdate($bookingMedicalReport, $providerId, $bookingId, $medicalReportId, $originalName, $filePath)
    {
        $bookingMedicalReport->provider_id = $providerId;
        $bookingMedicalReport->service_booking_id = $bookingId;
        $bookingMedicalReport->medical_report_id = $medicalReportId;
        $bookingMedicalReport->original_name = $originalName;
        $bookingMedicalReport->filled_file_path = $filePath;
        $bookingMedicalReport->is_approved = 0;
        $bookingMedicalReport->customer_can_view = 0;
        return $bookingMedicalReport->save();
    }

}