<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$tango->content("\n<!-- Här börjar rutinten för att skapa inmatningsfält för pass -->\n");


$tider = $current_cab->pass_time();
$pass = 0;
$day = 0;
$tango->content("<div class='cab-form-row'>\n<div class='field'>");
for ($pass = 0; $pass < 2; $pass++) {
    $pass_etikett = $pass + 1;
    $tango->content("<div id='pass{$pass}' class='cab-pass-row'>");
    $tango->content("Pass " . $pass_etikett);
    $tango->content("\n</div>");
}
$tango->content("</div>\n</div>");
for ($day = 0; $day < 7; $day++) {
    $tango->content("<div class='cab-form-row'>");
    for ($pass = 0; $pass < 2; $pass++) {
        $tango->content("<div class='cab-pass-row'>");
        $tango->content("<input type='text' name='pass{$pass}_start[{$day}]' class='pass' value='{$tider[$day]["pass{$pass}_start"]}'/>");
        $tango->content("<input type='text' name='pass{$pass}_stop[{$day}]' class='pass' value='" . $tider[$day]["pass{$pass}_stop"] . "'/>");
        $tango->content("</div>");
    } //end for day;
    $tango->content("</div>");
} //end for pass
$tango->content("");
$tango->content("");
$tango->content("");
$tango->content("");
$tango->content("");
$tango->content("");


$tango->content("\n<!-- Här slutar rutinten för att skapa inmatningsfält för pass -->\n");
