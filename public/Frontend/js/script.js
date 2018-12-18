$(function() {

  'use strict';

  // Start Navbar Menu

  //Togell Active Class in Menu
  $(".navbar_menu li:first-child").addClass("active");

  $(".navbar_menu li").click(function() {
    $(this).addClass("active").siblings().removeClass("active");
  });
  // Fixed navbar
  $(window).scroll(function() {
    if ($(window).scrollTop() >= 80) {
      $(".navbar").addClass("fixed");

    } else {
      $(".navbar").removeClass("fixed");

    }
  });
  // Menu Fore Desck Top
  if ($(window).width() >= 992) {


    $(".dropdown_link ,.dropdown_link-inside ").mouseenter(function() {
      $(this).children(".navbar_dropdown-menu").slideDown(800);
    });

    $(".dropdown_link ,.dropdown_link-inside ").mouseleave(function() {
      $(this).children(".navbar_dropdown-menu").slideUp("fast");
    });

    $(".dropdown_link-inside").click(function() {
      $(this).children(".navbar_dropdown-menu").slideToggle();

    });
  }


  // Menu Fore Mobile
  if ($(window).width() <= 992) {
    $(".dropdown_link ,.dropdown_link-inside ").click(function() {
      $(this).children(".navbar_dropdown-menu").slideToggle();
    });


  }

  // Button Togell To Show and Hide Menu
  $(".navbar_button").click(function() {
    $(".navbar_overlay").fadeIn();
    $(".menu_content").animate({
      left: 0 //Change
    }, 500);

  });

  // Overlay Click To  Hide Menu
  $(".navbar_overlay").click(function() {
    $(this).fadeOut("slow");
    $(".navbar_overlay").animate({
      right: 260 //Change
    }, 500);

  });
  $(" .navbar_overlay").children().click(function(e) {
    e.stopPropagation();
  });


  // Hiden Menu in Mobile By Using Esc Button
  $(document).keydown(function(e) {
    if (e.keyCode == 27)
      $(".navbar_overlay").fadeOut("slow");
  });

  // =03= Start Search Subheader
  $(".department_button").click(function() {
    $(this).addClass("active").siblings().removeClass("active");
  });
  // =03= End Search Subheader

  /*======= Backgrounds ======*/
  $("[data-src]").each(function() {
    var backgroundImage = $(this).attr("data-src");
    $(this).css("background-image", "url(" + backgroundImage + ")");
  });


  /*Start Home Page Script*/

  //Start Header Slider
  /**Start Webiner Slider **/
  $('.header_slider-js').slick({
    arrows: false,
    dots: true,
    //        rtl: true,
    infinite: true,
    autoplay: true,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
  });
  /**End Webiner Slider **/

  //End Header Slider

  /*End Home Page Script*/


  /**Start Webiner Slider **/
  $('.department_slider-js').slick({
    //  dots: true,
    rtl: true,
    infinite: false,
    speed: 300,
    slidesToShow: 14,
    slidesToScroll: 1,
    responsive: [{
        breakpoint: 1024,
        settings: {
          slidesToShow: 14,
          slidesToScroll: 1,
          infinite: true,
          //        dots: true
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
      // You can unslick at a given breakpoint now by adding:
      // settings: "unslick"
      // instead of a settings object
    ]
  });
  /**End Webiner Slider **/



  //Button Go to Top Hidden and Show
  $(window).scroll(function() {


    var buttonUp = $(".go_up-js");

    if ($(window).scrollTop() >= 400) {
      buttonUp.fadeIn(1000);
    } else {
      buttonUp.fadeOut(1000);

    }


  });

  //Button Click To Scroll to top
  $(".go_up-js").on('click', function() {
    $('html,body').animate({
      scrollTop: 0
    }, 1000)
  });

  /*Start Profile Doctor */
  // $(".rate_content .fa-heart,.rate_content .fa-star").click(function() {
  //   $(this).toggleClass("active");
  // });
  $(".rate_content .fa-share-square").click(function() {
    $(".social_media-content").slideToggle();
  });
  /*End Profile Doctor */

  /*****Start Preloder*****/
  //For Loading Function
  $(window).on('load', function() {
    $(".loading-bg").fadeOut(2000, function() {
      $("body").css('overflow', 'auto')
    });
  });
  /*****End Preloder*****/
      // Start Notificaion 
      $(".notification_button").on('click', function () {
        $(".notification_area-list").slideToggle();
      });


});