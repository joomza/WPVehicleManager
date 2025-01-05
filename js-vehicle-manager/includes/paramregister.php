<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

function jsvm_generate_rewrite_rules(&$rules, $rule){
    $_new_rules = array();
    foreach($rules AS $key => $value){
        if(strstr($key, $rule)){
            $newkey = substr($key,0,strlen($key) - 3);
            $matcharray = explode('$matches', $value);
            $countmatch = COUNT($matcharray);
            //on all pages
            $changename = false;
            if(file_exists(WP_PLUGIN_DIR.'/js-jobs/js-jobs.php')){
                $changename = true;
            }
            if(file_exists(WP_PLUGIN_DIR.'/js-support-ticket/js-support-ticket.php')){
                $changename = true;
            }
            $my_profile = ($changename === true) ? 'vehicle-my-profile' : 'my-profile';
            $edit_profile = ($changename === true) ? 'vehicle-edit-profile' : 'edit-profile';
            $purchase_history = ($changename === true) ? 'vehicle-purchase-history' : 'purchase-history';
            $registration = ($changename === true) ? 'vehicle-registration' : 'registration';
            $login = ($changename === true) ? 'vehicle-login' : 'login';
            $credit_logs = ($changename === true) ? 'vehicle-credit-logs' : 'credit-logs';
            $stats = ($changename === true) ? 'vehicle-stats' : 'stats';
            $packages = ($changename === true) ? 'vehicle-packages' : 'packages';
            $_key = $newkey . '/(vehicle-search|vehicle-by-cities|seller-by-cities|vehicle-by-conditions|vehicle-by-types|vehicle-detail|vehicle-by-makes|shortlisted-vehicles|vehicle-alerts|pricing|'.$credit_logs.'|'.$packages.'|'.$edit_profile.'|'.$my_profile.'|sellers|seller|'.$purchase_history.'|'.$registration.'|'.$login.'|'.$stats.'|compare|add-vehicle|my-vehicles|print-vehicle|vehicle-pdf|vehicles|vehicle|car-manager-lost-password|car-manager-reset-new-password)(/[^/]*)?(/[^/]*)?(/[^/]*)?/?$';
            $newvalue = $value . '&jsvmlayout=$matches['.$countmatch.']&jsvm1=$matches['.($countmatch + 1).']&jsvm2=$matches['.($countmatch + 2).']&jsvm3=$matches['.($countmatch + 3).']';
            $_new_rules[$_key] = $newvalue;
        }
    }
    return $_new_rules;
}

function jsvm_post_rewrite_rules_array($rules){
    $newrules = array();
    $newrules = jsvm_generate_rewrite_rules($rules, '([^/]+)(?:/([0-9]+))?/?$');
    $newrules += jsvm_generate_rewrite_rules($rules, '([^/]+)(/[0-9]+)?/?$');
    $newrules += jsvm_generate_rewrite_rules($rules, '([0-9]+)(?:/([0-9]+))?/?$');
    $newrules += jsvm_generate_rewrite_rules($rules, '([0-9]+)(/[0-9]+)?/?$');
    return $newrules + $rules;
}
add_filter('post_rewrite_rules', 'jsvm_post_rewrite_rules_array');

function jsvm_page_rewrite_rules_array($rules){
    $newrules = array();
    $newrules = jsvm_generate_rewrite_rules($rules, '(.?.+?)(?:/([0-9]+))?/?$');
    $newrules += jsvm_generate_rewrite_rules($rules, '(.?.+?)(/[0-9]+)?/?$');
    return $newrules + $rules;
}
add_filter('page_rewrite_rules', 'jsvm_page_rewrite_rules_array');

function jsvm_root_rewrite_rules( $rules ) {
        // // Hooks params
        // $rules = array();
        // Homepage params
        $pageid = get_option('page_on_front');
        $changename = false;
        if(file_exists(WP_PLUGIN_DIR.'/js-jobs/js-jobs.php')){
            $changename = true;
        }
        if(file_exists(WP_PLUGIN_DIR.'/js-vehicle-manager/js-vehicle-manager.php')){
            $changename = true;
        }
        $my_profile = ($changename === true) ? 'vm-vehicle-my-profile' : 'vm-my-profile';
        $edit_profile = ($changename === true) ? 'vm-vehicle-edit-profile' : 'vm-edit-profile';
        $purchase_history = ($changename === true) ? 'vm-vehicle-purchase-history' : 'vm-purchase-history';
        $registration = ($changename === true) ? 'vm-vehicle-registration' : 'vm-registration';
        $login = ($changename === true) ? 'vm-vehicle-login' : 'vm-login';
        $credit_logs = ($changename === true) ? 'vm-vehicle-credit-logs' : 'vm-credit-logs';
        $stats = ($changename === true) ? 'vm-vehicle-stats' : 'vm-stats';
        $packages = ($changename === true) ? 'vm-vehicle-packages' : 'vm-packages';
        $rules['('.$edit_profile.'|vm-vehicle-by-cities|vm-seller-by-cities|vm-vehicle-search|vm-vehicle-by-conditions|vm-vehicle-detail|vm-vehicle-by-types|vm-vehicle-by-makes|vm-shortlisted-vehicles|vm-vehicle-alerts|vm-pricing|'.$credit_logs.'|'.$packages.'|'.$my_profile.'|vm-sellers|vm-seller|'.$purchase_history.'|'.$registration.'|'.$login.'|'.$stats.'|vm-compare|vm-add-vehicle|vm-my-vehicles|vm-print-vehicle|vm-vehicle-pdf|vm-vehicles|vm-vehicle|vm-car-manager-lost-password|vm-car-manager-reset-new-password)(/[^/]*)?(/[^/]*)?(/[^/]*)?/?$'] = 'index.php?page_id='.$pageid.'&jsvmlayout=$matches[1]&jsvm1=$matches[2]&jsvm2=$matches[3]&jsvm3=$matches[4]';
        return $rules;
}
add_filter( 'root_rewrite_rules', 'jsvm_root_rewrite_rules' );

function jsvm_query_var( $qvars ) {
    $qvars[] = 'jsvmlayout';
    $qvars[] = 'jsvm1';
    $qvars[] = 'jsvm2';
    $qvars[] = 'jsvm3';
    return $qvars;
}
add_filter( 'query_vars', 'jsvm_query_var' , 10, 1 );

function jsvm_parse_request($q) {
    //  echo '<pre style="color:#000;">';print_r($q->query_vars);echo '</pre>';
    // // exit;
    if(isset($q->query_vars['jsvmlayout']) && !empty($q->query_vars['jsvmlayout'])){
        $layout = $q->query_vars['jsvmlayout'];
        if(substr($layout, 0, 3) == 'vm-'){
            $layout = substr($layout,3);
        }
        switch ($layout) {
            case 'vehicle-search':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'vehicle';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'vehiclesearch';
            break;
            case 'vehicle-by-cities':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'city';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'vehiclesbycity';
            break;
            case 'seller-by-cities':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'user';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'sellersbycity';
            break;
            case 'vehicle-by-types':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'vehicletype';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'vehiclesbytype';
            break;
            case 'vehicle-by-makes':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'make';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'vehiclesbymake';
            break;
            case 'vehicles':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'vehicle';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'vehicles';
                if(!empty($q->query_vars['jsvm1'])){
                    jsvehiclemanager::$_data['sanitized_args']['jsvehiclemanagerid'] = str_replace('/', '',$q->query_vars['jsvm1']);
                }
            break;
            case 'vehicle-detail':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'vehicle';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'vehicledetail';
                jsvehiclemanager::$_data['sanitized_args']['jsvehiclemanagerid'] = str_replace('/', '',$q->query_vars['jsvm1']);
            break;
            case 'shortlisted-vehicles':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'shortlist';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'shortlistvehicles';
            break;
            case 'vehicle-alerts':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'vehiclealert';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'vehiclealerts';
            break;
            case 'pricing':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'credits';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'ratelist';
            break;
            case 'vehicle-credit-logs':
            case 'credit-logs':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'creditslog';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'creditslog';
            break;
            case 'vehicle-packages':
            case 'packages':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'creditspack';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'creditspack';
            break;
            case 'vehicle-edit-profile':
            case 'edit-profile':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'user';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'profile';
            break;
            case 'vehicle-my-profile':
            case 'my-profile':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'user';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'dashboard';
            break;
            case 'sellers':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'user';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'sellerlist';
                if(!empty($q->query_vars['jsvm1'])){
                    jsvehiclemanager::$_data['sanitized_args']['cityid'] = str_replace('/', '',$q->query_vars['jsvm1']);
                }
            break;
            case 'seller':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'user';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'viewsellerinfo';
                jsvehiclemanager::$_data['sanitized_args']['jsvehiclemanagerid'] = str_replace('/', '',$q->query_vars['jsvm1']);
            break;
            case 'stats':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'user';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'stats';
            break;
            case 'vehicle-purchase-history':
            case 'purchase-history':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'purchasehistory';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'purchasehistory';
            break;
            case 'vehicle-registration':
            case 'registration':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'user';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'userregister';
            break;
            case 'vehicle-login':
            case 'login':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'jsvehiclemanager';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'login';
            break;
            case 'compare':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'comparevehicle';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'comparevehicles';
            break;
            case 'add-vehicle':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'vehicle';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'formvehicle';
                if(!empty($q->query_vars['jsvm1'])){
                    jsvehiclemanager::$_data['sanitized_args']['jsvehiclemanagerid'] = str_replace('/', '',$q->query_vars['jsvm1']);
                }
            break;
            case 'my-vehicles':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'vehicle';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'myvehicles';
            break;
            case 'vehicle-by-conditions':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'conditions';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'vehiclesbycondition';
            break;
            case 'print-vehicle':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'print';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'printvehicle';
                jsvehiclemanager::$_data['sanitized_args']['jsvehiclemanagerid'] = str_replace('/', '',$q->query_vars['jsvm1']);
            break;
            case 'vehicle-pdf':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'pdf';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'pdf';
                jsvehiclemanager::$_data['sanitized_args']['jsvehiclemanagerid'] = str_replace('/', '',$q->query_vars['jsvm1']);
            break;
            case 'car-manager-lost-password':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'jsvehiclemanager';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'passwordlostform';
                jsvehiclemanager::$_data['sanitized_args']['jsvehiclemanagerid'] = str_replace('/', '',$q->query_vars['jsvm1']);
            break;
            case 'car-manager-reset-new-password':
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'jsvehiclemanager';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'resetnewpasswordform';
                jsvehiclemanager::$_data['sanitized_args']['jsvehiclemanagerid'] = str_replace('/', '',$q->query_vars['jsvm1']);
            break;
            default:
                jsvehiclemanager::$_data['sanitized_args']['jsvmme'] = 'jsvehiclemanager';
                jsvehiclemanager::$_data['sanitized_args']['jsvmlt'] = 'controlpanel';
            break;
        }
    }
}
add_action('parse_request', 'jsvm_parse_request');

function jsvm_redirect_canonical($redirect_url, $requested_url) {
    global $wp_rewrite;
    if(is_home() || is_front_page()){
        $array = array('/vm-vehicle-by-cities','/vm-seller-by-cities','/vm-vehicle-by-types','/vm-vehicle-by-makes','/vm-vehicles','/vm-vehicle','/vm-shortlisted-vehicles','/vm-vehicle-alerts','/vm-pricing','/vm-credit-logs','/vm-vehicle-credit-logs','/vm-packages','/vm-vehicle-packages'
            ,'/vm-edit-profile','/vm-vehicle-edit-profile','/vm-my-profile','/vm-vehicle-my-profile','/vm-sellers','/vm-seller','/vm-purchase-history','/vm-vehicle-purchase-history','/vm-registration','/vm-vehicle-registration','/vm-login','/vm-vehicle-login','/vm-compare','/vm-add-vehicle','/vm-my-vehicles','/vm-print-vehicle','/vm-vehicle-pdf','/vm-car-manager-lost-password','/car-manager-reset-new-password');
        $ret = false;
        foreach($array AS $layout){
            if(strstr($requested_url, $layout)){
                $ret = true;
                break;
            }
        }
        if($ret == true){
            return $requested_url;
        }
    }
      return $redirect_url;
}
add_filter('redirect_canonical', 'jsvm_redirect_canonical', 11, 2);

?>
