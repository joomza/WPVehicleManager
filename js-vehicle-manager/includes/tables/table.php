<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERtable {

    public $isnew = false;
    public $columns = array();
    public $primarykey = '';
    public $tablename = '';
    public $db = '';

    function __construct($tbl, $pk) {
        $this->db = new jsvehiclemanagerdb();
        $this->tablename = $this->db->prefix . 'js_vehiclemanager_' . $tbl;
        $this->primarykey = $pk;
    }

    public function bind($data) {
        if ((!is_array($data)) || (empty($data)))
            return false;
        if (isset($data['id']) && !empty($data['id'])) { // Edit case
            $this->isnew = false;
        } else { // New case
            $this->isnew = true;
        }
        $result = $this->setColumns($data);
        return $result;
    }

    protected function setColumns($data) {
        if ($this->isnew == true) { // new record insert
            $array = get_object_vars($this);
            unset($array['isnew']);
            unset($array['primarykey']);
            unset($array['tablename']);
            unset($array['columns']);
            unset($array['db']);
            foreach ($array AS $k => $v) {
                if (isset($data[$k])) {
                    $this->$k = $data[$k];
                }
                $this->columns[$k] = $this->$k;
            }
        } else { // update record
            if (isset($data[$this->primarykey])) {
                foreach ($data AS $k => $v) {
                    if (isset($this->$k)) {
                        $this->$k = $v;
                        $this->columns[$k] = $v;
                    }
                }
            } else {
                return false; // record cannot be updated b/c of pk not exist
            }
        }
        return true;
    }

    function store() {
        if ($this->isnew == true) { // new record store
            $result = $this->db->insert($this->tablename, $this->columns);
            if($result == false) return false;
            $this->{$this->primarykey} = $this->db->insert_id;
        } else { // record updated
            $result = $this->db->update($this->tablename, $this->columns, array($this->primarykey => $this->columns[$this->primarykey]));
            if($result == false) return false;
        }
        return true;
    }

    function update($data) {
        $result = $this->bind($data);
        if ($result == false) return false;
        $result = $this->store();
        if ($result == false) return false;
        return true;
    }

    function delete($id) {
        if (!is_numeric($id))
            return false;
        $result = $this->db->delete($this->tablename, array($this->primarykey => $id));
        if($result == false) return false;
        return true;
    }

    function check() {
        return true;
    }

    function load($id){
        if(!is_numeric($id)) return false;
        $query = "SELECT * FROM `".$this->tablename."` WHERE ".$this->primarykey." = ".$id;
        $this->db->setQuery($query);
        $result = $this->db->loadObject();
        $array = get_object_vars($this);
        unset($array['isnew']);
        unset($array['primarykey']);
        unset($array['tablename']);
        unset($array['columns']);
        unset($array['db']); // it comes on load , store not working properly, only ->update working after load.
        foreach ($array AS $k => $v) {
            if (isset($result->$k)) {
                $this->$k = $result->$k;
            }
            $this->columns[$k] = $this->$k;
        }
        return true;
    }

}

?>