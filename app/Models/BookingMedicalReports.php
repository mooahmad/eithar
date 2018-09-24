<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingMedicalReports extends Model
{
    use SoftDeletes;

    public $timestamps = true;
    protected $table = 'booking_medical_reports';
    protected $dateFormat = 'Y-m-d H:m:s';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
