$(document).ready(function () {
    $(".LikeAction").click(function() {
        likeProvider();
    });

    function likeProvider(){
        $(".LikeAction").removeClass('active');
        // alert($('.LikeAction').data('action'));
        $.ajax({
            url: url,
            type: "post",
            data:{provider_id:provider_id,_token:_token},
            success: function (data) {
                if (data.result){
                    if (data.action == 'like'){
                        $(".LikeAction").addClass('active');
                    }
                }
            },
            error: function (data) {
                console.log('something went wrong.');
            }
        });
    }

});