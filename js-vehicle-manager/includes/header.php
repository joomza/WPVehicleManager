<?php
if (!defined('ABSPATH'))
    die('Restricted Access');

global $config_array;
$config_array = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigByFor('topmenu');


function jsvehiclemanagerchecktopmenuLink($name) {
    $print = false;
    $visname = 'vis_'.$name;
    $isguest = JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest();

    global $config_array;

    if ($isguest == false) {
        if (isset($config_array[$name]) && $config_array[$name] == 1)
            $print = true;
    } else {
        if (isset($config_array["$visname"]) && $config_array["$visname"] == 1)
            $print = true;
    }
    return $print;
}
$div = '';
    if( jsvehiclemanagerchecktopmenuLink('topmenu_controlpanel') == true ){
        $linkarray[] = array(
            'link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'user', 'jsvmlt'=>'dashboard')),
            'title' => __('Control Panel', 'js-vehicle-manager'),
        );
    }
    if( jsvehiclemanagerchecktopmenuLink('topmenu_addVehicle') == true ){
        $linkarray[] = array(
            'link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'formvehicle')),
            'title' => __('Add Vehicle', 'js-vehicle-manager'),
        );
    }
    if( jsvehiclemanagerchecktopmenuLink('topmenu_myvehicles') == true ){
        $linkarray[] = array(
            'link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'myvehicles')),
            'title' => __('My Vehicles', 'js-vehicle-manager'),
        );
    }
    if( jsvehiclemanagerchecktopmenuLink('topmenu_vehiclelist') == true ){
        $linkarray[] = array(
            'link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehicles')),
            'title' => __('Vehicles', 'js-vehicle-manager'),
        );
    }
    if( jsvehiclemanagerchecktopmenuLink('topmenu_shortlistvehicles') == true ){
        $linkarray[] = array(
            'link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'shortlist', 'jsvmlt'=>'shortlistvehicles')),
            'title' => __('Shortlist Vehicles', 'js-vehicle-manager'),
        );
    }
    if( jsvehiclemanagerchecktopmenuLink('topmenu_searchvehicles') == true ){
        $linkarray[] = array(
            'link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehiclesearch')),
            'title' => __('Search Vehicle', 'js-vehicle-manager'),
        );
    }
    if( jsvehiclemanagerchecktopmenuLink('topmenu_vehiclebycity') == true ){
        $linkarray[] = array(
            'link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'city', 'jsvmlt'=>'vehiclesbycity')),
            'title' => __('Vehicle By Cities', 'js-vehicle-manager'),
        );
    }
    if( jsvehiclemanagerchecktopmenuLink('topmenu_vehiclebymake') == true ){
        $linkarray[] = array(
            'link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'make', 'jsvmlt'=>'vehiclesbymake')),
            'title' => __('Vehicles By Make', 'js-vehicle-manager'),
        );
    }
    if( jsvehiclemanagerchecktopmenuLink('topmenu_sellerlist') == true ){
        $linkarray[] = array(
            'link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'user', 'jsvmlt'=>'sellerlist')),
            'title' => __('Sellers List', 'js-vehicle-manager'),
        );
    }


if (isset($linkarray)) {
    $div .= '<div id="jsvehiclemanager-header-main-wrapper">';
    foreach ($linkarray AS $link) {
        $div .= '<a class="headerlinks" href="' . $link['link'] . '">' . $link['title'] . '</a>';
    }
    $div .= '</div>';
}
echo wp_kses($div, JSVEHICLEMANAGER_ALLOWED_TAGS);
?>
