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
$tango->set_property('style',array('less', 'webroot/css/test.less'));
$tango->set_property('style', array('css', 'webroot/js/jquery/css/jquery.ui.timepicker.css'));
$tango->set_property('style', array('css', 'webroot/js/jquery/css/jquery-ui-1.10.0.custom.min.css'));
$tango->js_include("https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"); 
$tango->js_include( 'webroot/js/jquery/include/ui-1.10.0/jquery.ui.core.min.js'); 
$tango->js_include('webroot/js/jquery/jquery.ui.timepicker.js');
$tango->js_include('webroot/js/jquery.timeentry/jquery.timeentry.js');
$tango->js_include('webroot/js/jquery.timeentry/jquery.timeentry-sv.js');
$tango->js_include( 'webroot/js/caradmin.js');
include_once TANGO_FUNCTIONS_PATH . "cab_funct.php";

$cab = new CCab();

save_cab();

$tango->set_property('main', cabinfo());

include_once 'footer.php';
include_once (TANGO_THEME_PATH);

function cabinfo() {
//fyller $tango med lite data att skriva ut...
    global $cab;
    global $user;
    
    $selected_cab = (isset($_POST['use_cab'])) ? $_POST['use_cab'] : $_SESSION['cab'];
////#####################################################################

    $content = "<div id='form-cab'>\n";
    $content .= "<form action='' method='post'>\n";
    $content .= "<fieldset>\n";
    $content .= "<legend>\nFörare\n</legend>\n";
    if ($selected_cab == -1) {
        $content .= "<div class='cab-form-row'>\n";
        $content .= "<div class='cab-form-label'>\n<label>Inloggning  </label>\n</div>\n<!-- cab-form-label -->";
        $content .= "<div class='cab-form-input'>\n<input type='text' name='acronym' value=''></div>\n</br>\n";
        $content .= "</div>\n";
        $content .= "<div class='cab-form-row'>\n";
        $content .= "<div class='cab-form-label'>\n<label>Namn  </label>\n</div>\n<!-- cab-form-label -->";
        $content .= "<div class='cab-form-input'>\n<input type='text' name='name' value=''></br>\n";
        $content .= "</div>\n";
        $content .= "<div class='cab-form-row'>\n";
        $content .= "<div class='cab-form-label'>\n<label>Password  </label>\n</div>\n<!-- cab-form-label -->";
        $content .= "<div class='cab-form-input'>\n<input type='text' name='password' value=''></div>\n</br>\n";
        $content .= "</div>\n";
        $content .= "<div class='cab-form-row'>\n";
        $content .= "<div class='cab-form-label'>\n<label>Repetera  </label>\n</div>\n";
        $content .= "<div class='cab-form-input'>\n<input type='text' name='password_check' value=''></div>\n</br>\n";
        $content .= "</div>\n";
    } else {
        $content .= "<div class='cab-form-row'>\n";
        $content .= "<div class='cab-form-label'>\n";
        $content .= "<select name='use_cab'>\n";
        if ($user->role() == 1 AND $selected_cab != -1) {
            $content .= "<option value='-1'>Ny bil</option>\n";
        }
        foreach ($cab->cabs() as $cabdata) {
            $mark_selected = ($cabdata->id == $selected_cab) ? 'SELECTED' : '';
            $content .= "<option value='{$cabdata->id}' {$mark_selected}>{$cabdata->cab}</option>\n";
        }
        $content .= "</select>\n";
        $content .= "</div>\n";
        $content .= "<div class='cab-form-input'>\n<input type='submit' value='Visa'>\n";
        $content .= "</div>\n";
        $content .= "</div>\n";
        $content .= "</fieldset>\n";
        $content .= "</form>\n";
        $content .= "</div>\n";
        $content .= "<div id='form-cabinfo'>\n";
        $content .= "<form action='' method='post'>\n";
        $content .= "<fieldset>\n";
        $content .= "<legend>\nBilinfo\n</legend>\n";
        $content .= "<div class='cab-form-content'>\n";
        $content .= "<div class='cab-form-block left'>\n";
    }
    foreach ($cab->cab_data($selected_cab) as $cabdata) {
        $content .= "<div class='cab-form-row'>\n";
        $content .= "<label class='cab-form-label'>\n{$cabdata->data_descr}</label>\n";
        $content .= "<div class='cab-form-label'>\n"
                . "<input type='text' name='{$cabdata->data_descr}' value='{$cabdata->value}'>\n</div>\n";
        $content .= "</div>\n";
    }
        $content .= "</div>\n";
    $content .= "<div class='cab-form-block left'>\n";
    include_once TANGO_VIEWS_PATH . "cab_pass.php";
    $content .= "</div>\n";
    $content .= "</div>\n";
    if ($user->role() == 1) {

        $content .= "<div class='cab-form-row'>\n";
        $content .= "<button type='submit'  name='save' value='TRUE'>Spara</button></br>\n";
        $content .= "</div>\n";
    }
    $content .= "";
    $content .= "</fieldset>\n";
    $content .= "</form>\n";
    $content .= "</div>\n";
    $cab->pass_time($selected_cab);
    return $content;
}
