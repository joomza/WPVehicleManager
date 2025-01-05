<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERactivitylogController {

    function __construct() {

        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'activitylogs');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_activitylogs':
                    JSVEHICLEMANAGERincluder::getJSModel('activitylog')->getAllActivities();
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jsvmme';
            $module = JSVEHICLEMANAGERrequest::getVar($module, null, 'activitylog');
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

$JSVEHICLEMANAGERactivitylogController = new JSVEHICLEMANAGERactivitylogController();
?>
