<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
wp_enqueue_style('awesomemin-css', $protocol.'cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');

$refinesearchpositions = array(
        (object) array('id' => 1 , 'text' => __('Top Left','js-vehicle-manager') ),
        (object) array('id' => 2 , 'text' => __('Top Right','js-vehicle-manager') ),
        (object) array('id' => 3 , 'text' => __('Middle Left','js-vehicle-manager') ),
        (object) array('id' => 4 , 'text' => __('Middle Right','js-vehicle-manager') ),
        (object) array('id' => 5 , 'text' => __('Bottom Left','js-vehicle-manager') ),
        (object) array('id' => 6 , 'text' => __('Bottom Right','js-vehicle-manager') )
    );


$yesno = array((object) array('id' => 1, 'text' => __('Yes', 'js-vehicle-manager'))
                    , (object) array('id' => 0, 'text' => __('No', 'js-vehicle-manager')));
global $wp_roles;
$roles = $wp_roles->get_names();
$userroles = array();
foreach ($roles as $key => $value) {
    $userroles[] = (object) array('id' => $key, 'text' => $value);
}

/*wp_enqueue_script('jsjob-commonjs', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/js/radio.js');*/
if (!defined('ABSPATH')) die('Restricted Access'); ?>
<div id="jsvehiclemanageradmin-wrapper" class="post-installation">
    <div class="js-admin-title-installtion">
        <img class="left-image" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/postinstallation/setting-icon.png" />
        <span class="title-text"><?php echo __('Vehicle Manager Settings','js-vehicle-manager'); ?></span>
        <a href="<?php echo esc_url(admin_url('admin.php?page=jsvehiclemanager')); ?>" class="close-button">
            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/postinstallation/close-icon.png" />
        </a>
    </div>
    <div class="post-installation-content-wrp">
        <div class="post-installtion-content-header">
            <div class="update-header-img step-1">
                <div class="header-parts first-part">
                    <a href="<?php echo esc_url(admin_url("admin.php?page=jsvm_postinstallation&jsvmlt=stepone")); ?>" class="visited">
                        <i class="fa fa-cog" aria-hidden="true"></i>
                        <span class="text"><?php echo __('General Settings', 'js-vehicle-manager'); ?></span>
                    </a>
                </div>
                <div class="header-parts second-part">
                    <a href="<?php echo esc_url(admin_url("admin.php?page=jsvm_postinstallation&jsvmlt=steptwo")); ?>" class="visited">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span class="text"><?php echo __('User Settings', 'js-vehicle-manager'); ?></span>
                    </a>
                </div>
                <div class="header-parts third-part active">
                    <i class="fa fa-car" aria-hidden="true"></i>
                    <span class="text"><?php echo __('Vehicle Settings', 'js-vehicle-manager'); ?></span>
                </div>
                <div class="header-parts fourth-part">
                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                    <span class="text"><?php echo __('Sample Data', 'js-vehicle-manager'); ?></span>
                </div>
                <div class="header-parts fourth-part">
                    <i class="fa  fa-check-square-o" aria-hidden="true"></i>
                    <span class="text"><?php echo __('Settings Complete', 'js-vehicle-manager'); ?></span>
                </div>
            </div>
        </div>
        <div class="post-installtion-content">
            <div class="heading-post">
                <span class="heading-post-ins"><?php echo __('Vehicle Settings','js-vehicle-manager');?></span>
                <span class="heading-post-ins-step-count"><?php echo __('Step 3 Of 5','js-vehicle-manager');?></span>
            </div>
            <form id="jsvehiclemanager-form-ins" method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_postinstallation&task=save&action=jsvmtask")); ?>">
                <div class="pic-config">
                    <div class="title">
                        <?php echo __('Maximum images per vehicle','js-vehicle-manager');?>:
                    </div>
                    <div class="field">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('maximum_images_per_vehicle', jsvehiclemanager::$_data[0]['maximum_images_per_vehicle'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                    <div class="desc"><?php echo __('Maximum upload images per vehicle', 'js-vehicle-manager'); echo '<br/><b></b>'; ?> </div>
                </div>
                <?php if(in_array('visitoraddvehicle', jsvehiclemanager::$_active_addons)){ ?>
                    <div class="pic-config">
                        <div class="title">
                            <?php echo __('Visitor can add vehicle','js-vehicle-manager');?>:
                        </div>
                        <div class="field">
                            <span class="wrp">
                                <input id="visitor_can_add_vehicle-on" class="toggle toggle-left" name="visitor_can_add_vehicle" value="0" type="radio" >
                                <label for="visitor_can_add_vehicle-on" class="btn">Yes</label>
                                <input id="visitor_can_add_vehicle-off" class="toggle toggle-right" name="visitor_can_add_vehicle" value="1" type="radio" checked>
                                <label for="visitor_can_add_vehicle-off" class="btn">No</label>
                            </span>
                        </div>
                        <div class="desc"> </div>
                    </div>
                <?php } ?>
                <div class="pic-config">
                    <div class="title">
                        <?php echo __(' Vehicle default expiry in days');?>:
                    </div>
                    <div class="field">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('default_vehicle_expiry', jsvehiclemanager::$_data[0]['default_vehicle_expiry'],array('class'=>'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                    <div class="desc"> </div>
                </div>
                <?php if(in_array('markassold', jsvehiclemanager::$_active_addons)){ ?>
                    <div class="pic-config">
                        <div class="title">
                            <?php echo __('Show sold vehicles','js-vehicle-manager');?>:
                        </div>
                        <div class="field">
                            <span class="wrp">
                                <input id="show_sold_vehicles-on" class="toggle toggle-left" name="show_sold_vehicles" value="0" type="radio" >
                                <label for="show_sold_vehicles-on" class="btn">Yes</label>
                                <input id="show_sold_vehicles-off" class="toggle toggle-right" name="show_sold_vehicles" value="1" type="radio" checked>
                                <label for="show_sold_vehicles-off" class="btn">No</label>
                            </span>
                        </div>
                        <div class="desc"><?php echo __('Show sold vehicles in vehicle listing', 'js-vehicle-manager'); echo '<br/>'; ?></div>
                    </div>
                <?php } ?>
                <div class="pic-config">
                    <div class="title">
                        <?php echo __('Vehicle condition row','js-vehicle-manager');?>:
                    </div>
                    <div class="field">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('condition_per_row', jsvehiclemanager::$_data[0]['condition_per_row'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                    <div class="desc"> </div>
                </div>
                <div class="pic-config">
                    <div class="title">
                        <?php echo __('Vehicle type per row','js-vehicle-manager');?>:
                    </div>
                    <div class="field">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('type_per_row', jsvehiclemanager::$_data[0]['type_per_row'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                    <div class="desc"> </div>
                </div>
                <div class="pic-config">
                    <div class="title">
                        <?php echo __('Vehicle auto approve','js-vehicle-manager');?>:
                    </div>
                    <div class="field">
                        <span class="wrp">
                            <input id="featuredvehicle_autoapprove-on" class="toggle toggle-left" name="featuredvehicle_autoapprove" value="0" type="radio">
                            <label for="featuredvehicle_autoapprove-on" class="btn">Yes</label>
                            <input id="featuredvehicle_autoapprove-off" class="toggle toggle-right" name="featuredvehicle_autoapprove" value="1" type="radio" checked>
                            <label for="featuredvehicle_autoapprove-off" class="btn">No</label>
                        </span>
                    </div>
                    <div class="desc"> </div>
                </div>
                <div class="pic-config">
                    <div class="title">
                        <?php echo __('Refine Search Tag Position','js-vehicle-manager');?>:
                    </div>
                    <div class="field">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehiclelist_refinesearchposition',$refinesearchpositions, jsvehiclemanager::$_data[0]['vehiclelist_refinesearchposition']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                    <div class="desc"> </div>
                </div>
                <div class="pic-button-part">
                    <a class="next-step" href="#" onclick="document.getElementById('jsvehiclemanager-form-ins').submit();" >
                        <?php echo __('Next','js-vehicle-manager'); ?>
                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/postinstallation/next-arrow.png" />
                    </a>
                    <a class="back" href="<?php echo esc_url(admin_url("admin.php?page=jsvm_postinstallation&jsvmlt=steptwo")); ?>" >
                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/postinstallation/back-arrow.png" />
                        <?php echo __('Back','js-vehicle-manager'); ?>
                    </a>
                </div>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('action', 'postinstallation_save'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('form_request', 'jsvehiclemanager'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('step', 3), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            </form>
        </div>
    </div>
</div>
