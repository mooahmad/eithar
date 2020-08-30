$(document).ready(function () {
    $('#datetimepicker1').datetimepicker({
        format: 'YYYY MM DD'
    });

    var owl = $('.owl-carousel');
    owl.owlCarousel({
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            500: {
                items: 2,
                nav: false
            },
            1000: {
                items: 3,
                nav: true,
            },
            1200: {
                items: 4,
                nav: true,
            }
        },
        loop: true,
        rtl: true,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
    });
});;
