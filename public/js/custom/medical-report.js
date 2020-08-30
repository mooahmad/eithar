$(document).ready(function () {
    $('#yes-is_general').on('change', function () {
        $('#services-row').hide();
        $('#service').removeAttr('required');
    });
    $('#no-is_general').on('click', function () {
        $('#services-row').show();
        $('#service').attr('required', 'required');
    });
    $('#yes-is_lap').on('change', function () {
        $('#services-input').hide();
        $('#service').removeAttr('required');
    });
    $('#no-is_lap').on('click', function () {
        $('#services-input').show();
        $('#service').attr('required', 'required');
    });
});