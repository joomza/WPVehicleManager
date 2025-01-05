<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERCommonModel {

    function getAdExpiryTypeForCombobox(){
        $adexpiry = array();
        $adexpiry[] = (object) array('id' => '1', 'text' => __('Days', 'js-vehicle-manager'));
        $adexpiry[] = (object) array('id' => '2', 'text' => __('Weeks', 'js-vehicle-manager'));
        $adexpiry[] = (object) array('id' => '3', 'text' => __('Months', 'js-vehicle-manager'));
        $adexpiry[] = (object) array('id' => '4', 'text' => __('Years', 'js-vehicle-manager'));
        return $adexpiry;
    }

    function getAdExpiryTypeValue($adtype){
        if(!is_numeric($adtype)) return false;
        switch ($adtype) {
            case 1:$value = __('Days','js-vehicle-manager');break;
            case 2:$value = __('Weeks','js-vehicle-manager');break;
            case 3:$value = __('Months','js-vehicle-manager');break;
            case 4:$value = __('Years','js-vehicle-manager');break;
            default:$value = __('Unknown','js-vehicle-manager');break;
        }
        return $value;
    }

    function removeSpecialCharacter($string) {
        $string = strtolower($string);
        $string = strip_tags($string, "");
        //Strip any unwanted characters
        // $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);

        $string = preg_replace("/[@!*&$;%'\\\\#\\/]+/", "", $string);

        //Clean multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);
        return $string;
    }

    function setDefaultForDefaultTable($id, $for) {
        if (is_numeric($id) == false) return false;
        $tablename = $this->getTableNameByFor($for);
        if($tablename == false) return false;
        if (self::checkCanMakeDefault($id, $tablename)) {
            $column = "isdefault";
            $db = new jsvehiclemanagerdb();
            $query = "UPDATE `#__js_vehiclemanager_" . $tablename . "` AS t SET t." . $column . " = 0 ";
            $db->setQuery($query);
            $db->query();
            $query = "UPDATE  `#__js_vehiclemanager_" . $tablename . "` AS t SET t." . $column . " = 1 WHERE id=" . $id;
            $db->setQuery($query);
            if (!$db->query())
                return JSVEHICLEMANAGER_SET_DEFAULT_ERROR;
            else
                return JSVEHICLEMANAGER_SET_DEFAULT;
        }else {
            return JSVEHICLEMANAGER_UNPUBLISH_DEFAULT_ERROR;
        }
    }

    function checkCanMakeDefault($id, $tablename) {
        if (!is_numeric($id)) return false;
        switch ($tablename) {
            default: $column = "status"; break;
        }
        $db = new jsvehiclemanagerdb();
        $query = "SELECT " . $column . " FROM `#__js_vehiclemanager_" . $tablename . "` WHERE id=" . $id;
        $db->setQuery($query);
        $res = $db->loadResult();
        if ($res == 1) return true;
        else return false;
    }

    function getDefaultValue($table) {
        $db = new jsvehiclemanagerdb();
        switch ($table) {
            case "categories":
            case "jobtypes":
            case "jobstatus":
            case "shifts":
            case "heighesteducation":
            case "ages":
            case "careerlevels":
            case "experiences":
            case "salaryrange":
            case "salaryrangetypes":
            case "subcategories":
                $query = "SELECT id FROM `#__js_vehiclemanager_" . $table . "` WHERE isdefault=1";

                $db->setQuery($query);
                $default_id = $db->loadResult();
                if ($default_id)
                    return $default_id;
                else {
                    $query = "SELECT min(id) AS id FROM `#__js_vehiclemanager_" . $table . "`";

                    $db->setQuery($query);
                    $min_id = $db->loadResult();
                    return $min_id;
                }
            case "currencies":
                $query = "SELECT id FROM `#__js_vehiclemanager_" . $table . "` WHERE `default`=1";

                $db->setQuery($query);
                $default_id = $db->loadResult();
                if ($default_id)
                    return $default_id;
                else {
                    $query = "SELECT min(id) AS id FROM `#__js_vehiclemanager_" . $table . "`";

                    $db->setQuery($query);
                    $min_id = $db->loadResult();
                    return $min_id;
                }
                break;
        }
    }

    function setOrderingUpForDefaultTable($field_id, $for) {
        if (is_numeric($field_id) == false)
            return false;
        $db = new jsvehiclemanagerdb();
        $tablename = $this->getTableNameByFor($for);
        if($tablename == false) return false;
        $query = "UPDATE `#__js_vehiclemanager_" . $tablename . "` AS f1, `#__js_vehiclemanager_" . $tablename . "` AS f2
                    SET f1.ordering = f1.ordering + 1
                    WHERE f1.ordering = f2.ordering - 1
                    AND f2.id = " . $field_id;
        $db->setQuery($query);
        if (false == $db->query()) {
            return JSVEHICLEMANAGER_ORDER_UP_ERROR;
        }
        $query = " UPDATE `#__js_vehiclemanager_" . $tablename . "`
                    SET ordering = ordering - 1
                    WHERE id = " . $field_id;
        $db->setQuery($query);
        if (false == $db->query()) {
            return JSVEHICLEMANAGER_ORDER_UP_ERROR;
        }
        return JSVEHICLEMANAGER_ORDER_UP;
    }

    function setOrderingDownForDefaultTable($field_id, $for) {
        if (is_numeric($field_id) == false)
            return false;
        $db = new jsvehiclemanagerdb();
        $tablename = $this->getTableNameByFor($for);
        if($tablename == false) return false;
        $query = "UPDATE `#__js_vehiclemanager_" . $tablename . "` AS f1, `#__js_vehiclemanager_" . $tablename . "` AS f2
                    SET f1.ordering = f1.ordering - 1
                    WHERE f1.ordering = f2.ordering + 1
                    AND f2.id = " . $field_id;
        $db->setQuery($query);
        if (false == $db->query()) {
            return JSVEHICLEMANAGER_ORDER_DOWN_ERROR;
        }
        $query = " UPDATE `#__js_vehiclemanager_" . $tablename . "`
                    SET ordering = ordering + 1
                    WHERE id = " . $field_id;
        $db->setQuery($query);
        if (false == $db->query()) {
            return JSVEHICLEMANAGER_ORDER_DOWN_ERROR;
        }
        return JSVEHICLEMANAGER_ORDER_DOWN;
    }

    private function getTableNameByFor($for){
        $tablename = false;
        switch ($for) {
            case 'adexpiry':$tablename = 'adexpiries';break;
            case 'fueltypes':$tablename = 'fueltypes';break;
            case 'conditions':$tablename = 'conditions';break;
            case 'transmissions':$tablename = 'transmissions';break;
            case 'cylinders':$tablename = 'cylinders';break;
            case 'currency':$tablename = 'currencies';break;
            case 'modelyears':$tablename = 'modelyears';break;
            case 'make':$tablename = 'makes';break;
            case 'model':$tablename = 'models';break;
            case 'vehicletype':$tablename = 'vehicletypes';break;
            case 'mileages':$tablename = 'mileages';break;
        }
        return $tablename;
    }

    function getMultiSelectEdit($id, $for) {
        if (!is_numeric($id))
            return false;
        $db = new jsvehiclemanagerdb();
        $config = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigByFor('default');
        $query = "SELECT city.id AS id, concat(city.name";
        switch ($config['defaultaddressdisplaytype']) {
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
        $query .= " AS name ";
        switch ($for) {
            case 1:
                $query .= " FROM `#__js_vehiclemanager_jobcities` AS mcity";
                break;
            case 2:
                $query .= " FROM `#__js_vehiclemanager_companycities` AS mcity";
                break;
            case 3:
                $query .= " FROM `#__js_vehiclemanager_jobalertcities` AS mcity";
                break;
        }
        $query .=" JOIN `#__js_vehiclemanager_cities` AS city on city.id=mcity.cityid
                  JOIN `#__js_vehiclemanager_countries` AS country on city.countryid=country.id
                  LEFT JOIN `#__js_vehiclemanager_states` AS state on city.stateid=state.id";
        switch ($for) {
            case 1:
                $query .= " WHERE mcity.jobid = $id AND country.enabled = 1 AND city.enabled = 1";
                break;
            case 2:
                $query .= " WHERE mcity.companyid = $id AND country.enabled = 1 AND city.enabled = 1";
                break;
            case 3:
                $query .= " WHERE mcity.alertid = $id AND country.enabled = 1 AND city.enabled = 1";
                break;
        }

        $db->setQuery($query);
        $result = $db->loadObjectList();
        $json_array = json_encode($result);
        if (empty($json_array))
            return null;
        else
            return $json_array;
    }

    function getLogAction($for) {
        $logaction = array();
        if ($for == 1) {
            $logaction[] = (object) array('id' => 'add_vehicle', 'text' => __('New Vehicle', 'js-vehicle-manager'));
            if(in_array('featuredvehicle', jsvehiclemanager::$_active_addons)){
                $logaction[] = (object) array('id' => 'featured_vehicle', 'text' => __('Featured Vehicle', 'js-vehicle-manager'));
            }
        }
        return $logaction;
    }

    function getMiniMax() {
        $minimax = array();
        $minimax[] = (object) array('id' => '1', 'text' => __('Minimum', 'js-vehicle-manager'));
        $minimax[] = (object) array('id' => '2', 'text' => __('Maximum', 'js-vehicle-manager'));
        return $minimax;
    }

    function getYesNo() {
        $yesno = array();
        $yesno[] = (object) array('id' => '1', 'text' => __('Yes', 'js-vehicle-manager'));
        $yesno[] = (object) array('id' => '0', 'text' => __('No', 'js-vehicle-manager'));
        return $yesno;
    }

    function getStatus() {
        $status = array();
        $status[] = (object) array('id' => '1', 'text' => __('Published', 'js-vehicle-manager'));
        $status[] = (object) array('id' => '0', 'text' => __('Unpublished', 'js-vehicle-manager'));
        return $status;
    }

    function getQueStatus() {
        $status = array();
        $status[] = (object) array('id' => '1', 'text' => __('Approved', 'js-vehicle-manager'));
        $status[] = (object) array('id' => '0', 'text' => __('Rejected', 'js-vehicle-manager'));
        return $status;
    }

    function getListingStatus() {
        $status = array();
        $status[] = (object) array('id' => '1', 'text' => __('Approved', 'js-vehicle-manager'));
        $status[] = (object) array('id' => '-1', 'text' => __('Rejected', 'js-vehicle-manager'));
        return $status;
    }

    function getShowAllCombo() {
        $status = array();
        $status[] = (object) array('id' => '1', 'text' => __('Show all', 'js-vehicle-manager'));
        if(in_array('featuredvehicle', jsvehiclemanager::$_active_addons)){
            $status[] = (object) array('id' => '2', 'text' => __('Show featured', 'js-vehicle-manager'));
        }
        return $status;
    }

    function getFeilds() {
        $values = array();
        $values[] = (object) array('id' => 'text', 'text' => __('Text Field', 'js-vehicle-manager'));
        $values[] = (object) array('id' => 'textarea', 'text' => __('Text Area', 'js-vehicle-manager'));
        $values[] = (object) array('id' => 'checkbox', 'text' => __('Check Box', 'js-vehicle-manager'));
        $values[] = (object) array('id' => 'date', 'text' => __('Date', 'js-vehicle-manager'));
        $values[] = (object) array('id' => 'select', 'text' => __('Drop Down', 'js-vehicle-manager'));
        $values[] = (object) array('id' => 'emailaddress', 'text' => __('Email Address', 'js-vehicle-manager'));
        return $values;
    }

    function checkImageFileExtensions($file_name, $file_tmp, $image_extension_allow) {
        $allow_image_extension = explode(',', $image_extension_allow);
        if ($file_name != "" AND $file_tmp != "") {
            $ext = $this->getExtension($file_name);
            $ext = strtolower($ext);
            if (in_array($ext, $allow_image_extension))
                return true;
            else
                return false;
        }
    }

    function checkDocumentFileExtensions($file_name, $file_tmp, $document_extension_allow) {
        $allow_document_extension = explode(',', $document_extension_allow);
        if ($file_name != '' AND $file_tmp != "") {
            $ext = $this->getExtension($file_name);
            $ext = strtolower($ext);
            if (in_array($ext, $allow_document_extension))
                return true;
            else
                return false;
        }
    }

    function makeDir($path) {
        if (!file_exists($path)) { // create directory
            mkdir($path, 0755);
            $ourFileName = $path . '/index.html';
            $ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
            fclose($ourFileHandle);
        }
    }

    function getLocationForView($cityname, $statename, $countryname) {
        $location = $cityname;
        $defaultaddressdisplaytype = jsvehiclemanager::$_config['defaultaddressdisplaytype'];
        switch ($defaultaddressdisplaytype) {
            case 'csc': // city state country
                if ($statename)
                    $location .= ', ' . $statename;
                if ($countryname)
                    $location .= ', ' . $countryname;
                break;
            case 'cs':
                if ($statename)
                    $location .= ', ' . $statename;
                break;
            case 'cc':
                if ($countryname)
                    $location .= ', ' . $countryname;
                break;
        }
        return $location;
    }

    function parseID($id){
        if(is_numeric($id)) return $id;
        $id = explode('-', $id);
        $id = $id[count($id) -1];
        return $id;
    }

    function getStatusforCombo($title) {
        $status = array();
        if ($title)
            $status[] = array('value' => '' , 'text' => $title);
            $status[] = array('value' => 1, 'text' => __('Published'));
            $status[] = array('value' => -1, 'text' => __('Unpublished'));
        return $status;
    }


    function getCitiesForFilter($cities){
        if(empty($cities))
            return NULL;
        $db = new jsvehiclemanagerdb();
        $cities = explode(',', $cities);
        $result = array();

        $defaultaddressdisplaytype = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('defaultaddressdisplaytype');

        foreach ($cities as $city) {
            $query = "SELECT city.id AS id, concat(city.name";
            switch ($defaultaddressdisplaytype) {
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
            $query .= " AS name ";
            $query .= " FROM `#__js_vehiclemanager_cities` AS city
                        JOIN `#__js_vehiclemanager_countries` AS country on city.countryid=country.id
                        LEFT JOIN `#__js_vehiclemanager_states` AS state on city.stateid=state.id
                        WHERE country.enabled = 1 AND city.enabled = 1";
            $query .= " AND city.id =".$city;
            $db->setQuery($query);
            $result[] = $db->loadObject();
        }
        if(!empty($result)){
            return json_encode($result);
        }else{
            return NULL;
        }
    }

    function getDefaultValuesForVehicleCombos(){
        $data = array();
        $tables = array('vehicletypes','fueltypes','mileages','modelyears','transmissions','cylinders','currencies');
        $db = new jsvehiclemanagerdb();
        foreach ($tables as $table) {
            $query = "SELECT id FROM `#__js_vehiclemanager_$table` WHERE isdefault = 1";
            $db->setQuery($query);
            $id = $db->loadResult();
            $data[$table] = $id;
        }
        return $data;
    }

    function getUidByObjectId($actionfor, $id) {
        if (!is_numeric($id))
            return false;
        $db = new jsvehiclemanagerdb();
        switch ($actionfor) {
            case'vechile':
                $table = '#__js_vehiclemanager_vehicles';
                break;
        }
        if(!isset($table))
            return false;
        $query = "SELECT uid FROM `". $table ."` WHERE id =" . $id;
        $db->setQuery($query);
        $result = $db->loadResult();

        return $result;
    }

    function jsMakeRedirectURL($module, $layout){
        if(empty($module) AND empty($layout))
            return null;

        $finalurl = '';
        // login links
        $jsthisurl = jsvehiclemanager::makeUrl(array('jsvmme'=>$module, 'jsvmlt'=>$layout));
        $jsthisurl = base64_encode($jsthisurl);
        $finalurl = jsvehiclemanager::makeUrl(array('jsvmme'=>'jsvehiclemanager', 'jsvmlt'=>'login', 'jsvehiclemanagerredirecturl'=>$jsthisurl));
        return $finalurl;
    }

    function vehiclTitle($make,$model,$modelyear){
        $title = $make.'&nbsp;'.$model.'&nbsp;'.$modelyear;
        return $title;
    }

    function returnVehicleTitle($make,$model,$modelyear){// add relevent configurations
        $modelYearPosition = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('vehicle_modelyearposition');
        if( $modelYearPosition == 2){//right
            $title = esc_html(__($make,'js-vehicle-manager')).' '.esc_html(__($model,'js-vehicle-manager')).' - '.esc_html(__($modelyear,'js-vehicle-manager'));
        }
        else{ //left
            $title = esc_html(__($modelyear,'js-vehicle-manager')).' - '.esc_html(__($make,'js-vehicle-manager')).' '.esc_html(__($model,'js-vehicle-manager'));
        }
        return $title;
    }

    function getPrice($price,$currency, $isdiscount, $discounttype, $discountamount, $discountstartdate, $discountenddate){
        $curdate = date_i18n('Y-m-d');
        if($isdiscount == 1 && ($curdate >= date('Y-m-d', strtotime($discountstartdate)) && $curdate <= date('Y-m-d', strtotime($discountenddate)))){
            if($discounttype == 1){ // Percentage
                $dprice = $price * ($discountamount / 100);
                if($dprice < $price){
                    $price = $price - $dprice;
                }else{
                    $price = 0;
                }
            }else{ // Amount
                if($discountamount < $price){
                    $price = $price - $discountamount;
                }else{
                    $price = 0;
                }
            }
        }
        if($price != '' && $price > 0){
            $price = number_format($price,jsvehiclemanager::$_config['price_numbers_after_decimel_point'], jsvehiclemanager::$_config['price_decimal_separator'],jsvehiclemanager::$_config['price_thousand_separator']);
            if(jsvehiclemanager::$_config['price_poition_of_currency'] == 1){
                $price = $currency.' '.$price;
            }else{
                $price = $price.' '.$currency;
            }
        }else{
            $price = __('Call','js-vehicle-manager');
        }
        return $price;
    }

    function getExtension($str) {
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }

    function jsvm_set_html_content_type() {
        return 'text/html';
    }

    function sendContactUsEmail($name, $email, $message, $recevieremail){
        $headers = 'From: ' . $name . ' <' . $email . '>' . "\r\n";
        add_filter('wp_mail_content_type', array($this,'jsvm_set_html_content_type'));
        $body = preg_replace('/\r?\n|\r/', '<br/>', $message);
        $body = str_replace(array("\r\n", "\r", "\n"), "<br/>", $body);
        $body = nl2br($body);
        $subject = esc_html__('Contact us email received','js-vehicle-manager');
        wp_mail($recevieremail, $subject, $body, $headers, '');

        return;
    }

    function doAction($actionname) {
        $result = false;
        $id = JSVEHICLEMANAGERrequest::getVar('id');
        $actionid = JSVEHICLEMANAGERrequest::getVar('actiona');
        switch ($actionname) {
            case 'featured_vehicle':
                $result = JSVEHICLEMANAGERincluder::getJSModel('featuredvehicle')->addToFeaturedVehicle($id, $actionid);
                break;
        }
        return $result;
    }

    function popupFormProceedActions($isadmin){
        if($isadmin){
            $jsvehiclemanagerPopupResumeFormProceeds = 'jsvehiclemanagerPopupResumeFormProceedsAdmin';
            $jsvehiclemanagerPopupFormProceeds = 'jsvehiclemanagerPopupFormProceedsAdmin';
            $jsvehiclemanagerPopupProceeds = 'jsvehiclemanagerPopupProceedsAdmin';
            $proceedlang = __('Proceed Without Paying','js-vehicle-manager');
        }else{
            $jsvehiclemanagerPopupResumeFormProceeds = 'jsvehiclemanagerPopupResumeFormProceeds';
            $jsvehiclemanagerPopupFormProceeds = 'jsvehiclemanagerPopupFormProceeds';
            $jsvehiclemanagerPopupProceeds = 'jsvehiclemanagerPopupProceeds';
            $proceedlang = __('Proceed','js-vehicle-manager');
        }
        return array("popupresumeformproceeds" => $jsvehiclemanagerPopupResumeFormProceeds, "popupformproceeds" => $jsvehiclemanagerPopupFormProceeds, "popupproceeds" => $jsvehiclemanagerPopupProceeds, "proceedlang" => $proceedlang);
    }

    function autoSubmitDataforVehicles($action,$formid,$actionname,$popupproceed){
        $objectid = JSVEHICLEMANAGERrequest::getVar('id');
        $srcid = JSVEHICLEMANAGERrequest::getVar('srcid');
        $anchorid = JSVEHICLEMANAGERrequest::getVar('anchorid');
        $html = '';
        if ($formid) { // popup in case of form is opened
            if ($formid == 'resumeform') {
                $html .= '<script type="text/javascript">
                            '.$popupproceed.'(\'' . $action . '\');
                        </script>';
            } else {
                $html .= '<script type="text/javascript">
                            '.$popupproceed.'(\'' . $formid . '\',\'' . $action . '\');
                        </script>';
            }
        } elseif ($srcid && $anchorid) { // popup in case of add to gold and feature
            $html .= '<script type="text/javascript">
                        '.$popupproceed.'(\'' . $actionname . '\',' . $objectid . ',\'' . $srcid . '\',\'' . $anchorid . '\',\'' . $action . '\');
                    </script>';
        } else { // popup in case of view company, resume, job contact detail
            $html .= '<script type="text/javascript">
                        location.href= "' . $result['link'] . '";
                    </script>';
        }
        return $html;
    }
    function getSanitizedFormData($data){
       return $data;
    }
    function getSanitizedEditorData($data){
       $data = wp_filter_post_kses($data);
       return $data;
    }
    function stripslashesFull($input){// testing this function/.
        if (is_array($input)) {
            $input = array_map(array($this,'stripslashesFull'), $input);
        } elseif (is_object($input)) {
            $vars = get_object_vars($input);
            foreach ($vars as $k=>$v) {
                $input->{$k} = stripslashesFull($v);
            }
        } else {
            $input = stripslashes($input);
        }
        return $input;
    }

}
?>
