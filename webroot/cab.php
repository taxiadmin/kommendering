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
$tango->set_property('title', "Bilar");
$tango->set_property('title_append', "Administrera bilar");
$tango->set_property('style', array('css', 'webroot/css/nohead.css'));
$tango->set_property('style', array('css', 'webroot/js/jquery/css/jquery.ui.timepicker.css'));
$tango->set_property('style', array('css', 'webroot/js/jquery/css/jquery-ui-1.10.0.custom.min.css'));
$tango->js_include("https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js");
$tango->js_include('webroot/js/jquery/include/ui-1.10.0/jquery.ui.core.min.js');
$tango->js_include('webroot/js/jquery/jquery.ui.timepicker.js');
$tango->js_include('webroot/js/jquery.timeentry/jquery.timeentry.js');
$tango->js_include('webroot/js/jquery.timeentry/jquery.timeentry-sv.js');
$tango->js_include('webroot/js/caradmin.js');


include_once TANGO_FUNCTIONS_PATH . "cab_funct.php";

//$tango->set_property('main', cabinfo());
cabinfo();
//include_once 'footer.php';
include_once (TANGO_THEME_PATH);

function cabinfo() {
//fyller $tango med lite data att skriva ut...
    global $user;
    global $tango;
    $current_cab = new CCab;

    $selected_cab = (int)$current_cab->id();

//    $selected_cab = (isset($_POST['use_cab'])) ? $_POST['use_cab'] : $_SESSION['cab'];
////#####################################################################
    $tango->content("<form id='cab-info' action='' method='post'>");
    $tango->content("<fieldset>");
    $tango->content("<legend>\nBilinfo\n</legend>");
    if ($selected_cab < 0) {
        $tango->content("<input type='hidden' name='current_cab' value=-1>");
    } else {
        $tango->content("<div class='cab-form-row'>");
        $tango->content( "<div class='input-label driver-form-label'>");
        $tango->content("<label>Välj bil</label>");
        $tango->content("</div><!-- input-label driver-form-label -->");
        $tango->content("<select id='select-cab' class='input' name='current_cab'>");
        if ($user->role() == 1 AND $selected_cab != -1) {
            $tango->content("<option value='-1'>Ny bil</option>");
        }
        $test = $current_cab->cabs();
        foreach ($current_cab->cabs() as $cabdata) {
            $mark_selected = ($cabdata->id == $selected_cab) ? 'SELECTED' : '';
            $tango->content("<option value='{$cabdata->id}' {$mark_selected}>{$cabdata->cab}</option>");
        }
    $tango->content("</select>");
    $tango->content("</div><!-- cab-form-row -->");
    }
    $tango->content("<div class='cab-form-block left'>");
    if ($selected_cab < 0) {
        $tango->content( "<div class='driver-form-label'>");
        $tango->content("<label>Ny taxi</label>");
        $tango->content("</div><!-- input-label driver-form-label -->");
        $tango->content("<input type='text' name='cab' value='{$current_cab->get_car()}'>");
        $tango->content("</div><!-- cab-form-row -->");
    }
    foreach ($current_cab->cab_data() as $cabdata) {
        $tango->content("<div class='driver-form-row'>");
        $tango->content("<div class='driver-form-label'>\n<label>\n{$cabdata->data_descr}  \n</label>\n</div>");
        $tango->content("<div class='driver-form-label'>");
        $tango->content("<input type='text'  name='value[]' value='{$cabdata->value}'/>");
        $tango->content("<input type='hidden' name='key[]' value='{$cabdata->data_descr}'/>");
        $tango->content("<input type='hidden' name='user_data_id[]' value='{$cabdata->car_id}'/>");
        $tango->content("<input type='hidden' name='post_id[]' value='{$cabdata->id}'/>");
        $tango->content("<input type='hidden' name='key_id[]' value='{$cabdata->key_id}'/>");
        $tango->content("</div><!-- driver-form-label -->\n</div>");
    }
    $tango->content("</div><!-- form-block-left -->");
    $tango->content("<div class='cab-form-block left'>");
    include_once TANGO_VIEWS_PATH . "cab_pass.php";
    $tango->content("</div>");
    if ($user->role() == 1) {

        $tango->content("<div class='cab-form-row'>");
        $tango->content("<button type='submit'  name='save' value='TRUE'>Spara</button>");
        $tango->content("</div>");
    }
    $tango->content("</fieldset>");
    $tango->content("</form>");
//    $cab->pass_time($selected_cab);
}
