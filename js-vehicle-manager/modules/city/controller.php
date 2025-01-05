<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERCityController {

    private $_msgkey;

    function __construct() {
        $this->_msgkey = JSVEHICLEMANAGERincluder::getJSModel('city')->getMessagekey();
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'cities');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_cities':
                    $countryid = JSVEHICLEMANAGERrequest::getVar('countryid');
                    $stateid = JSVEHICLEMANAGERrequest::getVar('stateid');

                    update_option("jsvm_countryid_for_city",$countryid);
                    update_option("jsvm_stateid_for_city",$stateid);
                    JSVEHICLEMANAGERincluder::getJSModel('city')->getAllStatesCities($countryid, $stateid);
                    break;
                case 'admin_formcity':
                    $id = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerid');
                    JSVEHICLEMANAGERincluder::getJSModel('city')->getCitybyId($id);
                    break;
                case 'vehiclesbycity':
                     JSVEHICLEMANAGERincluder::getJSModel('city')->getVehiclebyCities(get_the_ID());
                     jsvehiclemanager::$_data['config'] = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigByFor('vehiclebycity');
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jsvmme';
            $module = JSVEHICLEMANAGERrequest::getVar($module, null, 'city');
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

    function getaddressdatabycityname() {
        $cityname = JSVEHICLEMANAGERrequest::getVar('q');
        $result = JSVEHICLEMANAGERincluder::getJSModel('city')->getAddressDataByCityName($cityname);
        $json_response = json_encode($result);
        echo $json_response;
        exit();
    }

    function removecity() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-city') ) {
             die( 'Security check Failed' );
        }
        $countryid = get_option( 'jsvm_countryid_for_city');
        $stateid = get_option( 'jsvm_stateid_for_city');

        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $result = JSVEHICLEMANAGERincluder::getJSModel('city')->deleteCities($ids);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'city');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_city&jsvmlt=cities&countryid=" . $countryid . "&stateid=" . $stateid);
        wp_redirect($url);
        die();
    }

    function publish() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'publish-city') ) {
             die( 'Security check Failed' );
        }
        $countryid = get_option( 'jsvm_countryid_for_city');
        $stateid = get_option( 'jsvm_stateid_for_city');

        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $result = JSVEHICLEMANAGERincluder::getJSModel('city')->publishUnpublish($ids, 1); //  for publish
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'record');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_city&jsvmlt=cities&countryid=" . $countryid . "&stateid=" . $stateid);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function unpublish() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'unpublish-city') ) {
             die( 'Security check Failed' );
        }
        $countryid = get_option( 'jsvm_countryid_for_city');
        $stateid = get_option( 'jsvm_stateid_for_city');

        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum');
        $ids = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanager-cb');
        $result = JSVEHICLEMANAGERincluder::getJSModel('city')->publishUnpublish($ids, 0); //  for unpublish
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'record');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        $url = admin_url("admin.php?page=jsvm_city&jsvmlt=cities&countryid=" . $countryid . "&stateid=" . $stateid);
        if ($pagenum)
            $url .= "&pagenum=" . $pagenum;
        wp_redirect($url);
        die();
    }

    function savecity() {
        if(!is_admin())
            return false;
        $nonce = JSVEHICLEMANAGERrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'save-city') ) {
             die( 'Security check Failed' );
        }
        $countryid = get_option( 'jsvm_countryid_for_city');
        $stateid = get_option( 'jsvm_stateid_for_city');
        $url = admin_url("admin.php?page=jsvm_city&jsvmlt=cities&countryid=" . $countryid . "&stateid=" . $stateid);

        $data = JSVEHICLEMANAGERrequest::get('post');
        if ($data['stateid'])
            $stateid = $data['stateid'];
        $result = JSVEHICLEMANAGERincluder::getJSModel('city')->storeCity($data, $countryid, $stateid);
        $msg = JSVEHICLEMANAGERmessages::getMessage($result, 'city');
        JSVEHICLEMANAGERmessages::setLayoutMessage($msg['message'], $msg['status'], $this->_msgkey);
        wp_redirect($url);
        die();
    }

}

$JSVEHICLEMANAGERCityController = new JSVEHICLEMANAGERCityController();
?>
