<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERsystemerrorModel {

    function getSystemErrors() {
        $db = new jsvehiclemanagerdb();
        $inquery = '';
        // Pagination
        $query = "SELECT COUNT(`id`) FROM `#__js_vehiclemanager_system_errors`";
        $query .= $inquery;
        $db->setquery($query);
        $total = $db->loadResult();
        jsvehiclemanager::$_data[1] = JSVEHICLEMANAGERpagination::getPagination($total);

        // Data
        $query = " SELECT systemerror.*
					FROM `#__js_vehiclemanager_system_errors` AS systemerror ";
        $query .= $inquery;
        $query .= " ORDER BY systemerror.created DESC LIMIT " . JSVEHICLEMANAGERpagination::$_offset . ", " . JSVEHICLEMANAGERpagination::$_limit;
        $db->setquery($query);
        jsvehiclemanager::$_data[0] = $db->loadObjectList();

        return;
    }

    function addSystemError($error) {
        $query_array = array('error' => $error,
            'uid' => get_current_user_id(),
            'isview' => 0,
            'created' => date("Y-m-d H:i:s")
        );
        $db = new jsvehiclemanagerdb();
        $db->_insert('system_errors',$query_array);
        return;
    }

    function getMessagekey(){
        $key = 'systemerror';if(is_admin()){$key = 'admin_'.$key;}return $key;
    }
}

?>
