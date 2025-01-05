<?php

if (!defined('ABSPATH')) die('Restricted Access'); ?>

<?php
    $defaultaddressdisplaytype = array((object) array('id' => 'csc', 'text' => __('City','js-vehicle-manager').', ' .__('State','js-vehicle-manager').', ' .__('Country', 'js-vehicle-manager')), (object) array('id' => 'cs', 'text' => __('City','js-vehicle-manager').', ' .__('State', 'js-vehicle-manager')), (object) array('id' => 'cc', 'text' => __('City','js-vehicle-manager').', ' .__('Country', 'js-vehicle-manager')), (object) array('id' => 'c', 'text' => __('City', 'js-vehicle-manager')));
    $date_format = array((object) array('id' => 'd-m-Y', 'text' => __('dd-mm-yyyy', 'js-vehicle-manager')), (object) array('id' => 'm/d/Y', 'text' => __('mm/dd/yyyy', 'js-vehicle-manager')), (object) array('id' => 'Y-m-d', 'text' => __('yyyy-mm-dd', 'js-vehicle-manager')));
    $yesno = array((object) array('id' => 1, 'text' => __('Yes', 'js-vehicle-manager')), (object) array('id' => 0, 'text' => __('No', 'js-vehicle-manager')));
?>

<div id="jsvm_postinstallation_wrapper">
    <div class="jsvm_pi_topheader-area">
        <div class="jsvm-pi-left"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/good-icon.png"></div>
        <div class="jsvm-pi-right">
            <div class="jsvm-pi-head-text"><?php echo __('Installation Successful' , 'js-vehicle-manager'); ?></div>
            <div class="jsvm-pi-desc-text"><?php echo __('WP Vehicle Manager successfully install' , 'js-vehicle-manager'); ?></div>
        </div>
    </div>
    <div class="jsvm-pi-heading-text"><?php echo __('WP Vehicle Manager Site Settings' , 'js-vehicle-manager'); ?></div>
    <form id="jsvehiclemanager-form" method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_postinstallation&task=save")); ?>">
    <div class="jsvm-pi-content-left">
        <div class="jsvm-pi-content-wrap">
            <div class="jsvm-pi-title"><?php echo __('Data directory', 'js-vehicle-manager'); ?></div>
            <div><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('data_directory', jsvehiclemanager::$_data[0]['data_directory'], array('class' => 'jsvm_inputbox jsvm_pi_field')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            <div class="jsvm-pi-sm"><?php echo __('System will upload all user files in this folder', 'js-vehicle-manager'); echo '<br/>'; echo esc_html(JSVEHICLEMANAGER_PLUGIN_PATH).esc_html(jsvehiclemanager::$_data[0]['data_directory']);?></div>
        </div>
        <div class="jsvm-pi-content-wrap">
            <div class="jsvm-pi-title"><?php echo __('Default pagination size' , 'js-vehicle-manager'); ?></div>
            <div><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('pagination_default_page_size', jsvehiclemanager::$_data[0]['pagination_default_page_size'], array('class' => 'jsvm_inputbox jsvm_pi_field')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            <div class="jsvm-pi-sm"><?php echo __('Maximum number of records show per Page' , 'js-vehicle-manager'); ?></div>
        </div>
        <div class="jsvm-pi-content-wrap">
            <div class="jsvm-pi-title"><?php echo __('Default Expiry in days' , 'js-vehicle-manager'); ?></div>
            <div><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('default_vehicle_expiry', jsvehiclemanager::$_data[0]['default_vehicle_expiry'],array('class'=>'jsvm_inputbox jsvm_pi_field')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            <div class="jsvm-pi-sm"><?php echo __('Vehicle default expiry in days' , 'js-vehicle-manager'); ?></div>
        </div>
        <div class="jsvm-pi-content-wrap">
            <div class="jsvm-pi-title"><?php echo __('Sender Email Address' , 'js-vehicle-manager'); ?></div>
            <div><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('mailfromaddress', jsvehiclemanager::$_data[0]['mailfromaddress'], array('class' => 'jsvm_inputbox jsvm_pi_field')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            <div class="jsvm-pi-sm"><?php echo __('Default sender email address' , 'js-vehicle-manager'); ?></div>
        </div>
        <div class="jsvm-pi-content-wrap">
            <div class="jsvm-pi-title"><?php echo __('Email Sender Name' , 'js-vehicle-manager'); ?></div>
            <div><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('mailfromname', jsvehiclemanager::$_data[0]['mailfromname'], array('class' => 'jsvm_inputbox jsvm_pi_field')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            <div class="jsvm-pi-sm"><?php echo __('Default email sender name' , 'js-vehicle-manager'); ?></div>
        </div>
        <div class="jsvm-pi-content-wrap">
            <div class="jsvm-pi-title"><?php echo __('Admin Email address' , 'js-vehicle-manager'); ?></div>
            <div><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('adminemailaddress', jsvehiclemanager::$_data[0]['adminemailaddress'], array('class' => 'jsvm_inputbox jsvm_pi_field')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            <div class="jsvm-pi-sm"><?php echo __('Admin email address' , 'js-vehicle-manager'); ?></div>
        </div>
    </div>
    <div class="jsvm-pi-content-right">
        <div class="jsvm-pi-content-wrap">
            <div class="jsvm-pi-title"><?php echo __('Date Format' , 'js-vehicle-manager'); ?></div>
            <div><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('date_format', $date_format, jsvehiclemanager::$_data[0]['date_format'] , ''  , array('class'=>'jsvm_pi_field')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            <div class="jsvm-pi-sm"><?php echo __('Date format' , 'js-vehicle-manager'); ?></div>
        </div>
        <div class="jsvm-pi-content-wrap">
            <div class="jsvm-pi-title"><?php echo __('Address Display Style' , 'js-vehicle-manager'); ?></div>
            <div><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('defaultaddressdisplaytype', $defaultaddressdisplaytype, jsvehiclemanager::$_data[0]['defaultaddressdisplaytype'] , ''  , array('class'=>'jsvm_pi_field')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            <div class="jsvm-pi-sm"><?php echo __('Default address display style' , 'js-vehicle-manager'); ?></div>
        </div>
        <div class="jsvm-pi-content-wrap">
            <div class="jsvm-pi-title"><?php echo __('User Can Add Vehicle' , 'js-vehicle-manager'); ?></div>
            <div><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('allow_user_to_add_vehicle', $yesno, jsvehiclemanager::$_data[0]['allow_user_to_add_vehicle'] , ''  , array('class'=>'jsvm_pi_field')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            <div class="jsvm-pi-sm"><?php echo __('User can add new vehicle' , 'js-vehicle-manager'); ?></div>
        </div>
        <?php if(in_array('visitoraddvehicle', jsvehiclemanager::$_active_addons)){ ?>
            <div class="jsvm-pi-content-wrap">
                <div class="jsvm-pi-title"><?php echo __('Visitor Can Add Vehicle' , 'js-vehicle-manager'); ?></div>
                <div><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('visitor_can_add_vehicle', $yesno, jsvehiclemanager::$_data[0]['visitor_can_add_vehicle'] , ''  , array('class'=>'jsvm_pi_field')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                <div class="jsvm-pi-sm"><?php echo __('Visitor can add new vehicle' , 'js-vehicle-manager'); ?></div>
            </div>
        <?php } ?>
        <div class="jsvm-pi-content-wrap">
            <div class="jsvm-pi-title"><?php echo __('Vehicle Auto Approve' , 'js-vehicle-manager'); ?></div>
            <div><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehicle_auto_approve', $yesno, jsvehiclemanager::$_data[0]['vehicle_auto_approve'], '', array('class' => 'jsvm_inputbox jsvm_pi_field', 'data-validation' => '')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            <div class="jsvm-pi-sm"><?php echo __('Auto approve vehicle created from front end' , 'js-vehicle-manager'); ?></div>
        </div>
        <div class="jsvm-pi-content-wrap">
            <div class="jsvm-pi-title"><?php echo __('Sample User Data' , 'js-vehicle-manager'); ?></div>
            <div><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('sampleuserdata', $yesno, 1 , '' , array('class'=>'jsvm_pi_field')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            <div class="jsvm-pi-sm"><?php echo __('Import sample data' , 'js-vehicle-manager'); ?></div>
        </div>
    </div>
    <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('action', 'jsvmtask'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
    <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('step', 3), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
    <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('form_request', 'jsvehiclemanager'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
    <div class="jsvm-pi-lowerbtn">
        <?php echo wp_kses(JSVEHICLEMANAGERformfield::submitbutton('save', __('Save','js-vehicle-manager') .' '. __('Configuration', 'js-vehicle-manager'), array('class' => 'button jsvm-pi-savebtn')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
    </div>
    </form>
</div>
