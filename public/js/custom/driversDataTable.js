var mainTable = null;

function datatable() {
    $('#data-table-drivers').dataTable().fnDestroy();
    $.fn.dataTable.ext.errMode = 'throw';
    mainTable = $('#data-table-drivers').DataTable({
        "bfilter": false,
        "dom": 'B f l t p r i',
        "paging": true,
        "searching": true,
        "ordering": true,
        select: {
            style: 'multi'
        },
        "columnDefs": [
            {className: "text-center", "targets": "_all"}
        ],
        order: [[0, 'asc']],
        buttons: [{
            extend: 'csvHtml5',
            title: 'Customers report',
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
                        deleteDriversRecords(ids)
                    });
                    $('#staticDeleteModal').modal();
                }
            }
        ],
        processing: true,
        serverSide: true,
        ajax: {
            url: driversDataTableURL
        },
        columns: [
            {data: 'id', name: 'drivers.id'},
            {data: 'name', name: 'drivers.name'},
            {data: 'car_type', name: 'drivers.car_type'},
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

function deleteDriversRecords(ids) {
    $.ajax({
        url: deleteDriversURL,
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
