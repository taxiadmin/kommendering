<?php

/**
 * CUser är en class för att hålla ordning på om en användare är inloggad eller
 * inte, sköta in och utloggningar samt i förlägningen kunna ge all behövd
 * användarinformation
 *
 * @author peder
 */
class CCab {

    private $cab = null;

    public function __construct() {
        checkLogin();
        $this->cab = (object) $this->cab;
        $this->cab->current_cab = isset($_POST['current_cab']) ? $_POST['current_cab'] : null;
        $succed = true;
        if (isset($_POST['save']) && $_POST['save']) {
            $this->extract_post();
            $succed = $this->save();
        }
        if ($succed) {
            $this->get_cabs();

            $this->get_cab($this->cab->current_cab);
            $this->get_cab_data($this->cab->current_cab);
        }
    }



    private function save()
    {
        global $db;
        $sql = "";
        $user_array = array();
        if ($this->cab->current_cab == -1) {
            $sql = "INSERT INTO cab( cab, pass, pass_time) VALUES ('{$this->cab->cab}', 2, '{$this->cab->data_current->pass_time}')";
        } else {
            $sql = "UPDATE cab SET pass=2, pass_time='{$this->cab->data_current->pass_time}' WHERE id={$this->cab->current_cab}";
        }

        $succed = $db->DB_execute($sql, $user_array, false);
        $this->cab->current_cab =  ($this->cab->current_cab == -1) ? $db->id_new_post() :$this->cab->current_cab;

        $_SESSION['cab']['duplett'] = ($succed)? "":"Duplett";
        if ($succed)
        {
            foreach ($this->cab->cab_data as $key => $value)
            {
                $sql = "INSERT INTO
                            data_value(parent, key_id, value)
                        VALUES
                            ({$this->cab->current_cab},{$value->id},'{$value->value}')
                        ON DUPLICATE KEY UPDATE
                        value='{$value->value}';";
                $db->DB_execute($sql, $user_array, false);
            }
        }
        return $succed;

    }

    private function get_cab($current_cab) {
        // Fyller $cab->data_current med bilens data
        global $db;
        $sql = "SELECT * FROM cab WHERE id='{$current_cab}';";
        $row = $db->query_DB($sql, array(), false);
        if ($row) {
            $this->cab->data_current = (object)$row;
        }
    }

    private function get_cabs() {
        // Fyller $cabs med alla bilar
        global $db;
        $sql = 'SELECT id, cab, pass_time FROM cab ORDER BY cab;';
        $row = $db->query_DB($sql, array(), FALSE);
        if ($row) {
            if (isset($_POST['save']) && $this->cab->current_cab == -1 )
            {
                $this->cab->current_cab =  $db->id_new_post();
            }
            elseif (is_null($this->cab->current_cab)) {
                 $this->cab->current_cab = $row->id;
             }
            do {
                $cabs[] = $row;
                $row = $db->fetch_DB();
            } while (!$row == false);
        }
        $this->cab->cabs = (object) $cabs;

    }

    private function get_cab_data($id) {
        // Hämtar alla data för en bil
        global $db;
        $new_cab = (isset($_POST['new_cab'])) ? TRUE : FALSE;
        $sql = 'SELECT
                  parent as car_id,
                  data_id,
                  data_descr,
                  value,
                  value_dec,
                  key_id
                FROM
                  (select * from data_key where owner=2) as a
                LEFT JOIN
                 data_value
                ON
                 (data_id = key_id and parent=?)
                ORDER BY
                  data_sort
                ;'; // end $sql

        $row = $db->query_DB($sql, array($id), FALSE);
        if ($row) {
            do {
                $row_data['car_id'] = $row->car_id;
                $row_data['data_descr'] = $row->data_descr;
                $row_data['id'] = $row->data_id;
                $row_data['value'] = $row->value;
                $row_data['value_dec'] = $row->value_dec;
                $row_data['key_id'] = $row->key_id;
                $cab_data[$row->data_descr] = (object) $row_data;
                $row = $db->fetch_DB();
            } while (!$row == false);
        }
        $this->cab->cab_data = (object) $cab_data;
    }

    private function extract_post() {
        if (isset($_POST)) {
            if (!empty($_POST['key'])) {
                $this->extract_post_key();
            }
            unset($_POST['key']);
            unset($_POST['value']);
            unset($_POST['post_id']);
            unset($_POST['user_data_id']);
            $this->cab->data_current = null;
            $this->cab->data_current = (object)$this->cab->data_current;
            $this->save_pass();
            foreach ($_POST as $key => $var) {
                $this->cab->{$key} = $var;
                if ($key != 'current_cab'){
                    unset($_POST[$key]);
                                    }
            }
        }
    }

    private function save_pass(){
        $pass = [];
        $day = [];
        for ($i = 0 ; $i < 7 ; $i++){
            $day['pass0_start'] = $_POST["pass0_start"][$i];
            $day['pass0_stop'] = $_POST["pass0_stop"][$i];
            $day['pass1_start'] = $_POST["pass1_start"][$i];
            $day['pass1_stop'] = $_POST["pass1_stop"][$i];

            $pass[] = $day;
        }
        unset($_POST["pass0_start"]);
        unset($_POST["pass0_stop"]);
        unset($_POST["pass1_start"]);
        unset($_POST["pass1_stop"]);
        $this->cab->data_current->pass_time = serialize($pass);
    }

    private function extract_post_key() {
        foreach ($_POST['key'] as $index => $key) {
            $user_data['data_descr'] = $_POST['key'][$index];
            $user_data['value'] = $_POST['value'][$index];
            $user_data['id'] = $_POST['post_id'][$index];
            $user_data['car_id'] = $_POST['user_data_id'][$index];
            $user_data['key_id'] = $_POST['key_id'][$index];
            $cabdata[] = (object) $user_data;
            unset($user_data);
        }
        $this->cab->cab_data = (object)$cabdata;
    }

    public function cabs() {
        $return = $this->cab->cabs;
        return $return;
    }

    public function id() {
        return $this->cab->current_cab;
    }

    public function cab_data() {
        return $this->cab->cab_data;
    }

    public function pass_time() {
        global $db;
        if (isset($this->cab->data_current->pass_time))
        {
            $pass_time = $this->cab->data_current->pass_time;
        }
        else
        {
            $sql = "SELECT * FROM data_key WHERE owner = 0 and data_key=100";

            // hämtar datan från databasen och lagrrar den i $data_keys
            $row = $db->query_DB($sql, array(), false);
            $pass_time = $row->text;
        }

        return unserialize($pass_time);
    }

    public function get_car()
    {
        $car = (isset($this->cab->data_current->cab)) ? $this->cab->data_current->cab:"";
        return $car;
    }

}
