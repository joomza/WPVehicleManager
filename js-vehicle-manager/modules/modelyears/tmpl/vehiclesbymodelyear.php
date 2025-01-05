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
            <span class="heading"><?php echo __('Vehicles by Model Years', 'js-vehicle-manager'); ?></span>
        </div>
        <?php 
        	//echo '<pre>';print_r(jsvehiclemanager::$_data[0]); echo '</pre>';
        ?>
        <div id="jsvehiclemanager-vehicles-details">
        	<?php
            $modelyear_per_row = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('modelyear_per_row');
        	for ($i = 0; $i < count(jsvehiclemanager::$_data[0]); $i++) {
                $row = jsvehiclemanager::$_data[0][$i];
            ?>
            <a class="jsvehiclemanager_record_perrow jsvehiclemanager-width-<?php echo esc_attr($modelyear_per_row); ?>" href="<?php echo jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehicles', 'jsvehiclemanagerid'=>$row->aliasid)); ?>">
        		<div class="jsvehiclemanager-record-wraper">
        			<div class="jsvehiclemanager-record-title"><?php echo esc_html(__($row->title, 'js-vehicle-manager')); ?></div>
        			<div class="jsvehiclemanager-record-number"> (<span class="jsvehiclemanager-record-number-text"><?php echo __($row->vehicles,'js-vehicle-manager');  ?></span>)</div>
        		</div>
        	</a>         
        	<?php } ?>	
        </div>
    </div>
<?php
}
?>
</div>