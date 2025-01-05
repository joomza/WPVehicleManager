<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERjsvehiclemanagerController {

    function __construct() {

        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'controlpanel');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_controlpanel':
                    include_once JSVEHICLEMANAGER_PLUGIN_PATH . 'includes/updates/updates.php';
                    JSVEHICLEMANAGERupdates::checkUpdates();
                    JSVEHICLEMANAGERincluder::getJSModel('jsvehiclemanager')->getAdminControlPanelData();
                    break;
                case 'admin_jsvehiclemanagerstats':
                    JSVEHICLEMANAGERincluder::getJSModel('jsvehiclemanager')->getJSVehicleManagerStats();
                    break;
                case 'info':
                    $id = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerid');
                    JSVEHICLEMANAGERincluder::getJSModel('announcement')->getAnnouncementDetails($id);
                    break;
                case 'updates':
                    break;
                case 'login':
                    if(JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()){
                        $url = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerredirecturl', 'get');
                        if(isset($url)){
                            jsvehiclemanager::$_data[0]['redirect_url'] = base64_decode($url);
                        }else{
                            jsvehiclemanager::$_data[0]['redirect_url'] = home_url();
                        }
                    }
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jsvmme';
            $module = JSVEHICLEMANAGERrequest::getVar($module, null, 'jsvehiclemanager');
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
}

$JSVEHICLEMANAGERjsvehiclemanagerController = new JSVEHICLEMANAGERjsvehiclemanagerController();
?>
