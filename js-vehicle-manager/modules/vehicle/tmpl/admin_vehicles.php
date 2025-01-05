<?php
if(!defined('ABSPATH'))
    die('Restricted Access');
wp_register_script( 'picEyes.js', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/js/jquery.picEyes.js', array( 'jquery' ), false, true );
wp_enqueue_script( 'picEyes.js' );
wp_register_style( 'picEyes', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/css/jquery.picEyes.css', false, false, false );
wp_enqueue_style( 'picEyes' );

if(jsvehiclemanager::$_config['date_format'] == 'd-m-Y' ){
    $date_format_string = 'd/F/Y';
}elseif(jsvehiclemanager::$_config['date_format'] == 'm/d/Y'){
    $date_format_string = 'F/d/Y';
}elseif(jsvehiclemanager::$_config['date_format'] == 'Y-m-d'){
    $date_format_string = 'Y/F/d';
}
$categoryarray = array(
    (object) array('id' => 1, 'text' => __('Make', 'js-vehicle-manager')),
    (object) array('id' => 2, 'text' => __('Price', 'js-vehicle-manager')),
    (object) array('id' => 3, 'text' => __('Transmission', 'js-vehicle-manager')),
    (object) array('id' => 4, 'text' => __('Fuel', 'js-vehicle-manager')),
    (object) array('id' => 5, 'text' => __('Model Year', 'js-vehicle-manager')),
    (object) array('id' => 6, 'text' => __('Created', 'js-vehicle-manager'))
);
?>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        // token input seller
        var sellers = <?php echo isset(jsvehiclemanager::$_data['filter']['sellers']) ? jsvehiclemanager::$_data['filter']['sellers'] : "''" ?>;
        getTokenInputSellers(sellers);
        // Filter show hide
        jQuery("span#jsvm_showhidefilter").click(function (e) {
            e.preventDefault();
            jQuery(".jsvm_default-hidden").toggle();
            var height = jQuery(this).height();
            var imgheight = jQuery(this).find('img').height();
            var currenttop = (height - imgheight) / 2;
            jQuery(this).find('img').css('top', currenttop);
        });
    });
</script>

<script type="text/javascript">
function showLightBox(vehid){
    var ajaxurl = "<?php echo esc_url(admin_url('admin-ajax.php')) ?>";
    jQuery('div#jsvm_ajaxloaded_wait_overlay').show();
    jQuery('img#jsvm_ajaxloaded_wait_image').show();
    jQuery.post(ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'vehicle', task: 'getVehicleImagesByVehicleIdAJAX', vehicleid: vehid,wpnoncecheck:common.wp_vm_nonce}, function(data){
        if (data){
            var $array = jQuery.parseJSON(data);
            var ul = document.createElement('ul');
            jQuery($array).each(function( index, element ) {
                jQuery(element.image).each(function(i,e){
                    var li = document.createElement('li');
                    var img = document.createElement('img');
                    jQuery(img).addClass('jsvm_mainimage');
                    jQuery(img).attr('data-fuel',element.fueltype);
                    jQuery(img).attr('data-transmission',element.transmissiontitle);
                    jQuery(img).attr('data-price',element.price);
                    jQuery(img).attr('data-mileage',element.milage);
                    jQuery(img).attr('data-src',e.small);
                    jQuery(img).attr('data-src-main',e.main);
                    jQuery(img).attr('src',e.main);
                    jQuery(li).append(img);
                    jQuery(ul).append(li);
                });
            });
            jQuery('div#jsvm_light-box-wrapper').append(ul);
            jQuery(ul).find('li').picEyes({
                'fuelgage': '<?php echo CAR_MANAGER_IMAGE; ?>/light-box-milage.png',
                'transmission': '<?php echo CAR_MANAGER_IMAGE; ?>/light-box-transmission.png',
                'fueltype': '<?php echo CAR_MANAGER_IMAGE; ?>/light-box-fuel.png',

            });
            jQuery('div#jsvm_light-box-wrapper ul li img').click();
            jQuery('div#jsvm_ajaxloaded_wait_overlay').hide();
            jQuery('img#jsvm_ajaxloaded_wait_image').hide();
        }
    });
}
</script>
<div style="display:none;" id="jsvm_ajaxloaded_wait_overlay"></div>
<img style="display:none;" id="jsvm_ajaxloaded_wait_image" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/loading.gif'; ?>">

<div id="jsvm_light-box-wrapper" style="display:none;">
</div>
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
            <?php echo __(' Vehicles', 'js-vehicle-manager'); ?>
            </a>
            <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
            <a class="jsvm_js-button-link button" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_vehicle&jsvmlt=formvehicle')); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/add_icon.png" /><?php echo __('Add New','js-vehicle-manager') .' '. __('Vehicle' , 'js-vehicle-manager'); ?></a>
        </span>
        <div class="jsvm_page-actions">
            <label class="jsvm_js-bulk-link button" for="jsvm_selectall"><input type="checkbox" name="selectall" id="jsvm_selectall" value=""><?php echo __('Select All', 'js-vehicle-manager') ?></label>
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
                <a class="jsvm_sort-icon" href="#" data-image1="<?php echo esc_attr($image1); ?>" data-image2="<?php echo esc_attr($image2); ?>" data-sortby="<?php echo esc_attr(jsvehiclemanager::$_data['sortby']); ?>"><img id="jsvm_sortingimage" src="<?php echo esc_url($image); ?>" /></a>
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
        <form class="jsvm_js-filter-form" name="jsvehiclemanagerform" id="jsvehiclemanagerform" method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_vehicle")); ?>">
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('make', JSVEHICLEMANAGERincluder::getJSModel('make')->getMakeForCombo(), jsvehiclemanager::$_data['filter']['make'], __('Select make', 'js-vehicle-manager'), array('class' => 'inputbox','onchange' => 'getmodels(\'model\', this.value);')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('model', JSVEHICLEMANAGERincluder::getJSModel('model')->getVehiclesModelsbyMakeId(jsvehiclemanager::$_data['filter']['make']), jsvehiclemanager::$_data['filter']['model'], __('Select model', 'js-vehicle-manager'), array('class' => 'inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <img id="makemodelloading-gif" style="display:none;float:left" src="<?php echo CAR_MANAGER_IMAGE;?>/makemodelloading.gif" />
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('status', JSVEHICLEMANAGERincluder::getJSModel('common')->getListingStatus(), jsvehiclemanager::$_data['filter']['status'], __('Select status', 'js-vehicle-manager'), array('class' => 'inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('condition', JSVEHICLEMANAGERincluder::getJSModel('conditions')->getConditionForCombo(), jsvehiclemanager::$_data['filter']['condition'], __('Select condition', 'js-vehicle-manager'), array('class' => 'inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('transmission', JSVEHICLEMANAGERincluder::getJSModel('transmissions')->getTransmissionsForCombo(), jsvehiclemanager::$_data['filter']['transmission'], __('Select transmission', 'js-vehicle-manager'), array('class' => 'inputbox jsvm_default-hidden')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('fueltype', JSVEHICLEMANAGERincluder::getJSModel('fueltypes')->getFueltypeForCombo(), jsvehiclemanager::$_data['filter']['fueltype'], __('Select fuel type', 'js-vehicle-manager'), array('class' => 'inputbox jsvm_default-hidden')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('mileage', JSVEHICLEMANAGERincluder::getJSModel('mileages')->getMileagesForCombo(), jsvehiclemanager::$_data['filter']['mileage'], __('Select mileage type', 'js-vehicle-manager'), array('class' => 'inputbox jsvm_default-hidden')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('isgfcombo', JSVEHICLEMANAGERincluder::getJSModel('common')->getShowAllCombo(), jsvehiclemanager::$_data['filter']['isgfcombo'], '', array('class' => 'inputbox jsvm_default-hidden')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('pricestrat', jsvehiclemanager::$_data['filter']['pricestrat'], array('class' => 'inputbox jsvm_default-hidden', 'placeholder' => __('Start Price', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('priceend', jsvehiclemanager::$_data['filter']['priceend'], array('class' => 'inputbox jsvm_default-hidden', 'placeholder' => __(' End Price', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php $uid = JSVEHICLEMANAGERrequest::getVar('uid');?>
            <div id="jsvehiclemanager-formseller-admin" class="jsvm_default-hidden"><input type="text" id="jsvm_sellers" name="uid" value="<?php echo $uid;?>" /></div>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('JSVEHICLEMANAGER_form_search', 'JSVEHICLEMANAGER_SEARCH'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::submitbutton('btnsubmit', __('Search', 'js-vehicle-manager'), array('class' => 'button')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::button('reset', __('Reset', 'js-vehicle-manager'), array('class' => 'button', 'onclick' => 'resetFrom();')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('sortby', jsvehiclemanager::$_data['sortby']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('sorton', jsvehiclemanager::$_data['sorton']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>

            <span id="jsvm_showhidefilter"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/filter-down.png"/></span>
        </form>
        <?php
        if (!empty(jsvehiclemanager::$_data[0])) {
            ?>
            <form id="jsvehiclemanager-list-form" method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_vehicle")); ?>">
                <?php
                    $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum', 'get', 1);
                    $pageid = ($pagenum > 1) ? '&pagenum=' . $pagenum : '';
                    $islastordershow = JSVEHICLEMANAGERpagination::isLastOrdering(jsvehiclemanager::$_data['total'], $pagenum);
                    $dateformat = jsvehiclemanager::$_config['date_format'];
                    for ($i = 0, $n = count(jsvehiclemanager::$_data[0]); $i < $n; $i++) {
                        $row = jsvehiclemanager::$_data[0][$i];
                            $upimg = 'uparrow.png';
                            $downimg = 'downarrow.png';
                        $lightbox_flag = 0;
                        if($row->imagename == ''){
                            $imgpath = CAR_MANAGER_IMAGE."/vehicle-image.png";
                        }else{
                            $lightbox_flag = 1;
                            $imgpath = $row->filepath.'ms_'.$row->imagename;
                        }
                        ?>
                        <div id="jsvehiclemanager_vehicle_wrapper">
                            <?php do_action('jsvm_show_featured_tag',$row); ?>
                            <div id="jsvehiclemanager_vehicle_top_wrap">
                                <div id="jsvehiclemanager_vehicle_slide_wrap" class="<?php if($lightbox_flag == 1) echo ' jsvm_hover-pointer' ?>" <?php if($lightbox_flag == 1) echo 'onClick="showLightBox('.$row->vehicleid.');"'; ?> >
                                    <img src="<?php echo esc_url($imgpath); ?>" class="jsvehiclemanager_vehicle_slide_img" />
                                    <?php if($lightbox_flag == 1){ ?>
                                        <span class="jsvm_cm-sl-veh-left-txt" ><?php echo __('See','js-vehicle-manager').' '.esc_html($row->totalimages).' '. __('Photos','js-vehicle-manager');?></span>
                                    <?php } ?>
                                    <?php do_action('jsvm_vehiclelist_mark_vehicle_sold',$row); ?>
                                </div>
                                <div id="jsvehiclemanager_vehicle_right_content">
                                    <div id="jsvehiclemanager_vehicle_content_top_row">
                                        <div id="jsvehiclemanager_vehicle_title">
                                        <input type="checkbox" class="jsvehiclemanager-cb" id="jsvehiclemanager-cb" name="jsvehiclemanager-cb[]" value="<?php echo esc_attr($row->vehicleid); ?>" />
                                        <a href="<?php echo esc_url(admin_url('admin.php?page=jsvm_vehicle&jsvmlt=formvehicle&jsvehiclemanagerid='.$row->vehicleid.' ')); ?>">
                                            <span id="jsvm_title">
                                                <?php
                                                    if(jsvehiclemanager::$_car_manager_theme == 1){
                                                        echo wp_kses(car_manager_ReturnVehcileTitle($row->maketitle, $row->modeltitle, $row->modelyeartitle), JSVEHICLEMANAGER_ALLOWED_TAGS); 
                                                    }else{
                                                        echo  wp_kses(JSVEHICLEMANAGERincluder::getJSModel('common')->returnVehicleTitle($row->maketitle, $row->modeltitle, $row->modelyeartitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
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
                                        <span id="jsvehiclemanager_vehicle_title"><?php echo __("Seller",'js-vehicle-manager')." :  ";?></span>
                                        <span id="jsvehiclemanager_vehicle_value"><a class="jsvehiclemanager_vehicle_value_anchor" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_user&jsvmlt=profile&jsvehiclemanagerid='.$row->uid)); ?>"><?php echo esc_html(__($row->sellername,'js-vehicle-manager'));?></a></span>
                                    </div>
                                    <div id="jsvehiclemanager_vehicle_detail_row">
                                        <span id="jsvehiclemanager_vehicle_title"><?php echo __("Fuel Consumption",'js-vehicle-manager')." :  ";?></span>
                                        <span id="jsvehiclemanager_vehicle_value"><?php echo esc_html(__($row->cityfuelconsumption,'js-vehicle-manager'))." ".esc_html(__($row->mileagesymbol,'js-vehicle-manager'))." ".__("City",'js-vehicle-manager')." / ".esc_html(__($row->highwayfuelconsumption,'js-vehicle-manager'))." ".esc_html(__($row->mileagesymbol,'js-vehicle-manager'))." ".__("Highway",'js-vehicle-manager');?></span>
                                    </div>
                                    <div id="jsvehiclemanager_vehicle_detail_row">
                                        <span id="jsvehiclemanager_vehicle_title"><?php echo __("Location",'js-vehicle-manager')." : "; ?></span>
                                        <span id="jsvehiclemanager_vehicle_value"><?php echo esc_html(__($row->location,'js-vehicle-manager'));?></span>
                                    </div>
                                    <?php
                                        $customfields = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->userFieldsData(1,10,1);// 10 for main section of vehicle
                                        foreach($customfields AS $field){
                                            $array = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->showCustomFields($field, 2,$row->params); ?>
                                            <div id="jsvehiclemanager_vehicle_detail_row">
                                                <span id="jsvehiclemanager_vehicle_title"><?php echo esc_html(__($array[0],'js-vehicle-manager'))." : "; ?></span>
                                                <span id="jsvehiclemanager_vehicle_value"><?php echo esc_html($array[1]);?></span>
                                            </div>
                                        <?php
                                        }
                                    ?>
                                    <?php
                                        $date = $row->adexpiryvalue;
                                        if(date('Y-m-d',strtotime($date)) >= date('Y-m-d') && $row->status == 1){
                                            echo "<span class='jsvehiclemanager_vehicle_status_value jsvm_publish'>";
                                                echo __("Publish",'js-vehicle-manager');
                                            echo"</span>";
                                        }elseif($row->status == "-1"){
                                            echo "<span class='jsvehiclemanager_vehicle_status_value jsvm_rejected'>";
                                                echo __("Rejected",'js-vehicle-manager');
                                            echo"</span>";
                                        }else{
                                            echo "<span class='jsvehiclemanager_vehicle_status_value'>";
                                                echo __("Expired",'js-vehicle-manager');
                                            echo"</span>";
                                        }

                                    ?>
                                        <div class="jsvm_showexpriy_date_listing_admin">
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
                            <div id="jsvehiclemanager_vehicle_bottom_wrap">
                                <div id="jsvehiclemanager_vehicle_left">
                                    <div id="jsvehiclemanager_vehicle_option">
                                        <span id="jsvehiclemanager_vehicle_condions_new" style="color:<?php echo esc_attr($row->conditioncolor); ?>;border:1px solid <?php echo esc_attr($row->conditioncolor);?>" >
                                          <?php echo esc_html(__($row->conditiontitle,'js-vehicle-manager'));?>
                                        </span>
                                    </div>
                                    <?php
                                    if(trim($row->transmissiontitle)){ ?>
                                        <div id="jsvehiclemanager_vehicle_option">
                                            <span id="jsvm_manual_box"><?php echo esc_html(__($row->transmissiontitle,'js-vehicle-manager'));?></span>
                                        </div>
                                    <?php
                                    }
                                    if(trim($row->fueltypetitle)){ ?>
                                        <div id="jsvehiclemanager_vehicle_option">
                                            <span id="jsvm_manual_box"><?php echo esc_html(__($row->fueltypetitle,'js-vehicle-manager'));?></span>
                                        </div>
                                    <?php
                                    }
                                    if(trim($row->mileages) AND trim($row->mileagesymbol)){ ?>
                                        <div id="jsvehiclemanager_vehicle_option">
                                            <span id="jsvm_manual_box"><?php echo esc_html(__($row->mileages,'js-vehicle-manager'))." ".esc_html(__($row->mileagesymbol,'js-vehicle-manager'));?></span>
                                        </div>
                                    <?php
                                    }
                                    if(trim($row->enginecapacity)){ ?>
                                        <div id="jsvehiclemanager_vehicle_option">
                                            <span id="jsvm_manual_box"><?php echo esc_html(__($row->enginecapacity,'js-vehicle-manager'))." ".__("CC",'js-vehicle-manager');?></span>
                                        </div>
                                    <?php
                                    } ?>
                                </div>
                                <div id="jsvehiclemanager_vehicle_right_button">
                                    <div id="jsvehiclemanager_vehicle_button_area">
                                        <?php do_action('jsvm_admin_show_featured_vehicle_button',$row); ?>
                                        <a id="jsvehiclemanager_vehicle_btn" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_vehicle&task=remove&action=jsvmtask&jsvehiclemanager-cb[]='.$row->vehicleid),'delete-vehicle')); ?>" onclick="return confirmdelete('<?php echo __('Are you sure to delete', 'js-vehicle-manager').' ?'; ?>');">
                                            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/deleted-icon.png" title="<?php echo __('Delete','js-vehicle-manager');?>" />
                                            <span id="jsvehiclemanager_vehicle_btn_title"><?php echo __("Delete",'js-vehicle-manager'); ?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('action', 'adexpiry_remove'), JSVEHICLEMANAGER_ALLOWED_TAGS);?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('pagenum', ($pagenum > 1) ? $pagenum : ''), JSVEHICLEMANAGER_ALLOWED_TAGS);?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('task', ''), JSVEHICLEMANAGER_ALLOWED_TAGS);?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('form_request', 'jsvehiclemanager'), JSVEHICLEMANAGER_ALLOWED_TAGS);?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('_wpnonce', wp_create_nonce('delete-vehicle')), JSVEHICLEMANAGER_ALLOWED_TAGS);?>
            </form>
            <?php
            if (jsvehiclemanager::$_data[1]) {
                echo '<div class="tablenav"><div class="tablenav-pages">' . wp_kses_post(jsvehiclemanager::$_data[1]) . '</div></div>';
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
    jQuery(document).ready(function(){
        jQuery('div.jsvm_hover-pointer').hover(
            function(){
                jQuery(this).append('<div class="jsvm_cm_veh_image_overlay"></div>');
            },
            function(){
                jQuery(this).find('div.jsvm_cm_veh_image_overlay').remove();
            }
        );
    });
</script>
