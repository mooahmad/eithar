$(document).ready(function () {
    getGlobalServicesList($(".doctorsSubCategory").data('id'));
    $(".doctorsSubCategory").click(function() {
        getGlobalServicesList($(this).data('id'));
    });

    function getGlobalServicesList(subcategory_id){
        $.ajax({
            url: url,
            type: "post",
            data:{subcategory_id:subcategory_id,_token:_token},
            success: function (data) {
                if (data.result){
                    //append html to dev and active it
                    $('#OneTimeVisitServices').empty();
                    $('#OneTimeVisitServices').html(data.one_time_visit_list);
                    $('#PackageServices').empty();
                    $('#PackageServices').html(data.package_list);
                    $(".list_doctor").show();
                }
            },
            error: function (data) {
                console.log('something went wrong.');
            }
        });
    }

});