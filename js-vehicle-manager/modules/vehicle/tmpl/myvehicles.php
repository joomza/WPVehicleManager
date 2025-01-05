<?php
if (!defined('ABSPATH')) die('Restricted Access');?>


<div id="jsvehiclemanager-main-up-wrapper">
<?php
    $msgkey = JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getMessagekey();
    JSVEHICLEMANAGERmessages::getLayoutMessage($msgkey);
    JSVEHICLEMANAGERbreadcrumbs::getBreadcrumbs();
    include_once(JSVEHICLEMANAGER_PLUGIN_PATH . 'includes/header.php');
if (jsvehiclemanager::$_error_flag_message == null) {
?>
    <div id="jsvehiclemanager-wrapper">
        <div class="control-pannel-header">
            <span class="heading">
                <?php echo __('My Vehicles', 'js-vehicle-manager'); ?>
            </span>
        </div>
        <div id="jsvehiclemanager-myvehicle-content">
        <?php
            if (!empty(jsvehiclemanager::$_data[0])) {

                    $curdate = date_i18n('Y-m-d');

                    for ($i = 0, $n = count(jsvehiclemanager::$_data[0]); $i < $n; $i++) {

                        $vehicle = jsvehiclemanager::$_data[0][$i];
                        $arrow_flag = 1;
                        if( empty($vehicle->imagename) ){
                            $imagepath = JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/vehicle-image.png';
                            $arrow_flag = 0;
                        }else{
                            $imagepath = $vehicle->filepath.'ms_'.$vehicle->imagename;
                        }
                        ?>

                        <?php do_action('jsvm_featuredvehicle_vehiclelist_feature_icon',$vehicle); ?>
                        <div class="jsvehiclemanager_vehicle_wrapper">
                            <div class="jsvehiclemanager_vehicle_top_wrap">
                                <div class="jsvehiclemanager_vehicle_slide_wrap">
                                    <div class="jsvehiclemanager_vehicle_slide_image">
                                        <a href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehicledetail', 'jsvehiclemanagerid'=>$vehicle->vehicleid, 'jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid()))); ?>">
                                        <img class="big-image" src="<?php echo esc_url($imagepath); ?>" id="jsvehiclemanager-big-image-<?php echo esc_attr($vehicle->vehicleid); ?>">
                                        </a>
                                        <?php if($arrow_flag == 1){?>
                                            <span class="jsvehiclemanager_vehicle_slide_left_arrow" onclick="showImageSlide(<?php echo esc_html($vehicle->vehicleid)?>,true);">
                                            <img class="jsvehiclemanager_vehicle_logo" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>/includes/images/shortlisted-veh/left-arrow.png" /></span>
                                            <span class="jsvehiclemanager_vehicle_slide_right_arrow" onclick="showImageSlide(<?php echo esc_html($vehicle->vehicleid)?>);">
                                            <img class="jsvehiclemanager_vehicle_logo" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>/includes/images/shortlisted-veh/right-arrow.png" /></span>
                                        <?php } ?>

                                        <?php do_action("jsvm_vehiclelist_mark_vehicle_sold",$vehicle); ?>
                                    </div>
                                </div>
                                <div class="jsvehiclemanager_vehicle_right_content">
                                    <div class="jsvehiclemanager_vehicle_content_top_row">
                                        <span class="jsvehiclemanager_vehicle_title">
                                            <a href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehicledetail', 'jsvehiclemanagerid'=>$vehicle->vehicleid))); ?>">
                                                <span class="title"> <?php echo wp_kses(JSVEHICLEMANAGERincluder::getJSModel('common')->returnVehicleTitle($vehicle->maketitle,$vehicle->modeltitle,$vehicle->modelyeartitle), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></span>
                                            </a>
                                        </span>
                                        <span class="jsvehiclemanager_vehicle_price">
                                            <span class="price">
                                            <?php $v_price = JSVEHICLEMANAGERincluder::getJSModel('common')->getPrice($vehicle->price,$vehicle->currencysymbol, $vehicle->isdiscount, $vehicle->discounttype, $vehicle->discount, $vehicle->discountstart, $vehicle->discountend); ?>
                                             <?php echo esc_html($v_price); ?>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="jsvehiclemanager_vehicle_detail_row">
                                        <span class="jsvehiclemanager_vehicle_create_date">
                                            <?php echo esc_html(date_i18n(jsvehiclemanager::$_config['date_format'],strtotime($vehicle->created))); ?>
                                        </span>
                                    </div>
                                    <div class="jsvehiclemanager_vehicle_detail_row">
                                        <span class="jsvehiclemanager_vehicle_fuel_title"><?php echo __("Fuel Consumption",'js-vehicle-manager').": ";?></span>
                                        <span class="jsvehiclemanager_vehicle_value">
                                        <?php
                                            if (jsvehiclemanager::$_data['listingfields']['cityfuelconsumption'] == 1) {
                                                echo esc_html(__($vehicle->cityfuelconsumption,'js-vehicle-manager'))." ".esc_html($vehicle->mileagesymbol)." ".esc_html__("City",'js-vehicle-manager');
                                            }
                                            if(jsvehiclemanager::$_data['listingfields']['cityfuelconsumption'] == 1 && jsvehiclemanager::$_data['listingfields']['highwayfuelconsumption'] == 1 ){
                                                echo    " / ";
                                            }
                                            if( jsvehiclemanager::$_data['listingfields']['highwayfuelconsumption'] == 1 ){
                                                echo esc_html(__($vehicle->highwayfuelconsumption,'js-vehicle-manager'))." ".esc_html($vehicle->mileagesymbol)." ".esc_html__("Highway",'js-vehicle-manager');
                                            }
                                        ?>
                                        </span>
                                    </div>
                                    <?php do_action('jsvm_featuredvehicle_vehiclelist_show_stock_color',$vehicle); ?>

                                    <div class="jsvehiclemanager_vehicle_detail_row">
                                        <span class="jsvehiclemanager_vehicle_loction_title"><?php echo esc_html(__(jsvehiclemanager::$_data['fields']['locationcity'],'js-vehicle-manager')).': '; ?></span>
                                        <span class="jsvehiclemanager_vehicle_location_value"><?php echo esc_html(__($vehicle->location,'js-vehicle-manager'));?></span>
                                        <span class="jsvehiclemanager_vehicle_expiry_value">
                                            <?php echo __('Expiry Date','js-vehicle-manager').': '.esc_html(date_i18n(jsvehiclemanager::$_config['date_format'],strtotime($vehicle->adexpiryvalue))); ?>
                                        </span>
                                    </div>
                                    <?php
                                        $customfields = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->userFieldsData(1,10,1);// 10 for main section of vehicle
                                        foreach ($customfields AS $field) {
                                        $array =  JSVEHICLEMANAGERincluder::getObjectClass('customfields')->showCustomFields($field, 2, $vehicle->params);
                                    ?>
                                        <div class="jsvehiclemanager_vehicle_detail_row">
                                            <span class="jsvehiclemanager_vehicle_loction_title"><?php echo esc_html(__($array[0],'js-vehicle-manager')).': '; ?></span>
                                            <span class="jsvehiclemanager_vehicle_location_value"><?php echo esc_html(__($array[1],'js-vehicle-manager'));?></span>
                                        </div>
                                    <?php } ?>
                                    <div class="jsvehiclemanager_vehicle_status jsvehiclemanager_vehicle_status-myvehicles">
                                        <?php
                                        if($vehicle->status == 1){
                                            $statusclass = 'jsvehiclemanager-approved';
                                            $statustext = 'Approved';
                                        }elseif($vehicle->status == 0){
                                            $statusclass = 'jsvehiclemanager-pending';
                                            $statustext = 'Pending';
                                        }elseif($vehicle->status == -1){
                                            $statusclass = 'jsvehiclemanager-rejected';
                                            $statustext = 'Rejected';
                                        }
                                        ?>
                                        <span class="<?php echo esc_attr($statusclass); ?>">
                                            <?php echo esc_html(__($statustext,'js-vehicle-manager')); ?>
                                        </span>
                                    </div>

                                </div>
                            </div>
                            <div class="jsvehiclemanager_vehicle_bottom_wrap" class="jsvehiclemanager_frontend">
                                <div class="jsvehiclemanager_vehicle_left">
                                    <?php if($vehicle->conditiontitle !='') { ?>
                                        <div class="jsvehiclemanager_vehicle_option">
                                            <span class="jsvehiclemanager_vehicle_condions_new" style="background:#fff;font-weight:bold;color:<?php echo esc_attr($vehicle->conditioncolor);?>;border:1px solid <?php echo esc_attr($vehicle->conditioncolor);?>;">
                                              <?php echo esc_html(__($vehicle->conditiontitle,'js-vehicle-manager'));?>
                                            </span>
                                        </div><!--menu box-->

                                    <?php } if($vehicle->transmissiontitle != '') { ?>
                                        <div class="jsvehiclemanager_vehicle_option">
                                            <span class="manual_box"><?php echo esc_html(__($vehicle->transmissiontitle,'js-vehicle-manager'));?></span>
                                        </div><!--menu box-->

                                    <?php } if($vehicle->fueltypetitle != '') { ?>
                                        <div class="jsvehiclemanager_vehicle_option">
                                            <span class="petrol_box"><?php echo esc_html(__($vehicle->fueltypetitle,'js-vehicle-manager'));?></span>
                                        </div><!--menu box-->

                                    <?php } if($vehicle->mileages != '') { ?>
                                        <div class="jsvehiclemanager_vehicle_option">
                                            <span class="milage_box"><?php echo esc_html(__($vehicle->mileages,'js-vehicle-manager'))." ".esc_html(__($vehicle->mileagesymbol,'js-vehicle-manager'));?></span>
                                        </div><!--menu box-->

                                    <?php } if($vehicle->enginecapacity != '') { ?>
                                        <div class="jsvehiclemanager_vehicle_option">
                                            <span class="model_box"><?php echo esc_html(__($vehicle->enginecapacity,'js-vehicle-manager'))." ".__("CC",'js-vehicle-manager');?></span>
                                        </div><!--menu box-->
                                    <?php } ?>

                                </div><!--left side-->
                                <div class="jsvehiclemanager_vehicle_right_button">
                                    <div class="jsvehiclemanager_vehicle_button_area">
                                    <a class="jsvehiclemanager_vehicle_btn" href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle','jsvmlt'=>'formvehicle','jsvehiclemanagerid'=>$vehicle->vehicleid,'jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid()))); ?>">
                                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/edit-icon.png" alt="<?php echo __('Edit Icon','js-vehicle-manager'); ?>" title="<?php echo __('Edit','js-vehicle-manager'); ?>">
                                    </a>
                                    <?php do_action('jsvm_myvehiclelist_bottom_btn',$vehicle); // mark as sold,  ?>
                                    <?php //do_action('jsvm_featuredicon_user_vehicles',$vehicle); ?>
                                    <a class="jsvehiclemanager_vehicle_btn" href="<?php echo esc_url(wp_nonce_url( jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle','action'=>'jsvmtask','task'=>'removevehicle','jsvehiclemanagerid'=>$vehicle->vehicleid,'jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid())),'delete-vehicle')); ?>" onclick="return confirm('<?php echo __('Are you sure to delete?','js-vehicle-manager'); ?>');">
                                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/delete.png" alt="<?php echo __('Delete Icon','js-vehicle-manager'); ?>" title="<?php echo __('Delete','js-vehicle-manager'); ?>">
                                    </a>
                                    </div>
                                </div>
                            </div><!--bottom row -->
                        </div><!--jsvehiclemanager_admin_wrapper -->
                        <?php } ?>
                        </div>
                        <?php
                        $nextpage = JSVEHICLEMANAGERpagination::$_currentpage + 1;
            if (jsvehiclemanager::$_data[1]) {
                echo '<div class="jsvehiclemanager-pagination">' . wp_kses_post(jsvehiclemanager::$_data[1]) . '</div>';
            }
            } else {
                $msg = __('No record found','js-vehicle-manager');
                $link = array(
                             array(
                                'link' => jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle','jsvmlt'=>'formvehicle')),
                                'text' => __('Add New','js-vehicle-manager') .' '. __('Vehicle','js-vehicle-manager')
                            )
                        );
                echo wp_kses(JSVEHICLEMANAGERlayout::getNoRecordFound($msg,$link), JSVEHICLEMANAGER_ALLOWED_TAGS);
            }
        ?>
    </div>
<?php
}else{
    echo wp_kses(jsvehiclemanager::$_error_flag_message, JSVEHICLEMANAGER_ALLOWED_TAGS);
}
?>
</div>
</div>
