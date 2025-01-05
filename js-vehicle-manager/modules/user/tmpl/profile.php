<div id="jsvehiclemanager-main-up-wrapper">
<?php
if(isset(jsvehiclemanager::$_error_flag_message)){
    if(jsvehiclemanager::$_car_manager_theme == 1){
        $obj = new car_manager_Messages();
        $obj->getErrorMessage(jsvehiclemanager::$_error_flag_message);
    }else{
        echo wp_kses(jsvehiclemanager::$_error_flag_message, JSVEHICLEMANAGER_ALLOWED_TAGS);
        echo wp_kses(jsvehiclemanager::$_error_flag_message, JSVEHICLEMANAGER_ALLOWED_TAGS);
    }

}else{

    ?>
<div id="jsvehiclemanager-wrapper">
<?php
$msgkey = JSVEHICLEMANAGERincluder::getJSModel('user')->getMessagekey();
JSVEHICLEMANAGERmessages::getLayoutMessage($msgkey);
include_once(JSVEHICLEMANAGER_PLUGIN_PATH . 'includes/header.php');
?>
        <div class="control-pannel-header">
            <span class="heading">
                <?php echo __('Edit Profile', 'js-vehicle-manager'); ?>
            </span>
        </div>
        <div id="jsvehiclemanager-add-form-vehicle-wrapper">
            <div id="jsvehiclemanager-add-vehicle-wrap">
            <form  method="post" name="adminForm" id="jsvm_adminForm" class="jsvm_form-validate jsvm_js-form-horizontal" enctype="multipart/form-data" action="<?php echo esc_attr(jsvehiclemanager::makeUrl(array('jsvmme'=>'user', 'task'=>'saveprofile'))); ?>" >
                <div class="jsvehiclemanager-form-field-wrapper">
                <?php
                $rowcount = 0;
                foreach (jsvehiclemanager::$_data[2] as $field ) {
                    switch ($field->field) {
                        case 'name':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">
                                    <label class="form-label"><?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), $field->fieldtitle))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('name', isset(jsvehiclemanager::$_data[0]->name) ? jsvehiclemanager::$_data[0]->name: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'email':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">
                                    <label class="form-label"><?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), $field->fieldtitle))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('email', isset(jsvehiclemanager::$_data[0]->email) ? jsvehiclemanager::$_data[0]->email: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'cell':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">
                                    <label class="form-label"><?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), $field->fieldtitle))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('cell', isset(jsvehiclemanager::$_data[0]->cell) ? jsvehiclemanager::$_data[0]->cell: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS);; ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'weblink':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">
                                    <label class="form-label"><?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), $field->fieldtitle))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('weblink', isset(jsvehiclemanager::$_data[0]->weblink) ? jsvehiclemanager::$_data[0]->weblink: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'phone':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">
                                    <label class="form-label"><?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), $field->fieldtitle))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('phone', isset(jsvehiclemanager::$_data[0]->phone) ? jsvehiclemanager::$_data[0]->phone: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'cityid':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">
                                    <label class="form-label"><?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), $field->fieldtitle))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('cityid', isset(jsvehiclemanager::$_data[0]->cityid) ? jsvehiclemanager::$_data[0]->cityid: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'address':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">
                                    <label class="form-label"><?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), $field->fieldtitle))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('address', isset(jsvehiclemanager::$_data[0]->address) ? jsvehiclemanager::$_data[0]->address: '', array('class' => 'form-control', 'data-validation' => $req ,'onblur'=>'addMarkerFromAddress()')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'photo': ?>
                            <div class="jsvehiclemanager-js-form-wrapper jsvehiclemanager-full-width">
                                    <label class="form-label"><?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), $field->fieldtitle))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <input class="jsvm_inputbox" id="jsvm_profilephoto" name="profilephoto" type="file" />
                                    <?php
                                    if (isset(jsvehiclemanager::$_data[0]->photo) && jsvehiclemanager::$_data[0]->photo != "") { ?>
                                        <div class="jsvm_profile-profileimg-wrapper">
                                            <div class="jsvm_profile-profileimg-overlay">
                                            </div>
                                            <img alt="<?php echo esc_attr(__('User Image','js-vehicle-manager')); ?>" title="<?php echo esc_attr(__('User Image','js-vehicle-manager')); ?>" id="jsvm_profile_logo" style="display:inline;width:60px;height:auto;"  src="<?php echo esc_attr(jsvehiclemanager::$_data[0]->photo); ?>" />
                                        </div>
                                        <span class="jsvm_remove-file" onclick="return removePhoto(this);"><img alt="<?php echo esc_attr(__('Reject Icon','js-vehicle-manager')); ?>" title="<?php echo esc_attr(__('Reject Icon','js-vehicle-manager')); ?>" src="<?php echo esc_attr(CAR_MANAGER_IMAGE.'/reject-s.png'); ?>"></span>
                                    <?php
                                        }
                                         echo wp_kses(JSVEHICLEMANAGERformfield::hidden('deleteimage', 0), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                        $logoformat = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('image_file_type');
                                        $maxsize = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('allowed_file_size');
                                    echo '<br>('.esc_html($logoformat).')<br>';
                                    echo '('.esc_html__("Maximum file size","js-vehicle-manager").' '.esc_html($maxsize).' Kb)'; ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'facebook':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">
                                    <label class="form-label"><?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), $field->fieldtitle))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('facebook', isset(jsvehiclemanager::$_data[0]->facebook) ? jsvehiclemanager::$_data[0]->facebook: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'twitter':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">
                                    <label class="form-label"><?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), $field->fieldtitle))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('twitter', isset(jsvehiclemanager::$_data[0]->twitter) ? jsvehiclemanager::$_data[0]->twitter: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'linkedin':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">
                                    <label class="form-label"><?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), $field->fieldtitle))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('linkedin', isset(jsvehiclemanager::$_data[0]->linkedin) ? jsvehiclemanager::$_data[0]->linkedin: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'googleplus':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">
                                    <label class="form-label"><?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), $field->fieldtitle))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('googleplus', isset(jsvehiclemanager::$_data[0]->googleplus) ? jsvehiclemanager::$_data[0]->googleplus: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'pinterest':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">
                                    <label class="form-label"><?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), $field->fieldtitle))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('pinterest', isset(jsvehiclemanager::$_data[0]->pinterest) ? jsvehiclemanager::$_data[0]->pinterest: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'instagram':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">
                                    <label class="form-label"><?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), $field->fieldtitle))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('instagram', isset(jsvehiclemanager::$_data[0]->instagram) ? jsvehiclemanager::$_data[0]->instagram: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'reddit':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">
                                    <label class="form-label"><?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), $field->fieldtitle))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('reddit', isset(jsvehiclemanager::$_data[0]->reddit) ? jsvehiclemanager::$_data[0]->reddit: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'videotypeid':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">
                                    <label class="form-label"><?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), $field->fieldtitle))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::radiobutton('videotypeid', array(1 => esc_html__('Youtube video Link', 'js-vehicle-manager'), 2 => esc_html__('Embedded html', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data[0]->videotypeid) ? jsvehiclemanager::$_data[0]->videotypeid : '', array('class' => 'jsvm_inputbox', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'video':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">
                                    <label class="form-label"><?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), $field->fieldtitle))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('video', isset(jsvehiclemanager::$_data[0]->video) ? jsvehiclemanager::$_data[0]->video: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'description': ?>
                            <div class="jsvehiclemanager-js-form-wrapper jsvehiclemanager-full-width">
                                <label class="form-label"><?php echo esc_html(sprintf(__('%s','js-vehicle-manager'), $field->fieldtitle))." : "; ?>
                                    <?php
                                    $req = '';
                                    if ($field->required == 1) {
                                        $req = 'required';
                                        echo '<font color="red">&nbsp*</font>';
                                    }
                                    ?>
                                </label>
                                <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses_post(wp_editor(isset(jsvehiclemanager::$_data[0]->description) ? jsvehiclemanager::$_data[0]->description: '', 'description', array('media_buttons' => false, 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'map': ?>
                            <div class="jsvehiclemanager-js-form-wrapper jsvehiclemanager-full-width">
                                <label class="control-label"  id="map" for="map"><?php echo esc_html__('Map','js-vehicle-manager')." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                <div class="jsvehiclemanager-value">
                                    <div class="col-sm-12 col-md-12">
                                        <div id="map_container" style="height: 350px;" ></div>
                                    </div>
                                </div>
                                <div class="jsvehiclemanager-js-form-wrapper">
                                    <label class="control-label"  id="longitude" for="longitude"><?php echo esc_html__('Longitude','js-vehicle-manager')." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                    <div class="jsvehiclemanager-value">
                                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('longitude', isset(jsvehiclemanager::$_data[0]->longitude) ? jsvehiclemanager::$_data[0]->longitude: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    </div>
                                </div>
                                <div class="jsvehiclemanager-js-form-wrapper">
                                    <label class="control-label"  id="latitude" for="latitude"><?php echo esc_html__('Latitude','js-vehicle-manager')." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                    <div class="jsvehiclemanager-value">
                                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('latitude', isset(jsvehiclemanager::$_data[0]->latitude) ? jsvehiclemanager::$_data[0]->latitude: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        break;
                        default:
                            $u_field = wp_kses(JSVEHICLEMANAGERincluder::getObjectClass('customfields')->formCustomFields($field), JSVEHICLEMANAGER_ALLOWED_TAGS);;
                            if($u_field){
                                echo $u_field;
                            }
                        break;
                    }
                }
                echo "</div>";
                ?>
                <?php if(JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()) {?>
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="form-label"><?php echo esc_html__('Captacha','js-vehicle-manager')." : "; ?></label>
                            <div class="jsvehiclemanager-value">
                            <div class="g-recaptcha jsvm_captcha-wrapper" data-sitekey=<?php echo esc_attr($cm_options['cm_recaptcha_public_key']);?>> </div>
                        </div>
                    </div>
                <?php } ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('form_request', 'jsvehiclemanager'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <input type="hidden" name="task" value="saveprofile" />
                <input type="hidden" name="id" value="<?php echo esc_attr(isset(jsvehiclemanager::$_data[0]->id) ?jsvehiclemanager::$_data[0]->id : ''); ?>" />
                <input type="hidden" name="profileid" value="<?php echo esc_attr(isset(jsvehiclemanager::$_data[0]->profileid) ?jsvehiclemanager::$_data[0]->profileid : ''); ?>" />
                <input type="hidden" name="created" value="<?php echo esc_attr(isset(jsvehiclemanager::$_data[0]->created) ? jsvehiclemanager::$_data[0]->created : date_i18n('Y-m-d H:i:s')); ?>" />
                <input type="hidden" name="uid" value="<?php echo esc_attr(isset(jsvehiclemanager::$_data[0]->uid) ?jsvehiclemanager::$_data[0]->uid : get_current_user_id()); ?>" />
                <input type="hidden" name="jsvehiclemanagerpageid" id="jsvehiclemanagerpageid" value="<?php echo esc_attr(get_the_ID()); ?>" />
                <input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce('save-user'); ?>" />
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('hash', isset(jsvehiclemanager::$_data[0]->hash) ? jsvehiclemanager::$_data[0]->hash :''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <div class="jsvehiclemanager-js-buttons-area">
                    <div class="jsvehiclemanager-js-buttons-area-btn">
                        <input class="jsvehiclemanager-js-btn-save" type="submit" name="" id="" value="<?php echo esc_attr(__('Update Profile','js-vehicle-manager')); ?>" />
                    </div>
                </div>
            </div>
            </form>
        </div>
      </div>
 </div>
 </div>
<?php
 $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
 wp_enqueue_script( 'recaptchaAPI',$protocol.'www.google.com/recaptcha/api.js');
 ?>

<?php
$google_api_key = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('google_map_api_key');
wp_enqueue_script( 'mapAPI', $protocol.'maps.googleapis.com/maps/api/js?key='.$google_api_key);
?>
<input type="hidden" id="default_longitude" name="default_longitude" value="<?php echo (isset(jsvehiclemanager::$_data[0]->longitude) && jsvehiclemanager::$_data[0]->longitude !='' ) ? jsvehiclemanager::$_data[0]->longitude : jsvehiclemanager::$_config['default_longitude']; ?>"/>
<input type="hidden" id="default_latitude" name="default_latitude" value="<?php echo (isset(jsvehiclemanager::$_data[0]->latitude) && jsvehiclemanager::$_data[0]->latitude !='' ) ? jsvehiclemanager::$_data[0]->latitude : jsvehiclemanager::$_config['default_latitude']; ?>"/>
<?php if(isset(jsvehiclemanager::$_data[0]->latitude) && isset(jsvehiclemanager::$_data[0]->longitude) ){?>
        <input type="hidden" id="addmarker" name="addmarker" value="1"/>
<?php }else{ ?>
    <input type="hidden" id="addmarker" name="addmarker" value="0"/>
<?php } ?>



<?php } ?>
</div>
