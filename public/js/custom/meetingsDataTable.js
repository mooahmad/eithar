var mainTable = null;

function datatable() {
    $('#data-table-meetings').dataTable().fnDestroy();
    $.fn.dataTable.ext.errMode = 'throw';
    mainTable = $('#data-table-meetings').DataTable({
        "bfilter": true,
        "dom": 'B f l t p r i',
        "paging": true,
        "searching": true,
        "ordering": true,
        select: {
            style: 'multi'
        },
        order: [[0, 'asc']],
        buttons: [{
            extend: 'csvHtml5',
            title: 'Meetings Report',
            messageTop: 'Search result data',
            exportOptions: {
                columns: [0, 2, 3]
            },
            bom: true,
            charset: 'UTF-8'
        },
            {
                className: 'deleteSelected',
                text: 'Delete selected',
                action: function () {
                    var ids = [];
                    var data = mainTable.rows('.selected').data();
                    $(data).each(function () {
                        var row = this;
                        ids.push(row.id);
                    });
                    $('#btn-modal-delete').unbind('click');
                    $('#btn-modal-delete').on('click', function () {
                        // deleteServicesRecords(ids)
                    });
                    $('#staticDeleteModal').modal();
                }
            }
        ],
        processing: true,
        serverSide: true,
        ajax: {
            url: indexURL,
            data: {'meeting_type':meeting_type}
        },
        columns: [
            {data: 'id', name: 'service_bookings.id'},
            {data: 'name_en', name: 'services.name_en'},
            {data: 'first_name', name: 'customers.first_name'},
            {data: 'middle_name', name: 'customers.middle_name'},
            {data: 'last_name', name: 'customers.last_name'},
            {data: 'national_id', name: 'customers.national_id'},
            {data: 'price', name: 'service_bookings.price'},
            {data: 'status', name: 'service_bookings.status'},
            {
                searchable: false,
                orderable: false,
                data: 'actions',
                name: 'actions',
                "render": function (data, type, full, meta) {
                    return data;
                }
            }
        ],
        columnDefs: [
            {
                "render": function ( data, type, row ) {
                    return data + '-' +row['middle_name']+ '-' +row['last_name'];
                },
                "targets": 2
            },
            { "visible": false,  "targets": [ 3,4 ] }
        ],
        "fnDrawCallback": function () {
            // fires after each search

        }
        ,
        initComplete: function () {
            // fires after tables initiated
            $('.deleteSelected').addClass('hidden');
            $(".dt-buttons").appendTo("#dataTable-buttons");
            $(".dt-buttons").show();
        }
    });

    mainTable.on('select', function (e, dt, type, indexes) {
        var count = mainTable.rows('.selected').count();
        if (count > 0)
            $('.deleteSelected').removeClass('hidden');

    })
        .on('deselect', function (e, dt, type, indexes) {
            var count = mainTable.rows('.selected').count();
            if (count === 0)
                $('.deleteSelected').addClass('hidden');
        });
}

function deleteServicesRecords(ids) {
    $.ajax({
        url: deleteURL,
        type: "Post",
        data: {
            "_token": csrfToken,
            ids: ids
        },
        success: function (response, status, xhr) {
            mainTable
                .order( [[ 0, 'asc' ]] )
                .draw( false );
            $('#staticDeleteModal').modal('hide');
            $('.deleteSelected').addClass('hidden');
        },
        error: function (response, status, xhr) {

        }
    });
}

$(document).ready(function () {
    datatable();
});
