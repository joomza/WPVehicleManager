<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERStateController {

    private $_msgkey;

    function __construct() {
        $this->_msgkey = JSVEHICLEMANAGERincluder::getJSModel('state')->getMessagekey();
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'states');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_states':
                    $countryid = JSVEHICLEMANAGERrequest::getVar('countryid');
                    if (!$countryid)
                        $countryid = get_option( 'jsvm_countryid_for_state','');

                    update_option("jsvm_countryid_for_state",$countryid);
                    JSVEHICLEMANAGERincluder::getJSModel('state')->getAllCountryStates($countryid);
                    break;
                case 'admin_formstate':
                    $id = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerid');
                    JSVEHICLEMANAGERincluder::getJSModel('state')->getStatebyId($id);
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jsvmme';
            $module = JSVEHICLEMANAGERrequest::getVar($module, null, 'states');
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

    function remove() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-state') ) {
            die( 'Security check Failed' );
        }
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $countryid = get_option( 'jsvm_countryid_for_state','');

        $result = JSVEHICLEMANAGERincluder::getJSModel('state')->deleteStates($ids);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'state');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_state&jsvmlt=states&countryid=" . $countryid);
        wp_redirect($url);
        die();
    }

    function publish() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'publish-state') ) {
            die( 'Security check Failed' );
        }
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $countryid = get_option( 'jsvm_countryid_for_state','');
        $result = JSVEHICLEMANAGERincluder::getJSModel('state')->publishUnpublish($ids, 1); //  for publish
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'record');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_state&jsvmlt=states&countryid=" . $countryid);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function unpublish() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'unpublish-state') ) {
            die( 'Security check Failed' );
        }
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $countryid = get_option( 'jsvm_countryid_for_state','');
        $result = JSVEHICLEMANAGERincluder::getJSModel('state')->publishUnpublish($ids, 0); //  for unpublish
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'record');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_state&jsvmlt=states&countryid=" . $countryid);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function savestate() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'save-state') ) {
            die( 'Security check Failed' );
        }
        $data = JSVEHICLEMANAGERrequest::get('post');
        $countryid = get_option( 'jsvm_countryid_for_state','');
        $result = JSVEHICLEMANAGERincluder::getJSModel('state')->storeState($data, $countryid);
        $url = admin_url("admin.php?page=jsvm_state&jsvmlt=states&countryid=" . $countryid);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'state');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        wp_redirect($url);
        die();
    }

}

$JSVEHICLEMANAGERStateController = new JSVEHICLEMANAGERStateController();
?>
