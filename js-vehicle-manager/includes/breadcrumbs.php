<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
class JSVEHICLEMANAGERbreadcrumbs {

    static function showBreadcrumbs(){
        $showBreadcrumbs = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('breadcrumbs_showhide');
        return ($showBreadcrumbs == 1);
    }

    static function getBreadcrumbs() {
        //$cur_location = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('cur_location');
        if( self::showBreadcrumbs() == false ) return;

        $cur_location = 1;
        if ($cur_location != 1){
            return false;
        }
        if (!is_admin()) {
            $editid = JSVEHICLEMANAGERrequest::getVar('jsvehiclemanagerid');
            $isnew = ($editid == null) ? true : false;
            $module = JSVEHICLEMANAGERrequest::getVar('jsvmme');
            $layout = JSVEHICLEMANAGERrequest::getVar('jsvmlt');
            $array[] = array('link' => jsvehiclemanager::makeUrl(array("jsvehiclemanagerpageid"=>jsvehiclemanager::getPageid())), 'text' => __('Control Panel', 'js-vehicle-manager'));
            if ($layout == 'printresume' || $layout == 'pdf')
                return false; // b/c we have print and pdf layouts
            if ($module != null) {
                switch ($module) {
                    case 'user':
                        // Add default module link
                        switch ($layout) {
                            case 'dashboard':
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'user', 'jsvmlt'=>'dashboard')), 'text' => __('Dashboard', 'js-vehicle-manager'));
                            break;
                            case 'sellerlist':
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'user', 'jsvmlt'=>'sellerlist')), 'text' => __('Seller List', 'js-vehicle-manager'));
                            break;
                            case 'sellersbycity':
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'user', 'jsvmlt'=>'sellersbycity')), 'text' => __('Sellers By City', 'js-vehicle-manager'));
                            break;
                            case 'userregister':
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'user', 'jsvmlt'=>'userregister')), 'text' => __('Register', 'js-vehicle-manager'));
                            break;
                            case 'stats':
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'user', 'jsvmlt'=>'stats')), 'text' => __('My Stats', 'js-vehicle-manager'));
                            break;
                            case 'viewsellerinfo':
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'user', 'jsvmlt'=>'sellerlist')), 'text' => __('Seller List', 'js-vehicle-manager'));
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'user', 'jsvmlt'=>'viewsellerinfo')), 'text' => __('Seller Info', 'js-vehicle-manager'));
                            break;
                        }
                    break;
                    case 'vehicle':
                        // Add default module link
                        switch ($layout) {
                            case 'myvehicles':
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'myvehicles')), 'text' => __('My Vehicles', 'js-vehicle-manager'));
                            break;
                            case 'vehicledetail':
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehicles')), 'text' => __('Vehicles', 'js-vehicle-manager'));
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehicledetail')), 'text' => __('Vehicle Detail', 'js-vehicle-manager'));
                            break;
                            case 'vehicles':
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehicles')), 'text' => __('Vehicles', 'js-vehicle-manager'));
                            break;
                            case 'vehiclesearch':
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehiclesearch')), 'text' => __('Search Vehicle', 'js-vehicle-manager'));
                            break;
                            case 'shortlistvehicles':
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'shortlist', 'jsvmlt'=>'shortlistvehicles')), 'text' => __('Shortlisted Vehicles', 'js-vehicle-manager'));
                            break;
                            case 'comparevehicles':
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehicles')), 'text' => __('Vehicles', 'js-vehicle-manager'));
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'comparevehicle', 'jsvmlt'=>'comparevehicles')), 'text' => __('Compare Vehicles', 'js-vehicle-manager'));
                            break;
                            case 'formvehicle':
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'myvehicles')), 'text' => __('My Vehicles', 'js-vehicle-manager'));
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'formvehicle')), 'text' => __('Form Vehicle', 'js-vehicle-manager'));
                            break;
                        }
                    break;
                    case 'make':
                        // Add default module link
                        switch ($layout) {
                            case 'vehiclesbymake':
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'make', 'jsvmlt'=>'vehiclesbymake')), 'text' => __('Vehicles By Make', 'js-vehicle-manager'));
                            break;
                        }
                    break;
                    case 'conditions':
                        // Add default module link
                        switch ($layout) {
                            case 'vehiclesbycondition':
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'conditions', 'jsvmlt'=>'vehiclesbycondition')), 'text' => __('Vehicles By Condition', 'js-vehicle-manager'));
                            break;
                        }
                    break;
                    case 'city':
                        // Add default module link
                        switch ($layout) {
                            case 'vehiclesbycity':
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'city', 'jsvmlt'=>'vehiclesbycity')), 'text' => __('Vehicles By City', 'js-vehicle-manager'));
                            break;
                        }
                    break;
                    case 'credits':
                        // Add default module link
                        switch ($layout) {
                            case 'ratelist':
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'credits', 'jsvmlt'=>'ratelist')), 'text' => __('Rate List', 'js-vehicle-manager'));
                            break;
                        }
                    break;
                    case 'creditslog':
                        // Add default module link
                        switch ($layout) {
                            case 'creditslog':
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'creditslog', 'jsvmlt'=>'creditslog')), 'text' => __('Credits Log', 'js-vehicle-manager'));
                            break;
                        }
                    break;
                    case 'creditspack':
                        // Add default module link
                        switch ($layout) {
                            case 'creditspack':
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'creditspack', 'jsvmlt'=>'creditspack')), 'text' => __('Credits Pack', 'js-vehicle-manager'));
                            break;
                        }
                    break;
                    case 'purchasehistory':
                        // Add default module link
                        switch ($layout) {
                            case 'purchasehistory':
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'purchasehistory', 'jsvmlt'=>'purchasehistory')), 'text' => __('Purchase History', 'js-vehicle-manager'));
                            break;
                        }
                    break;
                    case 'vehiclealert':
                        // Add default module link
                        switch ($layout) {
                            case 'vehiclealerts':
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'vehiclealert', 'jsvmlt'=>'vehiclealerts')), 'text' => __('Vehicle Alert', 'js-vehicle-manager'));
                            break;
                        }
                    break;
                    case 'vehicletype':
                        // Add default module link
                        switch ($layout) {
                            case 'vehiclesbytype':
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicletype', 'jsvmlt'=>'vehiclesbytype')), 'text' => __('Vehicles By Types', 'js-vehicle-manager'));
                            break;
                        }
                    break;
                    case 'jsvehiclemanager':
                        // Add default module link
                        switch ($layout) {
                            case 'login':
                                $array[] = array('link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'jsvehiclemanager', 'jsvmlt'=>'login')), 'text' => __('Login', 'js-vehicle-manager'));
                            break;
                        }
                    break;
                }
            }
        }
        if (isset($array)) {
            $count = count($array);
            $i = 0;
            echo '<div id="jsvehiclemanager_breadcrumbs_parent">';
            foreach ($array AS $obj) {
                if ($i == 0) {
                    echo '<div class="jsvehiclemanager_home"><a href="' . $obj['link'] . '"><img class="homeicon" src="' . JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/homeicon.png"/></a></div>';
                } else {
                    if ($i == ($count - 1)) {
                        echo '<div class="jsvehiclemanager_lastlink">' . $obj['text'] . '</div>';
                    } else {
                        echo '<div class="jsvehiclemanager_links"><a class="jsvehiclemanager_links" href="' . $obj['link'] . '">' . $obj['text'] . '</a></div>';
                    }
                }
                $i++;
            }
            echo '</div>';
        }
    }

}

$JSVEHICLEMANAGERbreadcrumbs = new JSVEHICLEMANAGERbreadcrumbs;
?>
