<?php if (!defined('ABSPATH')) die('Restricted Access'); ?>
<?php wp_enqueue_script('jsauto-res-tables', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/js/responsivetable.js');
$msgkey = JSVEHICLEMANAGERincluder::getJSModel('user')->getMessagekey();
JSVEHICLEMANAGERmessages::getLayoutMessage($msgkey); 
?>
<div id="jsvehiclemanageradmin-wrapper">
    <div id="jsvehiclemanageradmin-leftmenu">
        <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </div>
    <div id="jsvehiclemanageradmin-data">
        <span class="jsvm_js-admin-title">
            <a href="<?php echo esc_url(admin_url('admin.php?page=jsvehiclemanager')); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" /></a>
            <?php echo __('Control Panel', 'js-vehicle-manager') ?>
        </span>
        <table id="jsvm_js-table" class="jsvehiclemanager-shortcodes" >
            <thead>
                <tr>
                    <th ><?php echo __('Title', 'js-vehicle-manager'); ?></th>
                    <th class="jsvehiclemanager-shortcodes-second-col" ><?php echo __('Shortcode', 'js-vehicle-manager'); ?></th>
                    <th class="jsvehiclemanager-shortcodes-third-col" ><?php echo __('Description', 'js-vehicle-manager'); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td  width="33.3%">
                        <?php echo __('List Vehicles','js-vehicle-manager');?>
                    </td>
                    <td  width="33.3%" class="jsvehiclemanager-shortcodes-second-col">
                        [jsvehiclemanager_list_vehicles]
                    </td>
                    <td  width="33.4%" class="jsvehiclemanager-shortcodes-third-col">
                        <?php echo __('This shortcode is for vehicle listing page','js-vehicle-manager'); ?>
                    </td>
                </tr>
                <tr>
                    <td  width="33.3%">
                        <?php echo __('Vehicle Search','js-vehicle-manager');?>
                    </td>
                    <td  width="33.3%" class="jsvehiclemanager-shortcodes-second-col">
                        [jsvehiclemanager_vehicle_search]
                    </td>
                    <td  width="33.4%" class="jsvehiclemanager-shortcodes-third-col">
                        <?php echo __('This shortcode is for vehicle Search page','js-vehicle-manager'); ?>
                    </td>
                </tr>
                <tr>
                    <td  width="33.3%">
                        <?php echo __('Add Vehicle','js-vehicle-manager');?>
                    </td>
                    <td  width="33.3%" class="jsvehiclemanager-shortcodes-second-col">
                        [jsvehiclemanager_add_vehicle]
                    </td>
                    <td  width="33.4%" class="jsvehiclemanager-shortcodes-third-col">
                        <?php echo __('This shortcode is for add vehicle page','js-vehicle-manager'); ?>
                    </td>
                </tr>
                <tr>
                    <td  width="33.3%">
                        <?php echo __('My Vehicles','js-vehicle-manager');?>
                    </td>
                    <td  width="33.3%" class="jsvehiclemanager-shortcodes-second-col">
                        [jsvehiclemanager_my_vehicles]
                    </td>
                    <td  width="33.4%" class="jsvehiclemanager-shortcodes-third-col">
                        <?php echo __('This shortcode is for my vehicles','js-vehicle-manager'); ?>
                    </td>
                </tr>
                <tr>
                    <td  width="33.3%">
                        <?php echo __('Control Panel','js-vehicle-manager');?>
                    </td>
                    <td  width="33.3%" class="jsvehiclemanager-shortcodes-second-col">
                        [jsvehiclemanager_control_panel]
                    </td>
                    <td  width="33.4%" class="jsvehiclemanager-shortcodes-third-col">
                        <?php echo __('This shortcode is for control panel','js-vehicle-manager'); ?>
                    </td>
                </tr>
                <tr>
                    <td  width="33.3%">
                        <?php echo __('Compare Vehicles','js-vehicle-manager');?>
                    </td>
                    <td  width="33.3%" class="jsvehiclemanager-shortcodes-second-col">
                        [jsvehiclemanager_compare_vehicles]
                    </td>
                    <td  width="33.4%" class="jsvehiclemanager-shortcodes-third-col">
                        <?php echo __('This shortcode is for compare vehicles page','js-vehicle-manager'); ?>
                    </td>
                </tr>
                <tr>
                    <td  width="33.3%">
                        <?php echo __('Shortlisted Vehicles','js-vehicle-manager');?>
                    </td>
                    <td  width="33.3%" class="jsvehiclemanager-shortcodes-second-col">
                        [jsvehiclemanager_shortlisted_vehicles]
                    </td>
                    <td  width="33.4%" class="jsvehiclemanager-shortcodes-third-col">
                        <?php echo __('This shortcode is for shortlisted vehicles listing page','js-vehicle-manager'); ?>
                    </td>
                </tr>
                <tr>
                    <td  width="33.3%">
                        <?php echo __('Vehicles By City','js-vehicle-manager');?>
                    </td>
                    <td  width="33.3%" class="jsvehiclemanager-shortcodes-second-col">
                        [jsvehiclemanager_vehicles_by_city]
                    </td>
                    <td  width="33.4%" class="jsvehiclemanager-shortcodes-third-col">
                        <?php echo __('This shortcode is for vehicles by city page','js-vehicle-manager'); ?>
                    </td>
                </tr>
                <tr>
                    <td  width="33.3%">
                        <?php echo __('Vehicles By Type','js-vehicle-manager');?>
                    </td>
                    <td  width="33.3%" class="jsvehiclemanager-shortcodes-second-col">
                        [jsvehiclemanager_vehicles_by_type]
                    </td>
                    <td  width="33.4%" class="jsvehiclemanager-shortcodes-third-col">
                        <?php echo __('This shortcode is for vehicles by types page','js-vehicle-manager'); ?>
                    </td>
                </tr>
                <tr>
                    <td  width="33.3%">
                        <?php echo __('Vehicles By Make','js-vehicle-manager');?>
                    </td>
                    <td  width="33.3%" class="jsvehiclemanager-shortcodes-second-col">
                        [jsvehiclemanager_vehicles_by_make]
                    </td>
                    <td  width="33.4%" class="jsvehiclemanager-shortcodes-third-col">
                        <?php echo __('This shortcode is for vehicles by makes page','js-vehicle-manager'); ?>
                    </td>
                </tr>
                <tr>
                    <td  width="33.3%">
                        <?php echo __('Sellers List','js-vehicle-manager');?>
                    </td>
                    <td  width="33.3%" class="jsvehiclemanager-shortcodes-second-col">
                        [jsvehiclemanager_sellers_list]
                    </td>
                    <td  width="33.4%" class="jsvehiclemanager-shortcodes-third-col">
                        <?php echo __('This shortcode is for sellers listing page','js-vehicle-manager'); ?>
                    </td>
                </tr>
                <tr>
                    <td  width="33.3%">
                        <?php echo __('Sellers By City','js-vehicle-manager');?>
                    </td>
                    <td  width="33.3%" class="jsvehiclemanager-shortcodes-second-col">
                        [jsvehiclemanager_sellers_by_city]
                    </td>
                    <td  width="33.4%" class="jsvehiclemanager-shortcodes-third-col">
                        <?php echo __('This shortcode is for sellers by city page','js-vehicle-manager'); ?>
                    </td>
                </tr>
                <tr>
                    <td  width="33.3%">
                        <?php echo __('Credits Pack','js-vehicle-manager');?>
                    </td>
                    <td  width="33.3%" class="jsvehiclemanager-shortcodes-second-col">
                        [jsvehiclemanager_credits_pack]
                    </td>
                    <td  width="33.4%" class="jsvehiclemanager-shortcodes-third-col">
                        <?php echo __('This shortcode is for credits pack page','js-vehicle-manager'); ?>
                    </td>
                </tr>
                <tr>
                    <td  width="33.3%">
                        <?php echo __('Credits Rate List','js-vehicle-manager');?>
                    </td>
                    <td  width="33.3%" class="jsvehiclemanager-shortcodes-second-col">
                        [jsvehiclemanager_credits_rate_list]
                    </td>
                    <td  width="33.4%" class="jsvehiclemanager-shortcodes-third-col">
                        <?php echo __('This shortcode is for credits rate list page','js-vehicle-manager'); ?>
                    </td>
                </tr>
                <tr>
                    <td  width="33.3%">
                        <?php echo __('Purchase History','js-vehicle-manager');?>
                    </td>
                    <td  width="33.3%" class="jsvehiclemanager-shortcodes-second-col">
                        [jsvehiclemanager_purchase_history]
                    </td>
                    <td  width="33.4%" class="jsvehiclemanager-shortcodes-third-col">
                        <?php echo __('This shortcode is for purchase history page','js-vehicle-manager'); ?>
                    </td>
                </tr>
                <tr>
                    <td  width="33.3%">
                        <?php echo __('Credits Log','js-vehicle-manager');?>
                    </td>
                    <td  width="33.3%" class="jsvehiclemanager-shortcodes-second-col">
                        [jsvehiclemanager_credits_log]
                    </td>
                    <td  width="33.4%" class="jsvehiclemanager-shortcodes-third-col">
                        <?php echo __('This shortcode is for credits log page','js-vehicle-manager'); ?>
                    </td>
                </tr>
                <tr>
                    <td  width="33.3%">
                        <?php echo __('Vehicle Alerts','js-vehicle-manager');?>
                    </td>
                    <td  width="33.3%" class="jsvehiclemanager-shortcodes-second-col">
                        [jsvehiclemanager_vehicle_alerts]
                    </td>
                    <td  width="33.4%" class="jsvehiclemanager-shortcodes-third-col">
                        <?php echo __('This shortcode is for vehicles alerts page','js-vehicle-manager'); ?>
                    </td>
                </tr>
                <tr>
                    <td  width="33.3%">
                        <?php echo __('Login','js-vehicle-manager');?>
                    </td>
                    <td  width="33.3%" class="jsvehiclemanager-shortcodes-second-col">
                        [jsvehiclemanager_login]
                    </td>
                    <td  width="33.4%" class="jsvehiclemanager-shortcodes-third-col">
                        <?php echo __('This shortcode is for login page','js-vehicle-manager'); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
