<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERvehicletypeModel {

    function getVehicletypebyId($id) {
        if (is_numeric($id) == false)
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT * FROM `#__js_vehiclemanager_vehicletypes` WHERE id = " . $id;
        $db->setQuery($query);
        jsvehiclemanager::$_data[0] = $db->loadObject();
        return;
    }

    function getVehicleTypeTitlebyId($id) {
        if (is_numeric($id) == false)
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT title FROM `#__js_vehiclemanager_vehicletypes` WHERE id = " . $id;
        $db->setQuery($query);
        return $db->loadResult();
    }

    function getAllVehicletypes() {
        // Filter
        $title = jsvehiclemanager::$_search['type']['title'];
        $status = jsvehiclemanager::$_search['type']['status'];

        $inquery = '';
        $clause = ' WHERE ';
        if ($title != null) {
            //$title = esc_sql($title);
            $inquery .= $clause . "title LIKE '%" . $title . "%'";
            $clause = ' AND ';
        }
        if (is_numeric($status))
            $inquery .= $clause . " status = " . $status;

        jsvehiclemanager::$_data['filter']['title'] = $title;
        jsvehiclemanager::$_data['filter']['status'] = $status;
        $db = new jsvehiclemanagerdb();
        //pagination
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicletypes` ";
        $query .= $inquery;
        $db->setQuery($query);
        $total = $db->loadResult();
        jsvehiclemanager::$_data['total'] = $total;
        jsvehiclemanager::$_data[1] = JSVEHICLEMANAGERpagination::getPagination($total);

        //data
        $query = "SELECT * FROM `#__js_vehiclemanager_vehicletypes` ";
        $query .= $inquery;
        $query .= " ORDER BY ordering ASC LIMIT " . JSVEHICLEMANAGERpagination::$_offset . ", " . JSVEHICLEMANAGERpagination::$_limit;
        $db->setQuery($query);
        jsvehiclemanager::$_data[0] = $db->loadObjectList();
        return;
    }

    function validateFormData(&$data) {
        $canupdate = false;
        $db = new jsvehiclemanagerdb();
        if ($data['id'] == '') {
            $result = $this->isAlreadyExist($data['title']);
            if ($result == true) {
                return JSVEHICLEMANAGER_ALREADY_EXIST;
            } else {
                $query = "SELECT max(ordering) AS maxordering FROM `#__js_vehiclemanager_vehicletypes`";
                $db->setQuery($query);
                $ordering = $db->loadResult();
                $data['ordering'] = $ordering + 1;
            }

            if ($data['status'] == 0) {
                $data['isdefault'] = 0;
            } else {
                if (isset($data['isdefault']) && $data['isdefault'] == 1) {
                    $canupdate = true;
                }
            }
        } 
        else {
            if ($data['jsvehiclemanager_isdefault'] == 1) {
                $data['isdefault'] = 1;
                $data['status'] = 1;
            } else {
                if ($data['status'] == 0) {
                    $data['isdefault'] = 0;
                } else {
                    if ($data['isdefault'] == 1) {
                        $canupdate = true;
                    }
                }
            }
        }
        return $canupdate;
    }

    function updateIsDefault($id) {
        if (is_numeric($id)) {
            $db = new jsvehiclemanagerdb();
            $query = "UPDATE `#__js_vehiclemanager_vehicletypes` SET isdefault = 0 WHERE id != " . $id;
            $db->setQuery($query);
            $db->query();
        }
    }

    function storeVehicletype($data) {
        if (empty($data))
            return false;

        $canupdate = $this->validateFormData($data);
        if ($canupdate === JSVEHICLEMANAGER_ALREADY_EXIST)
            return JSVEHICLEMANAGER_ALREADY_EXIST;

        $row = JSVEHICLEMANAGERincluder::getJSTable('vehicletype');
        $data = JSVEHICLEMANAGERincluder::getJSmodel('common')->stripslashesFull($data);// remove slashes with quotes.
        $data = JSVEHICLEMANAGERincluder::getJSModel('common')->getSanitizedFormData($data);
        $data['alias'] = JSVEHICLEMANAGERincluder::getJSModel('common')->removeSpecialCharacter($data['title']);
        if($data['removelogo'] == 1){
            $data['logo'] = '';
        }
        if (!$row->bind($data)) {
            return JSVEHICLEMANAGER_SAVE_ERROR;
        }
        if (!$row->store()) {
            return JSVEHICLEMANAGER_SAVE_ERROR;
        }
        if ($canupdate) {
            $this->updateIsDefault($row->id);
        }
        $file = $_FILES['logo'];
        $id = $row->id;
        $image_url = JSVEHICLEMANAGERincluder::getObjectClass('uploads')->vehicleManagerUpload($id, $file , 1);
        $data = array();
        if($image_url){
            $data['logo'] = $image_url;
            $data['id'] = $id;
            $row->bind($data);
            $row->store();
        }

        return JSVEHICLEMANAGER_SAVED;
    }

    function deleteVehicletype($ids) {
        if (empty($ids))
            return false;
        $row = JSVEHICLEMANAGERincluder::getJSTable('vehicletype');

        $wpdir = wp_upload_dir();
        $data_directory = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
        $path = $wpdir['basedir'] . '/' . $data_directory . '/data';
        $notdeleted = 0;
        foreach ($ids as $id) {
            if(is_numeric($id)){
                if ($this->vehicletypeCanDelete($id) == true) {
                    if (!$row->delete($id)) {
                        $notdeleted += 1;
                    }else{
                        $filepath = $path . '/vehicletype/vehicletype_' . $id;
                        $files = glob( $filepath . '/*');
                        foreach($files as $file){
                            if(is_file($file)) unlink($file);
                        }
                        if(is_dir($filepath)) rmdir($filepath);
                    }
                } else {
                    $notdeleted += 1;
                }
            }else{
                $notdeleted += 1;
            }
        }
        if ($notdeleted == 0) {
            JSVEHICLEMANAGERmessages::$counter = false;
            return JSVEHICLEMANAGER_DELETED;
        } else {
            JSVEHICLEMANAGERmessages::$counter = $notdeleted;
            return JSVEHICLEMANAGER_DELETE_ERROR;
        }
    }

    function publishUnpublish($ids, $status) {
        if (empty($ids))
            return false;
        if (!is_numeric($status))
            return false;

        $row = JSVEHICLEMANAGERincluder::getJSTable('vehicletype');
        $total = 0;
        if ($status == 1) {
            foreach ($ids as $id) {
                if(is_numeric($id)){
                    if (!$row->update(array('id' => $id, 'status' => $status))) {
                        $total += 1;
                    }
                }else{
                    $total += 1;
                }
            }
        } else {
            foreach ($ids as $id) {
                if(is_numeric($id)){
                    if ($this->vehicletypeCanUnpublish($id)) {
                        if (!$row->update(array('id' => $id, 'status' => $status))) {
                            $total += 1;
                        }
                    } else {
                        $total += 1;
                    }
                }else{
                    $total += 1;
                }
            }
        }
        if ($total == 0) {
            JSVEHICLEMANAGERmessages::$counter = false;
            if ($status == 1)
                return JSVEHICLEMANAGER_PUBLISHED;
            else
                return JSVEHICLEMANAGER_UN_PUBLISHED;
        }else {
            JSVEHICLEMANAGERmessages::$counter = $total;
            if ($status == 1)
                return JSVEHICLEMANAGER_PUBLISH_ERROR;
            else
                return JSVEHICLEMANAGER_UN_PUBLISH_ERROR;
        }
    }

    function vehicletypeCanUnpublish($id) {
        if (!is_numeric($id))
            return false;
        $db = new jsvehiclemanagerdb();
        $query = " SELECT
                    ( SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicletypes` WHERE id = " . $id . " AND isdefault = 1)
                    AS total";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total > 0)
            return false;
        else
            return true;
    }

    function vehicletypeCanDelete($id) {
        if (!is_numeric($id))
            return false;
        $db = new jsvehiclemanagerdb();
        $query = " SELECT
                    ( SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicles` WHERE vehicletypeid = " . $id . ")
                    + ( SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicletypes` WHERE id = " . $id . " AND isdefault = 1)
                    AS total";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total > 0)
            return false;
        else
            return true;
    }

    function getVehicletypeForCombo() {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT id, title AS text FROM `#__js_vehiclemanager_vehicletypes` WHERE status = 1 ORDER BY isdefault DESC,ordering ASC ";
        $db->setQuery($query);
        $list = $db->loadObjectList();
        return $list;
    }

    function isAlreadyExist($title) {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicletypes` WHERE title = '" . $title . "'";
        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result > 0)
            return true;
        else
            return false;
    }

    function getVehiclesTypes(){
        $db = new jsvehiclemanagerdb();
        $query = "SELECT vehtype.title,vehtype.id, CONCAT(vehtype.alias,'-',vehtype.id) AS aliasid, vehtype.logo,
                    (SELECT COUNT(veh.id) FROM `#__js_vehiclemanager_vehicles` AS veh WHERE veh.vehicletypeid = vehtype.id AND veh.status = 1 AND DATE(veh.adexpiryvalue) >= CURDATE()) AS vehicles
                    FROM `#__js_vehiclemanager_vehicletypes` AS vehtype WHERE vehtype.status = 1 ";
        $db->setQuery($query);
        $data = $db->loadObjectList();

        foreach ($data AS $type) {
            $img = $type->logo;
            // default make img needs to be replaced ..
            $path = JSVEHICLEMANAGER_PLUGIN_URL.'/includes/images/type-image.png';
            if($img != ''){
                if(strstr($img, 'http:')){
                    $path = $img;
                    if(filter_var($path, FILTER_VALIDATE_URL) === FALSE){
                        $path = JSVEHICLEMANAGER_PLUGIN_URL.'/includes/images/type-image.png';
                    }
                }else{
                    $path = JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/default-vehicle-types/'.$img;
                }
            }
            $type->imagepath = $path;
        }
        jsvehiclemanager::$_data[0] = $data;
        return;
    }

    function getVehicleTypes($limitstart, $limit) {          //get all vehicle types
        $db = new jsvehiclemanagerdb();
        $result = array();
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicletypes` ";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;
        $query = "SELECT * FROM `#__js_vehiclemanager_vehicletypes` ORDER BY id ASC ";

        $db->setQuery($query, $limitstart, $limit);
        $result[0] = $db->loadObjectList();
        $result[1] = $total;
        return $result;
    }

    function getVehicleTypeImage($img) {
        if($img != ''){
            if(strstr($img, 'http:')){
                $path = $img;
				if(filter_var($path, FILTER_VALIDATE_URL) === FALSE){
                    return JSVEHICLEMANAGER_PLUGIN_URL.'/includes/images/type-image.png';
                } else {
                    return $path;
                }
            }else{
                $path = JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/default-vehicle-types/'.$img;
            }
        }
        // default make img needs to be replaced ..
        $path = JSVEHICLEMANAGER_PLUGIN_URL.'/includes/images/type-image.png';
        return $path;
    }

    function getMessagekey(){
        $key = 'vehicletype';if(is_admin()){$key = 'admin_'.$key;}return $key;
    }
}

?>
