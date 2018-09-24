<?php

namespace App\Http\Services\Adminstrator\MedicalReportModule\ClassesReport;


use App\Helpers\Utilities;
use App\Models\MedicalReports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

class MedicalReportClass
{

    public static function createOrUpdate(MedicalReports $medicalReport, $serviceId, $isGeneral, $isPublished, $customerCanView, $filePath)
    {
        $medicalReport->service_id = $serviceId;
        $medicalReport->user_id = Auth::id();
        $medicalReport->is_general = $isGeneral;
        $medicalReport->is_published = $isPublished;
        $medicalReport->customer_can_view = $customerCanView;
        $medicalReport->file_path = $filePath;
        return $medicalReport->save();
    }

}