<?php
if (!defined('ABSPATH')) die('Restricted Access');?>
<div id="jsvehiclemanager-main-up-wrapper">
<?php
$msgkey = JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getMessagekey();
JSVEHICLEMANAGERmessages::getLayoutMessage($msgkey);
JSVEHICLEMANAGERbreadcrumbs::getBreadcrumbs();
wp_enqueue_style('jsauto-ratingstyle', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/css/jsvehiclemanagerrating.css');
include_once(JSVEHICLEMANAGER_PLUGIN_PATH . 'includes/header.php');

function checkLinks($name) {
    $print = false;
    $configname = $name;

    $config_array = jsvehiclemanager::$_data['config'];
    if ($config_array["$configname"] == 1) {
        $print = true;
    }
    return $print;
}

if (jsvehiclemanager::$_error_flag == null) {

    $radiustype = array(
        (object) array('id' => '1', 'text' => __('Meters', 'js-vehicle-manager')),
        (object) array('id' => '2', 'text' => __('Kilometers', 'js-vehicle-manager')),
        (object) array('id' => '3', 'text' => __('Miles', 'js-vehicle-manager')),
        (object) array('id' => '4', 'text' => __('Nautical Miles', 'js-vehicle-manager')),
    );

    $location = 'left';
    $borderradius = '0px 8px 8px 0px';
    $padding = '5px 10px 5px 20px';
    $searchjobtag = jsvehiclemanager::$_data['config']['vehiclelist_refinesearchposition'];
    //$searchjobtag = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('searchvehicletag');
    switch ($searchjobtag) {
        case 1: // Top left
            $top = "30px";
            $left = "0px";
            $right = "none";
            $bottom = "none";
            break;
        case 2: // Top right
            $top = "30px";
            $left = "none";
            $right = "0px";
            $bottom = "none";
            $location = 'right';
            $borderradius = '8px 0px 0px 8px';
            $padding = '5px 20px 5px 10px';
            break;
        case 3: // middle left
            $top = "48%";
            $left = "0px";
            $right = "none";
            $bottom = "none";
            break;
        case 4: // middle right
            $top = "48%";
            $left = "none";
            $right = "0px";
            $bottom = "none";
            $location = 'right';
            $borderradius = '8px 0px 0px 8px';
            $padding = '5px 20px 5px 10px';
            break;
        case 5: // bottom left
            $top = "none";
            $left = "0px";
            $right = "none";
            $bottom = "30px";
            break;
        case 6: // bottom right
            $top = "none";
            $left = "none";
            $right = "0px";
            $bottom = "30px";
            $location = 'right';
            $borderradius = '8px 0px 0px 8px';
            $padding = '5px 20px 5px 10px';
            break;
    }
    $html = '<style type="text/css">
                div#refineSearch{opacity:0;position:fixed;top:' . $top . ';left:' . $left . ';right:' . $right . ';bottom:' . $bottom . ';padding:' . $padding . ';background:rgba(149,149,149,.50);z-index:9999;border-radius:' . $borderradius . ';}
                div#refineSearch img{margin-' . $location . ':10px;display:inline-block;vertical-align:middle;}
                div#refineSearch a{color:#ffffff;text-decoration:none;}
            </style>';


   include_once('vehiclepopups.php');


?>
    <div id="jsvehiclemanager-wrapper">

        <?php
        $html .= '<div id="refineSearch">';
        if ($location == 'right') {
            $html .= '<img src="' . JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/searchicon.png" /><a href="#">' . __("Search", 'js-vehicle-manager') . '</a>';
        } else {
            $html .= '<a href="#">' . __("Search", 'js-vehicle-manager') . '</a><img src="' . JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/searchicon.png" />';
        }
        $html .= '
                </div>
                <script type="text/javascript">
                    jQuery(document).ready(function(){

                        var isMSIE = false;
                        if(navigator.appName === "Microsoft Internet Explorer") isMSIE = true;
                        if(!isMSIE && /(MSIE|Trident\/|Edge\/)/i.test(navigator.userAgent || userAgent))    isMSIE = true;
                        if(isMSIE){
                            jQuery("div#refineSearch").css("opacity",1);
                        }else{
                            jQuery("div#refineSearch").css("' . $location . '","-"+(jQuery("div#refineSearch a").width() + 25)+"px");
                            jQuery("div#refineSearch").css("opacity",1);
                            jQuery("div#refineSearch").hover(
                                function(){
                                    jQuery(this).animate({' . $location . ': "+="+(jQuery("div#refineSearch a").width() + 25)}, 1000);
                                },
                                function(){
                                    jQuery(this).animate({' . $location . ': "-="+(jQuery("div#refineSearch a").width() + 25)}, 1000);
                                }
                            );
                        }
                    });
                </script>';
        echo $html;
        ?>
        <!-- Refine Popup Start -->

        <?php include_once('refinesearchpopup.php'); ?>

        <!-- Refine Popup End -->



        <div class="control-pannel-header">
            <span class="heading">
                <?php echo __('Vehicles', 'js-vehicle-manager'); ?> <?php echo esc_html(jsvehiclemanager::$_data['vehiclesby']); ?>
                <?php if(JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('show_total_number_of_vehicles') == 1) { ?>
                <div class="jsvehiclemanager-vehicle-listing-total-vehicles" >
                    <?php echo __('Total Vehicles','js-vehicle-manager').':&nbsp;'; ?>
                    <span><?php echo esc_html(jsvehiclemanager::$_data['total']);?></span>
                </div>
            <?php } ?>
            </span>
            <?php do_action('jsvm_vehiclelist_topheading_btns'); // for showing "Go to compare button", "Vehicle Alert" ?>
        </div>
        <div id="jsvehiclemanager-content">
        <?php
            if (!empty(jsvehiclemanager::$_data[0])) {

                    $compareVehicleList=array();
                    if(in_array('comparevehicle', jsvehiclemanager::$_active_addons)){
                        if(isset(jsvehiclemanager::$_data['json_data'])){
                            foreach(json_decode(jsvehiclemanager::$_data['json_data']) as $k=>$compVeh){
                                $compareVehicleList[] = $k;
                            }
                        }
                    }
                    $curdate = date_i18n('Y-m-d');
                    $noofvehicles = 0;
                    for ($i = 0, $n = count(jsvehiclemanager::$_data[0]); $i < $n; $i++) {
                        $vehicle = jsvehiclemanager::$_data[0][$i];
                        $arrow_flag = 1;
                        if( empty($vehicle->imagename) ){
                            $imagepath = JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/vehicle-image.png';
                            $arrow_flag = 0;
                        }else{
                            $imagepath = $vehicle->filepath.'ms_'.$vehicle->imagename;
                        }
                        do_action('jsvm_featuredvehicle_vehiclelist_feature_icon',$vehicle); ?>
                        <div class="jsvehiclemanager_vehicle_wrapper <?php if(in_array($vehicle->id,$compareVehicleList)) echo 'jsvehiclemanager_cmp_sel_wrapper'; ?>">
                            <div class="jsvehiclemanager_vehicle_top_wrap">
                                <div class="jsvehiclemanager_vehicle_slide_wrap">
                                    <div class="jsvehiclemanager_vehicle_slide_image">
                                        <a href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehicledetail', 'jsvehiclemanagerid'=>$vehicle->vehicleid, 'jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid()))); ?>">
                                            <img class="big-image" src="<?php echo esc_url($imagepath); ?>" id="jsvehiclemanager-big-image-<?php echo esc_attr($vehicle->id); ?>">
                                        </a>
                                        <?php if($arrow_flag == 1){?>
                                            <span class="jsvehiclemanager_vehicle_slide_left_arrow" onclick="showImageSlide(<?php echo esc_attr($vehicle->id)?>,true);">
                                            <img class="jsvehiclemanager_vehicle_logo" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>/includes/images/shortlisted-veh/left-arrow.png" title="<?php echo __('Previous Image'); ?>" /></span>
                                            <span class="jsvehiclemanager_vehicle_slide_right_arrow" onclick="showImageSlide(<?php echo esc_attr($vehicle->id)?>);">
                                            <img class="jsvehiclemanager_vehicle_logo" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>/includes/images/shortlisted-veh/right-arrow.png" title="<?php echo __('Next Image'); ?>" /></span>
                                        <?php } ?>
                                        <?php do_action('jsvm_vehiclelist_mark_vehicle_sold',$vehicle); ?>
                                    </div>
                                </div>
                                <div class="jsvehiclemanager_vehicle_right_content">
                                    <div class="jsvehiclemanager_vehicle_content_top_row">
                                        <span class="jsvehiclemanager_vehicle_title">
                                            <a href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehicledetail', 'jsvehiclemanagerid'=>$vehicle->vehicleid, 'jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid()))); ?>">
                                                <span class="title"><?php
                                                    echo wp_kses(JSVEHICLEMANAGERincluder::getJSModel('common')->returnVehicleTitle($vehicle->maketitle,$vehicle->modeltitle,$vehicle->modelyeartitle), JSVEHICLEMANAGER_ALLOWED_TAGS);

                                                ?></span>
                                            </a>
                                        </span>
                                        <span class="jsvehiclemanager_vehicle_price">
                                            <span class="price">
                                            <?php $v_price = JSVEHICLEMANAGERincluder::getJSModel('common')->getPrice($vehicle->price,$vehicle->currencysymbol, $vehicle->isdiscount, $vehicle->discounttype, $vehicle->discount, $vehicle->discountstart, $vehicle->discountend); ?>
                                             <?php echo wp_kses($v_price, JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="jsvehiclemanager_vehicle_detail_row">
                                        <span class="jsvehiclemanager_vehicle_create_date">
                                            <?php
                                               echo esc_html(date_i18n(jsvehiclemanager::$_config['date_format'],strtotime($vehicle->created)));
                                             ?>
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

                                <?php do_action('jsvm_featuredvehicle_vehiclelist_show_stock_color',$vehicle);?>

                                    <div class="jsvehiclemanager_vehicle_detail_row">
                                        <span class="jsvehiclemanager_vehicle_loction_title"><?php echo esc_html(__(jsvehiclemanager::$_data['fields']['locationcity'],'js-vehicle-manager')).': '; ?></span>
                                        <span class="jsvehiclemanager_vehicle_location_value"><?php echo __($vehicle->location,'js-vehicle-manager');?></span>
                                    </div>
                                    <?php
                                        $customfields = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->userFieldsData(1,10,1);// 10 for main section of vehicle
                                        foreach($customfields AS $field){
                                            $array = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->showCustomFields($field, 2,$vehicle->params); ?>
                                            <div class="jsvehiclemanager_vehicle_detail_row">
                                                <span class="jsvehiclemanager_vehicle_loction_title"><?php echo esc_html(__($array[0],'js-vehicle-manager')).': '; ?></span>
                                                <span class="jsvehiclemanager_vehicle_location_value"><?php echo esc_html(__($array[1],'js-vehicle-manager'));?></span>
                                            </div>
                                            <?php
                                        }
                                    ?>
                                    <?php if(checkLinks('vehiclelist_sellerimage')==true && !empty($vehicle->sellerphoto) ): ?>
                                    <div class="jsvehiclemanager_vehicle_status">
                                        <a href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'user','jsvmlt'=>'viewsellerinfo','jsvehiclemanagerid'=>$vehicle->sellerid,'jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid()))); ?>">
                                            <img class="jsvehiclemanager_vehicle_logo" src="<?php echo esc_url($vehicle->sellerphoto); ?>" title="<?php echo __('View Seller Info','js-vehicle-manager'); ?>" alt="<?php echo __('Seller Photo','js-vehicle-manager'); ?>" />
                                        </a>
                                    </div>
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="jsvehiclemanager_vehicle_bottom_wrap" class="jsvehiclemanager_frontend">
                                <div class="jsvehiclemanager_vehicle_left">
                                    <div class="jsvehiclemanager_vehicle_option">
                                        <span class="jsvehiclemanager_vehicle_condions_new" style="background:#fff;font-weight:bold;color:<?php echo esc_attr($vehicle->conditioncolor);?>;border:1px solid <?php echo esc_html($vehicle->conditioncolor);?>;">
                                          <?php echo esc_html(__($vehicle->conditiontitle,'js-vehicle-manager'));?>
                                        </span>
                                    </div><!--menu box-->
                                    <?php if(trim($vehicle->transmissiontitle) != ''){ ?>
                                        <div class="jsvehiclemanager_vehicle_option">
                                            <span class="manual_box"><?php echo esc_html(__($vehicle->transmissiontitle,'js-vehicle-manager'));?></span>
                                        </div><!--menu box-->

                                    <?php
                                        }
                                        if(trim($vehicle->fueltypetitle) != ''){ ?>
                                        <div class="jsvehiclemanager_vehicle_option">
                                            <span class="petrol_box"><?php echo esc_html(__($vehicle->fueltypetitle,'js-vehicle-manager'));?></span>
                                        </div><!--menu box-->
                                    <?php
                                        }
                                        if(trim($vehicle->mileages) != ''){ ?>
                                        <div class="jsvehiclemanager_vehicle_option">
                                            <span class="milage_box"><?php echo esc_html(__($vehicle->mileages,'js-vehicle-manager'))." ".__($vehicle->mileagesymbol,'js-vehicle-manager');?></span>
                                        </div><!--menu box-->
                                    <?php
                                        }
                                        if(trim($vehicle->enginecapacity) != ''){ ?>
                                        <div class="jsvehiclemanager_vehicle_option">
                                            <span class="model_box"><?php echo esc_html(__($vehicle->enginecapacity,'js-vehicle-manager'))." ".__("CC",'js-vehicle-manager');?></span>
                                        </div><!--menu box-->
                                        <?php } ?>
                                </div><!--left side-->
                                <div class="jsvehiclemanager_vehicle_right_button">
                                    <div class="jsvehiclemanager_vehicle_button_area">
                                    <?php do_action('jsvm_vehiclelist_bottom_btns', $vehicle,$compareVehicleList); // For tell a friend button, compare vehicle; ?>
                                    </div>
                                </div>
                            </div><!--bottom row -->
                        </div><!--jsvehiclemanager_admin_wrapper -->
                <?php
                    $noofvehicles++;
                    $html = apply_filters("jsvm_adsense_show_adsense_vehiclelist",'',$noofvehicles);
                    echo wp_kses($html, JSVEHICLEMANAGER_ALLOWED_TAGS);
                    } ?>
                        </div>
                        <?php
                        $nextpage = JSVEHICLEMANAGERpagination::$_currentpage + 1;
                        ?>
                        <a id="jsvehiclemanager-showmoreautoz" class="jsvehiclemanager-scrolltask" data-scrolltask="getNexttemplateVehicles" data-offset="<?php echo esc_attr($nextpage); ?>" data-showmore="0" style="display:none;"></a>

                        <div class="jsvehiclemanager_light-box-loading" style="display:none;" >
                            <img class="jsvehiclemanager_mainimage" src="<?php echo esc_attr(JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/load.gif');?>" title="<?php echo esc_attr(__('Loading','js-vehicle-manager'));?>" alt="<?php echo esc_attr(__('Loading','js-vehicle-manager'));?>" />
                        </div>
            <?php
            // if (jsvehiclemanager::$_data[1]) {
            //     echo '<div class="jsvehiclemanager-pagination">' . jsvehiclemanager::$_data[1] . '</div>';
            // }
        } else {
            $msg = __('No record found','js-vehicle-manager');
            echo wp_kses(JSVEHICLEMANAGERlayout::getNoRecordFound($msg), JSVEHICLEMANAGER_ALLOWED_TAGS);
        }
        ?>
    </div>
<?php
}
?>
</div>
