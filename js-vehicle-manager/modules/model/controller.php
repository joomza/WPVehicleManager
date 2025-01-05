<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERModelController {

    private $_msgkey;

    function __construct() {
        $this->_msgkey = JSVEHICLEMANAGERincluder::getJSModel('model')->getMessagekey();
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'models');
        if (self::canaddfile()) {
            $makeid = JSVEHICLEMANAGERrequest::getVar('makeid');
            switch ($layout) {
                case 'admin_models':
                    JSVEHICLEMANAGERincluder::getJSModel('model')->getAllModels($makeid);
                    break;
                case 'admin_formmodel':
                    $id = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerid');
                    JSVEHICLEMANAGERincluder::getJSModel('model')->getModelbyId($id);
                    break;
            }
            if(is_numeric($makeid)){ // for admin listing and form
                jsvehiclemanager::$_data['makeid'] = $makeid;
                $db = new jsvehiclemanagerdb();
                // Make title
                $query = "SELECT title FROM `#__js_vehiclemanager_makes` WHERE id = ".$makeid;
                $db->setQuery($query);
                jsvehiclemanager::$_data['maketitle'] = $db->loadResult();
            }
            $module = (is_admin()) ? 'page' : 'jsvmme';
            $module = JSVEHICLEMANAGERrequest::getVar($module, null, 'models');
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

    function savemodel() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'save-model') ) {
            die( 'Security check Failed' );
        }
        $data = JSVEHICLEMANAGERrequest::get('post');
        $makeid = JSVEHICLEMANAGERrequest::getVar('makeid');
        $url = admin_url("admin.php?page=jsvm_model&jsvmlt=models&makeid=".$makeid);
        $result = JSVEHICLEMANAGERincluder::getJSModel('model')->storeModel($data);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'model');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        wp_redirect($url);
        exit();
    }

    function remove() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-model') ) {
            die( 'Security check Failed' );
        }
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $makeid = JSVEHICLEMANAGERrequest::getVar('makeid');
        if(!is_numeric($makeid)){
            $makeid = get_option( 'jsvehiclemanager-models-makeid' );
            delete_option( 'jsvehiclemanager-models-makeid' );
        }
        $result = JSVEHICLEMANAGERincluder::getJSModel('model')->deleteModel($ids);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'model');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_model&jsvmlt=models&makeid=".$makeid);
        wp_redirect($url);
        die();
    }

    function publish() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'publish-model') ) {
            die( 'Security check Failed' );
        }
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $makeid = JSVEHICLEMANAGERrequest::getVar('makeid');
        if(!is_numeric($makeid)){
            $makeid = update_option( 'jsvehiclemanager-models-makeid' , $makeid);
            delete_option( 'jsvehiclemanager-models-makeid' );
        }
        $result = JSVEHICLEMANAGERincluder::getJSModel('model')->publishUnpublish($ids, 1); //  for publish
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'record');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_model&jsvmlt=models&makeid=".$makeid);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function unpublish() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'unpublish-model') ) {
            die( 'Security check Failed' );
        }
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $makeid = JSVEHICLEMANAGERrequest::getVar('makeid');

        if(!is_numeric($makeid)){
            $makeid = update_option( 'jsvehiclemanager-models-makeid' , $makeid);
            delete_option( 'jsvehiclemanager-models-makeid' );
        }
        $result = JSVEHICLEMANAGERincluder::getJSModel('model')->publishUnpublish($ids, 0); //  for unpublish
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'record');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_model&jsvmlt=models&makeid=".$makeid);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

}

$JSVEHICLEMANAGERModelController = new JSVEHICLEMANAGERModelController();
?>
