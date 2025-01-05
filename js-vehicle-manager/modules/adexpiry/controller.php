<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERAdexpiryController {

    private $_msgkey;

    function __construct() {
        $this->_msgkey = JSVEHICLEMANAGERincluder::getJSModel('adexpiry')->getMessageKey();
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'adexpiries');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_adexpiries':
                    JSVEHICLEMANAGERincluder::getJSModel('adexpiry')->getAllAdexpiries();
                    break;
                case 'admin_formadexpiry':
                    $id = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerid');
                    JSVEHICLEMANAGERincluder::getJSModel('adexpiry')->getAdexpirybyId($id);
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jsvmme';
            $module = JSVEHICLEMANAGERrequest::getVar($module, null, 'adexpiry');
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

    function saveadexpiry() {
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'save-adexpiry') ) {
            die( 'Security check Failed' ); 
        }
        $data = JSVEHICLEMANAGERrequest::get('post');
        $url = admin_url("admin.php?page=jsvm_adexpiry&jsvmlt=adexpiries");
        $result = JSVEHICLEMANAGERincluder::getJSModel('adexpiry')->storeAdexpiry($data);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'adexpiry');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        wp_redirect($url);
        exit();
    }

    function remove() {
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-adexpiry') ) {
            die( 'Security check Failed' ); 
        }
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $result = JSVEHICLEMANAGERincluder::getJSModel('adexpiry')->deleteAdexpiry($ids);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'adexpiry');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_adexpiry&jsvmlt=adexpiries");
        wp_redirect($url);
        die();
    }

    function publish() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'publish-adexpiry') ) {
            die( 'Security check Failed' ); 
        }
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $result = JSVEHICLEMANAGERincluder::getJSModel('adexpiry')->publishUnpublish($ids, 1); //  for publish
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'record');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_adexpiry&jsvmlt=adexpiries");
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function unpublish() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'unpublish-adexpiry') ) {
            die( 'Security check Failed' ); 
        }
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $result = JSVEHICLEMANAGERincluder::getJSModel('adexpiry')->publishUnpublish($ids, 0); //  for unpublish
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'record');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_adexpiry&jsvmlt=adexpiries");
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

}

$JSVEHICLEMANAGERAdexpiryController = new JSVEHICLEMANAGERAdexpiryController();
?>
