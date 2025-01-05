<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERjsvehiclemanagerModel {
    var $nodata;

    function getAdminControlPanelData() {

        $db = new jsvehiclemanagerdb();

        // Data for the control panel graph
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicles`";
        $db->setQuery($query);
        jsvehiclemanager::$_data['totalvehicles'] = $db->loadResult();
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicles` WHERE status = 1 AND DATE(adexpiryvalue) >= CURDATE()";
        $db->setQuery($query);
        jsvehiclemanager::$_data['activevehicles'] = $db->loadResult();
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicles` WHERE DATE(adexpiryvalue) < CURDATE()";
        $db->setQuery($query);
        jsvehiclemanager::$_data['expiredvehicles'] = $db->loadResult();

        // Graph
        $curdate = date('Y-m-d');
        $fromdate = date('Y-m-d', strtotime("now -1 month"));
        jsvehiclemanager::$_data['curdate'] = $curdate;
        jsvehiclemanager::$_data['fromdate'] = $fromdate;

        // All
        $query = "SELECT veh.created
            FROM `#__js_vehiclemanager_vehicles` AS veh WHERE date(veh.created) >= '" . $fromdate . "' AND date(veh.created) <= '" . $curdate . "' ORDER BY veh.created";
        $db->setQuery($query);
        $allvehicles = $db->loadObjectList();
        $totalvehicles = array();
        foreach ($allvehicles AS $obj) {
            $date = date('Y-m-d', strtotime($obj->created));
            $totalvehicles[$date] = isset($totalvehicles[$date]) ? ($totalvehicles[$date] + 1) : 1;
        }

        // Active
        $query = "SELECT veh.created
            FROM `#__js_vehiclemanager_vehicles` AS veh WHERE date(veh.created) >= '" . $fromdate . "' AND date(veh.created) <= '" . $curdate . "' AND DATE(veh.adexpiryvalue) >= CURDATE() ORDER BY veh.created";
        $db->setQuery($query);
        $active_vehicles = $db->loadObjectList();
        $activevehicles = array();
        foreach ($active_vehicles AS $obj) {
            $date = date('Y-m-d', strtotime($obj->created));
            $activevehicles[$date] = isset($activevehicles[$date]) ? ($activevehicles[$date] + 1) : 1;
        }

        // Expired
        $query = "SELECT veh.created
            FROM `#__js_vehiclemanager_vehicles` AS veh WHERE date(veh.created) >= '" . $fromdate . "' AND date(veh.created) <= '" . $curdate . "' AND DATE(veh.adexpiryvalue) < CURDATE() ORDER BY veh.created";
        $db->setQuery($query);
        $expired_vehicles = $db->loadObjectList();
        $expiredvehicles = array();
        foreach ($expired_vehicles AS $obj) {
            $date = date('Y-m-d', strtotime($obj->created));
            $expiredvehicles[$date] = isset($expiredvehicles[$date]) ? ($expiredvehicles[$date] + 1) : 1;
        }

        jsvehiclemanager::$_data['stack_chart_horizontal']['title'] = "['" . __('Dates', 'js-vehicle-manager') . "','" . __('All vehicles', 'js-vehicle-manager') . "','" . __('Active vehicles', 'js-vehicle-manager') . "','" . __('Expired vehicles', 'js-vehicle-manager') . "']";
        jsvehiclemanager::$_data['stack_chart_horizontal']['data'] = '';
        for ($i = 29; $i >= 0; $i--) {
            $checkdate = date('Y-m-d', strtotime($curdate . " -$i days"));
            if ($i != 29) {
                jsvehiclemanager::$_data['stack_chart_horizontal']['data'] .= ',';
            }
            jsvehiclemanager::$_data['stack_chart_horizontal']['data'] .= "['" . date_i18n('Y-M-d', strtotime($checkdate)) . "',";
            $all = isset($totalvehicles[$checkdate]) ? $totalvehicles[$checkdate] : 0;
            $active = isset($activevehicles[$checkdate]) ? $activevehicles[$checkdate] : 0;
            $expired = isset($expiredvehicles[$checkdate]) ? $expiredvehicles[$checkdate] : 0;
            jsvehiclemanager::$_data['stack_chart_horizontal']['data'] .= "$all,$active,$expired]";
        }

        // newest vehicles
        $query = "SELECT vehicles.id,vehicles.title,vehicles.enginecapacity,makes.title maketitle,miletype.symbol As mileagesymbol,
                    models.title AS modeltitle,modelyear.title AS modelyeartitle,trans.title AS transmission ,
                    fueltype.title AS fueltitle,conditions.title AS conditiontitle,conditions.id AS conditionid,conditions.color AS conditioncolor,
                    image.filename,image.file, country.name AS countryname,state.name AS statename,vehicles.status,
                    city.name AS cityname,vehicles.price,vehicles.isdiscount,vehicles.discountstart,vehicles.mileages AS mileage,
                    vehicles.discountend,vehicles.discounttype,vehicles.discount,currency.symbol AS currency
                FROM `#__js_vehiclemanager_vehicles` AS vehicles
                JOIN `#__js_vehiclemanager_conditions` AS conditions ON vehicles.conditionid = conditions.id
                JOIN `#__js_vehiclemanager_makes` AS makes ON vehicles.makeid =makes.id
                JOIN `#__js_vehiclemanager_models` AS models ON vehicles.modelid =  models.id
                LEFT JOIN `#__js_vehiclemanager_vehicleimages` AS image ON vehicles.id= image.vehicleid AND image.isdefault = 1
                LEFT JOIN `#__js_vehiclemanager_modelyears` AS modelyear ON vehicles.modelyearid = modelyear.id
                LEFT JOIN `#__js_vehiclemanager_fueltypes` AS fueltype ON vehicles.fueltypeid = fueltype.id
                LEFT JOIN `#__js_vehiclemanager_cities` AS city ON vehicles.loccity = city.id
                LEFT JOIN `#__js_vehiclemanager_countries` AS country ON city.countryid = country.id
                LEFT JOIN `#__js_vehiclemanager_states` AS state ON city.stateid = state.id
                LEFT JOIN `#__js_vehiclemanager_currencies` AS currency ON vehicles.currencyid = currency.id
                LEFT JOIN `#__js_vehiclemanager_mileages` AS miletype ON vehicles.speedmetertypeid = miletype.id
                LEFT JOIN `#__js_vehiclemanager_transmissions` AS trans ON vehicles.transmissionid = trans.id
                ORDER By vehicles.created DESC LIMIT 5";

        $db->setQuery($query);
        $result = $db->loadObjectList();
        jsvehiclemanager::$_data['newest'] = $result;

        return;
    }

    function getTodayStatsForWidget(){
        $db = new jsvehiclemanagerdb();
        //Today
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicles` WHERE DATE(created) = CURDATE()";
        $db->setQuery($query);
        $data = $db->loadResult();
        $result['today_add'] = $data;
        //Today
        $result['today_featured'] = apply_filters('jsvm_today_widgets_stats_data',0);
        $result['today_sold'] = apply_filters('jsvm_markassold_widgetdata_for_today',0);
        //Today
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicles` WHERE DATE(adexpiryvalue) = CURDATE()";
        $db->setQuery($query);
        $data = $db->loadResult();
        $result['today_expire'] = $data;

        $for = 1;
        $html = $this->makeHTMLOfWidget($result , $for);

        return $html;
    }

    function getLastWeekVehicleByMakeGraphForWidget(){

        $db = new jsvehiclemanagerdb();
        // vehicles by Makes
        $query = "SELECT make.id, make.title, make.logo, COUNT(veh.makeid) AS total
            FROM `#__js_vehiclemanager_vehicles` AS veh
            JOIN `#__js_vehiclemanager_makes` AS make ON make.id = veh.makeid
            WHERE make.status = 1 AND DATE(veh.created) >= (DATE(NOW()) - INTERVAL 7 DAY)
            GROUP BY veh.makeid ORDER By total DESC";
        $db->setQuery($query);
        $data = $db->loadObjectList();
        $result['makes'] = $data;
        $this->nodata = false;
        if(empty($result['makes'])){
            $this->nodata = true;
        }

        // var for graph
        $col1 = __('Makes','js-vehicle-manager');
        $col2 = __('Vehicle By Makes','js-vehicle-manager');
        $var = "['$col1', '$col2'],";
        $i = 1;
        $others = __('Others' , 'js-vehicle-manager');
        $others_total = 0;
        foreach ($result['makes'] as $object) {
            if($i > 5){
                $others_total += $object->total;
            }else{
                $var .= "['$object->title' , $object->total],";
            }
            $i++;
        }
        $var .= "['$others' , $others_total],";

        $html = $this->makeHTMLOfWidget($var , 2);
        return $html;
    }

    function getLatestVehiclesForWidget(){

        $db = new jsvehiclemanagerdb();
        // vehicles
        $query = "SELECT vehicles.id AS vehicleid, vehicles.status, vehicles.loccity,
            makes.title maketitle,models.title AS modeltitle,modelyear.title AS modelyeartitle,
            conditions.title AS conditiontitle,conditions.color AS conditioncolor, vimages.file, vimages.filename ,
            vehicles.price,vehicles.isdiscount,vehicles.discountstart,
            vehicles.discountend,vehicles.discounttype,vehicles.discount,currency.symbol AS currency
            FROM `#__js_vehiclemanager_vehicles` AS vehicles
            JOIN `#__js_vehiclemanager_makes` AS makes ON vehicles.makeid =makes.id
            JOIN `#__js_vehiclemanager_models` AS models ON vehicles.modelid =  models.id
            left JOIN `#__js_vehiclemanager_vehicleimages` AS vimages ON (vimages.vehicleid =  vehicles.id AND vimages.isdefault = 1)
            LEFT JOIN `#__js_vehiclemanager_modelyears` AS modelyear ON vehicles.modelyearid = modelyear.id
            LEFT JOIN `#__js_vehiclemanager_conditions` AS conditions ON vehicles.conditionid = conditions.id
            LEFT JOIN `#__js_vehiclemanager_currencies` AS currency ON vehicles.currencyid = currency.id
            ORDER BY vehicles.created DESC LIMIT 0,5";

        $db->setQuery($query);
        $results = $db->loadObjectList();

        $vehicles_list = array();
        foreach ($results as $obj) {
            $obj->title = $obj->maketitle.' '.$obj->modeltitle.' - '.$obj->modelyeartitle;
            $obj->location = JSVEHICLEMANAGERincluder::getJSModel('city')->getLocationDataForView($obj->loccity);
            $obj->price = JSVEHICLEMANAGERincluder::getJSModel('common')->getPrice($obj->price,$obj->currency, $obj->isdiscount, $obj->discounttype, $obj->discount, $obj->discountstart, $obj->discountend);
            if($obj->filename == ''){
                $imgpath = CAR_MANAGER_IMAGE."/default-images/vehicle-image.png";
            }else{
                $imgpath = $obj->file.'s_'.$obj->filename;
            }
            $obj->imagepath = $imgpath;
            $vehicles_list[] = $obj;
        }

        $html = $this->makeHTMLOfWidget($vehicles_list , 3);
        return $html;
    }

    function getTotalStatsForWidget(){

        $db = new jsvehiclemanagerdb();
        $result = array();

        // total vhecle
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicles`";
        $db->setQuery($query);
        $data = $db->loadResult();
        $result['total_vehicle'] = $data;

        // Active vhecle
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicles` WHERE status = 1 AND DATE(adexpiryvalue) >= CURDATE()";
        $db->setQuery($query);
        $data = $db->loadResult();
        $result['active_vehicle'] = $data;

        // Active features vhecle
        $result['feature_active_vehicle'] = apply_filters('jsvm_featuredvehicle_active_feature_vehicle',0);

        // Expire vhecle
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicles` WHERE DATE(adexpiryvalue) < CURDATE()";
        $db->setQuery($query);
        $data = $db->loadResult();
        $result['expired_vehicle'] = $data;

        $html = $this->makeHTMLOfWidget($result , 4);
        return $html;
    }

    function getLatestSellersForWidget(){

        $db = new jsvehiclemanagerdb();
        // vehicles
        $query = "SELECT id,name,email,cityid,photo FROM `#__js_vehiclemanager_users` AS user
            ORDER BY user.created DESC LIMIT 0,5";

        $db->setQuery($query);
        $data = $db->loadObjectList();

        $html = $this->makeHTMLOfWidget($data , 5);
        return $html;
    }

    function makeHTMLOfWidget($data , $for){
        $html = '';
        switch ($for) {
            case '1':
                $html = '
                <div class="jsvehiclemanager-widget-contaner">
                    <div class="jsvehiclemanager-widget-block mrgn-right mrgn-bottm">
                        <div class="jsvehiclemanager-widget-img">
                            <img src="'.JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/widgets/new.png'.'" />
                        </div>
                        <div class="jsvehiclemanager-widget-data">
                            <p class="heading">'.$data['today_add'].'</p>
                            <p class="detail">'.__('New Vehicles','js-vehicle-manager').'</p>
                        </div>
                    </div>';
                    // html for featured, sold vehicle
                    $html .= apply_filters('jsvm_htmlwidget_data_today','',$data);
                    $html .' <div class="jsvehiclemanager-widget-block">
                        <div class="jsvehiclemanager-widget-img">
                            <img src="'.JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/widgets/expire.png'.'" />
                        </div>
                        <div class="jsvehiclemanager-widget-data">
                            <p class="heading">'.$data['today_expire'].'</p>
                            <p class="detail">'.__('Expired Vehicles','js-vehicle-manager').'</p>
                        </div>
                    </div>
                </div>';
            break;
            case '2':
                if($this->nodata == false){
                    do_action('admin_enqueue_scripts');
                    $html = '
                    <script type="text/javascript">
                     google.load("visualization", "1", {packages:["corechart"]});
                        google.setOnLoadCallback(drawSliceChart);
                        function drawSliceChart() {
                            var data = google.visualization.arrayToDataTable([
                                '.$data.'
                            ]);

                            var options = {
                                chartArea :{width:450,height:250}
                            };

                          var chart = new google.visualization.PieChart(document.getElementById("slice_chart"));
                          chart.draw(data, options);
                        }
                    </script>
                    <div id="js-vehicle-managergraph-widget-wrap">
                      <div class="js-vehicle-managergraph-widget-divcss" style="height:300px;" id="slice_chart"></div>
                    </div>';
                }else{
                    $html = __('Not enough data to show graph' , 'js-vehicle-manager');
                }
            break;
            case '3': // latest vehicles
                $html = '
                    <div class="jsvehiclemanager-widget-contaner"> ';
                        foreach ($data as $row) {
                            if($row->status != 0){
                                $vehicle_link = admin_url('admin.php?page=jsvm_vehicle&jsvmlt=vehicles');
                            }else{
                                $vehicle_link = admin_url('admin.php?page=jsvm_vehicle&jsvmlt=vehiclequeue');
                            }
                            $html .= '
                            <div class="jsvehiclemanager-widget-vehicle-row">
                                <div class="widg-vehicle-image">
                                    <div class="veh-widget-image">
                                        <img class="widg-vehicle-image" src="'.$row->imagepath.'" />
                                    </div>
                                </div>
                                <div class="vehicle-row-top">
                                    <span class="widg-vehicle-title"><a href="'.$vehicle_link.'">'.$row->title.'</a></span>
                                    <span class="widg-vehicle-price">'.$row->price.'</span>
                                </div>
                                <div class="vehicle-row-bottom">
                                    <span class="widg-vehicle-condition" style="color:'.$row->conditioncolor.'; border: 1px solid '.$row->conditioncolor.';background-color:#fff;">'.__($row->conditiontitle , 'js-vehicle-manager').'</span>
                                    <span class="widg-vehicle-location">'.$row->location.' dsfds</span>
                                </div>
                            </div>';
                        }
                $html .='</div>';
            break;
            case '4': // total stats
                $html = '
                <div class="jsvehiclemanager-widget-contaner">
                    <div class="jsvehiclemanager-widget-total-block">
                        <img class="totalimage" src="'.JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/widgets/total.png'.'" />
                        <span class="total-detail">'.__('Total Vehicles','js-vehicle-manager').'</span>
                        <span class="total-total">'.$data['total_vehicle'].'</span>
                    </div>
                    <div class="jsvehiclemanager-widget-total-block">
                        <img class="totalimage" src="'.JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/widgets/active-2.png'.'" />
                        <span class="total-detail">'.__('Active Vehicles','js-vehicle-manager').'</span>
                        <span class="total-total">'.$data['active_vehicle'].'</span>
                    </div>';
                    $html .= apply_filters("jsvm_htmlwidget_data_total",'',$data);
                    $html .= '<div class="jsvehiclemanager-widget-total-block">
                        <img class="totalimage" src="'.JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/widgets/expire-2.png'.'" />
                        <span class="total-detail">'.__('Expired Vehicles','js-vehicle-manager').'</span>
                        <span class="total-total">'.$data['expired_vehicle'].'</span>
                    </div>
                </div>';
            break;
            case '5': // latest selllers
                $html = '
                    <div class="jsvehiclemanager-widget-contaner"> ';
                        foreach ($data as $row) {
                            if($row->photo){
                                $logo = $row->photo;
                            }else{
                                $logo = JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/users.png';
                            }
                            $link = admin_url('admin.php?page=jsvm_user&jsvmlt=profile&jsvehiclemanagerid='.$row->id);
                            $html .= '
                            <div class="jsvehiclemanager-widget-seller-row">
                                <div class="widg-seller-image">
                                    <div class="seller-image">
                                        <img class="widg-seller-image" src="'.$logo.'" />
                                    </div>
                                </div>
                                <div class="vehicle-row-top">
                                    <span class="widg-seller-title"><a href="'.$link.'">'.$row->name.'</a></span>
                                </div>
                                <div class="vehicle-row-bottom">
                                    <span class="widg-seller-condition">'.$row->email.'</span>
                                </div>
                            </div>';
                        }
                $html .='</div>';
                break;
        }
        return $html;
    }
    function makeDir($path) {
        if (!file_exists($path)) { // create directory
            mkdir($path, 0755);
            $ourFileName = $path . '/index.html';
            $ourFileHandle = fopen($ourFileName, 'w') or die(__('Cannot open file', 'js-support-ticket'));
            fclose($ourFileHandle);
        }
    }

    function getListTranslations() {
        check_ajax_referer( 'wp_js_vm_nonce_check', 'wpnoncecheck' );
        $result = array();
        $result['error'] = false;

        // $path = JSVEHICLEMANAGER_PLUGIN_PATH.'languages';
        $path = WP_LANG_DIR;
        if(!is_dir($path)){
            $this->makeDir($path);
        }else{
            $path = WP_LANG_DIR . '/plugins/';
            if(!is_dir($path)){
                $this->makeDir($path);
            }
        }
        if( ! is_writeable($path)){
            $result['error'] = __('Dir is not writable','js-vehicle-manager').' '.$path;

        }else{

            if($this->isConnected()){
                $version = JSVEHICLEMANAGERIncluder::getJSModel('configuration')->getConfigByFor('default');
                $url = "http://www.wpvehiclemanager.com/translations/api/1.0/index.php";
                $post_data['product'] ='js-vehicle-manager';
                $post_data['domain'] = get_site_url();
                // $post_data['producttype'] = $version['versiontype'];
                $post_data['productcode'] = 'js-vehicle-manager';
                $post_data['productversion'] = $version['version'];
                $post_data['JVERSION'] = get_bloginfo('version');
                $post_data['method'] = 'getTranslations';
                $response = wp_remote_post( $url, array('body' => $post_data,'timeout'=>7,'sslverify'=>false));
                if( !is_wp_error($response) && $response['response']['code'] == 200 && isset($response['body']) ){
                    $call_result = $response['body'];
                }else{
                    $call_result = false;
                    if(!is_wp_error($response)){
                       $error = $response['response']['message'];
                   }else{
                        $error = $response->get_error_message();
                   }
                }

                $result['data'] = $call_result;
                if(!$call_result){
                    $result['error'] = $error;
                }
            }else{
                $result['error'] = __('Unable to connect to server','js-vehicle-manager');
            }
        }

        $result = json_encode($result);

        return $result;
    }

    function makeLanguageCode($lang_name){
        $langarray = wp_get_installed_translations('core');
        $langarray = $langarray['default'];
        $match = false;
        if(array_key_exists($lang_name, $langarray)){
            $lang_name = $lang_name;
            $match = true;
        }else{
            $m_lang = '';
            foreach($langarray AS $k => $v){
                if($lang_name[0].$lang_name[1] == $k[0].$k[1]){
                    $m_lang .= $k.', ';
                }
            }

            if($m_lang != ''){
                $m_lang = substr($m_lang, 0,strlen($m_lang) - 2);
                $lang_name = $m_lang;
                $match = 2;
            }else{
                $lang_name = $lang_name;
                $match = false;
            }
        }

        return array('match' => $match , 'lang_name' => $lang_name);
    }

    function validateAndShowDownloadFileName( ){
        $lang_name = JSVEHICLEMANAGERrequest::getVar('langname');
        if($lang_name == '') return '';
        $result = array();
        $f_result = $this->makeLanguageCode($lang_name);
        // $path = JSVEHICLEMANAGER_PLUGIN_PATH.'languages';
        $path = WP_LANG_DIR . '/plugins/';

        $result['error'] = false;
        if($f_result['match'] === false){
            $result['error'] = $lang_name. ' ' . __('Language is not installed','js-vehicle-manager');
        }elseif( ! is_writeable($path)){
            $result['error'] = $lang_name. ' ' . __('Language directory is not writable','js-vehicle-manager').': '.$path;
        }else{
            $result['input'] = '<input id="languagecode" class="text_area" type="text" value="'.$f_result['lang_name'].'" name="languagecode">';
            if($f_result['match'] === 2){
                $result['input'] .= '<div id="js-emessage-wrapper" style="display:block;margin:20px 0px 20px;">';
                $result['input'] .= __('Required language is not installed but similar language[s] like').': "<b>'.$f_result['lang_name'].'</b>" '.__('is found in your system','js-vehicle-manager');
                $result['input'] .= '</div>';

            }
            $result['path'] = __('Language code','js-vehicle-manager');
        }
        $result = json_encode($result);
        return $result;
    }

    function getLanguageTranslation(){

        $lang_name = JSVEHICLEMANAGERrequest::getVar('langname');
        $language_code = JSVEHICLEMANAGERrequest::getVar('filename');

        $result = array();
        $result['error'] = false;
        // $path = JSVEHICLEMANAGER_PLUGIN_PATH.'languages';
        $path = WP_LANG_DIR . '/plugins/';
       
        if(!is_dir($path)){
            mkdir($path);
        }
       
        if($lang_name == '' || $language_code == ''){
            $result['error'] = __('Empty values','js-vehicle-manager');
            return json_encode($result);
        }

        $final_path = $path.'/js-vehicle-manager-'.$language_code.'.po';


        $langarray = wp_get_installed_translations('core');
        $langarray = $langarray['default'];

        if(!array_key_exists($language_code, $langarray)){
            $result['error'] = $lang_name. ' ' . __('Language is not installed','js-vehicle-manager');
            return json_encode($result);
        }elseif( ! is_writeable($path)){
            $result['error'] = $lang_name. ' ' . __('Language directory is not writable','js-vehicle-manager').': '.$path;
            return json_encode($result);
        }

        if( ! file_exists($final_path)){
            touch($final_path);
        }

        if( ! is_writeable($final_path)){
            $result['error'] = __('File is not writable','js-vehicle-manager').': '.$final_path;
        }else{

            if($this->isConnected()){
                $version = JSVEHICLEMANAGERIncluder::getJSModel('configuration')->getConfigByFor('version');
                $url = "http://www.wpvehiclemanager.com/translations/api/1.0/index.php";
                $post_data['product'] ='js-vehicle-manager';
                $post_data['domain'] = get_site_url();
                $post_data['producttype'] = $version['versiontype'];
                $post_data['productcode'] = 'jsvehiclemanager';
                $post_data['productversion'] = $version['version'];
                $post_data['JVERSION'] = get_bloginfo('version');
                $post_data['translationcode'] = $lang_name;
                $post_data['method'] = 'getTranslationFile';
                $response = wp_remote_post( $url, array('body' => $post_data,'timeout'=>7,'sslverify'=>false));
                if( !is_wp_error($response) && $response['response']['code'] == 200 && isset($response['body']) ){
                    $call_result = $response['body'];
                }else{
                    $call_result = false;
                    if(!is_wp_error($response)){
                       $error = $response['response']['message'];
                   }else{
                        $error = $response->get_error_message();
                   }
                }
                if($call_result){
                    $array = json_decode($call_result, true);
                }else{
                    $array = array();
                }
                $ret = $this->writeLanguageFile( $final_path , $array['file']);
                // if($ret != false){
                //     $url = "http://www.wpvehiclemanager.com/translations/api/1.0/index.php";
                //     $post_data['product'] ='js-vehicle-manager';
                //     $post_data['domain'] = get_site_url();
                //     $post_data['producttype'] = $version['versiontype'];
                //     $post_data['productcode'] = 'jsvehiclemanager';
                //     $post_data['productversion'] = $version['version'];
                //     $post_data['JVERSION'] = get_bloginfo('version');
                //     $post_data['folder'] = $array['foldername'];
                //     $ch = curl_init();
                //     curl_setopt($ch, CURLOPT_URL, $url);
                //     curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                //     $response = curl_exec($ch);
                //     curl_close($ch);
                // }
                $result['data'] = __('File Downloaded Successfully','js-vehicle-manager');
            }else{
                $result['error'] = __('Unable to connect to server','js-vehicle-manager');
            }
        }

        $result = json_encode($result);

        return $result;
    }

    function writeLanguageFile( $path , $url ){

        $result = file_put_contents($path, fopen($url, 'r'));
        //make mo for po file
        $this->phpmo_convert($path);
        return $result;
    }

    function isConnected(){

        $connected = @fsockopen("www.google.com", 80);
        if ($connected){
            $is_conn = true; //action when connected
            fclose($connected);
        }else{
            $is_conn = false; //action in connection failure
        }
        return $is_conn;
    }

    function phpmo_convert($input, $output = false) {
        if ( !$output )
            $output = str_replace( '.po', '.mo', $input );
        $hash = $this->phpmo_parse_po_file( $input );
        if ( $hash === false ) {
            return false;
        } else {
            $this->phpmo_write_mo_file( $hash, $output );
            return true;
        }
    }

    function phpmo_clean_helper($x) {
        if (is_array($x)) {
            foreach ($x as $k => $v) {
                $x[$k] = $this->phpmo_clean_helper($v);
            }
        } else {
            if ($x[0] == '"')
                $x = substr($x, 1, -1);
            $x = str_replace("\"\n\"", '', $x);
            $x = str_replace('$', '\\$', $x);
        }
        return $x;
    }
    /* Parse gettext .po files. */
    /* @link http://www.gnu.org/software/gettext/manual/gettext.html#PO-Files */
    function phpmo_parse_po_file($in) {
    if (!file_exists($in)){ return false; }
    $ids = array();
    $strings = array();
    $language = array();
    $lines = file($in);
    foreach ($lines as $line_num => $line) {
        if (strstr($line, 'msgid')){
            $endpos = strrchr($line, '"');
            $id = substr($line, 7, $endpos-2);
            $ids[] = $id;
        }elseif(strstr($line, 'msgstr')){
            $endpos = strrchr($line, '"');
            $string = substr($line, 8, $endpos-2);
            $strings[] = array($string);
        }else{}
    }
    for ($i=0; $i<count($ids); $i++){
        //Shoaib
        if(isset($ids[$i]) && isset($strings[$i])){
            if($entry['msgstr'][0] == '""'){
                continue;
            }
            $language[$ids[$i]] = array('msgid' => $ids[$i], 'msgstr' =>$strings[$i]);
        }
    }
    return $language;
    }
    /* Write a GNU gettext style machine object. */
    /* @link http://www.gnu.org/software/gettext/manual/gettext.html#MO-Files */
    function phpmo_write_mo_file($hash, $out) {
        // sort by msgid
        ksort($hash, SORT_STRING);
        // our mo file data
        $mo = '';
        // header data
        $offsets = array ();
        $ids = '';
        $strings = '';
        foreach ($hash as $entry) {
            $id = $entry['msgid'];
            $str = implode("\x00", $entry['msgstr']);
            // keep track of offsets
            $offsets[] = array (
                            strlen($ids), strlen($id), strlen($strings), strlen($str)
                            );
            // plural msgids are not stored (?)
            $ids .= $id . "\x00";
            $strings .= $str . "\x00";
        }
        // keys start after the header (7 words) + index tables ($#hash * 4 words)
        $key_start = 7 * 4 + sizeof($hash) * 4 * 4;
        // values start right after the keys
        $value_start = $key_start +strlen($ids);
        // first all key offsets, then all value offsets
        $key_offsets = array ();
        $value_offsets = array ();
        // calculate
        foreach ($offsets as $v) {
            list ($o1, $l1, $o2, $l2) = $v;
            $key_offsets[] = $l1;
            $key_offsets[] = $o1 + $key_start;
            $value_offsets[] = $l2;
            $value_offsets[] = $o2 + $value_start;
        }
        $offsets = array_merge($key_offsets, $value_offsets);
        // write header
        $mo .= pack('Iiiiiii', 0x950412de, // magic number
        0, // version
        sizeof($hash), // number of entries in the catalog
        7 * 4, // key index offset
        7 * 4 + sizeof($hash) * 8, // value index offset,
        0, // hashtable size (unused, thus 0)
        $key_start // hashtable offset
        );
        // offsets
        foreach ($offsets as $offset)
            $mo .= pack('i', $offset);
        // ids
        $mo .= $ids;
        // strings
        $mo .= $strings;
        file_put_contents($out, $mo);
    }

    function updateDate($addon_name,$plugin_version){
        return JSVEHICLEMANAGERincluder::getJSModel('premiumplugin')->verfifyAddonActivation($addon_name);
    }

    function getAddonSqlForActivation($addon_name,$addon_version){
        return JSVEHICLEMANAGERincluder::getJSModel('premiumplugin')->verifyAddonSqlFile($addon_name,$addon_version);
    }

    function getMessagekey(){
        $key = 'jsvehiclemanager';if(is_admin()){$key = 'admin_'.$key;}return $key;
    }

}

?>
