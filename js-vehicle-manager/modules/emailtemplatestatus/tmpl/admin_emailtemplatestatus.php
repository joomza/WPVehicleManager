<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
wp_enqueue_script('jsvm-res-tables', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/js/responsivetable.js');
?>
<div id="jsvehiclemanageradmin-wrapper">
    <div id="jsvehiclemanageradmin-leftmenu">
        <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </div>
    <div id="jsvehiclemanageradmin-data">
        <?php 
        $msgkey = JSVEHICLEMANAGERincluder::getJSModel('emailtemplatestatus')->getMessagekey();
        JSVEHICLEMANAGERmessages::getLayoutMessage($msgkey); 
        
        $specclass = "jsvm_title";
        ?>
        <span class="jsvm_js-admin-title">
            <a href="<?php echo esc_url(admin_url('admin.php?page=jsvehiclemanager')); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" /></a>
            <?php echo __('Email Templates Options', 'js-vehicle-manager') ?>
        </span>
        <table class="jsvm_adminlist" border="0" id="jsvm_js-table">
            <thead>
                <tr>
                    <th width="40%" class="jsvm_title"><?php echo __('Title' , 'js-vehicle-manager'); ?></th>
                    <th width="20%" class="jsvm_center"><?php echo __('Admin' , 'js-vehicle-manager'); ?></th>
                    <th width="20%" class="jsvm_center"><?php echo __('Seller' , 'js-vehicle-manager'); ?></th>
                    <th width="20%" class="jsvm_center"><?php echo __('Visitor Seller' , 'js-vehicle-manager'); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4" class="jsvm_section-header" ><?php echo __('Vehicle', 'js-vehicle-manager'); ?></td>
                </tr>       
                <tr class="<?php echo esc_attr($specclass); ?>">
                    <?php
                    $lang = __('Add new vehicle', 'js-vehicle-manager');
                    ?>              
                    <td class="jsvm_left-row"><?php echo esc_attr($lang); ?></td>
                    <td>
                        <?php if (jsvehiclemanager::$_data[0]['add_new_vehicle']['admin'] == 1) { ?> 
                            <a class="jsvm_left-row-status" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_emailtemplatestatus&task=noSendEmail&action=jsvmtask&jsvehiclemanagerid='.jsvehiclemanager::$_data[0]['add_new_vehicle']['tempid'].'&actionfor=1'),'nosend-email')); ?>">
                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/yes.png" border="0" alt="<?php echo __('Send email', 'js-vehicle-manager'); ?>" /></a>
                        <?php } else { ?>
                            <a class="jsvm_left-row-status" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_emailtemplatestatus&task=sendEmail&action=jsvmtask&jsvehiclemanagerid='.jsvehiclemanager::$_data[0]['add_new_vehicle']['tempid'].'&actionfor=1'),'send-email')); ?>">
                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/no.png" border="0" alt="<?php echo __('Do not send email', 'js-vehicle-manager'); ?>" /></a>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if (jsvehiclemanager::$_data[0]['add_new_vehicle']['seller'] == 1) { ?> 
                            <a class="jsvm_left-row-status" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_emailtemplatestatus&task=noSendEmail&action=jsvmtask&jsvehiclemanagerid='.jsvehiclemanager::$_data[0]['add_new_vehicle']['tempid'].'&actionfor=2'),'nosend-email')); ?>">
                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/yes.png" border="0" alt="<?php echo __('Send email', 'js-vehicle-manager'); ?>" /></a>
                        <?php } else { ?>
                            <a class="jsvm_left-row-status" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_emailtemplatestatus&task=sendEmail&action=jsvmtask&jsvehiclemanagerid='.jsvehiclemanager::$_data[0]['add_new_vehicle']['tempid'].'&actionfor=2'),'send-email')); ?>">
                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/no.png" border="0" alt="<?php echo __('Do not send email', 'js-vehicle-manager'); ?>" /></a>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if (jsvehiclemanager::$_data[0]['add_new_vehicle']['seller_visitor'] == 1) { ?> 
                            <a class="jsvm_left-row-status" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_emailtemplatestatus&task=noSendEmail&action=jsvmtask&jsvehiclemanagerid='.jsvehiclemanager::$_data[0]['add_new_vehicle']['tempid'].'&actionfor=3'),'nosend-email')); ?>">
                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/yes.png" border="0" alt="<?php echo __('Send email', 'js-vehicle-manager'); ?>" /></a>
                        <?php } else { ?>
                            <a class="jsvm_left-row-status" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_emailtemplatestatus&task=sendEmail&action=jsvmtask&jsvehiclemanagerid='.jsvehiclemanager::$_data[0]['add_new_vehicle']['tempid'].'&actionfor=3'),'send-email')); ?>">
                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/no.png" border="0" alt="<?php echo __('Do not send email', 'js-vehicle-manager'); ?>" /></a>
                        <?php } ?>
                    </td>
                </tr>           
                <tr class="<?php echo esc_attr($specclass); ?>">
                    <?php
                    $lang = __('Delete Vehicle' , 'js-vehicle-manager');
                    ?>
                    <td class="jsvm_left-row"><?php echo esc_attr($lang); ?></td>
                    <td> - </td>
                    <td>
                        <?php if (jsvehiclemanager::$_data[0]['delete_vehicle']['seller'] == 1) { ?> 
                            <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_emailtemplatestatus&task=noSendEmail&action=jsvmtask&jsvehiclemanagerid='.jsvehiclemanager::$_data[0]['delete_vehicle']['tempid'].'&actionfor=2'),'nosend-email')); ?>">
                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/yes.png" border="0" alt="<?php echo __('Send email', 'js-vehicle-manager'); ?>" /></a>
                        <?php } else { ?>
                            <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_emailtemplatestatus&task=sendEmail&action=jsvmtask&jsvehiclemanagerid='.jsvehiclemanager::$_data[0]['delete_vehicle']['tempid'].'&actionfor=2'),'send-email')); ?>">
                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/no.png" border="0" alt="<?php echo __('Do not send email', 'js-vehicle-manager'); ?>" /></a>
                        <?php } ?>
                    </td>
                    <td> - </td>
                </tr>
                <tr class="<?php echo esc_attr($specclass); ?>">
                    <?php
                    $lang = __('Vehicle Status','js-vehicle-manager');
                    ?>
                    <td class="jsvm_left-row"><?php echo esc_attr($lang); ?></td>
                    <td> - </td>
                    <td>
                        <?php if (jsvehiclemanager::$_data[0]['vehicle_status']['seller'] == 1) { ?> 
                            <a  href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_emailtemplatestatus&task=noSendEmail&action=jsvmtask&jsvehiclemanagerid='.jsvehiclemanager::$_data[0]['vehicle_status']['tempid'].'&actionfor=2'),'nosend-email')); ?>">
                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/yes.png" border="0" alt="<?php echo __('Send email', 'js-vehicle-manager'); ?>" /></a>
                        <?php } else { ?>
                            <a class="jsvm_left-row-status" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_emailtemplatestatus&task=sendEmail&action=jsvmtask&jsvehiclemanagerid='.jsvehiclemanager::$_data[0]['vehicle_status']['tempid'].'&actionfor=2'),'send-email')); ?>">
                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/no.png" border="0" alt="<?php echo __('Do not send email', 'js-vehicle-manager'); ?>" /></a>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if (jsvehiclemanager::$_data[0]['vehicle_status']['seller_visitor'] == 1) { ?> 
                            <a class="jsvm_left-row-status" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_emailtemplatestatus&task=noSendEmail&action=jsvmtask&jsvehiclemanagerid='.jsvehiclemanager::$_data[0]['vehicle_status']['tempid'].'&actionfor=3'),'nosend-email')); ?>">
                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/yes.png" border="0" alt="<?php echo __('Send email', 'js-vehicle-manager'); ?>" /></a>
                        <?php } else { ?>
                            <a class="jsvm_left-row-status" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_emailtemplatestatus&task=sendEmail&action=jsvmtask&jsvehiclemanagerid='.jsvehiclemanager::$_data[0]['vehicle_status']['tempid'].'&actionfor=3'),'send-email')); ?>">
                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/no.png" border="0" alt="<?php echo __('Do not send email', 'js-vehicle-manager'); ?>" /></a>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="jsvm_section-header" ><?php echo __('Miscellaneous', 'js-vehicle-manager'); ?></td>
                </tr>       
                <tr class="<?php echo esc_attr($specclass); ?>">
                    <?php
                    $lang = __('Purchase Credits Pack','js-vehicle-manager');
                    ?>
                    <td class="jsvm_left-row"><?php echo esc_attr($lang); ?></td>
                    <td>
                        <?php if (jsvehiclemanager::$_data[0]['purchase_credits_pack']['admin'] == 1) { ?> 
                            <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_emailtemplatestatus&task=noSendEmail&action=jsvmtask&jsvehiclemanagerid='.jsvehiclemanager::$_data[0]['purchase_credits_pack']['tempid'].'&actionfor=1'),'nosend-email')); ?>">
                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/yes.png" border="0" alt="<?php echo __('Send email', 'js-vehicle-manager'); ?>" /></a>
                        <?php } else { ?>
                            <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_emailtemplatestatus&task=sendEmail&action=jsvmtask&jsvehiclemanagerid='.jsvehiclemanager::$_data[0]['purchase_credits_pack']['tempid'].'&actionfor=1'),'send-email')); ?>">
                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/no.png" border="0" alt="<?php echo __('Do not send email', 'js-vehicle-manager'); ?>" /></a>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if (jsvehiclemanager::$_data[0]['purchase_credits_pack']['seller'] == 1) { ?> 
                            <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_emailtemplatestatus&task=noSendEmail&action=jsvmtask&jsvehiclemanagerid='.jsvehiclemanager::$_data[0]['purchase_credits_pack']['tempid'].'&actionfor=2'),'nosend-email')); ?>">
                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/yes.png" border="0" alt="<?php echo __('Send email', 'js-vehicle-manager'); ?>" /></a>
                        <?php } else { ?>
                            <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_emailtemplatestatus&task=sendEmail&action=jsvmtask&jsvehiclemanagerid='.jsvehiclemanager::$_data[0]['purchase_credits_pack']['tempid'].'&actionfor=2'),'send-email')); ?>">
                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/no.png" border="0" alt="<?php echo __('Do not send email', 'js-vehicle-manager'); ?>" /></a>
                        <?php } ?>
                    </td>
                    <td>-</td>
                </tr>

                <tr class="<?php echo esc_attr($specclass); ?>">
                    <?php
                    $lang = __('Expire Credits Pack','js-vehicle-manager');
                    ?>
                    <td class="jsvm_left-row"><?php echo esc_attr($lang); ?></td>
                    <td>-</td>
                    <td>
                        <?php if (jsvehiclemanager::$_data[0]['expire_credits_pack']['seller'] == 1) { ?> 
                            <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_emailtemplatestatus&task=noSendEmail&action=jsvmtask&jsvehiclemanagerid='.jsvehiclemanager::$_data[0]['expire_credits_pack']['tempid'].'&actionfor=2'),'nosend-email')); ?>">
                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/yes.png" border="0" alt="<?php echo __('Send email', 'js-vehicle-manager'); ?>" /></a>
                        <?php } else { ?>
                            <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_emailtemplatestatus&task=sendEmail&action=jsvmtask&jsvehiclemanagerid='.jsvehiclemanager::$_data[0]['expire_credits_pack']['tempid'].'&actionfor=2'),'send-email')); ?>">
                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/no.png" border="0" alt="<?php echo __('Do not send email', 'js-vehicle-manager'); ?>" /></a>
                        <?php } ?>
                    </td>
                    <td>-</td>
                </tr>
                <tr class="<?php echo esc_attr($specclass); ?>">
                    <?php
                    $lang = __('Register New Seller','js-vehicle-manager');
                    ?>
                    <td class="jsvm_left-row"><?php echo esc_attr($lang); ?></td>
                    <td>-</td>
                    <td>
                        <?php if (jsvehiclemanager::$_data[0]['add_new_seller']['seller'] == 1) { ?> 
                            <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_emailtemplatestatus&task=noSendEmail&action=jsvmtask&jsvehiclemanagerid='.jsvehiclemanager::$_data[0]['add_new_seller']['tempid'].'&actionfor=2'),'nosend-email')); ?>">
                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/yes.png" border="0" alt="<?php echo __('Send email', 'js-vehicle-manager'); ?>" /></a>
                        <?php } else { ?>
                            <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_emailtemplatestatus&task=sendEmail&action=jsvmtask&jsvehiclemanagerid='.jsvehiclemanager::$_data[0]['add_new_seller']['tempid'].'&actionfor=2'),'send-email')); ?>">
                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/no.png" border="0" alt="<?php echo __('Do not send email', 'js-vehicle-manager'); ?>" /></a>
                        <?php } ?>
                    </td>
                    <td>-</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
