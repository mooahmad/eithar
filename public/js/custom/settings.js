$(document).ready(function () {
    $('#pushNotificationsTypes').on('change', function () {
        $.ajax({
            url: baseUrl + '/Administrator/getPushType/' + $(this).find('option:selected').val(),
            type: "GET",
            success: function (res) {
                $('#pushTypeTitleAR').val(res.title_ar);
                $('#pushTypeTitleEN').val(res.title_en);
                $('#desc_ar').val(res.title_ar);
                $('#desc_en').val(res.title_en);
            },
            error: function () {

            }
        });
    }).change();

});