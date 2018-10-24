$(document).ready(function () {
    $('#pushNotificationsTypes').on('change', function () {
        $.ajax({
            url: baseUrl + '/Administrator/getPushType/' + $(this).find('option:selected').val(),
            type: "GET",
            success: function (res) {
                $('#pushTypeTitleAR').val(res.title_ar);
                $('#pushTypeTitleEN').val(res.title_en);
                $('#desc_ar').val(res.desc_ar);
                $('#desc_en').val(res.desc_en);
                if(res.type === 3 || res.type === 4 )
                    $('.hint').show();
                else
                    $('.hint').hide();
            },
            error: function () {

            }
        });
    }).change();

});