$(document).ready(function () {
    $('#yes-is_general').on('change', function () {
        $('#services-row').hide();
        $('#service').removeAttr('required');
    });
    $('#no-is_general').on('click', function () {
        $('#services-row').show();
        $('#service').attr('required', 'required');
    });
});