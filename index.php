<?php

$db_connect['dsn'] = 'mysql:host=turakarna2-159065.mysql.binero.se;dbname=159065-turakarna2;';
$db_connect['username'] = '159065_ut55346';
$db_connect['password'] = 'T4x14dm1n';
$db_connect['driver_options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");

$include = '';
if (isset($_POST['logout'])) {
    unset($_SESSION['user']);
    include 'webroot/start.php';
//}elseif (!isset($_SESSION['user']) && $_SERVER['REQUEST_URI'] != '/login') {
//    include 'webroot/start.php';
} elseif ($_SERVER['REQUEST_URI'] === '/' || stristr($_SERVER['REQUEST_URI'], '/?') != FALSE) {
    include 'webroot/start.php';
} elseif (stristr($_SERVER['REQUEST_URI'], '.php') != FALSE) {
    include 'webroot/' . stristr($_SERVER['REQUEST_URI'], '.php', TRUE) . '.php';
} else {
    $include = (stristr($_SERVER['REQUEST_URI'], '?', TRUE) ? stristr($_SERVER['REQUEST_URI'], '?', TRUE) : $_SERVER['REQUEST_URI']);
    include "webroot/{$include}.php";
}
