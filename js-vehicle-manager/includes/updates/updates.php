<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERupdates {

    static function checkUpdates() {
        $installedversion = JSVEHICLEMANAGERupdates::getInstalledVersion();
        if ($installedversion != jsvehiclemanager::$_currentversion) {
            $db = new jsvehiclemanagerdb();
            //UPDATE the last_version of the plugin
            $query = "REPLACE INTO `#__js_vehiclemanager_config` (`configname`, `configvalue`, `configfor`) VALUES ('last_version','','default');";
            $db->setQuery($query);
            $db->query();
            $query = "SELECT configvalue FROM `#__js_vehiclemanager_config` WHERE configname='versioncode'";
            $db->setQuery($query);
            $versioncode = $db->loadResult();
            $versioncode = str_replace('.','',$versioncode);
            $query = "UPDATE `#__js_vehiclemanager_config` SET configvalue = '".$versioncode."' WHERE configname = 'last_version';";
            $db->setQuery($query);
            $db->query();
            $from = $installedversion + 1;
            $to = jsvehiclemanager::$_currentversion;
            for ($i = $from; $i <= $to; $i++) {
                $installfile = JSVEHICLEMANAGER_PLUGIN_PATH . 'includes/updates/sql/' . $i . '.sql';
                if (file_exists($installfile)) {
                    $delimiter = ';';
                    $file = fopen($installfile, 'r');
                    if (is_resource($file) === true) {
                        $query = array();

                        while (feof($file) === false) {
                            $query[] = fgets($file);
                            if (preg_match('~' . preg_quote($delimiter, '~') . '\s*$~iS', end($query)) === 1) {
                                $query = trim(implode('', $query));
                                if (!empty($query)) {
                                    $db->setQuery($query);
                                    $db->query();
                                }
                            }
                            if (is_string($query) === true) {
                                $query = array();
                            }
                        }
                        fclose($file);
                    }
                }
            }
        }
    }

    static function getInstalledVersion() {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT configvalue FROM `#__js_vehiclemanager_config` WHERE configname = 'versioncode'";
        $db->setQuery($query);
        $version = $db->loadResult();
        if (!$version)
            $version = '102';
        else
            $version = str_replace('.', '', $version);
        return $version;
    }

}

?>
