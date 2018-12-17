//$(document).ready(function(){
//  'use strict';
//  var text;
//  text = document.getElementById('text');
//  text.innerHTML = 'Hello World, document is ready!';
//  text.className = 'green';
//  console.log('Everything is ready.');  
//  

$(document).ready(function () {
    $(".calendarpost").tooltip();
    $('.calendarpost').hover(function () {
        $('.tooltip').text($(this).attr('calendar-time'));
        var ttLeft,
                ttTop,
                $this = $(this),
                $tip = $($this.attr('data-tooltip')),
                triggerPos = $this.offset(),
                triggerH = $this.outerHeight(),
                triggerW = $this.outerWidth(),
                tipW = $tip.outerWidth(),
                tipH = $tip.outerHeight(),
                screenW = $(window).width(),
                scrollTop = $(document).scrollTop();
        if (triggerPos.top - tipH - scrollTop > 0) {
            ttTop = triggerPos.top - tipH + 30;
        } else {
            ttTop = triggerPos.top + triggerH + 100;
        }

        var overFlowRight = (triggerPos.left + tipW) - screenW;
        if (overFlowRight > 0) {
            ttLeft = triggerPos.left - overFlowRight - 10;
        } else {
            ttLeft = triggerPos.left + triggerW;
        }
        var post_id = $(this).attr('calendar-id');
        if (post_id > 0) {
            $('.tooltip').css({left: ttLeft,
                top: ttTop,
                position: 'absolute'
            })
                    .stop(true).delay(800).fadeIn(200);
        }
    },
            function () {
                $('.tooltip').hide();
    }); // end mouseover

    $('.calendarpost').mouseout(function () {
        $(this).css('background-color', '#F2F2F2');
        $('#day' + $(this).attr('calendar-day')).css('background-color', '#E8E8E8');
    }); // end mouseout

    $('.calendarpost').click(function () {
        var message = $(this).text();
        var pass = $(this).attr('calendar-pass');
        var datum = $(this).attr('calendar-day');
        var post_id = $(this).attr('calendar-id');
        var tfl = $('#current_driver :selected').val();
        var tfl_update = '0';
        var namn = $('#current_driver :selected').text();
        if (post_id > 0) {
            if (message == namn) {
                message = "-----";
                tfl_update = '';
            } else if (message == '-----') {
                message = namn;
                tfl_update = tfl;
            } else {
                message = namn;
                tfl_update = tfl;
            }
            $(this).text(message);
            $('#update_calendar').append('<input type= "hidden" name= "tfl[]" value="' + tfl_update + '"  /> ');
            $('#update_calendar').append('<input type= "hidden" name= "post_id[]" value="' + post_id + '"  /> ');
        }
    }); // end calendarpost click
//
//    $('.pass').timepicker({
//        showPeriodLabels: false,
//    });
    $('.pass').mouseout(function () {
        var $background
        var message = $(this).text();
        if (message == '-----') {
            $background = 'greenyellow';
        } else {
            $background = 'E8E8E8';
        }
        $(this).css('background-color', $background);
        $('#day' + $(this).attr('calendar-day')).css('background-color', $background);
    }); // end mouseout


    $(function () {
        $('.pass').timeEntry({spinnerImage: ''});
    });
}); // end ready







