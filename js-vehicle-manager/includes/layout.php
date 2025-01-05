<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERlayout {

    static function getNoRecordFound($message = null, $linkarray = array()) {
        if($message == null){
            $message = __('Could not find any matching results', 'js-vehicle-manager');
        }
        $html = '
                <div class="js_vehiclemanager_error_messages_wrapper">
                    <div class="jsvehiclemanager_message1">
                        <span>
                            ' . __("Oops...", "js-vehicle-manager") . '
                        </span>
                    </div>
                    <div class="jsvehiclemanager_message2">
                         <span class="jsvehiclemanager_img">
                        <img class="js_vehiclemanager_messages_image" src="' . JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/norecordfound.png"/>
                         </span>
                         <span class="jsvehiclemanager_message-text">
                            ' . $message . '
                         </span>
                    </div>
                    <div class="jsvehiclemanager_footer">';

                        if(!empty($linkarray)){
                            foreach($linkarray AS $link){
                                $html .= '<a href="' . $link['link'] . '">' . $link['text'] . '</a>';
                            }
                        }

        $html .=    '</div>
                </div>
        ';
        echo $html;
    }

    static function getAdminPopupNoRecordFound() {
        $html = '
                <div class="jsvehiclemanager-popup-norecordfound">
                    <img class="jsvehiclemanager_jsautomessages_image" src="' . JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/info-icon.png"/>
                    '.__("No record found","js-vehicle-manager").'
                </div>
		';
        echo wp_kses($html, JSVEHICLEMANAGER_ALLOWED_TAGS);
    }

    static function getSystemOffline() {
        $offline_text = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('offline_message');
        $html = '
                <div class="js_vehiclemanager_error_messages_wrapper">
                    <div class="jsvehiclemanager_message1">
                        <span>
                            ' . __("Oops...", "js-vehicle-manager") . '
                        </span>
                    </div>
                    <div class="jsvehiclemanager_message2">
                         <span class="jsvehiclemanager_img">
                        <img class="js_vehiclemanager_messages_image" src="' . JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/offline.png"/>
                         </span>
                         <span class="jsvehiclemanager_message-text">
                            ' . $offline_text . '
                         </span>
                    </div>
                    <div class="jsvehiclemanager_footer">
                    </div>
                </div>
        ';
        echo wp_kses($html, JSVEHICLEMANAGER_ALLOWED_TAGS);
    }

    static function getUserGuest() {
        $html = '<div class="js_vehiclemanager_error_messages_wrapper">
                    <div class="jsvehiclemanager_message1">
                        <span>
                            ' . __("Oops...", "js-vehicle-manager") . '
                        </span>
                    </div>
                    <div class="jsvehiclemanager_message2">
                         <span class="jsvehiclemanager_img">
                        <img class="js_vehiclemanager_messages_image" src="' . JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/notloginicon.png"/>
                         </span>
                         <span class="jsvehiclemanager_message-text">
                            ' . __('To Access This Page Please Login', 'js-vehicle-manager') . '
                         </span>
                    </div>
                    <div class="jsvehiclemanager_footer">
                        <a href="' . get_the_permalink(jsvehiclemanager::getPageid()) . '">' . __('Back to control panel', 'js-vehicle-manager') . '</a>
                    </div>
                </div>
        ';
        echo wp_kses($html, JSVEHICLEMANAGER_ALLOWED_TAGS);
    }

    static function getRegistrationDisabled() {
        $html = '<div class="js_vehiclemanager_error_messages_wrapper">
                    <div class="jsvehiclemanager_message1">
                        <span>
                            ' . __("Oops...", "js-vehicle-manager") . '
                        </span>
                    </div>
                    <div class="jsvehiclemanager_message2 jsvehiclemanager_message3 ">
                         <span class="jsvehiclemanager_img">
                        <img class="js_vehiclemanager_messages_image" src="' . JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/disable.png"/>
                         </span>
                         <span class="jsvehiclemanager_message-text">
                            ' . __('Registration is disabled by admin, please contact to system administrator', 'js-vehicle-manager') . '
                         </span>
                    </div>
                    <div class="jsvehiclemanager_footer">
                    </div>
                </div>
        ';
        echo wp_kses($html, JSVEHICLEMANAGER_ALLOWED_TAGS);
    }

    static function getUserDisabledMsg() {
        $html = '<div class="js_vehiclemanager_error_messages_wrapper">
                    <div class="jsvehiclemanager_message1">
                        <span>
                            ' . __("Oops...", "js-vehicle-manager") . '
                        </span>
                    </div>
                    <div class="jsvehiclemanager_message2 jsvehiclemanager_message3 ">
                         <span class="jsvehiclemanager_img">
                        <img class="js_vehiclemanager_messages_image" src="' . JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/disable.png"/>
                         </span>
                         <span class="jsvehiclemanager_message-text">
                            ' . __('Your account is disabled, please contact system administrator!', 'js-vehicle-manager') . '
                         </span>
                    </div>
                    <div class="jsvehiclemanager_footer">
                    </div>
                </div>
        ';
        echo wp_kses($html, JSVEHICLEMANAGER_ALLOWED_TAGS);
    }


    static function setMessageFor($for, $link = null, $linktext = null, $return = 0) {
        $image = null;
        $description = '';
        switch ($for) {
            case '1': // User is guest
                $description = __('You are not logged in', 'js-vehicle-manager');
                break;
            case '2': // insufficient credits
                $description = __('You do not have sufficient credits', 'js-vehicle-manager');
                break;
            case '3': // Visitor
                $description = __('Visitor not allowed to perform this action', 'js-vehicle-manager');
                break;
            case '10': // User have no role
                $description = __('You are not allowed', 'js-vehicle-manager');
                break;
        }
        $html = JSVEHICLEMANAGERlayout::getUserNotAllowed($description, $link, $linktext, $image, $return,$for);
        if ($return == 1) {
            return $html;
        }
    }

    static function getUserNotAllowed($description, $link, $linktext, $image, $return = 0,$for = 0) {
        $html = '<div class="js_vehiclemanager_error_messages_wrapper">
                    <div class="jsvehiclemanager_message1">
                        <span>
                            ' . __("Oops...", "js-vehicle-manager") . '
                        </span>
                    </div>
                    <div class="jsvehiclemanager_message2">
                         <span class="jsvehiclemanager_img">
                        <img class="js_vehiclemanager_messages_image" src="' . JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/notallow.png"/>
                         </span>
                         <span class="jsvehiclemanager_message-text">
                            ' . $description . '

                         </span>
                    </div>
                    <div class="jsvehiclemanager_footer">
                    ';
        if($linktext == null){
            $linktext = "Login";
        }
        if ($link != null) {
            $html .= '<a class="button" href="' . $link . '">' . __($linktext,'js-vehicle-manager') . '</a>';
            if($for == 1){
                if(jsvehiclemanager::$_config['user_registration_custom_link_enabled'] == 1 && jsvehiclemanager::$_config['user_registration_custom_link'] != '' ){
                    $rlink = jsvehiclemanager::$_config['user_registration_custom_link'];
                }else{
                    $rlink = jsvehiclemanager::makeUrl(array("jsvmme"=>"user","jsvmlt"=>"userregister", "jsvehiclemanagerpageid"=>jsvehiclemanager::getPageid()));
                }
                $html .= '<a class="button" href="' . $rlink . '">' . __("Register",'js-vehicle-manager') . '</a>';
            }
        }
        $html .= '
                    </div>
                </div>
        ';
        if ($return == 0) {
            echo wp_kses($html, JSVEHICLEMANAGER_ALLOWED_TAGS);
        } else {
            return $html;
        }
    }

    static function addonMissingError(){
        $html = '<div class="error popup">
                    <p>'. __("This addon not exists in system. Please contact with administrator.","js-vehicle-manager") .'</p>
                </div>';
        return  json_encode($html);
    }
}

?>