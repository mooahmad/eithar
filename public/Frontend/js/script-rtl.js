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

  //Button Click To Scroll to Down
  $(".down_icon").on('click', function() {
    $('html,body').animate({
      scrollTop: 600
    }, 1000)
  });

  /*Start Profile Doctor */
  $(".rate_content .fa-heart,.rate_content .fa-star").click(function() {
    $(this).toggleClass("active");
  });
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
  /**End Preloder*****/

  /**Start Custum Calender**/
  // Start My Code//
  //End Code//
  var currentMonth = new Date().getMonth();
  var currentYear = new Date().getFullYear();
  var clickedDays = 0;
  var bookingSteps = 0;
  var lastClickedDay;
  var startDate = "";
  var endDate = "";
  var monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
  ];
  var monthShortNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  var dayNames = ["Sun", "Mon", "Tue", "Wed", "Thur", "Fri", "Sat"];
  var bookedDates = [];
  var selectedDates = [];

  Date.prototype.addDays = function(days) {
    var dat = new Date(this.valueOf())
    dat.setDate(dat.getDate() + days);
    return dat;
  }

  function clearCalender() {
    clickedDays = 0;
    $(".month div").removeClass("clicked");
    $("#startdate").html("");
    $("#enddate").html("");

    startDate = "";
    endDate = "";
    selectedDates = [];
    bookingSteps = 0;
  }

  function clearBooking() {
    $("#booking-form input").val("");
    $("#booking-form textarea").val("");

    $("#booking-wrapper").removeClass("opened");


  }

  function daysInMonth(month) {
    return new Date(currentYear, month, 0).getDate();
  }

  function displayCalender() {
    var days = daysInMonth(currentMonth + 1);

    $("#calender-title p").html(monthNames[currentMonth].toUpperCase());
    $("#calender-content").html("");

    for (var i = 1; i < firstDayOffset(new Date()); i++) {
      $("#calender-content").append("<div class='month flex center-vh'></div>");
    }
    for (var i = 1; i <= days; i++) {
      var day = new Date(currentYear, currentMonth, i).getDay();
      var string = "<div class='month'><div id='" + dayNames[day] + "-" + i + "-" + monthNames[currentMonth] + "-" + currentYear + "'class='month-selector flex center-vh clickable' onclick='monthClick(this)'><p>" + i + "</p><span class='day_avilable '>5</span></div></div>";
      $("#calender-content").append(string);
      // My Cutum Code
      $(".day_avilable").parent().click(function() {
        // $(this).hide();
      });

    }

    checkSelected();
    checkBookings();
  }

  function monthClick(e) {
    clickedDays += 1;

    if (clickedDays == 1) {
      $(e).toggleClass("clicked");
      startDateIndex = parseInt($(e).attr('id').split('-')[1]);
      startDate = new Date(currentYear, currentMonth, startDateIndex);
    }
    if (clickedDays > 1) {
      endDateIndex = parseInt($(e).attr('id').split('-')[1]);
      endDate = new Date(currentYear, currentMonth, endDateIndex);
    }
    if (endDate > startDate) {
      var clicked = $(".clicked");
      $(clicked).not(clicked[0]).removeClass("clicked");
      $(e).toggleClass("clicked");

      dateArray = getDates(startDate, endDate);
      dateArray = formatDates(dateArray)
      selectedDates = dateArray;

      for (var i = 0; i < dateArray.length; i++) {
        $("#" + dateArray[i]).addClass("clicked");
      }
    }
    $("#startdate").html(startDate.toString().split(' ').slice(0, 4).join(' '));
    $("#enddate").html(endDate.toString().split(' ').slice(0, 4).join(' '));
  }

  function firstDayOffset(date) {
    return new Date(currentYear, currentMonth, 1).getDay();
  }

  function checkBookings() {
    if (bookedDates != null) {
      for (var i = 0; i < bookedDates.length; i++) {
        var inner = bookedDates[i];
        for (var j = 0; j < inner.length; j++) {
          $("#" + inner[j]).removeClass("clickable").delay(400).addClass("booked");
        }
      }
    }
  }

  function checkSelected() {
    selectedDates = getDates(startDate, endDate);
    selectedDates = formatDates(selectedDates);

    if (selectedDates != null) {
      for (var i = 0; i < selectedDates.length; i++) {
        $("#" + selectedDates[i]).addClass("clicked");
      }
    }
  }

  function addBooking() {
    bookedDates.push(dateArray);
    clearCalender();
    displayCalender();
  }

  function formatDates(dates) {
    if (dates != null) {
      var newDateArray = [];
      for (var i = 0; i < dates.length; i++) {
        var date = "";
        date += dayNames[dates[i].getDay()] + "-";
        date += dates[i].getDate() + "-";
        date += monthNames[dates[i].getMonth()] + "-";
        date += dates[i].getFullYear();
        newDateArray.push(date);
      }
      return newDateArray;
    }
    return null;
  }

  function getDates(startDate, stopDate) {
    if (startDate != "" && endDate != "") {
      var dateArray = new Array();
      var currentDate = startDate;
      while (currentDate <= stopDate) {
        dateArray.push(new Date(currentDate))
        currentDate = currentDate.addDays(1);
      }
      return dateArray;
    }
    return null;
  }

  $(function() {
    displayCalender(currentMonth)
    $("#date").append(new Date);
  });

  $("#left").on("click", function() {
    if (currentMonth > 0)
      currentMonth -= 1;
    else {
      currentMonth = 11;
      currentYear -= 1;
    }
    displayCalender();
  });
  $("#right").on("click", function() {
    if (currentMonth < 11)
      currentMonth += 1;
    else {
      currentMonth = 0;
      currentYear += 1;
    }
    displayCalender();
  });

  $("#remove-booking").on("click", function() {
    if (selectedDates != null && selectedDates.length > 0) {
      bookingSteps += 1;

      if (bookingSteps == 1) {
        clearBooking();
        addBooking();
      }
    }
  });
  /**End Custum Calender**/
  /***Start Wizured Form for Booking***/
  //Initialize tooltips
  $('.nav-tabs > li a[title]').tooltip();

  //Wizard
  $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {

    var $target = $(e.target);

    if ($target.parent().hasClass('disabled')) {
      return false;
    }
  });

  $(".next-step").click(function(e) {

    var $active = $('.wizard .nav-tabs li.active');
    $active.next().removeClass('disabled');
    nextTab($active);

  });
  $(".prev-step").click(function(e) {

    var $active = $('.wizard .nav-tabs li.active');
    prevTab($active);

  });


  function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
  }

  function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
  }
  /***End Wizured Form for Booking***/
  /****/

});