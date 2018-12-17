<?php

// Configfile For tango
// Error reporting
//
//Måste läsa mer om detta, otydlig förståelse.
//
error_reporting(E_ALL);

mb_internal_encoding("UTF-8");
//
//error_reporting(-1); // Report all types of errors
//ini_set('display_errors', 1); //Visar alla fel
//ini_set('output_buffering', 0); //Skriv felen direkt
// Skapar sökvägar som ska användas i systemet

define('TANGO_INSTALL_PATH', __DIR__ . '/..');
define('TANGO_SOURCE_PATH', TANGO_INSTALL_PATH . '/src/');
define('TANGO_THEME_PATH', TANGO_INSTALL_PATH . '/theme/renderer.php');
define('TANGO_FUNCTIONS_PATH', TANGO_INSTALL_PATH . '/webroot/functions/');
define('TANGO_VIEWS_PATH', TANGO_INSTALL_PATH . '/webroot/views/');
define('TANGO_SCRIPT_PATH', __DIR__ . '/js/');

define('DRIVER_CHANGE', 7);


/**
 *
 * Bootstrapp-funktionerna
 *
 */
include_once (TANGO_INSTALL_PATH . '/src/bootstrap.php');

// Pga behov av funktionerna dump() och print_a tidigare i processen vid utveckling ...
include_once (TANGO_INSTALL_PATH . '/theme/functions.php');

/**
 *
 * Starta sessionen
 *
 */
session_name(preg_replace('/[^a-z\d]/i', '', __DIR__));
session_start();


// skapar en instans av tango
$tango = new CTango();
//Skapar en ny instans av CSystem
$sys = new CSystem;




/**
 * Om siten ska ha databas, sätt $use_db till true
 */
$use_db = TRUE;
$use_login = TRUE;

if ($use_db) {

// Sätt DROP_DB till true för att skapa nya tabeller.
// Observera att alla data kommer att raderas och ersätas med defaultdata
    define('DROP_DB', FALSE);
// Sätt SAMPLE_DATA til false för att få en tom databas
    define('SAMPLE_DATA', TRUE);


    // Först skapar vi en array för att föra in inloggningsuppgifter i databasklassen

    // Först skapar vi en array för att föra in inloggningsuppgifter i databasklassen
//    $db_connect['dsn']            = 'mysql:host=tst-159065.mysql.binero.se;dbname=159065-tst;';
//    $db_connect['username']       = '159065_fk52886';
//    $db_connect['password']       = 'L0s3n0rd';
//    $db_connect['driver_options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");
//
//    // Först skapar vi en array för att föra in inloggningsuppgifter i databasklassen
//    $db_connect['dsn']            = 'mysql:host=blu-ray.student.bth.se;dbname=penc14;';
//    $db_connect['username']       = 'penc14';
//    $db_connect['password']       = 'pf#g/hR5';
//    $db_connect['driver_options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");
//
    //sedan en ny instans av den
    //include_once 'dbcreate/dbcreate.php';
    $db = new CDatabase();
}
if ($use_login) {
    $user = new CUser;
}

include "header.php";
include 'menu.php';
if ($include != '/cab') {
    if (isset($_SESSION)) {
        unset($_SESSION['cab']);
    } else {
        echo 'Finns inte';
    }
}

/**
 * Settings for $tango.
 *
 * Här kan man ändra defaultvärdena på olika parametrar som är fördefinierade i
 * CTango.
 *
 */
// $tango->set_property('lang', "sv");
// $tango->set_property('favicon', "");
// $tango->set_property('style', array("css/style.css"));

$tango->set_property('modernizr', 'js/modernizr.js');
//
// För att få fart på google analytics skickar man sitt kontoid till CTango
// $tango->set_property('google_analytics', '');
// $tango->set_property('title',"");
// $tango->set_property('title_append', "");
$tango->set_property('logo', "");
