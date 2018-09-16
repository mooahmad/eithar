$(document).ready(function () {

    var last_valid_selection = null;

    $('#week_days').change(function (event) {

        if ($(this).val().length >= maxSelect) {
            $(this).val(last_valid_selection);
        } else {
            last_valid_selection = $(this).val();
        }
    });
});