$(document).ready(function () {
    getProviderList($(".doctorsSubCategory").data('id'));
    $(".doctorsSubCategory").click(function() {
        getProviderList($(this).data('id'));
    });

    function getProviderList(subcategory_id){
        $.ajax({
            url: url,
            type: "post",
            data:{subcategory_id:subcategory_id,_token:_token},
            success: function (data) {
                if (data.result){
                    //append html to dev and active it
                    $('#DoctorsList').empty();
                    $('#DoctorsList').html(data.list);
                }
            },
            error: function (data) {
                console.log('something went wrong.');
            }
        });
    }

});