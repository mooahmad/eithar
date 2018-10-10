@if(isset($questionsURL) && $questionsURL != "")
    <a href="{{ $questionsURL }}" class="btn btn-outline btn-circle btn-sm yellow">
        <i class="fa fa-book"></i>
    </a>
    <a href="{{ $addQuestionsURL }}" class="btn btn-outline btn-circle btn-sm red">
        <i class="fa fa-bookmark"></i>
    </a>
@endif
@include('Administrator.widgets.dataTablesActions', ['editURL' => $editURL])
