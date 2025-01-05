<?php
function jsvehiclemanagercheckLink($name) {
	$print = false;
    $visname = 'vis_'.$name;
    $isguest = JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest();

    $config_array = jsvehiclemanager::$_data['config'];

    if ($isguest == false) {
        if (isset($config_array[$name]) && $config_array[$name] == 1)
            $print = true;
    } else {
        if (isset($config_array["$visname"]) && $config_array["$visname"] == 1)
            $print = true;
    }
    return $print;
}
?>