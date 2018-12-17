<?php

/*
  Copyright (C) 2016 peder

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

  #########################################################################
 */

// Ikluderar config.php. som sätter igång allt.

include( __DIR__ . '/config.php');
$tango->set_property('title', "Planering");
$tango->set_property('title_append', "Planera bilar");
$tango->set_property('style', array('css', 'webroot/css/old.css'));
$tango->set_property('style', array('css', 'webroot/css/nohead.css'));
$tango->set_property('style', array('css', 'webroot/js/jquery/include/jquery-ui-1.12.1.custom/jquery-ui.css'));
$tango->js_include("https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js");
$tango->js_include('webroot/js/calendar.js');
include_once TANGO_FUNCTIONS_PATH . "cab_funct.php";

$dates = new CDates();

$tango->set_property('main', test());

include_once 'footer.php';
include_once (TANGO_THEME_PATH);

/// inget under här kommer med. Dumdjävel.

function test() {
    global $user;
    $cal = new CCalendar();
    //$cab_data = $cal->calendar_data();

    $cont = "<div id='form-cab'>\n";
    $cont .= "<div class='cab-form-row'>\n";
    $cont .= "<div id='calendar'>\n";
    $cont .= "<div id= 'calendar_heading'>\n";
    $cont .= "<div class='rubrik'>\n";
    $cont .= "<div id='calendar_heading_date'>\n";
    $cont .= "<span class='prev_month left'>\n";
    $cont .= $cal->out_link_prev_month() . "\n";
    $cont .= "</span>\n";
    $cont .= "<span class='left'>\n";
    $cont .= $cal->txi_month_name(0);
    $cont .= $cal->out_year() . "\n";
    $cont .= "</span>\n";
    $cont .= "<span class='next_month left'>\n";
    $cont .= $cal->out_link_next_month();
    $cont .= "</span>\n";
    $cont .= "</div><!-- #calendar_heading_date -->\n";
    if ($user->role() != 1) {
        $cont .= "<div class='hidden_element'>";
    }
    $cont .= "<select id='current_driver' name='driver' size='1'>>";
// Dörarna läggs in i select-kontrollen. Inloggad markeras som vald
    foreach ($user->users() as $user_data_id => $userdata) {
        $mark_selected = ($user_data_id == $_SESSION['user']) ? 'SELECTED' : '';
        $cont .= "<option value='{$user_data_id}' {$mark_selected} >{$userdata['display_name']}</option>\n";
    }
    $cont .= "</select>";
    if ($user->role() != 1) {
        $cont .= "</div >";
    }
    $cont .= "</div><!-- .rubrik -->\n";
    $cont .= "</div><!-- #calendar_heading -->\n";
    $cont .= "<div id='the-calendar'>";
    $cont .= $cal->the_calendar['cab'];
    $cont .= $cal->the_calendar['pass_name'];
    if (!empty($cal->the_calendar['pass'])) {
        foreach ($cal->the_calendar['pass'] as $calendar_row) {
            $cont .= $calendar_row;
        }
//
//        $cont .= "</div><!-- .bil-calendar -->\n";
//    } //end foreach

        $cont .= "</div><!-- #the-calendar -->\n";
        $cont .= "<div class='cab-form-row'>\n";

        $cont .= "<form id= 'update_calendar' name= 'update' action='' method='post' >";
        $cont .= "<input type= 'submit' name='update' value='Uppdatera' />";
        $cont .= "</form>";
    }
    if ($user->role() == 1) {
        $cont .= "<div class='cab-form-row'>\n";
        $cont .= "<form id= 'create_calendar' name= 'create' action='' method='post' >";
        $cont .= " <input type= 'submit' name='create' value='Skapa kalender' />";
        $cont .= "</form>";
    }
    $cont .= "</div>";
    $cont .= "</div><!-- #calendar -->\n";
    $cont .= "</div><!-- .form_row -->\n";

    $cont .= "<div class='tooltip' id='calendarpost'>";
    $cont .= "<h2>Pass</h2>";
    $cont .= " </div>";
    return $cont;
}

//end tur_cal_print_days_in_month
