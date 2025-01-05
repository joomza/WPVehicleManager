<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERadexpiryModel {

    function getAdexpirybyId($id) {
        if (is_numeric($id) == false)
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT * FROM `#__js_vehiclemanager_adexpiries` WHERE id = " . $id;
        $db->setQuery($query);
        jsvehiclemanager::$_data[0] = $db->loadObject();
        return;
    }

    function getAllAdexpiries() {
        // Filter
        $advalue = jsvehiclemanager::$_search['adexpiry']['advalue'];
        $type = jsvehiclemanager::$_search['adexpiry']['type'];
        $status = jsvehiclemanager::$_search['adexpiry']['status'];

        $inquery = '';
        $clause = ' WHERE ';
        if (is_numeric($advalue)) {
            $inquery .= $clause . " advalue = " . $advalue;
            $clause = ' AND ';
        }
        if (is_numeric($type)) {
            $inquery .= $clause . " type = " . $type;
            $clause = ' AND ';
        }
        if (is_numeric($status))
            $inquery .= $clause . " status = " . $status;

        jsvehiclemanager::$_data['filter']['advalue'] = $advalue;
        jsvehiclemanager::$_data['filter']['type'] = $type;
        jsvehiclemanager::$_data['filter']['status'] = $status;
        $db = new jsvehiclemanagerdb();
        //pagination
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_adexpiries` ";
        $query .= $inquery;
        $db->setQuery($query);
        $total = $db->loadResult();
        jsvehiclemanager::$_data['total'] = $total;
        jsvehiclemanager::$_data[1] = JSVEHICLEMANAGERpagination::getPagination($total);

        //data
        $query = "SELECT * FROM `#__js_vehiclemanager_adexpiries` ";
        $query .= $inquery;
        $query .= " ORDER BY ordering ASC LIMIT " . JSVEHICLEMANAGERpagination::$_offset . ", " . JSVEHICLEMANAGERpagination::$_limit;
        $db->setQuery($query);
        jsvehiclemanager::$_data[0] = $db->loadObjectList();
        return;
    }

    function updateIsDefault($id) {
        if (is_numeric($id)) {
            $db = new jsvehiclemanagerdb();
            $query = "UPDATE `#__js_vehiclemanager_adexpiries` SET isdefault = 0 WHERE id != " . $id;
            $db->setQuery($query);
            $db->query();
        }
    }

    function validateFormData(&$data) {
        $canupdate = false;
        $db = new jsvehiclemanagerdb();
        if ($data['id'] == '') {
            $result = $this->isAlreadyExist($data['type'], $data['advalue']);
            if ($result == true) {
                return JSVEHICLEMANAGER_ALREADY_EXIST;
            } else {
                $query = "SELECT max(ordering) AS maxordering FROM `#__js_vehiclemanager_adexpiries`";
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
            if ($data['jsvehiclemanager_isdefault'] == 1) {
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

    function storeAdexpiry($data) {
        if (empty($data))
            return false;

        $canupdate = $this->validateFormData($data);
        if ($canupdate === JSVEHICLEMANAGER_ALREADY_EXIST)
            return JSVEHICLEMANAGER_ALREADY_EXIST;

        $row = JSVEHICLEMANAGERincluder::getJSTable('adexpiry');
        $data = JSVEHICLEMANAGERincluder::getJSmodel('common')->stripslashesFull($data);// remove slashes with quotes.
        $data = JSVEHICLEMANAGERincluder::getJSModel('common')->getSanitizedFormData($data);
        if (!$row->bind($data)) {
            return JSVEHICLEMANAGER_SAVE_ERROR;
        }
        if (!$row->store()) {
            return JSVEHICLEMANAGER_SAVE_ERROR;
        }
        if ($canupdate) {
            $this->updateIsDefault($row->id);
        }

        return JSVEHICLEMANAGER_SAVED;
    }

    function deleteAdexpiry($ids) {
        if (empty($ids))
            return false;
        $row = JSVEHICLEMANAGERincluder::getJSTable('adexpiry');
        $notdeleted = 0;
        foreach ($ids as $id) {
            if ($this->adexpiryCanDelete($id) == true) {
                if (!$row->delete($id)) {
                    $notdeleted += 1;
                }
            } else {
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

        $row = JSVEHICLEMANAGERincluder::getJSTable('adexpiry');
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
                    if ($this->adexpiryCanUnpublish($id)) {
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

    function adexpiryCanUnpublish($ageid) {
        if (!is_numeric($ageid))
            return false;
        $db = new jsvehiclemanagerdb();
        $query = " SELECT
                    ( SELECT COUNT(id) FROM `#__js_vehiclemanager_adexpiries` WHERE id = " . $ageid . " AND isdefault = 1)
                    AS total";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total > 0)
            return false;
        else
            return true;
    }

    function adexpiryCanDelete($id) {
        if (!is_numeric($id))
            return false;
        $db = new jsvehiclemanagerdb();
        $query = " SELECT
                    ( SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicles` WHERE adexpiryid = " . $id . ")
                    + ( SELECT COUNT(id) FROM `#__js_vehiclemanager_adexpiries` WHERE id = " . $id . " AND isdefault = 1)
                    AS total";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total > 0)
            return false;
        else
            return true;
    }

    function getAdexpiryForCombo() {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT id,title AS text FROM `#__js_vehiclemanager_adexpiries` WHERE status = 1 ORDER BY ordering ASC ";
        $db->setQuery($query);
        $ages = $db->loadObjectList();
        return $ages;
    }

    function isAlreadyExist($type, $advalue) {
        if(!is_numeric($type)) return false;
        if(!is_numeric($advalue)) return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_adexpiries` WHERE type = " . $type . " AND advalue = " . $advalue;
        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result > 0)
            return true;
        else
            return false;
    }

    function getVehiclesAdexpirie($title = '') {       //get vehicle adexpiries
        $db = new jsvehiclemanagerdb();
        $query = "SELECT  id,type,advalue FROM `#__js_vehiclemanager_adexpiries` WHERE id != 1 AND status = 1  ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        $adexpiries = array();
        if ($title!= '')
            $adexpiries[] = array('value' => '' , 'text' => $title);
        foreach ($rows as $row) {
            if($row->advalue > 1){
                switch($row->type){
                    case 1 : $row->type = __('Days'); break;
                    case 2 : $row->type = __('Weeks'); break;
                    case 3 : $row->type = __('Months'); break;
                    case 4 : $row->type = __('Years'); break;
                }
            }else{
                switch($row->type){
                    case 1 : $row->type = __('Day'); break;
                    case 2 : $row->type = __('Week'); break;
                    case 3 : $row->type = __('Month'); break;
                    case 4 : $row->type = __('Year'); break;
                }
            }

            $adexpiries[] = array('id' => $row->id, 'text' => $row->advalue . ' ' . $row->type);
        }
        $adexpiries = json_decode(json_encode($adexpiries));
        //echo '<pre>';print_r($adexpiries);exit;
        return $adexpiries;
    }

    function getMessagekey(){
        $key = 'adexpiry';if(is_admin()){$key = 'admin_'.$key;}return $key;
    }

}

?>
