<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERemailtemplatestatusModel {

    function sendEmailModel($id, $actionfor) {
        if (empty($id))
            return false;
        if (!is_numeric($actionfor))
            return false;

        $row = JSVEHICLEMANAGERincluder::getJSTable('emailtemplateconfig');
        $value = 1;

        switch ($actionfor) {
            case 1: 
                $row->update(array('id' => $id, 'admin' => $value));
                break;
            case 2: 
                $row->update(array('id' => $id, 'seller' => $value));
                break;
            case 3: 
                $row->update(array('id' => $id, 'seller_visitor' => $value));
                break;
        }
    }

    function noSendEmailModel($id, $actionfor) {
        if (empty($id))
            return false;
        if (!is_numeric($actionfor))
            return false;

        $row = JSVEHICLEMANAGERincluder::getJSTable('emailtemplateconfig');
        $value = 0;

        switch ($actionfor) {
            case 1: 
                $row->update(array('id' => $id, 'admin' => $value));
                break;
            case 2: 
                $row->update(array('id' => $id, 'seller' => $value));
                break;
            case 3: 
                $row->update(array('id' => $id, 'seller_visitor' => $value));
                break;
        }
    }

    function getEmailTemplateStatusData() {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT * FROM `#__js_vehiclemanager_emailtemplates_config`";
        $db->setQuery($query);
        jsvehiclemanager::$_data[0] = $db->loadObjectList();
        $newdata = array();
        foreach (jsvehiclemanager::$_data[0] as $data) {
            $newdata[$data->emailfor] = array(
                'tempid' => $data->id,
                'tempname' => $data->emailfor,
                'admin' => $data->admin,
                'seller' => $data->seller,
                'buyer' => $data->buyer,
                'seller_visitor' => $data->seller_visitor,
                'buyer_visitor' => $data->buyer_visitor
            );
        }
        jsvehiclemanager::$_data[0] = $newdata;
    }

    function getEmailTemplateStatus($template_name) {
        $db = new jsvehiclemanagerdb();
        if(! $template_name)
            return '';
        $query = "SELECT emc.admin,emc.seller,emc.seller_visitor
                FROM `#__js_vehiclemanager_emailtemplates_config` AS emc
                where  emc.emailfor = '" . $template_name . "'";
        $db->setQuery($query);
        $templatestatus = $db->loadObject();
        return $templatestatus;
    }

    function getMessagekey(){
        $key = 'emailtemplatestatus';if(is_admin()){$key = 'admin_'.$key;}return $key;
    }
}

?>
