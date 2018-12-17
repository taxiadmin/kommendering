<?php
class CSystem {
    private $data_key = null; // sparar datatypernas nycklar för data_value
    private $data_values = null;

    public function get_system_data() {
        $selected = isset($_POST['data_key'])? $_POST['data_key']  : null;
        $whatKeyToFech = $this->fech_data_keys($selected);
        $this->FechValues($whatKeyToFech);
    }

    private function fech_data_keys($selected ) {
        global $db;
        //Jag gillar object ...
        $this->data_key = (object) $this->data_key;
        // SQL-satsen för att hämta nycklarna
        $sql = "SELECT * FROM data_key WHERE owner = 0 ORDER BY data_sort;";

        // hämtar datan från databasen och lagrrar den i $data_keys
        $row = $db->query_DB($sql, array(), false);
        //dump($row, "row");
        $counter = 0;
        $key = 0;

        if ($row) { //Om det fanns data

            do { // så kör vi
                $row_data['owner'] = (int)$row->owner;
                $row_data['key'] = (int)$row->data_key;
                $row_data['sort'] = (int)$row->data_sort;
                $row_data['description'] = $row->data_descr;
                // kollar om något värde är valt
                if(isset($selected)) {
                    $row_data['selected'] = ($row->data_id == $selected ) ? 'SELECTED' : '';
                    $key = ($row->data_id == $selected ) ? $row->data_key : $key;
                } elseif ($counter == 0) {
                    //annars sätter jag första värdet till valt
                    $row_data['selected'] = 'SELECTED';
                    $key = $row->data_key;
                } else {
                    $row_data['selected'] = '';
                }
                //skapar ett object av arrayen och sparar i en array
                $key_data[$row->data_id] = (object) $row_data;
                $counter ++;
                $row = $db->fetch_DB();
            } while (!$row == false); // så länge det finns data
            //sedan gillar jag object ....
            $this->data_keys = (object) $key_data;
        }
        return $key;
    }

    private function FechValues($key)
    {
        global $db;
        //Jag gillar object ...
        $this->data_values = (object) $this->data_values;
        // SQL-satsen för att hämta nycklarna
        $sql = "SELECT * FROM data_key WHERE owner = {$key} ORDER BY data_sort;";

        // hämtar datan från databasen och lagrrar den i $data_keys
        $row = $db->query_DB($sql, array(), false);
        //dump($row, "row");
        if ($row) { //Om det fanns data

            do { // så kör vi
                $row_data['owner'] = (int)$row->owner;
                $row_data['key'] = (int)$row->data_key;
                $row_data['sort'] = (int)$row->data_sort;
                $row_data['description'] = $row->data_descr;
                $row_data['user'] = $row->user;

                //skapar ett object av arrayen och sparar i en array
                $key_data[$row->data_id] = (object) $row_data;
                $row = $db->fetch_DB();
            } while (!$row == false); // så länge det finns data
            //sedan gillar jag object ....
            $this->data_values = (object) $key_data;
        }
    }

    private function fetch_obect_data($id) {
        // Hämtar alla data för en bil
        global $db;
        $sql = 'SELECT
                  parent as car_id,
                  data_value.id,
                  data_descr,
                  value,
                  value_dec
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
                $row_data['obj_id'] = $row->car_id;
                $row_data['data_descr'] = $row->data_descr;
                $row_data['id'] = $row->id;
                $row_data['value'] = $row->value;
                $row_data['value_dec'] = $row->value_dec;
                $cab_data[$row->data_descr] = (object) $row_data;
                $row = $db->fetch_DB();
            } while (!$row == false);
        }
        $this->cab->cab_data = (object) $cab_data;
    }

    public function get_key_data () {
        return $this->data_keys;

    }

    public function get_keys()
    {
        return $this->data_values;
    }

    public function get_object_data($id)
    {
        fetch_object_data(id);
        return $this->cab->cab_data;
    }
}
