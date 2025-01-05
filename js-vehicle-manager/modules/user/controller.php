<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERUserController {

    private $_msgkey;

    function __construct() {
        $this->_msgkey = JSVEHICLEMANAGERincluder::getJSModel('user')->getMessagekey();
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'users');
        $uid = JSVEHICLEMANAGERincluder::getObjectClass('user')->uid();
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_users':
                    JSVEHICLEMANAGERincluder::getJSModel('user')->getAllprofile();
                break;
                case 'admin_profile':
                    $id = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerid');
                    JSVEHICLEMANAGERincluder::getJSModel('user')->getProfileByUid($id);
                break;
                case 'sellerlist':
                    JSVEHICLEMANAGERincluder::getJSModel('user')->getAllSellerInfos();
                break;
                case 'viewsellerinfo':
                    $id = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerid');
                    JSVEHICLEMANAGERincluder::getJSModel('user')->getAllSellerInfoForView($id);
                    jsvehiclemanager::$_data['config'] = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigByFor('recaptcha');
                break;
                case 'myprofile':
                if(JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()){
                    if(jsvehiclemanager::$_car_manager_theme == 1){
                    	jsvehiclemanager::$_error_flag_message = CAR_MANAGER_GUEST;
                    }else{
                    	jsvehiclemanager::$_error_flag_message = JSVEHICLEMANAGERLayout::setMessageFor(3,null,null,1);
                    }
                }else{
                    JSVEHICLEMANAGERincluder::getJSModel('user')->getProfileByUid($uid);
                }
                break;
                case 'dashboard':
                    jsvehiclemanager::$_data['config'] = JSVEHICLEMANAGERincluder::getJSModel("configuration")->getConfigByFor("dashboard");
                    if(!JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()){
                        JSVEHICLEMANAGERincluder::getJSModel('user')->getProfileByUid($uid);
                        JSVEHICLEMANAGERincluder::getJSModel('user')->getDataForDashboardTab($uid);
                        do_action('jsvm_credits_get_purchasehistory_data',$uid);
                        do_action('jsvm_credits_get_user_creditslog_dashboard',$uid);
                    }else{
                        jsvehiclemanager::$_js_login_redirct_link = JSVEHICLEMANAGERincluder::getJSModel('common')->jsMakeRedirectURL('user', $layout);
                        if(jsvehiclemanager::$_car_manager_theme == 1){
                        	jsvehiclemanager::$_error_flag_message = CAR_MANAGER_GUEST;
                        }else{
                        	jsvehiclemanager::$_error_flag_message = JSVEHICLEMANAGERLayout::setMessageFor(3,null,null,1);
                        }
                    }
                break;
                case 'admin_formprofile':
                case 'profile':
                    if (is_admin()) {
                        $uid = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerid');
                    }
                    if(!JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()){
                        JSVEHICLEMANAGERincluder::getJSModel('user')->getProfileByUid($uid);
                        JSVEHICLEMANAGERincluder::getJSModel('user')->getDataForProfileForm($uid);
                    }else{
                        jsvehiclemanager::$_js_login_redirct_link = JSVEHICLEMANAGERincluder::getJSModel('common')->jsMakeRedirectURL('user', $layout);
                        if(jsvehiclemanager::$_car_manager_theme == 1){
                        	jsvehiclemanager::$_error_flag_message = CAR_MANAGER_GUEST;
                        }else{
                        	jsvehiclemanager::$_error_flag_message = JSVEHICLEMANAGERLayout::setMessageFor(3,null,null,1);
                        }
                    }
                break;
                case 'userregister':
                        jsvehiclemanager::$_data[2] = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getFieldsOrderingByFor(2);
                break;
                case 'sellersbycity':
                        JSVEHICLEMANAGERincluder::getJSModel('user')->getSellersbyCities(get_the_ID());
                        jsvehiclemanager::$_data['config'] = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigByFor('sellerbycity');
                break;
                case 'stats':
                        if(!JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()){
                            JSVEHICLEMANAGERincluder::getJSModel('user')->getUserStats($uid);
                        }else{
                            jsvehiclemanager::$_js_login_redirct_link = JSVEHICLEMANAGERincluder::getJSModel('common')->jsMakeRedirectURL('user', $layout);
                            $link = JSVEHICLEMANAGERincluder::getJSModel('common')->jsMakeRedirectURL('user', $layout);
                            if(jsvehiclemanager::$_car_manager_theme == 1){
                                jsvehiclemanager::$_error_flag_message = CAR_MANAGER_GUEST;
                            }else{
                                jsvehiclemanager::$_error_flag_message = JSVEHICLEMANAGERLayout::setMessageFor(1,$link,null,1);
                            }
                        }
                break;
            }
            $module = (is_admin()) ? 'page' : 'jsvmme';
            $module = JSVEHICLEMANAGERrequest::getVar($module, null, 'user');
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

    function saveprofile() {
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'save-user') ) {
            die( 'Security check Failed' );
        }
        $data = JSVEHICLEMANAGERrequest::get('post');
        if (is_admin()) {
           $url = admin_url("admin.php?page=jsvm_user&jsvmlt=users");
        } else {
            $url = jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerpageid'), 'jsvmme'=>'user', 'jsvmlt'=>'profile'));
        }
        $result = JSVEHICLEMANAGERincluder::getJSModel('user')->storeProfile($data);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'user');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        wp_redirect($url);
        exit();
    }

    function remove() { // only delete VM records
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-user') ) {
            die( 'Security check Failed' );
        }
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $result = JSVEHICLEMANAGERincluder::getJSModel('user')->deleteUserData($ids);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'user');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_user&jsvmlt=users");
        wp_redirect($url);
        die();
    }

    function enforceremove() { // delete eitire user
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-user') ) {
            die( 'Security check Failed' );
        }
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $result = JSVEHICLEMANAGERincluder::getJSModel('user')->enforceDeleteUserData($ids);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'user');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_user&jsvmlt=users");
        wp_redirect($url);
        die();
    }

    function publish() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'publish-user') ) {
            die( 'Security check Failed' );
        }
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $result = JSVEHICLEMANAGERincluder::getJSModel('user')->publishUnpublish($ids, 1); //  for publish
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'record');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_user&jsvmlt=users");
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function unpublish() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'unpublish-user') ) {
            die( 'Security check Failed' );
        }
        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $result = JSVEHICLEMANAGERincluder::getJSModel('user')->publishUnpublish($ids, 0); //  for unpublish
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'record');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_user&jsvmlt=users");
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function getsellersbysellername() {
        $sellername = JSVEHICLEMANAGERrequest::getVar('q');
        $result = JSVEHICLEMANAGERincluder::getJSModel('user')->getSellersBySellerName($sellername);
        $json_response = json_encode($result);
        echo $json_response;
        exit();
    }
}
$JSVEHICLEMANAGERUserController = new JSVEHICLEMANAGERUserController();
?>
