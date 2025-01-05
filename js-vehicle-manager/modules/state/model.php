<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERStateModel {

    function getStatebyId($id) {
        if (is_numeric($id) == false)
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT * FROM `#__js_vehiclemanager_states` WHERE id = " . $id;
        $db->setQuery($query);
        jsvehiclemanager::$_data[0] = $db->loadObject();
        return;
    }

    function getAllCountryStates($countryid) {
        if (!is_numeric($countryid))
            return false;
        //Filters
        $searchname = jsvehiclemanager::$_search['state']['searchname'];
        $city = jsvehiclemanager::$_search['state']['city'];
        $status = jsvehiclemanager::$_search['state']['status'];



        $inquery = '';
        if ($searchname) {
            $inquery .= " AND name LIKE '%" . $searchname . "%'";
        }
        if (is_numeric($status)) {
            $inquery .= " AND state.enabled = " . $status;
        }

        if ($city == 1) {
            $inquery .=" AND (SELECT COUNT(id) FROM `#__js_vehiclemanager_cities` AS city WHERE city.stateid = state.id) > 0 ";
        }

        jsvehiclemanager::$_data['filter']['searchname'] = $searchname;
        jsvehiclemanager::$_data['filter']['status'] = $status;
        jsvehiclemanager::$_data['filter']['city'] = $city;

        $db = new jsvehiclemanagerdb();
        //Pagination
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_states` AS state WHERE countryid = " . $countryid;
        $query.=$inquery;
        $db->setQuery($query);
        $total = $db->loadResult();
        jsvehiclemanager::$_data['total'] = $total;
        jsvehiclemanager::$_data[1] = JSVEHICLEMANAGERpagination::getPagination($total);

        //Data
        $query = "SELECT * FROM `#__js_vehiclemanager_states` AS state WHERE countryid = " . $countryid;
        $query.=$inquery;
        $query.=" ORDER BY name ASC LIMIT " . JSVEHICLEMANAGERpagination::$_offset . "," . JSVEHICLEMANAGERpagination::$_limit;
        $db->setQuery($query);
        jsvehiclemanager::$_data[0] = $db->loadObjectList();

        return;
    }

    function storeState($data, $countryid) {
        if (empty($data))
            return false;

        $row = JSVEHICLEMANAGERincluder::getJSTable('state');
        $data['countryid'] = $countryid;

        if (!$data['id']) { // only for new
            $existvalue = $this->isStateExist($data['name'], $data['countryid']);
            if ($existvalue == true)
                return JSVEHICLEMANAGER_ALREADY_EXIST;
        }

        $data['shortRegion'] = $data['name'];
        $data = JSVEHICLEMANAGERincluder::getJSmodel('common')->stripslashesFull($data);// remove slashes with quotes.
        $data = JSVEHICLEMANAGERincluder::getJSModel('common')->getSanitizedFormData($data);
        if (!$row->bind($data)) {
            return JSVEHICLEMANAGER_SAVE_ERROR;
        }
        if (!$row->store()) {
            return JSVEHICLEMANAGER_SAVE_ERROR;
        }
        return JSVEHICLEMANAGER_SAVED;
    }

    function deleteStates($ids) {
        if (empty($ids))
            return false;
        $row = JSVEHICLEMANAGERincluder::getJSTable('state');
        $notdeleted = 0;
        foreach ($ids as $id) {
            if(is_numeric($id)){
                if ($this->stateCanDelete($id) == true) {
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

    function stateCanDelete($stateid) {
        if (!is_numeric($stateid))
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT
            ( SELECT COUNT(veh.id)
                FROM `#__js_vehiclemanager_cities` AS city
                JOIN `#__js_vehiclemanager_vehicles` AS veh ON veh.loccity = city.id
                WHERE city.stateid = " . $stateid . "
            )
            +
            ( SELECT COUNT(veh.id)
                FROM `#__js_vehiclemanager_cities` AS city
                JOIN `#__js_vehiclemanager_vehicles` AS veh ON veh.regcity = city.id
                WHERE city.stateid = " . $stateid . "
            )
            +
            ( SELECT COUNT(user.id)
                FROM `#__js_vehiclemanager_cities` AS city
                JOIN `#__js_vehiclemanager_users` AS user ON user.cityid = city.id
                WHERE city.stateid = " . $stateid . "
            )
            +
            ( SELECT COUNT(city.id)
                FROM `#__js_vehiclemanager_cities` AS city
                WHERE city.stateid = " . $stateid . "
            )
            AS total";

        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total > 0)
            return false;
        else
            return true;
    }

    function isStateExist($state, $countryid) {
        if (!is_numeric($countryid))
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_states` WHERE name = '$state' AND countryid = " . $countryid;
        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result > 0)
            return true;
        else
            return false;
    }

    function getStatesForCombo($country) {
        if (is_null($country) OR empty($country))
            $country = 0;
        if(!is_numeric($country))
            $country = 0;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT id, name AS text FROM `#__js_vehiclemanager_states` WHERE enabled = '1' AND countryid = " . $country . " ORDER BY name ASC ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        return $rows;
    }

    function publishUnpublish($ids, $status) {
        if (empty($ids))
            return false;
        if (!is_numeric($status))
            return false;

        $row = JSVEHICLEMANAGERincluder::getJSTable('state');
        $total = 0;
        if ($status == 1) {
            foreach ($ids as $id) {
                if(is_numeric($id)){
                    if (!$row->update(array('id' => $id, 'enabled' => $status))) {
                        $total += 1;
                    }
                }else{
                    $total += 1;
                }
            }
        } else {
            foreach ($ids as $id) {
                if(is_numeric($id)){
                    if (!$row->update(array('id' => $id, 'enabled' => $status))) {
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

    function getStateIdByName($name) { // new function coded
        $db = new jsvehiclemanagerdb();
        $query = "SELECT id FROM `#__js_vehiclemanager_states` WHERE REPLACE(LOWER(name), ' ', '') = REPLACE(LOWER('" . $name . "'), ' ', '') AND enabled = 1";
        $db->setQuery($query);
        $id = $db->loadResult();
        return $id;
    }

    function storeTokenInputState($data) { // new function coded
        if (empty($data))
            return false;
        if (!isset($data['countryid']))
            return false;

        $row = JSVEHICLEMANAGERincluder::getJSTable('state');
        if (!$row->bind($data)) {
            return false;
        }
        if (!$row->store()) {
            return false;
        }
        return true;
    }

    function getMessagekey(){
        $key = 'state';if(is_admin()){$key = 'admin_'.$key;}return $key;
    }
}

?>
