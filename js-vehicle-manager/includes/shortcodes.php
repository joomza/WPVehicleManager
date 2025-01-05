<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
	// Vehicle Manager Pages
	if( ! function_exists( 'vehicle_manager_pages' ) ) {
	    function vehicle_manager_pages($raw_args, $content = null){
	    	ob_start();
	        $defaults = array(
	            'page' => "",
	            'tell_a_friend' => "",
	            'title' => __('Thank you','js-vehicle-manager'),
	            'message' => __('Please add your text field for the ','js-vehicle-manager'),
	        );
	        $sanitized_args = shortcode_atts($defaults, $raw_args);
	        if(isset(jsvehiclemanager::$_data['sanitized_args']) && !empty(jsvehiclemanager::$_data['sanitized_args'])){
                jsvehiclemanager::$_data['sanitized_args'] += $sanitized_args;
            }else{
	        	jsvehiclemanager::$_data['sanitized_args'] = $sanitized_args;
            }
	        //echo '<pre>';print_r(jsvehiclemanager::$_data['sanitized_args']);echo '</pre>';exit;
	        $pageid = JSVEHICLEMANAGERrequest::getVar('page_id');
	        if(!$pageid)  $pageid = get_the_ID();
	        jsvehiclemanager::setPageID($pageid);
	        jsvehiclemanager::addStyleSheets();
	        $offline = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('offline');
	        if ($offline == 1) {
	            JSVEHICLEMANAGERlayout::getSystemOffline();
	        } else {
	        	switch($sanitized_args['page']){
	        		case 1: // List Vehicles
		        		$module = 'vehicle';
		        		jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = (!isset(jsvehiclemanager::$_data['sanitized_args']['jsvmlt']) || empty(jsvehiclemanager::$_data['sanitized_args']['jsvmlt'])) ? 'vehicles' : jsvehiclemanager::$_data['sanitized_args']['jsvmlt'];
	        		break;
	        		case 2: // List Search
		        		$module = 'vehicle';
		        		jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = (!isset(jsvehiclemanager::$_data['sanitized_args']['jsvmlt']) || empty(jsvehiclemanager::$_data['sanitized_args']['jsvmlt'])) ? 'vehiclesearch' : jsvehiclemanager::$_data['sanitized_args']['jsvmlt'];
	        		break;
	        		case 3: // Add Vehicle
		        		$module = 'vehicle';
		        		jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = (!isset(jsvehiclemanager::$_data['sanitized_args']['jsvmlt']) || empty(jsvehiclemanager::$_data['sanitized_args']['jsvmlt'])) ? 'formvehicle' : jsvehiclemanager::$_data['sanitized_args']['jsvmlt'];
	        		break;
	        		case 4: // My Vehicles
		        		$module = 'vehicle';
		        		jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = (!isset(jsvehiclemanager::$_data['sanitized_args']['jsvmlt']) || empty(jsvehiclemanager::$_data['sanitized_args']['jsvmlt'])) ? 'myvehicles' : jsvehiclemanager::$_data['sanitized_args']['jsvmlt'];
	        		break;
	        		case 5: // My Profile
		        		$module = 'user';
		        		jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = (!isset(jsvehiclemanager::$_data['sanitized_args']['jsvmlt']) || empty(jsvehiclemanager::$_data['sanitized_args']['jsvmlt'])) ? 'dashboard' : jsvehiclemanager::$_data['sanitized_args']['jsvmlt'];
	        		break;
	        		case 6: // Compare Vehicles
		        		$module = 'comparevehicle';
		        		jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = (!isset(jsvehiclemanager::$_data['sanitized_args']['jsvmlt']) || empty(jsvehiclemanager::$_data['sanitized_args']['jsvmlt'])) ? 'comparevehicles' : jsvehiclemanager::$_data['sanitized_args']['jsvmlt'];
	        		break;
	        		case 7: // Vehicle Detail
		        		$module = 'vehicle';
		        		jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = (!isset(jsvehiclemanager::$_data['sanitized_args']['jsvmlt']) || empty(jsvehiclemanager::$_data['sanitized_args']['jsvmlt'])) ? 'vehicledetail' : jsvehiclemanager::$_data['sanitized_args']['jsvmlt'];
	        		break;
	        		case 8: // Shortlisted Vehicles
		        		$module = 'shortlist';
		        		jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = (!isset(jsvehiclemanager::$_data['sanitized_args']['jsvmlt']) || empty(jsvehiclemanager::$_data['sanitized_args']['jsvmlt'])) ? 'shortlistvehicles' : jsvehiclemanager::$_data['sanitized_args']['jsvmlt'];
	        		break;
	        		case 9: // Vehicles by City
		        		$module = 'city';
		        		jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = (!isset(jsvehiclemanager::$_data['sanitized_args']['jsvmlt']) || empty(jsvehiclemanager::$_data['sanitized_args']['jsvmlt'])) ? 'vehiclesbycity' : jsvehiclemanager::$_data['sanitized_args']['jsvmlt'];
	        		break;
	        		case 10: // Vehicles by Type
		        		$module = 'vehicletype';
		        		jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = (!isset(jsvehiclemanager::$_data['sanitized_args']['jsvmlt']) || empty(jsvehiclemanager::$_data['sanitized_args']['jsvmlt'])) ? 'vehiclesbytype' : jsvehiclemanager::$_data['sanitized_args']['jsvmlt'];
	        		break;
	        		case 11: // Vehicles by Make
		        		$module = 'make';
		        		jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = (!isset(jsvehiclemanager::$_data['sanitized_args']['jsvmlt']) || empty(jsvehiclemanager::$_data['sanitized_args']['jsvmlt'])) ? 'vehiclesbymake' : jsvehiclemanager::$_data['sanitized_args']['jsvmlt'];
	        		break;
	        		case 12: // Seller List
		        		$module = 'user';
		        		jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = (!isset(jsvehiclemanager::$_data['sanitized_args']['jsvmlt']) || empty(jsvehiclemanager::$_data['sanitized_args']['jsvmlt'])) ? 'sellerlist' : jsvehiclemanager::$_data['sanitized_args']['jsvmlt'];
	        		break;
	        		case 13: // Seller Detail
		        		$module = 'user';
		        		jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = (!isset(jsvehiclemanager::$_data['sanitized_args']['jsvmlt']) || empty(jsvehiclemanager::$_data['sanitized_args']['jsvmlt'])) ? 'viewsellerinfo' : jsvehiclemanager::$_data['sanitized_args']['jsvmlt'];
	        		break;
	        		case 14: // Credits Pack
		        		$module = 'creditspack';
		        		jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = (!isset(jsvehiclemanager::$_data['sanitized_args']['jsvmlt']) || empty(jsvehiclemanager::$_data['sanitized_args']['jsvmlt'])) ? 'creditspack' : jsvehiclemanager::$_data['sanitized_args']['jsvmlt'];
	        		break;
	        		case 15: // Credits Rate List
		        		$module = 'credits';
		        		jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = (!isset(jsvehiclemanager::$_data['sanitized_args']['jsvmlt']) || empty(jsvehiclemanager::$_data['sanitized_args']['jsvmlt'])) ? 'ratelist' : jsvehiclemanager::$_data['sanitized_args']['jsvmlt'];
	        		break;
	        		case 16: // Purchase History
		        		$module = 'purchasehistory';
		        		jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = (!isset(jsvehiclemanager::$_data['sanitized_args']['jsvmlt']) || empty(jsvehiclemanager::$_data['sanitized_args']['jsvmlt'])) ? 'purchasehistory' : jsvehiclemanager::$_data['sanitized_args']['jsvmlt'];
	        		break;
	        		case 17: // Credits Log
		        		$module = 'creditslog';
		        		jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = (!isset(jsvehiclemanager::$_data['sanitized_args']['jsvmlt']) || empty(jsvehiclemanager::$_data['sanitized_args']['jsvmlt'])) ? 'creditslog' : jsvehiclemanager::$_data['sanitized_args']['jsvmlt'];
	        		break;
	        		case 18: // Vehicle alerts
		        		$module = 'vehiclealert';
		        		jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = (!isset(jsvehiclemanager::$_data['sanitized_args']['jsvmlt']) || empty(jsvehiclemanager::$_data['sanitized_args']['jsvmlt'])) ? 'vehiclealerts' : jsvehiclemanager::$_data['sanitized_args']['jsvmlt'];
	        		break;
	        		case 19: // Login
	        			$module = 'jsvehiclemanager';
		        		jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = (!isset(jsvehiclemanager::$_data['sanitized_args']['jsvmlt']) || empty(jsvehiclemanager::$_data['sanitized_args']['jsvmlt'])) ? 'login' : jsvehiclemanager::$_data['sanitized_args']['jsvmlt'];
	        		break;
	        		case 20: // Thank you
		        		$module = 'jsvehiclemanager';
		        		jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = (!isset(jsvehiclemanager::$_data['sanitized_args']['jsvmlt']) || empty(jsvehiclemanager::$_data['sanitized_args']['jsvmlt'])) ? 'thankyou' : jsvehiclemanager::$_data['sanitized_args']['jsvmlt'];
	        		break;
	        		case 21: // buyer
		        		$module = 'buyer';
		        		jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = (!isset(jsvehiclemanager::$_data['sanitized_args']['jsvmlt']) || empty(jsvehiclemanager::$_data['sanitized_args']['jsvmlt'])) ? 'controlpanel' : jsvehiclemanager::$_data['sanitized_args']['jsvmlt'];
	        		break;
	        		case 22: // Thank you
		        		$module = 'seller';
		        		jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = (!isset(jsvehiclemanager::$_data['sanitized_args']['jsvmlt']) || empty(jsvehiclemanager::$_data['sanitized_args']['jsvmlt'])) ? 'controlpanel' : jsvehiclemanager::$_data['sanitized_args']['jsvmlt'];
	        		break;
	        		default:
		        		$module = 'vehicle';
		        		jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = (!isset(jsvehiclemanager::$_data['sanitized_args']['jsvmlt']) || empty(jsvehiclemanager::$_data['sanitized_args']['jsvmlt'])) ? 'vehicles' : jsvehiclemanager::$_data['sanitized_args']['jsvmlt'];
	        		break;
	        	}
	        	//echo '<pre>';print_r(jsvehiclemanager::$_data['sanitized_args']);exit;
				$c_mod = JSVEHICLEMANAGERrequest::getVar('jsvmme');
	        	if($c_mod){
	        		$module = $c_mod;
	        	}
	        	JSVEHICLEMANAGERincluder::include_file($module);
	        }
	        $content .= ob_get_clean();
	        return $content;
	    }
	}
add_shortcode( 'vehicle_manager_pages', 'vehicle_manager_pages' );
// plugin shortcodes start
	add_shortcode('jsvehiclemanager_list_vehicles', 'show_list_vehicles');
		function show_list_vehicles($raw_args, $content = null) {
		    //default set of parameters for the front end shortcodes
		    ob_start();
		    $defaults = array(
		        'jsvmme' => 'vehicle',
		        'jsvmlt' => 'vehicles',
		    );
		    $sanitized_args = shortcode_atts($defaults, $raw_args);
		    if(isset(jsvehiclemanager::$_data['sanitized_args']) && !empty(jsvehiclemanager::$_data['sanitized_args'])){
		        jsvehiclemanager::$_data['sanitized_args'] += $sanitized_args;
		    }else{
		        jsvehiclemanager::$_data['sanitized_args'] = $sanitized_args;
		    }
		    $pageid = get_the_ID();
		    jsvehiclemanager::setPageID($pageid);
		    jsvehiclemanager::addStyleSheets();
		    $offline =JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('offline');
		    if ($offline == 1) {
		        JSVEHICLEMANAGERlayout::getSystemOffline();
		    } elseif (JSVEHICLEMANAGERincluder::getObjectClass('user')->isdisabled()) { // handling for the user disabled
		        JSVEHICLEMANAGERlayout::getUserDisabledMsg();
		    } else {
		        $module = JSVEHICLEMANAGERrequest::getVar('jsvmme', null, 'vehicle');
		        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'vehicles');
	            JSVEHICLEMANAGERincluder::include_file($module);
		    }
		    $content .= ob_get_clean();
		    return $content;
		}

	add_shortcode('jsvehiclemanager_vehicle_search', 'show_vehicle_search');
		function show_vehicle_search($raw_args, $content = null) {
		    //default set of parameters for the front end shortcodes
		    ob_start();
		    $defaults = array(
		        'jsvmme' => 'vehicle',
		        'jsvmlt' => 'vehiclesearch',
		    );
		    $sanitized_args = shortcode_atts($defaults, $raw_args);
		    if(isset(jsvehiclemanager::$_data['sanitized_args']) && !empty(jsvehiclemanager::$_data['sanitized_args'])){
		        jsvehiclemanager::$_data['sanitized_args'] += $sanitized_args;
		    }else{
		        jsvehiclemanager::$_data['sanitized_args'] = $sanitized_args;
		    }
		    $pageid = get_the_ID();
		    jsvehiclemanager::setPageID($pageid);
		    jsvehiclemanager::addStyleSheets();
		    $offline =JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('offline');
		    if ($offline == 1) {
		        JSVEHICLEMANAGERlayout::getSystemOffline();
		    } elseif (JSVEHICLEMANAGERincluder::getObjectClass('user')->isdisabled()) { // handling for the user disabled
		        JSVEHICLEMANAGERlayout::getUserDisabledMsg();
		    } else {
		        $module = JSVEHICLEMANAGERrequest::getVar('jsvmme', null, 'vehicle');
		        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'vehiclesearch');
	            JSVEHICLEMANAGERincluder::include_file($module);
		    }
		    $content .= ob_get_clean();
		    return $content;
		}

	add_shortcode('jsvehiclemanager_add_vehicle', 'show_add_vehicle');
		function show_add_vehicle($raw_args, $content = null) {
		    //default set of parameters for the front end shortcodes
		    ob_start();
		    $defaults = array(
		        'jsvmme' => 'vehicle',
		        'jsvmlt' => 'formvehicle',
		    );
		    $sanitized_args = shortcode_atts($defaults, $raw_args);
		    if(isset(jsvehiclemanager::$_data['sanitized_args']) && !empty(jsvehiclemanager::$_data['sanitized_args'])){
		        jsvehiclemanager::$_data['sanitized_args'] += $sanitized_args;
		    }else{
		        jsvehiclemanager::$_data['sanitized_args'] = $sanitized_args;
		    }
		    $pageid = get_the_ID();
		    jsvehiclemanager::setPageID($pageid);
		    jsvehiclemanager::addStyleSheets();
		    $offline =JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('offline');
		    if ($offline == 1) {
		        JSVEHICLEMANAGERlayout::getSystemOffline();
		    } elseif (JSVEHICLEMANAGERincluder::getObjectClass('user')->isdisabled()) { // handling for the user disabled
		        JSVEHICLEMANAGERlayout::getUserDisabledMsg();
		    } else {
		        $module = JSVEHICLEMANAGERrequest::getVar('jsvmme', null, 'vehicle');
		        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'formvehicle');
	            JSVEHICLEMANAGERincluder::include_file($module);
		    }
		    $content .= ob_get_clean();
		    return $content;
		}

	add_shortcode('jsvehiclemanager_my_vehicles', 'show_my_vehicles');
		function show_my_vehicles($raw_args, $content = null) {
		    //default set of parameters for the front end shortcodes
		    ob_start();
		    $defaults = array(
		        'jsvmme' => 'vehicle',
		        'jsvmlt' => 'myvehicles',
		    );
		    $sanitized_args = shortcode_atts($defaults, $raw_args);
		    if(isset(jsvehiclemanager::$_data['sanitized_args']) && !empty(jsvehiclemanager::$_data['sanitized_args'])){
		        jsvehiclemanager::$_data['sanitized_args'] += $sanitized_args;
		    }else{
		        jsvehiclemanager::$_data['sanitized_args'] = $sanitized_args;
		    }
		    $pageid = get_the_ID();
		    jsvehiclemanager::setPageID($pageid);
		    jsvehiclemanager::addStyleSheets();
		    $offline =JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('offline');
		    if ($offline == 1) {
		        JSVEHICLEMANAGERlayout::getSystemOffline();
		    } elseif (JSVEHICLEMANAGERincluder::getObjectClass('user')->isdisabled()) { // handling for the user disabled
		        JSVEHICLEMANAGERlayout::getUserDisabledMsg();
		    } else {
		        $module = JSVEHICLEMANAGERrequest::getVar('jsvmme', null, 'vehicle');
		        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'myvehicles');
	            JSVEHICLEMANAGERincluder::include_file($module);
		    }
		    $content .= ob_get_clean();
		    return $content;
		}

	add_shortcode('jsvehiclemanager_control_panel', 'show_control_panel');
		function show_control_panel($raw_args, $content = null) {
		    //default set of parameters for the front end shortcodes
		    ob_start();
		    $defaults = array(
		        'jsvmme' => 'user',
		        'jsvmlt' => 'dashboard',
		    );
		    $sanitized_args = shortcode_atts($defaults, $raw_args);
		    if(isset(jsvehiclemanager::$_data['sanitized_args']) && !empty(jsvehiclemanager::$_data['sanitized_args'])){
		        jsvehiclemanager::$_data['sanitized_args'] += $sanitized_args;
		    }else{
		        jsvehiclemanager::$_data['sanitized_args'] = $sanitized_args;
		    }
		    $pageid = get_the_ID();
		    jsvehiclemanager::setPageID($pageid);
		    jsvehiclemanager::addStyleSheets();
		    $offline =JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('offline');
		    if ($offline == 1) {
		        JSVEHICLEMANAGERlayout::getSystemOffline();
		    } elseif (JSVEHICLEMANAGERincluder::getObjectClass('user')->isdisabled()) { // handling for the user disabled
		        JSVEHICLEMANAGERlayout::getUserDisabledMsg();
		    } else {
		        $module = JSVEHICLEMANAGERrequest::getVar('jsvmme', null, 'user');
		        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'dashboard');
	            JSVEHICLEMANAGERincluder::include_file($module);
		    }
		    $content .= ob_get_clean();
		    return $content;
		}

	add_shortcode('jsvehiclemanager_compare_vehicles', 'show_compare_vehicles');
		function show_compare_vehicles($raw_args, $content = null) {
			//default set of parameters for the front end shortcodes
		    ob_start();
		    $defaults = array(
		        'jsvmme' => 'comparevehicle',
		        'jsvmlt' => 'comparevehicles',
		    );
		    $sanitized_args = shortcode_atts($defaults, $raw_args);
		    if(isset(jsvehiclemanager::$_data['sanitized_args']) && !empty(jsvehiclemanager::$_data['sanitized_args'])){
		        jsvehiclemanager::$_data['sanitized_args'] += $sanitized_args;
		    }else{
		        jsvehiclemanager::$_data['sanitized_args'] = $sanitized_args;
		    }
		    $pageid = get_the_ID();
		    jsvehiclemanager::setPageID($pageid);
		    jsvehiclemanager::addStyleSheets();
		    $offline =JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('offline');
		    if ($offline == 1) {
		        JSVEHICLEMANAGERlayout::getSystemOffline();
		    } elseif (JSVEHICLEMANAGERincluder::getObjectClass('user')->isdisabled()) { // handling for the user disabled
		        JSVEHICLEMANAGERlayout::getUserDisabledMsg();
		    } else {
		        $module = JSVEHICLEMANAGERrequest::getVar('jsvmme', null, 'comparevehicle');
		        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'comparevehicles');
	            JSVEHICLEMANAGERincluder::include_file($module);
		    }
		    $content .= ob_get_clean();
		    return $content;
		}

	add_shortcode('jsvehiclemanager_shortlisted_vehicles', 'show_shortlisted_vehicles');
		function show_shortlisted_vehicles($raw_args, $content = null) {
		    //default set of parameters for the front end shortcodes
		    ob_start();
		    $defaults = array(
		        'jsvmme' => 'shortlist',
		        'jsvmlt' => 'shortlistvehicles',
		    );
		    $sanitized_args = shortcode_atts($defaults, $raw_args);
		    if(isset(jsvehiclemanager::$_data['sanitized_args']) && !empty(jsvehiclemanager::$_data['sanitized_args'])){
		        jsvehiclemanager::$_data['sanitized_args'] += $sanitized_args;
		    }else{
		        jsvehiclemanager::$_data['sanitized_args'] = $sanitized_args;
		    }
		    $pageid = get_the_ID();
		    jsvehiclemanager::setPageID($pageid);
		    jsvehiclemanager::addStyleSheets();
		    $offline =JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('offline');
		    if ($offline == 1) {
		        JSVEHICLEMANAGERlayout::getSystemOffline();
		    } elseif (JSVEHICLEMANAGERincluder::getObjectClass('user')->isdisabled()) { // handling for the user disabled
		        JSVEHICLEMANAGERlayout::getUserDisabledMsg();
		    } else {
		        $module = JSVEHICLEMANAGERrequest::getVar('jsvmme', null, 'vehicle');
		        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'shortlistvehicles');
	            JSVEHICLEMANAGERincluder::include_file($module);
		    }
		    $content .= ob_get_clean();
		    return $content;
		}

	add_shortcode('jsvehiclemanager_vehicles_by_city', 'show_vehicles_by_city');
		function show_vehicles_by_city($raw_args, $content = null) {
		    //default set of parameters for the front end shortcodes
		    ob_start();
		    $defaults = array(
		        'jsvmme' => 'city',
		        'jsvmlt' => 'vehiclesbycity',
		    );
		    $sanitized_args = shortcode_atts($defaults, $raw_args);
		    if(isset(jsvehiclemanager::$_data['sanitized_args']) && !empty(jsvehiclemanager::$_data['sanitized_args'])){
		        jsvehiclemanager::$_data['sanitized_args'] += $sanitized_args;
		    }else{
		        jsvehiclemanager::$_data['sanitized_args'] = $sanitized_args;
		    }
		    $pageid = get_the_ID();
		    jsvehiclemanager::setPageID($pageid);
		    jsvehiclemanager::addStyleSheets();
		    $offline =JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('offline');
		    if ($offline == 1) {
		        JSVEHICLEMANAGERlayout::getSystemOffline();
		    } elseif (JSVEHICLEMANAGERincluder::getObjectClass('user')->isdisabled()) { // handling for the user disabled
		        JSVEHICLEMANAGERlayout::getUserDisabledMsg();
		    } else {
		        $module = JSVEHICLEMANAGERrequest::getVar('jsvmme', null, 'city');
		        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'vehiclesbycity');
	            JSVEHICLEMANAGERincluder::include_file($module);
		    }
		    $content .= ob_get_clean();
		    return $content;
		}

	add_shortcode('jsvehiclemanager_vehicles_by_type', 'show_vehicles_by_type');
		function show_vehicles_by_type($raw_args, $content = null) {
		    //default set of parameters for the front end shortcodes
		    ob_start();
		    $defaults = array(
		        'jsvmme' => 'vehicletype',
		        'jsvmlt' => 'vehiclesbytype',
		    );
		    $sanitized_args = shortcode_atts($defaults, $raw_args);
		    if(isset(jsvehiclemanager::$_data['sanitized_args']) && !empty(jsvehiclemanager::$_data['sanitized_args'])){
		        jsvehiclemanager::$_data['sanitized_args'] += $sanitized_args;
		    }else{
		        jsvehiclemanager::$_data['sanitized_args'] = $sanitized_args;
		    }
		    $pageid = get_the_ID();
		    jsvehiclemanager::setPageID($pageid);
		    jsvehiclemanager::addStyleSheets();
		    $offline =JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('offline');
		    if ($offline == 1) {
		        JSVEHICLEMANAGERlayout::getSystemOffline();
		    } elseif (JSVEHICLEMANAGERincluder::getObjectClass('user')->isdisabled()) { // handling for the user disabled
		        JSVEHICLEMANAGERlayout::getUserDisabledMsg();
		    } else {
		        $module = JSVEHICLEMANAGERrequest::getVar('jsvmme', null, 'vehicletype');
		        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'vehiclesbytype');
	            JSVEHICLEMANAGERincluder::include_file($module);
		    }
		    $content .= ob_get_clean();
		    return $content;
		}

	add_shortcode('jsvehiclemanager_vehicles_by_make', 'show_vehicles_by_make');
		function show_vehicles_by_make($raw_args, $content = null) {
		    //default set of parameters for the front end shortcodes
		    ob_start();
		    $defaults = array(
		        'jsvmme' => 'make',
		        'jsvmlt' => 'vehiclesbymake',
		    );
		    $sanitized_args = shortcode_atts($defaults, $raw_args);
		    if(isset(jsvehiclemanager::$_data['sanitized_args']) && !empty(jsvehiclemanager::$_data['sanitized_args'])){
		        jsvehiclemanager::$_data['sanitized_args'] += $sanitized_args;
		    }else{
		        jsvehiclemanager::$_data['sanitized_args'] = $sanitized_args;
		    }
		    $pageid = get_the_ID();
		    jsvehiclemanager::setPageID($pageid);
		    jsvehiclemanager::addStyleSheets();
		    $offline =JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('offline');
		    if ($offline == 1) {
		        JSVEHICLEMANAGERlayout::getSystemOffline();
		    } elseif (JSVEHICLEMANAGERincluder::getObjectClass('user')->isdisabled()) { // handling for the user disabled
		        JSVEHICLEMANAGERlayout::getUserDisabledMsg();
		    } else {
		        $module = JSVEHICLEMANAGERrequest::getVar('jsvmme', null, 'make');
		        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'vehiclesbymake');
	            JSVEHICLEMANAGERincluder::include_file($module);
		    }
		    $content .= ob_get_clean();
		    return $content;
		}

	add_shortcode('jsvehiclemanager_sellers_list', 'show_sellers_list');
		function show_sellers_list($raw_args, $content = null) {
		    //default set of parameters for the front end shortcodes
		    ob_start();
		    $defaults = array(
		        'jsvmme' => 'user',
		        'jsvmlt' => 'sellerlist',
		    );
		    $sanitized_args = shortcode_atts($defaults, $raw_args);
		    if(isset(jsvehiclemanager::$_data['sanitized_args']) && !empty(jsvehiclemanager::$_data['sanitized_args'])){
		        jsvehiclemanager::$_data['sanitized_args'] += $sanitized_args;
		    }else{
		        jsvehiclemanager::$_data['sanitized_args'] = $sanitized_args;
		    }
		    $pageid = get_the_ID();
		    jsvehiclemanager::setPageID($pageid);
		    jsvehiclemanager::addStyleSheets();
		    $offline =JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('offline');
		    if ($offline == 1) {
		        JSVEHICLEMANAGERlayout::getSystemOffline();
		    } elseif (JSVEHICLEMANAGERincluder::getObjectClass('user')->isdisabled()) { // handling for the user disabled
		        JSVEHICLEMANAGERlayout::getUserDisabledMsg();
		    } else {
		        $module = JSVEHICLEMANAGERrequest::getVar('jsvmme', null, 'user');
		        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'sellerlist');
	            JSVEHICLEMANAGERincluder::include_file($module);
		    }
		    $content .= ob_get_clean();
		    return $content;
		}

	add_shortcode('jsvehiclemanager_sellers_by_city', 'show_sellers_by_city');
		function show_sellers_by_city($raw_args, $content = null) {
		    //default set of parameters for the front end shortcodes
		    ob_start();
		    $defaults = array(
		        'jsvmme' => 'user',
		        'jsvmlt' => 'sellerbycity',
		    );
		    $sanitized_args = shortcode_atts($defaults, $raw_args);
		    if(isset(jsvehiclemanager::$_data['sanitized_args']) && !empty(jsvehiclemanager::$_data['sanitized_args'])){
		        jsvehiclemanager::$_data['sanitized_args'] += $sanitized_args;
		    }else{
		        jsvehiclemanager::$_data['sanitized_args'] = $sanitized_args;
		    }
		    $pageid = get_the_ID();
		    jsvehiclemanager::setPageID($pageid);
		    jsvehiclemanager::addStyleSheets();
		    $offline =JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('offline');
		    if ($offline == 1) {
		        JSVEHICLEMANAGERlayout::getSystemOffline();
		    } elseif (JSVEHICLEMANAGERincluder::getObjectClass('user')->isdisabled()) { // handling for the user disabled
		        JSVEHICLEMANAGERlayout::getUserDisabledMsg();
		    } else {
		        $module = JSVEHICLEMANAGERrequest::getVar('jsvmme', null, 'user');
		        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'sellerbycity');
	            JSVEHICLEMANAGERincluder::include_file($module);
		    }
		    $content .= ob_get_clean();
		    return $content;
		}

	add_shortcode('jsvehiclemanager_credits_pack', 'show_credits_pack');
		function show_credits_pack($raw_args, $content = null) {
		    //default set of parameters for the front end shortcodes
		    ob_start();
		    $defaults = array(
		        'jsvmme' => 'creditspack',
		        'jsvmlt' => 'creditspack',
		    );
		    $sanitized_args = shortcode_atts($defaults, $raw_args);
		    if(isset(jsvehiclemanager::$_data['sanitized_args']) && !empty(jsvehiclemanager::$_data['sanitized_args'])){
		        jsvehiclemanager::$_data['sanitized_args'] += $sanitized_args;
		    }else{
		        jsvehiclemanager::$_data['sanitized_args'] = $sanitized_args;
		    }
		    $pageid = get_the_ID();
		    jsvehiclemanager::setPageID($pageid);
		    jsvehiclemanager::addStyleSheets();
		    $offline =JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('offline');
		    if ($offline == 1) {
		        JSVEHICLEMANAGERlayout::getSystemOffline();
		    } elseif (JSVEHICLEMANAGERincluder::getObjectClass('user')->isdisabled()) { // handling for the user disabled
		        JSVEHICLEMANAGERlayout::getUserDisabledMsg();
		    } else {
		        $module = JSVEHICLEMANAGERrequest::getVar('jsvmme', null, 'creditspack');
		        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'creditspack');
	            JSVEHICLEMANAGERincluder::include_file($module);
		    }
		    $content .= ob_get_clean();
		    return $content;
		}

	add_shortcode('jsvehiclemanager_credits_rate_list', 'show_credits_rate_list');
		function show_credits_rate_list($raw_args, $content = null) {
		    //default set of parameters for the front end shortcodes
		    ob_start();
		    $defaults = array(
		        'jsvmme' => 'credits',
		        'jsvmlt' => 'ratelist',
		    );
		    $sanitized_args = shortcode_atts($defaults, $raw_args);
		    if(isset(jsvehiclemanager::$_data['sanitized_args']) && !empty(jsvehiclemanager::$_data['sanitized_args'])){
		        jsvehiclemanager::$_data['sanitized_args'] += $sanitized_args;
		    }else{
		        jsvehiclemanager::$_data['sanitized_args'] = $sanitized_args;
		    }
		    $pageid = get_the_ID();
		    jsvehiclemanager::setPageID($pageid);
		    jsvehiclemanager::addStyleSheets();
		    $offline =JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('offline');
		    if ($offline == 1) {
		        JSVEHICLEMANAGERlayout::getSystemOffline();
		    } elseif (JSVEHICLEMANAGERincluder::getObjectClass('user')->isdisabled()) { // handling for the user disabled
		        JSVEHICLEMANAGERlayout::getUserDisabledMsg();
		    } else {
		        $module = JSVEHICLEMANAGERrequest::getVar('jsvmme', null, 'credits');
		        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'ratelist');
	            JSVEHICLEMANAGERincluder::include_file($module);
		    }
		    $content .= ob_get_clean();
		    return $content;
		}

	add_shortcode('jsvehiclemanager_purchase_history', 'show_purchase_history');
		function show_purchase_history($raw_args, $content = null) {
		    //default set of parameters for the front end shortcodes
		    ob_start();
		    $defaults = array(
		        'jsvmme' => 'purchasehistory',
		        'jsvmlt' => 'purchasehistory',
		    );
		    $sanitized_args = shortcode_atts($defaults, $raw_args);
		    if(isset(jsvehiclemanager::$_data['sanitized_args']) && !empty(jsvehiclemanager::$_data['sanitized_args'])){
		        jsvehiclemanager::$_data['sanitized_args'] += $sanitized_args;
		    }else{
		        jsvehiclemanager::$_data['sanitized_args'] = $sanitized_args;
		    }
		    $pageid = get_the_ID();
		    jsvehiclemanager::setPageID($pageid);
		    jsvehiclemanager::addStyleSheets();
		    $offline =JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('offline');
		    if ($offline == 1) {
		        JSVEHICLEMANAGERlayout::getSystemOffline();
		    } elseif (JSVEHICLEMANAGERincluder::getObjectClass('user')->isdisabled()) { // handling for the user disabled
		        JSVEHICLEMANAGERlayout::getUserDisabledMsg();
		    } else {
		        $module = JSVEHICLEMANAGERrequest::getVar('jsvmme', null, 'purchasehistory');
		        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'purchasehistory');
	            JSVEHICLEMANAGERincluder::include_file($module);
		    }
		    $content .= ob_get_clean();
		    return $content;
		}

	add_shortcode('jsvehiclemanager_credits_log', 'show_credits_log');
		function show_credits_log($raw_args, $content = null) {
		    //default set of parameters for the front end shortcodes
		    ob_start();
		    $defaults = array(
		        'jsvmme' => 'creditslog',
		        'jsvmlt' => 'creditslog',
		    );
		    $sanitized_args = shortcode_atts($defaults, $raw_args);
		    if(isset(jsvehiclemanager::$_data['sanitized_args']) && !empty(jsvehiclemanager::$_data['sanitized_args'])){
		        jsvehiclemanager::$_data['sanitized_args'] += $sanitized_args;
		    }else{
		        jsvehiclemanager::$_data['sanitized_args'] = $sanitized_args;
		    }
		    $pageid = get_the_ID();
		    jsvehiclemanager::setPageID($pageid);
		    jsvehiclemanager::addStyleSheets();
		    $offline =JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('offline');
		    if ($offline == 1) {
		        JSVEHICLEMANAGERlayout::getSystemOffline();
		    } elseif (JSVEHICLEMANAGERincluder::getObjectClass('user')->isdisabled()) { // handling for the user disabled
		        JSVEHICLEMANAGERlayout::getUserDisabledMsg();
		    } else {
		        $module = JSVEHICLEMANAGERrequest::getVar('jsvmme', null, 'creditslog');
		        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'creditslog');
	            JSVEHICLEMANAGERincluder::include_file($module);
		    }
		    $content .= ob_get_clean();
		    return $content;
		}

	add_shortcode('jsvehiclemanager_vehicle_alerts', 'show_vehicle_alerts');
		function show_vehicle_alerts($raw_args, $content = null) {
		    //default set of parameters for the front end shortcodes
		    ob_start();
		    $defaults = array(
		        'jsvmme' => 'vehiclealert',
		        'jsvmlt' => 'vehiclealerts',
		    );
		    $sanitized_args = shortcode_atts($defaults, $raw_args);
		    if(isset(jsvehiclemanager::$_data['sanitized_args']) && !empty(jsvehiclemanager::$_data['sanitized_args'])){
		        jsvehiclemanager::$_data['sanitized_args'] += $sanitized_args;
		    }else{
		        jsvehiclemanager::$_data['sanitized_args'] = $sanitized_args;
		    }
		    $pageid = get_the_ID();
		    jsvehiclemanager::setPageID($pageid);
		    jsvehiclemanager::addStyleSheets();
		    $offline =JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('offline');
		    if ($offline == 1) {
		        JSVEHICLEMANAGERlayout::getSystemOffline();
		    } elseif (JSVEHICLEMANAGERincluder::getObjectClass('user')->isdisabled()) { // handling for the user disabled
		        JSVEHICLEMANAGERlayout::getUserDisabledMsg();
		    } else {
		        $module = JSVEHICLEMANAGERrequest::getVar('jsvmme', null, 'vehiclealert');
		        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'vehiclealerts');
	            JSVEHICLEMANAGERincluder::include_file($module);
		    }
		    $content .= ob_get_clean();
		    return $content;
		}

	add_shortcode('jsvehiclemanager_login', 'show_login');
		function show_login($raw_args, $content = null) {
			//default set of parameters for the front end shortcodes
		    ob_start();
		    $defaults = array(
		        'jsvmme' => 'jsvehiclemanager',
		        'jsvmlt' => 'login',
		    );
		    $sanitized_args = shortcode_atts($defaults, $raw_args);
		    if(isset(jsvehiclemanager::$_data['sanitized_args']) && !empty(jsvehiclemanager::$_data['sanitized_args'])){
		        jsvehiclemanager::$_data['sanitized_args'] += $sanitized_args;
		    }else{
		        jsvehiclemanager::$_data['sanitized_args'] = $sanitized_args;
		    }
		    $pageid = get_the_ID();
		    jsvehiclemanager::setPageID($pageid);
		    jsvehiclemanager::addStyleSheets();
		    $offline =JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('offline');
		    if ($offline == 1) {
		        JSVEHICLEMANAGERlayout::getSystemOffline();
		    } elseif (JSVEHICLEMANAGERincluder::getObjectClass('user')->isdisabled()) { // handling for the user disabled
		        JSVEHICLEMANAGERlayout::getUserDisabledMsg();
		    } else {
		        $module = JSVEHICLEMANAGERrequest::getVar('jsvmme', null, 'jsvehiclemanager');
		        $layout = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'login');
	            JSVEHICLEMANAGERincluder::include_file($module);
		    }
		    $content .= ob_get_clean();
		    return $content;
		}

// gutenberg vehicle manager pages

// possible end of shortcodes
		// widgets shortcodes start

	add_shortcode('vehicle_manager_vm_vehicles', 'vm_vehicles_widget');
		function vm_vehicles_widget($raw_args, $content = null) {
		    //default set of parameters for the front end shortcodes
		    ob_start();
		    $defaults = array(
		        'jsvehiclemanagerpageid' => '1',
		        'number_of_columns' => '1',
		        'numberofvehicles' => '5',
		        'heading' => 'Latest Vehicles',
		        'description' => '',
		        'typeofvehicles' => '1'
		    );
		    $sanitized_args = shortcode_atts($defaults, $raw_args);
//		    echo '<pre>';print_r($sanitized_args);exit;
		    if(isset(jsvehiclemanager::$_data['sanitized_args']) && !empty(jsvehiclemanager::$_data['sanitized_args'])){
		        jsvehiclemanager::$_data['sanitized_args'] += $sanitized_args;
		    }else{
		        jsvehiclemanager::$_data['sanitized_args'] = $sanitized_args;
		    }
		    $pageid = get_the_ID();
		    jsvehiclemanager::setPageID($pageid);
		    jsvehiclemanager::addStyleSheets();
		    jsvehiclemanager_register_plugin_styles();
		    $offline =JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('offline');
		    if ($offline != 1 && !(JSVEHICLEMANAGERincluder::getObjectClass('user')->isdisabled()) ) {
				$vehicles = JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getVehiclesWidgetData($sanitized_args['typeofvehicles'], $sanitized_args['numberofvehicles']);
		    	$mod = 'latestvehicles';
		    	if ($sanitized_args['typeofvehicles'] == 2) {
		    	    $mod = 'featuredvehicles';
		    	}
		    	$layoutName = $mod . uniqid();
				$html = JSVEHICLEMANAGERincluder::getJSModel('widget')->getVehiclesWidgetHTMl($vehicles,$sanitized_args['jsvehiclemanagerpageid'],$sanitized_args['heading'],$sanitized_args['description'],$sanitized_args['number_of_columns'],$layoutName);
				echo wp_kses($html, JSVEHICLEMANAGER_ALLOWED_TAGS);
		    }
		    $content .= ob_get_clean();
		    return $content;
		}


	add_shortcode('vehicle_manager_vm_vehicles_by_cities', 'vm_vehicles_by_cities_widget');
		function vm_vehicles_by_cities_widget($raw_args, $content = null) {
		    //default set of parameters for the front end shortcodes
		    ob_start();
		    $defaults = array(
		        'jsvehiclemanagerpageid' => '1',
		        'number_of_columns' => '3',
		        'numberofcities' => '5',
		        'heading' => 'Latest Vehicles',
		        'description' => '',
		    );
		    $sanitized_args = shortcode_atts($defaults, $raw_args);
//		    echo '<pre>';print_r($sanitized_args);exit;
		    if(isset(jsvehiclemanager::$_data['sanitized_args']) && !empty(jsvehiclemanager::$_data['sanitized_args'])){
		        jsvehiclemanager::$_data['sanitized_args'] += $sanitized_args;
		    }else{
		        jsvehiclemanager::$_data['sanitized_args'] = $sanitized_args;
		    }
		    $pageid = get_the_ID();
		    jsvehiclemanager::setPageID($pageid);
		    jsvehiclemanager::addStyleSheets();
		    jsvehiclemanager_register_plugin_styles();
		    $offline =JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('offline');
		    if ($offline != 1 && !(JSVEHICLEMANAGERincluder::getObjectClass('user')->isdisabled()) ) {
				$cities = JSVEHICLEMANAGERincluder::getJSModel('city')->getVehiclebyCitiesForWidget($sanitized_args['numberofcities']);
		    	$mod = 'vehiclesbycities';
		    	$layoutName = $mod . uniqid();
				$html = JSVEHICLEMANAGERincluder::getJSModel('widget')->getVehiclesByCitiesWidgetHTMl($cities,$sanitized_args['jsvehiclemanagerpageid'],$sanitized_args['heading'],$sanitized_args['description'],$sanitized_args['number_of_columns'],$layoutName);
				echo wp_kses($html, JSVEHICLEMANAGER_ALLOWED_TAGS);
		    }
		    $content .= ob_get_clean();
		    return $content;
		}


		// gutenberg vehicles block
		add_action( 'init', 'js_vehicle_manager_vehicles_block' );

		function js_vehicle_manager_vehicles_block() {
			if(!function_exists("register_block_type")){
				return;
			}
		    wp_register_script(
		        'jsvehiclemanagervehiclesblock',
		        JSVEHICLEMANAGER_PLUGIN_URL . 'includes/js/gutenberg/vehicles.js',
		        array( 'wp-blocks', 'wp-element','wp-editor' )
		    );
		    register_block_type( 'jsvehiclemanager/jsvehiclemanagervehiclesblock', array(
		    	'attributes'      => array(
		    	            'heading'    => array(
		    	                'type'      => 'string',
		    	                'default'   => '',
		    	            ),
		    	            'description'    => array(
		    	                'type'      => 'string',
		    	                'default'   => '',
		    	            ),
		    	            'typeofvehicles'    => array(
		    	                'type'      => 'select',
		    	                'default'   => '',
		    	            ),
		    	            'numberofvehicles'    => array(
		    	                'type'      => 'string',
		    	                'default'   => '',
		    	            ),
		    	            'number_of_columns'    => array(
		    	                'type'      => 'string',
		    	                'default'   => '',
		    	            )
		    	        ),
		        'render_callback' => 'js_vehicle_manager_vehicles_block_widget',
		        'editor_script' => 'jsvehiclemanagervehiclesblock',
		    ) );
		}

		function js_vehicle_manager_vehicles_block_widget( $attributes, $content ) {
			$defaults = array(
		        'jsvehiclemanagerpageid' => '0',
		        'number_of_columns' => '3',
		        'numberofvehicles' => '6',
		        'heading' => 'Latest Vehicle',
		        'description' => '',
		        'typeofvehicles' => '1'
		    );
		    // the code below is to avoid default value bug for gutenberg
		    $sanitized_args = shortcode_atts($defaults, $attributes);

		    if($sanitized_args['number_of_columns'] == '' || $sanitized_args['number_of_columns'] == 0){
		    	$sanitized_args['number_of_columns'] = 3;
		    }
		    if($sanitized_args['numberofvehicles'] == '' || $sanitized_args['numberofvehicles'] == 0){
		    	$sanitized_args['numberofvehicles'] = 6;
		    }
		    if($sanitized_args['heading'] == '' || $sanitized_args['heading'] == 0){
		    	$sanitized_args['heading'] = 'Latest Vehicles';
		    }
		    if($sanitized_args['description'] == '' || $sanitized_args['description'] == 0){
		    	$sanitized_args['description'] = '';
		    }
		    if($sanitized_args['typeofvehicles'] == '' || $sanitized_args['typeofvehicles'] == 0){
		    	$sanitized_args['typeofvehicles'] = 1;
		    }
		    if($sanitized_args['jsvehiclemanagerpageid'] == '' || $sanitized_args['jsvehiclemanagerpageid'] == 0){
		    	$sanitized_args['jsvehiclemanagerpageid'] = jsvehiclemanager::getPageid();
		    }
			//return 'abc';
			$vehicles = JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getVehiclesWidgetData($sanitized_args['typeofvehicles'], $sanitized_args['numberofvehicles']);
	    	$mod = 'latestvehicles';
	    	if ($sanitized_args['typeofvehicles'] == 2) {
	    	    $mod = 'featuredvehicles';
	    	}
	    	$layoutName = $mod . uniqid();
			$html = JSVEHICLEMANAGERincluder::getJSModel('widget')->getVehiclesWidgetHTMl($vehicles,$sanitized_args['jsvehiclemanagerpageid'],$sanitized_args['heading'],$sanitized_args['description'],$sanitized_args['number_of_columns'],$layoutName);

		    wp_enqueue_style('jsauto-site', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/css/site.css');
		    if (is_rtl()) {
	            wp_enqueue_style('jsauto-site-rtl', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/css/sitertl.css');
	        }
			return $html;
		}

		// gutenberg vehicles by cities block

		add_action( 'init', 'js_vehicle_manager_vehicles_by_cities_block' );

		function js_vehicle_manager_vehicles_by_cities_block() {
			if(!function_exists("register_block_type")){
				return;
			}
		    wp_register_script(
		        'jsvehiclemanagervehiclesbycitiesblock',
		        JSVEHICLEMANAGER_PLUGIN_URL . 'includes/js/gutenberg/vehiclesbycities.js',
		        array( 'wp-blocks', 'wp-element','wp-editor' )
		    );
		    register_block_type( 'jsvehiclemanager/jsvehiclemanagervehiclesbycitiesblock', array(
		    	'attributes'      => array(
		    	            'heading'    => array(
		    	                'type'      => 'string',
		    	                'default'   => '',
		    	            ),
		    	            'description'    => array(
		    	                'type'      => 'string',
		    	                'default'   => '',
		    	            ),
		    	            'shownumberofvehiclespercity' => array(
		    	                'type'      => 'select',
		    	                'default'   => '',
		    	            ),
		    	            'numberofcities'    => array(
		    	                'type'      => 'string',
		    	                'default'   => '',
		    	            ),
		    	            'number_of_columns'    => array(
		    	                'type'      => 'string',
		    	                'default'   => '',
		    	            )
		    	        ),
		        'render_callback' => 'js_vehicle_manager_vehicles_by_cities_block_widget',
		        'editor_script' => 'jsvehiclemanagervehiclesbycitiesblock',
		    ) );
		}

		function js_vehicle_manager_vehicles_by_cities_block_widget( $attributes, $content ) {
			$defaults = array(
		        'jsvehiclemanagerpageid' => '0',
		        'number_of_columns' => '3',
		        'numberofcities' => '6',
		        'heading' => 'Vehicles By Cities',
		        'description' => '',
		        'shownumberofvehiclespercity' => '1'
		    );
		    // the code below is to avoid default value bug for gutenberg
		    $sanitized_args = shortcode_atts($defaults, $attributes);

		    if($sanitized_args['number_of_columns'] == '' || $sanitized_args['number_of_columns'] == 0){
		    	$sanitized_args['number_of_columns'] = 3;
		    }
		    if($sanitized_args['numberofcities'] == '' || $sanitized_args['numberofcities'] == 0){
		    	$sanitized_args['numberofcities'] = 6;
		    }
		    if($sanitized_args['heading'] == '' || $sanitized_args['heading'] == 0){
		    	$sanitized_args['heading'] = 'Vehicles By Cities';
		    }
		    if($sanitized_args['description'] == '' || $sanitized_args['description'] == 0){
		    	$sanitized_args['description'] = '';
		    }
		    if($sanitized_args['shownumberofvehiclespercity'] == '' || $sanitized_args['shownumberofvehiclespercity'] == 0){
		    	$sanitized_args['shownumberofvehiclespercity'] = 1;
		    }
		    if($sanitized_args['jsvehiclemanagerpageid'] == '' || $sanitized_args['jsvehiclemanagerpageid'] == 0){
		    	$sanitized_args['jsvehiclemanagerpageid'] = jsvehiclemanager::getPageid();
		    }
			$cities = JSVEHICLEMANAGERincluder::getJSModel('city')->getVehiclebyCitiesForWidget($sanitized_args['numberofcities']);
	    	$mod = 'vehiclesbycities';
	    	$layoutName = $mod . uniqid();

	    	//echo '<pre>';print_r($cities);echo '</pre>';exit();
			$html = JSVEHICLEMANAGERincluder::getJSModel('widget')->getVehiclesByCitiesWidgetHTMl($cities,$sanitized_args['jsvehiclemanagerpageid'],$sanitized_args['heading'],$sanitized_args['description'],$sanitized_args['number_of_columns'],$layoutName);

		    wp_enqueue_style('jsauto-site', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/css/site.css');
		    if (is_rtl()) {
	            wp_enqueue_style('jsauto-site-rtl', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/css/sitertl.css');
	        }
			return $html;
		}

		// gutenberg vehicle manager pages

		add_action( 'init' , 'js_vehicle_manager_pages_block' );

		function js_vehicle_manager_pages_block(){
			if(!function_exists("register_block_type")){
				return;
			}
		    wp_register_script(
		        'jsvehiclemanagerpagesblock',
		        JSVEHICLEMANAGER_PLUGIN_URL . 'includes/js/gutenberg/vehiclemanagerpages.js',
		        array( 'wp-blocks', 'wp-element','wp-editor' )
		    );
		    register_block_type( 'jsvehiclemanager/jsvehiclemanagerpagesblock', array(
		    	'attributes'      => array(
		    	            'vehiclemanagerpages'    => array(
		    	                'type'      => 'select',
		    	                'default'   => '',
		    	            )
		    	        ),
		        'render_callback' => 'js_vehicle_manager_pages_block_widget',
		        'editor_script' => 'jsvehiclemanagerpagesblock',
		    ) );
		}

		function js_vehicle_manager_pages_block_widget( $attributes, $content ) {
			$defaults = array(
		        'vehiclemanagerpages' => '1',
		    );
		    // the code below is to avoid default value bug for gutenberg
		    $sanitized_args = shortcode_atts($defaults, $attributes);
			if($sanitized_args['vehiclemanagerpages'] == '' || $sanitized_args['vehiclemanagerpages'] == 0){
		    	$sanitized_args['vehiclemanagerpages'] = '1';
		    }
		    $shortcode = "";
		    switch ($sanitized_args['vehiclemanagerpages']) {
				case 1:
					$shortcode = '[jsvehiclemanager_list_vehicles]';
					break;
				case 2:
					$shortcode = '[jsvehiclemanager_vehicle_search]';
					break;
				case 3:
					$shortcode = '[jsvehiclemanager_add_vehicle]';
					break;
				case 4:
					$shortcode = '[jsvehiclemanager_my_vehicles]';
					break;
				case 5:
					$shortcode = '[jsvehiclemanager_control_panel]';
					break;
				case 6:
					$shortcode = '[jsvehiclemanager_compare_vehicles]';
					break;
				case 7:
					$shortcode = '[jsvehiclemanager_shortlisted_vehicles]';
					break;
				case 8:
					$shortcode = '[jsvehiclemanager_vehicles_by_city]';
					break;
				case 9:
					$shortcode = '[jsvehiclemanager_vehicles_by_type]';
					break;
				case 10:
					$shortcode = '[jsvehiclemanager_vehicles_by_make]';
					break;
				case 11:
					$shortcode = '[jsvehiclemanager_sellers_list]';
					break;
				case 12:
					$shortcode = '[jsvehiclemanager_sellers_by_city]';
					break;
				case 13:
					$shortcode = '[jsvehiclemanager_credits_pack]';
					break;
				case 14:
					$shortcode = '[jsvehiclemanager_credits_rate_list]';
					break;
				case 15:
					$shortcode = '[jsvehiclemanager_purchase_history]';
					break;
				case 16:
					$shortcode = '[jsvehiclemanager_credits_log]';
					break;
				case 17:
					$shortcode = '[jsvehiclemanager_vehicle_alerts]';
					break;
				case 18:
					$shortcode = '[jsvehiclemanager_login]';
					break;
			}

			$output = $shortcode;
			return $output;
		}
?>
