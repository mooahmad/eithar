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
  // Fixed navbar

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
    $(".navbar_menu").animate({
      right: 0 //Change
    }, 500);

  });

  // Overlay Click To  Hide Menu
  $(".navbar_overlay").click(function() {
    $(this).fadeOut("slow");
    $(".navbar_overlay").animate({
      left: -260 //Change
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
    rtl: true,
    infinite: true,
    autoplay: true,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
  });
  /**End Webiner Slider **/

  //End Header Slider

  /*End Home Page Script*/


  /**Start Provider Doctor **/
  // Toggle Class active
  $(".department_slider div[class*='col']").click(function() {
    $(".department_slider div").removeClass("active");
    $(this).children(".department_block").addClass("active");


  });

  $(" .department_block").click(function() {
    //  Hide All Content
    $(" .all_tabs > div").hide();

    //Show Dive With This Link
    $('.' + $(this).data('class')).fadeIn(1000);
  });

  $('.department_slider-js').slick({
    //  dots: true,
    rtl: true,
    infinite: false,
    speed: 300,
    slidesToShow: 10,
    slidesToScroll: 1,
    responsive: [{
        breakpoint: 1024,
        settings: {
          slidesToShow: 5,
          slidesToScroll: 1,
          infinite: true,
          //        dots: true
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 5,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1
        }
      }
      // You can unslick at a given breakpoint now by adding:
      // settings: "unslick"
      // instead of a settings object
    ]
  });
  /**End Provider Doctor **/



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



  /*****Start Preloder*****/
  //For Loading Function
  $(window).on('load', function() {
    $(".loading-bg").fadeOut(2000, function() {
      $("body").css('overflow', 'auto')
    });
  });
  /*****End Preloder*****/

});