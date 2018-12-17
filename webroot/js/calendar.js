$(document).ready(function () {

    $('.tooltip').hide();
    $('.calendarpost').click(function () {

        var driver_id = $('#current_driver :selected').val();
        var post_id = $(this).attr('calendar-id');

        if ($(this).hasClass("redigera")) {
            if ($(this).hasClass("tagen")) {
                driver_id = '';
                $(this).toggleClass('free-day', true);
                $(this).toggleClass('tagen', false);
                $(this).text('-----');
            } else {
                var driver_name = $('#current_driver :selected').text();
                $(this).toggleClass('tagen', true);
                $(this).toggleClass('free-day', false);
                $(this).text(driver_name);
            }
            $('#update_calendar').append('<input type= "hidden" name= "driver[]" value="' + driver_id + '"  /> ');
            $('#update_calendar').append('<input type= "hidden" name= "post_id[]" value="' + post_id + '"  /> ');
        }

    });
    $('.calendarpost').mouseover(function () {
        $('.tooltip').text($(this).attr('pass-time'));
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
            ttTop = triggerPos.top + triggerH;
        }

        var overFlowRight = (triggerPos.left + tipW) - screenW;
        if (overFlowRight > 0) {
            ttLeft = triggerPos.left - overFlowRight - 10;
        } else {
            ttLeft = triggerPos.left + triggerW;
        }
        var post_id = $(this).attr('calendar-id');
        $('.tooltip').css({left: ttLeft,
            top: ttTop,
            position: 'absolute'
        })
                .stop(true).delay(2000).fadeIn(600);

    });

    $('.calendarpost').mouseout(function () {

        $('.tooltip').hide();
    });

    $('.redigera').hover(
            function () {
                $(this).toggleClass('post-in-focus');
            },
            function () {
                $(this).toggleClass('post-in-focus');
            });
});
//    