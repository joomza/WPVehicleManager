<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERconfigurationModel {

    function __construct() {
        
    }

    function getConfiguration() {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        // check for plugin using plugin name
        if (is_plugin_active('js-vehicle-manager/js-vehicle-manager.php')) {
            $db = new jsvehiclemanagerdb();
            $query = "SELECT config.* FROM `#__js_vehiclemanager_config` AS config WHERE configfor = 'default'";
            $db->setQuery($query);
            $config = $db->loadObjectList();
            foreach ($config as $conf) {
                jsvehiclemanager::$_config[$conf->configname] = $conf->configvalue;
            }
            jsvehiclemanager::$_config['config_count'] = COUNT($config);
        }
    }

    function getConfigurationsForForm() {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT config.* FROM `#__js_vehiclemanager_config` AS config";
        $db->setQuery($query);
        $config = $db->loadObjectList();
        foreach ($config as $conf) {
            jsvehiclemanager::$_data[0][$conf->configname] = $conf->configvalue;
        }
        jsvehiclemanager::$_data[0]['config_count'] = COUNT($config);

    }

    function storeConfig($data) {
        if (empty($data))
            return false;

        if ($data['isgeneralbuttonsubmit'] == 1) {
            if (!isset($data['tumbler_share']))
                $data['tumbler_share'] = 0;
            if (!isset($data['fb_like']))
                $data['fb_like'] = 0;
            if (!isset($data['fb_comments']))
                $data['fb_comments'] = 0;
            if (!isset($data['fb_share']))
                $data['fb_share'] = 0;
            if (!isset($data['google_like']))
                $data['google_like'] = 0;
            if (!isset($data['google_share']))
                $data['google_share'] = 0;
            if (!isset($data['blogger_share']))
                $data['blogger_share'] = 0;
            if (!isset($data['instgram_share']))
                $data['instgram_share'] = 0;
            if (!isset($data['linkedin']))
                $data['linkedin'] = 0;
            if (!isset($data['digg_share']))
                $data['digg_share'] = 0;
            if (!isset($data['twitter_share']))
                $data['twitter_share'] = 0;
            if (!isset($data['pintrest_share']))
                $data['pintrest_share'] = 0;
            if (!isset($data['yahoo_share']))
                $data['yahoo_share'] = 0;
        }

        if (isset($_POST['offline_message'])) {
            $data['offline_message'] = wpautop(wptexturize(stripslashes($_POST['offline_message'])));
        }
        $error = false;
        $db = new jsvehiclemanagerdb();
        $uploaded_watermark = $this->uploadWaterMarkImage();
        if($uploaded_watermark != false){
            $data['water_mark_img_name'] = $uploaded_watermark;
        }
        foreach ($data as $key => $value) {
            if ($key == 'data_directory') {
                $data_directory = $value;
                if (empty($data_directory)) {
                    JSVEHICLEMANAGERmessages::setLayoutMessage(__('Data directory can not empty.', 'js-vehicle-manager'), 'error', 'configuration');
                    continue;
                }
                if (strpos($data_directory, '/') !== false) {
                    JSVEHICLEMANAGERmessages::setLayoutMessage(__('Data directory is not proper.', 'js-vehicle-manager'), 'error', 'configuration');
                    continue;
                }
                $path = JSVEHICLEMANAGER_PLUGIN_PATH . '/' . $data_directory;
                if (!file_exists($path)) {
                    mkdir($path, 0755);
                }
                if (!is_writeable($path)) {
                    JSVEHICLEMANAGERmessages::setLayoutMessage(__('Data directory is not writable.', 'js-vehicle-manager'), 'error', 'configuration');
                    continue;
                }
            }
            $query = "UPDATE `#__js_vehiclemanager_config` SET `configvalue` = '$value' WHERE `configname`= '" . $key . "'";
            $db->setQuery($query);
            if (false === $db->query()) {
                $error = true;
            }
        }
        if ($error)
            return JSVEHICLEMANAGER_SAVE_ERROR;
        else
            return JSVEHICLEMANAGER_SAVED;
    }

    function uploadWaterMarkImage() {
        if(isset($_FILES['watermarkimage']) && is_array($_FILES['watermarkimage'])){
            if($_FILES['watermarkimage']['error'] != 4){
                $file = $_FILES['watermarkimage'];
                $fileurl = JSVEHICLEMANAGERincluder::getObjectClass('uploads')->vehicleManagerUpload(0, $file,6);
                return basename($fileurl);
            }
        }
        return false;
    }

    function getConfigByFor($configfor) {
        if (!$configfor)
            return;
        $db = new jsvehiclemanagerdb();
        if(is_array($configfor)){
            $query = "SELECT * FROM `#__js_vehiclemanager_config` WHERE configfor in('".implode("','",$configfor)."')";
        }else{
            $query = "SELECT * FROM `#__js_vehiclemanager_config` WHERE configfor = '" . $configfor . "'";
        }
        $db->setQuery($query);
        $config = $db->loadObjectList();
        $configs = array();
        foreach ($config as $conf) {
            $configs[$conf->configname] = $conf->configvalue;
        }
        return $configs;
    }

    function getCheckCronKey() {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT configvalue FROM `#__js_vehiclemanager_config` WHERE configname = 'cron_job_alert_key'";
        $db->setQuery($query);
        $key = $db->loadResult();
        if ($key)
            return true;
        else
            return false;
    }

    function genearateCronKey() {
        $key = md5(date_i18n('Y-m-d'));
        $db = new jsvehiclemanagerdb();
        $query = "UPDATE `#__js_vehiclemanager_config` SET configvalue = '$key' WHERE configname = 'cron_job_alert_key'";
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        } else
            return true;
    }

    function getCronKey($passkey) {
        if ($passkey == md5(date_i18n('Y-m-d'))) {
            $db = new jsvehiclemanagerdb();
            $query = "SELECT configvalue FROM `#__js_vehiclemanager_config` WHERE configname = 'cron_job_alert_key'";
            $db->setQuery($query);
            $key = $db->loadResult();
            jsvehiclemanager::$_data[0]['ck'] = $key;
            return $key;
        } else
            return false;
    }

    function getCountConfig() {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT COUNT(*) FROM `#__js_vehiclemanager_config`";
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }

    function getConfigValue($configname) {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT configvalue FROM `#__js_vehiclemanager_config` WHERE configname = '" . $configname . "'";
        $db->setQuery($query);
        return $db->loadResult();
    }

    function getConfigurationByConfigForMultiple($configfor) {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT configname,configvalue 
                  FROM `#__js_vehiclemanager_config` WHERE configfor IN (" . $configfor . ")";
        $db->setQuery($query);
        $result = $db->loadObjectList();
        $config_array = array();
        //to make configuration in to an array with key as index 
        foreach ($result as $config) {
            $config_array[$config->configname] = $config->configvalue;
        }
        return $config_array;
    }

    function getConfigurationByConfigName($configname) {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT configvalue 
                  FROM `#__js_vehiclemanager_config` WHERE configname ='" . $configname . "'";
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }

    function checkCronKey($passkey) {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT COUNT(configvalue) FROM `#__js_vehiclemanager_config` WHERE configname = 'cron_job_alert_key' AND configvalue = '" . $passkey . "'";
        $db->setQuery($query);
        $key = $db->loadResult();
        if ($key == 1)
            return true;
        else
            return false;
    }

    function getConfiginArray($configfor) { //getConfiginArray
        $db = new jsvehiclemanagerdb();
        $query = "SELECT * FROM `#__js_vehiclemanager_config` ";
        $db->setQuery($query);
        $config = $db->loadObjectList();

        $configs = array();
        foreach ($config as $conf) {
            $configs[$conf->configname] = $conf->configvalue;
        }
        return $configs;
    }

    function getMessagekey(){
        $key = 'configuration';if(is_admin()){$key = 'admin_'.$key;}return $key;
    }
}

?>
