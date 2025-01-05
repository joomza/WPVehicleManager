<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class jsvehiclemanageradmin {

    function __construct() {
        add_action('admin_menu', array($this, 'mainmenu'));
    }

    function mainmenu() {
        if(current_user_can('jsvehiclemanager')){
            add_menu_page(__('Control Panel', 'js-vehicle-manager'), // Page title
                    __('Vehicle Manager', 'js-vehicle-manager'), // menu title
                    'jsvehiclemanager', // capability
                    'jsvehiclemanager', //menu slug
                    array($this, 'showAdminPage'), // function name
                    plugins_url('js-vehicle-manager/includes/images/admin_jsvehiclemanager1.png')
            );
            add_submenu_page('jsvehiclemanager', // parent slug
                    __('Vehicles', 'js-vehicle-manager'), // Page title
                    __('Vehicles', 'js-vehicle-manager'), // menu title
                    'jsvehiclemanager', // capability
                    'jsvm_vehicle', //menu slug
                    array($this, 'showAdminPage') // function name
            );

            add_submenu_page('jsvehiclemanager_hide', // parent slug
                    __('Fuel Types', 'js-vehicle-manager'), // Page title
                    __('Fuel Types', 'js-vehicle-manager'), // menu title
                    'jsvehiclemanager', // capability
                    'jsvm_fueltypes', //menu slug
                    array($this, 'showAdminPage') // function name
            );
            if(in_array('vehiclealert', jsvehiclemanager::$_active_addons)){
                add_submenu_page('jsvehiclemanager_hide', // parent slug
                        __('Vehicle alert', 'js-vehicle-manager'), // Page title
                        __('Vehicle alert', 'js-vehicle-manager'), // menu title
                        'jsvehiclemanager', // capability
                        'jsvm_vehiclealert', //menu slug
                        array($this, 'showAdminPage') // function name
                );
            }else{
                $this->addMissingAddonPage('jsvm_vehiclealert');
            }
            add_submenu_page('jsvehiclemanager_hide', // parent slug
                    __('Conditions', 'js-vehicle-manager'), // Page title
                    __('Conditions', 'js-vehicle-manager'), // menu title
                    'jsvehiclemanager', // capability
                    'jsvm_conditions', //menu slug
                    array($this, 'showAdminPage') // function name
            );
            add_submenu_page('jsvehiclemanager_hide', // parent slug
                    __('Currency', 'js-vehicle-manager'), // Page title
                    __('Currency', 'js-vehicle-manager'), // menu title
                    'jsvehiclemanager', // capability
                    'jsvm_currency', //menu slug
                    array($this, 'showAdminPage') // function name
            );
            add_submenu_page('jsvehiclemanager_hide', // parent slug
                    __('Cylinders', 'js-vehicle-manager'), // Page title
                    __('Cylinders', 'js-vehicle-manager'), // menu title
                    'jsvehiclemanager', // capability
                    'jsvm_cylinders', //menu slug
                    array($this, 'showAdminPage') // function name
            );
            add_submenu_page('jsvehiclemanager_hide', // parent slug
                    __('Model years', 'js-vehicle-manager'), // Page title
                    __('Model years', 'js-vehicle-manager'), // menu title
                    'jsvehiclemanager', // capability
                    'jsvm_modelyears', //menu slug
                    array($this, 'showAdminPage') // function name
            );
            add_submenu_page('jsvehiclemanager_hide', // parent slug
                    __('Transmissions', 'js-vehicle-manager'), // Page title
                    __('Transmissions', 'js-vehicle-manager'), // menu title
                    'jsvehiclemanager', // capability
                    'jsvm_transmissions', //menu slug
                    array($this, 'showAdminPage') // function name
            );
            add_submenu_page('jsvehiclemanager_hide', // parent slug
                    __('Models', 'js-vehicle-manager'), // Page title
                    __('Models', 'js-vehicle-manager'), // menu title
                    'jsvehiclemanager', // capability
                    'jsvm_model', //menu slug
                    array($this, 'showAdminPage') // function name
            );
            add_submenu_page('jsvehiclemanager_hide', // parent slug
                    __('Vehicle types', 'js-vehicle-manager'), // Page title
                    __('Vehicle types', 'js-vehicle-manager'), // menu title
                    'jsvehiclemanager', // capability
                    'jsvm_vehicletype', //menu slug
                    array($this, 'showAdminPage') // function name
            );
            if(in_array('credits', jsvehiclemanager::$_active_addons)){
                add_submenu_page('jsvehiclemanager', // parent slug
                        __('Credits', 'js-vehicle-manager'), // Page title
                        __('Credits', 'js-vehicle-manager'), // menu title
                        'jsvehiclemanager', // capability
                        'jsvm_credits', //menu slug
                        array($this, 'showAdminPage') // function name
                );
                add_submenu_page('jsvehiclemanager_hide', // parent slug
                        __('Credits Log', 'js-vehicle-manager'), // Page title
                        __('Credits Log', 'js-vehicle-manager'), // menu title
                        'jsvehiclemanager', // capability
                        'jsvm_creditslog', //menu slug
                        array($this, 'showAdminPage') // function name
                );
                add_submenu_page('jsvehiclemanager_hide', // parent slug
                        __('Credits Pack', 'js-vehicle-manager'), // Page title
                        __('Credits Pack', 'js-vehicle-manager'), // menu title
                        'jsvehiclemanager', // capability
                        'jsvm_creditspack', //menu slug
                        array($this, 'showAdminPage') // function name
                );
                add_submenu_page('jsvehiclemanager', // parent slug
                        __('Purchase History', 'js-vehicle-manager'), // Page title
                        __('Purchase History', 'js-vehicle-manager'), // menu title
                        'jsvehiclemanager', // capability
                        'jsvm_purchasehistory', //menu slug
                        array($this, 'showAdminPage') // function name
                );
            }else{
                $this->addMissingAddonPage('credits');
                $this->addMissingAddonPage('creditslog');
                $this->addMissingAddonPage('creditspack');
                $this->addMissingAddonPage('purchasehistory');
            }
            add_submenu_page('jsvehiclemanager', // parent slug
                    __('Email templates', 'js-vehicle-manager'), // Page title
                    __('Email templates', 'js-vehicle-manager'), // menu title
                    'jsvehiclemanager', // capability
                    'jsvm_emailtemplate', //menu slug
                    array($this, 'showAdminPage') // function name
            );
            add_submenu_page('jsvehiclemanager_hide', // parent slug
                    __('Email options', 'js-vehicle-manager'), // Page title
                    __('Email options', 'js-vehicle-manager'), // menu title
                    'jsvehiclemanager', // capability
                    'jsvm_emailtemplatestatus', //menu slug
                    array($this, 'showAdminPage') // function name
            );

            add_submenu_page('jsvehiclemanager_hide', // parent slug
                    __('Field ordering Vehicle', 'js-vehicle-manager'), // Page title
                    __('Field ordering Vehicle', 'js-vehicle-manager'), // menu title
                    'jsvehiclemanager', // capability
                    'jsvm_fieldordering', //menu slug
                    array($this, 'showAdminPage') // function name
            );
            add_submenu_page('jsvehiclemanager', // parent slug
                    __('Configurations', 'js-vehicle-manager'), // Page title
                    __('Configurations', 'js-vehicle-manager'), // menu title
                    'jsvehiclemanager', // capability
                    'jsvm_configuration', //menu slug
                    array($this, 'showAdminPage') // function name
            );
            add_submenu_page('jsvehiclemanager', // parent slug
                    __('Makes', 'js-vehicle-manager'), // Page title
                    __('Makes', 'js-vehicle-manager'), // menu title
                    'jsvehiclemanager', // capability
                    'jsvm_make', //menu slug
                    array($this, 'showAdminPage') // function name
            );
            if(in_array('credits', jsvehiclemanager::$_active_addons)){
                add_submenu_page('jsvehiclemanager_hide', // parent slug
                        __('Payment methods Configurations', 'js-vehicle-manager'), // Page title
                        __('Payment methods Configurations', 'js-vehicle-manager'), // menu title
                        'jsvehiclemanager', // capability
                        'jsvm_paymentmethodconfiguration', //menu slug
                        array($this, 'showAdminPage') // function name
                );
            }else{
                $this->addMissingAddonPage('paymentmethodconfiguration');
            }
            add_submenu_page('jsvehiclemanager_hide', // parent slug
                    __('Mileages', 'js-vehicle-manager'), // Page title
                    __('Mileages', 'js-vehicle-manager'), // menu title
                    'jsvehiclemanager', // capability
                    'jsvm_mileages', //menu slug
                    array($this, 'showAdminPage') // function name
            );
            add_submenu_page('jsvehiclemanager_hide', // parent slug
                    __('Countries', 'js-vehicle-manager'), // Page title
                    __('Countries', 'js-vehicle-manager'), // menu title
                    'jsvehiclemanager', // capability
                    'jsvm_country', //menu slug
                    array($this, 'showAdminPage') // function name
            );
            add_submenu_page('jsvehiclemanager_hide', // parent slug
                    __('States', 'js-vehicle-manager'), // Page title
                    __('States', 'js-vehicle-manager'), // menu title
                    'jsvehiclemanager', // capability
                    'jsvm_state', //menu slug
                    array($this, 'showAdminPage') // function name
            );
            add_submenu_page('jsvehiclemanager_hide', // parent slug
                    __('Cities', 'js-vehicle-manager'), // Page title
                    __('Cities', 'js-vehicle-manager'), // menu title
                    'jsvehiclemanager', // capability
                    'jsvm_city', //menu slug
                    array($this, 'showAdminPage') // function name
            );
            add_submenu_page('jsvehiclemanager_hide', // parent slug
                    __('Activity Log', 'js-vehicle-manager'), // Page title
                    __('Activity Log', 'js-vehicle-manager'), // menu title
                    'jsvehiclemanager', // capability
                    'jsvm_activitylog', //menu slug
                    array($this, 'showAdminPage') // function name
            );
            // add_submenu_page('jsvehiclemanager_hide', // parent slug
            //         __('Payment Methods Configuration', 'js-vehicle-manager'), // Page title
            //         __('Payment Methods Configuration', 'js-vehicle-manager'), // menu title
            //         'jsvehiclemanager', // capability
            //         'jsvm_paymentmethodconfiguration', //menu slug
            //         array($this, 'showAdminPage') // function name
            // );
            if(in_array('message', jsvehiclemanager::$_active_addons)){
                add_submenu_page('jsvehiclemanager_hide', // parent slug
                        __('Messages', 'js-vehicle-manager'), // Page title
                        __('Messages', 'js-vehicle-manager'), // menu title
                        'jsvehiclemanager', // capability
                        'jsvm_message', //menu slug
                        array($this, 'showAdminPage') // function name
                );
            }else{
                $this->addMissingAddonPage('message');
            }
            add_submenu_page('jsvehiclemanager_hide', // parent slug
                    __('Users', 'js-vehicle-manager'), // Page title
                    __('Users', 'js-vehicle-manager'), // menu title
                    'jsvehiclemanager', // capability
                    'jsvm_user', //menu slug
                    array($this, 'showAdminPage') // function name
            );
            add_submenu_page('jsvehiclemanager_hide', // parent slug
                    __('System Error', 'js-vehicle-manager'), // Page title
                    __('System Error', 'js-vehicle-manager'), // menu title
                    'jsvehiclemanager', // capability
                    'jsvm_systemerror', //menu slug
                    array($this, 'showAdminPage') // function name
            );
            add_submenu_page('jsvehiclemanager_hide', // parent slug
                    __('Common', 'js-vehicle-manager'), // Page title
                    __('Common', 'js-vehicle-manager'), // menu title
                    'jsvehiclemanager', // capability
                    'jsvm_common', //menu slug
                    array($this, 'showAdminPage') // function name
            );
            add_submenu_page('jsvehiclemanager', // parent slug
                    __('Post Installation', 'js-vehicle-manager'), // menu title
                    __('Post Installation', 'js-vehicle-manager'), // Page title
                    'jsvehiclemanager', // capability
                    'jsvm_postinstallation', //menu slug
                    array($this, 'showAdminPage') // function name
            );

            add_submenu_page('jsvehiclemanager', // parent slug
                    __('Premium Addons', 'js-vehicle-manager'), // menu title
                    __('Premium Addons', 'js-vehicle-manager'), // Page title
                    'jsvehiclemanager', // capability
                    'jsvm_premiumplugin', //menu slug
                    array($this, 'showAdminPage') // function name
            );
            add_submenu_page('jsvehiclemanager_hide', // parent slug
                    __('Ad Expiry', 'js-vehicle-manager'), // menu title
                    __('Ad Expiry', 'js-vehicle-manager'), // Page title
                    'jsvehiclemanager', // capability
                    'jsvm_adexpiry', //menu slug
                    array($this, 'showAdminPage') // function name
            );
            if(in_array('reports', jsvehiclemanager::$_active_addons)){
                add_submenu_page('jsvehiclemanager', // parent slug
                        __('Reports', 'js-vehicle-manager'), // Page title
                        __('Reports', 'js-vehicle-manager'), // menu title
                        'jsvehiclemanager', // capability
                        'jsvm_reports', //menu slug
                        array($this, 'showAdminPage') // function name
                );
            }else{
                $this->addMissingAddonPage('reports');
            }

            if(in_array('makeanoffer', jsvehiclemanager::$_active_addons)){
                add_submenu_page('jsvehiclemanager_hide', // parent slug
                        __('Make an Offer', 'js-vehicle-manager'), // Page title
                        __('Make an Offer', 'js-vehicle-manager'), // menu title
                        'jsvehiclemanager', // capability
                        'jsvm_makeanoffer', //menu slug
                        array($this, 'showAdminPage') // function name
                );
            }else{
                $this->addMissingAddonPage('makeanoffer');
            }
            if(in_array('buyercontacttoseller', jsvehiclemanager::$_active_addons)){
                add_submenu_page('jsvehiclemanager_hide', // parent slug
                        __('Seller Messages', 'js-vehicle-manager'), // Page title
                        __('Seller Messages', 'js-vehicle-manager'), // menu title
                        'jsvehiclemanager', // capability
                        'jsvm_buyercontacttoseller', //menu slug
                        array($this, 'showAdminPage') // function name
                );
            }else{
                $this->addMissingAddonPage('buyercontacttoseller');
            }
            if(in_array('testdrive', jsvehiclemanager::$_active_addons)){
                add_submenu_page('jsvehiclemanager_hide', // parent slug
                        __('Test Drive', 'js-vehicle-manager'), // Page title
                        __('Test Drive', 'js-vehicle-manager'), // menu title
                        'jsvehiclemanager', // capability
                        'jsvm_testdrive', //menu slug
                        array($this, 'showAdminPage') // function name
                );
            }else{
                $this->addMissingAddonPage('testdrive');
            }
            if(in_array('export', jsvehiclemanager::$_active_addons)){
                add_submenu_page('jsvehiclemanager_hide', // parent slug
                        __('Export', 'js-vehicle-manager'), // Page title
                        __('Export', 'js-vehicle-manager'), // menu title
                        'jsvehiclemanager', // capability
                        'jsvm_export', //menu slug
                        array($this, 'showAdminPage') // function name
                );
            }else{
                $this->addMissingAddonPage('export');
            }
            if(in_array('themes', jsvehiclemanager::$_active_addons)){
                add_submenu_page('jsvehiclemanager_hide', // parent slug
                        __('Themes', 'js-vehicle-manager'), // Page title
                        __('Themes', 'js-vehicle-manager'), // menu title
                        'jsvehiclemanager', // capability
                        'jsvm_themes', //menu slug
                        array($this, 'showAdminPage') // function name
                );
            }else{
                $this->addMissingAddonPage('themes');
            }

            if(in_array('addressdata', jsvehiclemanager::$_active_addons)){
                add_submenu_page('jsvehiclemanager_hide', // parent slug
                        __('Load Address Data', 'js-vehicle-manager'), // Page title
                        __('Load Address Data', 'js-vehicle-manager'), // menu title
                        'jsvehiclemanager', // capability
                        'jsvm_addressdata', //menu slug
                        array($this, 'showAdminPage') // function name
                );
            }else{
                $this->addMissingAddonPage('jsvm_addressdata');
            }

        }
    }

    function showAdminPage() {
        jsvehiclemanager::addStyleSheets();
        $page = JSVEHICLEMANAGERrequest::getVar('page');
        $page = str_replace('jsvm_', '', $page);
        JSVEHICLEMANAGERincluder::include_file($page);
    }

    function addMissingAddonPage($module_name){
        add_submenu_page('jsvehiclemanager_hide', // parent slug
                __('Premium Addon', 'js-vehicle-manager'), // Page title
                __('Premium Addon', 'js-vehicle-manager'), // menu title
                'jsvehiclemanager', // capability
                $module_name, //menu slug
                array($this, 'showMissingAddonPage') // function name
        );
    }

    function showMissingAddonPage() {
        JSVEHICLEMANAGERincluder::include_file('admin_missingaddon','premiumplugin');
    }
}

$jsvehiclemanagerAdmin = new jsvehiclemanageradmin();
?>
