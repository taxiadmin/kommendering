<?php 
/**
 * This is a tango pagecontroller.
 *
 */
// Include the essential config-file which also creates the CTango-class variable with its defaults.
include(__DIR__.'/config.php'); 



// Do it and store it all in variables in the Anax container.
$tango->set_property('title','404');
$tango->set_property('header',"");
$tango->set_property('main', "This is a Anax 404. Document is not here.");
$tango->set_property('footer', "");

// Send the 404 header 
header("HTTP/1.0 404 Not Found");


// Finally, leave it all to the rendering phase of Anax.
include(ANAX_THEME_PATH);
