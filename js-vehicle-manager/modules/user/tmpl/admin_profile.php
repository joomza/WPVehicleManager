<?php if (!defined('ABSPATH')) die('Restricted Access'); ?>

<div id="jsvehiclemanageradmin-wrapper">
    <div id="jsvehiclemanageradmin-leftmenu">
        <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </div>
    <div id="jsvehiclemanageradmin-data">
        <?php
        $msgkey = JSVEHICLEMANAGERincluder::getJSModel('user')->getMessagekey();
        JSVEHICLEMANAGERMessages::getLayoutMessage($msgkey);
        ?>
        <span class="jsvm_js-admin-title">
            <a class="jsvm_js-admin-title-left" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_user&jsvmlt=users')); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" />
                <?php echo __('User Profile', 'js-vehicle-manager') ?>
            </a>
        </span>
        <?php
        if (!empty(jsvehiclemanager::$_data['user'])) {
            $row = jsvehiclemanager::$_data['user'];
            $link = esc_url(admin_url('admin.php?page=jsvm_user&jsvmlt=formprofile&jsvehiclemanagerid=' . $row->id));
            if($row->photo){
                $logo = $row->photo;
            }else{
                $logo = JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/Users.png';
            }
            ?>
            <div id="jsvehiclemanager-seller-listing-wrap" class="jsvehiclemanager-viewprofile-page">
                <div id="jsvehiclemanager-seller-listing-limage">
                   <img src="<?php echo esc_url($logo); ?>" />
                </div>
                <div id="jsvehiclemanager-seller-listing-top-wrap">
                    <div id="jsvehiclemanager-seller-listing-heading-wrap">
                        <div id="jsvehiclemanager-seller-listing-heading">
                            <span id="jsvehiclemanager-seller-listing-heading-name">
                                <a href="<?php echo esc_url($link); ?>">
                                <?php echo esc_html(__($row->name,'js-vehicle-manager')); ?>
                                </a>
                            </span>
                            <?php
                            if($row->status == 1){
                                $status[0] = 'jsvm_active';
                                $status[1] = __('Active', 'js-vehicle-manager');
                            }else{
                                $status[0] = 'jsvm_disabled';
                                $status[1] = __('Disable', 'js-vehicle-manager');
                            } ?>
                            <span class="jsvehiclemanager-seller-listing-right">
                                <span class="jsvehiclemanager-seller-listing-heading-status <?php echo esc_attr($status[0]); ?>"><?php echo esc_html($status[1]); ?></span>
                                <span class="jsvehiclemanager-seller-listing-smedia-wrap">
                                    <?php  if($row->facebook !=''){
                                            if(!strstr($row->facebook, 'http')){
                                                $row->facebook = 'http://'.$row->facebook;
                                            }
                                    ?>
                                            <a class="jsvehiclemanager-seller-listing-smedia-links" href="<?php echo esc_url($row->facebook); ?>" target="_blank"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/facebook.png"></a>
                                    <?php   } ?>
                                    <?php if($row->twitter !=''){
                                            if(!strstr($row->twitter, 'http')) {
                                                $row->twitter = 'http://'.$row->twitter;
                                            }
                                    ?>
                                        <a class="jsvehiclemanager-seller-listing-smedia-links" href="<?php echo esc_url($row->twitter); ?>" target="_blank"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/twitter.png"></a>
                                    <?php } ?>
                                    <?php if($row->linkedin !='') {
                                            if(!strstr($row->linkedin, 'http')){
                                                $row->linkedin = 'http://'.$row->linkedin;
                                            }
                                    ?>
                                        <a class="jsvehiclemanager-seller-listing-smedia-links" href="<?php echo esc_url($row->linkedin); ?>" target="_blank"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/linkedin.png"> </a>
                                    <?php } ?>
                                    <?php if($row->googleplus !=''){
                                            if(!strstr($row->googleplus, 'http')){
                                                $row->googleplus = 'http://'.$row->googleplus;
                                            }
                                    ?>
                                        <a class="jsvehiclemanager-seller-listing-smedia-links" href="<?php echo esc_url($row->googleplus); ?>" target="_blank"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/google-plus.png"> </a>
                                    <?php } ?>
                                    <?php if($row->pinterest !=''){
                                            if(!strstr($row->pinterest,'http')){
                                                $row->pinterest = 'http://'.$row->pinterest;
                                            }
                                    ?>
                                        <a class="jsvehiclemanager-seller-listing-smedia-links" href="<?php echo esc_url($row->pinterest); ?>" target="_blank"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/pinterest.png"> </a>
                                    <?php } ?>
                                    <?php if($row->instagram !=''){
                                            if(!strstr($row->instagram, 'http')){
                                                $row->instagram = 'http://'.$row->instagram;
                                            }
                                    ?>
                                        <a class="jsvehiclemanager-seller-listing-smedia-links" href="<?php echo esc_url($row->instagram); ?>" target="_blank"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/instagram.png"></a>
                                    <?php } ?>
                                    <?php if($row->reddit !=''){
                                            if(!strstr($row->reddit, 'http')){
                                                $row->reddit = 'http://'.$row->reddit;
                                            }
                                    ?>
                                        <a class="jsvehiclemanager-seller-listing-smedia-links" href="<?php echo esc_url($row->reddit); ?>" target="_blank"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/reddit.png"></a>
                                    <?php } ?>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div id="jsvehiclemanager-seller-listing-data-wrap">
                        <div class="jsvehiclemanager-seller-listing-left">
                            <span class="jsvehiclemanager-seller-listing-data">
                                <span class="jsvehiclemanager-seller-listing-data-title"><?php echo __('Email','js-vehicle-manager'); ?>:</span>
                                <span class="jsvehiclemanager-seller-listing-data-value"><?php echo esc_html($row->email); ?></span>
                            </span>
                            <span class="jsvehiclemanager-seller-listing-data">
                                <span class="jsvehiclemanager-seller-listing-data-title"><?php echo __('Location','js-vehicle-manager'); ?>:</span>
                                <span class="jsvehiclemanager-seller-listing-data-value"><?php echo esc_html($row->location); ?></span>
                            </span>
                            <span class="jsvehiclemanager-seller-listing-data">
                                <span class="jsvehiclemanager-seller-listing-data-title"><?php echo __('Address','js-vehicle-manager'); ?>:</span>
                                <span class="jsvehiclemanager-seller-listing-data-value"><?php echo esc_html($row->address); ?></span>
                            </span>
                            <?php
                            $customfields = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->userFieldsData(2);// 10 for main section of vehicle
                            foreach($customfields AS $field){
                                $array = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->showCustomFields($field, 1,$row->params,1); ?>
                                <span class="jsvehiclemanager-seller-listing-data">
                                    <span class="jsvehiclemanager-seller-listing-data-title">
                                        <?php echo esc_html(__($array[0],'js-vehicle-manager'))." : "; ?>
                                    </span>
                                    <span class="jsvehiclemanager-seller-listing-data-value">
                                        <?php echo esc_html($array[1]);?>
                                    </span>
                                </span>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if(JSVEHICLEMANAGERincluder::getObjectClass('user')->isSellerCheck($row->id)){ ?>
                <div class="jsvm_user-stats-top">
                    <div class="jsvm_box">
                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/total.png">
                        <div class="jsvm_text">
                            <div class="jsvm_bold-text"><?php echo esc_html(jsvehiclemanager::$_data['totalvehicles']); ?></div>
                            <div class="jsvm_nonbold-text"><?php echo __('Total vehicles', 'js-vehicle-manager'); ?></div>
                        </div>
                    </div>
                    <?php do_action("jsvm_featuredvehicle_for_admin_profile",jsvehiclemanager::$_data['featuredvehicles']); ?>
                    <div class="jsvm_box">
                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/expired.png">
                        <div class="jsvm_text">
                            <div class="jsvm_bold-text"><?php echo esc_html(jsvehiclemanager::$_data['expiredvehicles']); ?></div>
                            <div class="jsvm_nonbold-text"><?php echo __('Expired vehicles', 'js-vehicle-manager'); ?></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="jsvehiclemanager-profileview-subhead"><?php echo __('Map' , 'js-vehicle-manager'); ?></div>
            <div id="jsvehiclemanager-profileview-subhead-map"><div id="jsvm_map_container" ></div></div>
            <div class="jsvehiclemanager-profileview-subhead"><?php echo __('Description' , 'js-vehicle-manager'); ?></div>
            <div id="jsvehiclemanager-profileview-subhead-description"><?php echo ($row->description) ? $row->description : __('None' , 'js-vehicle-manager'); ?></div>
            <div class="jsvehiclemanager-profileview-subhead"><?php echo __('Video' , 'js-vehicle-manager'); ?></div>
            <div id="jsvehiclemanager-profileview-subhead-video"><?php echo getRowForVideoView($row->video , $row->videotypeid); ?></div>
            <a id="jsvehiclemanager-profileview-button" href="<?php echo esc_url(admin_url("admin.php?page=jsvm_vehicle&jsvmlt=vehicles&uid=".$row->id)); ?>"><?php echo __('Show Seller Vehicles' , 'js-vehicle-manager'); ?></a>
            <?php
        } else {
            echo wp_kses(JSVEHICLEMANAGERlayout::getNoRecordFound(), JSVEHICLEMANAGER_ALLOWED_TAGS);
        }
        ?>
    </div>
</div>
<?php
function getRowForVideoView($value, $vtype){
        $html = '';
        if (!empty($value)) {
            parse_str(parse_url($value, PHP_URL_QUERY), $my_array_of_vars);
            if ($vtype == 1 && !empty($my_array_of_vars)) { // youtube video link
                $value = $my_array_of_vars['v'];
                $html .= '<object title="YouTube video player" width="100%;" height="400" data="https://www.youtube.com/embed/' . $value . '"></object>';        
            } else { //Embed code
                $html .= str_replace('\"', '', $value);
            }
        }
        return $html;
    }
?>
<style type="text/css">
    div#jsvm_map_container{
        height:300px;
        width:100%;
    }
</style>
<script type="text/javascript">
    jQuery(document).ready(function($){
        loadMap();
    });
</script>

<?php
$google_api_key = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('google_map_api_key');
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://"; ?>
<input type="hidden" id="default_longitude" name="default_longitude" value="<?php echo (isset($row->longitude) && $row->longitude !='' ) ? $row->longitude : esc_attr(jsvehiclemanager::$_config['default_longitude']); ?>"/>
<input type="hidden" id="default_latitude" name="default_latitude" value="<?php echo (isset($row->latitude) && $row->latitude !='' ) ? $row->latitude : esc_attr(jsvehiclemanager::$_config['default_latitude']); ?>"/>
<?php if(($row->latitude != '') && ($row->longitude != '') ){?>
        <input type="hidden" id="jsvm_addmarker" name="addmarker" value="1"/>
<? }else{?>
        <input type="hidden" id="jsvm_addmarker" name="addmarker" value="0"/>
<?php }

wp_enqueue_script('jsvm-repaptcha-scripti','https://maps.googleapis.com/maps/api/js?key='.$google_api_key);
?>

 <script type="text/javascript">

    function loadMap() {
        var default_latitude = document.getElementById('default_latitude').value;
        var default_longitude = document.getElementById('default_longitude').value;
        var latlng = new google.maps.LatLng(default_latitude, default_longitude);

        zoom = 10;
        var myOptions = {
            zoom: zoom,
            center: latlng,
            scrollwheel: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("jsvm_map_container"), myOptions);
        if(jQuery("input#jsvm_addmarker").val() == 1){
            addMarker(latlng);
        }
    }

    function addMarker(latlang){
        marker = new google.maps.Marker({
            position: latlang,
            map: map,
            center: latlang,
            draggable: true,
            scrollwheel: false,
        });
        marker.setMap(map);
    }
</script>
