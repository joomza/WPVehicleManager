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

/*wp_enqueue_script('jsjob-commonjs', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/js/radio.js');*///not present in plugin folder so commented
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
                <div class="header-parts third-part">
                    <a href="<?php echo esc_url(admin_url("admin.php?page=jsvm_postinstallation&jsvmlt=stepthree")); ?>" class="visited">
                        <i class="fa fa-car" aria-hidden="true"></i>
                        <span class="text"><?php echo __('Vehicle Settings', 'js-vehicle-manager'); ?></span>
                    </a>
                </div>
                <div class="header-parts fourth-part">
                    <a href="<?php echo esc_url(admin_url("admin.php?page=jsvm_postinstallation&jsvmlt=stepfour")); ?>" class="visited">
                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                        <span class="text"><?php echo __('Sample Data', 'js-vehicle-manager'); ?></span>
                    </a>
                </div>
                <div class="header-parts fifth-part active">
                    <i class="fa  fa-check-square-o" aria-hidden="true"></i>
                    <span class="text"><?php echo __('Settings Complete', 'js-vehicle-manager'); ?></span>
                </div>
            </div>
        </div>
       <div class="post-installtion-content">
            <div class="heading-post">
                <span class="heading-post-ins"><?php echo __('Settings Complete','js-vehicle-manager');?></span>
                <span class="heading-post-ins-step-count"><?php echo __('Step 5 Of 5','js-vehicle-manager');?></span>
            </div>
            <div class="pic-config finish">
               <h2 class="finish-message">Settings Completed</h2>
               <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/postinstallation/settings-completed.png" />
               <div class="desc">Settings you applied completed successfully. </div>
            </div>
            <div class="pic-button-part">
                <a class="next-step" href="<?php echo esc_url(admin_url("admin.php?page=jsvehiclemanager")); ?>" >
                    <?php echo __('Finish','js-vehicle-manager'); ?>
                </a>
                <a class="back" href="<?php echo esc_url(admin_url("admin.php?page=jsvm_postinstallation&jsvmlt=stepfour")); ?>" >
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/postinstallation/back-arrow.png" />
                    <?php echo __('Back','js-vehicle-manager'); ?>
                </a>
            </div>
        </div>
    </div>
</div>
