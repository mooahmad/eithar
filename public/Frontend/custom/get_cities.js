function changeCountry(event) {
    var country_id = $(event).val();
    $.ajax({
        url: url,
        type: "post",
        data:{country_id:country_id,_token:_token},
        success: function (data) {
            if (data.result){
                $('#city_id').empty();
                $('#city_id').html(data.list);
            }
        },
        error: function (data) {
            alert('something went wrong.');
        }
    });
}

$(function() {
    changeCountry($("#country_id"));
});
