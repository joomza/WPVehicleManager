<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERemailtemplatestatusController {

    private $_msgkey;

    function __construct() {
        $this->_msgkey = JSVEHICLEMANAGERincluder::getJSModel('emailtemplatestatus')->getMessagekey();
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'emailtemplatestatus');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_emailtemplatestatus':
                    JSVEHICLEMANAGERincluder::getJSModel('emailtemplatestatus')->getEmailTemplateStatusData();
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jsvmme';
            $module = JSVEHICLEMANAGERrequest::getVar($module, null, 'emailtemplatestatus');
            $module = str_replace('jsvm_', '', $module);
            JSVEHICLEMANAGERincluder::include_file($layout, $module);
        }
    }

    function sendEmail() {
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'send-email') ) {
            die( 'Security check Failed' ); 
        }
        $id = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerid');
        $action = JSVEHICLEMANAGERrequest::getVar('actionfor');
        JSVEHICLEMANAGERincluder::getJSModel('emailtemplatestatus')->sendEmailModel($id, $action); //  for send email
        $url = admin_url("admin.php?page=jsvm_emailtemplatestatus");
        wp_redirect($url);
        die();
    }

    function noSendEmail() {
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'nosend-email') ) {
            die( 'Security check Failed' ); 
        }
        $id = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerid');
        $action = JSVEHICLEMANAGERrequest::getVar('actionfor');
        JSVEHICLEMANAGERincluder::getJSModel('emailtemplatestatus')->noSendEmailModel($id, $action); //  for notsendemail
        $url = admin_url("admin.php?page=jsvm_emailtemplatestatus");
        wp_redirect($url);
        die();
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

$JSVEHICLEMANAGEREmailtemplatestatusController = new JSVEHICLEMANAGEREmailtemplatestatusController();
?>
