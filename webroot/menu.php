<?php

// This is a menu item

$menu_item['home'] = array(
    'text' => 'Hem',
    'url' => 'start',
    'title' => 'Hem',
    'slug' => null,
    'view' => null);
if ($user->logged_in()) {

    $menu_item['driver'] = array(
        'text' => 'Förare',
        'url' => 'driver',
        'title' => 'Föraradministration',
        'slug' => null,
        'view' => null);

    $menu_item['bilar'] = array(
        'text' => 'Bilar',
        'url' => 'cab',
        'title' => 'Biladministration',
        'slug' => null,
        'view' => null);

    $menu_item['plan'] = array(
        'text' => 'Planering',
        'url' => 'calendar',
        'title' => 'Planera bilar',
        'slug' => null,
        'view' => null);

    $menu_item['login'] = array(
        'text' => 'Login',
        'url' => 'login',
        'title' => 'Login',
        'slug' => null,
        'view' => null);
}

$full_menu['menu'] = array(
    'text' => 'Menu',
    'url' => '#',
    'title' => 'Meny',
    'slug' => null,
    'view' => null,
    'submenu' => array(
        'items' => $menu_item
    ));

$main_menu['id'] = "pagemenu";
$main_menu['class'] = 'pagemenu bottom-nav';
$main_menu['items'] = $menu_item;


// This is the callback tracing the current selected menu item base on scriptname
$main_menu['callback'] = function($url, $view) {
    if (basename($_SERVER['SCRIPT_FILENAME']) == $url) {
        if (isset($_GET['view']) && isset($view) && $view !== $_GET['view']) {
            return false;
        }
        return true;
    }
};
