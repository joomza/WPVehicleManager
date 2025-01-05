<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERmakeModel {

    function getMakebyId($id) {
        if (is_numeric($id) == false)
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT * FROM `#__js_vehiclemanager_makes` WHERE id = " . $id;
        $db->setQuery($query);
        jsvehiclemanager::$_data[0] = $db->loadObject();
        return;
    }

    function getMakeTitlebyId($id) {
        if (is_numeric($id) == false)
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT title FROM `#__js_vehiclemanager_makes` WHERE id = " . $id;
        $db->setQuery($query);

        return $db->loadResult();;
    }

    function getAllMakes() {
        // Filter
        $title = jsvehiclemanager::$_search['make']['title'];
        $status = jsvehiclemanager::$_search['make']['status'];

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
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_makes` ";
        $query .= $inquery;
        $db->setQuery($query);
        $total = $db->loadResult();
        jsvehiclemanager::$_data['total'] = $total;
        jsvehiclemanager::$_data[1] = JSVEHICLEMANAGERpagination::getPagination($total);

        //data
        $query = "SELECT * FROM `#__js_vehiclemanager_makes` ";
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
                $query = "SELECT max(ordering) AS maxordering FROM `#__js_vehiclemanager_makes`";
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
        } else {
           
             if (isset($data['jsvehiclemanager_isdefault']) && $data['jsvehiclemanager_isdefault'] == 1)
            {
                $data['isdefault'] = 1;
                $data['status'] = 1;
            } else {
                if ($data['status'] == 0) {
                    $data['isdefault'] = 0;
                } else {
                    if (isset($data['isdefault']) && $data['isdefault'] == 1) {
                        $canupdate = true;
                    }
                }
            }
        }
        return $canupdate;
    }

    function storeMake($data) {
        if (empty($data))
            return false;

        $canupdate = $this->validateFormData($data);
        if ($canupdate === JSVEHICLEMANAGER_ALREADY_EXIST)
            return JSVEHICLEMANAGER_ALREADY_EXIST;

        $row = JSVEHICLEMANAGERincluder::getJSTable('make');
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
        $image_url = JSVEHICLEMANAGERincluder::getObjectClass('uploads')->vehicleManagerUpload($id, $file , 2);
        $data = array();
        if($image_url){
            $data['logo'] = $image_url;
            $data['id'] = $id;
            $row->bind($data);
            $row->store();
        }
        return JSVEHICLEMANAGER_SAVED;
    }

    function deleteMake($ids) {
        if (empty($ids))
            return false;
        $row = JSVEHICLEMANAGERincluder::getJSTable('make');

        $wpdir = wp_upload_dir();
        $data_directory = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
        $path = $wpdir['basedir'] . '/' . $data_directory . '/data';

        $notdeleted = 0;
        foreach ($ids as $id) {
            if(is_numeric($id)){
                if ($this->makeCanDelete($id) == true) {
                    if (!$row->delete($id)) {
                        $notdeleted += 1;
                    }else{
                        $filepath = $path . '/make/make_' . $id;
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

        $row = JSVEHICLEMANAGERincluder::getJSTable('make');
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
                    if (!$row->update(array('id' => $id, 'status' => $status))) {
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

    function makeCanDelete($id) {
        if (!is_numeric($id))
            return false;
        $db = new jsvehiclemanagerdb();
        $query = " SELECT
                    ( SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicles` WHERE makeid = " . $id . ")
                    + ( SELECT COUNT(id) FROM `#__js_vehiclemanager_models` WHERE makeid = " . $id . ")
                    AS total";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total > 0)
            return false;
        else
            return true;
    }

    function getMakeForCombo() {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT id, title AS text FROM `#__js_vehiclemanager_makes` WHERE status = 1 ORDER BY ordering ASC ";
        $db->setQuery($query);
        $list = $db->loadObjectList();
        return $list;
    }

    function isAlreadyExist($title) {
        if(!$title)
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_makes` WHERE title = '" . $title . "'";
        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result > 0)
            return true;
        else
            return false;
    }

    function getVehiclebyMakesModels() {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT   make.id AS makeid, make.title AS maketitle, CONCAT(model.alias,'-',model.id) AS aliasid ,make.logo AS logo, model.id AS modelid,model.title AS modeltitle ,
        (SELECT COUNT(vehicle.makeid) FROM `#__js_vehiclemanager_vehicles`  AS vehicle WHERE vehicle.makeid = make.id AND DATE(vehicle.adexpiryvalue)  >= CURDATE() AND vehicle.status = 1  ) AS totalvehiclemake ,
        (SELECT COUNT(vehicle.modelid) FROM `#__js_vehiclemanager_vehicles` AS vehicle WHERE vehicle.modelid = model.id  AND vehicle.status = 1 AND DATE(vehicle.adexpiryvalue)  >= CURDATE() ) AS totalvehiclemodel";

        $squery = '';
        $show_sold_vehicle = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('show_sold_vehicles');
        if ($show_sold_vehicle == 0)
            $squery .=  do_action('jsvm_sold_vehiclenotsold_data','vehicle');
        $query .= " FROM `#__js_vehiclemanager_makes` AS make
        LEFT JOIN `#__js_vehiclemanager_models`  AS model ON make.id = model.makeid
        LEFT JOIN `#__js_vehiclemanager_vehicles` AS vehicle ON (make.id = vehicle.makeid AND model.id = vehicle.modelid " . $squery . ")
        WHERE make.status = 1 AND model.status = 1
        GROUP BY model.id ORDER BY make.id,model.title ASC ";//sorting by name so added model.title

        $db->setQuery($query);
        jsvehiclemanager::$_data[0] = $db->loadObjectList();
        return;
    }

    function getVehiclebyMakesModelsNotTotal($vehicletype) {
        if ($vehicletype)
            if (!is_numeric($vehicletype))
                return false;
        $db = new jsvehiclemanagerdb();
        $squery = '';
        $show_sold_vehicle = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('show_sold_vehicles');
        if ($show_sold_vehicle == 0)
            $squery = do_action('jsvm_sold_vehiclenotsold_data','vehicle');
        $query = "SELECT   make.id AS makeid,make.logo AS logo, make.title AS maketitle , model.id AS modelid,model.title AS modeltitle
                    FROM `#__js_vehiclemanager_makes` AS make
                    LEFT JOIN `#__js_vehiclemanager_models`  AS model ON make.id = model.makeid
                    LEFT JOIN `#__js_vehiclemanager_vehicles`  AS vehicle ON (make.id = vehicle.makeid AND model.id = vehicle.modelid " . $squery . " ";
        if ($vehicletype == 1) {
            $query.=" AND vehicle.status <> 0 AND DATE(vehicle.adexpiryvalue)  >= CURDATE() AND vehicle.conditionid=" . $vehicletype . " ) GROUP BY model.id ";
        } elseif ($vehicletype == 2) {
            $query.=" AND vehicle.status <> 0 AND DATE(vehicle.adexpiryvalue)  >= CURDATE() AND vehicle.conditionid=" . $vehicletype . " ) GROUP BY model.id ";
        } else {
            $query.=" AND vehicle.status <> 0 AND DATE(vehicle.adexpiryvalue)  >= CURDATE() ) GROUP BY model.id ";
        }
        $db->setQuery($query);
        jsvehiclemanager::$_data[0] = $db->loadObjectList();
    }

    function getVehiclebyMakes($vehicletype) {
        if ($vehicletype){
            if (!is_numeric($vehicletype))
                return false;
            $vehicletype = "AND vehicle.conditionid = ".$vehicletype;
        }else{
            $vehicletype = '';
        }
        $db = new jsvehiclemanagerdb();
        $squery = '';

        $show_sold_vehicle = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('show_sold_vehicles');
        if ($show_sold_vehicle == 0)
            $squery = do_action('jsvm_sold_vehiclenotsold_data','vehicle');
        $query = "SELECT make.id AS makeid,make.logo AS logo, make.title AS maketitle ,count(vehicle.id) AS totalvehiclemake
                    FROM `#__js_vehiclemanager_makes` AS make
                    LEFT JOIN `#__js_vehiclemanager_vehicles` AS vehicle ON ( vehicle.makeid = make.id AND date(vehicle.adexpiryvalue) > curdate() $vehicletype AND vehicle.makeid = make.id AND vehicle.status = 1 " . $squery . " )
                    GROUP BY make.id ";
        $db->setQuery($query);
        jsvehiclemanager::$_data[0] = $db->loadObjectList();
    }

    function getNumberOfMakes() {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT  COUNT(id) FROM `#__js_vehiclemanager_makes` WHERE status = 1 ORDER BY title ASC ";
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }

    function getMakeImage($img) {            //getVehiclesMakes
        if($img != ''){
            if(strstr($img, 'http')){
                $path = $img;
                if(filter_var($img, FILTER_VALIDATE_URL) === FALSE){
                    return CAR_MANAGER_IMAGE.'/default-images/make-image.png';
                } else {
                    return $img;
                }
            }else{
                return JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/default-makes/'.$img;
            }
        }else{
            return CAR_MANAGER_IMAGE.'/default-images/make-image.png';
        }
    }

    function getMessagekey(){
        $key = 'make';if(is_admin()){$key = 'admin_'.$key;}return $key;
    }
}

?>
