var mainTable = null;

function datatable() {
    $('#data-table-medical-reports').dataTable().fnDestroy();
    $.fn.dataTable.ext.errMode = 'throw';
    mainTable = $('#data-table-medical-reports').DataTable({
        "bfilter": false,
        "dom": 'B f l t p r i',
        "paging": true,
        "searching": true,
        "ordering": true,
        select: false,
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
                        deleteMedicalReportsRecords(ids)
                    });
                    $('#staticDeleteModal').modal();
                }
            }
        ],
        processing: true,
        serverSide: true,
        ajax: {
            url: medicalReportsDataTableURL
        },
        columns: [
            {data: 'id', name: 'medical_reports.id'},
            {
                data: 'is_general',
                name: 'medical_reports.is_general',
                render: function (data, type, full, meta) {
                    return (data === 0)? 'no' : 'yes';
                }
            },
            {
                data: 'service_id',
                name: 'medical_reports.service_id',
                render: function (data, type, full, meta) {
                    return (data === 0)? 'yes' : 'no';
                }
            },
            {
                data: 'customer_can_view',
                name: 'medical_reports.customer_can_view',
                render: function (data, type, full, meta) {
                    return (data === 0)? 'no' : 'yes';
                }
            },
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

function deleteMedicalReportsRecords(ids) {
    $.ajax({
        url: deletemedicalReportsURL,
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
