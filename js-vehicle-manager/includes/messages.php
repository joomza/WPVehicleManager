<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERMessages {
    /*
     * setLayoutMessage
     * @params $message = Your message to display
     * @params $type = Messages types => 'updated','error','update-nag'
     */

    public static $counter;

    public static function setLayoutMessage($message, $type, $msgkey){
        JSVEHICLEMANAGERincluder::getObjectClass('wpvmnotification')->addSessionNotificationDataToTable($message,$type,'notification',$msgkey);
    }

    public static function getLayoutMessage($msgkey) {
        $frontend = (is_admin()) ? '' : 'frontend';
        $divHtml = '';
        $notificationdata = JSVEHICLEMANAGERincluder::getObjectClass('wpvmnotification')->getNotificationDatabySessionId('notification',$msgkey,true);
        if (isset($notificationdata['msg'][0]) && isset($notificationdata['type'][0])) {
            for ($i = 0; $i < COUNT($notificationdata['msg']); $i++){
                if(is_admin()){
                    if(isset($notificationdata['type'][$i])){
                        $divHtml .= '<div class="frontend ' . $notificationdata['type'][$i] . '"><p>' . $notificationdata['msg'][$i] . '</p></div>';
                    }
                }else{
                    if(isset($notificationdata['type'][$i])){
                        if(jsvehiclemanager::$_car_manager_theme == 1){
                            if($notificationdata['type'][$i] == 'updated'){
                                $alert_class = 'success';
                                $img_name = 'veh-alert-successful.png';
                            }elseif($notificationdata['type'][$i] == 'saved'){
                                $alert_class = 'success';
                                $img_name = 'veh-alert-successful.png';
                            }elseif($notificationdata['type'][$i] == 'saved'){
                                //$alert_class = 'info';
                                //$alert_class = 'warning';
                            }elseif($notificationdata['type'][$i] == 'error'){
                                $alert_class = 'danger';
                                $img_name = 'veh-aler-unsuccessful.png';
                            }
                            $divHtml .= '<div class="alert alert-' . $alert_class . '" role="alert" id="autohidealert">
                                            <img class="leftimg" src="'.JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/'.$img_name.'" />
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            '. $notificationdata['msg'][$i] . '
                                        </div>';
                        }else{
                            $divHtml .= '<div class=" ' . $frontend . ' ' . $notificationdata['type'][$i] . '"><p>' . $notificationdata['msg'][$i] . '</p></div>';
                        }
                    }
                }
            }
        }
        echo wp_kses($divHtml, JSVEHICLEMANAGER_ALLOWED_TAGS);
    }

    public static function getMSelectionEMessage() { // multi selection error message
        return __('Please first make a selection from the list', 'js-vehicle-manager');
    }

    public static function getMessage($result, $entity) {

        $msg['message'] = __('Unknown');
        $msg['status'] = "updated";
       
        $msg1 = JSVEHICLEMANAGERmessages::getEntityName($entity);

        switch ($result) {
            case 'RECAPTCHA_FAILED':
                $msg['message'] = __('Invalid recaptcha answer', 'js-vehicle-manager');
                $msg['status'] = 'error';
                break;
            case JSVEHICLEMANAGER_INVALID_REQUEST:
                $msg['message'] = __('Invalid request', 'js-vehicle-manager');
                $msg['status'] = 'error';
                break;
            case JSVEHICLEMANAGER_SAVED:
                $msg2 = __('has been successfully saved', 'js-vehicle-manager');
                if ($msg1)
                    $msg['message'] = $msg1 . ' ' . $msg2;
                break;
            case JSVEHICLEMANAGER_SAVE_ERROR:
                $msg['status'] = "error";
                $msg2 = __('has not been saved', 'js-vehicle-manager');
                if ($msg1)
                    $msg['message'] = $msg1 . ' ' . $msg2;
                break;
            case JSVEHICLEMANAGER_DELETED:
                if($entity == 'user')
                    $msg2 = __('has been successfully removed from our system', 'js-vehicle-manager');
                else
                    $msg2 = __('has been successfully deleted', 'js-vehicle-manager');
                if ($msg1)
                    $msg['message'] = $msg1 . ' ' . $msg2;
                break;
            case JSVEHICLEMANAGER_NOT_EXIST:
                $msg['status'] = "error";
                $msg['message'] = __('Record not exist', 'js-vehicle-manager');
                break;
            case JSVEHICLEMANAGER_DELETE_ERROR:
                $msg['status'] = "error";
                $msg2 = __('has not been deleted', 'js-vehicle-manager');
                if ($msg1) {
                    $msg['message'] = $msg1 . ' ' . $msg2;
                    if (JSVEHICLEMANAGERmessages::$counter) {
                        if(JSVEHICLEMANAGERmessages::$counter > 1){
                            $msg['message'] = JSVEHICLEMANAGERmessages::$counter . ' ' . $msg['message'];
                        }
                    }
                }
                break;
            case JSVEHICLEMANAGER_PUBLISHED:
                $msg2 = __('has been successfully published', 'js-vehicle-manager');
                if ($msg1) {
                    $msg['message'] = $msg1 . ' ' . $msg2;
                    if (JSVEHICLEMANAGERmessages::$counter) {
                        if(JSVEHICLEMANAGERmessages::$counter > 1){
                            $msg['message'] = JSVEHICLEMANAGERmessages::$counter . ' ' . $msg['message'];
                        }
                    }
                }
                break;
            case JSVEHICLEMANAGER_VERIFIED:
                $msg['message'] = __('transaction has been successfully verified', 'js-vehicle-manager');
                break;
            case JSVEHICLEMANAGER_UN_VERIFIED:
                $msg['message'] = __('transaction has been successfully unverified', 'js-vehicle-manager');
                break;
            case JSVEHICLEMANAGER_VERIFIED_ERROR:
                $msg['message'] = __('transaction has not been successfully verified', 'js-vehicle-manager');
                break;
            case JSVEHICLEMANAGER_UN_VERIFIED_ERROR:
                $msg['message'] = __('transaction has not been successfully unverified', 'js-vehicle-manager');
                break;
            case JSVEHICLEMANAGER_PUBLISH_ERROR:
                $msg['status'] = "error";
                $msg2 = __('has not been published', 'js-vehicle-manager');
                if ($msg1) {
                    $msg['message'] = $msg1 . ' ' . $msg2;
                    if (JSVEHICLEMANAGERmessages::$counter) {
                            $msg['message'] = JSVEHICLEMANAGERmessages::$counter . ' ' . $msg['message'];
                    }
                }
                break;
            case JSVEHICLEMANAGER_UN_PUBLISHED:
                $msg2 = __('has been successfully unpublished', 'js-vehicle-manager');
                if ($msg1) {
                    $msg['message'] = $msg1 . ' ' . $msg2;
                    if (JSVEHICLEMANAGERmessages::$counter) {
                        if(JSVEHICLEMANAGERmessages::$counter > 1){
                            $msg['message'] = JSVEHICLEMANAGERmessages::$counter . ' ' . $msg['message'];
                        }
                    }
                }
                break;
            case JSVEHICLEMANAGER_UN_PUBLISH_ERROR:
                $msg['status'] = "error";
                $msg2 = __('has not been unpublished', 'js-vehicle-manager');
                if ($msg1) {
                    $msg['message'] = $msg1 . ' ' . $msg2;
                    if (JSVEHICLEMANAGERmessages::$counter) {
                            $msg['message'] = JSVEHICLEMANAGERmessages::$counter . ' ' . $msg['message'];
                    }
                }
                break;
            case JSVEHICLEMANAGER_REQUIRED:
                $msg['message'] = __('Fields has been successfully required', 'js-vehicle-manager');
                break;
            case JSVEHICLEMANAGER_REQUIRED_ERROR:
                $msg['status'] = "error";
                if (JSVEHICLEMANAGERmessages::$counter) {
                    if (JSVEHICLEMANAGERmessages::$counter == 1)
                        $msg['message'] = JSVEHICLEMANAGERmessages::$counter . ' ' . __('Field has not been required', 'js-vehicle-manager');
                    else
                        $msg['message'] = JSVEHICLEMANAGERmessages::$counter . ' ' . __('Fields has not been required', 'js-vehicle-manager');
                }else {
                    $msg['message'] = __('Field has not been required', 'js-vehicle-manager');
                }
                break;
            case JSVEHICLEMANAGER_NOT_REQUIRED:
                $msg['message'] = __('Fields has been successfully not required', 'js-vehicle-manager');
                break;
            case JSVEHICLEMANAGER_NOT_REQUIRED_ERROR:
                $msg['status'] = "error";
                if (JSVEHICLEMANAGERmessages::$counter) {
                    if (JSVEHICLEMANAGERmessages::$counter == 1)
                        $msg['message'] = JSVEHICLEMANAGERmessages::$counter . ' ' . __('Field has not been not required', 'js-vehicle-manager');
                    else
                        $msg['message'] = JSVEHICLEMANAGERmessages::$counter . ' ' . __('Fields has not been not required', 'js-vehicle-manager');
                }else {
                    $msg['message'] = __('Field has not been not required', 'js-vehicle-manager');
                }
                break;
            case JSVEHICLEMANAGER_ORDER_UP:
                $msg['message'] = __('Field order up successfully', 'js-vehicle-manager');
                break;
            case JSVEHICLEMANAGER_ORDER_UP_ERROR:
                $msg['status'] = "error";
                $msg['message'] = __('Field order up error', 'js-vehicle-manager');
                break;
            case JSVEHICLEMANAGER_ORDER_DOWN:
                $msg['message'] = __('Field order down successfully', 'js-vehicle-manager');
                break;
            case JSVEHICLEMANAGER_ORDER_DOWN_ERROR:
                $msg['status'] = "error";
                $msg['message'] = __('Field order up error', 'js-vehicle-manager');
                break;
            case JSVEHICLEMANAGER_REJECTED:
                $msg2 = __('has been rejected', 'js-vehicle-manager');
                if ($msg1)
                    $msg['message'] = $msg1 . ' ' . $msg2;
                break;
            case JSVEHICLEMANAGER_APPLY:
                $msg2 = __('Vehicle applied successfully', 'js-vehicle-manager');
                $msg['message'] = $msg2;
                break;
            case JSVEHICLEMANAGER_APPLY_ERROR:
                $msg2 = __('Error in applying Vehicle', 'js-vehicle-manager');
                $msg['message'] = $msg2;
                $msg['status'] = "error";
                break;
            case JSVEHICLEMANAGER_REJECT_ERROR:
                $msg['status'] = "error";
                $msg2 = __('has not been rejected', 'js-vehicle-manager');
                if ($msg1)
                    $msg['message'] = $msg1 . ' ' . $msg2;
                break;
            case JSVEHICLEMANAGER_APPROVED:
                $msg2 = __('has been approved', 'js-vehicle-manager');
                if ($msg1)
                    $msg['message'] = $msg1 . ' ' . $msg2;
                break;
            case JSVEHICLEMANAGER_APPROVE_ERROR:
                $msg['status'] = "error";
                $msg2 = __('has not been approved', 'js-vehicle-manager');
                if ($msg1) {
                    $msg['message'] = $msg1 . ' ' . $msg2;
                    if (JSVEHICLEMANAGERmessages::$counter) {
                        $msg['message'] = JSVEHICLEMANAGERmessages::$counter . ' ' . $msg['message'];
                    }
                }
                break;
            case JSVEHICLEMANAGER_SET_DEFAULT:
                $msg2 = __('has been set as default', 'js-vehicle-manager');
                if ($msg1)
                    $msg['message'] = $msg1 . ' ' . $msg2;
                break;
            case JSVEHICLEMANAGER_UNPUBLISH_DEFAULT_ERROR:
                $msg['status'] = "error";
                $msg['message'] = __('Unpublished field cannot set default', 'js-vehicle-manager');
                break;
            case JSVEHICLEMANAGER_SET_DEFAULT_ERROR:
                $msg['status'] = "error";
                $msg2 = __('has not been set as default', 'js-vehicle-manager');
                if ($msg1)
                    $msg['message'] = $msg1 . ' ' . $msg2;
                break;
            case JSVEHICLEMANAGER_STATUS_CHANGED:
                $msg2 = __('status has been updated', 'js-vehicle-manager');
                if ($msg1)
                    $msg['message'] = $msg1 . ' ' . $msg2;
                break;
            case JSVEHICLEMANAGER_STATUS_CHANGED_ERROR:
                $msg['status'] = "error";
                $msg2 = __('has not been updated', 'js-vehicle-manager');
                if ($msg1)
                    $msg['message'] = $msg1 . ' ' . $msg2;
                break;
            case JSVEHICLEMANAGER_IN_USE:
                $msg['status'] = "error";
                $msg2 = __('in use cannot deleted', 'js-vehicle-manager');
                if ($msg1)
                    $msg['message'] = $msg1 . ' ' . $msg2;
                break;
            case JSVEHICLEMANAGER_ALREADY_EXIST:
                $msg['status'] = "error";
                $msg2 = __('already exist', 'js-vehicle-manager');
                if ($msg1)
                    $msg['message'] = $msg1 . ' ' . $msg2;
                break;
            case JSVEHICLEMANAGER_FILE_TYPE_ERROR:
                $msg['status'] = "error";
                $msg['message'] = __('File type error', 'js-vehicle-manager');
                break;
            case JSVEHICLEMANAGER_FILE_SIZE_ERROR:
                $msg['status'] = "error";
                $msg['message'] = __('File size error', 'js-vehicle-manager');
                break;
            case JSVEHICLEMANAGER_ENABLED:
                $msg['status'] = "updated";
                $msg2 = __('has been enabled', 'js-vehicle-manager');
                if ($msg1) {
                    $msg['message'] = $msg1 . ' ' . $msg2;
                }
                break;
            case JSVEHICLEMANAGER_DISABLED:
                $msg['status'] = "updated";
                $msg2 = __('has been disabled', 'js-vehicle-manager');
                if ($msg1) {
                    $msg['message'] = $msg1 . ' ' . $msg2;
                }
                break;
            case CAR_MANAGER_SOLD:
                $msg['status'] = "updated";
                $msg2 = __('has been marked as sold', 'js-vehicle-manager');
                if ($msg1) {
                    $msg['message'] = $msg1 . ' ' . $msg2;
                }
                break;
            case CAR_MANAGER_SOLD_ERROR:
                $msg['status'] = "updated";
                $msg2 = __('has not been marked as sold', 'js-vehicle-manager');
                if ($msg1) {
                    $msg['message'] = $msg1 . ' ' . $msg2;
                }
                break;
            case JSVEHICLEMANAGER_WOO_UNPUBLISHED:
                $msg['status'] = "updated";
                $msg['message'] = __('Credits pack successfully saved and unpublished.You should also disable package from woo commerce if have', 'js-vehicle-manager');
                break;
            case JSVEHICLEMANAGER_ALREADY_PURCHASED:
                $msg['status'] = "error";
                $msg['message'] = __('Can not purchase free package more than once', 'js-vehicle-manager');
                break;
            case JSVEHICLEMANAGER_EMPTY_LOSTUSERNAME:
                $msg['status'] = "error";
                $msg['message'] = __('You need to enter your email address to continue.', 'js-vehicle-manager');
                break;
            case JSVEHICLEMANAGER_INVALID_LOSTEMAIL:
                $msg['status'] = "error";
                $msg['message'] = __( 'There are no users registered with this email address.', 'js-vehicle-manager' );
                break;
            case JSVEHICLEMANAGER_CONFIRMEMAIL_RESET:
                $msg['status'] = "updated";
                $msg['message'] = __( 'Check your email for a link to reset your password.', 'js-vehicle-manager' );
                break;
            case JSVEHICLEMANAGER_EXPIRED_INVALID_KEY:
                $msg['status'] = "error";
                $msg['message'] = __( 'The password reset link you used is not valid anymore.', 'js-vehicle-manager' );
                break;
            case JSVEHICLEMANAGER_PASSWORD_RESET_MISMATCH:
                $msg['status'] = "error";
                $msg['message'] = __( 'Your entered password not matching.', 'js-vehicle-manager' );
                break;
            case JSVEHICLEMANAGER_PASSWORD_RESET_EMPTY:
                $msg['status'] = "error";
                $msg['message'] = __( 'Sorry, we donot accept empty passwords.', 'js-vehicle-manager' );
                break;
            case JSVEHICLEMANAGER_INVALID_LOSTREQUEST:
                $msg['status'] = "error";
                $msg['message'] = __( 'Sorry, your request is invalid. Please try again', 'js-vehicle-manager' );
                break;

        }
        return $msg;
    }

    static function getEntityName($entity) {
        $name = "";
        $entity = strtolower($entity);
        switch ($entity) {
            case 'adexpiry':$name = __('Ad-Expiry', 'js-vehicle-manager');
                break;
            case 'addressdata':$name = __('Address Data', 'js-vehicle-manager');
                break;
            case 'fueltypes':$name = __('Fuel type', 'js-vehicle-manager');
                break;
            case 'conditions':$name = __('Condition', 'js-vehicle-manager');
                break;
            case 'cylinders':$name = __('Cylinder', 'js-vehicle-manager');
                break;
            case 'modelyears':$name = __('Model year', 'js-vehicle-manager');
                break;
            case 'transmissions':$name = __('Transmission', 'js-vehicle-manager');
                break;
            case 'make':$name = __('Make', 'js-vehicle-manager');
                break;
            case 'vehicletype':$name = __('Vehicle type', 'js-vehicle-manager');
                break;
            case 'model':$name = __('Model', 'js-vehicle-manager');
                break;
            case 'country':$name = __('Country', 'js-vehicle-manager');
                break;
            case 'city':$name = __('City', 'js-vehicle-manager');
                break;
            case 'currency':$name = __('Currency', 'js-vehicle-manager');
                break;
            case 'creditspack':$name = __('Credits Pack', 'js-vehicle-manager');
                break;
            case 'credits':$name = __('Credits', 'js-vehicle-manager');
                break;
            case 'customfield':
            case 'fieldordering':$name = __('Field', 'js-vehicle-manager');
                break;
            case 'featuredvehicle':$name = __('Featured vehicle', 'js-vehicle-manager');
                break;
            case 'goldvehicle':$name = __('Gold vehicle', 'js-vehicle-manager');
                break;
            case 'vehiclealert':$name = __('Vehicle alert', 'js-vehicle-manager');
                break;
            case 'message':$name = __('Message', 'js-vehicle-manager');
                break;
            case 'paymenthistory':$name = __('Payment History', 'js-vehicle-manager');
                break;
            case 'paymentmethodconfiguration':$name = __('Payment Method Configuration', 'js-vehicle-manager');
                break;
            case 'state':$name = __('State', 'js-vehicle-manager');
                break;
            case 'seller':$name = __('Seller', 'js-vehicle-manager');
                break;
            case 'configuration':$name = __('Configuration', 'js-vehicle-manager');
                break;
            case 'emailtemplate':$name = __('Email Template', 'js-vehicle-manager');
                break;
            case 'purchasehistory':$name = __('Purchase History', 'js-vehicle-manager');
                break;
            case 'tag':$name = __('Tag', 'js-vehicle-manager');
                break;
            case 'record':
                    $name = __('record', 'js-vehicle-manager').'('. __('s','js-vehicle-manager') .')';
                break;
            case 'mileages':
                    $name = __('Mileage', 'js-vehicle-manager');
                break;
            case 'vehicle':
                    $name = __('Vehicle', 'js-vehicle-manager');
                break;
            case 'user':
                    $name = __('User', 'js-vehicle-manager');
                break;
            case 'shortlist':
                    $name = __('Shortlist Vehicle', 'js-vehicle-manager');
                break;
        }
        return $name;
    }

}

?>
