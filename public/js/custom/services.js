$(document).ready(function () {
    $('#parent_cat').on('change', function () {
        $.ajax({
            url: baseUrl + '/Administrator/getservicestypes/' + $(this).find('option:selected').val() + '/' + serviceId,
            type: "GET",
            success: function (res) {
            $('#type').find('option').remove().end();
            $.each(res.allTypes, function (key, value) {
                if(res.selectedType !== "")
                    $('#type').append('<option value="'+key+'" selected>'+value+'</option>');
                else
                $('#type').append('<option value="'+key+'">'+value+'</option>');
            })
            },
            error: function () {

            }
        });
    }).change();
});