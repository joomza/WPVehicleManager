<?php
if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERVehicletypeController {

    private $_msgkey;

    function __construct() {
        $this->_msgkey = JSVEHICLEMANAGERincluder::getJSModel('vehicletype')->getMessagekey();
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'vehicletypes');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_vehicletypes':
                    JSVEHICLEMANAGERincluder::getJSModel('vehicletype')->getAllVehicletypes();
                    break;
                case 'admin_formvehicletype':
                    $id = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerid');
                    JSVEHICLEMANAGERincluder::getJSModel('vehicletype')->getVehicletypebyId($id);
                    break;
                case 'vehiclesbytype':
                    JSVEHICLEMANAGERincluder::getJSModel('vehicletype')->getVehiclesTypes();
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jsvmme';
            $module = JSVEHICLEMANAGERrequest::getVar($module, null, 'vehicletype');
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

    function savevehicletype() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'save-vehicletype') ) {
            die( 'Security check Failed' );
        }
        $data = JSVEHICLEMANAGERrequest::get('post');
        $url = admin_url("admin.php?page=jsvm_vehicletype&jsvmlt=vehicletypes");
        $result = JSVEHICLEMANAGERincluder::getJSModel('vehicletype')->storeVehicletype($data);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'vehicletype');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        wp_redirect($url);
        exit();
    }

    function remove() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-vehicletype') ) {
            die( 'Security check Failed' );
        }
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $result = JSVEHICLEMANAGERincluder::getJSModel('vehicletype')->deleteVehicletype($ids);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'vehicletype');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_vehicletype&jsvmlt=vehicletypes");
        wp_redirect($url);
        die();
    }

    function publish() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'publish-vehicletype') ) {
            die( 'Security check Failed' );
        }
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $result = JSVEHICLEMANAGERincluder::getJSModel('vehicletype')->publishUnpublish($ids, 1); //  for publish
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'record');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_vehicletype&jsvmlt=vehicletypes");
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function unpublish() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'unpublish-vehicletype') ) {
            die( 'Security check Failed' );
        }
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $result = JSVEHICLEMANAGERincluder::getJSModel('vehicletype')->publishUnpublish($ids, 0); //  for unpublish
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'record');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_vehicletype&jsvmlt=vehicletypes");
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

}

$JSVEHICLEMANAGERVehicletypeController = new JSVEHICLEMANAGERVehicletypeController();
?>
