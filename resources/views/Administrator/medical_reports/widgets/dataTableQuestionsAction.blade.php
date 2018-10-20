@if(isset($questionsURL) && $questionsURL != "")
    <a href="{{ $questionsURL }}" class="btn btn-outline btn-circle btn-sm yellow">
        <i class="fa fa-book"></i>
    </a>
    @if(isset($addQuestionsURL) && $addQuestionsURL != "")
        <a href="{{ $addQuestionsURL }}" class="btn btn-outline btn-circle btn-sm red">
            <i class="fa fa-bookmark"></i>
        </a>
    @endif
@endif
@if(isset($approveURL) && $approveURL != "")
    <a href="{{ $approveURL }}" class="btn btn-outline btn-circle btn-sm green">
        <i class="fa fa-check"></i>
    </a>
@endif
@if(isset($editURL) && $editURL != "")
    @include('Administrator.widgets.dataTablesActions', ['editURL' => $editURL])
@endif
