$(function () {
    'use strict';

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
    var monthShortNames = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
    var dayNames = ["Sun", "Mon", "Tue", "Wed", "Thur", "Fri", "Sat"];
    var bookedDates = [];
    var selectedDates = [];

    Date.prototype.addDays = function (days) {
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
    //
    // function monthClick(e) {
    //   clickedDays += 1;
    //
    //   if (clickedDays == 1) {
    //     $(e).toggleClass("clicked");
    //     startDateIndex = parseInt($(e).attr('id').split('-')[1]);
    //     startDate = new Date(currentYear, currentMonth, startDateIndex);
    //   }
    //   if (clickedDays > 1) {
    //     endDateIndex = parseInt($(e).attr('id').split('-')[1]);
    //     endDate = new Date(currentYear, currentMonth, endDateIndex);
    //   }
    //   if (endDate > startDate) {
    //     var clicked = $(".clicked");
    //     $(clicked).not(clicked[0]).removeClass("clicked");
    //     $(e).toggleClass("clicked");
    //
    //     dateArray = getDates(startDate, endDate);
    //     dateArray = formatDates(dateArray)
    //     selectedDates = dateArray;
    //
    //     for (var i = 0; i < dateArray.length; i++) {
    //       $("#" + dateArray[i]).addClass("clicked");
    //     }
    //   }
    //   $("#startdate").html(startDate.toString().split(' ').slice(0, 4).join(' '));
    //   $("#enddate").html(endDate.toString().split(' ').slice(0, 4).join(' '));
    // }


    function displayCalender() {
        var days = daysInMonth(currentMonth + 1);

        $("#calender-title p").html(monthNames[currentMonth].toUpperCase());
        $("#calender-content").html("");

        for (var i = 1; i < firstDayOffset(new Date()); i++) {
            $("#calender-content").append("<div class='month flex center-vh'></div>");
        }
        for (var i = 1; i <= days; i++) {
            var day = new Date(currentYear, currentMonth, i).getDay(),
                string = "<div class='month'><div id='" + currentYear + "-" + monthShortNames[currentMonth] + "-" + i + "'class='month-selector flex center-vh clickable'><span class='day_avilable '>0</span><p>" + i + "</p></div></div>";
            // My Custum Var

            // var string = "<div class='month'><div id='" + dayNames[day] + "-" + i + "-" + monthNames[currentMonth] + "-" + currentYear + "'class='month-selector flex center-vh clickable' onclick='monthClick(this)'><span class='day_avilable '>5</span><p>" + i + "</p></div></div>";

            $("#calender-content").append(string);


        }

        checkSelected();
        checkBookings();


        /***************** Start MY Pure keyCode*****************/
        $(".month").click(function () {
            $(this).addClass("active").siblings().removeClass("active");
            $(".available_dates-title").text(monthNames[currentMonth] + "-" + currentYear);
            $(".available_dates-list").fadeIn(1000);
            $('html,body').animate({
                scrollTop: $(".available_dates-list").offset().top - 100
            }, 1000);

        });

        /***************** End MY Pure keyCode*****************/
    }
    // Add Selected Date To Date List
    var counter = 0;
    $(".date_selected-js").on('click', function () {

        $(this).prop('disabled', 'true');
        if ($(this).is(':checked')) {
            var selectedDate = $(this).parent(".available_dates-add").siblings(".available_dates-details").html();
            var dateMove = "<li class='selected_dates-content'><aside id='selected_dates-details-" + counter + "'></aside><aside class='selected_dates-add'><i class='fas fa-times date_remove-js'></i><label>حذف من القائمة</label></aside></li>";
            $(dateMove).appendTo(".menu_selected-dates ul");
            $(selectedDate).appendTo("#selected_dates-details-" + counter);
            counter++;
            // Remove Selected Dates
            $(".date_remove-js").on('click', function () {
                $(this).parents(".selected_dates-content").hide();
            });

        } else {
            // $("#selected_dates-content-" + counter).fadeOut();

        }

    });




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

    $(function () {
        displayCalender(currentMonth)
        $("#date").append(new Date);
    });

    $("#left").on("click", function () {
        if (currentMonth > 0)
            currentMonth -= 1;
        else {
            currentMonth = 11;
            currentYear -= 1;
        }
        displayCalender();
    });
    $("#right").on("click", function () {
        if (currentMonth < 11)
            currentMonth += 1;
        else {
            currentMonth = 0;
            currentYear += 1;
        }
        displayCalender();
    });

    $("#remove-booking").on("click", function () {
        if (selectedDates != null && selectedDates.length > 0) {
            bookingSteps += 1;

            if (bookingSteps == 1) {
                clearBooking();
                addBooking();
            }
        }
    });

    /**End Custum Calender**/

});
