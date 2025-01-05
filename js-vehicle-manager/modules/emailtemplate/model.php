<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGEREmailtemplateModel {

    function sendMail($mailfor, $action, $id) {
        if (!is_numeric($mailfor))
            return false;
        if (!is_numeric($action))
            return false;
        if ($id != null)
            if (!is_numeric($id))
                return false;
        $config_array = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigByFor('email');
        $senderEmail = $config_array['mailfromaddress'];
        $senderName = $config_array['mailfromname'];
        $adminEmailid = $config_array['adminemailaddress'];

        $isguest = JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest();
        $pageid = jsvehiclemanager::getPageid();
        switch ($mailfor) {
            case 1: // Vehicle
                switch ($action) {
                    case 1: // Add New
                        $creditid = JSVEHICLEMANAGERrequest::getVar('creditid');

                        $record = $this->getRecordByTablenameAndId('js_vehiclemanager_vehicles', $id,$creditid);
                        if(empty($record)){
                            return;
                        }
                        $username = $record->name;
                        $vehname = $record->maketitle.'-'.$record->modeltitle.'-'.$record->modelyeartitle;
                        $email = $record->email;
                        $status = $record->status;
                        $location = $record->location;
                        $maketitle = $record->maketitle;
                        $modeltitle = $record->modeltitle;
                        $modelyeartitle = $record->modelyeartitle;

                        $credits = isset($record->credtitsforaddvehicle) ? $record->credtitsforaddvehicle : 0;
                        $checkstatus = null;

                        $link = null;
                        if ($status == 1) {
                            $checkstatus = __('Approved', 'js-vehicle-manager');
                            $link = '<a href="' . jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid(), 'jsvmme'=>'vehicle', 'jsvmlt'=>'vehicledetail', 'jsvehiclemanagerid'=>$id)) .'" target="_blank">' . __('Vehicle Detail', 'js-vehicle-manager') . '</a>';
                        }
                        if ($status == -1) {
                            $checkstatus = __('Rejected', 'js-vehicle-manager');
                            $link = '<a href="' . jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid(), 'jsvmme'=>'vehicle' , 'jsvmlt' => 'myvehicles' )) .'" target="_blank">' . __('Vehicles', 'js-vehicle-manager') . '</a>';
                        }
                        if ($status == 0) {
                            $checkstatus = __('Pending', 'js-vehicle-manager');
                            $link = '<a href="' . jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid(), 'jsvmme'=>'vehicle' , 'jsvmlt' => 'myvehicles' )) .'" target="_blank">' . __('Vehicles', 'js-vehicle-manager') . '</a>';
                        }

                        $matcharray = array(
                            '{VEHICLE_TITLE}' => $vehname,
                            '{SELLER_NAME}' => $username,
                            '{VEHICLE_LINK}' => $link,
                            '{VEHICLE_STATUS}' => $checkstatus,
                            '{VEHICLE_CREDITS}' => $credits,
                            '{LOCATION}' => $location,
                        );

                        // code for handling custom fields start
                        if(!empty($record->vehparams)){
                            $vdata = json_decode($record->vehparams,true);
                        }
                        if(!empty($record->userparams)){
                            $udata = json_decode($record->userparams,true);
                        }
                        $fields = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getUserfieldsforEmail();
                        foreach ($fields as $field) {
                            if( isset($vdata) && is_array($vdata)){
                                if($field->userfieldtype != 'file'){
                                    $fvalue1 = '';
                                    if(array_key_exists($field->field, $vdata)){
                                        $fvalue1 = $vdata[$field->field];
                                    }
                                    $matcharray['{'.$field->field.'_1'.'}'] = $fvalue1;// match array new index for custom field
                                }
                            }
                            if( isset($udata) && is_array($udata)){
                                if($field->userfieldtype != 'file'){
                                    $fvalue2 = '';
                                    if(array_key_exists($field->field, $udata)){
                                        $fvalue2 = $udata[$field->field];
                                    }
                                    $matcharray['{'.$field->field.'_2'.'}'] = $fvalue2;// match array new index for custom field
                                }
                            }
                        }
                        // code for handling custom fields end

                        $getEmailStatus = JSVEHICLEMANAGERincluder::getJSModel('emailtemplatestatus')->getEmailTemplateStatus('add_new_vehicle');

                        $template = $this->getTemplateForEmail('new-vehicle');
                        $msgSubject = $template->subject;
                        $msgBody = $template->body;
                        $this->replaceMatches($msgSubject, $matcharray);
                        $this->replaceMatches($msgBody, $matcharray);

                        // Add New vehicle mail to User

                        if ($getEmailStatus->seller == 1) {
                            $this->sendEmail($email, $msgSubject, $msgBody, $senderEmail, $senderName, '');
                        }

                        if ($getEmailStatus->admin == 1) {
                            $template = $this->getTemplateForEmail('new-vehicle-admin');
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $link = '<a href="' . admin_url("admin.php?page=jsvm_vehicle") .'" target="_blank">' . __('Vehicles', 'js-vehicle-manager') . '</a>';
                            $matcharray['{VEHICLE_LINK}'] = $link;
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);

                            $this->sendEmail($adminEmailid, $msgSubject, $msgBody, $senderEmail, $senderName, '');
                        }
                        break;
                    case 2: // Vehicle Delete
                        $getEmailStatus = JSVEHICLEMANAGERincluder::getJSModel('emailtemplatestatus')->getEmailTemplateStatus('delete_vehicle');
                        if ($getEmailStatus->seller == 1) {
                            if(isset($_COOKIE['autoz-email-useremail'])){
                                $matcharray = array(
                                    '{SELLER_NAME}' => isset($_COOKIE['autoz-email-sellername']) ? $_COOKIE['autoz-email-sellername'] : '',
                                    '{VEHICLE_TITLE}' => isset($_COOKIE['autoz-email-vehicletitle']) ? $_COOKIE['autoz-email-vehicletitle'] : ''
                                );
                                $email = isset($_COOKIE['autoz-email-useremail']) ? $_COOKIE['autoz-email-useremail'] : '';

                                $template = $this->getTemplateForEmail('delete-vehicle');
                                $msgSubject = $template->subject;
                                $msgBody = $template->body;
                                $this->replaceMatches($msgSubject, $matcharray);
                                $this->replaceMatches($msgBody, $matcharray);

                                setcookie('autoz-email-useremail' , '' , time()-3600 , COOKIEPATH);
                                if ( SITECOOKIEPATH != COOKIEPATH ){
                                    setcookie('autoz-email-useremail' , '' , time() - 3600 , SITECOOKIEPATH);
                                }
                                // vehicle Delete mail to User
                                $this->sendEmail($email, $msgSubject, $msgBody, $senderEmail, $senderName, '');
                            }
                        }
                        break;
                    case 3: // VEHICLE approve OR reject
                        $creditid = JSVEHICLEMANAGERrequest::getVar('creditid');

                        $record = $this->getRecordByTablenameAndId('js_vehiclemanager_vehicles', $id,$creditid);
                        if(empty($record)){
                            return;
                        }
                        $username = $record->name;
                        $vehname = $record->maketitle.'-'.$record->modeltitle.'-'.$record->modelyeartitle;
                        $email = $record->email;
                        $status = $record->status;
                        $location = $record->location;
                        $maketitle = $record->maketitle;
                        $modeltitle = $record->modeltitle;
                        $modelyeartitle = $record->modelyeartitle;

                        $credits = isset($record->credtitsforaddvehicle) ? $record->credtitsforaddvehicle : 0;

                        $link = null;
                        $checkstatus = null;
                        if ($status == 1) {
                            $checkstatus = __('Approved', 'js-vehicle-manager');
                            $link = '<a href="' . jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid(), 'jsvmme'=>'vehicle', 'jsvmlt'=>'vehicledetail', 'jsvehiclemanagerid'=>$id)) .'" target="_blank">' . __('Vehicle Detail', 'js-vehicle-manager') . '</a>';
                        }
                        if ($status == -1) {
                            $checkstatus = __('Rejected', 'js-vehicle-manager');
                            $link = '<a href="' . jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid(), 'jsvmme'=>'vehicle' , 'jsvmlt' => 'myvehicles' )) .'" target="_blank">' . __('My Vehicles', 'js-vehicle-manager') . '</a>';
                        }

                        $matcharray = array(
                            '{VEHICLE_TITLE}' => $vehname,
                            '{SELLER_NAME}' => $username,
                            '{VEHICLE_LINK}' => $link,
                            '{VEHICLE_STATUS}' => $checkstatus,
                            '{VEHICLE_CREDITS}' => $credits,
                            '{LOCATION}' => $location
                        );

                        // code for handling custom fields start
                        if(!empty($record->vehparams)){
                            $vdata = json_decode($record->vehparams,true);
                        }
                        if(!empty($record->userparams)){
                            $udata = json_decode($record->userparams,true);
                        }
                        $fields = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getUserfieldsforEmail();
                        foreach ($fields as $field) {
                            if( isset($vdata) && is_array($vdata)){
                                if($field->userfieldtype != 'file'){
                                    $fvalue1 = '';
                                    if(array_key_exists($field->field, $vdata)){
                                        $fvalue1 = $vdata[$field->field];
                                    }
                                    $matcharray['{'.$field->field.'_1'.'}'] = $fvalue1;// match array new index for custom field
                                }
                            }
                            if( isset($udata) && is_array($udata)){
                                if($field->userfieldtype != 'file'){
                                    $fvalue2 = '';
                                    if(array_key_exists($field->field, $udata)){
                                        $fvalue2 = $udata[$field->field];
                                    }
                                    $matcharray['{'.$field->field.'_2'.'}'] = $fvalue2;// match array new index for custom field
                                }
                            }
                        }
                        // code for handling custom fields end

                        $template = $this->getTemplateForEmail('vehicle-status');
                        $getEmailStatus = JSVEHICLEMANAGERincluder::getJSModel('emailtemplatestatus')->getEmailTemplateStatus('vehicle_status');

                        $msgSubject = $template->subject;
                        $msgBody = $template->body;
                        $this->replaceMatches($msgSubject, $matcharray);
                        $this->replaceMatches($msgBody, $matcharray);

                        // vehicle Approve mail to User
                        if ($getEmailStatus->seller == 1 && $record->visitor_vehicle != 0 ) {
                            $this->sendEmail($email, $msgSubject, $msgBody, $senderEmail, $senderName, '');
                        }
                        if ($status == 1) {
                            $checkstatus = __('Approved', 'js-vehicle-manager');
                            $link = '<a href="' . jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid(), 'jsvmme'=>'vehicle', 'jsvmlt'=>'vehicledetail', 'jsvehiclemanagerid'=>$id)) .'" target="_blank">' . __('Vehicle Detail', 'js-vehicle-manager') . '</a>';
                        }
                        if ($status == -1) {
                            $checkstatus = __('Rejected', 'js-vehicle-manager');
                            $link = null;
                        }
                        if ($status == 2) {
                            $checkstatus = __('Removed', 'js-vehicle-manager');
                            $link = null;
                        }

                        $matcharray['{VEHICLE_LINK}'] = $link;
                        $matcharray['{VEHICLE_STATUS}'] = $checkstatus;

                        $msgSubject = $template->subject;
                        $msgBody = $template->body;
                        $this->replaceMatches($msgSubject, $matcharray);
                        $this->replaceMatches($msgBody, $matcharray);
                        // vehicle Approve mail to visitor
                        if ($getEmailStatus->seller_visitor == 1 && $record->visitor_vehicle == 0) {
                            $this->sendEmail($email, $msgSubject, $msgBody, $senderEmail, $senderName, '');
                        }
                        break;
                    case 4: // vehicle approve OR reject for featured

                        $creditid = JSVEHICLEMANAGERrequest::getVar('actiona');
                        $record = $this->getRecordByTablenameAndId('js_vehiclemanager_vehicles', $id,$creditid);
                        if(empty($record)){
                            return;
                        }
                        $username = $record->name;
                        $vehname = $record->maketitle.'-'.$record->modeltitle.'-'.$record->modelyeartitle;
                        $email = $record->email;
                        $status = $record->status;
                        $location = $record->location;
                        $maketitle = $record->maketitle;
                        $modeltitle = $record->modeltitle;
                        $modelyeartitle = $record->modelyeartitle;
                        $featuredvehicle = $record->isfeaturedvehicle;

                        $credits = isset($record->credtitsforaddvehicle) ? $record->credtitsforaddvehicle : 0;

                        $link = null;
                        $checkfeatured_vehicle = null;

                        if ($featuredvehicle == -1) {
                            $checkfeatured_vehicle = __('rejected for featured', 'js-vehicle-manager');
                            $link = '<a href="' . jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid(), 'jsvmme'=>'vehicle', 'jsvmlt'=>'vehicledetail', 'jsvehiclemanagerid'=>$id)) .'" target="_blank">' . __('Vehicle Detail', 'js-vehicle-manager') . '</a>';
                        }
                        if ($featuredvehicle == 1) {
                            $checkfeatured_vehicle = __('approved for featured', 'js-vehicle-manager');
                            $link = '<a href="' . jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid(), 'jsvmme'=>'vehicle', 'jsvmlt'=>'vehicledetail', 'jsvehiclemanagerid'=>$id)) .'" target="_blank">' . __('Vehicle Detail', 'js-vehicle-manager') . '</a>';
                        }
                        if ($featuredvehicle == 2) {
                            $checkfeatured_vehicle = __('removed for featured', 'js-vehicle-manager');
                            $link = '<a href="' . jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid(), 'jsvmme'=>'vehicle', 'jsvmlt'=>'vehicledetail', 'jsvehiclemanagerid'=>$id)) .'" target="_blank">' . __('Vehicle Detail', 'js-vehicle-manager') . '</a>';
                        }
                        if ($featuredvehicle == 0) {
                            $checkfeatured_vehicle = __('pending for featured', 'js-vehicle-manager');
                            $link = '<a href="' . jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid(), 'jsvmme'=>'vehicle', 'jsvmlt'=>'vehicledetail', 'jsvehiclemanagerid'=>$id)) .'" target="_blank">' . __('Vehicle Detail', 'js-vehicle-manager') . '</a>';
                        }

                        $matcharray = array(
                            '{VEHICLE_TITLE}' => $vehname,
                            '{SELLER_NAME}' => $username,
                            '{VEHICLE_LINK}' => $link,
                            '{VEHICLE_STATUS}' => $checkfeatured_vehicle,
                            '{VEHICLE_CREDITS}' => $credits,
                            '{LOCATION}' => $location
                        );

                        // code for handling custom fields start
                        if(!empty($record->vehparams)){
                            $vdata = json_decode($record->vehparams,true);
                        }
                        if(!empty($record->userparams)){
                            $udata = json_decode($record->userparams,true);
                        }
                        $fields = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getUserfieldsforEmail();
                        foreach ($fields as $field) {
                            if( isset($vdata) && is_array($vdata)){
                                if($field->userfieldtype != 'file'){
                                    $fvalue1 = '';
                                    if(array_key_exists($field->field, $vdata)){
                                        $fvalue1 = $vdata[$field->field];
                                    }
                                    $matcharray['{'.$field->field.'_1'.'}'] = $fvalue1;// match array new index for custom field
                                }
                            }
                            if( isset($udata) && is_array($udata)){
                                if($field->userfieldtype != 'file'){
                                    $fvalue2 = '';
                                    if(array_key_exists($field->field, $udata)){
                                        $fvalue2 = $udata[$field->field];
                                    }
                                    $matcharray['{'.$field->field.'_2'.'}'] = $fvalue2;// match array new index for custom field
                                }
                            }
                        }
                        // code for handling custom fields end
                        $template = $this->getTemplateForEmail('vehicle-status');
                        $getEmailStatus = JSVEHICLEMANAGERincluder::getJSModel('emailtemplatestatus')->getEmailTemplateStatus('vehicle_status');
                        $msgSubject = $template->subject;
                        $msgBody = $template->body;
                        $this->replaceMatches($msgSubject, $matcharray);
                        $this->replaceMatches($msgBody, $matcharray);

                        // vehicle featured mail to User
                        if ($getEmailStatus->seller == 1 && $record->visitor_vehicle !=0) {
                            $this->sendEmail($email, $msgSubject, $msgBody, $senderEmail, $senderName, '');
                        }
                        // vehicle featured mail to visitor
                        if ($getEmailStatus->seller_visitor == 1 && $record->visitor_vehicle == 0) {
                            $this->sendEmail($email, $msgSubject, $msgBody, $senderEmail, $senderName, '');
                        }
                        break;
                    case 5: // Add New Vehicle Visitor
                        $record = $this->getRecordByTablenameAndId('js_vehiclemanager_vehicles', $id);
                        if(empty($record)){// to handle the issue of blank mail
                            break;
                        }
                        $username = $record->name;
                        $vehname = $record->maketitle.'-'.$record->modeltitle.'-'.$record->modelyeartitle;
                        $email = $record->email;
                        $status = $record->status;
                        $location = $record->location;
                        $maketitle = $record->maketitle;
                        $modeltitle = $record->modeltitle;
                        $modelyeartitle = $record->modelyeartitle;

                        $credits = 0;

                        $checkstatus = null;
                        $link = null;
                        if ($status == 1) {
                            $checkstatus = __('Approved', 'js-vehicle-manager');
                            $link = '<a href="' . jsvehiclemanager::makeUrl(array('jsvehiclemanagepageid'=>jsvehiclemanager::getPageid(), 'jsvmme'=>'vehicle', 'jsvmlt'=>'vehicledetail', 'jsvehiclemanagerid'=>$id)) .'" target="_blank">' . __('Vehicle Detail', 'js-vehicle-manager') . '</a>';
                        }
                        if ($status == -1) {
                            $checkstatus = __('Rejected', 'js-vehicle-manager');
                            $link = "<strong>" . __('Due to rejection of vehicle you have not permission to see vehicle detail', 'js-vehicle-manager') . "</strong>";
                        }
                        if ($status == 0) {
                            $checkstatus = __('Pending', 'js-vehicle-manager');
                            $link = "<strong>" . __('Due to pending status of vehicle you have not permission to see vehicle detail', 'js-vehicle-manager') . "</strong>";
                        }

                        $matcharray = array(
                            '{VEHICLE_TITLE}' => $vehname,
                            '{SELLER_NAME}' => $username,
                            '{VEHICLE_LINK}' => $link,
                            '{VEHICLE_STATUS}' => $checkstatus,
                            '{VEHICLE_CREDITS}' => $credits,
                            '{LOCATION}' => $location,
                        );

                        // code for handling custom fields start
                        if(!empty($record->vehparams)){
                            $vdata = json_decode($record->vehparams,true);
                        }
                        if(!empty($record->userparams)){
                            $udata = json_decode($record->userparams,true);
                        }
                        $fields = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getUserfieldsforEmail();
                        foreach ($fields as $field) {
                            if( isset($vdata) && is_array($vdata)){
                                if($field->userfieldtype != 'file'){
                                    $fvalue1 = '';
                                    if(array_key_exists($field->field, $vdata)){
                                        $fvalue1 = $vdata[$field->field];
                                    }
                                    $matcharray['{'.$field->field.'_1'.'}'] = $fvalue1;// match array new index for custom field
                                }
                            }
                            if( isset($udata) && is_array($udata)){
                                if($field->userfieldtype != 'file'){
                                    $fvalue2 = '';
                                    if(array_key_exists($field->field, $udata)){
                                        $fvalue2 = $udata[$field->field];
                                    }
                                    $matcharray['{'.$field->field.'_2'.'}'] = $fvalue2;// match array new index for custom field
                                }
                            }
                        }
                        // code for handling custom fields end

                        $template = $this->getTemplateForEmail('visitor-vehicle');
                        $getEmailStatus = JSVEHICLEMANAGERincluder::getJSModel('emailtemplatestatus')->getEmailTemplateStatus('add_new_vehicle');
                        $msgSubject = $template->subject;
                        $msgBody = $template->body;
                        $this->replaceMatches($msgSubject, $matcharray);
                        $this->replaceMatches($msgBody, $matcharray);

                        // Add New visitor vehicle mail to visitor
                        if ($getEmailStatus->seller_visitor == 1) {
                            $this->sendEmail($email, $msgSubject, $msgBody, $senderEmail, $senderName, '');
                        }

                        $link = null;
                        // Add New visitor mail to admin
                        if ($status == 1) {
                            $checkstatus = __('Approved', 'js-vehicle-manager');
                            $link = '<a href="' . admin_url("admin.php?page=jsvm_vehicle") .'" target="_blank">' . __('Vehicles', 'js-vehicle-manager') . '</a>';
                        }
                        if ($status == -1) {
                            $checkstatus = __('Rejected', 'js-vehicle-manager');
                            $link = '<a href="' . admin_url("admin.php?page=jsvm_vehicle") .'" target="_blank">' . __('Vehicles', 'js-vehicle-manager') . '</a>';
                        }
                        if ($status == 0) {
                            $checkstatus = __('Pending', 'js-vehicle-manager');
                            $link = '<a href="' . admin_url("admin.php?page=jsvm_vehicle&jsvmlt=vehiclequeue") .'" target="_blank">' . __('Vehicles Queue', 'js-vehicle-manager') . '</a>';
                        }
                        $matcharray['{VEHICLE_LINK}'] = $link;

                        $template = $this->getTemplateForEmail('new-vehicle-admin');
                        $msgSubject = $template->subject;
                        $msgBody = $template->body;
                        $this->replaceMatches($msgSubject, $matcharray);
                        $this->replaceMatches($msgBody, $matcharray);

                        if ($getEmailStatus->admin == 1) {
                            $this->sendEmail($adminEmailid, $msgSubject, $msgBody, $senderEmail, $senderName, '');
                        }
                        break;
                }
                break;
            case 2: // mail for purchase credits pack
                switch ($action) {
                    case 1: // purchase crdits pack
                        $record = $this->getRecordByTablenameAndId('js_vehiclemanager_paymenthistory', $id);
                        if(empty($record)){
                            return;
                        }
                        $Username = $record->userfirstname . $record->userlastname;
                        $packagename = $record->packagename;
                        $email = $record->useremailaddress;
                        $purchasedate = $record->purcahsedate;
                        $packageprice = $record->price;
                        if ($email == '') {
                            $finalEmail = $record->userotheremailaddress;
                        }
                        if ($Username == '') {
                            $username = $record->userothername;
                        }
                        $link = '<a href="' . jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid(), 'jsvmme'=>'purchasehistory' , 'jsvmlt' => 'purchasehistory' )) .'" target="_blank">' . __('Package Detail', 'js-vehicle-manager') . '</a>';
                        $matcharray = array(
                            '{PACKAGE_NAME}' => $packagename,
                            '{SELLER_NAME}' => $Username,
                            '{PACKAGE_PRICE}' => $packageprice,
                            '{PACKAGE_LINK}' => $link,
                            '{PACKAGE_PURCHASE_DATE}' => $purchasedate
                        );
                        $template = $this->getTemplateForEmail('credits-purchase');
                        $getEmailStatus = JSVEHICLEMANAGERincluder::getJSModel('emailtemplatestatus')->getEmailTemplateStatus('purchase_credits_pack');
                        $msgSubject = $template->subject;
                        $msgBody = $template->body;
                        $this->replaceMatches($msgSubject, $matcharray);
                        $this->replaceMatches($msgBody, $matcharray);

                        if ($getEmailStatus->seller == 1) {
                            $this->sendEmail($email, $msgSubject, $msgBody, $senderEmail, $senderName, '');
                        }
                        $link = '<a href="' . admin_url("admin.php?page=jsvm_purchasehistory&jsvmlt=viewpurchasehistory&jsvehiclemanagerid=".$id) .'" target="_blank">' . __('Package Detail', 'js-vehicle-manager') . '</a>';
                        $matcharray['{PACKAGE_LINK}'] = $link;
                        $msgSubject = $template->subject;
                        $msgBody = $template->body;
                        $this->replaceMatches($msgSubject, $matcharray);
                        $this->replaceMatches($msgBody, $matcharray);
                        if ($getEmailStatus->admin == 1) {
                            $template = $this->getTemplateForEmail('credits-purchase-admin');
                            $getEmailStatus = JSVEHICLEMANAGERincluder::getJSModel('emailtemplatestatus')->getEmailTemplateStatus('purchase_credits_pack');
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);

                            $this->sendEmail($adminEmailid, $msgSubject, $msgBody, $senderEmail, $senderName, '');
                        }
                        break;
                    case 2: // package Expiry
                        $record = $this->getRecordByTablenameAndId('js_vehiclemanager_credits_pack', $id);
                        if(empty($record)){
                            return;
                        }
                        $Username = $record->userfirstname . $record->userlastname;
                        $packagename = $record->packagename;
                        $email = $record->useremailaddress;
                        $purchasedate = $record->purcahsedate;
                        $packageprice = $record->price;
                        $expirydays = $record->expire;
                        $expirydate = date_i18n('Y-m-d', strtotime($purchasedate . ' + ' . $expirydays . ' day'));
                        $curdate = date_i18n('Y-m-d');
                        $purchasedate = date_i18n('Y-m-d', strtotime($purchasedate));
                        if ($email == '') {
                            $finalEmail = $record->userotheremailaddress;
                        }
                        if ($Username == '') {
                            $username = $record->userothername;
                        }
                        $link = '<a href="' . jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid(), 'jsvmme'=>'creditspack' , 'jsvmlt' => 'creditspack' )) .'" target="_blank">' . __('Credits Pack', 'js-vehicle-manager') . '</a>';
                        $matcharray = array(
                            '{PACKAGE_NAME}' => $packagename,
                            '{SELLER_NAME}' => $Username,
                            '{PACKAGE_LINK}' => $link,
                            '{PACKAGE_PURCHASE_DATE}' => $purchasedate
                        );
                        $template = $this->getTemplateForEmail('credits-expiry');
                        $getEmailStatus = JSVEHICLEMANAGERincluder::getJSModel('emailtemplatestatus')->getEmailTemplateStatus('expire_credits_pack');
                        $msgSubject = $template->subject;
                        $msgBody = $template->body;
                        $this->replaceMatches($msgSubject, $matcharray);
                        $this->replaceMatches($msgBody, $matcharray);

                        // purchase credits pack  mail to User
                        if ($getEmailStatus->seller == 1 && ($expirydate > $curdate)) {
                            $this->sendEmail($email, $msgSubject, $msgBody, $senderEmail, $senderName, '');
                        }
                        break;
                }
                break;
            case 3: //user resgistration
                switch ($action) {
                    case 1: //user register registration
                        $record = $this->getRecordByTablenameAndId('users', $id);
                        if(empty($record)){
                            return;
                        }
                        $link = null;

                        $Username = $record->username;
                        $email = $record->useremail;

                        $link = '<a href="' . jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid(), 'jsvmme'=>'user', 'jsvmlt'=>'dashboard')) .'" target="_blank">' . __('Dashboard', 'js-vehicle-manager') . '</a>';
                        $matcharray = array(
                            '{SELLER_NAME}' => $Username,
                            '{MY_DASHBOARD_LINK}' => $link
                        );

                        $template = $this->getTemplateForEmail('new-seller');
                        $getEmailStatus = JSVEHICLEMANAGERincluder::getJSModel('emailtemplatestatus')->getEmailTemplateStatus('add_new_seller');
                        $msgSubject = $template->subject;
                        $msgBody = $template->body;
                        $this->replaceMatches($msgSubject, $matcharray);
                        $this->replaceMatches($msgBody, $matcharray);

                        // New vehicleseeker registration mail to user
                        if ($getEmailStatus->seller == 1) {
                            $this->sendEmail($email, $msgSubject, $msgBody, $senderEmail, $senderName, '');
                        }
                        break;
                }
                break;
        }
    }

    function getTemplate($tempfor) {
        if(!$tempfor)
            return '';

        $db = new jsvehiclemanagerdb();
        $query = "SELECT * FROM `#__js_vehiclemanager_emailtemplates` WHERE templatefor = '" . $tempfor . "'";
        $db->setQuery($query);
        jsvehiclemanager::$_data[0] = $db->loadObject();
        jsvehiclemanager::$_data[2] = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getUserfieldsforEmail();
        return;
    }

    function storeEmailTemplate($data) {
        if (empty($data))
            return false;
        $data['body'] = JSVEHICLEMANAGERincluder::getJSModel('common')->getSanitizedEditorData($_POST['body']);
        $data['body'] = wpautop(wptexturize(stripslashes($data['body'])));
        $row = JSVEHICLEMANAGERincluder::getJSTable('emailtemplate');

        if (!$row->bind($data)) {
            return JSVEHICLEMANAGER_SAVE_ERROR;
        }
        if (!$row->store()) {
            return JSVEHICLEMANAGER_SAVE_ERROR;
        }

        return JSVEHICLEMANAGER_SAVED;
    }

    function getTemplateForEmail($templatefor) {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT * FROM `#__js_vehiclemanager_emailtemplates` WHERE templatefor = '" . $templatefor . "'";
        $db->setQuery($query);
        $template = $db->loadObject();
        return $template;
    }

    function replaceMatches(&$string, $matcharray) {
        foreach ($matcharray AS $find => $replace) {
            $string = str_replace($find, $replace, $string);
        }
    }

    function sendEmail($recevierEmail, $subject, $body, $senderEmail, $senderName, $attachments = '') {
        if (!$senderName)
            $senderName = jsvehiclemanager::$_config['title'];
        $headers = 'From: ' . $senderName . ' <' . $senderEmail . '>' . "\r\n";
        //add_filter('wp_mail_content_type', create_function('', 'return "text/html"; ')); deprecated add_filter('wp_mail_content_type', function(){ return "text/html";});
        add_filter('wp_mail_content_type', array($this,'jsvm_set_html_content_type'));
        $body = preg_replace('/\r?\n|\r/', '<br/>', $body);
        $body = str_replace(array("\r\n", "\r", "\n"), "<br/>", $body);
        $body = nl2br($body);
        wp_mail($recevierEmail, $subject, $body, $headers, $attachments);

    }
        function jsvm_set_html_content_type() {

        return 'text/html';
    }

    function getRecordByTablenameAndId($tablename, $id, $creditid = null) {
        if (!is_numeric($id))
            return false;
        $query = null;
        $db = new jsvehiclemanagerdb();
        switch ($tablename) {
            case 'js_vehiclemanager_vehicles':
                $query = "SELECT user.uid
                    FROM `#__js_vehiclemanager_vehicles` AS veh
                    JOIN `#__js_vehiclemanager_users` AS user ON user.id = veh.uid
                    WHERE veh.id = ".$id;
                $db->setQuery($query);
                $guest_vehivle = $db->loadResult();

                if($guest_vehivle == 0){
                    $query = "SELECT veh.id, veh.uid, veh.status, veh.isfeaturedvehicle, user.name, user.email, user.uid AS visitor_vehicle, veh.loccity, make.title AS maketitle, model.title AS modeltitle, mdy.title AS modelyeartitle,veh.params AS vehparams,user.params AS userparams
                        FROM `#__js_vehiclemanager_vehicles` AS veh
                        JOIN `#__js_vehiclemanager_makes` AS make ON make.id = veh.makeid
                        JOIN `#__js_vehiclemanager_models` AS model ON model.id = veh.modelid
                        LEFT JOIN `#__js_vehiclemanager_users` AS user ON user.id = veh.uid
                        LEFT JOIN `#__js_vehiclemanager_modelyears` AS mdy ON mdy.id = veh.modelyearid
                        WHERE veh.id = ".$id;
                    $db->setQuery($query);
                    $data = $db->loadObject();
                    if(!empty($data)){
                        $data->location = JSVEHICLEMANAGERincluder::getJSModel('city')->getLocationDataForView($data->loccity);
                    }
                    return $data;
                }else {
                    $credtitsforaddvehicle = 0;
                    if($creditid && is_numeric($creditid)){
                        $query = "SELECT actionid FROM `#__js_vehiclemanager_credits` WHERE id = " . $creditid;
                        $db->setQuery($query);
                        $actionid = $db->loadResult();

                        if(is_numeric($actionid)){
                            $query = "SELECT credlog.credits
                                FROM `#__js_vehiclemanager_credits_log` AS credlog
                                WHERE credlog.refrenceid = ".$id." AND credlog.actionid = ".$actionid." ORDER BY credlog.created DESC LIMIT 1";
                            $db->setQuery($query);
                            $credtitsforaddvehicle = $db->loadResult();
                        }
                    }
                    $query = "SELECT veh.id, veh.uid, veh.status, veh.isfeaturedvehicle, user.name, user.email, user.uid AS visitor_vehicle, veh.loccity, make.title AS maketitle, model.title AS modeltitle, mdy.title AS modelyeartitle,veh.params AS vehparams,user.params AS userparams
                        FROM `#__js_vehiclemanager_vehicles` AS veh
                        JOIN `#__js_vehiclemanager_makes` AS make ON make.id = veh.makeid
                        JOIN `#__js_vehiclemanager_models` AS model ON model.id = veh.modelid
                        JOIN `#__js_vehiclemanager_users` AS user ON user.id = veh.uid
                        LEFT JOIN `#__js_vehiclemanager_modelyears` AS mdy ON mdy.id = veh.modelyearid
                        WHERE veh.id = ".$id;
                    $db->setQuery($query);
                    $data = $db->loadObject();
                    if(!empty($data)){
                        $data->location = JSVEHICLEMANAGERincluder::getJSModel('city')->getLocationDataForView($data->loccity);
                    }
                    $data->credtitsforaddvehicle = $credtitsforaddvehicle;
                    return $data;
                }
                break;
            case 'js_vehiclemanager_paymenthistory':
                $query = 'SELECT pr.payer_firstname AS userfirstname,pr.payer_lastname AS userlastname
                            , pr.purchasetitle AS packagename ,pr.payer_email AS useremailaddress, pr.payer_amount AS price
                            , pr.created AS purcahsedate, user.name AS userothername
                            , user.email AS userotheremailaddress
                            FROM `#__js_vehiclemanager_paymenthistory` AS pr
                            JOIN `#__js_vehiclemanager_users` AS user ON user.id = pr.uid
                            WHERE pr.id = ' . $id;
                break;
            case 'js_vehiclemanager_credits_pack':
                $query = 'SELECT pr.payer_firstname AS userfirstname, pr.transactionverified AS status,pr.payer_lastname AS userlastname
                            ,pr.expireindays AS expire ,pr.purchasetitle AS packagename ,pr.payer_email AS useremailaddress
                            , pr.payer_amount AS price, pr.created AS purcahsedate, user.name AS userothername, user.email AS userotheremailaddress
                            FROM `#__js_vehiclemanager_paymenthistory` AS pr
                            JOIN `#__js_vehiclemanager_users` AS user ON user.id = pr.uid
                            WHERE pr.id = ' . $id;
                break;
            case 'users':
                $query = 'SELECT u.name AS username, u.email AS useremail
                            FROM `#__js_vehiclemanager_users` AS u
                            WHERE u.id = ' . $id;
                break;
        }
        if ($query != null) {
            $db = new jsvehiclemanagerdb();
            $db->setQuery($query);
            $record = $db->loadObject();
            return $record;
        }
        return false;
    }

    function getMessagekey(){
        $key = 'emailtemplate';if(is_admin()){$key = 'admin_'.$key;}return $key;
    }
}

?>
