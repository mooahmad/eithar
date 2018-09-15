$(document).ready(function () {
    $('#parent_cat').on('change', function () {
        $.ajax({
            url: baseUrl + '/Administrator/getservicestypes/' + $(this).find('option:selected').val() + '/' + serviceId,
            type: "GET",
            success: function (res) {
                $('#type').find('option').remove().end();
                $.each(res.allTypes, function (key, value) {
                    if (res.selectedType !== "")
                        $('#type').append('<option value="' + key + '" selected>' + value + '</option>');
                    else
                        $('#type').append('<option value="' + key + '">' + value + '</option>');
                });
                $('#type').change();
            },
            error: function () {

            }
        });
    }).change();

    $('#type').on('change', function () {
        if ($('#type').find('option:selected').val() == 2) {
            $('#no-of-visits').show();
            $('#no-of-visits-per-week').show();
        }else{
            $('#no-of-visits').hide();
            $('#no-of-visits-per-week').hide();
        }
    });
});