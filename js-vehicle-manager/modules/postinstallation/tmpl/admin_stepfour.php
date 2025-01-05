<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
wp_enqueue_style('awesomemin-css', $protocol.'cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');

$searchjobtag = array((object) array('id' => 1, 'text' => __('Top left', 'js-vehicle-manager'))
                    , (object) array('id' => 2, 'text' => __('Top right', 'js-vehicle-manager'))
                    , (object) array('id' => 3, 'text' => __('Middle left', 'js-vehicle-manager'))
                    , (object) array('id' => 4, 'text' => __('Middle right', 'js-vehicle-manager'))
                    , (object) array('id' => 5, 'text' => __('Bottom left', 'js-vehicle-manager'))
                    , (object) array('id' => 6, 'text' => __('Bottom right', 'js-vehicle-manager')));

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
<script>
    jQuery(document).ready(function(){
        jQuery("a.next-step").click(function(){
            jQuery("div#overlay").show();
        });
    });
</script>
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
                <div class="header-parts third-part">
                    <a href="<?php echo esc_url(admin_url("admin.php?page=jsvm_postinstallation&jsvmlt=stepthree")); ?>" class="visited">
                        <i class="fa fa-car" aria-hidden="true"></i>
                        <span class="text"><?php echo __('Vehicle Settings', 'js-vehicle-manager'); ?></span>
                    </a>
                </div>
                <div class="header-parts fourth-part active">
                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                    <span class="text"><?php echo __('Sample Data', 'js-vehicle-manager'); ?></span>
                </div>
                <div class="header-parts fifth-part">
                    <i class="fa  fa-check-square-o" aria-hidden="true"></i>
                    <span class="text"><?php echo __('Settings Complete', 'js-vehicle-manager'); ?></span>
                </div>
            </div>
        </div>
        <div class="post-installtion-content">
            <div class="heading-post">
                <span class="heading-post-ins"><?php echo __('Sample Data','js-vehicle-manager');?></span>
                <span class="heading-post-ins-step-count"><?php echo __('Step 4 Of 5','js-vehicle-manager');?></span>
            </div>
            <form id="jsvehiclemanager-form-ins" method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_postinstallation&task=savesampledata&action=jsvmtask")); ?>">
                <?php
                if( jsvehiclemanager::$_car_manager_theme == 1 && !file_exists(WP_PLUGIN_DIR.'/revslider/revslider.php')){ // Unzip ?>
                    <div class="post-installtion-msg">
                        <img alt="info icon" title="info icon" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/postinstallation/info-icon.png" />
                            Revolution Slider Is missing. Please install Revolution Slider so that home 4 data is imported properly.
                        <a href="<?php echo esc_url(admin_url('themes.php?page=tgmpa-install-plugins&plugin_status=install')); ?>" title="install revolution slider" target="_blank">Click here to install Revolution Slider.</a>
                    </div>
                <?php }
                if( jsvehiclemanager::$_car_manager_theme == 1 && !file_exists(WP_PLUGIN_DIR.'/js_composer/js_composer.php')){ // Unzip ?>
                    <div class="post-installtion-msg">
                        <img alt="info icon" title="info icon" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/postinstallation/info-icon.png" />
                            Visual Composer Is missing. Please install Visual Composer so sample can imported properly.
                        <a href="<?php echo esc_url(admin_url('themes.php?page=tgmpa-install-plugins&plugin_status=install')); ?>" title="install Visual Composer" target="_blank">Click here to install Visual Composer.</a>
                    </div>
                <?php } ?>
                <?php //if(jsvehiclemanager::$_car_manager_theme != 1){ ?>
                    <div class="pic-config">
                        <div class="title">
                            <?php echo __('Create vehicle Manager Menu','js-vehicle-manager');?>:
                        </div>
                        <div class="field">
                            <span class="wrp">
                                <input id="vehicle_manager_menu-on" class="toggle toggle-left" name="vehicle_manager_menu" value="0" type="radio" >
                                <label for="vehicle_manager_menu-on" class="btn">Yes</label>
                                <input id="vehicle_manager_menu-off" class="toggle toggle-right" name="vehicle_manager_menu" value="1" type="radio" checked>
                                <label for="vehicle_manager_menu-off" class="btn">No</label>
                            </span>
                        </div>
                        <div class="desc"><?php echo __('Create vehicle manager menu','js-vehicle-manager');?>. </div>

                    </div>
                    <div class="pic-config">
                        <div class="title">
                            <?php echo __('Insert Vehicle Manager Data','js-vehicle-manager');?>:
                        </div>
                        <div class="field">
                            <span class="wrp">
                                <input id="vehicle_manager_data-on" class="toggle toggle-left" name="vehicle_manager_data" value="0" type="radio" >
                                <label for="vehicle_manager_data-on" class="btn">Yes</label>
                                <input id="vehicle_manager_data-off" class="toggle toggle-right" name="vehicle_manager_data" value="1" type="radio" checked>
                                <label for="vehicle_manager_data-off" class="btn">No</label>
                            </span>
                        </div>
                        <div class="desc"><?php echo __('Insert Sample Vehicles and users.', 'js-vehicle-manager'); echo '<br/>'; ?></div>
                        <div class="sample-data-wrp">
                            <div class="sample-data-heading">
                               Seller
                            </div>
                            <div class="sample-data-text">
                                <div class="name-part">
                                    <span class="title">User Name:</span>
                                    <span class="value">seller</span>
                                </div>
                                <div class="name-part">
                                    <span class="title">Password:</span>
                                    <span class="value">demo</span>
                                </div>
                            </div>
                            <div class="sample-data-heading">
                               Seller
                            </div>
                            <div class="sample-data-text">
                                <div class="name-part">
                                    <span class="title">User Name:</span>
                                    <span class="value">seller2</span>
                                </div>
                                <div class="name-part">
                                    <span class="title">Password:</span>
                                    <span class="value">demo</span>
                                </div>
                            </div>
                            <div class="sample-data-heading">
                               <span><?php echo __("It takes sometime for downloading sample data.","js-vehicle-manager"); ?></span>
                            </div>
                        </div>
                    </div>
                <?php
                /* }else{?>
                    <div class="pic-config">
                        <div class="title">
                            <?php echo __('Insert Car Manager Data','js-vehicle-manager');?>:
                        </div>
                        <div class="field">
                            <span class="wrp">
                                <input id="car_manager_data-on" class="toggle toggle-left" name="car_manager_data" value="0" type="radio" >
                                <label for="car_manager_data-on" class="btn">Yes</label>
                                <input id="car_manager_data-off" class="toggle toggle-right" name="car_manager_data" value="1" type="radio" checked>
                                <label for="car_manager_data-off" class="btn">No</label>
                            </span>
                        </div>
                        <div class="desc"><?php echo __('Insert pages, menus, widgets, sample vehicles and users', 'js-vehicle-manager'); echo '<br/>'; ?></div>
                        <div class="sample-data-wrp">
                            <div class="sample-data-heading">
                               Seller
                            </div>
                            <div class="sample-data-text">
                                <div class="name-part">
                                    <span class="title">User Name:</span>
                                    <span class="value">seller</span>
                                </div>
                                <div class="name-part">
                                    <span class="title">Password:</span>
                                    <span class="value">demo</span>
                                </div>
                            </div>
                            <div class="sample-data-heading">
                               Seller
                            </div>
                            <div class="sample-data-text">
                                <div class="name-part">
                                    <span class="title">User Name:</span>
                                    <span class="value">seller2</span>
                                </div>
                                <div class="name-part">
                                    <span class="title">Password:</span>
                                    <span class="value">demo</span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }*/ ?>
                <div class="pic-button-part">
                    <a class="next-step" href="#" onclick="document.getElementById('jsvehiclemanager-form-ins').submit();" >
                        <?php echo __('Next','js-vehicle-manager'); ?>
                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/postinstallation/next-arrow.png" />
                    </a>
                    <a class="back" href="<?php echo esc_url(admin_url("admin.php?page=jsvm_postinstallation&jsvmlt=stepthree")); ?>" >
                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/postinstallation/back-arrow.png" />
                        <?php echo __('Back','js-vehicle-manager'); ?>
                    </a>
                </div>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('action', 'postinstallation_save'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('form_request', 'jsvehiclemanager'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('step', 4), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            </form>
        </div>
    </div>
</div>
<div id="overlay">
    <div class="overlay-data">
        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/postinstallation/loading-1.gif" />
        <span class="overlay-msg"><?php echo __("Please wait for a few minute. It takes some time.","js-vehicle-manager");?></span>
    </div>
</div>
