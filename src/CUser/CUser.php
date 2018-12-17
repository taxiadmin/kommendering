<?php

/**
 * CUser är en class för att hålla ordning på om en användare är inloggad eller
 * inte, sköta in och utloggningar samt i förlägningen kunna ge all behövd
 * användarinformation
 *
 * @author peder
 */
class CUser {

    private $user = [];
    private $users = array();
    private $user_data = array();

    public function __construct() {
        // convert $users to objekt ...
//        $this->user = (object) $this->user;
        if (isset($_POST['login'])) {
            $this->login();
        }
        if (isset($_POST['logout'])) {
            unset($_SESSION['user']);
        }
        $this->get_users();
        $this->logincheck();
    }

//end __construct

    public function get_users() {
        // Fyller $users med alla användare
        global $db;
        $sql = 'SELECT * FROM User ORDER BY name;';
        $row = $db->query_DB($sql, array(), FALSE);
        if ($row) {
            do {
                $users[] = $row;
                $row = $db->fetch_DB();
            } while (!$row == false);
        }
        foreach ($users as $user){
            $temp_user[$user->id]['acronym']=$user->acronym;
            $temp_user[$user->id]['name']=$user->name;
            $temp_user[$user->id]['role']=$user->role;
            $temp_user[$user->id]['display_name']=$user->display_name;
        }
        $this->users=$temp_user;
    }

    private function get_user_data($id) {
        // Hämtar alla data för en användare
        global $db;
        $new_driver = (isset($_POST['new_driver'])) ? TRUE : FALSE;
        $sql = 'SELECT
                  user_data_descr,
                  value,
                  value_dec,
                  user_data_key.user_data_id,
                  user_data.id

                FROM
                  user_data_key
                LEFT JOIN
                 user_data
                ON
                 (user_data_key.user_data_id = user_data.user_data_id and user = ?)
                ORDER BY
                  user_data_sort
                ;'; // end $sql

                /* SELECT data_descr, value, value_dec, data_key.data_id, user_data.id
FROM data_key
LEFT JOIN user_data ON ( data_key.data_id = user_data.user_data_id
AND owner =1
AND user_data.user =1 )
ORDER BY data_sort*/

        $row = $db->query_DB($sql, array($id), FALSE);
        if ($row) {
            do {
                $user_data[] = $row;
                $row = $db->fetch_DB();
            } while (!$row == false);
        }

        return $user_data;
    }

    // Kollar i $_SESSION om någon är inloggad och hämtar uppgifterna därifrån
    public function logincheck() {
        if (isset($_SESSION['user'])) {
            global $db;
            $sql = "SELECT id, acronym, name, role FROM User WHERE id = ?;";
            $this->user = $db->query_DB($sql, array($_SESSION['user']), FALSE);
            $this->user->logged_in = isset($this->user->id) ? TRUE : FALSE;
        } else {
            $this->user['logged_in'] = false;
            $this->user = (object) $this->user;
        }
        return $this->user->logged_in;
    }

//end logincheck()
    //metod för inloggning
    public function login() {
        global $db;
        $sql = "SELECT id, role FROM User WHERE acronym = ? AND password = md5(concat(?, salt))";
        $this->user = $db->query_DB($sql, array($_POST['acronym'], $_POST['password']), FALSE);
        if (isset($this->user->id)) {
            $_SESSION['user'] = $this->user->id;
        }
    }
    private function get_user_by_id($id){
        global $db;
        $sql= "SELECT id, display_name, name, role FROM User WHERE id=?;";
        $return = $db->query_DB($sql,array($id),false);
        return $return;
    }

// end login()
//    metod för utloggning
    public function logged_in() {
        return $this->user->logged_in;
    }

    public function id() {
        return $this->user->id;
    }

    public function name() {
        return $this->user->name;
    }

    public function acronym() {
        return $this->user->acronym;
    }

    public function role() {
        return $this->user->role;
    }

    public function users() {
        return $this->users;
    }
    public function user_role(){
        return $this->user->role;
    }

    public function user_data($id = -1) {
        if ($id) {
            $return = $this->get_user_data($id);
        }
        return $return;
    }
    public function show_user($id){
        $return = $this->get_user_by_id($id);
        return $return;
    }

}
