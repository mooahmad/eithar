@if(!empty($URLs))
    @foreach($URLs as $key=>$URL)
            <a href="{{ $URL['link'] }}" target="{{ (isset($URL['target'])) ? $URL['target'] : '_blank' }}" class="btn btn-outline btn-circle btn-sm {{ (isset($URL['color'])) ? $URL['color'] : 'purple' }}">
                <i class="fa fa-{{ (isset($URL['icon'])) ? $URL['icon'] : 'eye' }}"></i>
            </a>
    @endforeach
@endif