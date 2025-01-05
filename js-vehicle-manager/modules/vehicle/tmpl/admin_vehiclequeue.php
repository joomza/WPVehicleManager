<?php
if(!defined('ABSPATH'))
    die('Restricted Access');
$categoryarray = array(
    (object) array('id' => 1, 'text' => __('Make', 'js-vehicle-manager')),
    (object) array('id' => 2, 'text' => __('Price', 'js-vehicle-manager')),
    (object) array('id' => 3, 'text' => __('Transmission', 'js-vehicle-manager')),
    (object) array('id' => 4, 'text' => __('Fuel', 'js-vehicle-manager')),
    (object) array('id' => 5, 'text' => __('Model Year', 'js-vehicle-manager')),
    (object) array('id' => 6, 'text' => __('Created', 'js-vehicle-manager'))
);

if(jsvehiclemanager::$_config['date_format'] == 'd-m-Y' ){
    $date_format_string = 'd/F/Y';
}elseif(jsvehiclemanager::$_config['date_format'] == 'm/d/Y'){
    $date_format_string = 'F/d/Y';
}elseif(jsvehiclemanager::$_config['date_format'] == 'Y-m-d'){
    $date_format_string = 'Y/F/d';
}
?>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        var sellers = <?php echo isset(jsvehiclemanager::$_data['filter']['sellers']) ? jsvehiclemanager::$_data['filter']['sellers'] : "''" ?>;
        getTokenInputSellers(sellers);
        // Filter show hide
        jQuery("span#jsvm_showhidefilter").click(function (e) {
            e.preventDefault();
            var img2 = "<?php echo JSVEHICLEMANAGER_PLUGIN_URL . "includes/images/filter-up.png"; ?>";
            var img1 = "<?php echo JSVEHICLEMANAGER_PLUGIN_URL . "includes/images/filter-down.png"; ?>";
            if (jQuery('.jsvm_default-hidden').is(':visible')) {
                jQuery(this).find('img').attr('src', img1);
            } else {
                jQuery(this).find('img').attr('src', img2);
            }
            jQuery(".jsvm_default-hidden").toggle();
            var height = jQuery(this).height();
            var imgheight = jQuery(this).find('img').height();
            var currenttop = (height - imgheight) / 2;
            jQuery(this).find('img').css('top', currenttop);
        });
    });
</script>

<div id="jsvehiclemanageradmin-wrapper">
    <div id="jsvehiclemanageradmin-leftmenu">
        <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </div>
    <div id="jsvehiclemanageradmin-data">
        <?php
        $msgkey = JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getMessagekey();
        JSVEHICLEMANAGERmessages::getLayoutMessage($msgkey);
        ?>
        <span class="jsvm_js-admin-title">
            <a class="jsvm_js-admin-title-left" href="<?php echo esc_url(admin_url('admin.php?page=jsvehiclemanager')); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" />
                <?php echo __('Vehicle Approval Queue', 'js-vehicle-manager'); ?>
            </a>
            <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
        </span>
        <div class="jsvm_page-actions">
            <label class="jsvm_js-bulk-link button" for="jsvm_selectall"><input type="checkbox" name="jsvm_selectall" id="jsvm_selectall" value=""><?php echo __('Select All', 'js-vehicle-manager') ?></label>
            <a class="jsvm_js-bulk-link button jsvm_multioperation" message="<?php echo esc_attr(JSVEHICLEMANAGERmessages::getMSelectionEMessage()); ?>" confirmmessage="<?php echo __('Are you sure to delete', 'js-vehicle-manager').' ?'; ?>" data-for="remove" href="#"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/delete-icon.png" /><?php echo __('Delete', 'js-vehicle-manager') ?></a>
                <?php

            $image1 = JSVEHICLEMANAGER_PLUGIN_URL . "includes/images/up.png";
            $image2 = JSVEHICLEMANAGER_PLUGIN_URL . "includes/images/down.png";
            if (jsvehiclemanager::$_data['sortby'] == 1) {
                $image = $image1;
            } else {
                $image = $image2;
            }
            ?>
            <span class="jsvm_sort">
                <span class="jsvm_sort-text"><?php echo __('Sort by', 'js-vehicle-manager'); ?>:</span>
                <span class="jsvm_sort-field"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('jsvm_sorting', $categoryarray, jsvehiclemanager::$_data['combosort'], '', array('class' => 'inputbox', 'onchange' => 'changeCombo();')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></span>
                <a class="jsvm_sort-icon" href="#" data-image1="<?php echo esc_attr($image1); ?>" data-image2="<?php echo esc_attr($image2); ?>" data-sortby="<?php echo esc_attr(jsvehiclemanager::$_data['sortby']); ?>"><img id="jsvm_sortingimage" src="<?php echo esc_attr($image); ?>" /></a>
            </span>
            <script type="text/javascript">
                function changeSortBy() {
                    var value = jQuery('a.jsvm_sort-icon').attr('data-sortby');
                    var img = '';
                    if (value == 1) {
                        value = 2;
                        img = jQuery('a.jsvm_sort-icon').attr('data-image2');
                    } else {
                        img = jQuery('a.jsvm_sort-icon').attr('data-image1');
                        value = 1;
                    }
                    jQuery("img#jsvm_sortingimage").attr('src', img);
                    jQuery('input#sortby').val(value);
                    jQuery('form#jsvehiclemanagerform').submit();
                }
                jQuery('a.jsvm_sort-icon').click(function (e) {
                    e.preventDefault();
                    changeSortBy();
                });
                function changeCombo() {
                    jQuery("input#sorton").val(jQuery('select#jsvm_sorting').val());
                    changeSortBy();
                }
            </script>

        </div>
        <script type="text/javascript">
            function resetFrom() {
                jQuery("select#status").val('');
                jQuery("select#condition").val('');
                jQuery("select#transmission").val('');
                jQuery("select#fueltype").val('');
                jQuery("select#mileage").val('');
                jQuery("select#make").val('');
                jQuery("select#model").val('');
                jQuery("input#pricestrat").val('');
                jQuery("input#priceend").val('');
                jQuery("select#isgfcombo").val('1');
                jQuery('input#jsvm_sellers').tokenInput("clear");
                jQuery("form#jsvehiclemanagerform").submit();
            }
        </script>
        <form class="jsvm_js-filter-form" name="jsvehiclemanagerform" id="jsvehiclemanagerform" method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_vehicle&jsvmlt=vehiclequeue")); ?>">
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('make', JSVEHICLEMANAGERincluder::getJSModel('make')->getMakeForCombo(), jsvehiclemanager::$_data['filter']['make'], __('Select make', 'js-vehicle-manager'), array('class' => 'inputbox','onchange' => 'getmodels(\'model\', this.value);')), JSVEHICLEMANAGER_ALLOWED_TAGS);?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('model', JSVEHICLEMANAGERincluder::getJSModel('model')->getVehiclesModelsbyMakeId(jsvehiclemanager::$_data['filter']['make']), jsvehiclemanager::$_data['filter']['model'], __('Select model', 'js-vehicle-manager'), array('class' => 'inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <img id="makemodelloading-gif" style="display:none;float:left" src="<?php echo CAR_MANAGER_IMAGE;?>/makemodelloading.gif" />
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('isgfcombo', JSVEHICLEMANAGERincluder::getJSModel('common')->getShowAllCombo(), jsvehiclemanager::$_data['filter']['isgfcombo'], '', array('class' => 'inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('condition', JSVEHICLEMANAGERincluder::getJSModel('conditions')->getConditionForCombo(), jsvehiclemanager::$_data['filter']['condition'], __('Select condition', 'js-vehicle-manager'), array('class' => 'inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('transmission', JSVEHICLEMANAGERincluder::getJSModel('transmissions')->getTransmissionsForCombo(), jsvehiclemanager::$_data['filter']['transmission'], __('Select transmission', 'js-vehicle-manager'), array('class' => 'inputbox jsvm_default-hidden')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('fueltype', JSVEHICLEMANAGERincluder::getJSModel('fueltypes')->getFueltypeForCombo(), jsvehiclemanager::$_data['filter']['fueltype'], __('Select fuel type', 'js-vehicle-manager'), array('class' => 'inputbox jsvm_default-hidden')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('mileage', JSVEHICLEMANAGERincluder::getJSModel('mileages')->getMileagesForCombo(), jsvehiclemanager::$_data['filter']['mileage'], __('Select mileage', 'js-vehicle-manager'), array('class' => 'inputbox jsvm_default-hidden')), JSVEHICLEMANAGER_ALLOWED_TAGS);?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('pricestrat', jsvehiclemanager::$_data['filter']['pricestrat'], array('class' => 'inputbox jsvm_default-hidden', 'placeholder' => __('Start price', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('priceend', jsvehiclemanager::$_data['filter']['priceend'], array('class' => 'inputbox jsvm_default-hidden', 'placeholder' => __(' End price', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <div id="jsvehiclemanager-formseller-admin" class="jsvm_default-hidden"><input type="text" id="jsvm_sellers" name="uid" /></div>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('JSVEHICLEMANAGER_form_search', 'JSVEHICLEMANAGER_SEARCH'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::submitbutton('btnsubmit', __('Search', 'js-vehicle-manager'), array('class' => 'button')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::button('reset', __('Reset', 'js-vehicle-manager'), array('class' => 'button', 'onclick' => 'resetFrom();')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>

            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('sortby', jsvehiclemanager::$_data['sortby']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('sorton', jsvehiclemanager::$_data['sorton']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>

            <span id="jsvm_showhidefilter"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/filter-down.png"/></span>
        </form>
        <?php if (!empty(jsvehiclemanager::$_data[0])) { ?>
            <form id="jsvehiclemanager-list-form" method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_vehicle")); ?>">
                <?php
                    $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum', 'get', 1);
                    $pageid = ($pagenum > 1) ? '&pagenum=' . $pagenum : '';
                    $islastordershow = JSVEHICLEMANAGERpagination::isLastOrdering(jsvehiclemanager::$_data['total'], $pagenum);
                    for ($i = 0, $n = count(jsvehiclemanager::$_data[0]); $i < $n; $i++) {
                        $row = jsvehiclemanager::$_data[0][$i];
                            $upimg = 'uparrow.png';
                            $downimg = 'downarrow.png';
                        ?>
                        <div id="jsvehiclemanager_vehicle_wrapper">
                            <div id="jsvehiclemanager_vehicle_tags">
                                <?php
                                $arr = array();
                                if(in_array('featuredvehicle',jsvehiclemanager::$_active_addons)){
                                    if ($row->isfeaturedvehicle == 0) { ?>
                                       <div id="jsvehiclemanager_featured_tag">
                                           <?php echo __('Feature pending', 'js-vehicle-manager'); ?>
                                        </div>
                                        <?php
                                        $arr['feature'] = 1;
                                    }
                                }
                                if ($row->status == 0) {
                                    $arr['self'] = 1;
                                }
                                ?>
                            </div>
                            <div id="jsvehiclemanager_vehicle_top_wrap">
                                <div id="jsvehiclemanager_vehicle_slide_wrap">
                                    <?php
                                    if ($row->imagename !='') { ?>
                                        <img src="<?php echo esc_url($row->filepath.'ms_'.$row->imagename); ?>" class="jsvehiclemanager_vehicle_slide_img" />
                                    <?php
                                    }else{ ?>
                                        <img src="<?php echo CAR_MANAGER_IMAGE."/vehicle-image.png";?>" class="jsvehiclemanager_vehicle_slide_img" />
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div id="jsvehiclemanager_vehicle_right_content">
                                    <div id="jsvehiclemanager_vehicle_content_top_row">
                                        <div id="jsvehiclemanager_vehicle_title">
                                            <input type="checkbox" class="jsvehiclemanager-cb" id="jsvehiclemanager-cb" name="jsvehiclemanager-cb[]" value="<?php echo esc_html($row->vehicleid); ?>" />
                                            <a href="<?php echo esc_url(admin_url('admin.php?page=jsvm_vehicle&jsvmlt=formvehicle&jsvehiclemanagerid='.$row->vehicleid.' ')); ?>">
                                                <span id="jsvm_title">
                                                    <?php
                                                        if(jsvehiclemanager::$_car_manager_theme == 1){
                                                            echo wp_kses(car_manager_ReturnVehcileTitle($row->maketitle, $row->modeltitle, $row->modelyeartitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                                        }else{
                                                            echo wp_kses(JSVEHICLEMANAGERincluder::getJSModel('common')->returnVehicleTitle($row->maketitle, $row->modeltitle, $row->modelyeartitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                                        }
                                                    ?>
                                                </span>
                                            </a>
                                        </div>
                                        <div id="jsvehiclemanager_vehicle_price">
                                            <span id="jsvm_price">
                                                <?php echo wp_kses(JSVEHICLEMANAGERincluder::getJSModel('common')->getPrice($row->price,$row->currencysymbol, $row->isdiscount, $row->discounttype, $row->discount, $row->discountstart, $row->discountend), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div id="jsvehiclemanager_vehicle_detail_row">
                                        <span id="jsvehiclemanager_vehicle_create_date">
                                            <?php
                                               echo esc_html(date_i18n($date_format_string,strtotime($row->created)));
                                             ?>
                                        </span>
                                    </div>
                                    <div id="jsvehiclemanager_vehicle_detail_row">
                                        <span id="jsvehiclemanager_vehicle_title"><?php echo __("Fuel Consumption:",'js-vehicle-manager');?></span>
                                        <span id="jsvehiclemanager_vehicle_value"><?php echo esc_html(__($row->cityfuelconsumption,'js-vehicle-manager'))." ".esc_html(__($row->mileagesymbol,'js-vehicle-manager'))." ".__("City",'js-vehicle-manager')." / ".__($row->highwayfuelconsumption,'js-vehicle-manager')." ".__($row->mileagesymbol,'js-vehicle-manager')." ".__("Highway",'js-vehicle-manager');?></span>
                                    </div>
                                    <div id="jsvehiclemanager_vehicle_detail_row">
                                        <span id="jsvehiclemanager_vehicle_title"><?php echo __("Location:",'js-vehicle-manager'); ?></span>
                                        <span id="jsvehiclemanager_vehicle_value"><?php echo esc_html($row->location);?></span>
                                    </div>
                                    <?php
                                        $customfields = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->userFieldsData(1,10,1);// 10 for main section of vehicle
                                        foreach($customfields AS $field){
                                            $array = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->showCustomFields($field, 2,$row->params); ?>
                                            <div id="jsvehiclemanager_vehicle_detail_row">
                                                <span id="jsvehiclemanager_vehicle_title"><?php echo esc_html(__($array[0],'js-vehicle-manager')).": "; ?></span>
                                                <span id="jsvehiclemanager_vehicle_value"><?php echo esc_html($array[1]);?></span>
                                            </div>
                                        <?php
                                        }
                                    ?>
                                    <div id="jsvehiclemanager_vehicle_status">
                                            <?php
                                            $date = $row->adexpiryvalue;
                                            if(date('Y-m-d',strtotime($date)) >= date('Y-m-d')){
                                                echo "<span class='jsvehiclemanager_vehicle_status_value jsvm_publish'>";
                                                    echo __("Publish",'js-vehicle-manager');
                                                echo"</span>";
                                            }else{
                                                echo "<span class='jsvehiclemanager_vehicle_status_value'>";
                                                    echo __("Expired",'js-vehicle-manager');
                                                echo"</span>";
                                            }
                                            ?>
                                            <div class='jsvm_showexpriy_date_listing_admin'>
                                              <?php echo __('Expiry Date','js-vehicle-manager').': '.esc_html(date_i18n($date_format_string,strtotime($row->adexpiryvalue))); ?>
                                            </div>
                                            <?php
                                            if($row->sellerphoto != ''){
                                                $simg = '<a href ="'.esc_url(admin_url('admin.php?page=jsvm_user&jsvmlt=profile&jsvehiclemanagerid='.$row->sellerid)).'" >
                                                            <img src="'. esc_url($row->sellerphoto)  .'" />
                                                        </a>';
                                            ?>
                                                <div id="jsvehiclemanager_vehicle_img">
                                                    <?php echo $simg; ?>
                                                </div>
                                            <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div id="jsvehiclemanager_vehicle_bottom_wrap">
                                <div id="jsvehiclemanager_vehicle_left">
                                    <div id="jsvehiclemanager_vehicle_option">
                                        <span id="jsvehiclemanager_vehicle_condions_new" style="color:<?php echo esc_attr($row->conditioncolor); ?>;border:1px solid <?php echo esc_html($row->conditioncolor);?>" >
                                          <?php echo esc_html(__($row->conditiontitle,'js-vehicle-manager'));?>
                                        </span>
                                    </div><!--menu box-->
                                    <?php if(trim($row->transmissiontitle) != ''){ ?>
                                    <div id="jsvehiclemanager_vehicle_option">
                                        <span id="jsvm_manual_box"><?php echo esc_html(__($row->transmissiontitle,'js-vehicle-manager'));?></span>
                                    </div><!--menu box-->
                                    <?php
                                    }
                                    if(trim($row->fueltypetitle) != ''){ ?>
                                        <div id="jsvehiclemanager_vehicle_option">
                                            <span id="jsvm_manual_box"><?php echo esc_html(__($row->fueltypetitle,'js-vehicle-manager'));?></span>
                                        </div><!--menu box-->
                                    <?php } ?>
                                    <?php if(trim($row->mileages) != ''){ ?>
                                    <div id="jsvehiclemanager_vehicle_option">
                                        <span id="jsvm_manual_box"><?php echo esc_html(__($row->mileages,'js-vehicle-manager'))." ".esc_html(__($row->mileagesymbol,'js-vehicle-manager'));?></span>
                                    </div><!--menu box-->

                                    <?php } ?>
                                    <?php if(trim($row->enginecapacity) != ''){ ?>
                                    <div id="jsvehiclemanager_vehicle_option">
                                        <span id="jsvm_manual_box"><?php echo esc_html(__($row->enginecapacity,'js-vehicle-manager'))." ".__("CC",'js-vehicle-manager');?></span>
                                    </div><!--menu box-->
                                    <?php } ?>
                                </div><!--left side-->
                                <div id="jsvehiclemanager_vehicle_right_button">
                                    <div id="jsvehiclemanager_vehicle_button_area">
                                        <?php
                                        $t = count($arr);
                                        if( $t == 1 ){
                                            if(isset($arr['feature'])){ ?>
                                                <a id="jsvehiclemanager_vehicle_btn" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_featuredvehicle&task=approvequeuefeaturedvehicle&action=jsvmtask&id='.$row->vehicleid.$pageid.'&jsvmlt=vehiclequeue'),'approve-vehicle')); ?>">
                                                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/approve-h.png">
                                                    <span id="jsvehiclemanager_vehicle_btn_title"><?php echo __("Approve",'js-vehicle-manager'); ?></span>
                                                </a>
                                            <?php
                                            }
                                            if(isset($arr['self'])){ ?>
                                                <a id="jsvehiclemanager_vehicle_btn" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_vehicle&task=approvequeuevehicle&action=jsvmtask&id='.$row->vehicleid.$pageid.'&jsvmlt=vehiclequeue'),'approve-vehicle')); ?>">
                                                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/approve-h.png">
                                                    <span id="jsvehiclemanager_vehicle_btn_title"><?php echo __("Approve",'js-vehicle-manager'); ?></span>
                                                </a>
                                            <?php
                                            }
                                        }else{ ?>
                                            <div class="jsvehiclemanager_vehicle_btn jsvehiclemanagerqueue-approvalqueue" onmouseover="approveActionPopup(<?php echo esc_attr($row->vehicleid); ?>);" onmouseout="hideThis(this);">
                                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/approve-h.png">
                                                <span id="jsvehiclemanager_vehicle_btn_title"><?php echo __("Approve",'js-vehicle-manager'); ?></span>
                                                <div class="jsvehiclemanagerqueueapprove_<?php echo esc_attr($row->vehicleid); ?>" id="js-vehicle-manager-vehiclequeue-actionsbtn">
                                                    <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_vehicle&task=approvequeuevehicle&action=jsvmtask&id='.$row->vehicleid.$pageid.'&jsvmlt=vehiclequeue'),'approve-vehicle')); ?>" class="jsvehiclemanager-act-row" id="jsvehiclemanager-act-row">
                                                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/vehicle-logo.png">
                                                        <span id="jsvehiclemanager_vehicle_btn_title"><?php echo __("Vehicle Approve",'js-vehicle-manager'); ?></span>
                                                    </a>
                                                    <?php if(in_array('featuredvehicle',jsvehiclemanager::$_active_addons)){ ?>
                                                        <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_featuredvehicle&task=approvequeuefeaturedvehicle&action=jsvmtask&id='.$row->vehicleid.$pageid.'&jsvmlt=vehiclequeue'),'approve-vehicle')); ?>" class="jsvehiclemanager-act-row" id="jsvehiclemanager-act-row">
                                                            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/add-featured.png" class="jsvm_action-image">
                                                            <span id="jsvehiclemanager_vehicle_btn_title"><?php echo __("Feature Approve",'js-vehicle-manager'); ?></span>
                                                        </a>
                                                    <?php } ?>
                                                    <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_vehicle&task=approvequeueallvehicle&action=jsvmtask&id='.$row->vehicleid.$pageid.'&jsvmlt=vehiclequeue'),'approve-vehicle')); ?>"  class="jsvehiclemanager-act-row-all" id="jsvehiclemanager-act-row-all">
                                                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/select-all.png" class="jsvm_action-image">
                                                        <span id="jsvehiclemanager_vehicle_btn_title"><?php echo __("Approve Both",'js-vehicle-manager'); ?></span>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php
                                        }

                                        if($t == 1){
                                            if(isset($arr['feature'])){ ?>
                                                <a id="jsvehiclemanager_vehicle_btn" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_featuredvehicle&task=rejectqueuefeaturedvehicle&action=jsvmtask&id='.$row->vehicleid.$pageid.'&jsvmlt=vehiclequeue'),'reject-vehicle')); ?>">
                                                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/reject-icon.png">
                                                    <span id="jsvehiclemanager_vehicle_btn_title"><?php echo __("Reject",'js-vehicle-manager'); ?></span>
                                                </a>
                                            <?php
                                            }
                                            if(isset($arr['self'])){ ?>
                                                <a id="jsvehiclemanager_vehicle_btn" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_vehicle&task=rejectqueuevehicle&action=jsvmtask&id='.$row->vehicleid.$pageid.'&jsvmlt=vehiclequeue'),'reject-vehicle')); ?>">
                                                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/reject-icon.png">
                                                    <span id="jsvehiclemanager_vehicle_btn_title"><?php echo __("Reject",'js-vehicle-manager'); ?></span>
                                                </a>
                                            <?php
                                            }
                                        }else{ ?>
                                            <div class="jsvehiclemanager_vehicle_btn jsvehiclemanagerqueue-approvalqueue" onmouseover="rejectActionPopup(<?php echo esc_attr($row->vehicleid); ?>);" onmouseout="hideThis(this);">
                                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/reject-icon.png">
                                                <span id="jsvehiclemanager_vehicle_btn_title"><?php echo __("Reject",'js-vehicle-manager'); ?></span>
                                                <div class="jsvehiclemanagerqueuereject_<?php echo $row->vehicleid; ?>" id="js-vehicle-manager-vehiclequeue-actionsbtn">
                                                    <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_vehicle&task=rejectqueuevehicle&action=jsvmtask&id='.$row->vehicleid.$pageid.'&jsvmlt=vehiclequeue'),'reject-vehicle')); ?>" class="jsvehiclemanager-act-row" id="jsvehiclemanager-act-row">
                                                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/vehicle-logo.png" />
                                                        <span id="jsvehiclemanager_vehicle_btn_title"><?php echo __("Vehicle Reject",'js-vehicle-manager'); ?></span>
                                                    </a>
                                                    <?php if(in_array('featuredvehicle', jsvehiclemanager::$_active_addons)){ ?>
                                                        <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_featuredvehicle&task=rejectqueuefeaturedvehicle&action=jsvmtask&id='.$row->vehicleid.$pageid.'&jsvmlt=vehiclequeue'),'reject-vehicle')); ?>" class="jsvehiclemanager-act-row" id="jsvehiclemanager-act-row">
                                                            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/add-featured.png" class="jsvm_action-image" />
                                                            <span id="jsvehiclemanager_vehicle_btn_title"><?php echo __("Feature Reject",'js-vehicle-manager'); ?></span>
                                                        </a>
                                                    <?php } ?>
                                                    <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_vehicle&task=rejectqueueallvehicle&action=jsvmtask&id='.$row->vehicleid.$pageid.'&jsvmlt=vehiclequeue'),'reject-vehicle')); ?>"  class="jsvehiclemanager-act-row-all" id="jsvehiclemanager-act-row-all">
                                                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/select-all.png" class="jsvm_action-image" />
                                                        <span id="jsvehiclemanager_vehicle_btn_title"><?php echo __("Reject Both",'js-vehicle-manager'); ?></span>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php
                                        } ?>

                                        <a id="jsvehiclemanager_vehicle_btn" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_vehicle&task=remove&action=jsvmtask&fromqueue=1&jsvehiclemanager-cb[]='.$row->vehicleid),'delete-vehicle')); ?>" onclick="return confirmdelete('<?php echo __('Are you sure to delete', 'js-vehicle-manager').' ?'; ?>');">
                                            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/delete-icon.png">
                                            <span id="jsvehiclemanager_vehicle_btn_title"><?php echo __("Delete",'js-vehicle-manager'); ?></span>
                                        </a>
                                    </div>
                                </div>
                            </div><!--bottom row -->
                        </div><!--jsvehiclemanager_admin_wrapper -->
                <?php } ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('action', 'adexpiry_remove'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('pagenum', ($pagenum > 1) ? $pagenum : ''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('task', ''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('fromqueue', 1), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('form_request', 'jsvehiclemanager'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('_wpnonce', wp_create_nonce('delete-vehicle')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            </form>
            <?php
            if (jsvehiclemanager::$_data[1]) {
                echo '<div class="tablenav"><div class="tablenav-pages">' .  wp_kses_post(jsvehiclemanager::$_data[1]) . '</div></div>';
            }
        } else {
            $msg = __('No record found','js-vehicle-manager');
            $link[] = array(
                        'link' => 'admin.php?page=jsvm_vehicle&jsvmlt=formvehicle',
                        'text' => __('Add New','js-vehicle-manager') .' '. __('Vehicle','js-vehicle-manager')
                    );
            echo wp_kses(JSVEHICLEMANAGERlayout::getNoRecordFound($msg,$link), JSVEHICLEMANAGER_ALLOWED_TAGS);
        }
        ?>
    </div>
</div>
<script type="text/javascript">
    function getmodels(src, val){
        jQuery("img#makemodelloading-gif").show();
        var ajaxurl = "<?php echo esc_url(admin_url('admin-ajax.php')) ?>";
            jQuery.post(ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'model', task: 'getVehiclesModelsbyMake', makeid: val,wpnoncecheck:common.wp_vm_nonce}, function(data){
                if (data){
                   jQuery("#" + src).html(data); //retuen value
                }
                jQuery("img#makemodelloading-gif").hide();
            });
    }
</script>

<script type="text/javascript">

    function approveActionPopup(id) {
        var cname = '.jsvehiclemanagerqueueapprove_' + id;
        jQuery(cname).show();
        jQuery(cname).mouseout(function () {
            jQuery(cname).hide();
        });
    }

    function rejectActionPopup(id) {
        var cname = '.jsvehiclemanagerqueuereject_' + id;
        jQuery(cname).show();
        jQuery(cname).mouseout(function () {
            jQuery(cname).hide();
        });
    }

    function hideThis(obj) {
         jQuery(obj).find('div#js-vehicle-manager-vehiclequeue-actionsbtn').hide();
    }

    function getTokenInputSellers(seller) {
        var tagArray = '<?php echo admin_url("admin.php?page=jsvm_user&action=jsvmtask&task=getsellersbysellername"); ?>';
        jQuery("#jsvm_sellers").tokenInput(tagArray, {
            theme: "jsvehiclemanager",
            preventDuplicates: true,
            hintText: "<?php echo __('Type seller name', 'js-vehicle-manager'); ?>",
            noResultsText: "<?php echo __('No results', 'js-vehicle-manager'); ?>",
            searchingText: "<?php echo __('Searching', 'js-vehicle-manager'); ?>",
            placeholder: "<?php echo __('Select seller', 'js-vehicle-manager'); ?>",
            tokenLimit: 1,
            prePopulate: seller,
        });
    }
</script>
