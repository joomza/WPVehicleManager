<?php
if (!defined('ABSPATH')) die('Restricted Access');?>
<div id="jsvehiclemanager-main-up-wrapper">
<?php
$msgkey = JSVEHICLEMANAGERincluder::getJSModel('user')->getMessagekey();
JSVEHICLEMANAGERmessages::getLayoutMessage($msgkey);
JSVEHICLEMANAGERbreadcrumbs::getBreadcrumbs();
include_once(JSVEHICLEMANAGER_PLUGIN_PATH . 'includes/header.php');
if (jsvehiclemanager::$_error_flag == null) {


$seller = jsvehiclemanager::$_data[0];

//configuration
$cm_recaptcha_public_key = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('cm_recaptcha_public_key');
$cm_buyer_can_contact_seller = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('vehicle_buyercontactseller');
$google_api_key = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('google_map_api_key');


// funtion for youtube video
function getRowForVideoView($value, $vtype) {
    $html = '<div class="jsvehiclemanager_vehicle-detail-video">';
    if (!empty($value)) {
        parse_str(parse_url($value, PHP_URL_QUERY), $my_array_of_vars);
        if ($vtype == 1 && !empty($my_array_of_vars)) { // youtube video link
            $value = $my_array_of_vars['v'];
             $html .= '<object title="YouTube video player" width="100%;" height="400" data="https://www.youtube.com/embed/' . $value . '"></object>';        
        } else { //Embed code
            $html .= str_replace('\"', '', $value);
        }
    }
    $html .= '</div>';
    return $html;
}

?>
<div id="jsvehiclemanager-wrapper">
        <div class="control-pannel-header">
            <span class="heading">
                <?php echo __('Seller Information', 'js-vehicle-manager'); ?>
            </span>
        </div>
        <div id="jsvehiclemanager-content">

<div class="jsvehiclemanager_cm-seller-wrap">
    <div class="row jsvehiclemanager_cm-margin jsvehiclemanager_cm-seller-det">
        <div class="jsvehiclemanager_cm-seller-det-left">
            <img class="img-reponsive jsvehiclemanager_cm-seller-img" src="<?php echo esc_attr($seller->photo != '' ? $seller->photo : JSVEHICLEMANAGER_PLUGIN_URL."includes/images/default-images/profile-image.png");?>" title="<?php echo esc_attr(__('Seller', 'js-vehicle-manager')); ?>" alt="<?php echo esc_attr(__('Seller', 'js-vehicle-manager')); ?>" />
        </div>
        <div class="row jsvehiclemanager_cm-margin jsvehiclemanager_cm-seller-det-right">
            <div class="row jsvehiclemanager_cm-margin jsvehiclemanager_cm-seller-info-top">
                <h4 class="jsvehiclemanager_cm-seller-info-left">
                    <a class="jsvehiclemanager_cm-seller-info-left-text" href="#">
                        <?php echo esc_html($seller->name); ?>
                    </a>
                </h4>
                <span class="jsvehiclemanager_cm-social-media-links-wrap">
                    <?php  if($seller->facebook !=''){
                            if(!strstr($seller->facebook, 'http')){
                                $seller->facebook = 'http://'.$seller->facebook;
                            }
                    ?>
                            <a class="jsvehiclemanager_cm-social-media-links" title="<?php echo esc_attr('Facebook'); ?>" href="<?php echo esc_url($seller->facebook); ?>" target="_blank"><img src="<?php echo esc_attr(JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/facebook.png');?>" alt="<?php echo esc_attr(__('Facebook','js-vehicle-manager'));?>" title="<?php echo esc_attr(__('Facebook','js-vehicle-manager'));?>" /></a>
                    <?php   } ?>
                    <?php if($seller->twitter !=''){
                            if(!strstr($seller->twitter, 'http')) {
                                $seller->twitter = 'http://'.$seller->twitter;
                            }
                    ?>
                        <a class="jsvehiclemanager_cm-social-media-links" title="<?php echo esc_attr('Twitter'); ?>" href="<?php echo esc_url($seller->twitter); ?>" target="_blank"><img src="<?php echo esc_attr(JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/twitter.png');?>" alt="<?php echo esc_attr(__('Twitter','js-vehicle-manager'));?>" title="<?php echo esc_attr(__('Twitter','js-vehicle-manager'));?>" /></a>
                    <?php } ?>
                    <?php if($seller->linkedin !='') {
                            if(!strstr($seller->linkedin, 'http')){
                                $seller->linkedin = 'http://'.$seller->linkedin;
                            }
                    ?>
                        <a class="jsvehiclemanager_cm-social-media-links" title="<?php echo esc_attr('Linkedin'); ?>" href="<?php echo esc_url($seller->linkedin); ?>" target="_blank"><img src="<?php echo esc_attr(JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/linkedin.png');?>" alt="<?php echo esc_attr(__('Linkedin','js-vehicle-manager'));?>" title="<?php echo esc_attr(__('Linkedin','js-vehicle-manager'));?>" /></a>
                    <?php } ?>
                    <?php if($seller->googleplus !=''){
                            if(!strstr($seller->googleplus, 'http')){
                                $seller->googleplus = 'http://'.$seller->googleplus;
                            }
                    ?>
                        <a class="jsvehiclemanager_cm-social-media-links" title="<?php echo esc_attr('Googleplus'); ?>" href="<?php echo esc_url($seller->googleplus); ?>" target="_blank"><img src="<?php echo esc_attr(JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/google-plus');?>.png" alt="<?php echo esc_attr(__('Google Plus','js-vehicle-manager'));?>" title="<?php echo esc_attr(__('Google Plus','js-vehicle-manager'));?>" /></a>
                    <?php } ?>
                    <?php if($seller->pinterest !=''){
                            if(!strstr($seller->pinterest,'http')){
                                $seller->pinterest = 'http://'.$seller->pinterest;
                            }
                    ?>
                        <a class="jsvehiclemanager_cm-social-media-links" title="<?php echo esc_attr('Pinterest'); ?>" href="<?php echo esc_url($seller->pinterest); ?>" target="_blank"><img src="<?php echo esc_attr(JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/pinterest.png');?>" alt="<?php echo esc_attr(__('Pintrest','js-vehicle-manager'));?>" title="<?php echo esc_attr(__('Pintrest','js-vehicle-manager'));?>" /></a>
                    <?php } ?>
                    <?php if($seller->instagram !=''){
                            if(!strstr($seller->instagram, 'http')){
                                $seller->instagram = 'http://'.$seller->instagram;
                            }
                    ?>
                        <a class="jsvehiclemanager_cm-social-media-links" title="<?php echo esc_attr('Instagram'); ?>" href="<?php echo esc_url($seller->instagram); ?>" target="_blank"><img src="<?php echo esc_attr(JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/instagram.png');?>" alt="<?php echo esc_attr(__('Instagram','js-vehicle-manager'));?>" title="<?php echo esc_attr(__('Instagram','js-vehicle-manager'));?>" /></a>
                    <?php } ?>
                    <?php if($seller->reddit !=''){
                            if(!strstr($seller->reddit, 'http')){
                                $seller->reddit = 'http://'.$seller->reddit;
                            }
                    ?>
                        <a class="jsvehiclemanager_cm-social-media-links" title="<?php echo esc_attr('Reddit'); ?>" href="<?php echo esc_url($seller->reddit); ?>" target="_blank"><img src="<?php echo esc_attr(JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/reddit.png');?>" alt="<?php echo esc_attr(__('Reddit','js-vehicle-manager'));?>" title="<?php echo esc_attr(__('Reddit','js-vehicle-manager'));?>" /></a>
                    <?php } ?>
                </span>
            </div>
            <div class="row jsvehiclemanager_cm-margin jsvehiclemanager_cm-sellers-info-bottom">
                <div class="jsvehiclemanager_seller-info-wrp" >
                    <span class="jsvehiclemanager_cm-seller-info-bottom-bold-text">
                        <?php echo esc_html(__(jsvehiclemanager::$_data['fields']['email'],'js-vehicle-manager'))." : "; ?>
                    </span>
                    <span class="jsvehiclemanager_cm-seller-info-bottom-text text-muted">
                        <?php echo esc_html($seller->email); ?>
                    </span>
                </div>
                <div class="jsvehiclemanager_seller-info-wrp" >
                    <span class="jsvehiclemanager_cm-seller-info-bottom-bold-text">
                        <?php echo esc_html(__(jsvehiclemanager::$_data['fields']['phone'],'js-vehicle-manager'))." : "; ?>
                    </span>
                    <span class="jsvehiclemanager_cm-seller-info-bottom-text text-muted">
                        <?php echo esc_html($seller->phone); ?>
                    </span>
                </div>
                <div class="jsvehiclemanager_seller-info-wrp" >
                    <span class="jsvehiclemanager_cm-seller-info-bottom-bold-text">
                        <?php echo esc_html(__(jsvehiclemanager::$_data['fields']['weblink'],'js-vehicle-manager'))." : "; ?>
                    </span>
                    <span class="jsvehiclemanager_cm-seller-info-bottom-text text-muted">
                        <?php if(! strstr($seller->weblink, 'http')){
                            $weblink = 'http://'.$seller->weblink;
                        }else{
                            $weblink = $seller->weblink;
                        } ?>
                        <a href="<?php echo esc_url($weblink); ?>" ><?php echo esc_html($seller->weblink); ?></a>
                    </span>
                </div>
                <div class="jsvehiclemanager_seller-info-wrp" >
                    <span class="jsvehiclemanager_cm-seller-info-bottom-bold-text">
                        <?php echo esc_html(__(jsvehiclemanager::$_data['fields']['cityid'],'js-vehicle-manager'))." : "; ?>
                    </span>
                    <span class="jsvehiclemanager_cm-seller-info-bottom-text text-muted">
                        <?php echo esc_html(__($seller->location,'js-vehicle-manager')); ?>
                    </span>
                </div>
                <div class="jsvehiclemanager_seller-info-wrp" >
                    <span class="jsvehiclemanager_cm-seller-info-bottom-bold-text">
                        <?php echo esc_html(__(jsvehiclemanager::$_data['fields']['address'],'js-vehicle-manager'))." : "; ?>
                    </span>
                    <span class="jsvehiclemanager_cm-seller-info-bottom-text text-muted">
                        <?php echo esc_html($seller->address); ?>
                    </span>
                </div>
                <?php
                $customfields = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->userFieldsData(2);// 10 for main section of vehicle
                foreach($customfields AS $field){
                    $array = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->showCustomFields($field, 1,$seller->params,1); ?>
                    <div class="jsvehiclemanager_seller-info-wrp" >
                        <span class="jsvehiclemanager_cm-seller-info-bottom-bold-text">
                            <?php echo esc_html(__($array[0],'js-vehicle-manager'))." : "; ?>
                        </span>
                        <span class="jsvehiclemanager_cm-seller-info-bottom-text text-muted">
                            <?php echo esc_html($array[1]);?>
                        </span>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <?php
        $class = 'col-sm-6';
        $mapshow = true;
        if(empty($seller->latitude) || empty($seller->longitude)){
            $class = 'col-sm-12 col-sm-offset-1 jsvehiclemanager_full';
            $mapshow = false;
        }
    ?>
    <div class="row jsvehiclemanager_cm-margin jsvehiclemanager_cm-message-map-wrap">
        <?php do_action('jsvm_buyercontacttoseller_send_message',$seller->id,$class); ?>
        <?php if($mapshow == true){ ?>
            <div class="col-sm-6 jsvehiclemanager_cm-map <?php if($cm_buyer_can_contact_seller != 1) echo 'jsvehiclemanager_cm-map-full-width' ?>">
                <div id="jsvehiclemanager_map"></div>
            </div>
        <?php } ?>
    </div>
    <?php if(trim($seller->description) != '' ): ?>
        <div class="row jsvehiclemanager_cm-margin jsvehiclemanager_cm-desc-wrap">
            <div class="row jsvehiclemanager_cm-margin jsvehiclemanager_cm-desc-title">
                <?php echo esc_html__('Description','js-vehicle-manager'); ?>
            </div>
            <div class="row jsvehiclemanager_cm-margin jsvehiclemanager_cm-desc-det">
                <?php echo wp_kses_post($seller->description);?>
            </div>
        </div>
    <?php endif; ?>
    <?php if(trim($seller->video) != '' ): ?>
        <div class="row jsvehiclemanager_cm-margin jsvehiclemanager_cm-vid-wrap">
            <div class="row jsvehiclemanager_cm-margin jsvehiclemanager_cm-vid-title">
                <?php echo esc_html__('Video','js-vehicle-manager'); ?>
            </div>
            <div class="row jsvehiclemanager_cm-margin jsvehiclemanager_cm-vid-det">
                <?php
                    $value = $seller->video;
                    $vtype = $seller->videotypeid;
                    echo getRowForVideoView($value, $vtype);
                ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="row jsvehiclemanager_cm-margin jsvehiclemanager_cm-show-seller-btn-wrap">
        <a href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehicles', 'sellerid'=>$seller->id))); ?>" class="btn btn-primary text-center btn-block jsvehiclemanager_cm-show-seller-btn"><?php echo esc_html__('Show Seller Vehicles','js-vehicle-manager'); ?></a>
    </div>
</div>
</div>

<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
if(JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest() && jsvehiclemanager::$_data['showcaptcha'] == 1) {
$recaptcha_publickey = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('recaptcha_publickey');
    wp_enqueue_script( 'recaptchaAPI',$protocol.'www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit');
}
 ?>
<script>
function CaptchaCallback(){
    if( jQuery("#sellercaptcha").length > 0 ){
        oapcaptcha = grecaptcha.render("sellercaptcha", {"sitekey" : "<?php echo $recaptcha_publickey;?>"});
    }
}
</script>
<?php if($mapshow == true){
    wp_enqueue_script( 'mapAPI',$protocol.'maps.googleapis.com/maps/api/js?key='.$google_api_key);
}
?>
<?php if(isset($google_recaptcha) && $google_recaptcha){
    wp_enqueue_script('jsvm-repaptcha-scripti','https://www.google.com/recaptcha/api.js');
}
?>


<?php } ?>
</div>

