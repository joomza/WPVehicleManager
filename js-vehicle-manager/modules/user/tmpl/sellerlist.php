<?php
if (!defined('ABSPATH')) die('Restricted Access');?>
<div id="jsvehiclemanager-main-up-wrapper">
<?php
$msgkey = JSVEHICLEMANAGERincluder::getJSModel('user')->getMessagekey();
JSVEHICLEMANAGERmessages::getLayoutMessage($msgkey);
JSVEHICLEMANAGERbreadcrumbs::getBreadcrumbs();
include_once(JSVEHICLEMANAGER_PLUGIN_PATH . 'includes/header.php');
if (jsvehiclemanager::$_error_flag == null) {

?>
<div id="jsvehiclemanager-wrapper">
        <div class="control-pannel-header">
            <span class="heading">
                <?php echo __('Seller List', 'js-vehicle-manager'); ?>
            </span>
        </div>
        <div id="jsvehiclemanager-content">
<?php
if( is_array(jsvehiclemanager::$_data['searchfields']) && !empty(jsvehiclemanager::$_data['searchfields']) ){ ?>
    <form class="jsvehiclemanager_autoz_form" id="jsvehiclemanager_autoz_form" method="post" action="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'user', 'jsvmlt'=>'sellerlist'))); ?>">
        <?php
        foreach (jsvehiclemanager::$_data['searchfields'] AS $field) {
            switch ($field->field) {
                case 'name':?>
                    <div class="jsvehiclemanager_field_box">
                            <label for="registrationnumber" class="control-label"><?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), $field->fieldtitle));?></label>
                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('searchname', isset(jsvehiclemanager::$_data['filter']['searchname']) ? jsvehiclemanager::$_data['filter']['searchname']: '' , array('class' => 'form-control')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                <?php
                break;
                case 'cityid':?>
                    <div class="jsvehiclemanager_field_box">
                            <label for="locationcity" class="control-label"><?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), $field->fieldtitle));?></label>
                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('cityid', '', array('class' => 'form-control')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                <?php
                break;
                case 'weblink':?>
                    <div class="jsvehiclemanager_field_box">
                            <label for="loczip" class="control-label"><?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), $field->fieldtitle));?></label>
                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('weblink', isset(jsvehiclemanager::$_data['filter']['weblink']) ? jsvehiclemanager::$_data['filter']['weblink']: '', array('class' => 'form-control')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                <?php
                break;
                default:
                    $u_field = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->formCustomFieldsForSearch($field, $i,1);
                    if($u_field){
                    ?>
                        <div class="jsvehiclemanager_field_box">
                            <label for="<?php echo esc_html($field->field); ?>" class="control-label"><?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), $field->fieldtitle));?></label>
                            <?php echo wp_kses($u_field, JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                        </div>
                    <?php
                    }
                break;
            }
        }
        ?>
        <div class="jsvehiclemanager_seller-list-btn-wrapper">
            <input class="jsvehiclemanager-seller-list-btn-reset" type="button" value="<?php echo esc_attr(__('Reset','js-vehicle-manager')); ?>" onClick="restFrom(isPluginCall);" />
            <input class="jsvehiclemanager-seller-list-btn-search" type="submit" value="<?php echo esc_attr(__('Search','js-vehicle-manager')); ?>"  />
        </div>
        <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('JSVEHICLEMANAGER_form_search', 'JSVEHICLEMANAGER_SEARCH'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
        <input type="hidden" id="jsvm_issearch" name="issearch" value="1"/>
        <input type="hidden" id="jsvmlt" name="jsvmlt" value="sellerlist"/>
</form>
<?php
}
if(!empty(jsvehiclemanager::$_data[0])){
    foreach (jsvehiclemanager::$_data[0] as $data) {
        ?>
    <div class="jsvehiclemanager_cm-seller-wrap">
        <div class="row jsvehiclemanager_cm-margin jsvehiclemanager_cm-seller-det">
            <div class="jsvehiclemanager_cm-seller-det-left">
                <img class="img-reponsive jsvehiclemanager_cm-seller-img" src="<?php echo esc_attr($data->photo != '' ? $data->photo : JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/default-images/profile-image.png');?>" title="<?php echo esc_attr(__('Seller', 'js-vehicle-manager')); ?>" alt="<?php echo esc_attr(__('Seller', 'js-vehicle-manager')); ?>"/>
            </div>
            <div class="row jsvehiclemanager_cm-margin jsvehiclemanager_cm-seller-det-right">
                <div class="row jsvehiclemanager_cm-margin jsvehiclemanager_cm-seller-info-top">
                    <h4 class="jsvehiclemanager_cm-seller-info-left">
                        <a class="jsvehiclemanager_cm-seller-info-left-text" href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'user', 'jsvmlt'=>'viewsellerinfo', 'jsvehiclemanagerid'=>$data->id))); ?>" title="<?php echo esc_attr($data->name); ?>" ><?php echo esc_html($data->name); ?></a>
                    </h4>
                    <span class="jsvehiclemanager_cm-seller-info-right">
                        <a title="<?php echo esc_attr(__('seller info','js-vehicle-manager')); ?>" href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'user', 'jsvmlt'=>'viewsellerinfo', 'jsvehiclemanagerid'=>$data->id))); ?>" class="jsvehiclemanager_cm-seller-info-btn btn-lg"><?php echo esc_html__('View Seller Info','js-vehicle-manager'); ?></a>
                    </span>
                </div>
                <div class="row jsvehiclemanager_cm-margin jsvehiclemanager_cm-sellers-info-bottom">
                    <?php if (jsvehiclemanager::$_data['listingfields']['phone'] == 1) { ?>
                        <div class="jsvehiclemanager_seller-info-wrp" >
                            <span class="jsvehiclemanager_cm-seller-info-bottom-bold-text">
                                <?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), jsvehiclemanager::$_data['fields']['email']))." : "; ?>
                            </span>
                            <span class="jsvehiclemanager_cm-seller-info-bottom-text text-muted">
                                <?php echo esc_html($data->email); ?>
                            </span>
                        </div>
                    <?php } ?>
                    <?php if (jsvehiclemanager::$_data['listingfields']['phone'] == 1) { ?>
                        <div class="jsvehiclemanager_seller-info-wrp" >
                            <span class="jsvehiclemanager_cm-seller-info-bottom-bold-text">
                                <?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), jsvehiclemanager::$_data['fields']['phone']))." : "; ?>
                            </span>
                            <span class="jsvehiclemanager_cm-seller-info-bottom-text text-muted">
                                <?php echo esc_html($data->phone); ?>
                            </span>
                        </div>
                    <?php   } ?>
                    <?php if (jsvehiclemanager::$_data['listingfields']['weblink'] == 1) { ?>
                        <div class="jsvehiclemanager_seller-info-wrp" >
                            <span class="jsvehiclemanager_cm-seller-info-bottom-bold-text">
                                <?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), jsvehiclemanager::$_data['fields']['weblink']))." : "; ?>
                            </span>
                            <span class="jsvehiclemanager_cm-seller-info-bottom-text text-muted">
                                <?php if(! strstr($data->weblink, 'http')){
                                    $weblink = 'http://'.$data->weblink;
                                }else{
                                    $weblink = $data->weblink;
                                } ?>
                                <a href="<?php echo esc_url($weblink); ?>" ><?php echo esc_html($data->weblink); ?></a>
                            </span>
                        </div>
                    <?php } ?>
                    <div class="jsvehiclemanager_seller-info-wrp" >
                        <span class="jsvehiclemanager_cm-seller-info-bottom-bold-text">
                            <?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), jsvehiclemanager::$_data['fields']['cityid']))." : "; ?>
                        </span>
                        <span class="jsvehiclemanager_cm-seller-info-bottom-text text-muted">
                            <?php echo esc_html(__($data->location,'js-vehicle-manager')); ?>
                        </span>
                    </div>
                    <?php
                    $customfields = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->userFieldsData(2,0,1);// 10 for main section of vehicle
                    foreach($customfields AS $field){
                        $array = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->showCustomFields($field, 2,$data->params); ?>
                        <div class="jsvehiclemanager_seller-info-wrp" >
                            <span class="jsvehiclemanager_cm-seller-info-bottom-bold-text">
                                <?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), $array[0]))." : "; ?>
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
    </div>
    <?php
    }

    if (jsvehiclemanager::$_data[1]) {
        echo '<div id="jsvehiclemanager-pagination">' . wp_kses_post(jsvehiclemanager::$_data[1]) . '</div>';    }
    }else{
        $msg = __('No record found','js-vehicle-manager');
        echo wp_kses(JSVEHICLEMANAGERlayout::getNoRecordFound($msg), JSVEHICLEMANAGER_ALLOWED_TAGS);
    }
         echo wp_kses(jsvehiclemanager::$_error_flag_message, JSVEHICLEMANAGER_ALLOWED_TAGS);

     ?>

    </div>

<?php } ?>
</div>
