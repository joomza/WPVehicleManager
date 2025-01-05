<?php
if (!defined('ABSPATH')) die('Restricted Access');
$c = JSVEHICLEMANAGERrequest::getVar('page',null,'jsvehiclemanager');
$layout = JSVEHICLEMANAGERrequest::getVar('jsvmlt');
$ff = JSVEHICLEMANAGERrequest::getVar('ff');
?>
<script>
  jQuery( function() {
  jQuery( "#accordion" ).accordion({
        collapsible: true, active: false, heightStyle: "content"

    });
  } );
  </script>
<div id="jsvehiclemanageradmin-logo">
    <a href="admin.php?page=jsvehiclemanager" class="jsvehiclemanageradmin-anchor">
        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/left-icons/logo.png'; ?>"/>
    </a>
    <img id="jsvehiclemanageradmin-menu-toggle" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/left-icons/menu.png'; ?>" />
</div>
<ul class="jsvehiclemanageradmin-sidebar-menu tree" data-widget="tree" id="accordion" role="tablist">
    <li class="treeview  <?php if($c == 'jsvehiclemanager' && $layout != 'themes' || $c == 'makeanoffer' || $c == 'tellafriend' || $c == 'buyercontacttoseller') echo 'jsvm_lastshown'; ?>">
        <a href="admin.php?page=jsvehiclemanager" title="<?php echo __('dashboard' , 'js-vehicle-manager'); ?>">
             <img class="jsvm_menu-icon" alt="<?php echo __('dashboard' , 'js-vehicle-manager'); ?>" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/left-icons/admin.png'; ?>" />
            <span class="jsvehiclemanageradmin-text">
                <?php echo __('Dashboard' , 'js-vehicle-manager'); ?>
            </span>
        </a>
        <ul class="jsvehiclemanageradmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'jsvehiclemanager' && $layout != 'themes' || $c == 'makeanoffer' || $c == 'tellafriend' || $c == 'buyercontacttoseller') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvehiclemanager" title="<?php echo __('dashboard', 'js-vehicle-manager'); ?>">
                    <?php echo __('Dashboard', 'js-vehicle-manager'); ?>
                </a>
            </li>

            <li class="<?php if($c == 'jsvehiclemanager' && $layout != 'themes' || $c == 'makeanoffer' || $c == 'tellafriend' || $c == 'buyercontacttoseller') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvehiclemanager&jsvmlt=information" title="<?php echo __('information','js-vehicle-manager'); ?>">

                    <?php echo __('Information','js-vehicle-manager'); ?>

                </a>
            </li>
            <li class="<?php if($c == 'jsvehiclemanager' && $layout != 'themes' || $c == 'makeanoffer' || $c == 'tellafriend' || $c == 'buyercontacttoseller') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_activitylog&jsvmlt=activitylogs" title="<?php echo __('Activity Logs' , 'js-vehicle-manager'); ?>">
                    <?php echo __('Activity Logs' , 'js-vehicle-manager'); ?>
                </a>
            </li>
             <li class="<?php if($c == 'jsvehiclemanager' && $layout != 'themes' || $c == 'makeanoffer' || $c == 'tellafriend' || $c == 'buyercontacttoseller') echo 'jsvm_lastshown'; ?>">
                <?php do_action('jsvm_addons_admin_sidemenu_links_for_makeanoffer'); ?>

            </li>
            <li class="<?php if($c == 'jsvehiclemanager' && $layout != 'themes' || $c == 'makeanoffer' || $c == 'tellafriend' || $c == 'buyercontacttoseller') echo 'jsvm_lastshown'; ?>">
               <?php do_action('jsvm_addons_admin_sidemenu_links_for_testdrive'); ?>

            </li>
            <li class="<?php if($c == 'jsvehiclemanager' && $layout != 'themes' || $c == 'makeanoffer' || $c == 'tellafriend' || $c == 'buyercontacttoseller') echo 'jsvm_lastshown'; ?>">
                 <?php do_action('jsvm_addons_admin_sidemenu_links_for_contact'); // For buyer contact with seller ?>
            </li>
        </ul>
    </li>
    <li class="treeview <?php if($c == 'jsvm_vehicle' || ($c == 'jsvm_fieldordering' && $ff == 1) || $c == 'jsvm_vehiclealert') echo 'jsvm_lastshown'; ?>">
        <a href="admin.php?page=jsvm_vehicle" title="<?php echo __('vehicles' , 'js-vehicle-manager'); ?>">
            <img class="jsvm_menu-icon" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/left-icons/vehicles.png'; ?>"/>
             <span class="jsvehiclemanageradmin-text">
                <?php echo __('Vehicles' , 'js-vehicle-manager'); ?>

            </span>
        </a>
        <ul class="jsvehiclemanageradmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'jsvm_vehicle' || ($c == 'jsvm_fieldordering' && $ff == 1) || $c == 'jsvm_vehiclealert') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_vehicle" title="<?php echo __('vehicles', 'js-vehicle-manager'); ?>">
                     <?php echo __('Vehicles', 'js-vehicle-manager'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'jsvm_vehicle' || ($c == 'jsvm_fieldordering' && $ff == 1) || $c == 'jsvm_vehiclealert') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_vehicle&jsvmlt=vehiclequeue" title="<?php echo __('approval queue' , 'js-vehicle-manager'); ?>">
                      <?php echo __('Approval Queue' , 'js-vehicle-manager'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'jsvm_vehicle' || ($c == 'jsvm_fieldordering' && $ff == 1) || $c == 'jsvm_vehiclealert') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_fieldordering&ff=1" title="<?php echo __('Fields ordering' , 'js-vehicle-manager'); ?>">
                        <?php echo __('Fields ordering' , 'js-vehicle-manager'); ?>
                </a>
             </li>
             <li class="<?php if($c == 'jsvm_vehicle' || ($c == 'jsvm_fieldordering' && $ff == 1) || $c == 'jsvm_vehiclealert') echo 'jsvm_lastshown'; ?>">
                <a class="jsvm_js-child" href="admin.php?page=jsvm_fieldordering&jsvmlt=searchfieldsordering&ff=1" <?php echo __('search ordering' , 'js-vehicle-manager'); ?>>
                    <?php echo __('Search ordering' , 'js-vehicle-manager'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'jsvm_vehicle' || ($c == 'jsvm_fieldordering' && $ff == 1) || $c == 'jsvm_vehiclealert') echo 'jsvm_lastshown'; ?>">
                <?php do_action('jsvm_addons_admin_sidemenu_links_for_vehiclealert'); ?>
            </li>
        </ul>
    </li>
    <li class="treeview <?php if($c == 'config' || $layout == 'themes') echo 'jsvm_lastshown'; ?>">
        <a href="admin.php?page=jsvm_configuration" title="<?php echo __('configuration' , 'js-vehicle-manager'); ?>">
             <img class="jsvm_menu-icon" alt="<?php echo __('configuration' , 'js-vehicle-manager'); ?>" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/left-icons/configuration.png'; ?>" />
            <span class="jsvehiclemanageradmin-text">
                <?php echo __('Configuration' , 'js-vehicle-manager'); ?>
            </span>
        </a>
        <ul class="jsvehiclemanageradmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'config' || $layout == 'themes') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_configuration" title="<?php echo __('configuration', 'js-vehicle-manager'); ?>">
                    <?php echo __('Configuration', 'js-vehicle-manager'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'config' || $layout == 'themes') echo 'jsvm_lastshown'; ?>">
                <?php do_action('jsvm_addons_admin_sidemenu_links_for_theme'); ?>
            </li>
            <li class="<?php if($c == 'config' || $layout == 'themes') echo 'jsvm_lastshown'; ?>">
                <a class="jsvm_js-child" href="admin.php?page=jsvm_configuration&jsvmlt=cronjob">
                        <?php echo __('Cron Job' , 'js-vehicle-manager'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'config' || $layout == 'themes') echo 'jsvm_lastshown'; ?>">
                <?php do_action('jsvm_addons_admin_sidemenu_links_for_credit' , '' , 1); ?>
            </li>

        </ul>
    </li>
    <li class="treeview <?php if($c == 'jsvm_make') echo 'jsvm_lastshown'; ?>">
        <a href="admin.php?page=jsvm_make" title="<?php echo __('Makes By Models' , 'js-vehicle-manager'); ?>">
             <img class="jsvm_menu-icon" alt="<?php echo __('makes by models' , 'js-vehicle-manager'); ?>" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/left-icons/by-make.png'; ?>" />
            <span class="jsvehiclemanageradmin-text">
                <?php echo __('Makes By Models' , 'js-vehicle-manager'); ?>
            </span>
        </a>
        <ul class="jsvehiclemanageradmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'jsvm_make') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_make" title="<?php echo __('makes', 'js-vehicle-manager'); ?>">
                    <?php echo __('Makes', 'js-vehicle-manager'); ?>
                </a>
            </li>
        </ul>
    </li>
    <li class="treeview <?php if($c == 'jsvm_user' || ($c == 'jsvm_fieldordering' && $ff == 2)) echo 'jsvm_lastshown'; ?>">
        <a href="admin.php?page=jsvm_user" title="<?php echo __('user' , 'js-vehicle-manager'); ?>">
            <img class="jsvm_menu-icon" alt="<?php echo __('user' , 'js-vehicle-manager'); ?>" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/left-icons/seller.png'; ?>" />
            <span class="jsvehiclemanageradmin-text">
                <?php echo __('User' , 'js-vehicle-manager'); ?>
            </span>
        </a>
        <ul class="jsvehiclemanageradmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'jsvm_user' || ($c == 'jsvm_fieldordering' && $ff == 2)) echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_user" title="<?php echo __('user', 'js-vehicle-manager'); ?>">
                    <?php echo __('User', 'js-vehicle-manager'); ?>
                </a>
            </li>
             <li class="<?php if($c == 'jsvm_user' || ($c == 'jsvm_fieldordering' && $ff == 2)) echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_fieldordering&ff=2" title="<?php echo __('Fields ordering', 'js-vehicle-manager'); ?>">
                    <?php echo __('Fields ordering', 'js-vehicle-manager'); ?>
                </a>
            </li>
        </ul>
    </li>
     <?php do_action('jsvm_addons_admin_sidemenu_links_for_credit' , $c , 2); ?>
    <!-- aaa -->
    <li class="treeview <?php if($c == 'jsvm_vehicletype') echo 'jsvm_lastshown'; ?>">
        <a href="admin.php?page=jsvm_vehicletype" title="<?php echo __('Vehicle Types' , 'js-vehicle-manager'); ?>">
             <img class="jsvm_menu-icon" alt="<?php echo __('Vehicle Types' , 'js-vehicle-manager'); ?>" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/left-icons/vehicle-types.png'; ?>" />
            <span class="jsvehiclemanageradmin-text">
                <?php echo __('Vehicle Types' , 'js-vehicle-manager'); ?>
            </span>
        </a>
        <ul class="jsvehiclemanageradmin-sidebar-submenu treeview-menu">

            <li class="<?php if($c == 'jsvm_vehicletype') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_vehicletype" title="<?php echo __('Vehicle Types', 'js-vehicle-manager'); ?>">
                    <?php echo __('Vehicle Types' , 'js-vehicle-manager'); ?>
                </a>
            </li>
        </ul>
    </li>

    <li class="treeview <?php if($c == 'jsvm_premiumplugin') echo 'jsvm_lastshown'; ?>">
        <a href="admin.php?page=jsvm_premiumplugin" title="<?php echo __('Premium Addons' , 'js-vehicle-manager'); ?>">
             <img class="jsvm_menu-icon" alt="<?php echo __('Premium Addons' , 'js-vehicle-manager'); ?>" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/left-icons/premium_addons.png'; ?>" />
            <span class="jsvehiclemanageradmin-text">
                <?php echo __('Premium Addons' , 'js-vehicle-manager'); ?>
            </span>
        </a>
        <ul class="jsvehiclemanageradmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'jsvm_premiumplugin') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_premiumplugin" title="<?php echo __('Premium Addons' , 'js-vehicle-manager'); ?>">
                    <?php echo __('Premium Addons' , 'js-vehicle-manager'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'jsvm_premiumplugin') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_premiumplugin&jsvmlt=addonfeatures" title="<?php echo __('Addons list' , 'js-vehicle-manager'); ?>">
                    <?php echo __('Addons list' , 'js-vehicle-manager'); ?>
                </a>
            </li>
        </ul>
    </li>

    <li class="treeview <?php if(($c == 'jsvehiclemanager_forms' || ($c == 'jsvehiclemanager_fieldordering' && $ff == 1)) ) echo 'active'; ?>">
        <a href="admin.php?page=jsvm_fueltypes" title="<?php echo __('Fuel Types' , 'js-vehicle-manager'); ?>">
             <img class="jsvm_menu-icon" alt="<?php echo __('Fuel Types' , 'js-vehicle-manager'); ?>" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/left-icons/fuel-type.png'; ?>" />
            <span class="jsvehiclemanageradmin-text">
                <?php echo __('Fuel Types' , 'js-vehicle-manager'); ?>
            </span>
        </a>
        <ul class="jsvehiclemanageradmin-sidebar-submenu treeview-menu" style="height: auto;">

            <li class="<?php if($c == 'jsvm_fueltypes') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_fueltypes" title="<?php echo __('Fuel Types' , 'js-vehicle-manager'); ?>">
                    <?php echo __('Fuel Types' , 'js-vehicle-manager'); ?>
                </a>
            </li>
        </ul>
    </li>
    <li class="treeview <?php if($c == 'jsvm_mileages') echo 'jsvm_lastshown'; ?>">
        <a href="admin.php?page=jsvm_mileages" title="<?php echo __('Mileages' , 'js-vehicle-manager'); ?>">
             <img class="jsvm_menu-icon" alt="<?php echo __('Mileages' , 'js-vehicle-manager'); ?>" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/left-icons/mileages.png'; ?>" />
            <span class="jsvehiclemanageradmin-text">
                <?php echo __('Mileages' , 'js-vehicle-manager'); ?>
            </span>
        </a>
        <ul class="jsvehiclemanageradmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'jsvm_mileages') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_mileages" title="<?php echo __('Mileages' , 'js-vehicle-manager'); ?>">
                    <?php echo __('Mileages' , 'js-vehicle-manager'); ?>
                </a>
            </li>
        </ul>
    </li>
    <li class="treeview <?php if($c == 'jsvm_modelyears') echo 'jsvm_lastshown'; ?>">
        <a href="admin.php?page=jsvm_modelyears" title="<?php echo __('Model years' , 'js-vehicle-manager'); ?>">
             <img class="jsvm_menu-icon" alt="<?php echo __('Model years' , 'js-vehicle-manager'); ?>" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/left-icons/model-year.png'; ?>" />
            <span class="jsvehiclemanageradmin-text">
                <?php echo __('Model years' , 'js-vehicle-manager'); ?>
            </span>
        </a>
        <ul class="jsvehiclemanageradmin-sidebar-submenu treeview-menu">

            <li class="<?php if($c == 'jsvm_modelyears') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_modelyears" title="  <?php echo __('Model years' , 'js-vehicle-manager'); ?>">
                    <?php echo __('Model years' , 'js-vehicle-manager'); ?>
                </a>
            </li>
        </ul>
    </li>

    <li class="treeview <?php if($c == 'jsvm_transmissions') echo 'jsvm_lastshown'; ?>">
        <a href="admin.php?page=jsvm_transmissions" title="<?php echo __('Transmissions' , 'js-vehicle-manager'); ?>">
             <img class="jsvm_menu-icon" alt="<?php echo __('Transmissions' , 'js-vehicle-manager'); ?>" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/left-icons/transmissions.png'; ?>" />
            <span class="jsvehiclemanageradmin-text">
                <?php echo __('Transmissions' , 'js-vehicle-manager'); ?>
            </span>
        </a>
        <ul class="jsvehiclemanageradmin-sidebar-submenu treeview-menu">

            <li class="<?php if($c == 'jsvm_transmissions') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_transmissions" title="<?php echo __('Transmissions' , 'js-vehicle-manager'); ?>">
                    <?php echo __('Transmissions' , 'js-vehicle-manager'); ?>
                </a>
            </li>
        </ul>
    </li>

    <li class="treeview <?php if($c == 'jsvm_cylinders') echo 'jsvm_lastshown'; ?>">
        <a href="admin.php?page=jsvm_cylinders" title="<?php echo __('Cylinders' , 'js-vehicle-manager'); ?>">
             <img class="jsvm_menu-icon" alt="<?php echo __('Cylinders' , 'js-vehicle-manager'); ?>" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/left-icons/cylinder.png'; ?>" />
            <span class="jsvehiclemanageradmin-text">
                <?php echo __('Cylinders' , 'js-vehicle-manager'); ?>
            </span>
        </a>
        <ul class="jsvehiclemanageradmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'jsvm_cylinders') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_cylinders" title="<?php echo __('Cylinders' , 'js-vehicle-manager'); ?>">
                   <?php echo __('Cylinders' , 'js-vehicle-manager'); ?>
                </a>
            </li>
        </ul>
    </li>
    <li class="treeview <?php if($c == 'jsvm_conditions') echo 'jsvm_lastshown'; ?>">
        <a href="admin.php?page=jsvm_conditions" title="<?php echo __('Conditions' , 'js-vehicle-manager'); ?>">
             <img class="jsvm_menu-icon" alt="<?php echo __('Conditions' , 'js-vehicle-manager'); ?>" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/left-icons/condition.png'; ?>" />
            <span class="jsvehiclemanageradmin-text">
                <?php echo __('Conditions' , 'js-vehicle-manager'); ?>
            </span>
        </a>
        <ul class="jsvehiclemanageradmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'jsvm_conditions') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_conditions" title="<?php echo __('Conditions' , 'js-vehicle-manager'); ?>">
                   <?php echo __('Conditions' , 'js-vehicle-manager'); ?>
                </a>
            </li>
        </ul>
    </li>
    <li class="treeview <?php if($c == 'jsvm_currency') echo 'jsvm_lastshown'; ?>">
        <a href="admin.php?page=jsvm_currency" title="<?php echo __('Currencies' , 'js-vehicle-manager'); ?>">
             <img class="jsvm_menu-icon" alt="<?php echo __('Currencies' , 'js-vehicle-manager'); ?>" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/left-icons/currencies.png'; ?>" />
            <span class="jsvehiclemanageradmin-text">
                <?php echo __('Currencies' , 'js-vehicle-manager'); ?>
            </span>
        </a>
        <ul class="jsvehiclemanageradmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'jsvm_currency') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_currency" title="<?php echo __('Currencies' , 'js-vehicle-manager'); ?>">
                   <?php echo __('Currencies' , 'js-vehicle-manager'); ?>
                </a>
            </li>
        </ul>
    </li>
     <?php do_action('jsvm_addons_admin_sidemenu_links_for_reports',$c); ?>
    <?php do_action('jsvm_addons_admin_sidemenu_links_for_export',$c); ?>
    <li class="treeview <?php if($c == 'jsvm_emailtemplate') echo 'jsvm_lastshown'; ?>">
        <a href="admin.php?page=jsvm_emailtemplate" title="<?php echo __('Email Templates','js-vehicle-manager'); ?>">
             <img class="jsvm_menu-icon" alt="<?php echo __('Email Templates','js-vehicle-manager'); ?>" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/left-icons/email_tempelates.png'; ?>" />
            <span class="jsvehiclemanageradmin-text">
                <?php echo __('Email Templates','js-vehicle-manager'); ?>
            </span>
        </a>
        <ul class="jsvehiclemanageradmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'jsvm_emailtemplate') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_emailtemplate" title="<?php echo __('Email Templates','js-vehicle-manager'); ?>">
                   <?php echo __('Email Templates','js-vehicle-manager'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'jsvm_emailtemplate') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_emailtemplatestatus" title="<?php echo __('Options','js-vehicle-manager'); ?>">
                   <?php echo __('Options','js-vehicle-manager'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'jsvm_emailtemplate') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_emailtemplate&for=nw-ve-a" title="<?php echo __('New Vehicle Admin','js-vehicle-manager'); ?>">
                   <?php echo __('New Vehicle Admin','js-vehicle-manager'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'jsvm_emailtemplate') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_emailtemplate&for=nw-ve" title="<?php echo __('New Vehicle ','js-vehicle-manager'); ?>">
                   <?php echo __('New Vehicle','js-vehicle-manager'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'jsvm_emailtemplate') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_emailtemplate&for=nw-ve-v" title="<?php echo __('New Vehicle Visitor ','js-vehicle-manager'); ?>">
                   <?php echo __('New Vehicle Visitor','js-vehicle-manager'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'jsvm_emailtemplate') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_emailtemplate&for=ve-st" title="<?php echo __('Vehicle Status ','js-vehicle-manager'); ?>">
                   <?php echo __('Vehicle Status','js-vehicle-manager'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'jsvm_emailtemplate') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_emailtemplate&for=de-ve" title="<?php echo __('Delete Vehicle','js-vehicle-manager'); ?>">
                   <?php echo __('Delete Vehicle','js-vehicle-manager'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'jsvm_emailtemplate') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_emailtemplate&for=cr-pr-a" title="<?php echo __('Credits Purchase Admin','js-vehicle-manager'); ?>">
                   <?php echo __('Credits Purchase Admin','js-vehicle-manager'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'jsvm_emailtemplate') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_emailtemplate&for=cr-pr" title="<?php echo __('Credits Purchase','js-vehicle-manager'); ?>">
                   <?php echo __('Credits Purchase','js-vehicle-manager'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'jsvm_emailtemplate') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_emailtemplate&for=cr-ex" title="<?php echo __('Credits Expire','js-vehicle-manager'); ?>">
                   <?php echo __('Credits Expire','js-vehicle-manager'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'jsvm_emailtemplate') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_emailtemplate&for=nw-sl" title="<?php echo __('Register New Seller','js-vehicle-manager'); ?>">
                   <?php echo __('Register New Seller','js-vehicle-manager'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'jsvm_emailtemplate') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_emailtemplate&for=ve-al" title="<?php echo __('Vehicle Alert','js-vehicle-manager'); ?>">
                   <?php echo __('Vehicle Alert','js-vehicle-manager'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'jsvm_emailtemplate') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_emailtemplate&for=t-a-fr" title="<?php echo __('Tell A Friend','js-vehicle-manager'); ?>">
                   <?php echo __('Tell A Friend','js-vehicle-manager'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'jsvm_emailtemplate') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_emailtemplate&for=mk-a-of" title="<?php echo __('Make An Offer','js-vehicle-manager'); ?>">
                   <?php echo __('Make An Offer','js-vehicle-manager'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'jsvm_emailtemplate') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_emailtemplate&for=sc-t-dr" title="<?php echo __('Schedule Test Drive','js-vehicle-manager'); ?>">
                   <?php echo __('Schedule Test Drive','js-vehicle-manager'); ?>
                </a>
            </li>
            <li class="<?php if($c == 'jsvm_emailtemplate') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_emailtemplate&for=mg-t-sr" title="<?php echo __('Message To Seller','js-vehicle-manager'); ?>">
                   <?php echo __('Message To Seller','js-vehicle-manager'); ?>
                </a>
            </li>

        </ul>
    </li>
    <li class="treeview <?php if($c == 'jsvm_country') echo 'jsvm_lastshown'; ?>">
        <a href="admin.php?page=jsvm_country" title="<?php echo __('Country' , 'js-vehicle-manager'); ?>">
             <img class="jsvm_menu-icon" alt="<?php echo __('Country' , 'js-vehicle-manager'); ?>" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/left-icons/countries.png'; ?>" />
            <span class="jsvehiclemanageradmin-text">
                <?php echo __('Country' , 'js-vehicle-manager'); ?>
            </span>
        </a>
        <ul class="jsvehiclemanageradmin-sidebar-submenu treeview-menu">
            <li class="<?php if($c == 'jsvm_country') echo 'jsvm_lastshown'; ?>">
                <a href="admin.php?page=jsvm_country" title="<?php echo __('Country' , 'js-vehicle-manager'); ?>">
                   <?php echo __('Country' , 'js-vehicle-manager'); ?>
                </a>
            </li>
             <li class="<?php if($c == 'jsvm_country') echo 'jsvm_lastshown'; ?>">
                 <?php do_action('jsvm_addons_admin_sidemenu_links_for_loadaddressdata' , $c ); ?>
            </li>
        </ul>
    </li>
</ul>
<script >
    var cookielist = document.cookie.split(';');
    for (var i=0; i<cookielist.length; i++) {
        if (cookielist[i].trim() == "jsvehiclemanageradmin_collapse_admin_menu=1") {
            jQuery("#jsvehiclemanageradmin-wrapper").addClass("menu-collasped-active");
            break;
        }
    }

 jQuery(document).ready(function(){

        var pageWrapper = jQuery("#jsvehiclemanageradmin-wrapper");
        var sideMenuArea = jQuery("#jsvehiclemanageradmin-leftmenu");

        jQuery("#jsvehiclemanageradmin-menu-toggle").on("click", function () {

            if (pageWrapper.hasClass("menu-collasped-active")) {
                pageWrapper.removeClass("menu-collasped-active");
                document.cookie = 'jsvehiclemanageradmin_collapse_admin_menu=0; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
            }else{
                pageWrapper.addClass("menu-collasped-active");
                document.cookie = 'jsvehiclemanageradmin_collapse_admin_menu=1; expires=Sat, 01 Jan 2050 00:00:00 UTC; path=/';
            }
        });

        // to set anchor link active on menu collpapsed
        jQuery('.jsvehiclemanageradmin-sidebar-menu li.treeview a').on('click', function() {
            if (!(pageWrapper.hasClass("menu-collasped-active"))) {
                window.location.href = jQuery(this).attr("href");
            }
        });
    });
</script>
