<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CDriver
 *
 * @author peder
 */
class CDriver {

    private $driver = '';

    public function __construct() {

        $this->driver = (object) $this->driver;
        $this->extract_post();
        if (isset($this->driver->save) && $this->driver->save < 0) {
            $this->check_password();
        } else {
            $this->driver->id = (isset($this->driver->use_driver)) ? $this->driver->use_driver : $_SESSION['user'];
        }
        if (!empty($this->driver->save)) {
            $this->save_driver();
        }
        $this->driver();
    }

    private function driver() {
        if ($this->driver->id < 0) {
            $this->new_driver();
        } else {
            global $user;
            $use_driver = $user->show_user($this->driver->id);
            $this->driver->name = $use_driver->name;
            $this->driver->display_name = $use_driver->display_name;
//            unset $_POST;
        }
    }

    /* fyller $this-<driver med data om det ska skapas en ny förare.
       $this->driver->id är -1 om ny förare valts, -2 om posten inte kunde sparas.
       funktionen ger tomma fält i det första alternativet, annars behålls inmatade värden
     */    
    private function new_driver() {
        $this->driver->name = (empty($this->driver->name) OR $this->driver->id == -1) ? '' : $this->driver->name;
        $this->driver->acronym = (empty($this->driver->acronym) OR $this->driver->id == -1) ? '' : $this->driver->acronym;
        $this->driver->display_name = (empty($this->driver->display_name) OR $this->driver->id == -1) ? '' : $this->driver->display_name;
    }

    private function save_driver() {
        $user_array[] = $this->driver->name;
        $user_array[] = $this->driver->display_name;
        if ($this->driver->id < 0){   // om ny förare ska sparas
            $this->create_new_driver($user_array);
        } else {
            $this->update_driver($user_array);
        }
    }

    private function update_driver($user_array) {
        global $db;
        global $user;
        $sql = "UPDATE User SET name=?, display_name=? WHERE id=?;";
        $user_array[] = $this->driver->id;
        $succed = $db->DB_execute($sql, $user_array, FALSE);
        if ($succed) {
            $sql = "UPDATE user_data SET value=? WHERE ID=?";
            foreach ($user->user_data() as $row) {
                if (!empty($this->driver->{$row->user_data_descr})) {
                    unset($user_array);
                    $user_array[] = $this->driver->{$row->user_data_descr}->value;
                    $user_array[] = $this->driver->{$row->user_data_descr}->post_id;
                    $succed = $db->DB_execute($sql, $user_array, FALSE);
                }
            }
            $user->get_users();
        }
        return TRUE;
    }

    private function create_new_driver($user_array) {
        global $db;
        global $user;
        echo 'new driver';
        $sql = "INSERT INTO User ( name, display_name,acronym, role, password, salt) VALUES (?, ?, ?, ?, ?, unix_timestamp());";

        $user_array[] = $this->driver->acronym;
        $user_array[] = 10;
        $user_array[] = $this->driver->password;
        $succed = $db->DB_execute($sql, $user_array, TRUE);
        if ($succed) {
            $id = $db->id_new_post();
            $this->driver->use_driver = $id;
            $this->update_password($id);

            $sql = "INSERT INTO user_data (user, user_data_id, value) VALUES (?, ?, ?)";
            foreach ($user->user_data() as $row) {
                if (!empty($this->driver->{$row->user_data_descr})) {
                    unset($user_array);
                    $user_array[] = $id;
                    $user_array[] = $this->driver->{$row->user_data_descr}->user_data_id;
                    $user_array[] = $this->driver->{$row->user_data_descr}->value;
                    $succed = $db->DB_execute($sql, $user_array, TRUE);
                }
            }
            $user->get_users();
        }
        //Uppdaterar $_POST så användaren skickas med till nästa sida. Annars kommer inloggad användare visas.
        $_POST['use_driver'] = $id;
        // uppdaterar $this->driver->id så sedan rendeare
        $this->driver->id = $id;
        return TRUE;
    }

    private function update_password($id) {
        global $db;
        $sql = "UPDATE User SET password = md5(concat(?, salt)) WHERE id = ?";
        $passw_array[] = $this->driver->password;
        $passw_array[] = $id;

        $succed = $db->DB_execute($sql, $passw_array, TRUE);
    }

    private function check_password() {
        // Kollar om password är samma i boda fälten
        if (!empty($this->driver->password) && $this->driver->password === $this->driver->password_check) {
            $this->driver->id = -1;
            return TRUE; // Sätter $driver->new_driver till TRUE om password stämmer
//        }elseif (!isset ($this->driver->password)) {         
//         return TRUE; // Sätter $driver->new_driver till TRUE om password inte ska uppdateras  
        }
        $this->driver->id = -2;
        return FALSE; // Sätter $driver->new_driver till FALSE om password inte stämmer
    }

    public function id() {
        return $this->driver->id;
    }

    public function name() {
        return $this->driver->name;
    }

    public function display_name() {
        return $this->driver->display_name;
    }

    public function acronym() {
        return $this->driver->acronym;
    }

    public function driver_data($id) {
        global $user;
        $user_data = $user->user_data($id);
        if ($id < -1) {
            foreach ($user_data as $row) {
                $row->value = $this->driver->{$row->user_data_descr};
            }
        }
        return $user_data;
    }

    private function extract_post() {
        if(!empty($_POST['key'])){
            $this->extract_post_key(); 
        }
        unset($_POST['key']);
        unset($_POST['value']);
        unset($_POST['post_id']);
        unset($_POST['user_data_id']);
        foreach ($_POST as $key => $var) {
            $this->driver->{$key} = $var;
        }
        unset($_POST);
        
    }
    private function extract_post_key(){
        foreach ($_POST['key'] as $index=>$key){
            $user_data['value']=$_POST['value'][$index];            
            $user_data['post_id']=$_POST['post_id'][$index];       
            $user_data['user_data_id']=$_POST['user_data_id'][$index]; 
            $this->driver->{$key}=  (object)$user_data;
            unset($user_data);                    
        }
    }

}
