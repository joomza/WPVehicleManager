<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERConfigurationController {

    private $_msgkey;

    function __construct() {
        $this->_msgkey = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getMessagekey();
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'configurations');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_configurations':
                    JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationsForForm();
                    break;
                case 'admin_cronjob':
                    JSVEHICLEMANAGERincluder::getJSModel('configuration')->getCronKey(md5(date_i18n('Y-m-d')));
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jsvmme';
            $module = JSVEHICLEMANAGERrequest::getVar($module, null, 'configurations');
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

    function saveconfiguration() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'save-configuration') ) {
            die( 'Security check Failed' ); 
        }
        $data = JSVEHICLEMANAGERrequest::get('post');
        $layout = JSVEHICLEMANAGERrequest::getVar('jsvmlt');
        $result = JSVEHICLEMANAGERincluder::getJSModel('configuration')->storeConfig($data);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, "configuration");
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_configuration&jsvmlt=" . $layout);
        wp_redirect($url);
        die();
    }

}

$JSVEHICLEMANAGERConfigurationController = new JSVEHICLEMANAGERConfigurationController();
?>
