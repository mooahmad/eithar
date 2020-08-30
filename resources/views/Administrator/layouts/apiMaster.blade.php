@include(ADL.'.apiHeader')

@yield('content')

@include(ADL.'.delete_popup',['route'=>'Home'])

@include(ADL.'.apiFooter')