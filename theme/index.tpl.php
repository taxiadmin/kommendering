<?php
/*
Copyright (c) 2018 by Peder Nordenstad.

 This program is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY;
 without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program. If not, see <http://www.gnu.org/licenses/>.
 */


$renderHTML = "<!DOCTYPE html>";
$renderHTML .= $tango->head();
$renderHTML .= "<body>";
$renderHTML .= "<div id='header'>";
$renderHTML .= $tango->header();
$renderHTML .= "</div><!-- header -->";
$renderHTML .= "<div id='wrapper'>";
$renderHTML .= $tango->menu($main_menu);
$renderHTML .= "<div id='content'>";
$renderHTML .= $tango->main();
$renderHTML .= "<footer id='footer'>";
$renderHTML .= $tango->footer();
$renderHTML .= "</footer>";
$renderHTML .= "</div> <!-- content -->";
$renderHTML .= "</div> <!-- wrapper -->";
$renderHTML .= $tango->scripts_footer();
$renderHTML .= "</body>";
$renderHTML .= "</html>";


$regex = "~([\S]?)([ \t]*)(<)(.)(.*?)(.?)(>)([\s]*)~";
$renderHTML = preg_replace_callback($regex,"parseHTML",$renderHTML);
$tabcount = 2;
function parseHTML($m) {
    static $tabcount = 0;
    $m[2] = ($m[4] == "/" ? "\n" : "");
    $m[8] = "\n";
    if ($m[6] == "/" || $m[4] == "!") {
        for ( $i = 0; $i < $tabcount; $i++) {
            $m[8] .=  "\t";
        }
    } elseif ($m[4] != "/") {
        $tabcount ++;
        for ( $i = 0; $i < $tabcount; $i++) {
            $m[8] .=  "\t";
        }
    } elseif ($m[4] == "/") {
        $tabcount --;
        for ( $i = 0; $i < $tabcount; $i++) {
            $m[8] .=  "\t";
        }
        for ( $i = 0; $i < $tabcount; $i++) {
            $m[2] .=  "\t";
        }
    }
    return $m[1].$m[2].$m[3].$m[4].$m[5].$m[6].$m[7].$m[8];
}
$regex = "~([\n])([\t]*)([\n])([\t]*)~";
$renderHTML = preg_replace_callback($regex,"fixLf",$renderHTML);
$tabcount = 2;
function fixLf($m) {
    $m[1] = "";
    $m[2] = "";
    return $m[1].$m[2].$m[3].$m[4];
}

echo $renderHTML;
