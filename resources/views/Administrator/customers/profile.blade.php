@extends(ADL.'.master')

@section('style')
    <link href="{{ asset('public/assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css"/>
@stop

@section('content')

    <div class="profile">
        <div class="tabbable-line tabbable-full-width">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab_Overview" data-toggle="tab"> Overview </a>
                </li>
                <li>
                    <a href="#tab_appointments" data-toggle="tab"> Latest Appointments </a>
                </li>
                @if(!empty($customer->notifications))
                    <li>
                        <a href="#tab_notifications" data-toggle="tab"> Notifications </a>
                    </li>
                @endif
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_Overview">
                    <div class="row">
                        <div class="col-md-3">
                            <ul class="list-unstyled profile-nav">
                                <li>
                                    <img src="{{ \App\Helpers\Utilities::getFileUrl($customer->profile_picture_path) }}" class="img-responsive pic-bordered" alt="{{ $customer->full_name }}" />
                                    <a href="{{ url()->route('edit_customers',[$customer->id]) }}" target="_blank" class="profile-edit"> Edit </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-12 profile-info">
                                    <h1 class="font-green sbold uppercase">
                                        {{ $customer->full_name }}
                                        @if($customer->is_active==1)
                                            <span class="label label-success"><i class="fa fa-check-circle"></i> Active</span>
                                        @else
                                            <span class="label label-danger"><i class="fa fa-times-circle"></i> Not Active</span>
                                        @endif
                                    </h1>

                                    <p><span class="label label-info label-icon">National ID:</span> {{ $customer->national_id }}</p>
                                    <p><span class="label label-info label-icon">Eithar ID:</span> {{ $customer->eithar_id }}</p>

                                    <p>
                                        <span class="label label-info label-icon">Email:</span> {{ $customer->email }}
                                        @if($customer->email_verified==1)
                                            <span class="label label-success"><i class="fa fa-check-circle"></i> Verified</span>
                                        @else
                                            <span class="label label-danger"><i class="fa fa-times-circle"></i> Not Verified</span>
                                        @endif
                                    </p>
                                    <p>
                                        <span class="label label-info label-icon">{{ trans('admin.is_saudi_nationality') }}:</span>
                                        @if($customer->is_saudi_nationality==1)
                                            <span class="label label-success"><i class="fa fa-check-circle"></i> Yes</span>
                                        @else
                                            <span class="label label-danger"><i class="fa fa-times-circle"></i> No</span>
                                        @endif
                                    </p>

                                    <p>
                                        <span class="label label-info label-icon">Mobile:</span> {{ $customer->mobile_number }}
                                        @if($customer->mobile_verified==1)
                                            <span class="label label-success"><i class="fa fa-check-circle"></i> Verified</span>
                                        @else
                                            <span class="label label-danger"><i class="fa fa-times-circle"></i> Not Verified</span>
                                        @endif
                                    </p>

                                    <p>
                                        <a href="{{ \App\Helpers\Utilities::getFileUrl($customer->profile_picture_path) }}" data-lightbox="image-1" data-title="{{ $customer->full_name }}"><i class="fa fa-image"></i> Show Nationality ID</a>
                                    </p>
                                    @if($customer->position)
                                        <p>
                                            <a target="_blank" href="https://www.google.com/maps/place/{{ $customer->position }}:;"><i class="fa fa-map-marker"></i> Show On Google Map</a>
                                        </p>
                                    @endif
                                    <ul class="list-inline-item list-group-item-info">
                                        @if(count($customer->country))
                                            <li>
                                                <i class="fa fa-map-marker"></i>
                                                {{ $customer->country->country_name_eng }} -
                                                @if(count($customer->city)) {{ $customer->city->city_name_eng }} @endif
                                                - {{ $customer->address }}
                                            </li>
                                        @endif

                                        <li>
                                            @if($customer->gender===1)
                                                <i class="fa fa-male"></i> Male
                                            @else
                                                <i class="fa fa-female"></i> Female
                                            @endif
                                        </li>
                                        <li>
                                            <i class="fa fa-calendar"></i> Last Login: {{ $customer->last_login_date }}
                                        </li>
                                        <li>
                                            <i class="fa fa-calendar"></i>Birthdate: {{ $customer->birthdate }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_appointments">
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table id="data-table-customer-appointments" class="dataTable table table-bordered table-advance table-hover"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th>{{ trans('admin.id') }}</th>
                                    <th>{{ trans('admin.service_name') }}</th>
                                    <th>{{ trans('admin.price') }}</th>
                                    <th>{{ trans('admin.status') }}</th>
                                    <th>{{ trans('admin.submitted_at') }}</th>
                                    <th>{{ trans('admin.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--tab-pane-->
                @if(!empty($customer->notifications))
                    <div class="tab-pane" id="tab_notifications">
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table id="data-table-customer-notifications" class="dataTable table table-bordered table-advance table-hover"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th>{{ trans('admin.title') }}</th>
                                        <th>{{ trans('admin.notification_type') }}</th>
                                        <th>{{ trans('admin.description') }}</th>
                                        <th>{{ trans('admin.is_pushed') }}</th>
                                        <th>{{ trans('admin.is_emailed') }}</th>
                                        <th>{{ trans('admin.is_smsed') }}</th>
                                        <th>{{ trans('admin.send_at') }}</th>
                                        <th>{{ trans('admin.read_at') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>

@stop

@section('script')
    <script>
        var indexURL  = "{!! url()->route('get-customer-appointments-Datatable',[$customer->id])!!}";
        var indexNotificationsURL  = "{!! url()->route('get-customer-notifications-Datatable',[$customer->id])!!}";
        {{--var deleteURL = "{!! route('deleteServices') !!}";--}}
        var csrfToken = "{!! csrf_token() !!}";
    </script>
    <script src="{{ asset('public/js/custom/customerAppointmentsDataTable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/custom/customerNotificationsDataTable.js') }}" type="text/javascript"></script>
@stop