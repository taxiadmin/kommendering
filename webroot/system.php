<?php

include( __DIR__ . '/config.php');

$tango->set_property('title', "System");
$tango->set_property('title_append', "De dolda möjligheterna");

$tango->set_property('style', array('css', 'webroot/css/nohead.css'));
//$tango->set_property('style', array('css', 'webroot/js/jquery/include/jquery-ui-1.12.1.custom/jquery-ui.css'));

$tango->js_include("https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js");
$tango->js_include('webroot/js/system.js');

$sys->get_system_data();

$keyData = $sys->get_key_data();
$keyValues = $sys->get_keys();
$tango->content( "<form id='select-driver' action='' method='post'>");
$tango->content( "<fieldset class='select-driver'>");
$tango->content( "<div class='driver-form-row'>");
$tango->content( "<div class='input-label driver-form-label'> <label>Välj nyckel</label></div>");
$tango->content ( "<select id='select-data' class='input' name='data_key'>");
foreach ($keyData as $key => $value) {
    $tango->content ( "<option value='$key' {$value->selected} >{$value->description}</option>");
}
$tango->content( "</select></div><!--driver-form-row--></fieldset></form>");

$tango->content( "<form id='select-data-key' action='' method='post'>");
$tango->content( "<fieldset class='select-data'>");
$tango->content( "<div class='driver-form-row'>");
$tango->content( "<div class='input-label driver-form-label'> <label>Beskrivning</label></div>");
$tango->content( "<div class='input-label driver-form-label'> <label>Sort</label></div>");
$tango->content( "<div class='input-label driver-form-label'> <label>Övrigt</label></div>");
$tango->content( "</div><!--driver-form-row-->" );
foreach ($keyValues as $key => $value) {
    $tango->content( "<div class='driver-form-row'>");
    $tango->content ( "<input type='text' name='descr[]' value='{$value->description}'/>");
    $tango->content ( "<input type='text' name='sort[]' value='{$value->sort}'/>");
    $tango->content ( "<input type='text' name='user[]' value='{$value->user}'/>");
    $tango->content("</div><!--driver-form-row-->");
}
$tango->content( "<div class='driver-form-row'>");
$tango->content( "<input type='submit' value='Spara'name='submit'/>");
$tango->content( "<input type='submit' value='Ny' name='submit'/>");
$tango->content("</div><!--driver-form-row-->");

$tango->content( "</fieldset></form>");
include_once (TANGO_THEME_PATH);
