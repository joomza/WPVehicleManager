<?php
if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERwidgetController {

    function __construct() {

        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'widgets');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_widgets':
                    JSVEHICLEMANAGERincluder::getJSModel('widget')->getAllActivities();
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jsvmme';
            $module = JSVEHICLEMANAGERrequest::getVar($module, null, 'widget');
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

$JSVEHICLEMANAGERwidgetController = new JSVEHICLEMANAGERwidgetController();
?>