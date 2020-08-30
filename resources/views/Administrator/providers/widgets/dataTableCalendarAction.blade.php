<a href="{{ $calendarURL }}" class="btn btn-outline btn-circle btn-sm yellow">
    <i class="fa fa-calendar"></i>
</a>
<a href="{{ $addCalendarURL }}" class="btn btn-outline btn-circle btn-sm red">
    <i class="fa fa-plus"></i>
</a>

<a href="{{ $meetings }}" class="btn btn-outline btn-circle btn-sm red">
    <i class="fa fa-calendar"></i>
</a>

@include('Administrator.widgets.dataTablesActions', ['editURL' => $editURL])
