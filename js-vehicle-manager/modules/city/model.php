<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERCityModel {

    function getCitybyId($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
            $db = new jsvehiclemanagerdb();
            $query = "SELECT * FROM `#__js_vehiclemanager_cities` WHERE id = " . $id;
            $db->setQuery($query);
            jsvehiclemanager::$_data[0] = $db->loadObject();
        }
        return;
    }

    function getCityNamebyId($id) {
        if (is_numeric($id) == false)
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT name FROM `#__js_vehiclemanager_cities` WHERE id = " . $id;
        $db->setQuery($query);
        return $db->loadResult();;
    }

    function getAllStatesCities($countryid, $stateid) {
        if (!is_numeric($countryid))
            return false;

        //Filter
        $searchname = jsvehiclemanager::$_search['city']['searchname'];
        $status = jsvehiclemanager::$_search['city']['status'];

        $inquery = '';
        $clause = ' WHERE ';
        if ($searchname != null) {
            $inquery .= $clause . " name LIKE '%$searchname%'";
            $clause = ' AND ';
        }
        if (is_numeric($status)) {
            $inquery .= $clause . " enabled = " . $status;
            $clause = ' AND ';
        }

        if ($stateid) {
            if(is_numeric($stateid)){
                $inquery .=$clause . " stateid = " . $stateid;
                $clause = ' AND ';
            }
        }
        if ($countryid) {
            $inquery .= $clause . "countryid = " . $countryid;
            $clause = ' AND ';
        }

        jsvehiclemanager::$_data['filter']['searchname'] = $searchname;
        jsvehiclemanager::$_data['filter']['status'] = $status;

        $db = new jsvehiclemanagerdb();
        //Pagination
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_cities`";
        $query .= $inquery;
        $db->setQuery($query);
        $total = $db->loadResult();
        jsvehiclemanager::$_data['total'] = $total;
        jsvehiclemanager::$_data[1] = JSVEHICLEMANAGERpagination::getPagination($total);

        //Data
        $query = "SELECT * FROM `#__js_vehiclemanager_cities`";
        $query .=$inquery;
        $query .=" ORDER BY name ASC LIMIT " . JSVEHICLEMANAGERpagination::$_offset . " , " . JSVEHICLEMANAGERpagination::$_limit;
        $db->setQuery($query);
        jsvehiclemanager::$_data[0] = $db->loadObjectList();

        return;
    }

    function storeCity($data, $countryid, $stateid) {
        if (empty($data))
            return false;
        if(! (is_numeric($countryid) || is_numeric($stateid)))
            return false;

        if ($data['id'] == '') {
            $result = $this->isCityExist($countryid, $stateid, $data['name']);
            if ($result == true) {
                return JSVEHICLEMANAGER_ALREADY_EXIST;
            }
        }

        $data['countryid'] = $countryid;
        $data['stateid'] = $stateid;
        $data['cityName'] = $data['name'];

        $row = JSVEHICLEMANAGERincluder::getJSTable('city');
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

    function deleteCities($ids) {
        if (empty($ids))
            return false;
        $row = JSVEHICLEMANAGERincluder::getJSTable('city');
        $notdeleted = 0;
        foreach ($ids as $id) {
            if(is_numeric($id)){
                if ($this->cityCanDelete($id) == true) {
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

        $row = JSVEHICLEMANAGERincluder::getJSTable('city');
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

    function cityCanDelete($cityid) {
        if (!is_numeric($cityid))
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT
                    ( SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicles` WHERE (loccity = " . $cityid . " OR regcity = ".$cityid.") )
                    + ( SELECT COUNT(id) FROM `#__js_vehiclemanager_users` WHERE cityid = " . $cityid . ")
                    AS total ";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total > 0)
            return false;
        else
            return true;
    }

    function isCityExist($countryid, $stateid, $title) {
        if (!is_numeric($countryid))
            return false;
        if (!is_numeric($stateid))
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_cities` WHERE countryid=" . $countryid . "
		AND stateid=" . $stateid . " AND LOWER(name) = '" . strtolower($title) . "'";
        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result > 0)
            return true;
        else
            return false;
    }

    private function getDataForLocationByCityID($id) {
        if (!is_numeric($id))
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT city.name AS cityname,state.name AS statename,country.name AS countryname
                    FROM `#__js_vehiclemanager_cities` AS city
                    JOIN `#__js_vehiclemanager_countries` AS country ON country.id = city.countryid
                    LEFT JOIN `#__js_vehiclemanager_states` AS state ON state.id = city.stateid
                    WHERE city.id = " . $id;
        $db->setQuery($query);
        $result = $db->loadObject();
        return $result;
    }

    function getLocationDataForView($cityids) {
        if ($cityids == '')
            return false;
        $location = '';
        if (strstr($cityids, ',')) { // multi cities id
            $cities = explode(',', $cityids);
            $data = array();
            foreach ($cities AS $city) {
                $data[] = $this->getDataForLocationByCityID($city);
            }
            $databycountry = array();
            foreach ($data AS $d) {
                $databycountry[$d->countryname][] = array('cityname' => $d->cityname, 'statename' => $d->statename);
            }
            foreach ($databycountry AS $countryname => $locdata) {
                $call = 0;
                foreach ($locdata AS $dl) {
                    if ($call == 0) {
                        $location .= '[' . $dl['cityname'];
                        if ($dl['statename']) {
                            $location .= '-' . $dl['statename'];
                        }
                    } else {
                        $location .= ', ' . $dl['cityname'];
                        if ($dl['statename']) {
                            $location .= '-' . $dl['statename'];
                        }
                    }
                    $call++;
                }
                $location .= ', ' . $countryname . '] ';
            }
        } else { // single city id
            $data = $this->getDataForLocationByCityID($cityids);
            if (is_object($data))
                $location = JSVEHICLEMANAGERincluder::getJSModel('common')->getLocationForView($data->cityname, $data->statename, $data->countryname);
        }
        return $location;
    }

    function getAddressDataByCityName($cityname, $id = 0) {
        if (!is_numeric($id))
            return false;
        if (!$cityname)
            return false;


        if (strstr($cityname, ',')) {
            $cityname = str_replace(' ', '', $cityname);
            $array = explode(',', $cityname);
            $cityname = $array[0];
            $countryname = $array[1];
        }

        $query = "SELECT concat(city.name";
        switch (jsvehiclemanager::$_config['defaultaddressdisplaytype']) {
            case 'csc'://City, State, Country
                $query .= " ,', ', (IF(state.name is not null,state.name,'')),IF(state.name is not null,', ',''),country.name)";
                break;
            case 'cs'://City, State
                $query .= " ,', ', (IF(state.name is not null,state.name,'')))";
                break;
            case 'cc'://City, Country
                $query .= " ,', ', country.name)";
                break;
            case 'c'://city by default select for each case
                $query .= ")";
                break;
        }

        $query .= " AS name, city.id AS id
                      FROM `#__js_vehiclemanager_cities` AS city
                      JOIN `#__js_vehiclemanager_countries` AS country on city.countryid=country.id
                      LEFT JOIN `#__js_vehiclemanager_states` AS state on city.stateid=state.id";
        if ($id == 0) {
            if (isset($countryname)) {
                $query .= " WHERE city.name LIKE '" . $cityname . "%' AND country.name LIKE '" . $countryname . "%' AND country.enabled = 1 AND city.enabled = 1 AND IF(state.name is not null,state.enabled,1) = 1 LIMIT " . JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue("number_of_cities_for_autocomplete");
            } else {
                $query .= " WHERE city.name LIKE '" . $cityname . "%' AND country.enabled = 1 AND city.enabled = 1 AND IF(state.name is not null,state.enabled,1) = 1 LIMIT " . JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue("number_of_cities_for_autocomplete");
            }
        } else {
            $query .= " WHERE city.id = $id AND country.enabled = 1 AND city.enabled = 1";
        }
        $db = new jsvehiclemanagerdb();
        $db->setQuery($query);
        $result = $db->loadObjectList();
        if (empty($result))
            return null;
        else
            return $result;
    }

    function storeTokenInputCity($input) {
        $tempData = explode(',', $input); // array to maintain spaces
        $input = str_replace(' ', '', $input); // remove spaces from citydata
        // find number of commas
        $num_commas = substr_count($input, ',', 0);
        if ($num_commas == 1) { // only city and country names are given
            $cityname = $tempData[0];
            $countryname = str_replace(' ', '', $tempData[1]);
        } elseif ($num_commas > 1) {
            if ($num_commas > 2)
                return 5;
            $cityname = $tempData[0];
            if (mb_strpos($tempData[1], ' ') == 0) { // remove space from start of state name if exists
                $statename = substr($tempData[1], 1, strlen($tempData[1]));
            } else {
                $statename = $tempData[1];
            }
            $countryname = str_replace(' ', '', $tempData[2]);
        }

        // get list of countries from database and check if exists or not
        $countryid = JSVEHICLEMANAGERincluder::getJSModel('country')->getCountryIdByName($countryname); // new function coded
        if (!$countryid) {
            return 4;
        }
        // if state name given in input check if exists or not otherwise store in database
        if (isset($statename)) {
            $stateid = JSVEHICLEMANAGERincluder::getJSModel('state')->getStateIdByName(str_replace(' ', '', $statename)); // new function coded
            if (!$stateid) {
                $statedata = array();
                $statedata['id'] = null;
                $statedata['name'] = ucwords($statename);
                $statedata['shortRegion'] = ucwords($statename);
                $statedata['countryid'] = $countryid;
                $statedata['enabled'] = 1;
                $statedata['serverid'] = 0;

                $newstate = JSVEHICLEMANAGERincluder::getJSModel('state')->storeTokenInputState($statedata);
                if (!$newstate) {
                    return 3;
                }
                $stateid = JSVEHICLEMANAGERincluder::getJSModel('state')->getStateIdByName($statename); // to store with city's new record
            }
        } else {
            $stateid = null;
        }

        $data = array();
        $data['id'] = null;
        $data['cityName'] = ucwords($cityname);
        $data['name'] = ucwords($cityname);
        $data['stateid'] = $stateid;
        $data['countryid'] = $countryid;
        $data['isedit'] = 1;
        $data['enabled'] = 1;
        $data['serverid'] = 0;

        $row = JSVEHICLEMANAGERincluder::getJSTable('city');
        if (!$row->bind($data)) {
            return 2;
        }
        if (!$row->store()) {
            return 2;
        }
        if (isset($statename)) {
            $statename = ucwords($statename);
        } else {
            $statename = '';
        }
        $result[0] = 1;
        $result[1] = $row->id; // get the city id for forms
        $result[2] = JSVEHICLEMANAGERincluder::getJSModel('common')->getLocationForView($row->name, $statename, $countryname); // get the city name for forms
        return $result;
    }

    public function savetokeninputcity() {
        check_ajax_referer( 'wp_js_vm_nonce_check', 'wpnoncecheck' );
        $city_string = JSVEHICLEMANAGERrequest::getVar('citydata');
        $result = $this->storeTokenInputCity($city_string);
        if (is_array($result)) {
            $return_value = json_encode(array('id' => $result[1], 'name' => $result[2])); // send back the cityid newely created
        } elseif ($result == 2) {
            $return_value = __('Error in saving records please try again', 'js-vehicle-manager');
        } elseif ($result == 3) {
            $return_value = __('Error while saving new state', 'js-vehicle-manager');
        } elseif ($result == 4) {
            $return_value = __('Country not found', 'js-vehicle-manager');
        } elseif ($result == 5) {
            $return_value = __('Location format is not correct please enter city in this format city name, country name', 'js-vehicle-manager');
        }
        echo $return_value;
        exit();
    }

    function getVehiclebyCities($pageid) {
        $db = new jsvehiclemanagerdb();
        $inquery = '';
        $show_sold_vehicle = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('show_sold_vehicles');
        if ($show_sold_vehicle == 0)
            $inquery = apply_filters('jsvm_sold_vehiclenotsold_data','','vehicle');
        $query = "SELECT city.id AS cityid, city.name AS cityname, COUNT(vehicle.id) AS totalvehiclelbycity,country.name AS countryname, state.name AS statename
                    FROM `#__js_vehiclemanager_vehicles` AS vehicle
                    JOIN `#__js_vehiclemanager_cities` AS city ON city.id = vehicle.loccity
                    JOIN `#__js_vehiclemanager_countries` AS country ON country.id = city.countryid
                    LEFT JOIN `#__js_vehiclemanager_states` AS state ON state.id = city.stateid
                    WHERE country.enabled = 1 AND city.enabled = 1 AND vehicle.status = 1 AND DATE(vehicle.adexpiryvalue) >= CURDATE() " . $inquery . "
                    GROUP BY cityname ORDER BY cityname";
        $db->setQuery($query);
        jsvehiclemanager::$_data[0] = $db->loadObjectList();

        $this->getCoordinatesOfCities($pageid);
        return ;
    }

    function getCoordinatesOfCities($pageid){
        $db = new jsvehiclemanagerdb();
        $query = "SELECT vehicle.loccity AS cityid, vehicle.latitude,vehicle.longitude,vehicle.id AS vehicleid
                        ,make.title AS maketitle, model.title AS modeltitle, cond.title AS conditiontitle
                        ,fueltype.title AS fueltypetitle
                        ,vehicle.price
                        ,currency.symbol AS currencysymbol
                        ,modelyear.title AS modelyeartitle
                        ,vehicleimage.filename as imagename,vehicleimage.file as filepath
                        ,vehicle.isdiscount, vehicle.discountstart, vehicle.discountend, vehicle.discounttype, vehicle.discount
                        , cond.color AS conditioncolor
                    FROM `#__js_vehiclemanager_vehicles` AS vehicle
                    JOIN `#__js_vehiclemanager_makes` AS make ON make.id = vehicle.makeid
                    JOIN `#__js_vehiclemanager_models` AS model ON model.id = vehicle.modelid
                    LEFT JOIN `#__js_vehiclemanager_modelyears` AS modelyear ON modelyear.id = vehicle.modelyearid
                    LEFT JOIN `#__js_vehiclemanager_conditions` AS cond ON cond.id = vehicle.conditionid
                    LEFT JOIN `#__js_vehiclemanager_fueltypes` AS fueltype ON fueltype.id = vehicle.fueltypeid
                    LEFT JOIN `#__js_vehiclemanager_currencies` AS currency ON currency.id = vehicle.currencyid
                    LEFT JOIN `#__js_vehiclemanager_vehicleimages` AS vehicleimage ON vehicleimage.vehicleid = vehicle.id AND vehicleimage.isdefault = 1
                    WHERE vehicle.status = 1 AND vehicle.adexpiryvalue >= CURDATE() ORDER BY vehicle.latitude, vehicle.longitude" ;
        $db->setQuery($query);
        $data = $db->loadObjectList();
        //echo '<pre>';print_r($data);die('asd');
        $final_array= array();
        $i = 0;
        $control_array = array();
        foreach($data AS $row){
            $html = '';
            $img = '';
            if(is_numeric($row->latitude) && is_numeric($row->longitude) ){

                if($row->imagename == ''){
                    $imgpath = CAR_MANAGER_IMAGE."/default-images/vehicle-image.png";
                }else{
                    $imgpath = $row->filepath.'s_'.$row->imagename;
                }
                if(jsvehiclemanager::$_car_manager_theme == 1){
                    $title = car_manager_ReturnVehcileTitle($row->maketitle, $row->modeltitle, $row->modelyeartitle);
                }else{
                    $title = JSVEHICLEMANAGERincluder::getJSModel('common')->returnVehicleTitle($row->maketitle, $row->modeltitle, $row->modelyeartitle);
                }
                $price =  JSVEHICLEMANAGERincluder::getJSModel('common')->getPrice($row->price,$row->currencysymbol, $row->isdiscount, $row->discounttype, $row->discount, $row->discountstart, $row->discountend);
                $vlink = jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehicledetail', 'jsvehiclemanagerid'=>$row->vehicleid , 'jsvehiclemanagerpageid' => $pageid ));
                if(jsvehiclemanager::$_car_manager_theme == 1){
                    $html .= '<a class="jsvm_vehicle-detail-map-wrapper" href="'.$vlink.'" >
                                    <div class="jsvm_vdm-image-wrapper" >
                                        <img class="jsvm_vdm-image" src="'.$imgpath.'" />
                                    </div>
                                    <div class="jsvm_vdm-top-portion" >
                                        '.$title.'
                                    </div>
                                    <div class="jsvm_vdm-bottom-portion" >
                                        <div class="jsvm_vdm-bottom-portion-left" >
                                            <div class="jsvm_vdm-condition" style="color:'.$row->conditioncolor.';border:1px solid '.$row->conditioncolor.'" >
                                                 '.__($row->conditiontitle,"js-vehicle-manager") .'
                                            </div>
                                            <div class="jsvm_vdm-fueltype">
                                                        <img src="'.CAR_MANAGER_IMAGE.'/fuel-icon.png" class="img-reponsives" />
                                                        '. __($row->fueltypetitle,"js-vehicle-manager") . '
                                            </div>
                                        </div>
                                        <div class="jsvm_vdm-bottom-portion-right" >
                                            '.$price.'
                                        </div>
                                    </div>
                              </a>';
                $img =     CAR_MANAGER_IMAGE.'/location-icons/loction-mark-icon-'.$i.'.png';
                }

                $link = jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehicles', 'cityid'=>$row->cityid , 'jsvehiclemanagerpageid' => $pageid ));
                $final_array[] = array('lat' => $row->latitude, 'lng' => $row->longitude ,'link' => $link, 'img' => $img, 'ibox' => $html);
                $i ++;
                if($i > 10){
                    $i = 0;
                }

            }

        }
        $jfinal_array = json_encode($final_array);
        jsvehiclemanager::$_data['coordinates'] = $jfinal_array;

    }
    function getMessagekey(){
        $key = 'city';if(is_admin()){$key = 'admin_'.$key;}return $key;
    }

    //

    function getAllCities(){
        $db = new jsvehiclemanagerdb();
        $query = "SELECT id,name AS title , cityName as city FROM `#__js_vehiclemanager_cities` ";
        $db->setQuery($query);
        jsvehiclemanager::$_data[0] = $db->loadObjectList();
        return;
    }
    function getVehiclebyCitiesSP() {
        $db = new jsvehiclemanagerdb();
        $inquery = '';
        $show_sold_vehicle = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('show_sold_vehicles');
        if ($show_sold_vehicle == 0)
            $inquery = do_action('jsvm_sold_vehiclenotsold_data','vehicle');
        $query = "SELECT city.id AS cityid, city.name AS cityname, COUNT(vehicle.id) AS totalvehiclelbycity,country.name AS countryname, state.name AS statename
                    FROM `#__js_vehiclemanager_vehicles` AS vehicle
                    JOIN `#__js_vehiclemanager_cities` AS city ON city.id = vehicle.loccity
                    JOIN `#__js_vehiclemanager_countries` AS country ON country.id = city.countryid
                    LEFT JOIN `#__js_vehiclemanager_states` AS state ON state.id = city.stateid
                    WHERE country.enabled = 1 AND city.enabled = 1 AND vehicle.status = 1 AND DATE(vehicle.adexpiryvalue) >= CURDATE() " . $inquery . "
                    GROUP BY cityname ORDER BY cityname";
        $db->setQuery($query);
        jsvehiclemanager::$_data[0] = $db->loadObjectList();
        return ;
    }


    function getVehiclebyCitiesForWidget($numberofvehilces) {
        if(!is_numeric($numberofvehilces)){
            $numberofvehilces = 6;
        }
        $db = new jsvehiclemanagerdb();
        $inquery = '';
        $show_sold_vehicle = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('show_sold_vehicles');
        if ($show_sold_vehicle == 0)
            $inquery = do_action('jsvm_sold_vehiclenotsold_data','vehicle');
        $query = "SELECT city.id AS cityid, city.name AS cityname, COUNT(vehicle.id) AS totalvehiclelbycity,country.name AS countryname, state.name AS statename
                    FROM `#__js_vehiclemanager_vehicles` AS vehicle
                    JOIN `#__js_vehiclemanager_cities` AS city ON city.id = vehicle.loccity
                    JOIN `#__js_vehiclemanager_countries` AS country ON country.id = city.countryid
                    LEFT JOIN `#__js_vehiclemanager_states` AS state ON state.id = city.stateid
                    WHERE country.enabled = 1 AND city.enabled = 1 AND vehicle.status = 1 AND DATE(vehicle.adexpiryvalue) >= CURDATE() " . $inquery . "
                    GROUP BY cityname ORDER BY totalvehiclelbycity DESC LIMIT ".$numberofvehilces;
        $db->setQuery($query);
        $data = $db->loadObjectList();
        return $data;
    }
}
?>
