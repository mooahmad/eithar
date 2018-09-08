@if(!empty($editURL))
    <a href="{{ $editURL }}" class="btn btn-outline btn-circle btn-sm purple">
        <i class="fa fa-edit"></i>
    </a>
@endif

@if(!empty($showURL))
    <a href="{{ $showURL }}" class="btn btn-outline btn-circle btn-sm green-jungle">
        <i class="fa fa-eye"></i>
    </a>
@endif