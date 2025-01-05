<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
wp_enqueue_style('awesomemin-css', $protocol.'cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');

global $wp_roles;
$roles = $wp_roles->get_names();
$userroles = array();
foreach ($roles as $key => $value) {
    $userroles[] = (object) array('id' => $key, 'text' => $value);
}
$yesno = array((object) array('id' => 1, 'text' => __('Yes', 'js-vehicle-manager'))
                    , (object) array('id' => 0, 'text' => __('No', 'js-vehicle-manager')));
$showhide = array((object) array('id' => 1, 'text' => __('Show', 'js-vehicle-manager')), (object) array('id' => 0, 'text' => __('Hide', 'js-vehicle-manager')));
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
                <div class="header-parts second-part active">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span class="text"><?php echo __('User Settings', 'js-vehicle-manager'); ?></span>
                </div>
                <div class="header-parts third-part">
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
                <span class="heading-post-ins"><?php echo __('User Settings','js-vehicle-manager');?></span>
                <span class="heading-post-ins-step-count"><?php echo __('Step 2 Of 5','js-vehicle-manager');?></span>
            </div>
            <form id="jsvehiclemanager-form-ins" method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_postinstallation&task=save&action=jsvmtask")); ?>">
                <?php if(in_array('buyercontacttoseller', jsvehiclemanager::$_active_addons)){ ?>
                    <div class="pic-config">
                        <div class="title">
                            <?php echo __('Buyer Can Contact Seller','js-vehicle-manager');?>:
                        </div>
                        <div class="field">
                            <span class="wrp">
                                <input id="vehicle_buyercontactseller-on" class="toggle toggle-left" name="vehicle_buyercontactseller" value="0" type="radio" >
                                <label for="vehicle_buyercontactseller-on" class="btn"><?php echo __('Yes','js-vehicle-manager'); ?></label>
                                <input id="vehicle_buyercontactseller-off" class="toggle toggle-right" name="vehicle_buyercontactseller" value="1" type="radio" checked>
                                <label for="vehicle_buyercontactseller-off" class="btn"><?php echo __('No','js-vehicle-manager'); ?></label>
                            </span>
                        </div>
                        <div class="desc"> </div>
                    </div>
                <?php } ?>
                <div class="pic-config">
                    <div class="title">
                        <?php echo __('Show Seller Image','js-vehicle-manager');?>:
                    </div>
                    <div class="field">
                        <span class="wrp">
                            <input id="vehiclelist_sellerimage-on" class="toggle toggle-left" name="vehiclelist_sellerimage" value="0" type="radio" >
                            <label for="vehiclelist_sellerimage-on" class="btn"><?php echo __('Yes','js-vehicle-manager'); ?></label>
                            <input id="vehiclelist_sellerimage-off" class="toggle toggle-right" name="vehiclelist_sellerimage" value="1" type="radio" checked>
                            <label for="vehiclelist_sellerimage-off" class="btn"><?php echo __('No','js-vehicle-manager'); ?></label>
                        </span>
                    </div>
                    <div class="desc"><?php echo __('Show seller image on vehicle listing', 'js-vehicle-manager'); ?></div>
                </div>
                <div class="pic-config">
                    <div class="title">
                        <?php echo __('User register redirect','js-vehicle-manager');?>:
                    </div>
                    <div class="field">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('register_user_redirect_page', JSVEHICLEMANAGERincluder::getJSModel('postinstallation')->getPageList(), jsvehiclemanager::$_data[0]['register_user_redirect_page']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                    <div class="desc"><?php echo __('New user register redirect page', 'js-vehicle-manager'); ?></div>
                </div>
                <?php if(in_array('credits', jsvehiclemanager::$_active_addons)){ ?>
                    <div class="pic-config">
                        <div class="title">
                            <?php echo __('Auto assign package to new user','js-vehicle-manager');?>:
                        </div>
                        <div class="field">
                            <span class="wrp">
                                <input id="auto_assign_free_package-on" class="toggle toggle-left" name="auto_assign_free_package" value="0" type="radio" >
                                <label for="auto_assign_free_package-on" class="btn"><?php echo __('Yes','js-vehicle-manager'); ?></label>
                                <input id="auto_assign_free_package-off" class="toggle toggle-right" name="auto_assign_free_package" value="1" type="radio" checked>
                                <label for="auto_assign_free_package-off" class="btn"><?php echo __('No','js-vehicle-manager'); ?></label>
                            </span>
                        </div>
                        <div class="desc"><?php echo __('Auto assign free package to new user', 'js-vehicle-manager'); ?></div>
                    </div>
                <?php } ?>
                <div class="pic-config">
                    <div class="title">
                        <?php echo __('User can add vehicle','js-vehicle-manager');?>:
                    </div>
                    <div class="field">
                        <span class="wrp">
                            <input id="allow_user_to_add_vehicle-on" class="toggle toggle-left" name="allow_user_to_add_vehicle" value="0" type="radio" >
                            <label for="allow_user_to_add_vehicle-on" class="btn"><?php echo __('Yes','js-vehicle-manager'); ?></label>
                            <input id="allow_user_to_add_vehicle-off" class="toggle toggle-right" name="allow_user_to_add_vehicle" value="1" type="radio" checked >
                            <label for="allow_user_to_add_vehicle-off" class="btn"><?php echo __('No','js-vehicle-manager'); ?></label>
                        </span>
                    </div>
                    <div class="desc"></div>
                </div>
                <div class="pic-button-part">
                    <a class="next-step" href="#" onclick="document.getElementById('jsvehiclemanager-form-ins').submit();" >
                        <?php echo __('Next','js-vehicle-manager'); ?>
                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/postinstallation/next-arrow.png" />
                    </a>
                    <a class="back" href="<?php echo esc_url(admin_url("admin.php?page=jsvm_postinstallation&jsvmlt=stepone")); ?>" >
                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/postinstallation/back-arrow.png" />
                        <?php echo __('Back','js-vehicle-manager'); ?>
                    </a>
                </div>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('action', 'postinstallation_save'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('form_request', 'jsvehiclemanager'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('step', 2), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            </form>
        </div>
    </div>
</div>
