<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERmodelModel {

    function getModelbyId($id) {
        if (is_numeric($id) == false)
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT * FROM `#__js_vehiclemanager_models` WHERE id = " . $id;
        $db->setQuery($query);
        jsvehiclemanager::$_data[0] = $db->loadObject();
        return;
    }

    function getModelTitlebyId($id) {
        if (is_numeric($id) == false)
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT title FROM `#__js_vehiclemanager_models` WHERE id = " . $id;
        $db->setQuery($query);
        return $db->loadResult();;
    }

    function getAllModels($makeid) {
        if(!is_numeric($makeid)) return false;
        // Filter
        $title = jsvehiclemanager::$_search['modelyear']['title'];
        $status = jsvehiclemanager::$_search['modelyear']['status'];

        $inquery = '';
        if ($title != null) {
            //$title = esc_sql($title);
            $inquery .= " AND title LIKE '%" . $title . "%'";
        }
        if (is_numeric($status))
            $inquery .= " AND status = " . $status;

        jsvehiclemanager::$_data['filter']['title'] = $title;
        jsvehiclemanager::$_data['filter']['status'] = $status;
        $db = new jsvehiclemanagerdb();
        //pagination
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_models` WHERE makeid = ".$makeid;
        $query .= $inquery;
        $db->setQuery($query);
        $total = $db->loadResult();
        jsvehiclemanager::$_data['total'] = $total;
        jsvehiclemanager::$_data[1] = JSVEHICLEMANAGERpagination::getPagination($total);

        //data
        $query = "SELECT * FROM `#__js_vehiclemanager_models` WHERE makeid = ".$makeid;
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
            $result = $this->isAlreadyExist($data['title'],$data['makeid']);
            if ($result == true) {
                return JSVEHICLEMANAGER_ALREADY_EXIST;
            } else {
                if(is_numeric($data['makeid'])){
                    $query = "SELECT max(ordering) AS maxordering FROM `#__js_vehiclemanager_models` where makeid = ".$data['makeid'];
                    $db->setQuery($query);
                    $ordering = $db->loadResult();
                    $ordering = ($ordering != '') ? $ordering : 0;
                    $data['ordering'] = $ordering + 1;
                }
            }

            if ($data['status'] == 0) {
                $data['isdefault'] = 0;
            } else {
                if ( isset($data['isdefault']) && $data['isdefault'] == 1) {
                    $canupdate = true;
                }
            }
        } else {
            if ($data['jsvehiclemanager_isdefault'] == 1) {
                $data['isdefault'] = 1;
                $data['status'] = 1;
            } else {
                if ($data['status'] == 0) {
                    $data['isdefault'] = 0;
                } else {
                    if ( isset($data['isdefault']) && $data['isdefault'] == 1) {
                        $canupdate = true;
                    }
                }
            }
        }
        return $canupdate;
    }

    function storeModel($data) {
        if (empty($data))
            return false;

        $canupdate = $this->validateFormData($data);
        if ($canupdate === JSVEHICLEMANAGER_ALREADY_EXIST)
            return JSVEHICLEMANAGER_ALREADY_EXIST;

        $row = JSVEHICLEMANAGERincluder::getJSTable('model');
        $data = JSVEHICLEMANAGERincluder::getJSmodel('common')->stripslashesFull($data);// remove slashes with quotes.
        $data = JSVEHICLEMANAGERincluder::getJSModel('common')->getSanitizedFormData($data);
        $data['alias'] = JSVEHICLEMANAGERincluder::getJSModel('common')->removeSpecialCharacter($data['title']);
        if (!$row->bind($data)) {
            return JSVEHICLEMANAGER_SAVE_ERROR;
        }
        if (!$row->store()) {
            return JSVEHICLEMANAGER_SAVE_ERROR;
        }
        if ($canupdate) {
            $this->updateIsDefault($row->id);
        }

        return  JSVEHICLEMANAGER_SAVED;
    }

    function deleteModel($ids) {
        if (empty($ids))
            return false;
        $row = JSVEHICLEMANAGERincluder::getJSTable('model');
        $notdeleted = 0;
        foreach ($ids as $id) {
            if(is_numeric($id)){
                if ($this->modelCanDelete($id) == true) {
                    if (!$row->delete($id)) {
                        $notdeleted += 1;
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

        $row = JSVEHICLEMANAGERincluder::getJSTable('model');
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

    function modelCanDelete($id) {
        if (!is_numeric($id))
            return false;
        $db = new jsvehiclemanagerdb();
        $query = " SELECT
                    ( SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicles` WHERE modelid = " . $id . ")
                    AS total";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total > 0)
            return false;
        else
            return true;
    }

    function getModelForCombo() {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT id, title AS text FROM `#__js_vehiclemanager_models` WHERE status = 1 ORDER BY ordering ASC ";
        $db->setQuery($query);
        $model = $db->loadObjectList();
        return $model;
    }

    function isAlreadyExist($title,$makeid) {
		if(!is_numeric($makeid)){
		   return true;
		}
		$db = new jsvehiclemanagerdb();
		$query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_models` WHERE title = '" . $title . "' AND makeid = ".$makeid;
		$db->setQuery($query);
		$result = $db->loadResult();
		if ($result > 0)
		   return true;
		else
		   return false;
	}

    function getVehiclesModelsbyMakeId($makeid ) {        //get vehicle models by make id
        $db = new jsvehiclemanagerdb();
        if(is_array($makeid)){
            $makestring = '';
            $comma = '';
            foreach ($makeid as $value) {
                if(!is_numeric($value)) return false;
                $makestring .= $comma.$value;
                $comma = ',';
            }
            $wherequery = "AND makeid IN (" . $makestring . " )";
        }else{
            if (!is_numeric($makeid)) return false;
            $wherequery = " AND makeid = " . $makeid;
        }
        $query = "SELECT  id, title, title AS text FROM `#__js_vehiclemanager_models` WHERE status = 1 ".$wherequery."  ORDER BY title ASC ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        return $rows;
    }

    function getVehiclesModelsbyMake($title = false) {        //get vehicle models by make id
        check_ajax_referer( 'wp_js_vm_nonce_check', 'wpnoncecheck' );

        $db = new jsvehiclemanagerdb();
        $makeid = JSVEHICLEMANAGERrequest::getVar('makeid');
        $title = JSVEHICLEMANAGERrequest::getVar('title');
        if (!is_numeric($makeid))
            return false;
        $query = "SELECT  id, title AS text FROM `#__js_vehiclemanager_models` WHERE status = 1 AND makeid = " . $makeid . " ORDER BY title ASC ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        $return_value = "";//showing error undefined variable so added this line
        //$return_value = "<select name='modelid' class='inputbox'>\n";
        if($title)
            $return_value .= "<option value=\"\" >".__('Select Model', 'js-vehicle-manager')."</option> \n";
        foreach ($rows as $row) {
            $return_value .= "<option value=\"$row->id\" >$row->text</option> \n";
        }
        //$return_value .= "</select>\n";
        return $return_value;
    }

    function getVehiclesModelsbyMakeMulti() {        //get vehicle models by make id for multi select
        check_ajax_referer( 'wp_js_vm_nonce_check', 'wpnoncecheck' );
        $db = new jsvehiclemanagerdb();
        $make = JSVEHICLEMANAGERrequest::getVar('makeid');
        $arrayflag = JSVEHICLEMANAGERrequest::getVar('arrayflag');
        if($arrayflag != 1){
            if (!is_array($make)){
                return false;
            }else{
                $makestring = '';
                $comma = '';
                foreach ($make as $key => $value) {
                    $makestring .= $comma.$value;
                    $comma = ',';
                }
                $wherequery = "AND makeid IN (" . $makestring . " )";
                $name = "model[]";
            }
        }else{
            if (!is_numeric($make)){
                return false;
            }else{
                $wherequery = "AND makeid = " . $make . " ";
                $name = "modelid";
            }
        }

        $query = "SELECT  id, title AS text FROM `#__js_vehiclemanager_models`
        WHERE status = 1 ".$wherequery."
        ORDER BY title ASC ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        $return_value = "";//showing error undefined variable so added this line
        //$return_value = "<select name='".$name."' class='form-control jsvm_cm_select2 jsvm_cm_model_class' data-live-search='true' data-modelid='1' multiple >\n";
        foreach ($rows as $row) {
            $return_value .= "<option value=\"$row->id\" >$row->text</option> \n";
        }
        //$return_value .= "</select>\n";
        //return json_encode($return_value);
        return $return_value;
    }

    function getMessagekey(){
        $key = 'model';if(is_admin()){$key = 'admin_'.$key;}return $key;
    }
}

?>
