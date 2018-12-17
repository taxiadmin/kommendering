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
$tango->js_include("https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"); 
$tango->js_include('webroot/js/jquery/jquery.ui.timepicker.js');
$tango->js_include('webroot/js/jquery/jquery.ui.timepicker.js');
$tango->js_include('webroot/js/jquery.plugin.js');
$tango->js_include('webroot/js/jquery.timeentry/jquery.timeentry.js');
$tango->js_include('webroot/js/jquery.timeentry/jquery.timeentry-sv.js');
$tango->js_include( 'webroot/js/test.js');
$tango->js_include( 'webroot/js/taxi_js.js');

include_once TANGO_FUNCTIONS_PATH . "cab_funct.php";


$tango->set_property('main', test());

include_once 'footer.php';
include_once (TANGO_THEME_PATH);

function test(){
    $cont="Ett testprogram";
    $cont.="<p>Enter your time: <input type='text' class='defaultEntry' size='10'></p>";
    $cont.="";
    $cont.="";
    $cont.="";
    $cont.="";
    $cont.="";
    $cont.="";
    $cont.="";
    $cont.="";
    $cont.="";
    $cont.="";
    
    return $cont;
}


//<script type="text/javascript">
//
//</script>
//</head>
//<body>
//<h1>jQuery Time Entry Basics</h1>
//<p>This page demonstrates the very basics of the
//	<a href="http://www.jqueryscript.net/time-clock/jQuery-Plugin-for-Input-Field-Time-Format-Spinner-Time-Entry.html">jQuery Time Entry plugin</a>.
//	It contains the minimum requirements for using the plugin and
//	can be used as the basis for your own experimentation.</p>
//
//<script type="text/javascript">
//
//  var _gaq = _gaq || [];
//  _gaq.push(['_setAccount', 'UA-36251023-1']);
//  _gaq.push(['_trackPageview']);
//
//  (function() {
//    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
//    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
//    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
//  })();
//
//</script>
