<?php
if (!defined('ABSPATH')) die('Restricted Access');?>
<div id="jsvehiclemanager-main-up-wrapper">
<?php
    $msgkey = JSVEHICLEMANAGERincluder::getJSModel('jsvehiclemanager')->getMessagekey();
    JSVEHICLEMANAGERmessages::getLayoutMessage($msgkey);
    JSVEHICLEMANAGERbreadcrumbs::getBreadcrumbs();
    include_once(JSVEHICLEMANAGER_PLUGIN_PATH . 'includes/header.php');
if (jsvehiclemanager::$_error_flag == null) {
?>
    <div id="jsvehiclemanager-wrapper">
        <div class="control-pannel-header">
            <span class="heading">
                <?php echo __('Login', 'js-vehicle-manager'); ?>
            </span>
        </div>
        <div id="jsvehiclemanager-login-content">

    <div id="jsvm-vm-wrapper">
        <?php /*<div class="page_heading"><?php echo __('Login', 'js-vehicle-manager'); ?></div>*/ ?>

        <div class="js-login-wrapper">
            <div  class="js-ourlogin">
                <div class="jsvehiclemanager-login-heading"><?php echo __('Login into your account', 'js-vehicle-manager'); ?></div>
                <?php
                    if (JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()) { // Display WordPress login form:
                        $args = array(
                            'redirect' => jsvehiclemanager::$_data[0]['redirect_url'],
                            'form_id' => 'loginform-custom',
                            'label_username' => __('Username', 'js-vehicle-manager'),
                            'label_password' => __('Password', 'js-vehicle-manager'),
                            'label_log_in' => __('Login', 'js-vehicle-manager'),
                            'label_remember' => __('keep me login', 'js-vehicle-manager'),
                            'remember' => true
                        );
                        wp_login_form($args);
                    }
                ?>
                <?php do_action('jsvm_loginpage_sociallogin_layout'); ?>
            </div>
            <div class="jsvehiclemanager-login-image-wrapper">
               <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL."includes/images/car.png";?>">
            </div>
        </div>

    </div>
<?php
}
?>
</div>
