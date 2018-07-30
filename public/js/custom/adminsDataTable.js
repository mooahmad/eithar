function datatable() {
    $('#data-table-admins').dataTable().fnDestroy();
    $.fn.dataTable.ext.errMode = 'throw';
    $('#data-table-admins').DataTable({
        "bfilter": false,
        "dom": 'B f l t p r i',
        "paging": true,
        "searching": true,
        "ordering": true,
        "columnDefs": [
            {className: "text-center", "targets": "_all"}
        ],
        buttons: [{
            extend: 'csvHtml5',
            title: 'Customers report',
            messageTop: 'Search result data',
            exportOptions: {
                columns: [0, 1, 2, 3, 4]
            },
            bom: true,
            charset: 'UTF-8'
        },
            {
                extend: 'pdfHtml5',
                title: 'Customers report',
                messageTop: 'Search result data',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                },
                bom: true,
                charset: 'UTF-8'
            }],
        processing: true,
        serverSide: true,
        ajax: {
            url: adminsDataTableURL
        },
        columns: [
            {data: 'id', name: 'users.id'},
            {
                data: 'full_name', name: 'users.name', "render": function (data, type, full, meta) {
                    return data;
                }
            },
            {data: 'mobile_number', name: 'users.mobile_number'},
            {data: 'email', name: 'users.email'},
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

        }
    });

}

$(document).ready(function () {
    datatable();
});
