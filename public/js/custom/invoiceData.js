

$(document).ready(function () {
    // $('#data-table-meetings thead th').each( function () {
    //     var title = $(this).text();
    //     $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    // } );
    datatable();

    $('#from_date').on('change', function () {
        var from = $('#from_date').val();

        if (from != '') {
            $('#data-table-invoices').dataTable().fnDestroy();
            var to = $('#to_date').val();
            var bill = $('#bill').val();
            var pay = $('#pay').val();
            datatable(from, to, bill, pay);
        }
        else {
            alert('Select Both filter option');
        }
    });
    $('#to_date').on('change', function () {
        var to = $('#to_date').val();
        if (to != '') {
            $('#data-table-invoices').dataTable().fnDestroy();
            var from = $('#from_date').val();
            var bill = $('#bill').val();
            var pay = $('#pay').val();
            datatable(from, to, bill, pay);
        }
        else {
            alert('Select Both filter option');
        }
    });

    $('#bill').on('change', function () {
        var bill = $('#bill').val();
        if (bill != '') {
            $('#data-table-invoices').dataTable().fnDestroy();
            var from = $('#from_date').val();
            var to = $('#to_date').val();
            var pay = $('#pay').val();
            datatable(from, to, bill, pay);
        } else {
            alert('Select Both filter option');
        }
    });

    $('#pay').on('change', function () {
        var pay = $('#pay').val();
        if (pay != '') {
            $('#data-table-invoices').dataTable().fnDestroy();
            var from = $('#from_date').val();
            var to = $('#to_date').val();
            var bill = $('#bill').val();
            datatable(from, to, bill, pay);
        } else {
            alert('Select Both filter option');
        }
    });
    var mainTable = null;

    function datatable(from_date, to_date, bill, pay) {
        $('#data-table-invoices').dataTable().fnDestroy();
        $.fn.dataTable.ext.errMode = 'throw';
        mainTable = $('#data-table-invoices').DataTable({
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
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                },
                bom: true,
                charset: 'UTF-8'
            }],
            processing: true,
            serverSide: true,
            ajax: {
                url: indexURL,
                data: function (d) {
                    d.from_date = from_date;
                    d.to_date = to_date;
                    d.bill = bill;
                    d.pay = pay;
                }
            },
            columns: [
                {data: 'id', name: 'invoices.id'},
                {data: 'full_name', name: 'customers.first_name'},
                {data: 'national_id', name: 'customers.national_id'},
                {data: 'eithar_id', name: 'customers.eithar_id'},
                {data: 'invoice_code', name: 'invoices.invoice_code'},
                {data: 'mobile_number', name: 'customers.mobile_number'},
                {data: 'amount_original', name: 'invoices.amount_original'},
                {data: 'amount_after_discount', name: 'invoices.amount_after_discount'},
                {data: 'amount_after_vat', name: 'invoices.amount_after_vat'},
                {data: 'amount_final', name: 'invoices.amount_final'},
                {data: 'is_paid', name: 'invoices.is_paid'},
                {data: 'invoice_date', name: 'invoices.invoice_date'},
                {
                    searchable: true,
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

                this.api().columns([10]).every(function () {
                    var invoice_pay = new Array();
                    invoice_pay[0] = ["Pending"];
                    invoice_pay[1] = ["Paid"];
                    var column = this;
                    var select = $('<select class="btn btn-outline btn-circle btn-large blue-ebonyclay"><option value="">Advanced Filter</option></select>')
                        .appendTo($(column.footer()).empty())
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column.search(this.value).draw();
                        });
                    invoice_pay.forEach(function (value, key) {
                        select.append('<option value="' + key + '">' + value + '</option>')
                    });
                });
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

    $('#search-form').on('submit', function (e) {
        mainTable.draw();
        e.preventDefault();
    });

});

