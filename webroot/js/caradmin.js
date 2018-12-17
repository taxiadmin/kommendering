/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){

    $("#select-cab").change(function () {
        $("#cab-info").submit();
    });

    $(function () {
        $('.pass').timeEntry({spinnerImage: '',  timeSteps: [1, 30, 0]});
    });
});
