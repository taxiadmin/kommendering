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
$tango->set_property('title', "Förare");
$tango->set_property('title_append', "Administrera förare");

$tango->set_property('style', array('css', 'webroot/css/nohead.css'));
$tango->set_property('style', array('css', 'webroot/js/jquery/include/jquery-ui-1.12.1.custom/jquery-ui.css'));

$tango->js_include("https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js");
$tango->js_include('webroot/js/driver.js');
 driverinfo();

include_once 'footer.php';
include_once (TANGO_THEME_PATH);

function driverinfo() {
//fyller $tango med lite data att skriva ut...
    global $user;
    global $tango;
    $current_driver = new CDriver;
    $selected_driver = $current_driver->id();
//#####################################################################

    //$tango->content( "<p>");
    if ($selected_driver < 0) {
        $tango->content( "<input type='hidden' id='use_driver' name='use_driver' value= -2 />");
    }else{
        $tango->content( "<input type='hidden' name='use_driver' value={$current_driver->id()}>");
        $tango->content( "<form id='select-driver' action='' method='post'>");
        //$tango->content( "<legend>Välj förare</legend>");
        $tango->content( "<fieldset class='select-driver'>");
        $tango->content( "<div class='driver-form-row'>");
        $tango->content( "<div class='input-label driver-form-label'> <label>Välj förare</label></div>");
        $tango->content( "<select class='input' id='use-driver'  name='use_driver'>");
        // Om inloggad är admin val för ny förare
        if ($user->role() == 1 AND $selected_driver != -1) {
            $tango->content( "<option value='-1'>Ny förare</option>");
        }
        // Förarna läggs in i select-kontrollen. Inloggad markeras som vald
        foreach ($user->users() as $user_data_id => $driver_data) {
            $mark_selected = ($user_data_id == $selected_driver) ? 'SELECTED' : '';
            $tango->content( "<option value='{$user_data_id}' {$mark_selected}>{$driver_data['name']}</option>");
        }
        $tango->content( "</select>");
    }

    //$tango->content( "</div>");
    //        $tango->content( "<div class='input-label driver-form-label'> <input class='input' id='visa' type='submit' value='Visa'>");
    //        $tango->content( "</div>");
    $tango->content( "</fieldset>");
// Här börjar rutintn för inloggad förare

    if ($selected_driver > 0) {
        //$tango->content( "</div></fieldset>");

        $tango->content( "</form>");
        $tango->content( "<form  id='form-driverinfo' action='' method='post'>");
        $tango->content( "<legend>Förardata</legend>");
        $tango->content( "<fieldset class='fieldset-driver-data'>");


    }else{
        $tango->content( "<form  id='form-driverinfo' action='' method='post'>");
        $tango->content( "<p><legend>Lägg in förardata</legend></p>");
        //$tango->content( "<fieldset>");
    }
    $tango->content( "<input type='hidden' name='use_driver' value={$selected_driver}>");
    $tango->content( "<div class='driver-form-row'>");
    $tango->content( "<label class='input-label driver-form-label'>Namn  </label>");

    //Selectbox för roll

    $tango->content( "<input class='input' id='name' type='text' name='name' value='{$current_driver->name()}' autocomplete='off' />");
    if ($user->role() == 1 AND $selected_driver != -1) {
        $tango->content( "</div>");
        $tango->content( "<div class='driver-form-row'>");
        $tango->content( "<label class='input-label driver-form-label'>Roll  </label>");
        $tango->content( "<select class='input' id='driver_role'  name='driver_role'>");
        // Förarna läggs in i select-kontrollen. Inloggad markeras som vald
        foreach ($current_driver->driver_role($current_driver->role()) as $driver_roles => $driver_role) {
            $tango->content( "<option value='{$driver_role->id}' {$driver_role->selected}>{$driver_role->data_descr}</option>");
        }
        $tango->content( "</select>");
    }else {

        $tango->content( "<input type='hidden'   name='driver_role' value='10'>");
    }
    $tango->content( "</div>");


    $tango->content( "<div class='driver-form-row'>");
    $tango->content( "<label class='input-label driver-form-label'>Visas </label>");
    $tango->content( "<input class='input' id='display_name' type='text' name='display_name' value='{$current_driver->display_name()}' autocomplete='off' />");
    $tango->content( "</div>");

    if ($selected_driver < 0) {
        $tango->content( "<div class='driver-form-row'>");
        $tango->content( "<label class='input-label driver-form-label'>Inloggning  </label>");
        $tango->content( "<input class='input' id='acronym' type='text' name='acronym' value='{$current_driver->acronym()}' autocomplete='off' /></div>");
        //$tango->content( "</div>");
    }
    if ($selected_driver < 0 || $current_driver->newpassword()) {
        $tango->content( "<div class='driver-form-row'>");
        $tango->content( "<div class='input-label driver-form-label'> <label>Password  </label></div>");
        $tango->content( "<div class='driver-form-input'><input class='input' id='password' type='text' name='password' value='' autocomplete='off' /></div>");
        $tango->content( "</div>");
        $tango->content( "<div class='driver-form-row'>");
        $tango->content( "<div class='input-label driver-form-label'> <label>Repetera  </label></div>");
        $tango->content( "<div class='driver-form-input'><input class='input' id='password_check' type='text' name='password_check' value='' autocomplete='off' /></div>");
        $tango->content( "</div>");
    }
//här kommer fälten från user-posten
    foreach ($current_driver->driver_data($selected_driver) as $driver_data) {
        $tango->content( "<div class='driver-form-row'>");
        $tango->content( "<label class='input-label driver-form-label'>{$driver_data->user_data_descr}  </label>");
        //$tango->content( "<div class='driver-form-input'>");
        $tango->content( "<input class='input' type='text' name='value[]' value='{$driver_data->value}' autocomplete='off' />");
        $tango->content( "<input type='hidden' name='key[]' value='{$driver_data->user_data_descr}' />");
        $tango->content( "<input type='hidden' name='user_data_id[]' value='{$driver_data->user_data_id}' />");
        $tango->content( "<input type='hidden' name='post_id[]' value='{$driver_data->id}' />");
        $tango->content( "</div>");

    }
    if ($user->role() == 1 OR $selected_driver==$_SESSION['user']) {

        $tango->content( "<div class='driver-form-row'>");
        $tango->content( "<button id='save' class='button' type='submit'  name='save' value='{$selected_driver}'>Spara</button>");
        if (!$current_driver->newpassword()) {
            $tango->content( "<button id='passwrd' class='button' type='submit'  name='newpassword' value='true'>Nytt password</button>");
        }
        $tango->content( "</div>");
    }
    $tango->content( "</div>");
    $tango->content( "</fieldset>");
    $tango->content( "</form>");

    return true;
}
