@extends(ADL.'.master')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="btn-group">
                        <a href="{{ url()->route('add_family_members') }}" class="btn sbold green"> Add New <i
                                    class="fa fa-plus"></i></a>
                    </div>
                    <div id="dataTable-buttons" class="tools">

                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table id="data-table-family-members" class="dataTable table table-bordered table-hover"
                               width="100%">
                            <thead>
                                <tr>
                                    <th>{{ trans('admin.id') }}</th>
                                    <th>{{ trans('admin.customers') }}</th>
                                    <th>{{ trans('admin.full_name') }}</th>
                                    <th>{{ trans('admin.relation_type') }}</th>
                                    <th>{{ trans('admin.mobile') }}</th>
                                    <th>{{ trans('admin.national_id') }}</th>
                                    <th>{{ trans('admin.image') }}</th>
                                    <th>{{ trans('admin.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    @include('Administrator.widgets.deleteModal', ['message' => 'are you sure you want to delete?'])
@stop

@section('script')
    <script>
        var familyMembersDataTableURL = "{!! route('get-family-members-Datatable') !!}";
        var deleteFamilyMembersURL    = "{!! route('deleteFamilyMembers') !!}";
        var csrfToken          = "{!! csrf_token() !!}";
    </script>
    <script src="{{ asset('public/js/custom/familyMembersDataTable.js') }}" type="text/javascript"></script>
@stop