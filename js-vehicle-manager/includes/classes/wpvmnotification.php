<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERwpvmnotification {

    function __construct( ) {

    }

    public function addSessionNotificationDataToTable($message, $msgtype, $sessiondatafor = 'notification',$msgkey = 'captcha'){
        /*$message belows to repsonse message
        $msgtyp belongs to reponse type eg error or success
        $sessiondatafor belong to any random thing or reponse notification after saving some data
        $msgkey belong to module
        */
        if($message == ''){
            if(!is_numeric($message))
                return false;
        }
        global $wpdb;
        $data = array();
        $update = false;
        if(isset($_COOKIE['_wpjsvm_session_']) && isset(jsvehiclemanager::$_jsvmhdsession->sessionid)){
            if($sessiondatafor == 'notification'){
                $data = $this->getNotificationDatabySessionId($sessiondatafor);
                if(empty($data)){
                    $data['msg'][0] = $message;
                    $data['type'][0] = $msgtype;
                }else{
                    $update = true;
                    $count = count($data['msg']);
                    $data['msg'][$count] = $message;
                    $data['type'][$count] = $msgtype;
                }
            }

            if($sessiondatafor == 'jsvehiclemanager_spamcheckid'){
                $msgkey = 'captcha';
                $data = $this->getNotificationDatabySessionId($sessiondatafor,$msgkey);
                if($data != ""){
                    $update = true;
                    $data = $message;
                }else{
                    $data = $message;
                }
            }
            if($sessiondatafor == 'jsvehiclemanager_rot13'){
                $msgkey = 'captcha';
                $data = $this->getNotificationDatabySessionId($sessiondatafor,$msgkey);
                if($data != ""){
                    $update = true;
                    $data = $message;
                }else{
                    $data = $message;
                }
            }
            if($sessiondatafor == 'jsvehiclemanager_spamcheckresult'){
                $msgkey = 'captcha';
                $data = $this->getNotificationDatabySessionId($sessiondatafor,$msgkey);
                if($data != ""){
                    $update = true;
                    $data = $message;
                }else{
                    $data = $message;
                }
            }


            $data = json_encode($data , true);
            $sessionmsg = base64_encode($data);
            if(!$update){
                $wpdb->insert( "{$wpdb->prefix}js_vehiclemanager_jsvmsessiondata", array("usersessionid" => jsvehiclemanager::$_jsvmhdsession->sessionid, "sessionmsg" => $sessionmsg, "sessionexpire" => jsvehiclemanager::$_jsvmhdsession->sessionexpire, "sessionfor" => $sessiondatafor , "msgkey" => $msgkey) );
            }else{
                $wpdb->update( "{$wpdb->prefix}js_vehiclemanager_jsvmsessiondata", array("sessionmsg" => $sessionmsg), array("usersessionid" => jsvehiclemanager::$_jsvmhdsession->sessionid , 'sessionfor' => $sessiondatafor) );
            }
        }
        return false;
    }

    public function getNotificationDatabySessionId($sessionfor , $msgkey = null, $deldata = false){
        if(jsvehiclemanager::$_jsvmhdsession->sessionid == '')
            return false;
        global $wpdb;
        $data = $wpdb->get_var( "SELECT sessionmsg FROM {$wpdb->prefix}js_vehiclemanager_jsvmsessiondata WHERE usersessionid = '" . jsvehiclemanager::$_jsvmhdsession->sessionid . "' AND sessionfor = '" . $sessionfor . "' AND sessionexpire > '" . time() . "' AND msgkey = '" . $msgkey . "'");
        if(!empty($data)){
            $data = base64_decode($data);
            $data = json_decode( $data , true);
        }
        if($deldata){
            $wpdb->delete( "{$wpdb->prefix}js_vehiclemanager_jsvmsessiondata", array( 'usersessionid' => jsvehiclemanager::$_jsvmhdsession->sessionid , 'sessionfor' => $sessionfor , 'msgkey' => $msgkey) );
        }
        return $data;
    }

}

?>
