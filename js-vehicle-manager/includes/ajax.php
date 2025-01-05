<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERajax {

    function __construct() {
        add_action("wp_ajax_jsvehiclemanager_ajax", array($this, "ajaxhandler")); // when user is login
        add_action("wp_ajax_nopriv_jsvehiclemanager_ajax", array($this, "ajaxhandler")); // when user is not login
        add_action("wp_ajax_jsvehiclemanager_ajax_popup", array($this, "ajaxhandlerpopup")); // when user is login
        add_action("wp_ajax_nopriv_jsvehiclemanager_ajax_popup", array($this, "ajaxhandlerpopup")); // when user is not login
        add_action("wp_ajax_jsvehiclemanager_ajax_popup_action", array($this, "ajaxhandlerpopupaction")); // when user is login
        add_action("wp_ajax_nopriv_jsvehiclemanager_ajax_popup_action", array($this, "ajaxhandlerpopupaction")); // when user is not login
        add_action("wp_ajax_jsvehiclemanager_loginwith_ajax", array($this, "ajaxhandlerloginwith")); // when user is login
        add_action("wp_ajax_nopriv_jsvehiclemanager_loginwith_ajax", array($this, "ajaxhandlerloginwith")); // when user is not login
    }

    function ajaxhandler() {
        $functions_allowed = array('getVehiclesModelsbyMakeMulti','storeVehicleAlert','removeCompareVehicleFromSession','getVehicleDataForComparePopup','scheduleTestDrive','makeAnOffer','getVehiclesModelsbyMake','savetokeninputcity','getVehicleImagesByVehicleIdAJAX','getSellerListAjax','sendToSeller','getUserListAjax','getPacakageListByUid','getlanguagetranslation','validateandshowdownloadfilename','getListTranslations','getSectionToFillValues','getFieldsForComboByFieldFor','getOptionsForFieldEdit','getLogForUserById','calculateVehicleFinance','sendmailtofriend','saveVehicleShortlist','DataForDepandantField','getTellaFriend','getNexttemplateVehicles','featured_vehicle','getShortlistViewByVehicleId','getDataForShortlistForTemplate','setInSessionAndRedirectForCompare','setListStyleSession');
        $task = JSVEHICLEMANAGERrequest::getVar('task');
        if($task != '' && in_array($task, $functions_allowed)){
            $module = JSVEHICLEMANAGERrequest::getVar('jsvmme');
            $file_path = JSVEHICLEMANAGERincluder::getPluginPath($module,'model');
            if(file_exists($file_path)){
                $result = JSVEHICLEMANAGERincluder::getJSModel($module)->$task();
                echo $result;
            }else{
                echo JSVEHICLEMANAGERlayout::addonMissingError();
            }

            die();
        }else{
            die('Not Allowed!');
        }
    }

    function ajaxhandlerpopup() {
        check_ajax_referer( 'wp_js_vm_nonce_check', 'wpnoncecheck' );
        $task = JSVEHICLEMANAGERrequest::getVar('task');
        do_action('jsvm_credits_ajaxcredits_getusercreditsdetail',$task);
        if(!in_array('credits', jsvehiclemanager::$_active_addons)){
            $isadmin = JSVEHICLEMANAGERrequest::getVar('isadmin');
            $popupformproceedactions = JSVEHICLEMANAGERincluder::getJSModel('common')->popupFormProceedActions($isadmin);
            $jsvehiclemanagerPopupResumeFormProceeds = $popupformproceedactions['popupresumeformproceeds'];
            $jsvehiclemanagerPopupFormProceeds = $popupformproceedactions['popupformproceeds'];
            $jsvehiclemanagerPopupProceeds = $popupformproceedactions['popupproceeds'];
            $proceedlang = $popupformproceedactions['proceedlang'];
            $formid = JSVEHICLEMANAGERrequest::getVar('formid');
            $action = 0;
            if ($formid && $formid == 'resumeform') {
                $popproceed = $jsvehiclemanagerPopupResumeFormProceeds;
            }else if($formid && $formid != 'resumeform'){
                $popproceed = $jsvehiclemanagerPopupFormProceeds;
            }else{
                $popproceed = $jsvehiclemanagerPopupProceeds;
            }
            $html = JSVEHICLEMANAGERincluder::getJSModel('common')->autoSubmitDataforVehicles($action,$formid,$task,$popproceed);
            echo $html;
        }
        die();
    }

    function ajaxhandlerpopupaction() {
        check_ajax_referer( 'wp_js_vm_nonce_check', 'wpnoncecheck' );
        $task = JSVEHICLEMANAGERrequest::getVar('task');
        $result = JSVEHICLEMANAGERincluder::getJSModel('common')->doAction($task);
        echo $result;
        die();
    }
}

$jsajax = new JSVEHICLEMANAGERajax();
?>
