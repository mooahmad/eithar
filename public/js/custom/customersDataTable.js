var mainTable = null;

function datatable() {
    $('#data-table-customers').dataTable().fnDestroy();
    $.fn.dataTable.ext.errMode = 'throw';
    mainTable = $('#data-table-customers').DataTable({
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
            // {
            //     className: 'deleteSelected',
            //     text: 'Delete selected',
            //     action: function () {
            //         var ids = [];
            //         var data = mainTable.rows('.selected').data();
            //         $(data).each(function () {
            //             var row = this;
            //             ids.push(row.id);
            //         });
            //         $('#btn-modal-delete').unbind('click');
            //         $('#btn-modal-delete').on('click', function () {
            //             deleteServicesRecords(ids)
            //         });
            //         $('#staticDeleteModal').modal();
            //     }
            // }
        ],
        processing: true,
        serverSide: true,
        ajax: {
            url: indexURL
        },
        columns: [
            {data: 'id', name: 'customers.id'},
            {data: 'eithar_id', name: 'customers.eithar_id'},
            {data: 'full_name', name: 'customers.first_name'},
            {data: 'national_id', name: 'customers.national_id'},
            {
                data: 'is_saudi_nationality', name: 'customers.is_saudi_nationality',
                // "render": function (data, type, full, meta) {
                //     return (data == 1) ? "Saudi" : "Not Saudi";
                // }
            },
            {data: 'mobile_number', name: 'customers.mobile_number'},
            {data: 'country', name: 'customers.email'},
            {
                searchable: false,
                orderable: false,
                data: 'image',
                name: 'image',
                "render": function (data, type, full, meta) {
                    return data;
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
            // $('.deleteSelected').addClass('hidden');
            $(".dt-buttons").appendTo("#dataTable-buttons");
            $(".dt-buttons").show();
        }
    });

    // mainTable.on('select', function (e, dt, type, indexes) {
    //     var count = mainTable.rows('.selected').count();
    //     if (count > 0)
    //         $('.deleteSelected').removeClass('hidden');
    //
    // })
    //     .on('deselect', function (e, dt, type, indexes) {
    //         var count = mainTable.rows('.selected').count();
    //         if (count === 0)
    //             $('.deleteSelected').addClass('hidden');
    //     });
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
