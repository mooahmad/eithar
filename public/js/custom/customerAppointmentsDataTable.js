var mainTable = null;

function datatable() {
    $('#data-table-customer-appointments').dataTable().fnDestroy();
    $.fn.dataTable.ext.errMode = 'throw';
    mainTable = $('#data-table-customer-appointments').DataTable({
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
            title: 'Customer report',
            messageTop: 'Search result data',
            exportOptions: {
                columns: [0, 2, 3]
            },
            bom: true,
            charset: 'UTF-8'
        },
        ],
        processing: true,
        serverSide: true,
        ajax: {
            url: indexURL
        },
        columns: [
            {data: 'id', name: 'service_bookings.id'},
            {data: 'service_name', name: 'service_bookings.service_id'},
            {data: 'price', name: 'service_bookings.price'},
            {data: 'status', name: 'service_bookings.status'},
            {data: 'created_at', name: 'service_bookings.created_at'},
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
}

$(document).ready(function () {
    datatable();
});
