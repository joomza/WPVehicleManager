<?php if (!defined('ABSPATH')) die('Restricted Access'); ?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $.validate();
    });
</script>
<div id="jsvehiclemanageradmin-wrapper">
    <div id="jsvehiclemanageradmin-leftmenu">
        <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </div>
    <div id="jsvehiclemanageradmin-data">
        <span class="jsvm_js-admin-title">
            <a href="<?php echo esc_url(admin_url('admin.php?page=jsvm_adexpiry'));?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" /></a>
            <?php
            $heading = isset(jsvehiclemanager::$_data[0]) ? __('Edit', 'js-vehicle-manager') : __('Add New', 'js-vehicle-manager');
            echo $heading . '&nbsp' . __('Expiry', 'js-vehicle-manager');
            ?>
        </span>
        <div class="jsvehiclemanager-form-wrap">
            <form id="jsvehiclemanager-form" method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_adexpiry&task=saveadexpiry")); ?>">
                <div class="jsvm_js-field-wrapper">
                    <div class="jsvm_js-field-title"><?php echo __('Expiry Value', 'js-vehicle-manager'); ?><font class="required-notifier">*</font></div>
                    <div class="jsvm_js-field-obj"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('advalue', isset(jsvehiclemanager::$_data[0]->advalue) ? __(jsvehiclemanager::$_data[0]->advalue,'js-vehicle-manager') : '', array('class' => 'inputbox one', 'data-validation' => 'required number')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                </div>
                <div class="jsvm_js-field-wrapper">
                    <div class="jsvm_js-field-title"><?php echo __('Type', 'js-vehicle-manager'); ?><font class="required-notifier">*</font></div>
                    <div class="jsvm_js-field-obj"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('type', JSVEHICLEMANAGERincluder::getJSModel('common')->getAdExpiryTypeForCombobox(), isset(jsvehiclemanager::$_data[0]->type) ? jsvehiclemanager::$_data[0]->type : '', __('Select type', 'js-vehicle-manager'), array('class' => 'inputbox', 'data-validation' => 'required')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                </div>
                <div class="jsvm_js-field-wrapper">
                    <div class="jsvm_js-field-title"><?php echo __('Published', 'js-vehicle-manager'); ?></div>
                    <div class="jsvm_js-field-obj"><?php echo wp_kses(JSVEHICLEMANAGERformfield::radiobutton('status', array('1' => __('Yes', 'js-vehicle-manager'), '0' => __('No', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data[0]->status) ? jsvehiclemanager::$_data[0]->status : 1, array('class' => 'radiobutton')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                </div>
                <div class="jsvm_js-field-wrapper">
                    <div class="jsvm_js-field-title"><?php echo __('Default', 'js-vehicle-manager'); ?></div>
                    <div class="jsvm_js-field-obj"><?php echo wp_kses(JSVEHICLEMANAGERformfield::radiobutton('isdefault', array('1' => __('Yes', 'js-vehicle-manager'), '0' => __('No', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data[0]->isdefault) ? jsvehiclemanager::$_data[0]->isdefault : 0, array('class' => 'radiobutton')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                </div>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('id', isset(jsvehiclemanager::$_data[0]->id) ? jsvehiclemanager::$_data[0]->id : ''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('ordering', isset(jsvehiclemanager::$_data[0]->ordering) ? jsvehiclemanager::$_data[0]->ordering : '' ), JSVEHICLEMANAGER_ALLOWED_TAGS);?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('jsvehiclemanager_isdefault', isset(jsvehiclemanager::$_data[0]->isdefault) ? jsvehiclemanager::$_data[0]->isdefault : ''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('form_request', 'jsvehiclemanager'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('_wpnonce', wp_create_nonce('save-adexpiry')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <div class="jsvm_js-submit-container">
                    <div class="jsvm_js-button-container">
                        <a id="jsvm_form-cancel-button" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_adexpiry')); ?>" ><?php echo __('Cancel', 'js-vehicle-manager'); ?></a>
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::submitbutton('save', __('Save','js-vehicle-manager') .' '. __('Ad-Expiry', 'js-vehicle-manager'), array('class' => 'button')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
