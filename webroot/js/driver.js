/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {
    $("#use-driver").change(function () {
        $("#select-driver").submit();
    });
    $( "#form-driverinfo" ).submit(function( event ) {
        if ($("#password").length) {
            if ($("#password").val() === "") {
                alert("Du måste fylla i password");
                event.preventDefault();
            }else if ( $("#password").val() !== $("#password_check").val()) {
                alert("Du har skrivit olika i passwordfälten");
                event.preventDefault();
            }else if ($("#password").val().length < 8 ) {
                alert("Password måste vara minst 8 tecken");
                event.preventDefault();
            }
        }
    });

});
