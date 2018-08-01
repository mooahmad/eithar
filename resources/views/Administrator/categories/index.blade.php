@extends(ADL.'.master')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="btn-group">
                        <a href="{{ url(AD.'/admins/create') }}" class="btn sbold green"> Add New <i
                                    class="fa fa-plus"></i></a>
                    </div>
                    <div id="dataTable-buttons" class="tools">

                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table id="data-table-categories" class="dataTable table table-bordered table-hover"
                               width="100%">
                            <thead>
                            <tr>
                                <th>{{ __('admin.id') }}</th>
                                <th>{{ __('admin.name_en') }}</th>
                                <th>{{ __('admin.name_ar') }}</th>
                                <th>{{ __('admin.actions') }}</th>
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
    // declaring used variables
    <script>
        var categoriesDataTableURL = "{!! route('getCategoriesDatatable') !!}";
        var deleteCategoriesURL    = "{!! route('deleteCategories') !!}";
        var csrfToken          = "{!! csrf_token() !!}";
    </script>
    <script src="{{ asset('public/js/custom/categoriesDataTable.js') }}" type="text/javascript"></script>
@stop