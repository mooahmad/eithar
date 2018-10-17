var mainTableNotifications = null;

function datatableNotifications() {
    $('#data-table-customer-notifications').dataTable().fnDestroy();
    $.fn.dataTable.ext.errMode = 'throw';
    mainTableNotifications = $('#data-table-customer-notifications').DataTable({
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
            title: 'Customer Notifications Report',
            messageTop: 'Search result data',
            exportOptions: {
                columns: [0,1,2,3,5,6,7]
            },
            bom: true,
            charset: 'UTF-8'
        },
        ],
        processing: true,
        serverSide: true,
        ajax: {
            url: indexNotificationsURL
        },
        columns: [
            {data: 'title'},
            {data: 'notification_type'},
            {data: 'description'},
            {data: 'is_pushed'},
            {data: 'is_emailed'},
            {data: 'is_smsed'},
            {data: 'send_at'},
            {data: 'read_at'},
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
    datatableNotifications();
});
