
$(document).ready(function () {
    // $('#data-table-meetings thead th').each( function () {
    //     var title = $(this).text();
    //     $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    // } );
    datatable();

    var mainTable = null;

    $('#filter').on('change',function(){
        var filter = $('#filter').val();
        if(filter != '')
        {
            $('#data-table-meetings').dataTable().fnDestroy();
            datatable(filter);
        }
        else
        {
            alert('Select Both filter option');
        }
    });


    function datatable(filter) {
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
                    columns: [0,1,2,3,4,5,6,7,8,9,10,11,12]
                },
                bom: true,
                charset: 'UTF-8'
            }],
            processing: true,
            serverSide: true,
            ajax: {
                url: indexURL,
                data:function (d) {
                    d.from_date = $('#from_date').val();
                    d.to_date = $('#to_date').val();
                    d.filter = filter
                    d.providerId = providerId}

            },
            columns: [
                {data: 'id', name: 'service_bookings.id'},
                {data: 'name_en', name: 'services.name_en'},
                {data: 'first_name', name: 'customers.first_name'},
                {data: 'middle_name', name: 'customers.middle_name'},
                {data: 'last_name', name: 'customers.last_name'},
                {data: 'national_id', name: 'customers.national_id'},
                {data: 'eithar_id', name: 'customers.eithar_id'},
                {data: 'mobile_number', name: 'customers.mobile_number'},
                {data: 'price', name: 'service_bookings.price'},
                {data: 'status', name: 'service_bookings.status'},
                {data: 'unlock_request', name: 'service_bookings.unlock_request',
                    "render": function (data, type, full, meta) {
                        return (data == 1)? "yes" : "no";
                    }},
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

                // this.api().columns([1,5,6]).every( function () {
                //     var column = this;
                //         var select = $('<select class="btn btn-outline btn-circle btn-large blue-ebonyclay"><option value="">Advanced Filter</option></select>')
                //         .appendTo( $(column.footer()).empty() )
                //         .on( 'change', function () {
                //             var val = $.fn.dataTable.util.escapeRegex(
                //                 $(this).val()
                //             );
                //             column
                //                 .search( val ? '^'+val+'$' : '', true, false )
                //                 .draw();
                //         } );
                //
                //     column.data().unique().sort().each( function ( d, j ) {
                //         select.append( '<option value="'+d+'">'+d+'</option>' )
                //     } );
                // } );

                this.api().columns([9]).every( function () {
                    var meeting_status = new Array();
                    meeting_status[1] = ["In Progress"];
                    meeting_status[2] = ["Confirmed"];
                    meeting_status[3] = ["Canceled"];
                    var column = this;
                    var select = $('<select class="btn btn-outline btn-circle btn-large blue-ebonyclay"><option value="">Advanced Filter</option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column.search( this.value ).draw();
                        });
                    meeting_status.forEach( function ( value,key ) {
                        select.append( '<option value="'+key+'">'+value+'</option>' )
                    } );
                } );
                this.api().columns([10]).every( function () {
                    var column = this;
                    var select = $('<select id ="unlock-request" class="btn btn-outline btn-circle btn-large blue-ebonyclay"><option value="">Advanced Filter</option></select>')
                        .appendTo( $(column.footer()).empty() );
                    $('#unlock-request').on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column.search( val ).draw();
                    });
                    select.append( '<option value="1">yes</option>' );
                    select.append( '<option value="0">no</option>' );
                } );
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

        // Apply the search
        // mainTable.columns([0,1,2,3,4,5,6,7,8]).every( function () {
        //     var that = this;
        //
        //     $( 'input', this.header() ).on( 'keyup change', function () {
        //         if ( that.search() !== this.value ) {
        //             that
        //                 .search( this.value )
        //                 .draw();
        //         }
        //     } );
        // } );
    }

    $('#search-form').on('submit', function(e) {
        mainTable.draw();
        e.preventDefault();
    });


});
