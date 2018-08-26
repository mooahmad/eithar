$(document).ready(function () {
    unAvailablePages = JSON.parse(unAvailablePages);
    $.each(unAvailablePages, function (index, item) {
        $('#page option[value="' + item + '"]').prop('disabled', true);
    });
    $('#page').on('change', function () {
        $.ajax({
            url: baseUrl + '/Administrator/services/' + serviceId + '/questionnaire/' + $(this).find('option:selected').val(),
            type: "GET",
            success: function (res) {
                $('#order').find('option').remove().end();
                var ordersCount = res.ordersCount;
                var unAvailableOrders = res.unAvailableOrders;
                $.each(ordersCount, function (index, item) {
                    var elOption = '<option value="' + item + '">' + item + '</option>';
                    if(parseInt(item) === parseInt(questionnaireCurrentOrder))
                        elOption = '<option value="' + item + '" selected>' + item + '</option>';
                    $.each(unAvailableOrders, function (oIndex, oItem) {
                        if (item === oItem && parseInt(item) !== parseInt(questionnaireCurrentOrder))
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