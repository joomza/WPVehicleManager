<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERUserModel {

    private $_param_array;

    function getUserNamebyId($id) {
        if (is_numeric($id) == false)
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT name FROM `#__js_vehiclemanager_users` WHERE id = " . $id;
        $db->setQuery($query);
        return $db->loadResult();;
    }

    function checkUserBySocialID($socialid) {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_users` WHERE socialid = '" . $socialid . "'";
        $db->setQuery($query);
        $result = $db->loadResult($query);
        return $result;
    }

    function sorting() {
        jsvehiclemanager::$_data['sorton'] = JSVEHICLEMANAGERrequest::getVar('sorton', 'post', 2);
        jsvehiclemanager::$_data['sortby'] = JSVEHICLEMANAGERrequest::getVar('sortby', 'post', 2);
        switch (jsvehiclemanager::$_data['sorton']) {
            case 2: // created
                $sort_string = ' created ';
                break;
            case 1: // name
                $sort_string = ' name ';
                break;
        }
        if (jsvehiclemanager::$_data['sortby'] == 1) {
            $sort_string .= ' ASC ';
        } else {
            $sort_string .= ' DESC ';
        }
        jsvehiclemanager::$_data['combosort'] = jsvehiclemanager::$_data['sorton'];

        return $sort_string;
    }


    function getAllprofile() {
        // sorting
        $sort_string = $this->sorting();
        //Filters
        $searchname = jsvehiclemanager::$_search['user']['searchname'];
        $email = jsvehiclemanager::$_search['user']['email'];
        $status = jsvehiclemanager::$_search['user']['status'];

        $inquery = '';
        $clause = ' WHERE ';
        if ($searchname != null) {
            //$title = esc_sql($title);
            $inquery .= $clause . "user.name LIKE '%" . $searchname . "%'";
            $clause = ' AND ';
        }
        if (is_email($email)){
            $inquery .= $clause . " user.email = '" . $email ."' ";
            $clause = ' AND ';
        }
        if (is_numeric($status)){
            $inquery .= $clause . " user.status = " . $status;
            $clause = ' AND ';
        }

        jsvehiclemanager::$_data['filter']['searchname'] = $searchname;
        jsvehiclemanager::$_data['filter']['email'] = $email;
        jsvehiclemanager::$_data['filter']['status'] = $status;

        $db = new jsvehiclemanagerdb();
        //Pagination
        $query = "SELECT COUNT(user.id) FROM `#__js_vehiclemanager_users` AS user ";
        $query.=$inquery;
        $db->setQuery($query);
        $total = $db->loadResult();
        jsvehiclemanager::$_data['total'] = $total;
        jsvehiclemanager::$_data[1] = JSVEHICLEMANAGERpagination::getPagination($total);

        //Data
        do_action("jsvm_query_data_for_socialcheck");
        $query = "SELECT id, name, cell, phone, email, weblink, status, ". jsvehiclemanager::$_addon_query['select'] ." photo, cityid, latitude, longitude
                        , description, videotypeid, video, facebook, twitter, linkedin, googleplus, pinterest
                        , instagram, reddit, created, params
                        FROM `#__js_vehiclemanager_users` AS user ";
        $query.=$inquery;
        $query.=" ORDER BY ".$sort_string;
        $query.=" LIMIT " . JSVEHICLEMANAGERpagination::$_offset . "," . JSVEHICLEMANAGERpagination::$_limit;
        do_action("reset_jsvm_aadon_query");
        $db->setQuery($query);
        jsvehiclemanager::$_data[0] = $db->loadObjectList();
        return;
    }

    function getAllSellerInfoForView($id) {
        if (is_numeric($id) == false)
            return false;
        $db = new jsvehiclemanagerdb();
        do_action("jsvm_query_data_for_socialcheck");
        $query = "SELECT id, name, cell, phone, email, weblink, status, ". jsvehiclemanager::$_addon_query['select'] ." photo, cityid, latitude, longitude
                        , description, videotypeid, video, facebook, twitter, linkedin, googleplus, pinterest,address
                        , instagram, reddit, created, params
                        FROM `#__js_vehiclemanager_users`
                        WHERE id = " . $id;
        $db->setQuery($query);
        do_action("reset_jsvm_aadon_query");
        jsvehiclemanager::$_data[0] = $db->loadObject();
        if(!empty(jsvehiclemanager::$_data[0])){
            jsvehiclemanager::$_data[0]->location = JSVEHICLEMANAGERincluder::getJSModel('city')->getLocationDataForView(jsvehiclemanager::$_data[0]->cityid);
        }
        global $car_manager_options;
        if(JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()){
            jsvehiclemanager::$_data['showcaptcha'] = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('recaptcha_contacttoseller');
        }else{
            jsvehiclemanager::$_data['showcaptcha'] = 0;
        }
        // for custom file download
        jsvehiclemanager::$_data['objectid'] = $id;
        jsvehiclemanager::$_data['fields'] = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getFieldsOrderingforView(2);
        return;
    }

    function getAllSellerInfos() {
        $search_userfields = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->userFieldsForSearch(2);
        $searchname = null;
        $weblink   = null;

        if(isset(jsvehiclemanager::$_search['sellerlist']['searchname']))
        {
             $searchname = jsvehiclemanager::$_search['sellerlist']['searchname'];
        }

        if(isset(jsvehiclemanager::$_search['sellerlist']['weblink']))
        {
            $weblink = jsvehiclemanager::$_search['sellerlist']['weblink'];
        }


        if(isset(jsvehiclemanager::$_data['sanitized_args']) && isset(jsvehiclemanager::$_data['sanitized_args']['cityid'])){
            $id = jsvehiclemanager::$_data['sanitized_args']["cityid"];
        }else{
            $id = '';
        }
        if($id != ''){
            $array = explode('_', $id);
            $id = $array[1];
            $clue = $id[0] . $id[1];
            $id = substr($id, 2);
            if ($clue == 13) {
                $cityid = $id;
            }else{
                $cityid = '';
            }
        }else{
            $cityid = null;
            if(isset(jsvehiclemanager::$_search['sellerlist']['cityid']))
            {
                $cityid = jsvehiclemanager::$_search['sellerlist']['cityid'];
            }

        }
        $formsearch = JSVEHICLEMANAGERrequest::getVar('JSVEHICLEMANAGER_form_search', 'post');
        if (!empty($search_userfields)) {
            foreach ($search_userfields as $uf) {
                if (isset($value_array[$uf->field])) {
                $value_array[$uf->field] = jsvehiclemanager::$_search['jsvm_seller_customfield'][$uf->field];
                }
            }
        }

        $inquery = '';
        if ($searchname != '') {
            $inquery .= " AND user.name LIKE '%" . $searchname . "%'";
        }
        if ($weblink != ''){
            $inquery .= " AND user.weblink LIKE '%" . $weblink . "%'";
        }
        if ($cityid!= ''){
            $inquery .= " AND user.cityid IN (" . $cityid.") ";
            $cityid = JSVEHICLEMANAGERincluder::getJSModel('common')->getCitiesForFilter($cityid);
        }

        $valarray = array();
        if (!empty($search_userfields)) {
            foreach ($search_userfields as $uf) {
                if (JSVEHICLEMANAGERrequest::getVar('pagenum', 'get', null) != null) {
                    $valarray[$uf->field] = $value_array[$uf->field];
                }else{
                    $valarray[$uf->field] = JSVEHICLEMANAGERrequest::getVar($uf->field, 'post');
                }
                if (isset($valarray[$uf->field]) && $valarray[$uf->field] != null) {
                    switch ($uf->userfieldtype) {
                        case 'text':
                        case 'email':
                        case 'file':
                            $inquery .= ' AND user.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($valarray[$uf->field]) . '.*"\' ';
                            break;
                        case 'combo':
                            $inquery .= ' AND user.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                            break;
                        case 'depandant_field':
                            $inquery .= ' AND user.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                            break;
                        case 'radio':
                            $inquery .= ' AND user.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                            break;
                        case 'checkbox':
                            $finalvalue = '';
                            foreach($valarray[$uf->field] AS $value){
                                $finalvalue .= $value.'.*';
                            }
                            $inquery .= ' AND user.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($finalvalue) . '.*"\' ';
                            break;
                        case 'date':
                            $inquery .= ' AND user.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                            break;
                        case 'textarea':
                            $inquery .= ' AND user.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($valarray[$uf->field]) . '.*"\' ';
                            break;
                        case 'multiple':
                            $finalvalue = '';
                            foreach($valarray[$uf->field] AS $value){
                                if($value != null){
                                    $finalvalue .= $value.'.*';
                                }
                            }
                            if($finalvalue !=''){
                                $inquery .= ' AND user.params REGEXP \'"' . $uf->field . '":"[^"]*'.htmlspecialchars($finalvalue).'.*"\'';
                            }
                            break;
                    }
                    jsvehiclemanager::$_data['filter']['params'] = $valarray;
                }
            }
        }

        jsvehiclemanager::$_data['filter']['searchname'] = $searchname;
        jsvehiclemanager::$_data['filter']['weblink'] = $weblink;
        jsvehiclemanager::$_data['filter']['cityid'] = $cityid;


        $db = new jsvehiclemanagerdb();
        //pagination
        $query = "SELECT COUNT(DISTINCT user.id)
                    FROM `#__js_vehiclemanager_users` AS user
                    JOIN `#__js_vehiclemanager_vehicles` As veh ON veh.uid = user.id
                    WHERE user.status = 1 ";


        $query .=   $inquery;
        $query .=   " GROUP BY user.id";
        $db->setQuery($query);
        $total = $db->loadResult();
        jsvehiclemanager::$_data['total'] = $total;
        jsvehiclemanager::$_data[1] = JSVEHICLEMANAGERpagination::getPagination($total);
        do_action("jsvm_query_data_for_socialcheck","user.");
        $query = "SELECT user.id, user.name, user.cell, user.phone, user.email, user.weblink, user.status, ". jsvehiclemanager::$_addon_query['select'] ." user.photo, user.cityid, user.params
                        FROM `#__js_vehiclemanager_users` AS user
                        JOIN `#__js_vehiclemanager_vehicles` As veh ON veh.uid = user.id
                        WHERE user.status = 1";
        $query .=   $inquery;
        $query .=   " GROUP BY user.id";
        $db->setQuery($query);
        do_action("reset_jsvm_aadon_query");
        $results = $db->loadObjectList();
        foreach ($results as $seller) {
            $seller->location = JSVEHICLEMANAGERincluder::getJSModel('city')->getLocationDataForView($seller->cityid);
        }
        jsvehiclemanager::$_data[0] = $results;
        jsvehiclemanager::$_data['fields'] = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getFieldsOrderingforView(2);
        jsvehiclemanager::$_data['listingfields'] = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getFieldsForListing(2);
        JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getFieldsOrderingforSearch(2);
        jsvehiclemanager::$_data['searchfields'] = jsvehiclemanager::$_data[3];// it is populated from above call
        return;
    }

    function getProfileByUid($id) {
        if (is_numeric($id) == false)
            return false;
        // user stats
        $db = new jsvehiclemanagerdb();
        if(JSVEHICLEMANAGERincluder::getObjectClass('user')->isSellerCheck($id)){
            $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicles` WHERE uid = " . $id;
            $db->setQuery($query);
            jsvehiclemanager::$_data['totalvehicles'] = $db->loadResult();
            jsvehiclemanager::$_data['featuredvehicles'] = apply_filters('jsvm_featuredvehicle_for_userprofile',0,$id);
            $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicles` WHERE uid = " . $id. " AND adexpiryvalue < CURDATE() ";
            $db->setQuery($query);
            jsvehiclemanager::$_data['expiredvehicles'] = $db->loadResult();
        }
        $query = "SELECT * FROM `#__js_vehiclemanager_users` WHERE id = " . $id;
        $db->setQuery($query);
        $user = $db->loadObject();
        if($user->hash == ''){
            $row = JSVEHICLEMANAGERincluder::getJSTable('users');
            $en_string = jsvehiclemanager::generateHash($id);
            $row->update( array('id'=>$id,"hash"=>$en_string));
        }
        jsvehiclemanager::$_data['user'] = $user;
        //jsvehiclemanager::$_data['objectid'] = 1;
        jsvehiclemanager::$_data['objectid'] = $id;
        if(!empty(jsvehiclemanager::$_data['user']))
            jsvehiclemanager::$_data['user']->location = JSVEHICLEMANAGERincluder::getJSModel('city')->getLocationDataForView(jsvehiclemanager::$_data['user']->cityid);
        return;
    }

    function getSellersBySellerName($sname) {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT id,name FROM `#__js_vehiclemanager_users`
                    WHERE name LIKE '" . $sname . "%'
                    AND status = 1 LIMIT 0,10";
        $db->setQuery($query);
        $result = $db->loadObjectList();
        if (empty($result))
            return null;
        else
            return $result;
    }

    function getDataForDashboardTab($id) {
        if (is_numeric($id) == false)
            return false;
        $db = new jsvehiclemanagerdb();
        // user stats
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicles` WHERE uid = " . $id;
        $db->setQuery($query);
        jsvehiclemanager::$_data['totalvehicles'] = $db->loadResult();
        jsvehiclemanager::$_data['featuredvehicles'] = apply_filters('jsvm_featuredvehicle_for_userprofile',0,$id);
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicles` WHERE uid = " . $id. " AND adexpiryvalue < CURDATE() ";
        $db->setQuery($query);
        jsvehiclemanager::$_data['expiredvehicles'] = $db->loadResult();
        // user my vehicles
        $query = "SELECT veh.price, veh.created, veh.id AS vehicleid, veh.loccity, veh.isdiscount, veh.discountstart, veh.discountend, veh.discount, veh.discounttype, currency.symbol ,
                        make.title AS maketitle , model.title AS modeltitle , modelyear.title AS modelyeartitle
                        FROM `#__js_vehiclemanager_vehicles` AS veh
                        JOIN `#__js_vehiclemanager_makes` AS make ON make.id = veh.makeid
                        JOIN `#__js_vehiclemanager_models` AS model ON model.id = veh.modelid
                        LEFT JOIN `#__js_vehiclemanager_currencies` AS currency ON currency.id = veh.currencyid
                        LEFT JOIN `#__js_vehiclemanager_modelyears` AS modelyear ON modelyear.id = veh.modelyearid
                        WHERE veh.uid = " . $id ." ORDER BY veh.created DESC LIMIT 5";
        $db->setQuery($query);
        jsvehiclemanager::$_data['myvehicles'] = $db->loadObjectList();

        foreach (jsvehiclemanager::$_data['myvehicles'] as $vehicle) {
            $vehicle->location = JSVEHICLEMANAGERincluder::getJSModel('city')->getLocationDataForView($vehicle->loccity);
        }

        // user my Shortlisted Vehicles
        jsvehiclemanager::$_data['shortlistedvehicles'] = apply_filters("jsvm_shortlist_data_for_dashboard",'',$id);
        // user vehicle alerts
        jsvehiclemanager::$_data['vehiclealert'] = apply_filters("jsvm_vehiclealert_data_for_dashboard", '',$id);

        $query = "SELECT * FROM `#__js_vehiclemanager_users` WHERE id = " . $id;
        $db->setQuery($query);
        jsvehiclemanager::$_data['user'] = $db->loadObject();
        jsvehiclemanager::$_data['user']->location = JSVEHICLEMANAGERincluder::getJSModel('city')->getLocationDataForView(jsvehiclemanager::$_data['user']->cityid);
        jsvehiclemanager::$_data['listingfields'] = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getFieldsForListing(1);
        // dasshboard graph data
        $curdate = date('Y-m-d');
        $fromdate = date('Y-m-d', strtotime("now -1 month"));
        jsvehiclemanager::$_data['curdate'] = $curdate;
        jsvehiclemanager::$_data['fromdate'] = $fromdate;

        $query = "SELECT count(vehicle.id) AS total,vehicle.makeid AS id
                    FROM `#__js_vehiclemanager_vehicles` AS vehicle
                    WHERE date(vehicle.created) >= '" . $fromdate . "' AND date(vehicle.created) <= '" . $curdate . "'
                    GROUP BY vehicle.makeid
                    ORDER By total DESC
                    LIMIT 5 ";
        $db->setQuery($query);
        $makes = $db->loadObjectList();
        $make_count = 0;
        // to handle the case when there are not five diffrent makeids in vehicle table
        $make_array[0] = '';
        $make_array[1] = '';
        $make_array[2] = '';
        $make_array[3] = '';
        $make_array[4] = '';
        foreach ($makes as $make) {
            $query = "SELECT vehicle.created
                        FROM `#__js_vehiclemanager_vehicles` AS vehicle
                        WHERE date(vehicle.created) >= '" . $fromdate . "' AND date(vehicle.created) <= '" . $curdate . "'
                        AND vehicle.makeid= ".$make->id." AND vehicle.status = 1
                        ORDER BY vehicle.created";
            $db->setQuery($query);
            $vehicles[$make_count] = $db->loadObjectList();
            $vehicles_make[$make_count] = array();
            foreach ($vehicles[$make_count] AS $vehicle) {
                $date = date('Y-m-d', strtotime($vehicle->created));
                $vehicles_make[$make_count][$date] = isset($vehicles_make[$make_count][$date]) ? ($vehicles_make[$make_count][$date] + 1) : 1;
            }
            $make_array[$make_count]= JSVEHICLEMANAGERincluder::getJSModel('make')->getMakeTitlebyId($make->id);
            $make_count++;
        }


        jsvehiclemanager::$_data['stack_chart_horizontal']['title'] = "['" . __('Dates', 'js-vehicle-manager') . "','"
        . __($make_array[0], 'js-vehicle-manager') . "','"
        . __($make_array[1], 'js-vehicle-manager') . "','"
        . __($make_array[2], 'js-vehicle-manager') . "','"
        . __($make_array[3], 'js-vehicle-manager') . "','"
        . __($make_array[4], 'js-vehicle-manager') . "']";
        jsvehiclemanager::$_data['stack_chart_horizontal']['data'] = '';
        for ($i = 29; $i >= 0; $i--) {
            $checkdate = date('Y-m-d', strtotime($curdate . " -$i days"));
            if ($i != 29) {
                jsvehiclemanager::$_data['stack_chart_horizontal']['data'] .= ',';
            }
            jsvehiclemanager::$_data['stack_chart_horizontal']['data'] .= "['" . date_i18n('Y-M-d', strtotime($checkdate)) . "',";
            $make1 = isset($vehicles_make[0][$checkdate]) ? $vehicles_make[0][$checkdate] : 0;
            $make2 = isset($vehicles_make[1][$checkdate]) ? $vehicles_make[1][$checkdate] : 0;
            $make3 = isset($vehicles_make[2][$checkdate]) ? $vehicles_make[2][$checkdate] : 0;
            $make4 = isset($vehicles_make[3][$checkdate]) ? $vehicles_make[3][$checkdate] : 0;
            $make5 = isset($vehicles_make[4][$checkdate]) ? $vehicles_make[4][$checkdate] : 0;
            jsvehiclemanager::$_data['stack_chart_horizontal']['data'] .= "$make1,$make2,$make3,$make4,$make5,]";
        }
        // seller graph
        $uid = JSVEHICLEMANAGERincluder::getObjectClass('user')->uid();
        if(is_numeric($uid) && $uid != ''){
            if(JSVEHICLEMANAGERincluder::getObjectClass('user')->isSeller()){
                $curdate = date('Y-m-d');
                $query = "SELECT COUNT(vehicle.id) AS total,vehicle.created
                    FROM `#__js_vehiclemanager_vehicles` AS vehicle
                    WHERE vehicle.uid = ".$uid."
                    GROUP BY MONTH(vehicle.created)
                    ORDER BY vehicle.created DESC LIMIT 6 ";
                $db->setQuery($query);
                $vehicle = $db->loadObjectList();
                $vehicledata = array();
                foreach ($vehicle as $data) {
                    if (!isset($vehicledata[date_i18n('M', strtotime($data->created))]))
                        $vehicledata[date_i18n('M', strtotime($data->created))] = 0;
                    $vehicledata[date_i18n('M', strtotime($data->created))] = $data->total;
                }
                $colors = $this->getChartColor();
                jsvehiclemanager::$_data['sellergraph'] = '';
                for ($i = 5; $i >= 0; $i--) {
                    $checkdate = date_i18n('M', strtotime($curdate . " -$i months"));
                    $year = date_i18n('y', strtotime($curdate . " -$i months"));
                    $vehicles = isset($vehicledata[$checkdate]) ? $vehicledata[$checkdate] : 0;
                    jsvehiclemanager::$_data['sellergraph'] .= "['" . $checkdate . '-' . $year . "', " . $vehicles . ", '" . $colors[$i] . "', '" . __('vehicles', 'js-jobs') . "' ],";
                }
            }
        }
        return;
    }

    function getChartColor() {
        $colors = array('#3366CC', '#DC3912', '#FF9900', '#109618', '#990099', '#B77322', '#8B0707', '#AAAA11', '#316395', '#DD4477', '#3B3EAC', '#ADD042', '#9D98CA', '#ED3237', '#585570', '#4E5A62', '#5CC6D0');
        return $colors;
    }

    function getSellerInfoForForm($id) {
        if (is_numeric($id) == false)
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT * FROM `#__js_vehiclemanager_users` WHERE id = " . $id;
        $db->setQuery($query);
        jsvehiclemanager::$_data[0] = $db->loadObject();
        if(isset(jsvehiclemanager::$_data[0]) && !empty(jsvehiclemanager::$_data[0])){
            jsvehiclemanager::$_data[0]->cityid = JSVEHICLEMANAGERincluder::getJSModel('common')->getCitiesForFilter(jsvehiclemanager::$_data[0]->cityid);;
        }
        if(jsvehiclemanager::$_data[0]->hash == ''){
            $row = JSVEHICLEMANAGERincluder::getJSTable('users');
            $en_string = base64_encode(json_encode(base64_encode($id)));
            $row->update( array('id'=>$id,"hash"=>$en_string));
        }
        return;
    }

    function getDataForProfileForm($id){
        jsvehiclemanager::$_data[2] = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getFieldsOrderingByFor(2);
        $this->getSellerInfoForForm($id);
        return;
    }

    function storeProfile($data, $call_flag = 0) {
        if (empty($data))
            return false;
        $row = JSVEHICLEMANAGERincluder::getJSTable('users');
        $data = JSVEHICLEMANAGERincluder::getJSmodel('common')->stripslashesFull($data);// remove slashes with quotes.
        $data = JSVEHICLEMANAGERincluder::getJSModel('common')->getSanitizedFormData($data);
        if($call_flag != 2){ // auto generate profile from wp user case (will not have any files or custom fields)
            if($call_flag == 0){
                $data['params'] = $this->getParamsForProfile($data,$data['id']);
                $data['description']= wp_filter_post_kses($_POST['description']);
                $data['description'] = wpautop(wptexturize(stripslashes($data['description'])));
            }else{
                $pdata = JSVEHICLEMANAGERrequest::get('post');
                $data['params'] = $this->getParamsForProfile($pdata);
                $data['description']= wp_filter_post_kses($_POST['sellerdescription']);
                $data['description'] = wpautop(wptexturize(stripslashes($data['description'])));

            }
            $data['autogenerated']= 0;
        }

        // validations code
        if($data['id'] != ''){
            if(!is_admin()){
                unset($data['uid']);
                unset($data['status']);
            }
            $en_string = jsvehiclemanager::generateHash($data['id']);
            if($en_string != $data['hash']){
                return JSVEHICLEMANAGER_SAVE_ERROR;
            }
        }
        if(isset($data['uid']) && $data['uid'] != 0 && $data['uid'] != '' ){
            $db = new jsvehiclemanagerdb();
            $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_users` WHERE uid = ".$data['uid'];
            $db->setQuery($query);
            $uids = $db->loadResult();
            if($uids > 0){
                return JSVEHICLEMANAGER_SAVE_ERROR;
            }
        }

        if (!$row->bind($data)) {
            return JSVEHICLEMANAGER_SAVE_ERROR;
        }
        if (!$row->store()) {
            return JSVEHICLEMANAGER_SAVE_ERROR;
        }

        if($data['id'] == ''){
            $profileid = $row->id;
            $en_string = jsvehiclemanager::generateHash($profileid);
            $row->update( array('id'=>$profileid,"hash"=>$en_string));
            // email template code
            JSVEHICLEMANAGERincluder::getJSModel('emailtemplate')->sendMail(3, 1 ,$profileid);
            // auto assign free package to user
            if( is_numeric($data['uid']) && $data['uid'] != 0){
                $auto_assign_package = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('auto_assign_free_package');
                if($auto_assign_package == 1){
                    do_action('jsvm_purchase_auto_assign_free_package',$profileid,$data['name'],$data['email']);
                }

            }
        }else{
            $profileid = $data['id'];
        }
        if($call_flag != 2){ // auto generate profile from wp user case (will not have any files or custom fields)
            if($call_flag == 0){
                //delete images deleted by user
                $deleteimage = $data['deleteimage'];
                if($deleteimage == 1){
                    $this->deleteProfileImage($profileid);
                }
            }
            // upload new images
            if( isset($_FILES['profilephoto']) && $_FILES['profilephoto']['error'] != 4){
                $this->storeProfileImages($profileid);
            }
            // Storing Attachments
            //removing custom field attachments

            if( isset($this->_param_array['customflagfordelete'])){
                if($this->_param_array['customflagfordelete'] == true){
                    foreach ($this->_param_array['custom_field_namesfordelete'] as $key) {
                        $res = $this->removeFileCustom($profileid,$key);
                    }
                }
            }

            //storing custom field attachments

            if(isset($this->_param_array['customflagforadd'])){
                if($this->_param_array['customflagforadd'] == true){
                    foreach ($this->_param_array['custom_field_namesforadd'] as $key) {
                        if ($_FILES[$key]['size'] > 0) { // file
                            $res = $this->uploadFileCustom($profileid,$key);
                        }
                    }
                }
            }

        }
        if($call_flag != 0){
            return $profileid;
        }
        return JSVEHICLEMANAGER_SAVED;
    }

    function deleteProfileImage($profileid) {
        if(! is_numeric($profileid))
            return;
        $db = new jsvehiclemanagerdb();
        // select photo so that custom uploaded files are not delted
        $query = "SELECT photo FROM `#__js_vehiclemanager_users` WHERE id = ".$profileid;
        $db->setQuery($query);
        $photo = $db->loadResult();

        // path to file so that it can be removed
        $wpdir = wp_upload_dir();
        $data_directory = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
        $path = $wpdir['basedir'] . '/' . $data_directory . '/data/profile/profile_' .$profileid;
        $files = glob( $path . '/*');
        $filename = basename($photo);
        $filename = str_replace("", '', $filename);
        foreach($files as $file){
            if(is_file($file) && strstr($file, $filename) ) {
                unlink($file);
            }
        }
        $query = "UPDATE `#__js_vehiclemanager_users` SET photo = '' WHERE id = ".$profileid;
        $db->setQuery($query);
        $db->query();
        return;
    }

    function storeProfileImages($profileid) {
        if(! is_numeric($profileid))
            return;
        $file = $_FILES['profilephoto'];
        $image = JSVEHICLEMANAGERincluder::getObjectClass('uploads')->vehicleManagerUpload($profileid, $file,3);
        $wpdir = wp_upload_dir();
        $data_directory = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
        $path = $wpdir['basedir'] . '/' . $data_directory . '/data/profile/profile_' .$profileid ;
        if(is_array($image) && !empty($image)){
            $file_size = filesize($image[0]);
            $temp_file_name = basename( $image[0] );
            $image[1] = str_replace($temp_file_name, '', $image[1]);

            $file_name = ''.$temp_file_name;
            JSVEHICLEMANAGERincluder::getJSModel('vehicle')->createThumbnail($file_name,160,160,$image[0],$path,1);
            $img_loc = $image[1].$file_name;
            $db = new jsvehiclemanagerdb();
            $query = "UPDATE `#__js_vehiclemanager_users` SET photo = '".$img_loc."' WHERE id = ".$profileid;
            $db->setQuery($query);
            $db->query();
        }
        return ;
    }

    function uploadFileCustom($id,$field){
        JSVEHICLEMANAGERincluder::getObjectClass('uploads')->storeCustomUploadFile($id,$field,2);
    }

    function storeUploadFieldValueInParams($profileid,$filename,$field){
        if(!is_numeric($profileid))
            return;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT params FROM `#__js_vehiclemanager_users` WHERE id = ".$profileid;
        $db->setQuery($query);
        $params = $db->loadResult();
        if(!empty($params)){
            $decoded_params = json_decode($params,true);
        }else{
            $decoded_params = array();
        }
        $decoded_params[$field] = $filename;
        $encoded_params = json_encode($decoded_params);
        $query = "UPDATE `#__js_vehiclemanager_users` SET params = '" . $encoded_params . "' WHERE id = " . $profileid;
        $db->setQuery($query);
        $db->query();
        return;
    }

    function getParamsForProfile($data,$id = ''){
        //custom field code start
            $customflagforadd = false;
            $customflagfordelete = false;
            $custom_field_namesforadd = array();
            $custom_field_namesfordelete = array();
            $userfield = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getUserfieldsfor(2);
            $params = array();
            foreach ($userfield AS $ufobj) {
                $vardata = '';
                if($ufobj->userfieldtype == 'file'){
                    if(isset($data[$ufobj->field.'_1']) && $data[$ufobj->field.'_1']== 0){
                        $vardata = $data[$ufobj->field.'_2'];
                    }
                    $this->_param_array['customflagforadd']=true;
                    $this->_param_array['custom_field_namesforadd'][]=$ufobj->field;
                }else{
                    $vardata = isset($data[$ufobj->field]) ? $data[$ufobj->field] : '';
                }
                if(isset($data[$ufobj->field.'_1']) && $data[$ufobj->field.'_1'] == 1){
                    $this->_param_array['customflagfordelete'] = true;
                    $this->_param_array['custom_field_namesfordelete'][]= $data[$ufobj->field.'_2'];
                    }
                if($vardata != ''){

                    if(is_array($vardata)){
                        $vardata = implode(', ', $vardata);
                    }
                    $params[$ufobj->field] = htmlspecialchars($vardata);
                }
            }

            if($id != ''){
                if(is_numeric($id)){
                    $db = new jsvehiclemanagerdb();
                    $query = "SELECT params FROM `#__js_vehiclemanager_users` WHERE id = " . $id;
                    $db->setQuery($query);
                    $oParams = $db->loadResult();

                    if(!empty($oParams)){
                        $oParams = json_decode($oParams,true);
                        $unpublihsedFields = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getUserUnpublishFieldsfor(2);
                        foreach($unpublihsedFields AS $field){
                            if(isset($oParams[$field->field])){
                                $params[$field->field] = $oParams[$field->field];
                            }
                        }
                    }
                }
            }
                $params = json_encode($params);
            return $params;
    }

    function removeFileCustom($id,$key){
        $filename = str_replace(' ', '_', $key);
        $wpdir = wp_upload_dir();
        $data_directory = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
        $path = $wpdir['basedir'] . '/' . $data_directory . '/data/profile/profile_' .$id.'/' ;
        $userpath = $path.$filename;
        unlink($userpath);
        return ;
    }

    function getUsernameAndEmailFromProfile($uid){
        if(!is_numeric($uid))
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT name, email, id
            FROM `#__js_vehiclemanager_users`
            WHERE id = ".$uid;
        $db->setQuery($query);
        $user = $db->loadObject();
        return $user;
    }

    function publishUnpublish($ids, $status) {
        if (empty($ids))
            return false;
        if (!is_numeric($status))
            return false;

        $row = JSVEHICLEMANAGERincluder::getJSTable('users');
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

    function deleteUserData($ids){
        if (empty($ids))
            return false;

        $notdeleted = 0;
        foreach ($ids as $id) {
            if( is_numeric($id) ){
                if( ! $this->deleteUserRecords($id)){
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

    function enforceDeleteUserData($ids){
        if (empty($ids))
            return false;

        $notdeleted = 0;
        $also_delete_user = true;

        require_once(ABSPATH . 'wp-admin/includes/user.php' );

        foreach ($ids as $id) {
            if( is_numeric($id) ){

                $wp_uid = $this->getWPuidByOuruid($id);

                if( $this->deleteUserRecords($id , $also_delete_user ) ){
                    if ( ! wp_delete_user($wp_uid)){
                        $notdeleted += 1;
                    }
                }else{
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

    function deleteUserRecords($uid , $is_delete_user = false ){
        if(! is_numeric($uid))
            return false;
        $db = new jsvehiclemanagerdb();
        $model = JSVEHICLEMANAGERincluder::getJSModel('vehicle');

        $query = "SELECT id FROM `#__js_vehiclemanager_vehicles` WHERE uid = ".$uid;
        $db->setQuery($query);
        $data = $db->loadObjectList();

        $str = '';
        if($is_delete_user){
            $str = ' , user ';
        }
        do_action('jsvm_addon_deletequery_for_user');
        $query = "DELETE  veh ". jsvehiclemanager::$_addon_query['select'] . $str . "
            FROM `#__js_vehiclemanager_users` AS user LEFT JOIN `#__js_vehiclemanager_vehicles` AS veh ON veh.uid = user.id "
            . jsvehiclemanager::$_addon_query['join'] . "
            WHERE user.id = " . $uid;
        $db->setQuery($query);
        if($db->query()){
            do_action('reset_jsvm_aadon_query');
            foreach ($data as $key) {
                $model->removeVehicleImages($key->id);
            }
            return true;
        }else{
            return false;
        }
    }

    function getUserIDByWPUid($wpuid) {
        if (!is_numeric($wpuid))
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT id FROM `#__js_vehiclemanager_users` WHERE uid = " . $wpuid;
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }

    function getWPuidByOuruid($our_uid) {
        if (!is_numeric($our_uid))
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT uid FROM `#__js_vehiclemanager_users` WHERE id = " . $our_uid;
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }

    function getSellerListAjax() {
        check_ajax_referer( 'wp_js_vm_nonce_check', 'wpnoncecheck' );
        $userlimit = JSVEHICLEMANAGERrequest::getVar('userlimit', null, 0);
        $maxrecorded = 3;
        //Filters
        $name = JSVEHICLEMANAGERrequest::getVar('name');
        $email = JSVEHICLEMANAGERrequest::getVar('email');

        $db = new jsvehiclemanagerdb();

        jsvehiclemanager::$_data['filter']['name'] = $name;
        jsvehiclemanager::$_data['filter']['email'] = $email;

        $inquery = "";
        if ($name != null) {
            $inquery .= " AND user.name LIKE '%$name%' ";
        }
        if ($email != null)
            $inquery .= " AND user.email LIKE '%$email%' ";

        $query = "SELECT COUNT(user.id) FROM `#__js_vehiclemanager_users` AS user WHERE user.status = 1 ";
        $query .= $inquery;

        $db->setQuery($query);
        $total = $db->loadResult();
        $limit = $userlimit * $maxrecorded;
        if ($limit >= $total) {
            $limit = 0;
        }

        //Data
        $query = "SELECT user.name, user.email, user.id, user.uid
            FROM `#__js_vehiclemanager_users` AS user
            WHERE user.status = 1 ";
        $query .= $inquery;
        $query .= " ORDER BY user.id ASC LIMIT $limit, $maxrecorded";
        $db->setQuery($query);
        $users = $db->loadObjectList();

        $html = $this->makeUserList($users, $total, $maxrecorded, $userlimit);
        return $html;
    }

    function getUserListAjax() {
        check_ajax_referer( 'wp_js_vm_nonce_check', 'wpnoncecheck' );
        $userlimit = JSVEHICLEMANAGERrequest::getVar('userlimit', null, 0);
        $maxrecorded = 3;
        //Filters
        $name = JSVEHICLEMANAGERrequest::getVar('name');
        $email = JSVEHICLEMANAGERrequest::getVar('email');

        $db = new jsvehiclemanagerdb();

        jsvehiclemanager::$_data['filter']['name'] = $name;
        jsvehiclemanager::$_data['filter']['email'] = $email;

        $inquery = "";
        if ($name != null) {
            $inquery .= " AND user.display_name LIKE '%$name%' ";
        }
        if ($email != null)
            $inquery .= " AND user.user_email LIKE '%$email%' ";

        $query = "SELECT COUNT(user.ID)
                    FROM `#__users` AS user
                    WHERE user.id NOT IN (SELECT uid FROM `#__js_vehiclemanager_users` ) ";
        $query .= $inquery;

        $db->setQuery($query);
        $total = $db->loadResult();
        $limit = $userlimit * $maxrecorded;
        if ($limit >= $total) {
            $limit = 0;
        }

        //Data
        $query = "SELECT user.display_name AS name, user.user_email AS email, user.ID AS id
                    FROM `#__users` AS user
                    WHERE user.id NOT IN (SELECT uid FROM `#__js_vehiclemanager_users`)  ";
        $query .= $inquery;
        $query .= " ORDER BY user.id ASC LIMIT $limit, $maxrecorded";
        $db->setQuery($query);
        $users = $db->loadObjectList();

        $html = $this->makeUserList($users, $total, $maxrecorded, $userlimit);
        return $html;
    }

    function makeUserList($users, $total, $maxrecorded, $userlimit , $assignrole = false) {
        $html = '';
        if (!empty($users)) {
            if (is_array($users)) {

                $html .= '
                    <div id="jsvm_records">';
                $html .='
                <div id="jsvm_user-list-header">
                    <div class="jsvm_user-id">' . __('ID', 'js-vehicle-manager') . '</div>
                    <div class="jsvm_user-name">' . __('Name', 'js-vehicle-manager') . '</div>
                    <div class="jsvm_user-email">' . __('Email Address', 'js-vehicle-manager') . '</div>
                </div>';

                foreach ($users AS $user) {
                    $html .='
                        <div class="jsvm_user-records-wrapper" >
                            <div class="jsvm_user-id">
                                ' . $user->id . '
                            </div>
                            <div class="jsvm_user-name">
                                <a href="#" class="jsvm_js-userpopup-link" data-semail="'.$user->email.'" data-sid="' . $user->id .'" data-sname="' . $user->name .'" >' . $user->name . '</a>
                            </div>
                            <div class="jsvm_user-email">
                                ' . $user->email . '
                            </div>
                        </div>';
                }
            }
            $num_of_pages = ceil($total / $maxrecorded);
            $num_of_pages = ($num_of_pages > 0) ? ceil($num_of_pages) : floor($num_of_pages);
            if ($num_of_pages > 0) {
                $page_html = '';
                $prev = $userlimit;
                if ($prev > 0) {
                    $page_html .= '<a class="jsvm_jsst_userlink" href="#" onclick="updateuserlist(' . ($prev - 1) . ');">' . __('Previous', 'js-vehicle-manager') . '</a>';
                }
                for ($i = 0; $i < $num_of_pages; $i++) {
                    if ($i == $userlimit)
                        $page_html .= '<span class="jsvm_jsst_userlink selected" >' . ($i + 1) . '</span>';
                    else
                        $page_html .= '<a class="jsvm_jsst_userlink" href="#" onclick="updateuserlist(' . $i . ');">' . ($i + 1) . '</a>';
                }
                $next = $userlimit + 1;
                if ($next < $num_of_pages) {
                    $page_html .= '<a class="jsvm_jsst_userlink" href="#" onclick="updateuserlist(' . $next . ');">' . __('Next', 'js-vehicle-manager') . '</a>';
                }
                if ($page_html != '') {
                    $html .= '<div class="jsvm_jsst_userpages">' . $page_html . '</div>';
                }
            }
        } else {
            $html = JSVEHICLEMANAGERlayout::getAdminPopupNoRecordFound();
        }
        $html .= '</div>';
        return $html;
    }

    function getAutoGeneratedUserData($profileid){
        if(!is_numeric($profileid))
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT name,email,created,uid,id,hash  FROM `#__js_vehiclemanager_users`
                WHERE id = ".$profileid ." AND autogenerated = 1 ";
        $db->setQuery($query);
        $result = $db->loadObject();
        if($result == ''){
            return false;
        }else{
            return $result;
        }
    }

    function getSellersbyCities($pageid) {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT city.id AS cityid, city.name AS cityname, COUNT(DISTINCT user.id) AS totaluserbycity,country.name AS countryname, state.name AS statename
                    FROM `#__js_vehiclemanager_users` AS user
                    JOIN `#__js_vehiclemanager_vehicles` As veh ON veh.uid = user.id
                    JOIN `#__js_vehiclemanager_cities` AS city ON city.id = user.cityid
                    JOIN `#__js_vehiclemanager_countries` AS country ON country.id = city.countryid
                    LEFT JOIN `#__js_vehiclemanager_states` AS state ON state.id = city.stateid
                    WHERE country.enabled = 1 AND city.enabled = 1 AND user.status = 1
                    GROUP BY cityname ORDER BY cityname";
        $db->setQuery($query);
        jsvehiclemanager::$_data[0] = $db->loadObjectList();
        return ;
    }

    function getCoordinatesOfCities($pageid){
        $db = new jsvehiclemanagerdb();
        $query = "SELECT user.id, user.name, user.email, user.weblink, user.photo, user.cityid,user.latitude,user.longitude
                        FROM `#__js_vehiclemanager_users` AS user
                        JOIN `#__js_vehiclemanager_vehicles` As veh ON veh.uid = user.id
                        WHERE user.status = 1 GROUP BY user.id";
        $db->setQuery($query);
        $data = $db->loadObjectList();
        //echo '<pre>';print_r($data);die('asd');
        $final_array= array();
        $i = 1;
        $control_array = array();
        foreach($data AS $row){
            $html = '';
            if(is_numeric($row->latitude) && is_numeric($row->longitude) ){
                if($row->photo == ''){
                    $imgpath = CAR_MANAGER_IMAGE."/default-images/profile-image.png";
                }else{
                    $imgpath = $row->photo;
                }
                if($row->weblink == ''){
                    $email = $row->email;
                }else{
                    $email = $row->weblink;
                }
                $title = $row->name;
                $vlink = jsvehiclemanager::makeUrl(array('jsvmme'=>'user', 'jsvmlt'=>'viewsellerinfo', 'jsvehiclemanagerid'=>$row->id , 'jsvehiclemanagerpageid' => $pageid ));
                $html .= '<a class="jsvm_seller-detail-map-wrapper" href="'.$vlink.'" >
                                <div class="jsvm_vdm-image-wrapper" >
                                    <img class="jsvm_vdm-image" src="'.$imgpath.'" />
                                </div>
                                <div class="jsvm_vdm-top-portion" >
                                    '.$title.'
                                </div>
                                <div class="jsvm_vdm-bottom-portion" >
                                        '.$email.'
                                </div>
                          </a>';
                $link = jsvehiclemanager::makeUrl(array('jsvmme'=>'user', 'jsvmlt'=>'sellerlist', 'cityid'=>$row->cityid , 'jsvehiclemanagerpageid' => $pageid ));
                $img =     CAR_MANAGER_IMAGE.'/seller-location-icons/loction-mark-icon-'.$i.'.png';
                $final_array[] = array('lat' => $row->latitude, 'lng' => $row->longitude ,'link' => $link, 'img' => $img, 'ibox' => $html);
                $i ++;
                if($i > 10){
                    $i = 1;
                }
            }
        }
        $jfinal_array = json_encode($final_array);
        jsvehiclemanager::$_data['coordinates'] = $jfinal_array;

    }

    function getMessagekey(){
        $key = 'users';if(is_admin()){$key = 'admin_'.$key;}return $key;
    }

    function getUserStats($uid){
        $db = new jsvehiclemanagerdb();
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicles` WHERE uid = " . $uid;
        $db->setQuery($query);
        jsvehiclemanager::$_data['totalvehicles'] = $db->loadResult();
        jsvehiclemanager::$_data['featuredvehicles'] = apply_filters('jsvm_featuredvehicle_for_userprofile',0,$uid);
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicles` WHERE uid = " . $uid. " AND adexpiryvalue < CURDATE() ";
        $db->setQuery($query);
        jsvehiclemanager::$_data['expiredvehicles'] = $db->loadResult();
        jsvehiclemanager::$_data['featuredexpiredvehicles'] = apply_filters('jsvm_expirefeatured_for_userstats',0,$uid);
    }

    function captchaValidate() {
        if (JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()) {
            if( JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('recaptcha_registrationform') == 1){
                $gresponse = $_POST['g-recaptcha-response'];
                $resp = googleRecaptchaHTTPPost( JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('recaptcha_privatekey') , $gresponse);
                if ($resp) {
                    return true;
                } else {
                    jsvehiclemanager::$_data['google_captchaerror'] = __("Invalid captcha","js-vehicle-manager");
                    return false;
                }
            }
        }
        return true;
    }

    function insertNewUserForApp(){
	    $user_login = $_POST["jsvm_user_login"];
            $user_email = $_POST["jsvm_user_email"];
            $user_first = $_POST["jsvm_user_first"];
            $user_last = $_POST["jsvm_user_last"];
            $user_pass = $_POST["jsvm_user_pass"];
            $pass_confirm = $_POST["jsvm_user_pass_confirm"];
            $error_msg = array();

            if (username_exists($user_login)) {
                // Username already registered
                jsvehiclemanager_errors()->add('username_unavailable', __('Username already taken', 'js-vehicle-manager'));
            }
            if (!validate_username($user_login)) {
                // invalid username
                jsvehiclemanager_errors()->add('username_invalid', __('Invalid username', 'js-vehicle-manager'));
            }
            if ($user_login == '') {
                // empty username
                jsvehiclemanager_errors()->add('username_empty', __('Please enter a username', 'js-vehicle-manager'));
            }
            if (!is_email($user_email)) {
                //invalid email
                jsvehiclemanager_errors()->add('email_invalid', __('Invalid email', 'js-vehicle-manager'));
            }
            if (email_exists($user_email)) {
                //Email address already registered
                jsvehiclemanager_errors()->add('email_used', __('Email already registered', 'js-vehicle-manager'));
            }
            if ($user_pass == '') {
                // passwords do not match
                jsvehiclemanager_errors()->add('password_empty', __('Please enter a password', 'js-vehicle-manager'));
            }
            if ($user_pass != $pass_confirm) {
                // passwords do not match
                jsvehiclemanager_errors()->add('password_mismatch', __('Passwords do not match', 'js-vehicle-manager'));
            }

            $errors = jsvehiclemanager_errors()->get_error_messages();

            // only create the user in if there are no errors
            if (empty($errors)) {
                $new_user_id = wp_insert_user(array(
                    'user_login' => $user_login,
                    'user_pass' => $user_pass,
                    'user_email' => $user_email,
                    'first_name' => $user_first,
                    'last_name' => $user_last,
                    'user_registered' => date_i18n('Y-m-d H:i:s'),
                    'role' => 'subscriber'
                    )
                );
                if ($new_user_id) {
                    // send an email to the admin alerting them of the registration
                    wp_new_user_notification($new_user_id);
                    // log the new user in
                    wp_set_current_user($new_user_id, $user_login);
                    wp_set_auth_cookie($new_user_id);
                    do_action('wp_login', $user_login);


                    // insert entry into out db also

                    //$url = '';
                    $data = JSVEHICLEMANAGERrequest::get('post');
                    $data['uid'] = $new_user_id;
                    $data['name'] = $user_first.' '.$user_last;
                    $data['email'] = $user_email;
                    $data['created'] = date_i18n('Y-m-d H:i:s');
                    $data['status'] = 1;
                    $data['id'] = '';
                    JSVEHICLEMANAGERincluder::getJSModel('user')->storeProfile($data);
                    $pageid = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('register_user_redirect_page');
                    $url = home_url();
                    if(is_page($pageid)){
                        if(get_post_status($pageid) == 'publish'){
                            $url = get_the_permalink($pageid);
                        }
                    }           $error_msg['updated'] = __('User Added Successfully', 'js-vehicle-manager');
                        $data['id'] = $row->id;

                        $return_data['data']= $data;
                        $return_data['error']= $error_msg;
                        return $return_data;
                    // send the newly created user to the home page or configured page after logging them in
                    //echo $url;
                    exit;

                }
            }
            return json_encode(compact('data','error_msg'));
        }

        function authenticateUserLoginForApp(){
            $upassword = $_POST['jsvmapp-password'];
            $uusername = $_POST['jsvmapp-username'];
            $res = wp_authenticate($uusername,$upassword);
            if(get_class($res) == 'WP_User'){
               $code = '1';
            }else{
               $code = '0';
            }
            $data = array();

            if($code == '1'){
                $data = $this->getUserDataFromUserName($uusername);
            }

            $return_data['data'] = $data;
            $return_data['userverfified'] = $code;
            return $return_data;
            exit;
        }

        function getUserDataFromUserName($username){
            $db = new jsvehiclemanagerdb();
            do_action("jsvm_query_data_for_socialcheck");
            $query = "SELECT user.id, name, cell, phone, email, weblink, status, ". jsvehiclemanager::$_addon_query['select'] ." photo, cityid, latitude, longitude
                        , description, videotypeid, video, facebook, twitter, linkedin, googleplus, pinterest
                        , instagram, reddit, created, params "
                    . " FROM #__js_vehiclemanager_users AS user "
                    . " JOIN #__users AS u ON u.ID = user.uid "
                    . " WHERE u.user_login = '" . $username ."'";
            do_action("reset_jsvm_aadon_query");
            $db->setQuery($query);
            $result = $db->loadObject();
            return $result;
        }

}
?>
