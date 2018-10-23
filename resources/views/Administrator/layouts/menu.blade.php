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
        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true"
            data-slide-speed="200" style="padding-top: 20px">
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
            @can('admins.view', \Illuminate\Support\Facades\Auth::user())
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
            @endcan
            <!-- End Admins Area -->
            <!-- Start Categories Area -->
            @can('category.view', new \App\Models\Category())
                <li class="nav-item start {{ (Request::segment(2)=='categories') ? 'active' :'' }}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-user-secret"></i>
                        <span class="title">{{ trans('admin.categories') }}</span>
                        <span class="selected"></span>
                        <span class="arrow {{ (Request::segment(2)=='categories') ? 'open' :'' }}"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item start {{ (Request::segment(2)=='categories' && Request::segment(3)=='create') ? 'active' :'' }}">
                            <a href="{{ url(AD.'/categories/create') }}" class="nav-link ">
                                <i class="fa fa-plus-circle"></i>
                                <span class="title">{{ trans('admin.add_category') }}</span>
                            </a>
                        </li>
                        <li class="nav-item start {{ (Request::is(AD.'/categories')) ? 'active' :'' }}">
                            <a href="{{ url(AD.'/categories') }}" class="nav-link ">
                                <i class="icon-user"></i>
                                <span class="title">{{ trans('admin.show_category') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            <!-- End Categories Area -->
            <!-- Start Lap Area -->
            @can('category.view', new \App\Models\Category())
                <li class="nav-item start {{ ((Request::segment(2)=='services' && Request::segment(3)=='lap') || (Request::segment(2)=='lap' && Request::segment(3)=='calendar')) ? 'active' :'' }}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-user-secret"></i>
                        <span class="title">{{ trans('admin.Lap') }}</span>
                        <span class="selected"></span>
                        <span class="arrow {{ (Request::segment(2)=='lap') ? 'open' :'' }}"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item start {{ (Request::segment(3)=='lap' && Request::segment(4)=='questionnaire' && Request::segment(5)=='create') ? 'active' :'' }}">
                            <a href="{{ url(AD.'/services/lap/questionnaire/create') }}" class="nav-link ">
                                <i class="fa fa-plus-circle"></i>
                                <span class="title">{{ trans('admin.add_questionnaire') }}</span>
                            </a>
                        </li>
                        <li class="nav-item start {{ (Request::segment(3)=='lap' && Request::segment(4)=='questionnaire' && Request::segment(5)== '') ? 'active' :'' }}">
                            <a href="{{ url(AD.'/services/lap/questionnaire') }}" class="nav-link ">
                                <i class="icon-user"></i>
                                <span class="title">{{ trans('admin.show_questionnaire') }}</span>
                            </a>
                        </li>
                        <li class="nav-item start {{ (Request::segment(2)=='lap' && Request::segment(3)=='calendar' && Request::segment(4)=='create') ? 'active' :'' }}">
                            <a href="{{ url(AD.'/lap/calendar/create') }}" class="nav-link ">
                                <i class="fa fa-plus-circle"></i>
                                <span class="title">{{ trans('admin.add_calendar') }}</span>
                            </a>
                        </li>
                        <li class="nav-item start {{ (Request::segment(2)=='lap' && Request::segment(3)=='calendar' && Request::segment(4)== '') ? 'active' :'' }}">
                            <a href="{{ url(AD.'/lap/calendar') }}" class="nav-link ">
                                <i class="icon-user"></i>
                                <span class="title">{{ trans('admin.show_calendar') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            <!-- End Lap Area -->
            <!-- Start Services Area -->
            @can('service.view', new \App\Models\Service())
                <li class="nav-item start {{ (Request::segment(2)=='services'&& Request::segment(3)!='lap') ? 'active' :'' }}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-user-secret"></i>
                        <span class="title">{{ trans('admin.services') }}</span>
                        <span class="selected"></span>
                        <span class="arrow {{ (Request::segment(2)=='services') ? 'open' :'' }}"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item start {{ (Request::segment(2)=='services' && Request::segment(3)=='create') ? 'active' :'' }}">
                            <a href="{{ url(AD.'/services/create') }}" class="nav-link ">
                                <i class="fa fa-plus-circle"></i>
                                <span class="title">{{ trans('admin.add_service') }}</span>
                            </a>
                        </li>
                        <li class="nav-item start {{ (Request::is(AD.'/services')) ? 'active' :'' }}">
                            <a href="{{ url(AD.'/services') }}" class="nav-link ">
                                <i class="icon-user"></i>
                                <span class="title">{{ trans('admin.show_service') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            <!-- End Services Area -->
            <!-- Start Providers Area -->
            @can('provider.view', new \App\Models\Provider())
                <li class="nav-item start {{ (Request::segment(2)=='providers') ? 'active' :'' }}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-user-secret"></i>
                        <span class="title">{{ trans('admin.providers') }}</span>
                        <span class="selected"></span>
                        <span class="arrow {{ (Request::segment(2)=='providers') ? 'open' :'' }}"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item start {{ (Request::segment(2)=='providers' && Request::segment(3)=='create') ? 'active' :'' }}">
                            <a href="{{ url(AD.'/providers/create') }}" class="nav-link ">
                                <i class="fa fa-plus-circle"></i>
                                <span class="title">{{ trans('admin.add_provider') }}</span>
                            </a>
                        </li>
                        <li class="nav-item start {{ (Request::is(AD.'/providers')) ? 'active' :'' }}">
                            <a href="{{ url(AD.'/providers') }}" class="nav-link ">
                                <i class="icon-user"></i>
                                <span class="title">{{ trans('admin.show_provider') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            <!-- End Providers Area -->
            <!-- Start promo_codes Area -->
            @can('promo_code.view', new \App\Models\PromoCode())
                <li class="nav-item start {{ (Request::segment(2)=='promo_codes') ? 'active' :'' }}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-user-secret"></i>
                        <span class="title">{{ trans('admin.promo_codes') }}</span>
                        <span class="selected"></span>
                        <span class="arrow {{ (Request::segment(2)=='promo_codes') ? 'open' :'' }}"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item start {{ (Request::segment(2)=='promo_codes' && Request::segment(3)=='create') ? 'active' :'' }}">
                            <a href="{{ url(AD.'/promo_codes/create') }}" class="nav-link ">
                                <i class="fa fa-plus-circle"></i>
                                <span class="title">{{ trans('admin.add_promo_code') }}</span>
                            </a>
                        </li>
                        <li class="nav-item start {{ (Request::is(AD.'/promo_codes')) ? 'active' :'' }}">
                            <a href="{{ url(AD.'/promo_codes') }}" class="nav-link ">
                                <i class="icon-user"></i>
                                <span class="title">{{ trans('admin.show_promo_code') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            <!-- End Promo_codes Area -->

            <!-- Start Customers Area -->
            @can('customers.view')
            <li class="nav-item start {{ (Request::segment(2)=='customers') ? 'active' :'' }}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-users"></i>
                    <span class="title">{{ trans('admin.customers') }}</span>
                    <span class="selected"></span>
                    <span class="arrow {{ (Request::segment(2)=='customers') ? 'open' :'' }}"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start {{ (Request::segment(2)=='customers' && Request::segment(3)=='create') ? 'active' :'' }}">
                        <a href="{{ url(AD.'/customers/create') }}" class="nav-link ">
                            <i class="fa fa-plus-circle"></i>
                            <span class="title">{{ trans('admin.add_customers') }}</span>
                        </a>
                    </li>
                    <li class="nav-item start {{ (Request::is(AD.'/customers')) ? 'active' :'' }}">
                        <a href="{{ url(AD.'/customers') }}" class="nav-link ">
                            <i class="fa fa-eye"></i>
                            <span class="title">{{ trans('admin.show_customers') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
            <!-- End Customers Area -->

            <!-- Start Family Members Area -->
            @can('family_member.view')
                <li class="nav-item start {{ (Request::segment(2)=='family-members') ? 'active' :'' }}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-users"></i>
                        <span class="title">{{ trans('admin.family_members') }}</span>
                        <span class="selected"></span>
                        <span class="arrow {{ (Request::segment(2)=='family-members') ? 'open' :'' }}"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item start {{ (Request::segment(2)=='family-members' && Request::segment(3)=='create') ? 'active' :'' }}">
                            <a href="{{ url(AD.'/family-members/create') }}" class="nav-link ">
                                <i class="fa fa-plus-circle"></i>
                                <span class="title">{{ trans('admin.add_family_members') }}</span>
                            </a>
                        </li>
                        <li class="nav-item start {{ (Request::is(AD.'/family-members')) ? 'active' :'' }}">
                            <a href="{{ url(AD.'/family-members') }}" class="nav-link ">
                                <i class="fa fa-eye"></i>
                                <span class="title">{{ trans('admin.show_family_members') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            <!-- End Family Members Area -->

            <!-- Start Booking Services Area -->
            @can('meetings.view')
                <li class="nav-item start {{ (Request::segment(2)=='meetings') ? 'active' :'' }}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-calendar"></i>
                        <span class="title">{{ trans('admin.booking_services') }}</span>
                        <span class="selected"></span>
                        <span class="arrow {{ (Request::segment(2)=='meetings') ? 'open' :'' }}"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item start {{ (Request::is(AD.'/meetings/canceled')) ? 'active' :'' }}">
                            <a href="{{ url(AD.'/meetings/canceled') }}" class="nav-link ">
                                <i class="fa fa-eye"></i>
                                <span class="title">{{ trans('admin.canceled_meetings') }}</span>
                            </a>
                        </li>
                        <li class="nav-item start {{ (Request::is(AD.'/meetings/inprogress')) ? 'active' :'' }}">
                            <a href="{{ url(AD.'/meetings/inprogress') }}" class="nav-link ">
                                <i class="fa fa-eye"></i>
                                <span class="title">{{ trans('admin.inprogress_meetings') }}</span>
                            </a>
                        </li>
                        <li class="nav-item start {{ (Request::is(AD.'/meetings/confirmed')) ? 'active' :'' }}">
                            <a href="{{ url(AD.'/meetings/confirmed') }}" class="nav-link ">
                                <i class="fa fa-eye"></i>
                                <span class="title">{{ trans('admin.confirmed_meetings') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan
            <!-- End Booking Services Area -->

            <!-- Start Invoices Area -->
            @can('invoices.view')
                <li class="nav-item start {{ (Request::segment(2)=='invoices') ? 'active' :'' }}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-money"></i>
                        <span class="title">{{ trans('admin.invoices') }}</span>
                        <span class="selected"></span>
                        <span class="arrow {{ (Request::segment(2)=='invoices') ? 'open' :'' }}"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item start {{ (Request::is(AD.'/invoices')) ? 'active' :'' }}">
                            <a href="{{ url()->route('show-invoices') }}" class="nav-link ">
                                <i class="fa fa-eye"></i>
                                <span class="title">{{ trans('admin.show_invoices') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            <!-- End Invoices Area -->

            <!-- Start Medical reports Area -->
            @can('medical_report.view', new \App\Models\MedicalReports())
                <li class="nav-item start {{ (Request::segment(2)=='medical_reports') ? 'active' :'' }}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-user-secret"></i>
                        <span class="title">{{ trans('admin.medical_reports') }}</span>
                        <span class="selected"></span>
                        <span class="arrow {{ (Request::segment(2)=='medical_reports') ? 'open' :'' }}"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item start {{ (Request::segment(2)=='medical_reports' && Request::segment(3)=='create') ? 'active' :'' }}">
                            <a href="{{ url(AD.'/medical_reports/create') }}" class="nav-link ">
                                <i class="fa fa-plus-circle"></i>
                                <span class="title">{{ trans('admin.add_medical_reports') }}</span>
                            </a>
                        </li>
                        <li class="nav-item start {{ (Request::is(AD.'/medical_reports')) ? 'active' :'' }}">
                            <a href="{{ url(AD.'/medical_reports') }}" class="nav-link ">
                                <i class="icon-user"></i>
                                <span class="title">{{ trans('admin.show_medical_reports') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            <!-- End Medical reports Area -->
            <!-- Start settings Area -->
            @can('settings.view', new \App\Models\Settings())
                <li class="nav-item start {{ (Request::segment(2)=='settings') ? 'active' :'' }}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-user-secret"></i>
                        <span class="title">{{ trans('admin.settings') }}</span>
                        <span class="selected"></span>
                        <span class="arrow {{ (Request::segment(2)=='settings') ? 'open' :'' }}"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item start {{ (Request::is(AD.'/settings')) ? 'active' :'' }}">
                            <a href="{{ url(AD.'/settings/1/edit') }}" class="nav-link ">
                                <i class="fa fa-eye"></i>
                                <span class="title">{{ trans('admin.settings') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            <!-- End settings Area -->

            <!-- Start Providers Guard Area -->
            @if(auth()->guard('provider-web')->user())
                @if(auth()->guard('provider-web')->user()->can('provider_guard.update'))
                    <li class="nav-item start {{ (Request::segment(2)=='providers') ? 'active' :'' }}">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-user-secret"></i>
                            <span class="title">{{ trans('admin.providers') }}</span>
                            <span class="selected"></span>
                            <span class="arrow {{ (Request::segment(2)=='providers') ? 'open' :'' }}"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item start {{ (Request::is(AD.'/providers')) ? 'active' :'' }}">
                                <a href="{{ url()->route('edit_provider',[auth()->guard('provider-web')->user()->id]) }}" class="nav-link ">
                                    <i class="fa fa-edit"></i>
                                    <span class="title">{{ trans('admin.edit_provider') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- Start Booking Services Area -->
                    @if(auth()->guard('provider-web')->user()->can('provider_guard.view'))
                        <li class="nav-item start {{ (Request::segment(2)=='meetings') ? 'active' :'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-calendar"></i>
                                <span class="title">{{ trans('admin.booking_services') }}</span>
                                <span class="selected"></span>
                                <span class="arrow {{ (Request::segment(2)=='meetings') ? 'open' :'' }}"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item start {{ (Request::is(AD.'/meetings/canceled')) ? 'active' :'' }}">
                                    <a href="{{ url(AD.'/meetings/canceled') }}" class="nav-link ">
                                        <i class="fa fa-eye"></i>
                                        <span class="title">{{ trans('admin.canceled_meetings') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item start {{ (Request::is(AD.'/meetings/inprogress')) ? 'active' :'' }}">
                                    <a href="{{ url(AD.'/meetings/inprogress') }}" class="nav-link ">
                                        <i class="fa fa-eye"></i>
                                        <span class="title">{{ trans('admin.inprogress_meetings') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item start {{ (Request::is(AD.'/meetings/confirmed')) ? 'active' :'' }}">
                                    <a href="{{ url(AD.'/meetings/confirmed') }}" class="nav-link ">
                                        <i class="fa fa-eye"></i>
                                        <span class="title">{{ trans('admin.confirmed_meetings') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                <!-- End Booking Services Area -->
            @endif
        <!-- End Providers Guard Area -->
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>