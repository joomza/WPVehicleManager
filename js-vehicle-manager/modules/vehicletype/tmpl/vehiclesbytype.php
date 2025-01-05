<?php
if (!defined('ABSPATH')) die('Restricted Access');?>
<div id="jsvehiclemanager-main-up-wrapper">
<?php
JSVEHICLEMANAGERbreadcrumbs::getBreadcrumbs();
include_once(JSVEHICLEMANAGER_PLUGIN_PATH . 'includes/header.php');
if (jsvehiclemanager::$_error_flag == null) {
?>  
    <div id="jsvehiclemanager-wrapper">
        <div class="control-pannel-header">
            <span class="heading"><?php echo __('Vehicles by Types', 'js-vehicle-manager'); ?></span>
        </div>
        <div id="jsvehiclemanager-vehicles-details">
            <?php
            $type_per_row = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('type_per_row');
            for ($i = 0; $i < count(jsvehiclemanager::$_data[0]); $i++) {
                $row = jsvehiclemanager::$_data[0][$i];
            ?>
            <a class="jsvehiclemanager_record_perrow jsvehiclemanager-width-<?php echo esc_attr($type_per_row); ?>" href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehicles', 'vehicletypeid'=>$row->id))); ?>">
                <div class="jsvehiclemanager-record-wraper">
                    <div class="jsvehiclemanager-record-image">
                        <?php $imgpath = $row->imagepath; ?>
                        <img src="<?php echo esc_attr($imgpath); ?>"/>
                    </div>
                    <div class="jsvehiclemanager-record-types-title"><span class="jsvehiclemanager-record-title"><?php echo esc_html(__($row->title, 'js-vehicle-manager')); ?></span>(<span class="jsvehiclemanager-record-number"><?php echo esc_html(__($row->vehicles,'js-vehicle-manager'));  ?></span>)</div>
                </div>
            </a>         
            <?php } ?>   
        </div>
    </div>
<?php
}
?>
</div>