<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>
            <!-- END SIDEBAR TOGGLER BUTTON -->
            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
            <li class="sidebar-search-wrapper">
                <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                {!! Form::open(['method'=>'get','url'=>url(AD.'/admins'),'class'=>'sidebar-search']) !!}
                    <a href="javascript:;" class="remove">
                        <i class="icon-close"></i>
                    </a>
                    <div class="input-group has-error">
                        {!! Form::text('search',old('search'),['class'=>'form-control','placeholder'=>trans('admin.admins'),'required'=>'required']) !!}
                        <span class="input-group-btn">
                            <button type="submit" class="btn submit"><i class="icon-magnifier"></i></button>
                        </span>
                    </div>
                @if($errors->has('search'))
                    <span class="text-danger">{{ $errors->first('search') }}</span>
                @endif
                {!! Form::close() !!}
                <!-- END RESPONSIVE QUICK SEARCH FORM -->
            </li>

            <li class="heading">
                <h3 class="uppercase">Dashboard</h3>
            </li>
            <!-- Start Admins Area -->
            <li class="nav-item start {{ (Request::segment(2)=='admins') ? 'active' :'' }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-user-secret"></i>
                    <span class="title">{{ trans('admin.admins') }}</span>
                    <span class="selected"></span>
                    <span class="arrow {{ (Request::segment(2)=='admins') ? 'open' :'' }}"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start {{ (Request::segment(2)=='admins' && Request::segment(3)=='create') ? 'active' :'' }}">
                        <a href="{{ url(AD.'/admins/create') }}" class="nav-link ">
                            <i class="fa fa-plus-circle"></i>
                            <span class="title">{{ trans('admin.add_admin') }}</span>
                        </a>
                    </li>
                    <li class="nav-item start {{ (Request::is(AD.'/admins')) ? 'active' :'' }}">
                        <a href="{{ url(AD.'/admins') }}" class="nav-link ">
                            <i class="icon-user"></i>
                            <span class="title">{{ trans('admin.show_admin') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Admins Area -->
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>