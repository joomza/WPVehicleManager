<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGEREmailtemplateController {

    private $_msgkey;

    function __construct() {
        $this->_msgkey = JSVEHICLEMANAGERincluder::getJSModel('emailtemplate')->getMessagekey();
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'emailtemplate');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_emailtemplate':
                    $for = JSVEHICLEMANAGERrequest::getVar('for', null, 'nw-ve-a');
                    $tempfor = $this->parseTemplateFor($for);
                    JSVEHICLEMANAGERincluder::getJSModel('emailtemplate')->getTemplate($tempfor);
                    jsvehiclemanager::$_data[1] = $for;
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jsvmme';
            $module = JSVEHICLEMANAGERrequest::getVar($module, null, 'emailtemplate');
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

    function saveemailtemplate() {
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'save-emailtemplate') ) {
            die( 'Security check Failed' ); 
        }
        $data = JSVEHICLEMANAGERrequest::get('post');
        $templatefor = $data['templatefor'];
        $result = JSVEHICLEMANAGERincluder::getJSModel('emailtemplate')->storeEmailTemplate($data);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'emailtemplate');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);

        switch ($templatefor){
            case 'new-vehicle-admin' : $tempfor = 'nw-ve-a'; break;
            case 'new-vehicle' : $tempfor = 'nw-ve'; break;
            case 'visitor-vehicle' : $tempfor = 'nw-ve-v'; break;
            case 'vehicle-status' : $tempfor = 've-st'; break;
            case 'delete-vehicle' : $tempfor = 'de-ve'; break;
            case 'credits-purchase-admin' : $tempfor = 'cr-pr-a'; break;
            case 'credits-purchase' : $tempfor = 'cr-pr'; break;
            case 'credits-expiry' : $tempfor = 'cr-ex'; break;
            case 'new-seller' : $tempfor = 'nw-sl'; break;
            case 'vehicle-alert' : $tempfor = 've-al'; break;
            case 'tell-a-friend' : $tempfor = 't-a-fr'; break;
            case 'make-an-offer' : $tempfor = 'mk-a-of'; break;
            case 'schedule-test-drive' : $tempfor = 'sc-t-dr'; break;
            case 'message-to-sender' : $tempfor = 'mg-t-sr'; break;
        }

        $url = admin_url("admin.php?page=jsvm_emailtemplate&for=" . $tempfor);
        wp_redirect($url);
        die();
    }
    
    function parseTemplateFor($for) {
        switch ($for){
            case 'nw-ve-a' : $templatefor = 'new-vehicle-admin'; break;
            case 'nw-ve' : $templatefor = 'new-vehicle'; break;
            case 'nw-ve-v' : $templatefor = 'visitor-vehicle'; break;
            case 've-st' : $templatefor = 'vehicle-status'; break;
            case 'de-ve' : $templatefor = 'delete-vehicle'; break;
            case 'cr-pr-a' : $templatefor = 'credits-purchase-admin'; break;
            case 'cr-pr' : $templatefor = 'credits-purchase'; break;
            case 'cr-ex' : $templatefor = 'credits-expiry'; break;
            case 'nw-sl' : $templatefor = 'new-seller'; break;
            case 've-al' : $templatefor = 'vehicle-alert'; break;
            case 't-a-fr' : $templatefor = 'tell-a-friend'; break;
            case 'mk-a-of' : $templatefor = 'make-an-offer'; break;
            case 'sc-t-dr' : $templatefor = 'schedule-test-drive'; break;
            case 'mg-t-sr' : $templatefor = 'message-to-sender'; break;

        }
        return $templatefor;
    }

}

$JSVEHICLEMANAGEREmailtemplateController = new JSVEHICLEMANAGEREmailtemplateController();
?>
