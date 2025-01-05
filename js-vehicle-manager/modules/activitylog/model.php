<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVehicleManageractivitylogModel {

    function __construct() {
    }

    function storeActivity($tablename, $columns, $id, $activityfor) {
        $uid = JSVEHICLEMANAGERincluder::getObjectClass('user')->uid();
        // handle when visitor add vehicle
        if(!$uid)
            $uid = 0;

        if($activityfor == 2){// in case of status change of entity it does not contain all the columns of the record
            $columns = $this->getEntityData($id,$tablename);
        }

        $text = $this->getActivityDescription($tablename, $uid, $columns, $id, $activityfor);

        if ($text == false) {
            return;
        }
        $name = $text[0];
        $desc = $text[1];
        $created = date("Y-m-d H:i:s");

        $data = array();
        $data['description'] = wp_filter_post_kses($desc);
        $data['description'] = wpautop(wptexturize(stripslashes($data['description'])));
        $data['referencefor'] = $name;
        $data['referenceid'] = $id;
        $data['uid'] = $uid;
        $data['created'] = $created;

        $db = new jsvehiclemanagerdb();
        $db->_insert('activitylog',$data);
        return JSVEHICLEMANAGER_SAVED;
    }

    function storeActivityLogForActionDelete($text, $id) {
        if (!is_numeric($id))
            return false;
        if ($text == false)
            return;
        $name = $text[0];
        $desc = $text[1];
        $uid = $text[2];
        $uid = $uid != null ? $uid : 0;
        $created = date("Y-m-d H:i:s");

        $data = array();
        $data['description'] = wp_filter_post_kses($desc);
        $data['description'] = wpautop(wptexturize(stripslashes($data['description'])));
        $data['referencefor'] = $name;
        $data['referenceid'] = $id;
        $data['uid'] = $uid;
        $data['created'] = $created;
        $db = new jsvehiclemanagerdb();
        $db->_insert('activitylog',$data);

        return JSVEHICLEMANAGER_SAVED;
    }

    function sorting() {
        jsvehiclemanager::$_data['sorton'] = jsvehiclemanager::$_search['vehicle']['sorton'];
        jsvehiclemanager::$_data['sortby'] = jsvehiclemanager::$_search['vehicle']['sortby'];

        switch (jsvehiclemanager::$_data['sorton']) {
            case 1: // created
                jsvehiclemanager::$_data['sorting'] = ' act.id ';
                break;
            case 2: // company name
                jsvehiclemanager::$_data['sorting'] = ' u.name ';
                break;
            case 3: // category
                jsvehiclemanager::$_data['sorting'] = ' act.referencefor ';
                break;
            case 4: // location
                jsvehiclemanager::$_data['sorting'] = ' act.created ';
                break;
        }
        if (jsvehiclemanager::$_data['sortby'] == 1) {
            jsvehiclemanager::$_data['sorting'] .= ' ASC ';
        } else {
            jsvehiclemanager::$_data['sorting'] .= ' DESC ';
        }
        jsvehiclemanager::$_data['combosort'] = jsvehiclemanager::$_data['sorton'];
    }

    function getAllActivities() {
        $this->sorting();
        $data = JSVEHICLEMANAGERrequest::getVar('filter');
        $string = '';
        $comma = '';

        if (isset($data['vehicletypes'])) {
            $string .= $comma . '"vehicletypes"';
            $comma = ',';
        }

        if (isset($data['vehicles'])) {
            $string .= $comma . '"vehicles"';
            $comma = ',';
        }

        if (isset($data['fueltypes'])) {
            $string .= $comma . '"fueltypes"';
            $comma = ',';
        }

        if (isset($data['mileages'])) {
            $string .= $comma . '"mileages"';
            $comma = ',';
        }

        if (isset($data['modelyears'])) {
            $string .= $comma . '"modelyears"';
            $comma = ',';
        }

        if (isset($data['transmissions'])) {
            $string .= $comma . '"transmissions"';
            $comma = ',';
        }

        if (isset($data['adexpiries'])) {
            $string .= $comma . '"adexpiries"';
            $comma = ',';
        }

        if (isset($data['cylinders'])) {
            $string .= $comma . '"cylinders"';
            $comma = ',';
        }

        if (isset($data['conditions'])) {
            $string .= $comma . '"conditions"';
            $comma = ',';
        }

        if (isset($data['currencies'])) {
            $string .= $comma . '"currencies"';
            $comma = ',';
        }

        if (isset($data['makes'])) {
            $string .= $comma . '"makes"';
            $comma = ',';
        }

        if (isset($data['config'])) {
            $string .= $comma . '"config"';
            $comma = ',';
        }

        if (isset($data['countries'])) {
            $string .= $comma . '"countries"';
            $comma = ',';
        }

        if (isset($data['states'])) {
            $string .= $comma . '"states"';
            $comma = ',';
        }

        if (isset($data['cities'])) {
            $string .= $comma . '"cities"';
            $comma = ',';
        }

        if (isset($data['credits_pack'])) {
            $string .= $comma . '"credits_pack"';
            $comma = ',';
        }


        $inquery = " ";
        $db = new jsvehiclemanagerdb();
        $searchsubmit = JSVEHICLEMANAGERrequest::getVar('searchsubmit');
        if(!empty($searchsubmit) AND $searchsubmit == 1){
            $query = "UPDATE `#__js_vehiclemanager_config`
                set configvalue = '$string' WHERE configname = 'activity_log_filter'";
            $db->setQuery($query);
            $db->query();
        }

        $activity_log_filter = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('activity_log_filter');

        if ($string != '') {
            $inquery = "WHERE act.referencefor IN ($string) ";
        } else if ($activity_log_filter != null) {

            $data = array();
            $string = $activity_log_filter;
            $inquery = "WHERE act.referencefor IN ($string) ";
            //showing check boxes checked
            $array = explode(',', $string);
            foreach ($array as $var) {
                switch ($var) {
                    case '"vehicletypes"':
                        $data['vehicletypes'] = 1;
                        break;
                    case '"vehicles"':
                        $data['vehicles'] = 1;
                        break;
                    case '"fueltypes"':
                        $data['fueltypes'] = 1;
                        break;
                    case '"mileages"':
                        $data['mileages'] = 1;
                        break;
                    case '"modelyears"':
                        $data['modelyears'] = 1;
                        break;
                    case '"transmissions"':
                        $data['transmissions'] = 1;
                        break;
                    case '"adexpiries"':
                        $data['adexpiries'] = 1;
                        break;
                    case '"cylinders"':
                        $data['cylinders'] = 1;
                        break;
                    case '"conditions"':
                        $data['conditions'] = 1;
                        break;
                    case '"currencies"':
                        $data['currencies'] = 1;
                        break;
                    case '"makes"':
                        $data['makes'] = 1;
                        break;
                    case '"config"':
                        $data['config'] = 1;
                        break;
                    case '"countries"':
                        $data['countries'] = 1;
                        break;
                    case '"states"':
                        $data['states'] = 1;
                        break;
                    case '"cities"':
                        $data['cities'] = 1;
                        break;
                    case '"credits_pack"':
                        $data['credits_pack'] = 1;
                        break;
                }
            }
        }

        jsvehiclemanager::$_data['filter']['vehicles'] = isset($data['vehicles']) ? 1 : 0;
        jsvehiclemanager::$_data['filter']['vehicletypes'] = isset($data['vehicletypes']) ? 1 : 0;
        jsvehiclemanager::$_data['filter']['fueltypes'] = isset($data['fueltypes']) ? 1 : 0;
        jsvehiclemanager::$_data['filter']['mileages'] = isset($data['mileages']) ? 1 : 0;
        jsvehiclemanager::$_data['filter']['modelyears'] = isset($data['modelyears']) ? 1 : 0;
        jsvehiclemanager::$_data['filter']['transmissions'] = isset($data['transmissions']) ? 1 : 0;
        jsvehiclemanager::$_data['filter']['adexpiries'] = isset($data['adexpiries']) ? 1 : 0;
        jsvehiclemanager::$_data['filter']['cylinders'] = isset($data['cylinders']) ? 1 : 0;
        jsvehiclemanager::$_data['filter']['conditions'] = isset($data['conditions']) ? 1 : 0;
        jsvehiclemanager::$_data['filter']['currencies'] = isset($data['currencies']) ? 1 : 0;
        jsvehiclemanager::$_data['filter']['makes'] = isset($data['makes']) ? 1 : 0;
        jsvehiclemanager::$_data['filter']['config'] = isset($data['config']) ? 1 : 0;
        jsvehiclemanager::$_data['filter']['countries'] = isset($data['countries']) ? 1 : 0;
        jsvehiclemanager::$_data['filter']['states'] = isset($data['states']) ? 1 : 0;
        jsvehiclemanager::$_data['filter']['cities'] = isset($data['cities']) ? 1 : 0;
        jsvehiclemanager::$_data['filter']['credits_pack'] = isset($data['credits_pack']) ? 1 : 0;

        $query = "SELECT COUNT(act.id)
        FROM `#__js_vehiclemanager_activitylog` AS act
        LEFT JOIN `#__js_vehiclemanager_users` AS u ON u.id = act.uid " . $inquery;
        $db->setQuery($query);
        $total = $db->loadResult();
        jsvehiclemanager::$_data[1] = JSVEHICLEMANAGERpagination::getPagination($total);

        $query = "SELECT act.description,act.created,act.id,act.referencefor,u.name AS display_name
        FROM `#__js_vehiclemanager_activitylog` AS act
        LEFT JOIN `#__js_vehiclemanager_users` AS u ON u.id = act.uid " . $inquery;
        $query .= "ORDER BY " . jsvehiclemanager::$_data['sorting'];
        $query .=" LIMIT " . JSVEHICLEMANAGERpagination::$_offset . "," . JSVEHICLEMANAGERpagination::$_limit;
        $db->setQuery($query);
        $result = $db->loadObjectList();

        jsvehiclemanager::$_data[0] = $result;
        return;
    }

    function getEntityNameOrTitle($id, $text, $tablename) {
        if (!is_numeric($id))
            return false;
        if ($text == '' OR $tablename == '')
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT $text FROM `$tablename` WHERE id = " . $id;
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }

    private function getEntityData($id, $tablename) {
        if (!is_numeric($id))
            return false;
        if ($tablename == '')
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT * FROM `$tablename` WHERE id = " . $id;
        $db->setQuery($query);
        $result = $db->loadObject();
        if($result != ''){
            $result = json_decode(json_encode($result),true);// to conver std obect into array
        }
        return $result;
    }

    function getEntityNameOrTitleForJobApply($id, $tablename) {
        if (!is_numeric($id))
            return false;
        if ($tablename == '')
            return false;
        $query = "SELECT cvid,jobid FROM `$tablename` WHERE id = " . $id;
        $result = jsvehiclemanager::$_db->get_row($query);
        $data = array();
        $data[0] = $result->jobid;
        $data[1] = $this->getJobTitleFromid($result->jobid);
        $data[2] = $result->cvid;
        $data[3] = $this->getReusmeTitleFromid($result->cvid);
        return $data;
    }

    function getActivityDescription($tablename, $uid, $columns, $id, $activityfor) {

        if (!is_numeric($uid)) return false;
        $array = explode('_', $tablename);
        $name = $array[count($array) - 1];
        $target = "_blank";
        switch ($name) {
            //all the tables which have title as column
            case 'vehicles':
                $entityname = __('Vehicle', 'js-vehicle-manager');
                $linktext = JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getVehicleNameById($id);
                $path = "?page=jsvm_vehicle&jsvmlt=formvehicle&jsvehiclemanagerid=".$id;
                $html = "<a href=" . $path . " target=$target><strong>" . $linktext . "</strong></a>";
                break;
            case 'vehicletypes':
                $entityname = __('Vehicle type', 'js-vehicle-manager');
                $linktext = $columns['title'];
                $path = "?page=jsvm_vehicletype&jsvmlt=formvehicletype&jsvehiclemanagerid=".$id;
                $html = "<a href=" . $path . " target=$target><strong>" . $linktext . "</strong></a>";
                break;
            case 'fueltypes':
                $entityname = __('Fuel Types', 'js-vehicle-manager');
                $linktext = $columns['title'];
                $path = "?page=jsvm_fueltypes&jsvmlt=formfueltype&jsvehiclemanagerid=".$id;
                $html = "<a href=" . $path . " target=$target><strong>" . $linktext . "</strong></a>";
                break;
            case 'mileages':
                $entityname = __('Mileages', 'js-vehicle-manager');
                $linktext = $columns['title'];
                $path = "?page=jsvm_mileages&jsvmlt=form&jsvehiclemanagerid=".$id;
                $html = "<a href=" . $path . " target=$target><strong>" . $linktext . "</strong></a>";
                break;
            case 'modelyears':
                $entityname = __('Model years', 'js-vehicle-manager');
                $linktext = $columns['title'];
                $path = "?page=jsvm_modelyears&jsvmlt=formmodelyear&jsvehiclemanagerid=".$id;
                $html = "<a href=" . $path . " target=$target><strong>" . $linktext . "</strong></a>";
                break;
            case 'transmissions':
                $entityname = __('Transmissions', 'js-vehicle-manager');
                $linktext = $columns['title'];
                $path = "?page=jsvm_transmissions&jsvmlt=formtransmission&jsvehiclemanagerid=".$id;
                $html = "<a href=" . $path . " target=$target><strong>" . $linktext . "</strong></a>";
                break;
            case 'adexpiries':
                $entityname = __('Ad-Expiries', 'js-vehicle-manager');
                $linktext = $columns['title'];
                $path = "?page=jsvm_adexpiry&jsvmlt=formadexpiry&jsvehiclemanagerid=".$id;
                $html = "<a href=" . $path . " target=$target><strong>" . $linktext . "</strong></a>";
                break;
            case 'cylinders':
                $entityname = __('Cylinders', 'js-vehicle-manager');
                $linktext = $columns['title'];
                $path = "?page=jsvm_cylinders&jsvmlt=formcylinder&jsvehiclemanagerid=".$id;
                $html = "<a href=" . $path . " target=$target><strong>" . $linktext . "</strong></a>";
                break;
            case 'conditions':
                $entityname = __('Conditions', 'js-vehicle-manager');
                $linktext = $columns['title'];
                $path = "?page=jsvm_conditions&jsvmlt=formcondition&jsvehiclemanagerid=".$id;
                $html = "<a href=" . $path . " target=$target><strong>" . $linktext . "</strong></a>";
                break;
            case 'currencies':
                $entityname = __('Currency', 'js-vehicle-manager');
                $linktext = $columns['title'];
                $path = "?page=jsvm_currency&jsvmlt=formcurrency&jsvehiclemanagerid=".$id;
                $html = "<a href=" . $path . " target=$target><strong>" . $linktext . "</strong></a>";
                break;
            case 'makes':
                $entityname = __('Makes', 'js-vehicle-manager');
                $linktext = $columns['title'];
                $path = "?page=jsvm_make&jsvmlt=formmake&jsvehiclemanagerid=".$id;
                $html = "<a href=" . $path . " target=$target><strong>" . $linktext . "</strong></a>";
                break;
            case 'config':
                $entityname = __('Configuration', 'js-vehicle-manager');
                $linktext = $columns['title'];
                $path = "?page=jsvm_configuration&jsvmlt=formconfiguration&jsvehiclemanagerid=".$id;
                $html = "<a href=" . $path . " target=$target><strong>" . $linktext . "</strong></a>";
                break;
            case 'countries':
                $entityname = __('Country', 'js-vehicle-manager');
                $linktext = $columns['name'];
                $path = "?page=jsvm_country&jsvmlt=formcountry&jsvehiclemanagerid=".$id;
                $html = "<a href=" . $path . " target=$target><strong>" . $linktext . "</strong></a>";
                break;
            case 'states':
                $entityname = __('States', 'js-vehicle-manager');
                $linktext = $columns['name'];
                $path = "?page=jsvm_state&jsvmlt=formstate&jsvehiclemanagerid=".$id;
                $html = "<a href=" . $path . " target=$target><strong>" . $linktext . "</strong></a>";
                break;
            case 'cities':
                $entityname = __('City', 'js-vehicle-manager');
                $linktext = $columns['name'];
                $path = "?page=jsvm_city&jsvmlt=formcity&jsvehiclemanagerid=".$id;
                $html = "<a href=" . $path . " target=$target><strong>" . $linktext . "</strong></a>";
                break;
            case 'credits_pack':
                $entityname = __('Credits Pack', 'js-vehicle-manager');
                $linktext = $columns['title'];
                $path = "?page=jsvm_creditspack&jsvmlt=formcredits&jsvehiclemanagerid=".$id;
                $html = "<a href=" . $path . " target=$target><strong>" . $linktext . "</strong></a>";
                break;
            default:
                return false;
                break;
        }
        $username = $this->getNameFromUid($uid);
        $path2 = admin_url('admin.php?page=jsvm_user&jsvmlt=profile&jsvehiclemanagerid='.$uid);
        if(current_user_can('manage_options')){
            $html2 = __('Administrator','js-vehicle-manager');
        }else{
            $html2 = "<a href=" . $path2 . " target=$target><strong>" . $username . "</strong></a>";
        }
        switch ($activityfor) {
            case 1:
                $entityaction = __('added a new', 'js-vehicle-manager');
                break;
            case 2:
                $entityaction = __('edited a existing', 'js-vehicle-manager');
                break;
            case 3:
                $entityaction = __('delete a record', 'js-vehicle-manager');
                break;
            default:
                $entityaction = __('unknown', 'js-vehicle-manager');
                break;
        }
        $result = array();
        $result[0] = $name;
        $result[1] = $html2 . " " . $entityaction . " " . $entityname . " " . $html;
        return $result;
    }

    function getNameFromUid($uid) {
        if (!is_numeric($uid))
            return false;
        if ($uid == 0) {
            return "guest";
        }
        $db = new jsvehiclemanagerdb();
        $query = "SELECT name FROM `#__js_vehiclemanager_users` WHERE id = " . $uid;
        $db->setQuery($query);
        $name = $db->loadResult();
        return $name;
    }

    function getDeleteActionDataToStore($tablename, $id) {
        $array = explode('_', $tablename);
        $name = $array[count($array) - 1];
        switch ($name) {
            //all the tables which have title as column
            case 'adexpiries':
                $entityname = __('Ad-Expiry', 'js-vehicle-manager');
                $linktext = $this->getEntityNameOrTitle($id, 'advalue', $tablename);
                break;
            case 'vehicles':
                $entityname = __('Vehicle', 'js-vehicle-manager');
                $linktext = JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getVehicleNameById($id);
                break;
            case 'vehicletypes':
                $entityname = __('Vehicle Types', 'js-vehicle-manager');
                $linktext = $this->getEntityNameOrTitle($id, 'title', $tablename);
                break;
            case 'fueltypes':
                $entityname = __('Fuel Type', 'js-vehicle-manager');
                $linktext = $this->getEntityNameOrTitle($id, 'title', $tablename);
                break;
            case 'mileages':
                $entityname = __('Mileages', 'js-vehicle-manager');
                $linktext = $this->getEntityNameOrTitle($id, 'title', $tablename);
                break;
            case 'modelyears':
                $entityname = __('Model Year', 'js-vehicle-manager');
                $linktext = $this->getEntityNameOrTitle($id, 'title', $tablename);
                break;
            case 'transmissions':
                $entityname = __('Transmissions', 'js-vehicle-manager');
                $linktext = $this->getEntityNameOrTitle($id, 'title', $tablename);
                break;
            case 'cylinders':
                $entityname = __('Cylinder', 'js-vehicle-manager');
                $linktext = $this->getEntityNameOrTitle($id, 'title', $tablename);
                break;
            case 'conditions':
                $entityname = __('Condition', 'js-vehicle-manager');
                $linktext = $this->getEntityNameOrTitle($id, 'title', $tablename);
                break;
            case 'currencies':
                $entityname = __('Currency', 'js-vehicle-manager');
                $linktext = $this->getEntityNameOrTitle($id, 'title', $tablename);
                break;
            case 'makes':
                $entityname = __('Make', 'js-vehicle-manager');
                $linktext = $this->getEntityNameOrTitle($id, 'title', $tablename);
                break;
            case 'credits_pack':
                $entityname = __('Credits Pack', 'js-vehicle-manager');
                $linktext = $this->getEntityNameOrTitle($id, 'title', $tablename);
                break;
            case 'countries':
                $entityname = __('Country', 'js-vehicle-manager');
                $linktext = $this->getEntityNameOrTitle($id, 'name', $tablename);
                break;
            case 'states':
                $entityname = __('State', 'js-vehicle-manager');
                $linktext = $this->getEntityNameOrTitle($id, 'name', $tablename);
                break;
            //tables that have name as column
            case 'cities':
                $entityname = __('City', 'js-vehicle-manager');
                $linktext = $this->getEntityNameOrTitle($id, 'name', $tablename);
                break;
            default:
                return false;
                break;
        }
        $target = "_blank";
        $uid = JSVEHICLEMANAGERincluder::getObjectClass('user')->uid();
        $username = $this->getNameFromUid($uid);
        $path2 = admin_url('admin.php?page=jsvm_user&jsvmlt=profile&jsvehiclemanagerid='.$uid);
        $html2 = "<a href='" . $path2 . "' target=$target><strong>" . $username . "</strong></a>";
        $entityaction = __("Deleted a", "js-vehicle-manager");
        $result = array();
        $result[0] = $name;
        $result[1] = $html2 . " " . $entityaction . " " . $entityname . " ( " . $linktext . " )";
        $result[2] = $uid;

        return $result;
    }

    /* Activity log Search data, admin setting and delete cookies */
    function getAdminActivityLogSearchFormData(){
        $jsvm_search_array = array();
        if(JSVEHICLEMANAGERrequest::getVar('sorton', 'post', 4) != 4 || JSVEHICLEMANAGERrequest::getVar('sortby', 'post', 2) != 2){
            $jsvm_search_array['sorton'] = JSVEHICLEMANAGERrequest::getVar('sorton', 'post', 4);
            $jsvm_search_array['sortby'] = JSVEHICLEMANAGERrequest::getVar('sortby', 'post', 2);
            $jsvm_search_array['search_from_activitylog'] = 1;
        }
        return $jsvm_search_array;
    }

    function setSearchVariableForAdminActivityLog($jsvm_search_array){
        jsvehiclemanager::$_search['vehicle']['sorton'] = isset($jsvm_search_array['sorton']) ? $jsvm_search_array['sorton'] : 4;
        jsvehiclemanager::$_search['vehicle']['sortby'] = isset($jsvm_search_array['sortby']) ? $jsvm_search_array['sortby'] : 2;
    }

    function getCookiesSavedSearchDataActivityLog(){
        $jsvm_search_array = array();
        $vehicle_search_cookie_data = '';
        if(isset($_COOKIE['jsvm_vehicle_search_data'])){
            $vehicle_search_cookie_data = $_COOKIE['jsvm_vehicle_search_data'];
            $vehicle_search_cookie_data = json_decode( base64_decode($vehicle_search_cookie_data) , true );
        }
        if($vehicle_search_cookie_data != '' && isset($vehicle_search_cookie_data['search_from_activitylog']) && $vehicle_search_cookie_data['search_from_activitylog'] == 1){
            $jsvm_search_array['sorton'] = $vehicle_search_cookie_data['sorton'];
            $jsvm_search_array['sortby'] = $vehicle_search_cookie_data['sortby'];
            $jsvm_search_array['search_from_activitylog'] = $vehicle_search_cookie_data['search_from_activitylog'];
        }

        return $jsvm_search_array;
    }

}

?>
