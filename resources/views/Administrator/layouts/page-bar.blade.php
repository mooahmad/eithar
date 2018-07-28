<div class="page-bar">
    <ul class="page-breadcrumb  col-md-6">
        <li>
            <a href="{{ url(AD.'/home') }}">Home</a>
            <i class="fa fa-circle"></i>
        </li>

        <?php $sublink=''; ?>
        @for($i=2; $i<=4; $i++)
            @if(!empty(Request::segment($i)) )
                <?php $sublink .= '/'.Request::segment($i); ?>
                @if(is_numeric(Request::segment($i)) && Request::segment($i+1) =='edit' || Request::segment($i)=='home' || is_numeric(Request::segment($i)))
                    <?php continue; ?>
                @else
                    <li>
                        <a href="{{url('Administrator'.$sublink)}}">
                            @if(is_numeric(Request::segment($i)))
                                {{Request::segment($i)}}
                            @else
                                {{trans('admin.'.Request::segment($i))}}
                            @endif
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                @endif
            @endif
        @endfor
    </ul>
    <style type="text/css">
        .alert{margin-bottom: 0px !important;}
    </style>
    <div class="page-toolbar  col-md-6">
        @if(Session::has('error_msg'))
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button> {{ session()->get('error_msg') }}
            </div>
        @endif

        @if(Session::has('success_msg'))
            <div class="alert alert-success">
                <button class="close" data-close="alert"></button> {{ session()->get('success_msg') }}
            </div>
        @endif
    </div>
</div>