<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERVehicleController {

    private $_msgkey;

    function __construct() {
        $this->_msgkey = JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getMessagekey();
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'vehicles');
        $uid = JSVEHICLEMANAGERincluder::getObjectClass('user')->uid();
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_vehicles':
                    JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getAllVehicles(1);//for main listing
                break;
                case 'admin_vehiclequeue':
                    JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getAllVehicles(2);//  for queue
                break;
                case 'admin_vehicledetail':
                    $id = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerid');
                    JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getVehicledetailbyId($id);
                break;
                case 'admin_formvehicle':
                    $id = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerid');
                    JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getVehiclebyId($id);
                    JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getVehicleforForm($id);
                    JSVEHICLEMANAGERincluder::getJSModel('mileages')->getAllSymbolsWithID();
                    $user = JSVEHICLEMANAGERincluder::getJSModel('user')->getUsernameAndEmailFromProfile($uid);
                    jsvehiclemanager::$_data['user'] = $user;
                break;
                case 'vehicles':
                    JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getVehicles();
                    JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getFieldsOrderingforSearch(1);
                    JSVEHICLEMANAGERincluder::getJSModel('mileages')->getAllSymbolsWithID();
                    jsvehiclemanager::$_data['config'] = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigByFor('vehiclelist');
                break;
                case 'vehicledetail':
                    $id = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerid');
                    if( ! is_numeric($id)){
                        $id = JSVEHICLEMANAGERincluder::getJSModel('common')->parseID($id);
                    }

                    $expiryflag = JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getVehicleExpiryStatus($id);
                    if (!JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()) {
                        if (JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getIfVehicleOwner($id)) {
                            $expiryflag = true;
                        }
                    }
                    if($expiryflag == true){
                        JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getVehicledetailbyId($id);
                    }else{
                        if(jsvehiclemanager::$_car_manager_theme == true){
                            jsvehiclemanager::$_error_flag_message = CAR_MANAGER_CONTENTNOTFOUND;
                        }else{
                            jsvehiclemanager::$_error_flag_message = JSVEHICLEMANAGERLayout::setMessageFor(2,null,null,1);
                        }
                    }

                    break;
                case 'formvehicle':
                    $userflag = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('allow_user_to_add_vehicle');
                    $id = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerid');

                    if(is_admin() || $userflag == 1 ){
                        $visitorflag = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('visitor_can_add_vehicle');
                        if(!in_array('visitoraddvehicle', jsvehiclemanager::$_active_addons)){
                            $visitorflag = 0;
                        }
                        if(!JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest() || $visitorflag == 1 ){
                            if(!JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()){
                                $check_owner = true; // cehck owner code is to manage that only owner can or admin can edit a vehicle
                                if($id != ''){
                                    $canaddvehicle = true;
                                    if(!is_admin()){
                                        $check_owner = JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getIfVehicleOwner($id);
                                    }
                                }else{
                                    $canaddvehicle = apply_filters("jsvm_credits_check_user_can_addvehicle",true,$uid);
                                }
                                if($canaddvehicle){
                                    if($check_owner){
                                        JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getVehicleforForm($id);
                                        JSVEHICLEMANAGERincluder::getJSModel('mileages')->getAllSymbolsWithID();
                                    }else{
                                        if(jsvehiclemanager::$_car_manager_theme == true){
                                            jsvehiclemanager::$_error_flag_message = CAR_MANAGER_PAGENOTFOUND;
                                        }else{
                                            jsvehiclemanager::$_error_flag_message = JSVEHICLEMANAGERLayout::setMessageFor(10,null,null,1);
                                        }
                                    }
                                }else{
                                    if(jsvehiclemanager::$_car_manager_theme == true){
                                        jsvehiclemanager::$_error_flag_message = CAR_MANAGER_NOT_ENOUGH_CREDITS;
                                    }else{
                                        jsvehiclemanager::$_error_flag_message = JSVEHICLEMANAGERLayout::setMessageFor(2,null,null,1);
                                    }
                                }
                            }else{
                                $id = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerid');
                                JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getVehicleforForm($id);
                                JSVEHICLEMANAGERincluder::getJSModel('mileages')->getAllSymbolsWithID();
                            }
                        }else{
                            if(jsvehiclemanager::$_car_manager_theme == true){
                                jsvehiclemanager::$_js_login_redirct_link = JSVEHICLEMANAGERincluder::getJSModel('common')->jsMakeRedirectURL('vehicle', $layout);
                            	jsvehiclemanager::$_error_flag_message = CAR_MANAGER_GUEST;
                            }else{
                                jsvehiclemanager::$_error_flag_message = JSVEHICLEMANAGERLayout::setMessageFor(3,null,null,1);
                            }
                        }
                    }else{
                        if( jsvehiclemanager::$_car_manager_theme == true ){
                            jsvehiclemanager::$_error_flag_message = USERVEHICLENOTALLOWED;
                        }else{
                            jsvehiclemanager::$_error_flag_message = JSVEHICLEMANAGERLayout::setMessageFor(10,null,null,1);
                        }
                    }
                break;
                case 'vehiclesearch':
                    JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getFieldsOrderingforSearch(1);
                    JSVEHICLEMANAGERincluder::getJSModel('mileages')->getAllSymbolsWithID();
                break;
                case 'myvehicles':
                    if(!JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()){
                        JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getVehiclesByUid($uid);
                    }else{
                        jsvehiclemanager::$_js_login_redirct_link = JSVEHICLEMANAGERincluder::getJSModel('common')->jsMakeRedirectURL('vehicle', $layout);
                        if( jsvehiclemanager::$_car_manager_theme == true ){
                        	jsvehiclemanager::$_error_flag_message = CAR_MANAGER_GUEST;
                        }else{
                            $link = JSVEHICLEMANAGERincluder::getJSModel('common')->jsMakeRedirectURL('vehicle', $layout);
                            $linktext = __('Login','js-vehicle-manager');
                            jsvehiclemanager::$_error_flag_message = JSVEHICLEMANAGERLayout::setMessageFor(1 , $link , $linktext,1);
                        }
                    }

                break;
            }
            $module = (is_admin()) ? 'page' : 'jsvmme';
            $module = JSVEHICLEMANAGERrequest::getVar($module, null, 'vehicle');
            $module = str_replace('jsvm_', '', $module);
            JSVEHICLEMANAGERincluder::include_file($layout, $module);
        }
    }

    function canaddfile() {
        if (isset($_POST['form_request']) && $_POST['form_request'] == 'jsvehiclemanager')
            return false;
        elseif (isset($_GET['action']) && $_GET['action'] == 'jsvmtask')
            return false;
        else
            return true;
    }

    function savevehicle() {
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'save-vehicle') ) {
            die( 'Security check Failed' );
        }
        $data = JSVEHICLEMANAGERrequest::get('post');
        $msgKey = $this->_msgkey;
        if(is_admin()){
           $url = admin_url("admin.php?page=jsvm_vehicle&jsvmlt=vehicles");
        }else{
            $url = jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerpageid'), 'jsvmme'=>'vehicle', 'jsvmlt'=>'myvehicles'));
        }
        if(JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()){
            $pageid = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('visitor_add_vehicle_redirect_page');
            $url = get_the_permalink($pageid);
            $msgKey = JSVEHICLEMANAGERincluder::getJSModel('user')->getMessagekey();
        }
        $result = JSVEHICLEMANAGERincluder::getJSModel('vehicle')->storeVehicle($data);
        if($result == 'RECAPTCHA_FAILED'){
            $url = jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerpageid'), 'jsvmme'=>'vehicle', 'jsvmlt'=>'formvehicle'));
            $msgKey = $this->_msgkey;
        }
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'vehicle');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'],$msgKey);
        wp_redirect($url);
        exit();
    }

    function remove() {
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-vehicle') ) {
            die( 'Security check Failed' );
        }
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $fromqueue = JSVEHICLEMANAGERrequest::getVar('fromqueue' , null , 0);
        $result = JSVEHICLEMANAGERincluder::getJSModel('vehicle')->deleteVehicleAdmin($ids);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'vehicle');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        if(is_admin()){
                $url = admin_url("admin.php?page=jsvm_vehicle&jsvmlt=vehicles");
            if($fromqueue == 1)
                $url = admin_url("admin.php?page=jsvm_vehicle&jsvmlt=vehiclequeue");
        }else{
            $pageid = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerpageid');
            $url = jsvehiclemanager::makeUrl(array('jsvmme'=>'user', 'jsvmlt'=>'dashboard', 'jsvehiclemanagerpageid'=>$pageid));
        }
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function removevehicle() {
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-vehicle') ) {
             die( 'Security check Failed' );
        }
        $vehicleid = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerid');
        $call_from = JSVEHICLEMANAGERrequest::getVar('call_from');
        $uid = JSVEHICLEMANAGERincluder::getObjectClass('user')->uid();
        $result = JSVEHICLEMANAGERincluder::getJSModel('vehicle')->deleteVehicle($vehicleid,$uid);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'vehicle');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        if($call_from == 2){
            $url = jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerpageid'), 'jsvmme'=>'vehicle', 'jsvmlt'=>'myvehicles'));
        }elseif($call_from == 1){
            $url = jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerpageid'), 'jsvmme'=>'user', 'jsvmlt'=>'dashboard'));
        }else{
            $url = jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerpageid'), 'jsvmme'=>'vehicle', 'jsvmlt'=>'myvehicles'));
        }
        wp_redirect($url);
        die();
    }

    function publish() {
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'publish-vehicle') ) {
             die( 'Security check Failed' );
        }
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $result = JSVEHICLEMANAGERincluder::getJSModel('vehicle')->publishUnpublish($ids, 1); //  for publish
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'vehicle');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_vehicle&jsvmlt=vehicle");
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function unpublish() {
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'unpublish-vehicle') ) {
             die( 'Security check Failed' );
        }
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $result = JSVEHICLEMANAGERincluder::getJSModel('vehicle')->publishUnpublish($ids, 0); //  for unpublish
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'vehicle');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_vehicle&jsvmlt=vehicle");
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function approvequeuevehicle() {
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'approve-vehicle') ) {
             die( 'Security check Failed' );
        }
        $id = JSVEHICLEMANAGERrequest::getVar('id');
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');

        $result = JSVEHICLEMANAGERincluder::getJSModel('vehicle')->approveQueueVehicle($id);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'vehicle');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_vehicle&jsvmlt=vehiclequeue");
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function rejectqueuevehicle() {
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'reject-vehicle') ) {
             die( 'Security check Failed' );
        }
        $id = JSVEHICLEMANAGERrequest::getVar('id');
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');

        $result = JSVEHICLEMANAGERincluder::getJSModel('vehicle')->rejectQueueVehicle($id);

        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'vehicle');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_vehicle&jsvmlt=vehiclequeue");
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function approvequeueallvehicle() {
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'approve-vehicle') ) {
             die( 'Security check Failed' );
        }
        $id = JSVEHICLEMANAGERrequest::getVar('id');
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');

        $result = JSVEHICLEMANAGERincluder::getJSModel('vehicle')->approveQueueAllVehicleModel($id);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'vehicle');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_vehicle&jsvmlt=vehiclequeue");
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function rejectqueueallvehicle() {
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'reject-vehicle') ) {
             die( 'Security check Failed' );
        }
        $id = JSVEHICLEMANAGERrequest::getVar('id');
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');

        $result = JSVEHICLEMANAGERincluder::getJSModel('vehicle')->rejectQueueAllVehicleModel($id);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'vehicle');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_vehicle&jsvmlt=vehiclequeue");
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function getvehiclesbyname() {
        $vehcilename = JSVEHICLEMANAGERrequest::getVar('q');
        $result = JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getVehiclesByName($vehcilename);
        $json_response = json_encode($result);
        echo $json_response;
        exit();
    }

    function downloadbyname(){
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'download-vehicle') ) {
             die( 'Security check Failed' );
        }
        $name = JSVEHICLEMANAGERrequest::getVar('name');
        $id = JSVEHICLEMANAGERrequest::getVar('id');
        JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getDownloadFileByName($name,$id);
    }
}

$JSVEHICLEMANAGERVehicleController = new JSVEHICLEMANAGERVehicleController();
?>
