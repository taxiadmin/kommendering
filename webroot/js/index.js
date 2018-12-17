"use strict";

$(document).ready(function () {
    var screenHeight = window.innerHeight;
    var wrapper = getElementById("pagemenu");
    var wrapperHeight = screenHeight - wrapper.offsetHeight;
    console.log(screenHeight);
    console.console.log(wrapperHeight);

    $("#use-driver").change(function () {
        $("#select-driver").submit();
    });
});
