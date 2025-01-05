<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERfieldorderingController {

    private $_msgkey;

    function __construct() {
        $this->_msgkey = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getMessagekey();
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'fieldsordering');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_fieldsordering':
                    $fieldfor = JSVEHICLEMANAGERrequest::getVar('ff');
                    jsvehiclemanager::$_data['fieldfor'] = $fieldfor;
                    JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getFieldsOrdering($fieldfor);
                    break;
                case 'admin_searchfieldsordering':
                    $fieldfor = JSVEHICLEMANAGERrequest::getVar('ff');
                    jsvehiclemanager::$_data['fieldfor'] = $fieldfor;
                    JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getSearchFieldsOrdering($fieldfor);
                    break;

                case 'admin_formuserfield':
                    $id = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerid');
                    $fieldfor = JSVEHICLEMANAGERrequest::getVar('ff');
                    if (empty($fieldfor)){
                        $fieldfor = jsvehiclemanager::$_data['fieldfor'];
                    }else{
                        jsvehiclemanager::$_data['fieldfor'] = $fieldfor;
                    }
                    jsvehiclemanager::$_data[0]['fieldfor'] = $fieldfor;
                    JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getUserFieldbyId($id, $fieldfor);
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jsvmme';
            $module = JSVEHICLEMANAGERrequest::getVar($module, null, 'fieldordering');
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

    function fieldrequired() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'required-field') ) {
            die( 'Security check Failed' );
        }
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');
        $fieldfor = JSVEHICLEMANAGERrequest::getVar('ff');
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $result = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->fieldsRequiredOrNot($ids, 1); // required
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'fieldordering');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url('admin.php?page=jsvm_fieldordering&jsvmlt=fieldsordering&ff=' . $fieldfor);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function fieldnotrequired() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'notrequired-field') ) {
            die( 'Security check Failed' );
        }
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');
        $fieldfor = JSVEHICLEMANAGERrequest::getVar('ff');
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $result = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->fieldsRequiredOrNot($ids, 0); // notrequired
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'fieldordering');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url('admin.php?page=jsvm_fieldordering&jsvmlt=fieldsordering&ff=' . $fieldfor);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function fieldpublished() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'publish-field') ) {
            die( 'Security check Failed' );
        }
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');
        $fieldfor = JSVEHICLEMANAGERrequest::getVar('ff');
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $result = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->fieldsPublishedOrNot($ids, 1);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'record');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url('admin.php?page=jsvm_fieldordering&jsvmlt=fieldsordering&ff=' . $fieldfor);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function fieldunpublished() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'unpublish-field') ) {
            die( 'Security check Failed' );
        }
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');
        $fieldfor = JSVEHICLEMANAGERrequest::getVar('ff');
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $result = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->fieldsPublishedOrNot($ids, 0);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'record');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url('admin.php?page=jsvm_fieldordering&jsvmlt=fieldsordering&ff=' . $fieldfor);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function visitorfieldpublished() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'vpublish-field') ) {
            die( 'Security check Failed' );
        }
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');
        $fieldfor = JSVEHICLEMANAGERrequest::getVar('ff');
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $result = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->visitorFieldsPublishedOrNot($ids, 1);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'record');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url('admin.php?page=jsvm_fieldordering&jsvmlt=fieldsordering&ff=' . $fieldfor);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function visitorfieldunpublished() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'vunpublish-field') ) {
            die( 'Security check Failed' );
        }
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');
        $fieldfor = JSVEHICLEMANAGERrequest::getVar('ff');
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $result = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->visitorFieldsPublishedOrNot($ids, 0);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'record');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url('admin.php?page=jsvm_fieldordering&jsvmlt=fieldsordering&ff=' . $fieldfor);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function fieldorderingup() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'fieldup-field') ) {
            die( 'Security check Failed' );
        }
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');
        $fieldfor = JSVEHICLEMANAGERrequest::getVar('ff');
        $id = JSVEHICLEMANAGERrequest::getVar('fieldid');
        $result = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->fieldOrderingUp($id);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'fieldordering');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url('admin.php?page=jsvm_fieldordering&jsvmlt=fieldsordering&ff=' . $fieldfor);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function fieldorderingdown() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'fielddown-field') ) {
            die( 'Security check Failed' );
        }
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');
        $fieldfor = JSVEHICLEMANAGERrequest::getVar('ff');
        $id = JSVEHICLEMANAGERrequest::getVar('fieldid');
        $result = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->fieldOrderingDown($id);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'fieldordering');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url('admin.php?page=jsvm_fieldordering&jsvmlt=fieldsordering&ff=' . $fieldfor);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function saveuserfield() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'save-field') ) {
            die( 'Security check Failed' );
        }
        $data = JSVEHICLEMANAGERrequest::get('post');
        $fieldfor = JSVEHICLEMANAGERrequest::getVar('fieldfor');
        if($fieldfor == ''){
            $fieldfor = $data['fieldfor'];
        }
        $result = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->storeUserField($data);
        if ($result === JSVEHICLEMANAGER_SAVE_ERROR || $result === false) {
            $url = admin_url("admin.php?page=jsvm_fieldordering&jsvmlt=formuserfield&ff=" . $fieldfor);
        } else
            $url = admin_url("admin.php?page=jsvm_fieldordering&ff=" . $fieldfor);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'customfield');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        wp_redirect($url);
        die();
    }

    function remove() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-field') ) {
            die( 'Security check Failed' );
        }
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');
        $id = JSVEHICLEMANAGERrequest::getVar('fieldid');
        $ff = JSVEHICLEMANAGERrequest::getVar('ff');
        $result = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->deleteUserField($id);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'fieldordering');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_fieldordering&ff=".$ff);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function savesearchfieldordering() {
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'savesearch-field') ) {
            die( 'Security check Failed' );
        }
        $data = JSVEHICLEMANAGERrequest::get('post');
        $fieldfor = JSVEHICLEMANAGERrequest::getVar('fieldfor');
        if($fieldfor == ''){
            $fieldfor = $data['fieldfor'];
        }
        $result = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->storeSearchFieldOrdering($data);
        $url = admin_url("admin.php?page=jsvm_fieldordering&jsvmlt=searchfieldsordering&ff=" . $fieldfor);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'fieldordering');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        wp_redirect($url);
        die();
    }

    function savesearchfieldorderingFromForm() {
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'savesearch-field') ) {
            die( 'Security check Failed' );
        }
        $data = JSVEHICLEMANAGERrequest::get('post');
        $fieldfor = JSVEHICLEMANAGERrequest::getVar('fieldfor');
        if($fieldfor == ''){
            $fieldfor = $data['fieldfor'];
        }
        $result = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->storeSearchFieldOrderingByForm($data);
        $url = admin_url("admin.php?page=jsvm_fieldordering&jsvmlt=searchfieldsordering&ff=" . $fieldfor);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'fieldordering');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'],$this->_msgkey);
        wp_redirect($url);
        die();
    }

}

$JSVEHICLEMANAGERfieldorderingController = new JSVEHICLEMANAGERfieldorderingController();
?>
