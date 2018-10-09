$(document).ready(function () {
    $('#yes-is_general').on('change', function () {
        $('#services-row').hide();
        $('#service').removeAttr('required');
    });
    $('#no-is_general').on('click', function () {
        $('#services-row').show();
        $('#service').attr('required', 'required');
    });
    unAvailablePages = JSON.parse(unAvailablePages);
    $.each(unAvailablePages, function (index, item) {
        $('#page option[value="' + item + '"]').prop('disabled', true);
    });
    $('#page').on('change', function () {
        $.ajax({
            url: baseUrl + '/Administrator/services/' + serviceId + '/medical_reports/' + $(this).find('option:selected').val(),
            type: "GET",
            success: function (res) {
                $('#order').find('option').remove().end();
                var ordersCount = res.ordersCount;
                var unAvailableOrders = res.unAvailableOrders;
                $.each(ordersCount, function (index, item) {
                    var elOption = '<option value="' + item + '">' + item + '</option>';
                    if(parseInt(item) === parseInt(medicalReportCurrentOrder))
                        elOption = '<option value="' + item + '" selected>' + item + '</option>';
                    $.each(unAvailableOrders, function (oIndex, oItem) {
                        if (item === oItem && parseInt(item) !== parseInt(medicalReportCurrentOrder))
                            elOption = '<option value="' + item + '" disabled="disabled">' + item + '</option>';
                    });
                    $('#order').append(elOption);
                });
            },
            error: function () {

            }
        });
    }).change();
});