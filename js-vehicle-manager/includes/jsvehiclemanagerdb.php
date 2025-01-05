<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class jsvehiclemanagerdb {
    
    private $_db;
    private $_query;
    public $insert_id;
    public $prefix;
    
    function __construct() {
        global $wpdb;
        $this->_db = $wpdb;
        $this->prefix = $this->_db->prefix;
    }
    
    function setQuery($query){
        $this->_query = $this->parseQuery($query);
    }
    
    function getQuery(){
        if(!$this->_query) return false;
        return $this->_query;
    }
    
    function loadResult() {
        if(!$this->_query) return false;
        $result = $this->_db->get_var($this->_query);
        if ($this->_db->last_error != null) {
            $this->addSystemError();
        }
        return $result;
    }

    function loadObject() {
        if(!$this->_query) return false;
        $result = $this->_db->get_row($this->_query);
        if ($this->_db->last_error != null) {
            $this->addSystemError();
        }
        return $result;
    }

    function loadObjectList() {
        if(!$this->_query) return false;
        $result = $this->_db->get_results($this->_query);
        if ($this->_db->last_error != null) {
            $this->addSystemError();
        }
        return $result;
    }

    function query() {
        if(!$this->_query) return false;
        $this->_db->query($this->_query);
        if ($this->_db->last_error != null) {
            $this->addSystemError();
            return false;
        }
        return true;
    }
    
    function _insert($tablename, $columns){ // function that doesn't call the addSystemError to skip the infinite loop
        $tablename = $this->_db->prefix.'js_vehiclemanager_'.$tablename;
        $this->_db->insert($tablename, $columns);
    }
    
    function insert($tablename, $columns){
        $this->_db->insert($tablename, $columns);
        if ($this->_db->last_error != null) {
            $this->addSystemError();
            return false;
        }
        $this->insert_id = $this->_db->insert_id;

        JSVEHICLEMANAGERincluder::getJSModel('activitylog')->storeActivity($tablename, $columns, $this->insert_id, 1); // 1 mean add new record

        return true;
    }
    
    function update($tablename, $columns, $array){
        $this->_db->update($tablename, $columns, $array);
        if ($this->_db->last_error != null) {
            $this->addSystemError();
            return false;
        }
        JSVEHICLEMANAGERincluder::getJSModel('activitylog')->storeActivity($tablename, $columns, $columns['id'], 2);
        return true;
    }

    function delete($tablename, $array){
        //data for delete        
        $data = JSVEHICLEMANAGERincluder::getJSModel('activitylog')->getDeleteActionDataToStore($tablename, $array['id']);
        $this->_db->delete($tablename, $array);        
        if ($this->_db->last_error != null) {
            $this->addSystemError();
            return false;
        }
        JSVEHICLEMANAGERincluder::getJSModel('activitylog')->storeActivityLogForActionDelete($data, $array['id']);
        return true;
    }

    private function parseQuery($query){
        $query = str_replace('#__', $this->_db->prefix, $query);
        return $query;
    }
    
    private function addSystemError(){
        $last_error = $this->_db->last_error;
        JSVEHICLEMANAGERincluder::getJSModel('systemerror')->addSystemError($last_error);
    }
    
}

?>