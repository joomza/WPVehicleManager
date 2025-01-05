<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERCustomfieldController {

    private $_msgkey;

    function __construct() {
        $this->_msgkey = JSVEHICLEMANAGERIncluder::getJSModel('customfield')->getMessagekey();
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'userfields');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_userfields':
                    $fieldfor = JSVEHICLEMANAGERrequest::getVar('ff');
                    update_option( 'jsvm_customfield_ff', $fieldfor );
                    JSVEHICLEMANAGERincluder::getJSModel('customfield')->getUserFields($fieldfor);
                    jsvehiclemanager::$_data['fieldfor'] = $fieldfor;
                    break;
                case 'admin_formuserfield':
                    $id = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerid');
                    $fieldfor = JSVEHICLEMANAGERrequest::getVar('fieldfor');
                    if (empty($fieldfor))
                        $fieldfor = JSVEHICLEMANAGERrequest::getVar('ff');
                    if (empty($fieldfor))
                        $fieldfor = get_option( 'jsvm_customfield_ff' , 1 );

                    JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getUserFieldbyId($id, $fieldfor);
                    if ($fieldfor == 3)
                        JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getResumeSections($id);
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jsvmme';
            $module = JSVEHICLEMANAGERrequest::getVar($module, null, 'userfields');
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
        if (! wp_verify_nonce( $nonce, 'delete-customfield') ) {
            die( 'Security check Failed' );
        }
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvm-vm-cb');
        $fieldfor = get_option( 'jsvm_customfield_ff');
        $result = JSVEHICLEMANAGERincluder::getJSModel('customfield')->deleteUserFields($ids);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'customfield');
        $url = admin_url("admin.php?page=jsvm_customfield&jsvmlt=userfields&ff=" . $fieldfor);
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        wp_redirect($url);
        die();
    }

}

$JSVEHICLEMANAGERCustomfieldController = new JSVEHICLEMANAGERCustomfieldController();
?>
