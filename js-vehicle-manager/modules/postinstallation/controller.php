<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERpostinstallationController {

    function __construct() {

        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'quickconfig');
        if($this->canaddfile()){
            switch ($layout) {
                case 'admin_quickconfig':
                    JSVEHICLEMANAGERincluder::getJSModel('postinstallation')->getConfigurationValues();
                break;
                case 'admin_stepone':
                case 'admin_steptwo':
                case 'admin_stepthree':
                case 'admin_stepfour':
                case 'admin_stepfive':
                    JSVEHICLEMANAGERincluder::getJSModel('postinstallation')->getConfigurationValues();
                break;
                case 'admin_themedemodata':
                    $flag = JSVEHICLEMANAGERrequest::getVar('flag','',0);// zero as default value to avoid problems
                    jsvehiclemanager::$_data['flag'] = $flag;
                break;
                case 'admin_demoimporter':
                    JSVEHICLEMANAGERincluder::getJSModel('postinstallation')->getListOfDemoVersions();
                break;
            }
            $module = (is_admin()) ? 'page' : 'jsvmme';
            $module = JSVEHICLEMANAGERrequest::getVar($module, null, 'ages');
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

    function save(){
        $data = JSVEHICLEMANAGERrequest::get('post');
        $result = JSVEHICLEMANAGERincluder::getJSModel('postinstallation')->storeConfigurations($data);
        if($data['step'] == 1){
            $url = admin_url("admin.php?page=jsvm_postinstallation&jsvmlt=steptwo");
        }elseif($data['step'] == 2){
            $url = admin_url("admin.php?page=jsvm_postinstallation&jsvmlt=stepthree");
        }elseif($data['step'] == 3){
            $url = admin_url("admin.php?page=jsvm_postinstallation&jsvmlt=stepfour");
        }
        wp_redirect($url);
        exit();
    }

    function savesampledata(){
        $vehicle_manager_data = JSVEHICLEMANAGERrequest::getVar('vehicle_manager_data','',0);// zero as default value to handle diffretn cases
        $vehicle_manager_menu = JSVEHICLEMANAGERrequest::getVar('vehicle_manager_menu','',0);
        $result = JSVEHICLEMANAGERincluder::getJSModel('postinstallation')->installSampleData($vehicle_manager_data, $vehicle_manager_menu);
        if(jsvehiclemanager::$_car_manager_theme == 1){
            update_option( 'vehicles_sample_data', 1 );
            $url = admin_url("admin.php?page=jsvm_postinstallation&jsvmlt=demoimporter");
        }else{
            $url = admin_url("admin.php?page=jsvm_postinstallation&jsvmlt=stepfive");
        }
        wp_redirect($url);
        exit();
    }

    function importtemplatesampledata(){
        $flag = JSVEHICLEMANAGERrequest::getVar('flag','',0);// zero as default value to avoid problems
        if($flag != 'f'){
            $result = JSVEHICLEMANAGERincluder::getJSModel('postinstallation')->importTemplateSampleData($flag);
        }else{
            $result = 0;
        }
        $url = admin_url("admin.php?page=jsvm_postinstallation&jsvmlt=themedemodata&flag=".$result);
        wp_redirect($url);
        exit();
    }

    function getdemocode(){
        $demoid = JSVEHICLEMANAGERrequest::getVar('demoid');
        $foldername = JSVEHICLEMANAGERrequest::getVar('foldername');
        $demo_overwrite = JSVEHICLEMANAGERrequest::getVar('demo_overwrite');
        $result = JSVEHICLEMANAGERincluder::getJSModel('postinstallation')->getDemo($demoid,$foldername,$demo_overwrite);
        $url = admin_url("admin.php?page=jsvm_postinstallation&jsvmlt=stepfive");
        wp_redirect($url);
        exit();

    }
}
$JSVEHICLEMANAGERpostinstallationController = new JSVEHICLEMANAGERpostinstallationController();
?>
