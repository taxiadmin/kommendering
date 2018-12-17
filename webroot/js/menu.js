"use strict";

(function(){
    console.log("tjipp");
    window.addEventListener('onclick', function() {
        var screenHeight = window.innerHeight;
        var menu = document.getElementById("pagemenu");
        var wrapperHeight = screenHeight - menu.offsetHeight;
        var wrapper = document.getElementById("wrapper");

        wrapperHeight = wrapperHeight + "px";
        wrapper.style.maxHeight = "wrapperHeight";
        var mehhhn = wrapper.style.backgroundColor
        console.log(wrapperHeight + " 1");
        console.log(menu.offsetHeight + " 2");
        console.log(mehhhn + " 3");


    });
})()
