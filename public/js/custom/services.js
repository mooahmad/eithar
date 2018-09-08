$(document).ready(function () {
    $('#parent_cat').on('change', function () {
        $.ajax({
            url: baseUrl + '/Administrator/getservicestypes/' + $(this).find('option:selected').val(),
            type: "GET",
            success: function (res) {
            $('#type').find('option').remove().end();
            $.each(res, function (key, value) {
                $('#type').append('<option value="'+key+'">'+value+'</option>');
            })
            },
            error: function () {

            }
        });
    }).change();
});