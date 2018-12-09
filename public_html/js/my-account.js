$(function () {
    'use strict';

    // Start Profile List
    $(".profile_menu-list ul li:first-child").addClass("active");
    $(".profile_menu-list ul li").on('click', function () {
        $(".profile_menu").toggleClass("switch");
        $(".show_menu").toggleClass("switch");
        $(this).addClass("active").siblings().removeClass("active");
        $('html,body').animate({
            scrollTop: 0
        }, 1000);

        //Hide All Content
        $(".all_tabs > div").hide();

        //Show Dive With This Link
        $($(this).data('id')).fadeIn();

    });

    if ($(window).width() <= 992) {

        // Button Toggle Icon
        $(".show_menu").on('click', function () {
            $(this).toggleClass("switch");
            $(this).parent(".profile_menu").toggleClass("switch");

        });

    }

    $(".add_question-button").on('click', function () {
        $(".add_question-section").slideToggle();
        $(this).hide(1000);
    });
    // Start Tabs 
    // End Profile List


    /* Start Wallt PAges */
    // Open Next PAge 
    $(".next-js").on('click',function(){
        $(this).parents("section").fadeOut("1000");
        $(this).parents("section").next("section").fadeIn();
    });

    // Open Prev PAge 
    $(".prev-js").on('click', function(){
        $(this).parents("section").fadeOut("1000");
        $(this).parents("section").prev("section").fadeIn();
    });
    /* End Wallt PAges */


});
