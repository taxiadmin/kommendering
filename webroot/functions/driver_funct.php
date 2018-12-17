<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of driver_funct
 *
 * @author peder
 */
function save_driver() {
    dump($_POST, '$_POST i save_driver');
    global $db;
    global $user;
    $test=$user->show_user(6);
    dump($test, 'show_user i save_driver()');
    $return = new stdClass();
    $return->new_driver = check_password();
    $return->id = (isset($_POST['use_driver'])) ? $_POST['use_driver'] : $_SESSION['user'];
    if (!isset($_POST['save'])) {
        return $return;
    }
    if (!$return->new_driver->return) {
        $return->id = -2;
        return $return;
    }
    if ($_POST['save']==1) {
        echo 'spara posten';
        $sql = "INSERT INTO User (acronym, name, display_name, role, salt) VALUES (?, ?, 10, unix_timestamp());";
        $user_array[] = $_POST['acronym'];
        $user_array[] = $_POST['name'];
        $user_array[] = $_POST['display_name'];
        $succed = $db->DB_execute($sql, $user_array, TRUE);
        if ($succed) {
            echo 'jag lyckades';
            $id = $db->id_new_post();
            $_POST['use_driver'] = $id;
            $sql = "INSERT INTO user_data (user, user_data_id, value) VALUES (?, ?, ?)";
            foreach ($user->user_data() as $row) {
                echo $row->user_data_descr;
                if (!empty($_POST[$row->user_data_descr])) {
                    unset($user_array);
                    $user_array[] = $id;
                    $user_array[] = $row->user_data_id;
                    $user_array[] = $_POST[$row->user_data_descr];
                    $succed = $db->DB_execute($sql, $user_array, FALSE);
                }
            }
            $user->get_users();
        }
        return $return;
    }
}

function check_password() {
    $new_driver = new stdClass();
    $new_driver->name = '';
    $new_driver->acronym = '';
    $new_driver->return = FALSE;
    if (!empty($_POST['password']) && $_POST['password'] === $_POST['password_check']) {
        $return = TRUE;
    } else {
        $new_driver->name = (empty($_POST['name']))? '':$_POST['name'];
        $new_driver->acronym = (empty($_POST['acronym']))?'' :$_POST['acronym'];
        $new_driver->return = FALSE;
    }
    return $new_driver;
}
