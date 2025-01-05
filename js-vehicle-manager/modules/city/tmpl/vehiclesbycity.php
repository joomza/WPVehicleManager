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
            <span class="heading"><?php echo __('Vehicles by City', 'js-vehicle-manager'); ?></span>
        </div>
        <?php
        	//echo '<pre>';print_r(jsvehiclemanager::$_data[0]); echo '</pre>';
        ?>
        <?php if(!empty(jsvehiclemanager::$_data[0])){ ?>
            <div id="jsvehiclemanager-vehicles-details">
            	<?php
                $city_per_row = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('city_per_row');
            	for ($i = 0; $i < count(jsvehiclemanager::$_data[0]); $i++) {
                    $row = jsvehiclemanager::$_data[0][$i];
                    if( jsvehiclemanager::$_data['config']['vehiclebycity_countryname'] == 1 ){
                        $cityname = $row->cityname.', '.$row->countryname;
                    }
                    else{
                        $cityname = $row->cityname;
                    }
                ?>
                <a class="jsvehiclemanager_record_perrow jsvehiclemanager-width-<?php echo esc_attr($city_per_row); ?>" href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehicles', 'cityid'=>$row->cityid))); ?>">
            		<div class="jsvehiclemanager-record-wraper">
            			<div class="jsvehiclemanager-record-title"><?php echo esc_html(__($cityname, 'js-vehicle-manager')); ?></div>
                        <?php if(jsvehiclemanager::$_data['config']['vehiclebycity_vehiclecount'] == 1) { ?>
            			<div class="jsvehiclemanager-record-number"> (<span class="jsvehiclemanager-record-number-text"><?php echo esc_html(__($row->totalvehiclelbycity,'js-vehicle-manager'));  ?></span>)</div>
                        <?php } ?>
            		</div>
            	</a>
            	<?php }?>
            </div>
        <?php  }else{
            $msg = __('No record found','js-vehicle-manager');
           echo wp_kses(JSVEHICLEMANAGERlayout::getNoRecordFound($msg), JSVEHICLEMANAGER_ALLOWED_TAGS);
        } ?>
    </div>

<?php
}
?>
</div>
