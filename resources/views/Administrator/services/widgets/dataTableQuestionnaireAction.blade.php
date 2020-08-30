@if(isset($questionnaireURL) && $questionnaireURL != "")
    <a href="{{ $questionnaireURL }}" class="btn btn-outline btn-circle btn-sm yellow">
    <i class="fa fa-list"></i>
</a>
<a href="{{ $addQuestionnaireURL }}" class="btn btn-outline btn-circle btn-sm red">
    <i class="fa fa-info"></i>
</a>
@endif
@if(isset($medicalReportURL) && $medicalReportURL != "")
    <a href="{{ $medicalReportURL }}" class="btn btn-outline btn-circle btn-sm yellow">
        <i class="fa fa-book"></i>
    </a>
    <a href="{{ $addMedicalReportURL }}" class="btn btn-outline btn-circle btn-sm red">
        <i class="fa fa-bookmark"></i>
    </a>
@endif
@if(isset($calendarURL) && $calendarURL != "")
<a href="{{ $calendarURL }}" class="btn btn-outline btn-circle btn-sm yellow">
    <i class="fa fa-calendar"></i>
</a>
<a href="{{ $addCalendarURL }}" class="btn btn-outline btn-circle btn-sm red">
    <i class="fa fa-plus"></i>
</a>
@endif
@include('Administrator.widgets.dataTablesActions', ['editURL' => $editURL])
