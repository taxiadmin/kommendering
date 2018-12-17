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
    private $driver = null;

    public function __construct() {
        checkLogin();
        $this->driver = (object) $this->driver;
        $this->driver->use_driver = isset($_POST['use_driver']) ? $_POST['use_driver'] : null;
        unset($_POST['use_driver']);
        $this->driver->save = isset($_POST['save']) ? true : false;
        unset($_POST['save']);

        $this->driver->id = (isset($this->driver->use_driver)) ? $this->driver->use_driver : $_SESSION['user'];
        if (isset($this->driver->save) && $this->driver->save < 0) {
            $this->check_password();
        }
        $this->driver_data_init($this->driver->id);
        if (!empty($this->driver->save)) {
            $this->extract_post();
            $this->save_driver();
        }
        $this->driver();
    }

    private function driver() {
        if ($this->driver->id < 0) {
            //$this->new_driver();
        } else {
            global $user;
            $use_driver = $user->show_user($this->driver->id);
            $this->driver->name = $use_driver->name;
            $this->driver->display_name = $use_driver->display_name;
            $this->driver->role = $use_driver->role;
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
        $user_array[] = (int)$this->driver->driver_role;
        if ($this->driver->id < 0){   // om ny förare ska sparas
            $this->create_new_driver($user_array);
        } else {
            $this->update_driver($user_array);
        }
    }

    private function update_driver($user_array) {
        global $db;
        global $user;
        $sql = "UPDATE User SET name=?, display_name=?, role=? WHERE id=?;";
        $user_array[] = $this->driver->id;
        $succed = $db->DB_execute($sql, $user_array, false);
        if (isset($this->driver->password)){
            $this->update_password($this->driver->id);
        }
        if ($succed) {

            $this->update_driver_data();

            /*$sql = "UPDATE user_data SET value=? WHERE ID=?";
            foreach ($this->driver->data as $row) {
                dump($row);
                if (!empty($this->driver->{$row->user_data_descr})) {
                    unset($user_array);
                    $user_array[] = $this->driver->{$row->user_data_descr}->value;
                    $user_array[] = $this->driver->{$row->user_data_descr}->post_id;
                    $succed = $db->DB_execute($sql, $user_array, FALSE);
                }
            }*/
            $user->get_users();
        }
        return TRUE;
    }

    private function update_driver_data(){
        global $db;
        $user_array = array();
        foreach ($this->driver->data as $row0 => $value) {
            $sql = "INSERT INTO
                        user_data (user, user_data_id, value)
                    VALUES
                    ({$this->driver->id}, {$value->user_data_id}, '{$value->value}')
                    ON DUPLICATE KEY UPDATE
                    value='{$value->value}';";
                    $db->DB_execute($sql, $user_array, false);
        }

    }

    private function create_new_driver($user_array) {
        global $db;
        global $user;
        $sql = "INSERT INTO User ( name, display_name, role, acronym, password, salt) VALUES (?, ?, ?, ?, ?, unix_timestamp());";

        $user_array[] = $this->driver->acronym;
        $user_array[] = $this->driver->password;
        $succed = $db->DB_execute($sql, $user_array, false);
        if ($succed) {
            $id = $db->id_new_post();
            $this->driver->use_driver = $id;
            $this->driver->id = $id;
            $this->update_password($id);

            $sql = "INSERT INTO user_data (user, user_data_id, value) VALUES (?, ?, ?)";

            $this->update_driver_data();

            $user->get_users();
        }
        //Uppdaterar $_POST så användaren skickas med till nästa sida. Annars kommer inloggad användare visas.
        // uppdaterar $this->driver->id så sedan rendeare
        return TRUE;
    }

    private function update_password($id) {
        global $db;
        $sql = "UPDATE User SET password = md5(concat(?, salt)) WHERE id = ?";
        $passw_array[] = $this->driver->password;
        $passw_array[] = $id;

        $succed = $db->DB_execute($sql, $passw_array, false);
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

    public function role() {
        return $this->driver->role;
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

    public function newpassword() {
        return (isset($this->driver->newpassword)) ? true :false;
    }

    public function driver_role($role){
        global $db;
        $array = array();
        $sql = "SELECT data_key, data_descr FROM data_key WHERE owner =3";
        $row = $db->query_DB($sql, array(), FALSE);
        if ($row) {
            do {
                $row_data['data_descr'] = $row->data_descr;
                $row_data['id'] = $row->data_key;
                $row_data['selected'] = ($row->data_key == $role) ? "selected" : "";
                $driver_role[] = (object) $row_data;
                $row = $db->fetch_DB();
            } while (!$row == false);
            $driver_role = (object)$driver_role;
            return $driver_role;
        }
    }

    private function driver_data_init($id) {
        global $user;
        $data = array();
        $user_data = $user->user_data($id);
        foreach ($user_data as $row) {
            $row_data['user_data_descr'] = $row->user_data_descr;
            $row_data['value']= $row->value;
            $row_data['value_dec']= $row->value_dec;
            $row_data['id']= $row->id;
            $row_data['user_data_id']= $row->user_data_id;
            $data[]=  (object)$row_data;
            unset($row_data);
        }
        $this->driver->data = (object)$data;

        $this->driver->newpassword = isset($_POST['newpassword']) ? true : null;
        unset($_POST['newpassword']);
        $this->driver->password = isset($_POST['password']) ? $_POST['password'] : null;
        unset($_POST['password']);
        $this->driver->name = null;
        $this->driver->acronym = null;
        $this->driver->display_name = null;

    }

    public function driver_data(){
        return $this->driver->data;
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
        $data = array();
        foreach ($_POST['key'] as $index=>$key){
            $user_data['user_data_descr'] = $_POST['key'][$index];
            $user_data['value']=$_POST['value'][$index];
            $user_data['id']=$_POST['post_id'][$index];
            $user_data['user_data_id']=$_POST['user_data_id'][$index];
            $data[]=  (object)$user_data;
            unset($user_data);
        }
        $this->driver->data = (object)$data;
    }

}
