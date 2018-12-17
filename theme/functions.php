<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function print_a($array, $info = '') {
    echo "<br />" . $info;
    ?><pre><?php print_r($array); ?></pre><?php
}

function dump($array, $info = '') {
    echo "<br />" . $info;
    ?><pre><?php var_dump($array); ?></pre><?php
}

function checkLogin() {
    if (!isset($_SESSION['user'])) {
        $url= '/';
        header("location:$url");
    }
}

function html($txt = "") {
    global $tango;
    $tango->content($txt);
    return true;
}
