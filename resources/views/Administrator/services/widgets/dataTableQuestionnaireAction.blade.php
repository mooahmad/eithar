<a href="{{ $questionnaireURL }}" class="btn btn-outline btn-circle btn-sm yellow">
    <i class="fa fa-calendar"></i>
</a>
<a href="{{ $addQuestionnaireURL }}" class="btn btn-outline btn-circle btn-sm red">
    <i class="fa fa-plus"></i>
</a>
@include('Administrator.widgets.dataTablesActions', ['editURL' => $editURL])
