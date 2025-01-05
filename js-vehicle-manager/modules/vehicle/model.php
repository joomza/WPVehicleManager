<?php
if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERvehicleModel {

    function getVehiclebyId($id) {
        if (is_numeric($id) == false)
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT vehicle.* , user.*
                    FROM `#__js_vehiclemanager_vehicles` AS vehicle
                    JOIN `#__js_vehiclemanager_users` AS user ON user.id = vehicle.uid
                    WHERE vehicle.id = " . $id;
        $db->setQuery($query);
        jsvehiclemanager::$_data[0] = $db->loadObject();
        return;
    }

    function sorting() {
        jsvehiclemanager::$_data['sorton'] = jsvehiclemanager::$_search['vehicle']['sorton'];
        jsvehiclemanager::$_data['sortby'] = jsvehiclemanager::$_search['vehicle']['sortby'];
        switch (jsvehiclemanager::$_data['sorton']) {
            case 6: // created
                $sort_string = ' veh.created ';
                break;
            case 2: // price
                $sort_string = ' veh.price ';
                break;
            case 3: // transmission
                $sort_string = ' transmission.title ';
                break;
            case 4: //fuel
                $sort_string = ' fueltype.title ';
                break;
            case 5: // model year
                $sort_string = ' modelyear.title ';
                break;
            case 1: // make
                $sort_string = ' make.title ';
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

    function getAllVehicles($datafor) {
        // sorting
        $sort_string = $this->sorting();
        // DB Object
        $db = new jsvehiclemanagerdb();
        // Filter
        $status = jsvehiclemanager::$_search['vehicle']['status'];
        $isgfcombo = jsvehiclemanager::$_search['vehicle']['isgfcombo'];
        $condition = jsvehiclemanager::$_search['vehicle']['condition'];
        $transmission = jsvehiclemanager::$_search['vehicle']['transmission'];
        $fueltype = jsvehiclemanager::$_search['vehicle']['fueltype'];
        $mileage = jsvehiclemanager::$_search['vehicle']['mileage'];
        $make = jsvehiclemanager::$_search['vehicle']['make'];
        $model = jsvehiclemanager::$_search['vehicle']['model'];
        $pricestrat = jsvehiclemanager::$_search['vehicle']['pricestrat'];
        $priceend = jsvehiclemanager::$_search['vehicle']['priceend'];

        $uid = jsvehiclemanager::$_search['vehicle']['uid'];
        if($uid=='' )
        {
           $uid = JSVEHICLEMANAGERrequest::getVar('uid');
        }
        $formsearch = JSVEHICLEMANAGERrequest::getVar('JSVEHICLEMANAGER_form_search', 'post');

        /*
            $isgfcombo
            1 - for all
            2 - for feature
        */
        $curdate = date('Y-m-d');
        do_action('jsvm_featuredvehicle_vehiclelist_admin_query_data',0,0);
        do_action('jsvm_vehiclelist_querydata_for_sold','veh');
        if($datafor == 1){
            $status_opr = (is_numeric($status)) ? ' = '.$status : ' <> 0 ';
            $inquery = " WHERE veh.status".$status_opr;
            switch ($isgfcombo) {
                case '1':
                    // get all
                break;
                case '2':
                    $inquery .= jsvehiclemanager::$_addon_query['where'];
                break;
            }
        }else{ // For Queue
            switch ($isgfcombo) {
                case '1':
                    $inquery = " WHERE (veh.status = 0 " . jsvehiclemanager::$_addon_query['where'] ." ) ";
                break;
                case '2':
                    $inquery = " WHERE " . jsvehiclemanager::$_addon_query['where'];
                break;
                default:
                    $inquery = " WHERE (veh.status = 0 " . jsvehiclemanager::$_addon_query['where'] ." ) ";
                break;
            }
        }
        if (is_numeric($condition)){
            $inquery .= " AND veh.conditionid = " . $condition;
        }
        if (is_numeric($transmission)){
            $inquery .= " AND veh.transmissionid = " . $transmission;
        }
        if (is_numeric($fueltype)){
            $inquery .= " AND veh.fueltypeid = " . $fueltype;
        }
        if (is_numeric($mileage)){
            $inquery .= " AND veh.speedmetertypeid = " . $mileage;
        }
        if (is_numeric($make)){
            $inquery .= " AND veh.makeid = " . $make;
        }
        if (is_numeric($model)){
            $inquery .= " AND veh.modelid = " . $model;
        }
        if (is_numeric($pricestrat)){
            $inquery .= " AND veh.price >= " . $pricestrat;
        }
        if (is_numeric($priceend)){
            $inquery .= " AND veh.price <= " . $priceend;
        }

        $seller_name = null;
        if (is_numeric($uid)){
            $inquery .= " AND veh.uid = " . $uid;

            $query = "SELECT name FROM `#__js_vehiclemanager_users` WHERE id = ".$uid;
            $db->setQuery($query);
            $name = $db->loadResult();
            $seller_name = json_encode(array(array('id' => $uid, 'name' => $name)));
        }

        jsvehiclemanager::$_data['filter']['uid'] = $uid;
        jsvehiclemanager::$_data['filter']['status'] = $status;
        jsvehiclemanager::$_data['filter']['isgfcombo'] = $isgfcombo;
        jsvehiclemanager::$_data['filter']['condition'] = $condition;
        jsvehiclemanager::$_data['filter']['transmission'] = $transmission;
        jsvehiclemanager::$_data['filter']['fueltype'] = $fueltype;
        jsvehiclemanager::$_data['filter']['mileage'] = $mileage;
        jsvehiclemanager::$_data['filter']['make'] = $make;
        jsvehiclemanager::$_data['filter']['model'] = $model;
        jsvehiclemanager::$_data['filter']['pricestrat'] = $pricestrat;
        jsvehiclemanager::$_data['filter']['priceend'] = $priceend;
        jsvehiclemanager::$_data['filter']['sellers'] = $seller_name;
        //pagination
        $query = "SELECT COUNT(veh.id)
                    FROM `#__js_vehiclemanager_vehicles` AS veh
                    JOIN `#__js_vehiclemanager_makes` AS make ON make.id = veh.makeid
                    JOIN `#__js_vehiclemanager_models` AS model ON model.id = veh.modelid
                    JOIN `#__js_vehiclemanager_users` AS user ON user.id = veh.uid
                    LEFT JOIN `#__js_vehiclemanager_conditions` AS cond ON cond.id = veh.conditionid
                    LEFT JOIN `#__js_vehiclemanager_transmissions` AS transmission ON transmission.id = veh.transmissionid
                    LEFT JOIN `#__js_vehiclemanager_mileages` AS mileage ON mileage.id = veh.speedmetertypeid ";
        $query .= $inquery;
        $db->setQuery($query);
        $total = $db->loadResult();
        jsvehiclemanager::$_data['total'] = $total;
        jsvehiclemanager::$_data[1] = JSVEHICLEMANAGERpagination::getPagination($total);

        //data
        $query = "SELECT veh.price, veh.uid, veh.created,  veh.cityfuelconsumption, veh.highwayfuelconsumption, veh.enginecapacity, veh.mileages, veh.status, veh.adexpiryvalue, veh.regcity, veh.loccity, " . jsvehiclemanager::$_addon_query['select'] ."
                    make.title AS maketitle, model.title AS modeltitle, cond.title AS conditiontitle, transmission.title AS transmissiontitle, fueltype.title AS fueltypetitle,
                    mileage.symbol AS mileagesymbol, currency.symbol AS currencysymbol,veh.id AS vehicleid,modelyear.title AS modelyeartitle
                    ,vehicleimage.filename as imagename,vehicleimage.file as filepath,veh.params
                    ,(SELECT COUNT(vim.id) FROM  `#__js_vehiclemanager_vehicleimages` AS vim WHERE vim.vehicleid=veh.id ) AS totalimages
                    ,veh.isdiscount, veh.discountstart, veh.discountend, veh.discounttype, veh.discount
                    ,user.photo AS sellerphoto , user.id AS sellerid, user.name AS sellername, cond.color AS conditioncolor
                    FROM `#__js_vehiclemanager_vehicles` AS veh
                    JOIN `#__js_vehiclemanager_makes` AS make ON make.id = veh.makeid
                    JOIN `#__js_vehiclemanager_models` AS model ON model.id = veh.modelid
                    JOIN `#__js_vehiclemanager_users` AS user ON user.id = veh.uid
                    LEFT JOIN `#__js_vehiclemanager_conditions` AS cond ON cond.id = veh.conditionid
                    LEFT JOIN `#__js_vehiclemanager_transmissions` AS transmission ON transmission.id = veh.transmissionid
                    LEFT JOIN `#__js_vehiclemanager_mileages` AS mileage ON mileage.id = veh.speedmetertypeid
                    LEFT JOIN `#__js_vehiclemanager_fueltypes` AS fueltype ON fueltype.id = veh.fueltypeid
                    LEFT JOIN `#__js_vehiclemanager_currencies` AS currency ON currency.id = veh.currencyid
                    LEFT JOIN `#__js_vehiclemanager_vehicleimages` AS vehicleimage ON vehicleimage.vehicleid = veh.id AND vehicleimage.isdefault = 1
                    LEFT JOIN `#__js_vehiclemanager_modelyears` AS modelyear ON modelyear.id = veh.modelyearid ";
        $query .= $inquery;
        $query .= " ORDER BY ".$sort_string;
        $query .= " LIMIT " . JSVEHICLEMANAGERpagination::$_offset . ", " . JSVEHICLEMANAGERpagination::$_limit;

        $db->setQuery($query);
        $vehicles = $db->loadObjectList();
        foreach ($vehicles as $vehicle) {
            $vehicle->location = JSVEHICLEMANAGERincluder::getJSModel('city')->getLocationDataForView($vehicle->loccity);
        }
        do_action('reset_jsvm_aadon_query');
        jsvehiclemanager::$_data[0] = $vehicles;

        return;
    }

    function approveQueueVehicle( $id ) {
        if (is_numeric($id) == false)
            return false;
        $row = JSVEHICLEMANAGERincluder::getJSTable('vehicle');
        if (!$row->update(array('id' => $id, 'status' => 1))) {
            return JSVEHICLEMANAGER_APPROVE_ERROR;
        }
        JSVEHICLEMANAGERincluder::getJSModel('emailtemplate')->sendMail(1 , 3 , $id);
        return JSVEHICLEMANAGER_APPROVED;
    }

    function rejectQueueVehicle( $id ) {
        if (is_numeric($id) == false)
            return false;
        $row = JSVEHICLEMANAGERincluder::getJSTable('vehicle');
        if (!$row->update(array('id' => $id, 'status' => -1))) {
            return JSVEHICLEMANAGER_REJECT_ERROR;
        }
        JSVEHICLEMANAGERincluder::getJSModel('emailtemplate')->sendMail(1 , 3 , $id);
        return JSVEHICLEMANAGER_REJECTED;
    }

    function approveQueueAllVehicleModel( $id ) {

        if (!is_numeric($id))
            return false;

        $result = $this->approveQueueVehicle($id);
        $result = apply_filters('jsvm_approvalqueue_approve_feature',$id);
        if($result)
            $result = JSVEHICLEMANAGER_APPROVED;
        return $result;
    }

    function rejectQueueAllVehicleModel( $id ) {

        if (!is_numeric($id))
            return false;

        $result = $this->rejectQueueVehicle($id);
        $result = apply_filters('jsvm_approvalqueue_reject_feature',$id);
        if($result)
            $result = JSVEHICLEMANAGER_REJECTED;
        return $result;
    }

    function getVehicleExpiryStatus($vehicleid) {
        if (!is_numeric($vehicleid))
            return false;
        $db = new jsvehiclemanagerdb();
        $curdate = date_i18n('Y-m-d');
        // sold vehicle handling
        $soldquery = " ";
        $soldflag = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('show_sold_vehicles');
        if($soldflag == 0){
            $soldquery = apply_filters('jsvm_sold_vehiclenotsold_data','','vehicle');
        }
        $query = "SELECT vehicle.id
        FROM `#__js_vehiclemanager_vehicles` AS vehicle
        WHERE vehicle.status = 1 AND DATE(vehicle.adexpiryvalue) >= DATE('" . $curdate . "')
        AND vehicle.id =" . $vehicleid;
        $query .= $soldquery;
        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result == null) {
            return false;
        } else {
            return true;
        }
    }

    function getIfVehicleOwner($vehicleid) {
        if (!is_numeric($vehicleid))
            return false;
        $uid = JSVEHICLEMANAGERincluder::getObjectClass('user')->uid();
        if(!is_numeric($uid)) return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT vehicle.id
        FROM `#__js_vehiclemanager_vehicles` AS vehicle
        WHERE vehicle.uid = " . $uid . "
        AND vehicle.id =" . $vehicleid;
        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result == null) {
            return false;
        } else {
            return true;
        }
    }


    function getVehicledetailbyId($id) {
        if (is_numeric($id) == false)
            return false;
        global $car_manager_options;
        $db = new jsvehiclemanagerdb();
        $fieldorderings = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getFieldsOrderingByFor(1);
        $f_main = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getVehiclesFieldsOrderingBySection(10);
        $f_sectionbody = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getVehiclesFieldsOrderingBySection(20);
        $f_sectiondrivetrain = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getVehiclesFieldsOrderingBySection(30);
        $f_sectionexterior = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getVehiclesFieldsOrderingBySection(40);
        $f_sectioninterior = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getVehiclesFieldsOrderingBySection(50);
        $f_sectionelectronics = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getVehiclesFieldsOrderingBySection(60);
        $f_sectionsafety = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getVehiclesFieldsOrderingBySection(70);
        $query = "SELECT vehicles.*,vehicletypes.title AS vehicletitle,
            makes.title maketitle,models.title AS modeltitle,modelyear.title AS modelyeartitle,
            fueltype.title AS fueltitle,cylinder.title AS cylindertitle, conditions.title AS conditiontitle,
            transmission.title AS transmissiontitle,currency.symbol AS currencysymbol,mileage.symbol AS mileagesymbol,
            fueltype.title AS fueltypetitle,user.name AS sellerinfoname,user.weblink AS sellerinfoweblink,
            user.cell AS sellerinfocell,user.phone AS sellerinfophone,user.email AS sellerinfoemail,user.description AS sellerdescription,user.latitude AS sellerlatitude,user.longitude AS sellerlongitude,user.videotypeid AS sellervideotypeid,user.video AS sellervideo,
            user.photo AS sellerphoto,user.cityid AS sellercityid,vehicles.isdiscount, vehicles.discountstart, vehicles.discountend, vehicles.discounttype, vehicles.discount
            FROM `#__js_vehiclemanager_vehicles` AS vehicles
            LEFT JOIN `#__js_vehiclemanager_vehicletypes` AS vehicletypes ON vehicles.vehicletypeid = vehicletypes.id
            LEFT JOIN `#__js_vehiclemanager_makes` AS makes ON vehicles.makeid =makes.id
            LEFT JOIN `#__js_vehiclemanager_models` AS models ON vehicles.modelid =  models.id
            LEFT JOIN `#__js_vehiclemanager_modelyears` AS modelyear ON vehicles.modelyearid = modelyear.id
            LEFT JOIN `#__js_vehiclemanager_conditions` AS conditions ON vehicles.conditionid = conditions.id
            LEFT JOIN `#__js_vehiclemanager_cylinders` AS cylinder ON vehicles.cylinderid = cylinder.id
            LEFT JOIN `#__js_vehiclemanager_transmissions` AS transmission ON transmission.id = vehicles.transmissionid
            LEFT JOIN `#__js_vehiclemanager_adexpiries` AS adexpiries ON vehicles.adexpiryid = adexpiries.id
            LEFT JOIN `#__js_vehiclemanager_currencies` AS currency ON currency.id = vehicles.currencyid
            LEFT JOIN `#__js_vehiclemanager_mileages` AS mileage ON mileage.id = vehicles.speedmetertypeid
            LEFT JOIN `#__js_vehiclemanager_fueltypes` AS fueltype ON fueltype.id = vehicles.fueltypeid
            LEFT JOIN `#__js_vehiclemanager_users` AS user ON user.id = vehicles.uid
            WHERE  vehicles.id = " . $id;
        $db->setQuery($query);
        $vehicle = $db->loadObject();
        if(!empty($vehicle)){
            $vehicle->locationcity = JSVEHICLEMANAGERincluder::getJSModel('city')->getLocationDataForView($vehicle->loccity);
            $vehicle->regicity = JSVEHICLEMANAGERincluder::getJSModel('city')->getLocationDataForView($vehicle->regcity);
            $vehicle->sellerlocation = JSVEHICLEMANAGERincluder::getJSModel('city')->getLocationDataForView($vehicle->sellercityid);
            $vehicle->images = $this->getVehicleImagesByVehicleId($id);
        }else{
            return '';
        }

        jsvehiclemanager::$_data[0] = $vehicle;
        jsvehiclemanager::$_data[4]['main'] = $f_main;
        jsvehiclemanager::$_data[4]['body'] = $f_sectionbody;
        jsvehiclemanager::$_data[4]['drivetrain'] = $f_sectiondrivetrain;
        jsvehiclemanager::$_data[4]['exterior'] = $f_sectionexterior;
        jsvehiclemanager::$_data[4]['interior'] = $f_sectioninterior;
        jsvehiclemanager::$_data[4]['electronics'] = $f_sectionelectronics;
        jsvehiclemanager::$_data[4]['safety'] = $f_sectionsafety;
        jsvehiclemanager::$_data['config'] = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigByFor(array('socialmedia','vehicledetail'));
        jsvehiclemanager::$_data['objectid'] = $id;
        jsvehiclemanager::$_data['fields'] = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getFieldsOrderingforView(1,10);
        jsvehiclemanager::$_data['listingfields'] = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getFieldsForListing(1);
        if(JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()){
            jsvehiclemanager::$_data['showcaptcha'] = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('recaptcha_vehicleform');
        }else{
            jsvehiclemanager::$_data['showcaptcha'] = 0;
        }
        // Related vehicles data
        if(jsvehiclemanager::$_car_manager_theme == 1){
            global $car_manager_options;
            $max = $car_manager_options['maximum_relatedvehicles'];
            $finalvehicles = array();

            foreach($car_manager_options['relatedvehicle_criteria_sorter']['enabled'] AS $key => $value){
                $inquery = '';
                switch($key){
                    case 'make':
                        if($vehicle->makeid != ''){
                            $inquery = ' vehicle.makeid = ' . $vehicle->makeid;
                        }
                    break;
                    case 'model':
                        if($vehicle->modelid != ''){
                            $inquery = ' vehicle.modelid = ' . $vehicle->modelid;
                        }
                    break;
                    case 'modelyear':
                        if($vehicle->modelyearid != ''){
                            $inquery = ' vehicle.modelyearid = ' . $vehicle->modelyearid;
                        }
                    break;
                    case 'condition':
                        if($vehicle->conditionid != ''){
                            $inquery = ' vehicle.conditionid = ' . $vehicle->conditionid;
                        }
                    break;
                    case 'location':
                        if($vehicle->loccity != ''){
                            $inquery = ' vehicle.loccity = ' . $vehicle->loccity;
                        }
                    break;
                    case 'transmission':
                        if($vehicle->transmissionid != ''){
                            $inquery = ' vehicle.transmissionid = ' . $vehicle->transmissionid;
                        }
                    break;
                    case 'fueltype':
                        if($vehicle->fueltypeid != ''){
                            $inquery = ' vehicle.fueltypeid = ' . $vehicle->fueltypeid;
                        }
                    break;
                }
                if(!empty($inquery)){
                    $query = "SELECT vehicle.id, vehicle.price, vehicle.isdiscount, vehicle.discountstart, vehicle.discountend, vehicle.discounttype, vehicle.discount, make.title AS maketitle, model.title AS modeltitle, modelyear.title AS modelyeartitle, vehicle.created, vehicle.cityfuelconsumption, vehicle.highwayfuelconsumption,
                                city.name AS cityname, country.name AS countryname, cond.title AS conditiontitle,cond.color AS conditioncolor, transmission.title AS transmissiontitle, fueltype.title AS fueltypetitle, vehicle.mileages, vehicle.enginecapacity, mileagetype.symbol AS mileagesymbol, currency.symbol AS currencysymbol, image.file, image.filename
                                FROM `#__js_vehiclemanager_vehicles` AS vehicle
                                JOIN `#__js_vehiclemanager_makes` AS make on make.id = vehicle.makeid
                                JOIN `#__js_vehiclemanager_models` AS model on model.id = vehicle.modelid
                                JOIN `#__js_vehiclemanager_modelyears` AS modelyear on modelyear.id = vehicle.modelyearid
                                JOIN `#__js_vehiclemanager_conditions` AS cond on cond.id = vehicle.conditionid
                                LEFT JOIN `#__js_vehiclemanager_vehicleimages` AS image on ( image.vehicleid = vehicle.id AND image.isdefault = 1 )
                                LEFT JOIN `#__js_vehiclemanager_currencies` AS currency on currency.id = vehicle.currencyid
                                LEFT JOIN `#__js_vehiclemanager_cities` AS city on city.id = vehicle.loccity
                                LEFT JOIN `#__js_vehiclemanager_countries` AS country on country.id = city.countryid
                                LEFT JOIN `#__js_vehiclemanager_transmissions` AS transmission on transmission.id = vehicle.transmissionid
                                LEFT JOIN `#__js_vehiclemanager_fueltypes` AS fueltype on fueltype.id = vehicle.fueltypeid
                                LEFT JOIN `#__js_vehiclemanager_mileages` AS mileagetype on mileagetype.id = vehicle.speedmetertypeid
                                WHERE CURDATE() <= DATE(vehicle.adexpiryvalue) AND ".$inquery." AND vehicle.id != $id LIMIT ".$max;
                    $db->setQuery($query);
                    $result = $db->loadObjectList();
                    $finalvehicles = array_merge($finalvehicles, $result);
                    //$finalvehicles = array_unique($finalvehicles);
                    $finalvehicles = array_map('unserialize', array_unique(array_map('serialize', $finalvehicles)));
                    if(COUNT($finalvehicles) >= $max){
                        break;
                    }
                }
            }
            jsvehiclemanager::$_data['relatedvehicles'] = $finalvehicles;
        }

        // update vehicle hits
        $query = "UPDATE `#__js_vehiclemanager_vehicles` SET hits = (hits + 1) WHERE id = ".$id;
        $db->setQuery($query);
        $db->query();
        return;
    }

    function getVehicleImagesByVehicleId($vehicleid){
        if( ! is_numeric($vehicleid))
            return '';
        $db = new jsvehiclemanagerdb();
        $query = "SELECT file,filename,isdefault FROM `#__js_vehiclemanager_vehicleimages` WHERE vehicleid = " . $vehicleid." ORDER BY isdefault DESC";
        $db->setQuery($query);
        $images = $db->loadObjectList();
        return $images;
    }

    function getVehicleImagesByVehicleIdAJAX(){
        check_ajax_referer( 'wp_js_vm_nonce_check', 'wpnoncecheck' );
        $vehicleid = JSVEHICLEMANAGERrequest::getVar('vehicleid');
        if( ! is_numeric($vehicleid)){
            return '';
        }
        $db = new jsvehiclemanagerdb();
        $query = "SELECT vim.file,vim.filename,mileage.symbol AS mileagesymbol, currency.symbol AS currencysymbol,veh.discounttype
                , transmission.title AS transmissiontitle, fueltype.title AS fueltypetitle,veh.mileages,veh.price,veh.discount,veh.discountstart,veh.discountend,veh.isdiscount
                FROM `#__js_vehiclemanager_vehicles` AS veh
                JOIN `#__js_vehiclemanager_vehicleimages` AS vim ON vim.vehicleid = veh.id
                LEFT JOIN `#__js_vehiclemanager_transmissions` AS transmission ON transmission.id = veh.transmissionid
                LEFt JOIN `#__js_vehiclemanager_mileages` AS mileage ON mileage.id = veh.speedmetertypeid
                LEFT JOIN `#__js_vehiclemanager_fueltypes` AS fueltype ON fueltype.id = veh.fueltypeid
                LEFT JOIN `#__js_vehiclemanager_currencies` AS currency ON currency.id = veh.currencyid
                WHERE vim.vehicleid = ".$vehicleid ." ORDER By vim.isdefault DESC ";
        $db->setQuery($query);
        $data = $db->loadObjectList();
        $count = 0;
        if(!empty($data)){
            foreach ($data as $veh) {
                if($count == 0){
                    $array_return['price'] = JSVEHICLEMANAGERincluder::getJSModel('common')->getPrice($veh->price,$veh->currencysymbol, $veh->isdiscount, $veh->discounttype, $veh->discount, $veh->discountstart, $veh->discountend);
                    $array_return['fueltype'] = $veh->fueltypetitle;
                    $array_return['transmissiontitle'] = $veh->transmissiontitle;
                    $array_return['milage'] = $veh->mileages.'/'.$veh->mileagesymbol;
                }
                $array_image['main'] = $veh->file.$veh->filename;
                $array_image['small'] = $veh->file.'s_'.$veh->filename;
                $array_return['image'][] = $array_image;
                $count++;

            }
        }
    return json_encode($array_return);
    }

    function validateFormData(&$data) {
        $canupdate = false;
        $db = new jsvehiclemanagerdb();
        if ($data['id'] == '') {
            $result = $this->isAlreadyExist($data['title']);
            if ($result == true) {
                return JSVEHICLEMANAGER_ALREADY_EXIST;
            } else {
                $query = "SELECT max(ordering) AS maxordering FROM `#__js_vehiclemanager_vehicles`";
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
            if ($data['JSVEHICLEMANAGER_isdefault'] == 1) {
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

    function getVehicleOptionsForStore($data){
        //field orderings
        $body = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getVehiclesFieldsOrderingBySection(20);
        $drivetrain = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getVehiclesFieldsOrderingBySection(30);
        $exterior = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getVehiclesFieldsOrderingBySection(40);
        $interior = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getVehiclesFieldsOrderingBySection(50);
        $electronics = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getVehiclesFieldsOrderingBySection(60);
        $safety = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getVehiclesFieldsOrderingBySection(70);

        foreach ($body as $field) {
            if($field->ordering != 0){
                if(isset($data[$field->field])){
                    $vehicleoptions['body'][$field->field] = 1;
                }
            }
        }
        foreach ($drivetrain as $field) {
            if($field->ordering != 0){
                if(isset($data[$field->field])){
                    $vehicleoptions['drivetrain'][$field->field] = 1;
                }
            }
        }
        foreach ($interior as $field) {
            if($field->ordering != 0){
                if(isset($data[$field->field])){
                    $vehicleoptions['interior'][$field->field] = 1;
                }
            }
        }
        foreach ($exterior as $field) {
            if($field->ordering != 0){
                if(isset($data[$field->field])){
                    $vehicleoptions['exterior'][$field->field] = 1;
                }
            }
        }
        foreach ($electronics as $field) {
            if($field->ordering != 0){
                if(isset($data[$field->field])){
                    $vehicleoptions['electronics'][$field->field] = 1;
                }
            }
        }
        foreach ($safety as $field) {
            if($field->ordering != 0){
                if(isset($data[$field->field])){
                    $vehicleoptions['safety'][$field->field] = 1;
                }
            }
        }
        if(!empty($vehicleoptions)){
            $j_string = json_encode($vehicleoptions);
        }else{
            $j_string = '';
        }
        return $j_string;
    }

    function captchaValidate() {
        if (JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()) {

            if( JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('recaptcha_vehicleform') == 1){
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


    function storeVehicle($data) {
        if (empty($data))
            return false;

        if ($data['id'] == '' && !JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()) {
            $usercanaddvehicle = apply_filters('jsvm_credits_user_can_addorfeatured_vehicle',true,$data['creditid'],'add_vehicle');
            if(!$usercanaddvehicle){
                return JSVEHICLEMANAGER_INVALID_REQUEST;
            }
        }
        if(JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()){
            if( $this->captchaValidate() == false){
                return 'RECAPTCHA_FAILED';
            }
        }

        if($data['sellerflag'] == 0){
            $seller = JSVEHICLEMANAGERrequest::getVar('seller');
            $seller['latitude']= $data['latitude1'];
            $seller['longitude']= $data['longitude1'];
            $seller['cityid']= $data['sellercityid'];
            $seller['photo'] = $_FILES['profilephoto']['name'];
            $seller['status'] = 1;
            $uid = JSVEHICLEMANAGERincluder::getJSModel('user')->storeProfile($seller,1);
            $data['sellerinfoid'] = $uid;
            $data['uid'] = $uid;
        }
        $config_array = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigByFor('vehicle');
        $row = JSVEHICLEMANAGERincluder::getJSTable('vehicle');
        $expiry_check = apply_filters("jsvm_credits_check_expiry_exists",0,'add_vehicle');
        if ($data['id'] == '') {
            $data['created'] = date_i18n('Y-m-d H:i:s');
            if( $expiry_check != 0){
                $expiry = apply_filters('jsvm_credits_get_expiry_in_days_forcredits',0,$data['creditid']);
                $data['adexpiryvalue'] = date('Y-m-d H:i:s',strtotime('+'.$expiry.' days') );
            }else{
                $adexpid = isset($data['adexpiryid']) ? $data['adexpiryid'] : '';
                $date = date_i18n('Y-m-d H:i:s');
                if($adexpid != '' && $adexpid > 0){
                    $db = new jsvehiclemanagerdb();
                    $query = "SELECT adexp.advalue ,adexp.type AS adtype
                    FROM `#__js_vehiclemanager_adexpiries` AS adexp
                    WHERE adexp.id=" . $adexpid;
                    $db->setQuery($query);
                    $adexp = $db->loadObject();
                    switch ($adexp->adtype) {
                        case 4: $adexp->adtype = 'year';
                            break;
                        case 3: $adexp->adtype = 'month';
                            break;
                        case 2: $adexp->adtype = 'week';
                            break;
                        case 1: $adexp->adtype = 'day';
                            break;
                    }
                    $date = strtotime(date("Y-m-d", strtotime($date)) . " +$adexp->advalue $adexp->adtype");
                }else{
                    $config_expirty = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('default_vehicle_expiry');
                    $date = strtotime(date("Y-m-d", strtotime($date)) . " +$config_expirty days");
                }
                $data['adexpiryvalue'] = date('Y-m-d H:i:s',$date);

            }
            if(is_admin()){
                $data['status'] = 1;
            }else{
                $data['status'] = $config_array['vehicle_auto_approve'];
            }
        }else{
            $row->load($data['id']);
            if(is_admin() || $expiry_check == 0){
                if($row->adexpiryid != $data['adexpiryid']){
                    $adexpid = isset($data['adexpiryid']) ? $data['adexpiryid'] : '';
                    $date = date_i18n('Y-m-d H:i:s');
                    if($adexpid != '' && $adexpid > 0){
                        $db = new jsvehiclemanagerdb();
                        $query = "SELECT adexp.advalue ,adexp.type AS adtype
                        FROM `#__js_vehiclemanager_adexpiries` AS adexp
                        WHERE adexp.id=" . $adexpid;
                        $db->setQuery($query);
                        $adexp = $db->loadObject();
                        switch ($adexp->adtype) {
                            case 4: $adexp->adtype = 'year';
                                break;
                            case 3: $adexp->adtype = 'month';
                                break;
                            case 2: $adexp->adtype = 'week';
                                break;
                            case 1: $adexp->adtype = 'day';
                                break;
                        }
                        $date = strtotime(date("Y-m-d", strtotime($date)) . " +$adexp->advalue $adexp->adtype");
                        $data['adexpiryvalue'] = date('Y-m-d H:i:s',$date);
                    }
                }
            }
        }

        if(isset($data['discountstart'])){
            $data['discountstart'] = date('Y-m-d H:i:s', strtotime($data['discountstart']));
        }
        if(isset($data['discountend'])){
            $data['discountend'] = date('Y-m-d H:i:s', strtotime($data['discountend']));
        }
        $vehicleoptions = array();
        $data = JSVEHICLEMANAGERincluder::getJSmodel('common')->stripslashesFull($data);// remove slashes with quotes.
        $data = JSVEHICLEMANAGERincluder::getJSModel('common')->getSanitizedFormData($data);
        $data['description'] = wp_filter_post_kses($_POST['vechiledescription']);
        $data['description'] = wpautop(wptexturize(stripslashes($data['description'])));

        //custom field code start
        $customflagforadd = false;
        $customflagfordelete = false;
        $custom_field_namesforadd = array();
        $custom_field_namesfordelete = array();
        $userfield = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getUserfieldsfor(1);
        $params = array();
        $maxfilesizeallowed = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('file_maximum_size');
        foreach ($userfield AS $ufobj) {
            $vardata = '';
            if($ufobj->userfieldtype == 'file'){
                if(isset($data[$ufobj->field.'_1']) && $data[$ufobj->field.'_1']== 0){
                    $vardata = $data[$ufobj->field.'_2'];
                }
                $customflagforadd=true;
                $custom_field_namesforadd[]=$ufobj->field;
            }else{
                $vardata = isset($data[$ufobj->field]) ? $data[$ufobj->field] : '';
            }
            if(isset($data[$ufobj->field.'_1']) && $data[$ufobj->field.'_1'] == 1){
                $customflagfordelete = true;
                $custom_field_namesfordelete[]= $data[$ufobj->field.'_2'];
                }
            if($vardata != ''){
                if(is_array($vardata)){
                    $vardata = implode(', ', $vardata);
                }
                $params[$ufobj->field] = htmlspecialchars($vardata);
            }
        }
        if($data['id'] != ''){
            if(is_numeric($data['id'])){
                $db = new jsvehiclemanagerdb();
                $query = "SELECT params FROM `#__js_vehiclemanager_vehicles` WHERE id = " . $data['id'];
                $db->setQuery($query);
                $oParams = $db->loadResult();
                if(!empty($oParams)){
                    $oParams = json_decode($oParams,true);
                    $unpublihsedFields = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getUserUnpublishFieldsfor(1);
                    foreach($unpublihsedFields AS $field){
                        if(isset($oParams[$field->field])){
                            $params[$field->field] = $oParams[$field->field];
                        }
                    }
                }
            }
            // vunerbilty removal
            $en_string = jsvehiclemanager::generateHash($data['id']);
            $hash = $this->getHashByVehicleId($data['vehicleid']);
            if($en_string != $hash ){
                return JSVEHICLEMANAGER_SAVE_ERROR;
            }
            if(in_array('featuredvehicle', jsvehiclemanager::$_active_addons)){
                unset($data['isfeaturedvehicle']);
                unset($data['startfeatureddate']);
                unset($data['endfeatureddate']);
            }
            if(!is_admin()){
                unset($data['uid']);
            }
        }


        $params = json_encode($params);
        $data['params'] = $params;
        //custom field code end
        if($data['id'] == ''){
            $make = JSVEHICLEMANAGERincluder::getJSModel('make')->getMakeTitlebyId($data['makeid']);
            $model = JSVEHICLEMANAGERincluder::getJSModel('model')->getModelTitlebyId($data['modelid']);
            $data['alias'] =  JSVEHICLEMANAGERincluder::getJSModel('common')->removeSpecialCharacter($make.' '.$model);
        }
        $data['vehicleoptions'] = $this->getVehicleOptionsForStore($data);
        if(!$data['id']){
            $data['vehicleid'] = $this->getVehicleID();
        }

        if (!$row->bind($data)) {
            return JSVEHICLEMANAGER_SAVE_ERROR;
        }
        if (!$row->store()) {
            return JSVEHICLEMANAGER_SAVE_ERROR;
        }
        $vehicleid = $row->id;
        $actionid = $data['creditid'];
        if ($data['id'] == '') {
            $en_string = jsvehiclemanager::generateHash($vehicleid);
            $row->update( array('id'=>$vehicleid,"hash"=>$en_string));
            do_action('jsvm_credits_update_user_action_creditslog',$actionid, $data['uid'] , $vehicleid, 1);
        }

        //delete images deleted by user
        if(isset($data['deleteimages'])){
            $deltearray = array_filter($data['deleteimages']);
            if(!empty($deltearray)){
                $this->deleteVehicleIamges($deltearray,$row->id);
            }
        }
        // upload new images
        if($_FILES['images']['error'][0] != 4){
            if(isset($data['removefile'])){
                $remove_files = $data['removefile'];
            }
            $this->storeVehicleImages($row->id,$remove_files);
        }
        // BROCHURE
        //remove if asked
        $db = new jsvehiclemanagerdb();
        if(isset($data['removebrochurefile']) && is_numeric($row->id)){
            $query = 'SELECT brochure FROM `#__js_vehiclemanager_vehicles` WHERE id='.$row->id;
            $db->setQuery($query);
            $file = $db->loadResult();
            $filename = basename($file);
            $wpdir = wp_upload_dir();
            $data_directory = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
            $path = $wpdir['basedir'] . '/' . $data_directory . '/data/vehicle/vehicle_' .$row->id.'/' ;
            $file = $path . $filename;
            unlink($file);
            $query = "UPDATE `#__js_vehiclemanager_vehicles` SET brochure = '' WHERE id=".$row->id;
            $db->setQuery($query);
            $db->query();
        }
        //upload
        if(isset($_FILES['brochure']['error'][0]) && $_FILES['brochure']['error'][0] != 4){
            $path = $this->storeVehicleBrochure($row->id);
            if($path != false){
                $query = "UPDATE `#__js_vehiclemanager_vehicles` SET brochure = '".$path."' WHERE id=".$row->id;
                $db->setQuery($query);
                $db->query();
            }
        }

        // Storing Attachments
        //removing custom field attachments
        if($customflagfordelete == true){
            foreach ($custom_field_namesfordelete as $key) {
                $res = $this->removeFileCustom($vehicleid,$key);
            }
        }
        //storing custom field attachments
        if($customflagforadd == true){
            foreach ($custom_field_namesforadd as $key) {
                if ($_FILES[$key]['size'] > 0) { // file
                    $res = $this->uploadFileCustom($vehicleid,$key);
                }
            }
        }

        //default implimentation in edit case
        $filename = '';
        if(isset($data['default_image_url']) && $data['default_image_url'] == 1){
            $filename = basename($data['default_image_name']);
            $filename = str_replace('ms_', '', $filename);// to remove suufix of size from file name
        }elseif($data['default_image_name'] != ''){
            $filename = $data['default_image_name'];// if files were uploaded now
        }
        if($filename != ''){
            $this->makeImageDefault($filename,$row->id);
        }
        if ($data['id'] == '') {
            if(JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()){
                JSVEHICLEMANAGERincluder::getJSModel('emailtemplate')->sendMail(1 , 5 , $vehicleid);
            }else{
                JSVEHICLEMANAGERincluder::getJSModel('emailtemplate')->sendMail(1 , 1 , $vehicleid);
            }
        }
        return JSVEHICLEMANAGER_SAVED;
    }

    function getHashByVehicleId($vehicleid) {
        $db = new jsvehiclemanagerdb();
        $query = "Select hash from `#__js_vehiclemanager_vehicles` WHERE vehicleid ='".$vehicleid."'";
        $db->setQuery($query);
        return $db->loadResult();
    }

    function getVehicleID() {
        $db = new jsvehiclemanagerdb();
        $query = "Select vehicleid from `#__js_vehiclemanager_vehicles`";
        do {

            $vehicleid = "";
            $length = 9;
            $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
            // we refer to the length of $possible a few times, so let's grab it now
            $maxlength = strlen($possible);
            // check for length overflow and truncate if necessary
            if ($length > $maxlength) {
                $length = $maxlength;
            }
            // set up a counter for how many characters are in the password so far
            $i = 0;
            // add random characters to $password until $length is reached
            while ($i < $length) {
                // pick a random character from the possible ones
                $char = substr($possible, mt_rand(0, $maxlength - 1), 1);
                // have we already used this character in $password?

                if (!strstr($vehicleid, $char)) {
                    if ($i == 0) {
                        if (ctype_alpha($char)) {
                            $vehicleid .= $char;
                            $i++;
                        }
                    } else {
                        $vehicleid .= $char;
                        $i++;
                    }
                }
            }
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            foreach ($rows as $row) {
                if ($vehicleid == $row->vehicleid)
                    $match = 'Y';
                else
                    $match = 'N';
            }
        }while ($match == 'Y');
        return $vehicleid;
    }

    function makeImageDefault($filename,$vehicleid){
        if(! is_numeric($vehicleid))
            return;
        $db = new jsvehiclemanagerdb();
        $query = "UPDATE  `#__js_vehiclemanager_vehicleimages` set isdefault = 1
                WHERE vehicleid = " . $vehicleid ." AND filename='".$filename."' ";
        $db->setQuery($query);
        if($db->query()){
            // to remove previous isdefault of that vehicle
            $query = "UPDATE  `#__js_vehiclemanager_vehicleimages` set isdefault = 0
                    WHERE vehicleid = " . $vehicleid ." AND filename <> '".$filename."' ";
            $db->setQuery($query);
            $db->query();
        }
        return;
    }
    // Custom Field File code
    function uploadFileCustom($id,$field){
        JSVEHICLEMANAGERincluder::getObjectClass('uploads')->storeCustomUploadFile($id,$field);
    }

    function storeUploadFieldValueInParams($vehicleid,$filename,$field){
        if( ! is_numeric($vehicleid))
            return;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT params FROM `#__js_vehiclemanager_vehicles` WHERE id = ".$vehicleid;
        $db->setQuery($query);
        $params = $db->loadResult();
        if(!empty($params)){
            $params = htmlspecialchars($params);
            $decoded_params = json_decode($params,true);

        }else{
            $decoded_params = array();
        }
        $decoded_params[$field] = $filename;
        $encoded_params = json_encode($decoded_params);
        $query = "UPDATE `#__js_vehiclemanager_vehicles` SET params = '" . $encoded_params . "' WHERE id = " . $vehicleid;
        $db->setQuery($query);
        $db->query();
        return;
    }

    function removeFileCustom($id,$key){
        $filename = str_replace(' ', '_', $key);
        $wpdir = wp_upload_dir();
        $data_directory = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
        $path = $wpdir['basedir'] . '/' . $data_directory . '/data/vehicle/vehicle_' .$id.'/' ;
        $userpath = $path.$filename;
        unlink($userpath);
        return ;
    }

    function getDownloadFileByName($file_name,$id){
        if(empty($file_name)) return false;
        if(!is_numeric($id)) return false;
        $seller = JSVEHICLEMANAGERrequest::getVar('seller');
        $filename = str_replace(' ', '_',$file_name);
        $wpdir = wp_upload_dir();
        $data_directory = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
        if($seller != 1){
            $path = $wpdir['basedir'] . '/' . $data_directory . '/data/vehicle/vehicle_' .$id.'/' ;
        }else{
            $path = $wpdir['basedir'] . '/' . $data_directory . '/data/profile/profile_' .$id.'/' ;
        }

        $file = $path . $filename;

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        //ob_clean();
        flush();
        readfile($file);
        exit();
        exit;
    }

    function deleteVehicleIamges($imgarray,$vehicleid) {
        $db = new jsvehiclemanagerdb();
        $row = JSVEHICLEMANAGERincluder::getJSTable('vehicleimage');
        foreach ($imgarray as $key => $val) {
            if(is_numeric($val)){
                $query = "SELECT vehimg.file,vehimg.filename,vehimg.filesize
                        FROM `#__js_vehiclemanager_vehicleimages` AS vehimg
                        WHERE vehimg.id = " . $val;
                $db->setQuery($query);
                $vehicleimage = $db->loadObject();
                // path to file so that it can be removed
                $wpdir = wp_upload_dir();
                $data_directory = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
                $path = $wpdir['basedir'] . '/' . $data_directory . '/data/vehicle/vehicle_' .$vehicleid.'/' ;
                if(!empty($vehicleimage)){
                    $filename = $path.$vehicleimage->filename;
                    unlink($filename);
                    $filename = $path.'l_'.$vehicleimage->filename;
                    unlink($filename);
                    $filename = $path.'m_'.$vehicleimage->filename;
                    unlink($filename);
                    $filename = $path.'ms_'.$vehicleimage->filename;
                    unlink($filename);
                    $filename = $path.'s_'.$vehicleimage->filename;
                    unlink($filename);
                    $filename = $path.'lw_'.$vehicleimage->filename;
                    unlink($filename);
                }
                $row->delete($val);
            }
        }
        return;
    }

    function storeVehicleBrochure($vehicleid) {
        $db = new jsvehiclemanagerdb();
        if(!is_numeric($vehicleid)) return false;
        $imageresult = JSVEHICLEMANAGERincluder::getObjectClass('uploads')->vehicleManagerUpload($vehicleid, $_FILES['brochure'], 5);
        return $imageresult;
    }

    function storeVehicleImages($vehicleid,$filestring) {
        $db = new jsvehiclemanagerdb();
        if(! is_numeric($vehicleid))
            return;
        //count images and check is allow to upload more image or not
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicleimages` WHERE vehicleid = " . $vehicleid;
        $db->setQuery($query);
        $totalimagesuploaded = $db->loadResult();
        $total = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('maximum_images_per_vehicle');
        $imagesremaing = $total - $totalimagesuploaded;
        $imagesremaing = ($imagesremaing < 0) ? 0 : $imagesremaing;
        $total = ($imagesremaing <= $total) ? $imagesremaing : $total;
        if ($total == 0) {
        } else {
            $files = array();
            foreach ($_FILES['images'] as $k => $l) {
                foreach ($l as $i => $v) {
                    if (!array_key_exists($i, $files))
                        $files[$i] = array();
                    $files[$i][$k] = $v;
                }
            }
            if(count($files) > $total){
                $files_a = array();
                for($i = 0; $i < $total; $i++){
                    $files_a[$i] = $files[$i];
                }
                $files = $files_a;
            }
            $db = new jsvehiclemanagerdb();
            $query = "SELECT max(id) FROM `#__js_vehiclemanager_vehicleimages` WHERE vehicleid = " . $vehicleid;
            $db->setQuery($query);
            $imageid = $db->loadResult();
            $query = "SELECT id FROM `#__js_vehiclemanager_vehicleimages` WHERE vehicleid = " . $vehicleid." AND isdefault = 1 ";
            $db->setQuery($query);
            $isdefault = $db->loadResult();
            if($isdefault == ''){
                $isdefault_flag = 1;
            }else{
                $isdefault_flag = 0;
            }

            $imageresult = array();
            foreach($files AS $file) {
                if(!empty($file['name'])){
                    if($filestring != ''){
                        if( !strstr($filestring, $file['name'])){
                            $imageresult[] = JSVEHICLEMANAGERincluder::getObjectClass('uploads')->vehicleManagerUpload($vehicleid, $file,4);
                        }
                    }else{
                        $imageresult[] = JSVEHICLEMANAGERincluder::getObjectClass('uploads')->vehicleManagerUpload($vehicleid, $file,4);
                    }
                }
            }
            $wpdir = wp_upload_dir();
            $data_directory = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
            $path = $wpdir['basedir'] . '/' . $data_directory . '/data/vehicle/vehicle_' .$vehicleid ;
            foreach ($imageresult as $image) {
                if(is_array($image) && !empty($image)){
                    $file_size = filesize($image[0]);
                    $temp_file_name = basename( $image[0] );
                    $image[1] = str_replace($temp_file_name, '', $image[1]);
                   // to add sufix of image s m l ms
                    $file_name = 'l_'.$temp_file_name;
                    $this->createThumbnail($file_name,1170,690,$path,$image[0]);
                    $file_name = 'lw_'.$temp_file_name;
                    $this->createThumbnail($file_name,1170,690,$path,$image[0],1,1);
                    $file_name = 'm_'.$temp_file_name;
                    $this->createThumbnail($file_name,867,511,$path,$image[0],1,1);//  one is for watermark flag
                    $file_name = 'ms_'.$temp_file_name;
                    $this->createThumbnail($file_name,500,295,$path,$image[0],1);
                    $file_name = 's_'.$temp_file_name;
                    $this->createThumbnail($file_name,280,165,$path,$image[0],1);
                    $this->storeVehicleImagesRecord($vehicleid,$image[1],$temp_file_name,$isdefault_flag,$file_size);
                    $isdefault_flag = 0;
                    $this->createThumbnail('',0,0,$path,$image[0],3,1);// 3 for not to crop or resize image 1 for ading watermark
                }
            }
        }
        return ;
    }

    function storeVehicleImagesRecord($vehicleid,$image,$name,$isdefault_flag,$filesize){
        if(is_numeric($vehicleid)){
            $row = JSVEHICLEMANAGERincluder::getJSTable('vehicleimage');
            $data['vehicleid'] = $vehicleid;
            $data['file'] = $image;
            $data['filename'] = $name;
            $data['filesize'] = $filesize;
            $data['isdefault'] = $isdefault_flag;
            $data['status'] = 1;
            $data['created'] = date_i18n('Y-m-d H:i:s');
            $row->bind($data);
            $row->store();
        }
    }


    function createThumbnail($filename,$width,$height,$path,$file = null,$crop_flag = 0,$watermark_flag = 0) {
        $handle = new JSVMupload($file);
        $parts = explode(".",$filename);
        $extension = end($parts);
        $filename = str_replace("." . $extension,"",$filename);
        if ($handle->uploaded) {
            if($crop_flag != 3){
                $handle->file_new_name_body   = $filename;
                $handle->image_resize         = true;
                $handle->image_x              = $width;
                $handle->image_y              = $height;
                $handle->image_ratio_fill     = true;
                global $car_manager_options;
                $handle->image_background_color = $car_manager_options['cm_slide_image_background_color'];
                if($crop_flag == 1){
                    $handle->image_ratio_crop     = true;
                    $handle->image_ratio          = true;
                }
            }else{
                $handle->file_auto_rename = false;
                $handle->file_overwrite = true;
            }
            // water mark implimentation
            if($watermark_flag == 1){
                $config_array = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigByFor('watermark');
                if($config_array['show_water_mark'] == 1 && $config_array['water_mark_img_name'] != '' ){
                    $wpdir = wp_upload_dir();
                    $data_directory = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
                    $handle->image_watermark = $wpdir['basedir'] . '/' . $data_directory . '/data/'.$config_array['water_mark_img_name'];
                    switch ($config_array['water_mark_position']) {
                        case 1:
                            $x = 10;
                            $y = 10;
                        break;
                        case 2:
                            $x = 10;
                            $y = -10;
                        break;
                        case 3:
                            $x = -10;
                            $y = 10;
                        break;
                        case 4:
                            $x = -10;
                            $y = -10;
                        break;
                        default:
                            $x = 10;
                            $y = -10;
                        break;
                    }
                    $handle->image_watermark_x = $x;
                    $handle->image_watermark_y = $y;
                }
            }

            $handle->process($path);
            @$handle->processed;
            // uncomment this code to check for error.
            // if ($handle->processed) {
            //     // opration successful
            // } else {
            //     echo 'error : ' . $handle->error;
            //     return false;
            // }
        }else{
            echo 'error : ' . $handle->error;
        }
    }

    function publishUnpublish($ids, $status) {
        if (empty($ids))
            return false;
        if (!is_numeric($status))
            return false;

        $row = JSVEHICLEMANAGERincluder::getJSTable('vehicle');
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
                    ( SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicles` WHERE id = " . $id . " AND isdefault = 1)
                    AS total";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total > 0)
            return false;
        else
            return true;
    }

    function vehicleCanDelete($id) {
        if (!is_numeric($id))
            return false;
        $db = new jsvehiclemanagerdb();
        $query = " SELECT
                    ( SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicles` WHERE vehicleid = " . $id . ")
                    + ( SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicles` WHERE id = " . $id . " AND isdefault = 1)
                    AS total";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total > 0)
            return false;
        else
            return true;
    }

    function getVehicleForCombo() {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT id, title AS text FROM `#__js_vehiclemanager_vehicles` WHERE status = 1 ORDER BY ordering ASC ";
        $db->setQuery($query);
        $ages = $db->loadObjectList();
        return $ages;
    }

    function isAlreadyExist($title) {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicles` WHERE title = '" . $title . "'";
        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result > 0)
            return true;
        else
            return false;
    }

    function getSortingForListing($ordering_ajax = '' , $sorting_ajax = '') {
        $ordering = JSVEHICLEMANAGERrequest::getVar('cmordring');
		$sorting = JSVEHICLEMANAGERrequest::getVar('cmsorting','',2);
        if($ordering_ajax != ''){
            $ordering = $ordering_ajax;
            $sorting = $sorting_ajax;
        }

        $sorting = (!$sorting) ? 1 : $sorting;
        $odering_query = '';
        switch ($ordering) {
            case '1':
            $odering_query .= " ORDER BY maketitle ";
            break;
            case '2':
            $odering_query .= " ORDER BY price ";
            break;
            case '3':
            $odering_query .= " ORDER BY transmissiontitle ";
            break;
            case '4':
            $odering_query .= " ORDER BY fueltypetitle ";
            break;
            case '5':
            $odering_query .= " ORDER BY modelyeartitle ";
            break;
            case '6':
            $odering_query .= " ORDER BY rate ";
            break;
            default:
            $odering_query .= " ORDER BY veh.created ";
            break;
        }

        if($sorting == 1){
            $odering_query .= ' ASC ';
        }else{
            $odering_query .= ' DESC ';
        }
        jsvehiclemanager::$_data['ordering_query'] = $odering_query;
        jsvehiclemanager::$_data['filter']['ordering'] = jsvehiclemanager::$_data['ordering'] = $ordering;
        jsvehiclemanager::$_data['filter']['sorting'] = jsvehiclemanager::$_data['sorting'] = $sorting;
        return;
    }

    function getVehicles($ajax_flag = 0 ){

        $id = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerid');
        if($id !='') {
            //parse id what is the meaning of it
            $array = explode('_', $id);
            $id = $array[1];
            $clue = $id[0] . $id[1];
            $id = substr($id, 2);
            jsvehiclemanager::$_data['vehiclesby'] = '';
            switch ($clue) {
                case '10':
                    $vars['conditionid'] = $id;
                    jsvehiclemanager::$_data['vehiclesby'] = __('by conditions','js-vehicle-manager');
                    break;
                case '11':
                    $vars['vehicletypeid'] = $id;
                    jsvehiclemanager::$_data['vehiclesby'] = __('by types','js-vehicle-manager');
                    break;
                case '12':
                    $vars['modelyearid'] = $id;
                    jsvehiclemanager::$_data['vehiclesby'] = __('by model year','js-vehicle-manager');
                    break;
                case '13':
                    $vars['cityid'] = $id;
                    jsvehiclemanager::$_data['vehiclesby'] = __('by city','js-vehicle-manager');
                    break;
                case '14':
                    $vars['makeid'] = $id;
                    jsvehiclemanager::$_data['vehiclesby'] = __('by make','js-vehicle-manager');
                    break;
                case '15':
                    $vars['modelid'] = $id;
                    jsvehiclemanager::$_data['vehiclesby'] = __('by model','js-vehicle-manager');
                    break;
                case '16':
                    $vars['sellerid'] = $id;
                    jsvehiclemanager::$_data['vehiclesby'] = __('by seller','js-vehicle-manager');
                    break;
            }
        }else{ // permalink is off
            jsvehiclemanager::$_data['vehiclesby'] = '';
            $id = JSVEHICLEMANAGERrequest::getVar('conditionid','get');
            if(is_numeric($id)){
                $vars['conditionid'] = $id;
                jsvehiclemanager::$_data['vehiclesby'] = __('by conditions','js-vehicle-manager');
            }
            $id = JSVEHICLEMANAGERrequest::getVar('vehicletypeid','get');
            if(is_numeric($id)){
                $vars['vehicletypeid'] = $id;
                jsvehiclemanager::$_data['vehiclesby'] = __('by types','js-vehicle-manager');
            }
            $id = JSVEHICLEMANAGERrequest::getVar('modelyearid','get');
            if(is_numeric($id)){
                $vars['modelyearid'] = $id;
                jsvehiclemanager::$_data['vehiclesby'] = __('by model year','js-vehicle-manager');
            }
            $id = JSVEHICLEMANAGERrequest::getVar('cityid','get');
            if(is_numeric($id)){
                $vars['cityid'] = $id;
                jsvehiclemanager::$_data['vehiclesby'] = __('by city','js-vehicle-manager');
            }
            $id = JSVEHICLEMANAGERrequest::getVar('makeid','get');
            if(is_numeric($id)){
                $vars['makeid'] = $id;
                jsvehiclemanager::$_data['vehiclesby'] = __('by make','js-vehicle-manager');
            }
            $id = JSVEHICLEMANAGERrequest::getVar('modelid','get');
            if(is_numeric($id)){
                $vars['modelid'] = $id;
                jsvehiclemanager::$_data['vehiclesby'] = __('by model','js-vehicle-manager');
            }
            $id = JSVEHICLEMANAGERrequest::getVar('sellerid','get');
            if(is_numeric($id)){
                $vars['sellerid'] = $id;
                jsvehiclemanager::$_data['vehiclesby'] = __('by seller','js-vehicle-manager');
            }
        }
        $inquery = '';
        if (isset($vars['conditionid']) && is_numeric($vars['conditionid'])) {
            $inquery .=  " AND veh.conditionid  = " . $vars['conditionid'];
            jsvehiclemanager::$_data['filter']['condition'][] = $vars['conditionid'];
        }
        if (isset($vars['vehicletypeid']) && is_numeric($vars['vehicletypeid'])) {
            $inquery .=  " AND veh.vehicletypeid  = " . $vars['vehicletypeid'];
            jsvehiclemanager::$_data['filter']['vehicletype'][] = $vars['vehicletypeid'];
        }
        if (isset($vars['modelyearid']) && is_numeric($vars['modelyearid'])) {
            $inquery .=  " AND veh.modelyearid  = " . $vars['modelyearid'];
            jsvehiclemanager::$_data['filter']['modelyear'][] = $vars['modelyearid'];
        }
        if (isset($vars['cityid']) && is_numeric($vars['cityid'])) {
            $inquery .=  " AND veh.loccity  = " . $vars['cityid'];
            jsvehiclemanager::$_data['filter']['locationcity'] = $vars['cityid'];
            jsvehiclemanager::$_data['filter']['locationcitypopup'] = JSVEHICLEMANAGERincluder::getJSModel('common')->getCitiesForFilter($vars['cityid']);
        }
        if (isset($vars['makeid']) && is_numeric($vars['makeid'])) {
            $inquery .=  " AND veh.makeid  = " . $vars['makeid'];
            jsvehiclemanager::$_data['filter']['make'][] = $vars['makeid'];
        }
        if (isset($vars['modelid']) && is_numeric($vars['modelid'])) {
            $inquery .=  " AND veh.modelid  = " . $vars['modelid'];
            jsvehiclemanager::$_data['filter']['model'][] = $vars['modelid'];
        }
        if (isset($vars['sellerid']) && is_numeric($vars['sellerid'])) {
            $inquery .=  " AND veh.uid  = " . $vars['sellerid'];
            jsvehiclemanager::$_data['filter']['sellerid'] = $vars['sellerid'];
        }
        jsvehiclemanager::$_data['sellerid'] = isset($vars['sellerid']) ? $vars['sellerid'] : '';
        jsvehiclemanager::$_data['filter']['issearch'] = 0;
        $jsvm_ord = '';
        $jsvm_sort = '';
        //-------------------------
        //previous
        /*if($inquery == ''){
            if($ajax_flag == 1){
                $data = json_decode(base64_decode(JSVEHICLEMANAGERrequest::getVar('ajaxsearch')) , true);
                $jsvm_ord = $data['ordering'];
                $jsvm_sort = $data['sorting'];
                $inquery = $this->getInqueryForPopUpSearch($data);
            }else{
                $data = JSVEHICLEMANAGERrequest::get('post');
            }
            if(isset($data['issearch']) && $data['issearch'] == 1){
                $inquery = $this->getInqueryForPopUpSearch($data);
            }
        }*/
        //latest
        if($ajax_flag == 1){
            $data = json_decode(base64_decode(JSVEHICLEMANAGERrequest::getVar('ajaxsearch')) , true);
            $jsvm_ord = $data['ordering'];
            $jsvm_sort = $data['sorting'];
            $inquery .= $this->getInqueryForPopUpSearch($data);
        }else{
            $data = JSVEHICLEMANAGERrequest::get('post');
        }
        if(isset($data['issearch']) && $data['issearch'] == 1){
            $inquery .= $this->getInqueryForPopUpSearch($data);
        }
        //-------------------------


        $this->getSortingForListing($jsvm_ord , $jsvm_sort);
        // sold vehicle handling
        $soldquery = " ";
        $soldflag = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('show_sold_vehicles');
        if($soldflag == 0){
            $soldquery = apply_filters('jsvm_sold_vehiclenotsold_data','','veh');
        }
        $db = new jsvehiclemanagerdb();
        //Pagination// added these becoz number of count is wrong
        $query = "SELECT COUNT(veh.id) AS total
                    FROM `#__js_vehiclemanager_vehicles` AS veh
                    JOIN `#__js_vehiclemanager_makes` AS make ON make.id = veh.makeid
                    JOIN `#__js_vehiclemanager_models` AS model ON model.id = veh.modelid
                    JOIN `#__js_vehiclemanager_users` AS user ON user.id = veh.uid
                    LEFT JOIN `#__js_vehiclemanager_conditions` AS cond ON cond.id = veh.conditionid
                    LEFT JOIN `#__js_vehiclemanager_transmissions` AS transmission ON transmission.id = veh.transmissionid
                    LEFT JOIN `#__js_vehiclemanager_mileages` AS mileage ON mileage.id = veh.speedmetertypeid
                    LEFT JOIN `#__js_vehiclemanager_fueltypes` AS fueltype ON fueltype.id = veh.fueltypeid
                    LEFT JOIN `#__js_vehiclemanager_currencies` AS currency ON currency.id = veh.currencyid
                    LEFT JOIN `#__js_vehiclemanager_modelyears` AS modelyear ON modelyear.id = veh.modelyearid
                    WHERE veh.status = 1 AND DATE(veh.adexpiryvalue) >= CURDATE() ";
        $query = $query.$soldquery;
        $query .= $inquery;
        $db->setQuery($query);
        $total = $db->loadResult();
        jsvehiclemanager::$_data['total'] = $total;
        jsvehiclemanager::$_data[1] = JSVEHICLEMANAGERpagination::getPagination($total);
        $featuredvehicles = apply_filters('jsvm_vehiclelist_get_featuredvehicles',$soldquery,$inquery);

        //vehicles
        $veh = 'veh';
        do_action('jsvm_vehiclelist_querydata_for_sold',$veh);
        do_action('jsvm_featuredvehicle_vehiclelist_admin_query_data','','');
        $query = "SELECT veh.id, veh.price, veh.created, veh.cityfuelconsumption, veh.highwayfuelconsumption, veh.enginecapacity, veh.mileages, veh.status, veh.adexpiryvalue, veh.regcity, veh.loccity,
                    make.title AS maketitle, model.title AS modeltitle, cond.title AS conditiontitle, transmission.title AS transmissiontitle, fueltype.title AS fueltypetitle,
                    mileage.symbol AS mileagesymbol, currency.symbol AS currencysymbol,veh.id AS vehicleid,modelyear.title AS modelyeartitle,veh.stocknumber
                    ,veh.exteriorcolor,veh.params,vehicleimage.filename as imagename,vehicleimage.file as filepath,". jsvehiclemanager::$_addon_query['select'] ."
                    (SELECT COUNT(vim.id) FROM `#__js_vehiclemanager_vehicleimages` AS vim WHERE vim.vehicleid=veh.id ) AS totalimages,cond.color AS conditioncolor
                    ,user.photo AS sellerphoto , user.id AS sellerid,veh.isdiscount, veh.discountstart, veh.discountend, veh.discounttype, veh.discount
                    FROM `#__js_vehiclemanager_vehicles` AS veh
                    JOIN `#__js_vehiclemanager_makes` AS make ON make.id = veh.makeid
                    JOIN `#__js_vehiclemanager_models` AS model ON model.id = veh.modelid
                    JOIN `#__js_vehiclemanager_users` AS user ON user.id = veh.uid
                    LEFT JOIN `#__js_vehiclemanager_conditions` AS cond ON cond.id = veh.conditionid
                    LEFT JOIN `#__js_vehiclemanager_transmissions` AS transmission ON transmission.id = veh.transmissionid
                    LEFT JOIN `#__js_vehiclemanager_mileages` AS mileage ON mileage.id = veh.speedmetertypeid
                    LEFT JOIN `#__js_vehiclemanager_fueltypes` AS fueltype ON fueltype.id = veh.fueltypeid
                    LEFT JOIN `#__js_vehiclemanager_currencies` AS currency ON currency.id = veh.currencyid
                    LEFT JOIN `#__js_vehiclemanager_modelyears` AS modelyear ON modelyear.id = veh.modelyearid
                    LEFT JOIN `#__js_vehiclemanager_vehicleimages` AS vehicleimage ON vehicleimage.vehicleid = veh.id AND vehicleimage.isdefault = 1
                    WHERE veh.status = 1 AND DATE(veh.adexpiryvalue) >= CURDATE() ";
        $query = $query.$soldquery;
        $query .= $inquery;
        $query .= jsvehiclemanager::$_data['ordering_query'];
        $query .= " LIMIT " . JSVEHICLEMANAGERpagination::$_offset . ", " . JSVEHICLEMANAGERpagination::$_limit;
        $db->setQuery($query);
        $vehicles = $db->loadObjectList();
        do_action('reset_jsvm_aadon_query');
        // to show unique vehicles(avoid dupilcation)
        // in array function may not work in this case
        if(is_array($featuredvehicles)){
            $vehicles_array = $featuredvehicles;
        }else{
            $vehicles_array = array();
        }
        foreach ($vehicles AS $simple) {
            $matched = 0;
            foreach ($vehicles_array AS $vehicle) {
                if($simple->id == $vehicle->id){
                    $matched = 1;
                }
            }
            if($matched == 0){
                $vehicles_array[] = $simple;
            }
        }
        $finalvehicles = $vehicles_array;
        foreach ($finalvehicles as $vehicle) {
            $vehicle->location = JSVEHICLEMANAGERincluder::getJSModel('city')->getLocationDataForView($vehicle->loccity);
        }
        jsvehiclemanager::$_data[0] = $finalvehicles;
        if(isset($_COOKIE['jsvm_comp_vehicle'])){
            $vehnum = json_decode( base64_decode($_COOKIE['jsvm_comp_vehicle']),true);
            $htmldata = array();
            jsvehiclemanager::$_data['json_data'] = apply_filters("jsvm_comparevehicle_vehicle_data_for_compare",$htmldata,$vehnum);
        }
        jsvehiclemanager::$_data['fields'] = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getFieldsOrderingforView(1,10);
        if(JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()){
            if(JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('recaptcha_contacttoseller') == 1 || JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('recaptcha_makeanoffer') == 1 || JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('recaptcha_scheduletestdrive') == 1 || JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('recaptcha_tellafriend') == 1){
                jsvehiclemanager::$_data['showcaptcha'] = 1;
            }else{
                jsvehiclemanager::$_data['showcaptcha'] = 0;
            }
        }else{
            jsvehiclemanager::$_data['showcaptcha'] = 0;
        }
        jsvehiclemanager::$_data['listingfields'] = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getFieldsForListing(1);
        return;
    }

    private function makeQueryFromArray($for, $array) {
        if (empty($array))
            return false;
        $qa = array();
        switch ($for) {
            case 'vehicletype':
                foreach ($array as $item) {
                    if (is_numeric($item)) {
                        $qa[] = " veh.vehicletypeid = " . $item;
                    }
                }
            break;
            case 'make':
                foreach ($array as $item) {
                    if (is_numeric($item)) {
                        $qa[] = " veh.makeid  = " . $item;
                    }
                }
            break;
            case 'model':
                foreach ($array as $item) {
                    if (is_numeric($item)) {
                        $qa[] = " veh.modelid  = " . $item;
                    }
                }
            break;
            // case 'modelyear':
            //     foreach ($array as $item) {
            //         if (is_numeric($item)) {
            //             $qa[] = " veh.modelyearid = " . $item;
            //         }
            //     }
            // break;
            case 'condition':
                foreach ($array as $item) {
                    if (is_numeric($item)) {
                        $qa[] = " veh.conditionid = " . $item;
                    }
                }
            break;
            case 'fueltype':
                foreach ($array as $item) {
                    if (is_numeric($item)) {
                        $qa[] = " veh.fueltypeid = " . $item;
                    }
                }
            break;
            case 'cylinder':
                foreach ($array as $item) {
                    if (is_numeric($item)) {
                        $qa[] = " veh.cylinderid = " . $item;
                    }
                }
            break;
            case 'transmission':
                foreach ($array as $item) {
                    if (is_numeric($item)) {
                        $qa[] = " veh.transmissionid = " . $item;
                    }
                }
            break;
            case 'registrationcity':
                foreach ($array as $item) {
                    if (is_numeric($item)) {
                        $qa[] = " veh.regcity = " . $item;
                    }
                }
            break;
            case 'locationcity':
                foreach ($array as $item) {
                    if (is_numeric($item)) {
                        $qa[] = " veh.loccity = " . $item;
                    }
                }
            break;
            default:
                return false;
                break;
        }
        $query = implode(" OR ", $qa);
        return $query;
    }

    function getInqueryForPopUpSearch($data){
        $inquery = '';
        if(isset($data['vehicletype']) && $data['vehicletype'] != ''){
            jsvehiclemanager::$_data['filter']['vehicletype'] = $data['vehicletype'];
            $res = $this->makeQueryFromArray('vehicletype', $data['vehicletype']);
            if ($res)
                $inquery .= " AND ( " . $res . " )";
        }
        if(isset($data['make']) && $data['make'] != ''){
            $res = $this->makeQueryFromArray('make', $data['make']);
            if ($res)
                $inquery .= " AND ( " . $res . " )";
            jsvehiclemanager::$_data['filter']['make'] = $data['make'];
        }

        if(isset($data['model']) && $data['model'] != ''){
            $res = $this->makeQueryFromArray('model', $data['model']);
            if ($res)
                $inquery .= " AND ( " . $res . " )";
            jsvehiclemanager::$_data['filter']['model'] = $data['model'];
        }

        // if(isset($data['modelyear']) && $data['modelyear'] != ''){
        //     $res = $this->makeQueryFromArray('modelyear', $data['modelyear']);
        //     if ($res)
        //         $inquery .= " AND ( " . $res . " )";
        //     jsvehiclemanager::$_data['filter']['modelyear'] = $data['modelyear'];
        // }

        if(isset($data['modelyearfrom']) && $data['modelyearfrom'] != ''){
            $modelyearfrom = $data['modelyearfrom'];
            if(is_numeric($modelyearfrom)){
                $inquery .= ' AND modelyear.title >= '.$modelyearfrom.' ';
                jsvehiclemanager::$_data['filter']['modelyearfrom'] = $data['modelyearfrom'];
            }
        }

        if(isset($data['modelyearto']) && $data['modelyearto'] != ''){
            $modelyearto = $data['modelyearto'];
            if(is_numeric($modelyearto)){
                $inquery .= ' AND modelyear.title <= '.$modelyearto.' ';
                jsvehiclemanager::$_data['filter']['modelyearto'] = $data['modelyearto'];
            }
        }

        if(isset($data['condition']) && $data['condition'] != ''){
            $res = $this->makeQueryFromArray('condition', $data['condition']);
            if ($res)
                $inquery .= " AND ( " . $res . " )";
            jsvehiclemanager::$_data['filter']['condition'] = $data['condition'];
        }

        if(isset($data['fueltype']) && $data['fueltype'] != ''){
            $res = $this->makeQueryFromArray('fueltype', $data['fueltype']);
            if ($res)
                $inquery .= " AND ( " . $res . " )";
            jsvehiclemanager::$_data['filter']['fueltype'] = $data['fueltype'];
        }

        if(isset($data['cylinder']) && $data['cylinder'] != ''){
            $res = $this->makeQueryFromArray('cylinder', $data['cylinder']);
            if ($res)
                $inquery .= " AND ( " . $res . " )";
            jsvehiclemanager::$_data['filter']['cylinder'] = $data['cylinder'];
        }

        if(isset($data['transmission']) && $data['transmission'] != ''){
            $res = $this->makeQueryFromArray('transmission', $data['transmission']);
            if ($res)
                $inquery .= " AND ( " . $res . " )";
            jsvehiclemanager::$_data['filter']['transmission'] = $data['transmission'];
        }

        if(isset($data['registrationcity']) && $data['registrationcity'] != ''){
            $inquery .= ' AND veh.regcity IN ('.$data['registrationcity'].') ';
            jsvehiclemanager::$_data['filter']['registrationcity'] = $data['registrationcity'];
            jsvehiclemanager::$_data['filter']['registrationcitypopup'] = JSVEHICLEMANAGERincluder::getJSModel('common')->getCitiesForFilter($data['registrationcity']);
        }

        if(isset($data['locationcity']) && $data['locationcity'] != ''){
            $inquery .= ' AND veh.loccity IN ('.$data['locationcity'].') ';
            jsvehiclemanager::$_data['filter']['locationcity'] = $data['locationcity'];
            jsvehiclemanager::$_data['filter']['locationcitypopup'] = JSVEHICLEMANAGERincluder::getJSModel('common')->getCitiesForFilter($data['locationcity']);
        }

        if(isset($data['exteriorcolor']) && $data['exteriorcolor'] != ''){
            $inquery .= ' AND veh.exteriorcolor LIKE  "%'.$data['exteriorcolor'].'%" ';
            jsvehiclemanager::$_data['filter']['exteriorcolor'] = $data['exteriorcolor'];
        }

        if(isset($data['interiorcolor']) && $data['interiorcolor'] != ''){
            $inquery .= ' AND veh.interiorcolor LIKE  "%'.$data['interiorcolor'].'%" ';
            jsvehiclemanager::$_data['filter']['interiorcolor'] = $data['interiorcolor'];
        }

        if(isset($data['registrationnumber']) && $data['registrationnumber'] != ''){
            $inquery .= ' AND veh.registrationnumber LIKE  "%'.$data['registrationnumber'].'%" ';
            jsvehiclemanager::$_data['filter']['registrationnumber'] = $data['registrationnumber'];
        }

        if(isset($data['stocknumber']) && $data['stocknumber'] != ''){
            $inquery .= ' AND veh.stocknumber LIKE  "%'.$data['stocknumber'].'%" ';
            jsvehiclemanager::$_data['filter']['stocknumber'] = $data['stocknumber'];
        }

        if(isset($data['pricefrom']) && $data['pricefrom'] != ''){
            $pricefrom = filter_var($data['pricefrom'], FILTER_SANITIZE_NUMBER_INT);
            if(is_numeric($pricefrom)){
                $inquery .= ' AND veh.price >= '.$pricefrom.' ';
                jsvehiclemanager::$_data['filter']['pricefrom'] = $data['pricefrom'];
            }
        }

        if(isset($data['priceto']) && $data['priceto'] != ''){
            $priceto = filter_var($data['priceto'], FILTER_SANITIZE_NUMBER_INT);
            if(is_numeric($priceto)){
                $inquery .= ' AND veh.price <= '.$priceto.' ';
                jsvehiclemanager::$_data['filter']['priceto'] = $data['priceto'];
            }
        }

        if(isset($data['currency']) && $data['currency'] != ''){
            $inquery .= ' AND veh.currencyid =  '.$data['currency'].' ';
            jsvehiclemanager::$_data['filter']['currency'] = $data['currency'];

        }

        if(isset($data['enginecapacityfrom']) && $data['enginecapacityfrom'] != ''){
            $enginecapacityfrom = filter_var($data['enginecapacityfrom'], FILTER_SANITIZE_NUMBER_INT);
            if(is_numeric($enginecapacityfrom)){
                $inquery .= ' AND veh.enginecapacity LIKE "%'.$enginecapacityfrom.'%" ';
                jsvehiclemanager::$_data['filter']['enginecapacityfrom'] = $data['enginecapacityfrom'];
            }
        }
        if(isset($data['enginecapacityto']) && $data['enginecapacityto'] != ''){
            $enginecapacityto = filter_var($data['enginecapacityto'], FILTER_SANITIZE_NUMBER_INT);
            if(is_numeric($enginecapacityto)){
                $inquery .= ' AND veh.enginecapacity LIKE "%'.$enginecapacityto.'%" ';
                 jsvehiclemanager::$_data['filter']['enginecapacityto'] = $data['enginecapacityto'];
            }
        }
        if(isset($data['mileagefrom']) && $data['mileagefrom'] != ''){
        $mileagefrom = filter_var($data['mileagefrom'], FILTER_SANITIZE_NUMBER_INT);
        if(is_numeric($mileagefrom)){
            $inquery .= ' AND veh.mileages >= '.$mileagefrom.' ';
                jsvehiclemanager::$_data['filter']['mileagefrom'] = $data['mileagefrom'];
        }
        }
        if(isset($data['mileageto']) && $data['mileageto'] != ''){
            $mileageto = filter_var($data['mileageto'], FILTER_SANITIZE_NUMBER_INT);
            if(is_numeric($mileageto)){
                $inquery .= ' AND veh.mileages <=  '.$mileageto.' ';
                jsvehiclemanager::$_data['filter']['mileageto'] = $data['mileageto'];
            }
        }
        if(isset($data['mileagetype']) && $data['mileagetype'] != ''){
            $inquery .= ' AND veh.speedmetertypeid =  '.$data['mileagetype'].' ';
            jsvehiclemanager::$_data['filter']['mileagetype'] = $data['mileagetype'];
        }

        if(isset($data['cityfuelconsumptionfrom']) && $data['cityfuelconsumptionfrom'] != ''){
            $cityfuelconsumptionfrom = filter_var($data['cityfuelconsumptionfrom'], FILTER_SANITIZE_NUMBER_INT);
            if(is_numeric($cityfuelconsumptionfrom)){
                $inquery .= ' AND veh.cityfuelconsumption >=  '.$cityfuelconsumptionfrom.' ';
                jsvehiclemanager::$_data['filter']['cityfuelconsumptionfrom'] = $data['cityfuelconsumptionfrom'];
            }
        }
        if(isset($data['cityfuelconsumptionto']) && $data['cityfuelconsumptionto'] != ''){
            $cityfuelconsumptionto = filter_var($data['cityfuelconsumptionto'], FILTER_SANITIZE_NUMBER_INT);
            if(is_numeric($cityfuelconsumptionto)){
                $inquery .= ' AND veh.cityfuelconsumption <=  '.$cityfuelconsumptionto.' ';
                 jsvehiclemanager::$_data['filter']['cityfuelconsumptionto'] = $data['cityfuelconsumptionto'];
            }
        }
        if(isset($data['highwayfuelconsumptionfrom']) && $data['highwayfuelconsumptionfrom'] != ''){
            $highwayfuelconsumptionfrom = filter_var($data['highwayfuelconsumptionfrom'], FILTER_SANITIZE_NUMBER_INT);
            if(is_numeric($highwayfuelconsumptionfrom)){
                $inquery .= ' AND veh.highwayfuelconsumption >=  '.$highwayfuelconsumptionfrom.' ';
                jsvehiclemanager::$_data['filter']['highwayfuelconsumptionfrom'] = $data['highwayfuelconsumptionfrom'];
            }
        }

        if(isset($data['highwayfuelconsumptionto']) && $data['highwayfuelconsumptionto'] != ''){
            $highwayfuelconsumptionto = filter_var($data['highwayfuelconsumptionto'], FILTER_SANITIZE_NUMBER_INT);
            if(is_numeric($highwayfuelconsumptionto)){
                $inquery .= ' AND veh.highwayfuelconsumption <=  '.$highwayfuelconsumptionto.' ';
                jsvehiclemanager::$_data['filter']['highwayfuelconsumptionto'] = $data['highwayfuelconsumptionto'];
            }
        }

        if(isset($data['jsvehiclemanagerpageid']) && $data['jsvehiclemanagerpageid'] != ''){
            jsvehiclemanager::$_data['filter']['jsvehiclemanagerpageid'] = $data['jsvehiclemanagerpageid'];
        }

        $searchajax = null;
        if($searchajax == null){
            if(isset($data['longitude']) && isset($data['latitude']) && isset($data['radius']) && isset($data['radiustype'])){
                $longitude = $data['longitude'];
                $latitude = $data['latitude'];
                $radius = $data['radius'];
                $radius_length_type = $data['radiustype'];
            }else{
                $longitude = '';
                $latitude = '';
                $radius = '';
                $radius_length_type = '';
            }
        }else{
            $longitude = isset($searchajax['longitude']) ? $searchajax['longitude'] : '';
            $latitude = isset($searchajax['latitude']) ? $searchajax['latitude'] : '';
            $radius = isset($searchajax['radius']) ? $searchajax['radius'] : '';
            $radius_length_type = isset($searchajax['radiuslengthtype']) ? $searchajax['radiuslengthtype'] : '';
        }
        $longitude = str_replace(',', '', $longitude);
        $latitude = str_replace(',', '', $latitude);
        //for radius search
        switch ($radius_length_type) {
            case "1":$radiuslength = 6378137;
            break;
            case "2":$radiuslength = 6378.137;
            break;
            case "3":$radiuslength = 3963.191;
            break;
            case "4":$radiuslength = 3441.596;
            break;
        }
        if ($longitude != '' && $latitude != '' && $radius != '' && $radiuslength != '') {
            if (is_numeric($longitude)  && is_numeric($latitude)  && is_numeric($radius)  && is_numeric($radiuslength) ) {
                jsvehiclemanager::$_data['filter']['longitude'] = $longitude;
                jsvehiclemanager::$_data['filter']['latitude'] = $latitude;
                jsvehiclemanager::$_data['filter']['radius'] = $radius;
                jsvehiclemanager::$_data['filter']['radiuslengthtype'] = $radius_length_type;
                $inquery .= " AND acos((SIN( PI()* $latitude /180 )*SIN( PI()*veh.latitude/180 ))+(cos(PI()* $latitude /180)*COS( PI()*veh.latitude/180) *COS(PI()*veh.longitude/180-PI()* $longitude /180)))* $radiuslength <= $radius";
            }
        }

        $data = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->userFieldsForSearch(1);
        $valarray = array();
        if (!empty($data)) {
            foreach ($data as $uf) {
                $valarray[$uf->field] = JSVEHICLEMANAGERrequest::getVar($uf->field, 'post');
                if (isset($valarray[$uf->field]) && $valarray[$uf->field] != null) {
                    switch ($uf->userfieldtype) {
                        case 'text':
                        case 'email':
                        case 'file':
                            $inquery .= ' AND veh.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($valarray[$uf->field]) . '.*"\' ';
                            break;
                        case 'combo':
                            $inquery .= ' AND veh.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                            break;
                        case 'depandant_field':
                            $inquery .= ' AND veh.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                            break;
                        case 'radio':
                            $inquery .= ' AND veh.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                            break;
                        case 'checkbox':
                            $finalvalue = '';
                            foreach($valarray[$uf->field] AS $value){
                                $finalvalue .= $value.'.*';
                            }
                            $inquery .= ' AND veh.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($finalvalue) . '.*"\' ';
                            break;
                        case 'date':
                            $inquery .= ' AND veh.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                            break;
                        case 'textarea':
                            $inquery .= ' AND veh.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($valarray[$uf->field]) . '.*"\' ';
                            break;
                        case 'multiple':
                            $finalvalue = '';
                            foreach($valarray[$uf->field] AS $value){
                                if($value != null){
                                    $finalvalue .= $value.'.*';
                                }
                            }
                            if($finalvalue !=''){
                                $inquery .= ' AND veh.params REGEXP \'"' . $uf->field . '":"[^"]*'.htmlspecialchars($finalvalue).'.*"\'';
                            }
                            break;
                    }
                    jsvehiclemanager::$_data['filter']['params'] = $valarray;
                }
            }
        }
        if($inquery != ''){
            jsvehiclemanager::$_data['filter']['issearch'] = 1;
        }
        return $inquery;
    }

    function getVehicleImageByPath($file,$name,$size){
        if($file == '' && $name =='' && $size ==''){
            return CAR_MANAGER_IMAGE."/default-images/vehicle-image.png";
        }
        $path_strnig = $file.$size.'_'.$name;
        if(filter_var($path_strnig, FILTER_VALIDATE_URL) === FALSE){
            return CAR_MANAGER_IMAGE."/default-images/vehicle-image.png";
        } else {
            return $path_strnig;
        }
    }

    function getVehicleforForm($id) {         //getVehicleforForm
        $db = new jsvehiclemanagerdb();
        $sellerinfo = array();
        $sellerflag = 1;
        $path_array = array();
        $sellerinfodata = '';
        if ($id) {
            if (is_numeric($id) == false)
                return false;
            $query = "SELECT vehicle.* , user.name
                        FROM `#__js_vehiclemanager_vehicles` AS vehicle
                        JOIN `#__js_vehiclemanager_users` AS user ON user.id = vehicle.uid
                        WHERE vehicle.id = " . $id;
            $db->setQuery($query);
            $vehicle = $db->loadObject();
            if($vehicle->hash == ''){
                $row = JSVEHICLEMANAGERincluder::getJSTable('vehicle');
                $en_string = jsvehiclemanager::generateHash($id);
                $row->update( array('id'=>$id,"hash"=>$en_string));
            }
            $query = "SELECT vehimg.file,vehimg.filename,vehimg.filesize,vehimg.id
                    FROM `#__js_vehiclemanager_vehicleimages` AS vehimg
                    WHERE vehimg.vehicleid = " . $id." ORDER BY vehimg.isdefault DESC";
            $db->setQuery($query);
            $vehicleimages = $db->loadObjectList();
            $size_string = 'ms';
            $ki = 0;
            foreach ($vehicleimages as $img) {
                $path_string = $this->getVehicleImageByPath($img->file,$img->filename,$size_string);
                // to check if default img is to shown or not
                $comp_string = CAR_MANAGER_IMAGE."/default-images/vehicle-image.png";
                $path_array[$ki][0] = $path_string;
                $path_array[$ki][2] = $img->id;
                if($path_string == $comp_string){
                    $path_array[$ki][1] = 0;
                }else{
                    $path_array[$ki][1] = 1;
                }
                $ki += 1;
            }
            jsvehiclemanager::$_data['objectid'] = $id;
        }else{
            $fieldorderings2 = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getFieldsOrderingByFor(2);
            if(JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()){
                $sellerflag = 0;
            }else{
                $profileid = JSVEHICLEMANAGERincluder::getObjectClass('user')->uid();
                $sellerinfo = JSVEHICLEMANAGERincluder::getJSModel('user')->getAutoGeneratedUserData($profileid);
                if($sellerinfo){
                    $sellerflag = 0;
                    $sellerinfodata = $sellerinfo;
                }
            }
        }
        jsvehiclemanager::$_data['sellerflag'] = $sellerflag;
        $fieldorderings = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getFieldsOrderingByFor(1);
        $f_sectionbody = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getVehiclesFieldsOrderingBySection(20);
        $f_sectiondrivetrain = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getVehiclesFieldsOrderingBySection(30);
        $f_sectionexterior = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getVehiclesFieldsOrderingBySection(40);
        $f_sectioninterior = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getVehiclesFieldsOrderingBySection(50);
        $f_sectionelectronics = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getVehiclesFieldsOrderingBySection(60);
        $f_sectionsafety = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getVehiclesFieldsOrderingBySection(70);

        if (isset($vehicle)){
            $vehicle->loccity = JSVEHICLEMANAGERincluder::getJSModel('common')->getCitiesForFilter($vehicle->loccity);
            $vehicle->regcity = JSVEHICLEMANAGERincluder::getJSModel('common')->getCitiesForFilter($vehicle->regcity);
            jsvehiclemanager::$_data[0] = $vehicle;
            jsvehiclemanager::$_data[1] = json_decode($vehicle->vehicleoptions,true);
            jsvehiclemanager::$_data[3] = $fieldorderings;


        }
        // to handle images
        // for the time being it is ten later will be changed to configuration
        $maximum_images_per_vehicle = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('maximum_images_per_vehicle');
        for ($i= count($path_array); $i <= $maximum_images_per_vehicle; $i++) {
            $path_array[$i][0]= $this->getVehicleImageByPath('','','');
            $path_array[$i][1]= 0;
            $path_array[$i][2]= 0;
        }
        if($sellerflag == 0){
            jsvehiclemanager::$_data[5] = $fieldorderings2;//field ordering for seller info portion
            jsvehiclemanager::$_data[6] = $sellerinfodata;
        }

        jsvehiclemanager::$_data[3] = $fieldorderings;
        jsvehiclemanager::$_data[4]['body'] = $f_sectionbody;
        jsvehiclemanager::$_data[4]['drivetrain'] = $f_sectiondrivetrain;
        jsvehiclemanager::$_data[4]['exterior'] = $f_sectionexterior;
        jsvehiclemanager::$_data[4]['interior'] = $f_sectioninterior;
        jsvehiclemanager::$_data[4]['electronics'] = $f_sectionelectronics;
        jsvehiclemanager::$_data[4]['safety'] = $f_sectionsafety;
        jsvehiclemanager::$_data[7] = $path_array;

        if(JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()){
            jsvehiclemanager::$_data['showcaptcha'] = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('recaptcha_vehicleform');
        }else{
            jsvehiclemanager::$_data['showcaptcha'] = 0;
        }
        return;
    }

    function getVehiclesDefaultValues() {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT fueltype.id AS fueltypeid,cylinder.id AS cylinderid,currency.id AS currencyid,
                    adexp.id AS adexpiryid,vehtype.id AS vehicletypeid,mileagetype.id AS mileageid,modelyear.id AS modelyearid,trans.id AS transmissionid
                    FROM `#__js_vehiclemanager_fueltypes` AS fueltype,`#__js_vehiclemanager_cylinders` AS cylinder,
                    `#__js_vehiclemanager_adexpiries` AS adexp,`#__js_vehiclemanager_currencies` AS currency,
                    `#__js_vehiclemanager_vehicletypes` AS vehtype,`#__js_vehiclemanager_mileages` AS mileagetype,
                    `#__js_vehiclemanager_modelyears` AS modelyear,`#__js_vehiclemanager_transmissions` AS trans
                    WHERE  fueltype.isdefault = 1 AND cylinder.isdefault = 1 AND adexp.isdefault = 1 AND currency.isdefault = 1
                    AND vehtype.isdefault = 1 AND mileagetype.isdefault = 1 AND modelyear.isdefault = 1 AND trans.isdefault = 1";
        $db->setQuery($query);
        $defaultvalues = $db->loadObject();
        return $defaultvalues;
    }

    function getVehiclesByUid($uid){
        if(!is_numeric($uid)) return false;

        $db = new jsvehiclemanagerdb();
        //pagination
        $query = "SELECT COUNT(veh.id)
                    FROM `#__js_vehiclemanager_vehicles` AS veh
                    JOIN `#__js_vehiclemanager_makes` AS make ON make.id = veh.makeid
                    JOIN `#__js_vehiclemanager_models` AS model ON model.id = veh.modelid
                    JOIN `#__js_vehiclemanager_users` AS user ON user.id = veh.uid
                    WHERE veh.uid = ".$uid;
        $db->setQuery($query);
        $total = $db->loadResult();
        jsvehiclemanager::$_data['total'] = $total;
        jsvehiclemanager::$_data[1] = JSVEHICLEMANAGERpagination::getPagination($total);
        $this->getSortingForListing();
        //data
        do_action('jsvm_featuredvehicle_vehiclelist_admin_query_data','','');
        do_action('jsvm_vehiclelist_querydata_for_sold','veh');
        $query = "SELECT veh.price, veh.created, veh.cityfuelconsumption, veh.highwayfuelconsumption, veh.enginecapacity, veh.mileages, veh.status, veh.adexpiryvalue, veh.regcity, veh.loccity,
                    make.title AS maketitle, model.title AS modeltitle, cond.title AS conditiontitle, transmission.title AS transmissiontitle, fueltype.title AS fueltypetitle,
                    mileage.symbol AS mileagesymbol, currency.symbol AS currencysymbol,veh.id AS vehicleid,modelyear.title AS modelyeartitle,veh.stocknumber
                    ,veh.exteriorcolor,veh.params,vehicleimage.filename as imagename,vehicleimage.file as filepath , ". jsvehiclemanager::$_addon_query['select'] ."
                    (SELECT COUNT(vim.id) FROM `#__js_vehiclemanager_vehicleimages` AS vim WHERE vim.vehicleid=veh.id ) AS totalimages,cond.color AS conditioncolor
                    ,user.photo AS sellerphoto , user.id AS sellerid,veh.isdiscount, veh.discountstart, veh.discountend, veh.discounttype, veh.discount
                    FROM `#__js_vehiclemanager_vehicles` AS veh
                    JOIN `#__js_vehiclemanager_makes` AS make ON make.id = veh.makeid
                    JOIN `#__js_vehiclemanager_models` AS model ON model.id = veh.modelid
                    JOIN `#__js_vehiclemanager_users` AS user ON user.id = veh.uid
                    LEFT JOIN `#__js_vehiclemanager_conditions` AS cond ON cond.id = veh.conditionid
                    LEFT JOIN `#__js_vehiclemanager_transmissions` AS transmission ON transmission.id = veh.transmissionid
                    LEFt JOIN `#__js_vehiclemanager_mileages` AS mileage ON mileage.id = veh.speedmetertypeid
                    LEFT JOIN `#__js_vehiclemanager_fueltypes` AS fueltype ON fueltype.id = veh.fueltypeid
                    LEFT JOIN `#__js_vehiclemanager_currencies` AS currency ON currency.id = veh.currencyid
                    LEFT JOIN `#__js_vehiclemanager_modelyears` AS modelyear ON modelyear.id = veh.modelyearid
                    LEFT JOIN `#__js_vehiclemanager_vehicleimages` AS vehicleimage ON vehicleimage.vehicleid = veh.id AND vehicleimage.isdefault = 1
                    WHERE veh.uid =".$uid ;
        $query .= jsvehiclemanager::$_data['ordering_query'];
        $query .= " LIMIT " . JSVEHICLEMANAGERpagination::$_offset . ", " . JSVEHICLEMANAGERpagination::$_limit;
        $db->setQuery($query);
        $vehicles = $db->loadObjectList();
        do_action('reset_jsvm_aadon_query');
        foreach ($vehicles as $vehicle) {
            $vehicle->location = JSVEHICLEMANAGERincluder::getJSModel('city')->getLocationDataForView($vehicle->loccity);
        }
        jsvehiclemanager::$_data[0] = $vehicles;
        // for labels
        jsvehiclemanager::$_data['fields'] = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getFieldsOrderingforView(1,10);
        jsvehiclemanager::$_data['listingfields'] = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getFieldsForListing(1);
        return ;
    }

    function getVehiclesByName($vehicle_name, $id = 0){
        if(! $vehicle_name)
            return '';
        if(! is_numeric($id))
            return '';

        $db = new jsvehiclemanagerdb();

        $query = "SELECT vehicles.id, vehicles.title as name,vehicles.loccity,vehimage.filename AS vehicleimage,vehmake.title AS vehiclemake,vehmodel.title AS vehiclemodel,
                vehmodelyear.title AS vehiclemodelyear,vehcondition.title AS vehiclecondition,vehicles.price AS vehicleprice
                FROM `#__js_vehiclemanager_vehicles` AS vehicles
                LEFT JOIN `#__js_vehiclemanager_vehicleimages` AS vehimage ON vehimage.vehicleid = vehicles.id AND vehimage.isdefault = 1
                LEFT JOIN `#__js_vehiclemanager_makes` AS vehmake ON vehmake.id = vehicles.makeid
                LEFT JOIN `#__js_vehiclemanager_models` AS vehmodel ON vehmodel.id = vehicles.modelid
                LEFT JOIN `#__js_vehiclemanager_modelyears` AS vehmodelyear ON vehmodelyear.id = vehicles.modelyearid
                LEFT JOIN `#__js_vehiclemanager_conditions` AS vehcondition ON vehcondition.id = vehicles.conditionid
                WHERE (vehmake.title LIKE '%" . $vehicle_name . "%' OR vehmodel.title LIKE '%" . $vehicle_name . "%'OR vehmake.title LIKE '%" . $vehicle_name . "%') AND vehicles.status = 1 AND vehicles.adexpiryvalue >= CURDATE() LIMIT 10";
        $db->setQuery($query);
        $result = $db->loadObjectList(); //query the database for entries containing the term
        if (isset($result) && !empty($result)){
            foreach ($result AS $record) {
                if (!empty($record->vehicleimage)){
                    $src = '';
                }else{
                    $src = JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/slide-1.jpg';
                }
                $data = '<div class="token-vehicle-wrapper"> ';
                $data .=    '<img class="token-img" src="'.$src.'" /> ';
                $data .=    '<div class="token-vehicle-title">';
                $data .=   __($record->vehiclemake,'js-vehicle-manager') . '  ' . __($record->vehiclemodel,'js-vehicle-manager') . '  ' . $record->vehiclemodelyear . '  ' . __($record->vehiclecondition,'js-vehicle-manager') ;
                $data .=    '</div> ';
                $data .= '</div>';
               $record->id = $record->id;
               $record->name = $data;
            }
        }
        return $result;
    }

    function getVehiclePrice($id){
        if(!is_numeric($id))
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT vehicle.price, vehicle.isdiscount, vehicle.discountstart, vehicle.discountend, vehicle.discount
                        , vehicle.discounttype, currency.id, currency.symbol
                    FROM `#__js_vehiclemanager_vehicles` AS vehicle
                    LEFT JOIN `#__js_vehiclemanager_currencies` AS currency ON currency.id = vehicle.currencyid
                    WHERE vehicle.id = $id";
        $db->setQuery($query);
        $vehicleprice = $db->loadObject();
        return $vehicleprice;
    }

    function getNextVehicles() {
        $searchcriteria = JSVEHICLEMANAGERrequest::getVar('ajaxsearch');
        $decoded = base64_decode($searchcriteria);
        $array = json_decode($decoded,true);
        $this->getVehicles();
        $array['searchajax'] = 1;
        $vehicles = JSVEHICLEMANAGERincluder::getObjectClass('');
        $vehiclehtml = $vehicles->printvehicles(jsvehiclemanager::$_data[0]);
        echo($vehiclehtml);
    }

    function getNexttemplateVehicles() {
        $searchcriteria = JSVEHICLEMANAGERrequest::getVar('ajaxsearch');
        $isPluginCall = JSVEHICLEMANAGERrequest::getVar('isPluginCall');
        $this->getVehicles(1);
        $vehicles = JSVEHICLEMANAGERincluder::getObjectClass('vehiclelist');
        if( $isPluginCall == true ){
            jsvehiclemanager::$_data['config'] = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigByFor('vehiclelist');
            $vehiclehtml = $vehicles->printpluginvehicle(jsvehiclemanager::$_data[0]);
        }
        else{
            $vehiclehtml = $vehicles->printtemplatevehicle(jsvehiclemanager::$_data[0]);
        }
        echo ($vehiclehtml);
    }

    function deleteVehicleAdmin($ids){
        if (empty($ids))
            return false;
        $db = new jsvehiclemanagerdb();
        $row = JSVEHICLEMANAGERincluder::getJSTable('vehicle');


        $notdeleted = 0;
        foreach ($ids as $id) {
            if(is_numeric($id)){
                $this->getVehicleInfoForMailById($id);

                if (!$row->delete($id)) {
                    $notdeleted += 1;
                }else{
                    // remove compare vehicle data from session
                    do_action("jsvm_comparevehicle_remove_compare_data",$id);
                    // delete images
                    $this->removeVehicleImages($id);
                    // delete shortlisted
                    do_action("jsvm_shortlist_delete_shortlist_data",$id);
                    // send mail
                    JSVEHICLEMANAGERincluder::getJSModel('emailtemplate')->sendMail(1 , 2 , $id);
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

    function deleteVehicle($vehicleid,$uid){
        if (!is_numeric($uid))
            return false;
        if (!is_numeric($vehicleid))
            return false;
        $db = new jsvehiclemanagerdb();

        $this->getVehicleInfoForMailById($vehicleid);

        $query = "SELECT  veh.uid
                    FROM `#__js_vehiclemanager_vehicles` AS veh
                    WHERE veh.id = " . $vehicleid ;
        $db->setQuery($query);
        $vehuid = $db->loadResult();
        if($uid == $vehuid){
            $row = JSVEHICLEMANAGERincluder::getJSTable('vehicle');
            if (!$row->delete($vehicleid)) {
                return JSVEHICLEMANAGER_DELETE_ERROR;
            }else{
                // remove compare vehicle data from session
                do_action("jsvm_comparevehicle_remove_compare_data",$vehicleid);
                // to delete vehicle images
                $this->removeVehicleImages($vehicleid);
                // to delete shortlisted vehicles
                do_action("jsvm_shortlist_delete_shortlist_data",$vehicleid);
                // end of shortlist delete code
                JSVEHICLEMANAGERincluder::getJSModel('emailtemplate')->sendMail(1 , 2 , $vehicleid);
                return JSVEHICLEMANAGER_DELETED;
            }
        }
        return JSVEHICLEMANAGER_DELETE_ERROR;
    }

    function removeVehicleImages($vehicleid){
        if (!is_numeric($vehicleid))
            return false;
        // to remove files from dire
        $data_directory = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
        $wpdir = wp_upload_dir();
        if(is_dir($wpdir['basedir'] . '/' . $data_directory . "/data/vehicle/vehicle_".$vehicleid)){
            array_map('unlink', glob($wpdir['basedir'] . '/' . $data_directory . "/data/vehicle/vehicle_".$vehicleid."/*.*"));//deleting files
            rmdir($wpdir['basedir'] . '/' . $data_directory . "/data/vehicle/vehicle_".$vehicleid);
        }

        $db = new jsvehiclemanagerdb();
        $query = "SELECT  img.id
                    FROM `#__js_vehiclemanager_vehicleimages` AS img
                    WHERE img.vehicleid = " . $vehicleid ;
        $db->setQuery($query);
        $vehicleimages = $db->loadObjectList();
        // to hanlde if any vehicle has been shortlisted multiple times
        $row = JSVEHICLEMANAGERincluder::getJSTable('vehicleimage');
        $error_flag = 0;
        foreach ($vehicleimages as $key => $value) {
            if (!$row->delete($value)) {
                $error_flag ++;
            }
        }
        return;
    }

    function setListStyleSession(){
        check_ajax_referer( 'wp_js_vm_nonce_check', 'wpnoncecheck' );
        $listingstyle = JSVEHICLEMANAGERrequest::getVar('styleid');
        setcookie('jsvm_listing_style' , $listingstyle , 0 , COOKIEPATH);
        if ( SITECOOKIEPATH != COOKIEPATH ){
            setcookie('jsvm_listing_style' , $listingstyle , 0 , SITECOOKIEPATH);
        }
        return $listingstyle;
    }

    function canAddVehicle($uid) {
        if (!is_numeric($uid))
            return false;
        $creditid = apply_filters('jsvm_credits_get_credit_id',0,'add_vehicle');
        $credits = apply_filters('jsvm_credits_get_action_credits',0,$creditid);
        $availablecredits = JSVEHICLEMANAGERincluder::getObjectClass('user')->getAvailableCredits();
        if ($credits <= $availablecredits) {
            return true;
        } else {
            return false;
        }
    }

    function getVehicleNameById($id){
        if(!is_numeric($id)) return '';
        $db = new jsvehiclemanagerdb();
        $query = "SELECT make.title AS maketitle, model.title AS modeltitle, mdy.title AS modelyeartitle
            FROM `#__js_vehiclemanager_vehicles` AS veh
            JOIN `#__js_vehiclemanager_makes` AS make ON make.id = veh.makeid
            JOIN `#__js_vehiclemanager_models` AS model ON model.id = veh.modelid
            LEFT JOIN `#__js_vehiclemanager_modelyears` AS mdy ON mdy.id = veh.modelyearid
            WHERE veh.id = ".$id;
        $db->setQuery($query);
        $row = $db->loadObject();
        if(empty($row)) return '';
        $name = $row->maketitle.' '.$row->modeltitle;
        if($row->modelyeartitle)
            $name .= ' - '.$row->modelyeartitle;

        return $name;
    }

    function getVehicleOwnerInfoByVehicleId($vehicleid){
        if(!is_numeric($vehicleid))
            return '';
        $db = new jsvehiclemanagerdb();
        $query = "SELECT user.email,user.name,user.id
            FROM `#__js_vehiclemanager_vehicles` AS vehicle
            JOIN `#__js_vehiclemanager_users` AS user ON user.id = vehicle.uid
            WHERE vehicle.id = " . $vehicleid;
        $db->setQuery($query);
        $data = $db->loadObject();
        return $data;
    }


    function getVehicleInfoForMailById($id){
        if(!is_numeric($id))
            return '';
        $name = $this->getVehicleNameById($id);

        $db = new jsvehiclemanagerdb();
        $query = "SELECT user.name AS sellername, user.email
            FROM `#__js_vehiclemanager_vehicles` AS veh
            JOIN `#__js_vehiclemanager_users` AS user ON user.id = veh.uid
            WHERE veh.id = ".$id;
        $db->setQuery($query);
        $data = $db->loadObject($query);
        setcookie('autoz-email-sellername' , $data->sellername , 0 , COOKIEPATH);
        if ( SITECOOKIEPATH != COOKIEPATH ){
            setcookie('autoz-email-sellername' , $data->sellername , 0 , SITECOOKIEPATH);
        }
        setcookie('autoz-email-vehicletitle' , $name , 0 , COOKIEPATH);
        if ( SITECOOKIEPATH != COOKIEPATH ){
            setcookie('autoz-email-vehicletitle' , $name , 0 , SITECOOKIEPATH);
        }
        setcookie('autoz-email-useremail' , $data->email , 0 , COOKIEPATH);
        if ( SITECOOKIEPATH != COOKIEPATH ){
            setcookie('autoz-email-useremail' , $data->email , 0 , SITECOOKIEPATH);
        }

        return;
    }

    function getInqueryForVehcileAlert($data,$data2){//data for system fields data2 for custom fields
        if(!empty($data)){
            $inquery = '';
            if(isset($data['vehicletype']) && $data['vehicletype'] != ''){
                $res = $this->makeQueryFromArray('vehicletype', $data['vehicletype']);
                if ($res)
                    $inquery .= " AND ( " . $res . " )";
            }
            if(isset($data['make']) && $data['make'] != ''){
                $res = $this->makeQueryFromArray('make', $data['make']);
                if ($res)
                    $inquery .= " AND ( " . $res . " )";
            }

            if(isset($data['model']) && $data['model'] != ''){
                $res = $this->makeQueryFromArray('model', $data['model']);
                if ($res)
                    $inquery .= " AND ( " . $res . " )";
            }

            // if(isset($data['modelyear']) && $data['modelyear'] != ''){
            //     $res = $this->makeQueryFromArray('modelyear', $data['modelyear']);
            //     if ($res)
            //         $inquery .= " AND ( " . $res . " )";
            // }

            if(isset($data['condition']) && $data['condition'] != ''){
                $res = $this->makeQueryFromArray('condition', $data['condition']);
                if ($res)
                    $inquery .= " AND ( " . $res . " )";
            }

            if(isset($data['fueltype']) && $data['fueltype'] != ''){
                $res = $this->makeQueryFromArray('fueltype', $data['fueltype']);
                if ($res)
                    $inquery .= " AND ( " . $res . " )";
            }

            if(isset($data['cylinder']) && $data['cylinder'] != ''){
                $res = $this->makeQueryFromArray('cylinder', $data['cylinder']);
                if ($res)
                    $inquery .= " AND ( " . $res . " )";
            }

            if(isset($data['transmission']) && $data['transmission'] != ''){
                $res = $this->makeQueryFromArray('transmission', $data['transmission']);
                if ($res)
                    $inquery .= " AND ( " . $res . " )";
            }

            if(isset($data['registrationcity']) && $data['registrationcity'] != ''){
                $inquery .= ' AND veh.regcity IN ('.$data['registrationcity'].') ';
            }

            if(isset($data['locationcity']) && $data['locationcity'] != ''){
                $inquery .= ' AND veh.loccity IN ('.$data['locationcity'].') ';
            }

            if(isset($data['exteriorcolor']) && $data['exteriorcolor'] != ''){
                $inquery .= ' AND veh.exteriorcolor LIKE  "%'.$data['exteriorcolor'].'%" ';
            }

            if(isset($data['interiorcolor']) && $data['interiorcolor'] != ''){
                $inquery .= ' AND veh.interiorcolor LIKE  "%'.$data['interiorcolor'].'%" ';
            }

            if(isset($data['registrationnumber']) && $data['registrationnumber'] != ''){
                $inquery .= ' AND veh.registrationnumber LIKE  "%'.$data['registrationnumber'].'%" ';
            }

            if(isset($data['stocknumber']) && $data['stocknumber'] != ''){
                $inquery .= ' AND veh.stocknumber LIKE  "%'.$data['stocknumber'].'%" ';
            }

            if(isset($data['modelyearfrom']) && $data['modelyearfrom'] != ''){
                $modelyearfrom = $data['modelyearfrom'];
                if(is_numeric($modelyearfrom)){
                    $inquery .= ' AND modelyear.title >= '.$modelyearfrom.' ';
                }
            }

            if(isset($data['modelyearto']) && $data['modelyearto'] != ''){
                $modelyearto = $data['modelyearto'];
                if(is_numeric($modelyearto)){
                    $inquery .= ' AND modelyear.title <= '.$modelyearto.' ';
                }
            }

            if(isset($data['pricefrom']) && $data['pricefrom'] != ''){
                $pricefrom = filter_var($data['pricefrom'], FILTER_SANITIZE_NUMBER_INT);
                if(is_numeric($pricefrom)){
                    $inquery .= ' AND veh.price >= '.$pricefrom.' ';
                }

            }

            if(isset($data['priceto']) && $data['priceto'] != ''){
                $priceto = filter_var($data['priceto'], FILTER_SANITIZE_NUMBER_INT);
                if(is_numeric($priceto)){
                    $inquery .= ' AND veh.price <= '.$priceto.' ';
                }
            }

            if(isset($data['currency']) && $data['currency'] != ''){
                $inquery .= ' AND veh.currencyid =  '.$data['currency'].' ';
            }

            if(isset($data['enginecapacityfrom']) && $data['enginecapacityfrom'] != ''){
                $enginecapacityfrom = filter_var($data['enginecapacityfrom'], FILTER_SANITIZE_NUMBER_INT);
                if(is_numeric($enginecapacityfrom)){
                    $inquery .= ' AND veh.enginecapacity LIKE "%'.$enginecapacityfrom.'%" ';
                }
            }
            if(isset($data['enginecapacityto']) && $data['enginecapacityto'] != ''){
                $enginecapacityto = filter_var($data['enginecapacityto'], FILTER_SANITIZE_NUMBER_INT);
                if(is_numeric($enginecapacityto)){
                    $inquery .= ' AND veh.enginecapacity LIKE "%'.$enginecapacityto.'%" ';
                }
             }
            if(isset($data['mileagefrom']) && $data['mileagefrom'] != ''){
            $mileagefrom = filter_var($data['mileagefrom'], FILTER_SANITIZE_NUMBER_INT);
                if(is_numeric($mileagefrom)){
                    $inquery .= ' AND veh.mileages >= '.$mileagefrom.' ';
                }
            }
            if(isset($data['mileageto']) && $data['mileageto'] != ''){
                $mileageto = filter_var($data['mileageto'], FILTER_SANITIZE_NUMBER_INT);
                if(is_numeric($mileageto)){
                    $inquery .= ' AND veh.mileages <=  '.$mileageto.' ';
                }
            }
            if(isset($data['mileagetype']) && $data['mileagetype'] != ''){
                $inquery .= ' AND veh.speedmetertypeid =  '.$data['mileagetype'].' ';
            }

            if(isset($data['cityfuelconsumptionfrom']) && $data['cityfuelconsumptionfrom'] != ''){
                $cityfuelconsumptionfrom = filter_var($data['cityfuelconsumptionfrom'], FILTER_SANITIZE_NUMBER_INT);
                if(is_numeric($cityfuelconsumptionfrom)){
                    $inquery .= ' AND veh.cityfuelconsumption >=  '.$cityfuelconsumptionfrom.' ';
                }
            }
            if(isset($data['cityfuelconsumptionto']) && $data['cityfuelconsumptionto'] != ''){
                $cityfuelconsumptionto = filter_var($data['cityfuelconsumptionto'], FILTER_SANITIZE_NUMBER_INT);
                if(is_numeric($cityfuelconsumptionto)){
                    $inquery .= ' AND veh.cityfuelconsumption <=  '.$cityfuelconsumptionto.' ';
                }
            }
            if(isset($data['highwayfuelconsumptionfrom']) && $data['highwayfuelconsumptionfrom'] != ''){
                $highwayfuelconsumptionfrom = filter_var($data['highwayfuelconsumptionfrom'], FILTER_SANITIZE_NUMBER_INT);
                if(is_numeric($highwayfuelconsumptionfrom)){
                    $inquery .= ' AND veh.highwayfuelconsumption >=  '.$highwayfuelconsumptionfrom.' ';
                }
            }

            if(isset($data['highwayfuelconsumptionto']) && $data['highwayfuelconsumptionto'] != ''){
                $highwayfuelconsumptionto = filter_var($data['highwayfuelconsumptionto'], FILTER_SANITIZE_NUMBER_INT);
                if(is_numeric($highwayfuelconsumptionto)){
                    $inquery .= ' AND veh.highwayfuelconsumption <=  '.$highwayfuelconsumptionto.' ';
                }
            }
            if(isset($data['longitude']) && isset($data['latitude']) && isset($data['radius']) && isset($data['radiuslengthtype']) ){
                $longitude = $data['longitude'];
                $latitude = $data['latitude'];
                $radius = $data['radius'];
                $radius_length_type = $data['radiuslengthtype'];
                $longitude = str_replace(',', '', $longitude);
                $latitude = str_replace(',', '', $latitude);
                //for radius search
                switch ($radius_length_type) {
                    case "1":$radiuslength = 6378137;
                    break;
                    case "2":$radiuslength = 6378.137;
                    break;
                    case "3":$radiuslength = 3963.191;
                    break;
                    case "4":$radiuslength = 3441.596;
                    break;
                }
                if ($longitude != '' && $latitude != '' && $radius != '' && $radiuslength != '') {
                    if (is_numeric($longitude)  && is_numeric($latitude)  && is_numeric($radius)  && is_numeric($radiuslength) ) {
                        $inquery .= " AND acos((SIN( PI()* $latitude /180 )*SIN( PI()*veh.latitude/180 ))+(cos(PI()* $latitude /180)*COS( PI()*veh.latitude/180) *COS(PI()*veh.longitude/180-PI()* $longitude /180)))* $radiuslength <= $radius";
                    }
                }
            }
        }

        if(!empty($data2)){
            $custom_fields = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->userFieldsForSearch(1);
            $valarray = array();
            if (!empty($custom_fields)) {
                foreach ($custom_fields as $uf) {
                    $valarray[$uf->field] = $data2[$uf->field];
                    if (isset($valarray[$uf->field]) && $valarray[$uf->field] != null) {
                        switch ($uf->userfieldtype) {
                            case 'text':
                            case 'email':
                            case 'file':
                                $inquery .= ' AND veh.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($valarray[$uf->field]) . '.*"\' ';
                                break;
                            case 'combo':
                                $inquery .= ' AND veh.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                                break;
                            case 'depandant_field':
                                $inquery .= ' AND veh.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                                break;
                            case 'radio':
                                $inquery .= ' AND veh.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                                break;
                            case 'checkbox':
                                $finalvalue = '';
                                foreach($valarray[$uf->field] AS $value){
                                    $finalvalue .= $value.'.*';
                                }
                                $inquery .= ' AND veh.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($finalvalue) . '.*"\' ';
                                break;
                            case 'date':
                                $inquery .= ' AND veh.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                                break;
                            case 'textarea':
                                $inquery .= ' AND veh.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($valarray[$uf->field]) . '.*"\' ';
                                break;
                            case 'multiple':
                                $finalvalue = '';
                                foreach($valarray[$uf->field] AS $value){
                                    if($value != null){
                                        $finalvalue .= $value.'.*';
                                    }
                                }
                                if($finalvalue !=''){
                                    $inquery .= ' AND veh.params REGEXP \'"' . $uf->field . '":"[^"]*'.htmlspecialchars($finalvalue).'.*"\'';
                                }
                                break;
                        }
                    }
                }
            }
        }
        return $inquery;
    }

    function makeVehicleSeo($vehicle_seo , $jsvehiclemanagerid){
        if(empty($vehicle_seo))
            return '';

        $db = new jsvehiclemanagerdb();

        $common = JSVEHICLEMANAGERincluder::getJSModel('common');
        $id = $common->parseID($jsvehiclemanagerid);
        if(! is_numeric($id))
            return '';
        $result = '';
        $vehicle_seo = str_replace( ' ', '', $vehicle_seo);
        $vehicle_seo = str_replace( '[', '', $vehicle_seo);
        $array = explode(']', $vehicle_seo);

        $total = count($array);
        if($total > 6)
            $total = 6;

        for ($i=0; $i < $total; $i++) {
            $query = '';
            switch ($array[$i]) {
                case 'make':
                    $query = "SELECT make.title AS col
                        FROM `#__js_vehiclemanager_vehicles` AS veh
                        JOIN `#__js_vehiclemanager_makes` AS make ON make.id = veh.makeid
                        WHERE veh.id = ".$id;
                break;
                case 'model':
                    $query = "SELECT model.title AS col
                        FROM `#__js_vehiclemanager_vehicles` AS veh
                        JOIN `#__js_vehiclemanager_models` AS model ON model.id = veh.modelid
                        WHERE veh.id = ".$id;
                break;
                case 'modelyear':
                    $query = "SELECT mdy.title AS col
                        FROM `#__js_vehiclemanager_vehicles` AS veh
                        LEFT JOIN `#__js_vehiclemanager_modelyears` AS mdy ON mdy.id = veh.modelyearid
                        WHERE veh.id = ".$id;
                break;
                case 'vehicletype':
                    $query = "SELECT vtype.title AS col
                        FROM `#__js_vehiclemanager_vehicles` AS veh
                        JOIN `#__js_vehiclemanager_vehicletypes` AS vtype ON vtype.id = veh.vehicletypeid
                        WHERE veh.id = ".$id;
                break;
                case 'condition':
                    $query = "SELECT cond.title AS col
                        FROM `#__js_vehiclemanager_vehicles` AS veh
                        JOIN `#__js_vehiclemanager_conditions` AS cond ON cond.id = veh.conditionid
                        WHERE veh.id = ".$id;
                break;
                case 'location':
                    $query = "SELECT city.name AS col
                        FROM `#__js_vehiclemanager_vehicles` AS veh
                        LEFT JOIN `#__js_vehiclemanager_cities` AS city ON city.id = veh.loccity
                        WHERE veh.id = ".$id;
                break;
            }
            if($query){
                $db->setQuery($query);
                $data = $db->loadObject();
                if(isset($data->col)){
                    $val = $common->removeSpecialCharacter($data->col);
                    if($result == '')
                        $result .= str_replace(' ', '-', $val);
                    else
                        $result .= '-'.str_replace(' ', '-', $val);
                }
            }
        }
        return $result;
    }

    function getMessagekey(){
        $key = 'vehicle';if(is_admin()){$key = 'admin_'.$key;} return $key;
    }

    function getAdSense(){
        $config_array = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigByFor('googleadds');
        $showgoogleadds = $config_array['googleadsenseshowinlistvehicle'];
        $after_vehicles = $config_array['googleadsenseshowafter'];
        $googleclient = $config_array['googleadsenseclient'];
        $googleslot = $config_array['googleadsenseslot'];
        $googleaddcss = $config_array['googleadsensecustomcss'];
        $html = '';
        if ($showgoogleadds == 1) {
            $html .= '<div class="jsvm-ad-wrap">
                    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <!-- new-responsive -->
                    <ins class="adsbygoogle adslot_1" style="'.$googleaddcss.'" data-ad-client="'.$googleclient.'" data-ad-slot="'.$googleslot.'" ></ins>
                    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script></div>';
        }
       return $html;
    }

    //Mobile code start here

    function getPopularVehicles(){
        $db = new jsvehiclemanagerdb();
        $query = "SELECT vehicle.id, vehicle.id AS vehicleid, vehicle.price, vehicle.isdiscount, vehicle.discountstart, vehicle.discountend, vehicle.discounttype, vehicle.discount, make.title AS maketitle, model.title AS modeltitle, modelyear.title AS modelyeartitle, vehicle.created, vehicle.cityfuelconsumption, vehicle.highwayfuelconsumption,vehicle.loccity, vehicletype.title AS vehicletype,
                    city.name AS cityname, state.name AS statename, country.name AS countryname, cond.title AS conditiontitle, cond.color AS conditioncolor, transmission.title AS transmissiontitle, fueltype.title AS fueltypetitle, vehicle.mileages, vehicle.enginecapacity, mileagetype.symbol AS mileagesymbol, currency.symbol AS currencysymbol, image.file As filepath, image.filename AS imagename
                    FROM `#__js_vehiclemanager_vehicles` AS vehicle
                    JOIN `#__js_vehiclemanager_makes` AS make on make.id = vehicle.makeid
                    JOIN `#__js_vehiclemanager_models` AS model on model.id = vehicle.modelid
                    JOIN `#__js_vehiclemanager_modelyears` AS modelyear on modelyear.id = vehicle.modelyearid
                    JOIN `#__js_vehiclemanager_conditions` AS cond on cond.id = vehicle.conditionid
                    LEFT JOIN `#__js_vehiclemanager_vehicleimages` AS image on ( image.vehicleid = vehicle.id AND image.isdefault = 1 )
                    LEFT JOIN `#__js_vehiclemanager_currencies` AS currency on currency.id = vehicle.currencyid
                    LEFT JOIN `#__js_vehiclemanager_cities` AS city on city.id = vehicle.loccity
                    LEFT JOIN `#__js_vehiclemanager_states` AS state on state.id = city.stateid
                    LEFT JOIN `#__js_vehiclemanager_countries` AS country on country.id = city.countryid
                    LEFT JOIN `#__js_vehiclemanager_transmissions` AS transmission on transmission.id = vehicle.transmissionid
                    LEFT JOIN `#__js_vehiclemanager_fueltypes` AS fueltype on fueltype.id = vehicle.fueltypeid
                    LEFT JOIN `#__js_vehiclemanager_mileages` AS mileagetype on mileagetype.id = vehicle.speedmetertypeid
                    LEFT JOIN `#__js_vehiclemanager_vehicletypes` AS vehicletype on vehicletype.id = vehicle.vehicletypeid

                    WHERE CURDATE() <= DATE(vehicle.adexpiryvalue) ORDER BY vehicle.hits  DESC LIMIT 5
                    ";
        $db->setQuery($query);
        $vehicles =$db->loadObjectList();
        foreach ($vehicles as $vehicle) {
            $vehicle->location = JSVEHICLEMANAGERincluder::getJSModel('city')->getLocationDataForView($vehicle->loccity);
        }
        jsvehiclemanager::$_data[0] = $vehicles;
        return;
    }

    function getVehiclesWidgetData($type_of_vehicles,$number_of_vehicles){
        $inquery = "";
        if($type_of_vehicles == 2){
            do_action('jsvm_widgetvehicle_query_data');
            $inquery = jsvehiclemanager::$_addon_query['where'];
        }

        $inquery .= " ORDER By vehicle.created DESC ";
        $db = new jsvehiclemanagerdb();
        $query = "SELECT vehicle.id, vehicle.price, vehicle.isdiscount, vehicle.discountstart, vehicle.discountend, vehicle.discounttype, vehicle.discount, make.title AS maketitle, model.title AS modeltitle, modelyear.title AS modelyeartitle, vehicle.created, vehicle.cityfuelconsumption, vehicle.highwayfuelconsumption,
                        city.name AS cityname, country.name AS countryname,state.name AS statename, cond.title AS conditiontitle,cond.color AS conditioncolor, transmission.title AS transmissiontitle, fueltype.title AS fueltypetitle, vehicle.mileages, vehicle.enginecapacity, mileagetype.symbol AS mileagesymbol, currency.symbol AS currencysymbol, image.file, image.filename
                        FROM `#__js_vehiclemanager_vehicles` AS vehicle
                        JOIN `#__js_vehiclemanager_makes` AS make on make.id = vehicle.makeid
                        JOIN `#__js_vehiclemanager_models` AS model on model.id = vehicle.modelid
                        JOIN `#__js_vehiclemanager_modelyears` AS modelyear on modelyear.id = vehicle.modelyearid
                        JOIN `#__js_vehiclemanager_conditions` AS cond on cond.id = vehicle.conditionid
                        LEFT JOIN `#__js_vehiclemanager_vehicleimages` AS image on ( image.vehicleid = vehicle.id AND image.isdefault = 1 )
                        LEFT JOIN `#__js_vehiclemanager_currencies` AS currency on currency.id = vehicle.currencyid
                        LEFT JOIN `#__js_vehiclemanager_cities` AS city on city.id = vehicle.loccity
                        LEFT JOIN `#__js_vehiclemanager_states` AS state on state.id = city.stateid
                        LEFT JOIN `#__js_vehiclemanager_countries` AS country on country.id = city.countryid
                        LEFT JOIN `#__js_vehiclemanager_transmissions` AS transmission on transmission.id = vehicle.transmissionid
                        LEFT JOIN `#__js_vehiclemanager_fueltypes` AS fueltype on fueltype.id = vehicle.fueltypeid
                        LEFT JOIN `#__js_vehiclemanager_mileages` AS mileagetype on mileagetype.id = vehicle.speedmetertypeid
                        WHERE CURDATE() <= DATE(vehicle.adexpiryvalue) ";
        $query .= $inquery;
        $query .= "LIMIT ".$number_of_vehicles;
        $db->setQuery($query);
        $vehicles = $db->loadObjectList();
        do_action('reset_jsvm_aadon_query');
        return $vehicles;
        //echo '<pre>';print_r($vehicles);exit();
    }
    //mobile code here by zain end

    /* Vehicle Search data, admin setting, frontend setting and delete cookies */
    function getAdminVehicleSearchFormData($search_userfields){
        $jsvm_search_array = array();
        $search_userfields = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->userFieldsForSearch(1);
        $jsvm_search_array['status'] = JSVEHICLEMANAGERrequest::getVar('status','');
        $jsvm_search_array['isgfcombo'] = JSVEHICLEMANAGERrequest::getVar('isgfcombo' , '');
        $jsvm_search_array['condition'] = JSVEHICLEMANAGERrequest::getVar('condition','');
        $jsvm_search_array['transmission'] = JSVEHICLEMANAGERrequest::getVar('transmission');
        $jsvm_search_array['fueltype'] = JSVEHICLEMANAGERrequest::getVar('fueltype');
        $jsvm_search_array['mileage'] = JSVEHICLEMANAGERrequest::getVar('mileage');
        $jsvm_search_array['make'] = JSVEHICLEMANAGERrequest::getVar('make');
        $jsvm_search_array['model'] = JSVEHICLEMANAGERrequest::getVar('model');
        $jsvm_search_array['pricestrat'] = JSVEHICLEMANAGERrequest::getVar('pricestrat');
        $jsvm_search_array['priceend'] = JSVEHICLEMANAGERrequest::getVar('priceend');
        $jsvm_search_array['uid'] = JSVEHICLEMANAGERrequest::getVar('uid');
        $jsvm_search_array['sorton'] = JSVEHICLEMANAGERrequest::getVar('sorton', 'post', 6);
        $jsvm_search_array['sortby'] = JSVEHICLEMANAGERrequest::getVar('sortby', 'post', 2);
        $jsvm_search_array['search_from_vehicle'] = 1;
        if (!empty($search_userfields)) {
            foreach ($search_userfields as $uf) {
                $jsvm_search_array['jsvm_vehicle_custom_field'][$uf->field] = JSVEHICLEMANAGERrequest::getVar($uf->field, 'post');
            }
        }
        return $jsvm_search_array;
    }

    function setSearchVariableForAdminVehicle($jsvm_search_array,$search_userfields){
        jsvehiclemanager::$_search['vehicle']['status'] = isset($jsvm_search_array['status']) ? $jsvm_search_array['status'] : null;
        jsvehiclemanager::$_search['vehicle']['isgfcombo'] = isset($jsvm_search_array['isgfcombo']) ? $jsvm_search_array['isgfcombo'] : null;
        jsvehiclemanager::$_search['vehicle']['condition'] = isset($jsvm_search_array['condition']) ? $jsvm_search_array['condition'] : null;
        jsvehiclemanager::$_search['vehicle']['transmission'] = isset($jsvm_search_array['transmission']) ? $jsvm_search_array['transmission'] : null;
        jsvehiclemanager::$_search['vehicle']['fueltype'] = isset($jsvm_search_array['fueltype']) ? $jsvm_search_array['fueltype'] : null;
        jsvehiclemanager::$_search['vehicle']['mileage'] = isset($jsvm_search_array['mileage']) ? $jsvm_search_array['mileage'] : null;
        jsvehiclemanager::$_search['vehicle']['make'] = isset($jsvm_search_array['make']) ? $jsvm_search_array['make'] : null;
        jsvehiclemanager::$_search['vehicle']['model'] = isset($jsvm_search_array['model']) ? $jsvm_search_array['model'] : null;
        jsvehiclemanager::$_search['vehicle']['pricestrat'] = isset($jsvm_search_array['pricestrat']) ? $jsvm_search_array['pricestrat'] : null;
        jsvehiclemanager::$_search['vehicle']['priceend'] = isset($jsvm_search_array['priceend']) ? $jsvm_search_array['priceend'] : null;
        jsvehiclemanager::$_search['vehicle']['uid'] = isset($jsvm_search_array['uid']) ? $jsvm_search_array['uid'] : '';
        jsvehiclemanager::$_search['vehicle']['sorton'] = isset($jsvm_search_array['sorton']) ? $jsvm_search_array['sorton'] : 6;
        jsvehiclemanager::$_search['vehicle']['sortby'] = isset($jsvm_search_array['sortby']) ? $jsvm_search_array['sortby'] : 2;
        if (!empty($search_userfields)) {
            foreach ($search_userfields as $uf) {
                jsvehiclemanager::$_search['jsvm_vehicle_custom_field'][$uf->field] = isset($jsvm_search_array['jsvm_vehicle_custom_field'][$uf->field]) ? $jsvm_search_array['jsvm_vehicle_custom_field'][$uf->field] : null;
            }
        }
    }

    function setSearchVariableForFrontVehicle($jsvm_search_array,$search_userfields){
        jsvehiclemanager::$_search['vehicle']['status'] = isset($jsvm_search_array['status']) ? $jsvm_search_array['status'] : null;
        jsvehiclemanager::$_search['vehicle']['isgfcombo'] = isset($jsvm_search_array['isgfcombo']) ? $jsvm_search_array['isgfcombo'] : null;
        jsvehiclemanager::$_search['vehicle']['condition'] = isset($jsvm_search_array['condition']) ? $jsvm_search_array['condition'] : null;
        jsvehiclemanager::$_search['vehicle']['transmission'] = isset($jsvm_search_array['transmission']) ? $jsvm_search_array['transmission'] : null;
        jsvehiclemanager::$_search['vehicle']['fueltype'] = isset($jsvm_search_array['fueltype']) ? $jsvm_search_array['fueltype'] : null;
        jsvehiclemanager::$_search['vehicle']['mileage'] = isset($jsvm_search_array['mileage']) ? $jsvm_search_array['mileage'] : null;
        jsvehiclemanager::$_search['vehicle']['make'] = isset($jsvm_search_array['make']) ? $jsvm_search_array['make'] : null;
        jsvehiclemanager::$_search['vehicle']['model'] = isset($jsvm_search_array['model']) ? $jsvm_search_array['model'] : null;
        jsvehiclemanager::$_search['vehicle']['pricestrat'] = isset($jsvm_search_array['pricestrat']) ? $jsvm_search_array['pricestrat'] : null;
        jsvehiclemanager::$_search['vehicle']['priceend'] = isset($jsvm_search_array['priceend']) ? $jsvm_search_array['priceend'] : null;
        jsvehiclemanager::$_search['vehicle']['uid'] = isset($jsvm_search_array['uid']) ? $jsvm_search_array['uid'] : '';
        jsvehiclemanager::$_search['vehicle']['sorton'] = isset($jsvm_search_array['sorton']) ? $jsvm_search_array['sorton'] : 6;
        jsvehiclemanager::$_search['vehicle']['sortby'] = isset($jsvm_search_array['sortby']) ? $jsvm_search_array['sortby'] : 2;
        if (!empty($search_userfields)) {
            foreach ($search_userfields as $uf) {
                jsvehiclemanager::$_search['jsvm_vehicle_custom_field'][$uf->field] = isset($jsvm_search_array['jsvm_vehicle_custom_field'][$uf->field]) ? $jsvm_search_array['jsvm_vehicle_custom_field'][$uf->field] : null;
            }
        }
    }
    function getCookiesSavedSearchDataVehicle($search_userfields){
        $jsvm_search_array = array();
        $vehicle_search_cookie_data = '';
        if(isset($_COOKIE['jsvm_vehicle_search_data'])){
            $vehicle_search_cookie_data = $_COOKIE['jsvm_vehicle_search_data'];
            $vehicle_search_cookie_data = json_decode( base64_decode($vehicle_search_cookie_data) , true );
        }
        if($vehicle_search_cookie_data != '' && isset($vehicle_search_cookie_data['search_from_vehicle']) && $vehicle_search_cookie_data['search_from_vehicle'] == 1){
            $jsvm_search_array['status'] = $vehicle_search_cookie_data['status'];
            $jsvm_search_array['isgfcombo'] = $vehicle_search_cookie_data['isgfcombo'];
            $jsvm_search_array['condition'] = $vehicle_search_cookie_data['condition'];
            $jsvm_search_array['transmission'] = $vehicle_search_cookie_data['transmission'];
            $jsvm_search_array['fueltype'] = $vehicle_search_cookie_data['fueltype'];
            $jsvm_search_array['mileage'] = $vehicle_search_cookie_data['mileage'];
            $jsvm_search_array['make'] = $vehicle_search_cookie_data['make'];
            $jsvm_search_array['model'] = $vehicle_search_cookie_data['model'];
            $jsvm_search_array['pricestrat'] = $vehicle_search_cookie_data['pricestrat'];
            $jsvm_search_array['priceend'] = $vehicle_search_cookie_data['priceend'];
            $jsvm_search_array['uid'] = $vehicle_search_cookie_data['uid'];
            $jsvm_search_array['sorton'] = $vehicle_search_cookie_data['sorton'];
            $jsvm_search_array['sortby'] = $vehicle_search_cookie_data['sortby'];
            $jsvm_search_array['search_from_vehicle'] = $vehicle_search_cookie_data['search_from_vehicle'];

            if (!empty($search_userfields)) {
                foreach ($search_userfields as $uf) {
                    $jsvm_search_array['jsvm_vehicle_custom_field'][$uf->field] = (isset($vehicle_search_cookie_data['jsvm_vehicle_custom_field'][$uf->field]) && $vehicle_search_cookie_data['jsvm_vehicle_custom_field'][$uf->field] != '') ? $vehicle_search_cookie_data['jsvm_vehicle_custom_field'][$uf->field] : null;
                }
            }
        }

        return $jsvm_search_array;
    }
}
?>
