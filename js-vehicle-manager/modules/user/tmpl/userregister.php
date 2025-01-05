<?php
if (!defined('ABSPATH')) die('Restricted Access');?>
<div id="jsvehiclemanager-main-up-wrapper">
<?php
//JSJOBSbreadcrumbs::getBreadcrumbs();
JSVEHICLEMANAGERbreadcrumbs::getBreadcrumbs();
include_once(JSVEHICLEMANAGER_PLUGIN_PATH . 'includes/header.php');
if (JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()) {
    // check to make sure user registration is enabled
    $is_enable = get_option('users_can_register');
    // only show the registration form if allowed
    if ($is_enable) {

        //echo '<div class="frontend error"><p>Invalid recaptcha answer</p></div>';
        //jsvehiclemanager_show_error_messages();
        if ($codes = jsvehiclemanager_errors()->get_error_codes()) {

            foreach ($codes as $code) {
                 echo '<div class="frontend error">';// errors was showing in same div so added in loop
                $message = jsvehiclemanager_errors()->get_error_message($code);
                echo  '<p>'.esc_html($message)."</p>";
                echo '</div>';
            }

        }

        ?>
        <!-- registration form fields -->
        <div id="jsvehiclemanager-wrapper">
            <div class="control-pannel-header">
                <span class="heading">
                    <?php echo __('Register', 'js-vehicle-manager'); ?>
                </span>
            </div>
            <div id="jsvehiclemanager-add-form-vehicle-wrapper">
                <div id="jsvehiclemanager-add-vehicle-wrap">
                <form id="jsvehiclemanager_registration_form" class="jsvehiclemanager_form" action="" method="POST" enctype="multipart/form-data">
                    <fieldset>
                        <p>
                            <label for="jsvehiclemanager_user_login"><?php _e('Username','js-vehicle-manager'); ?><font color="red">&nbsp*</font></label>
                            <input name="jsvehiclemanager_user_login" id="jsvehiclemanager_user_login" class="jsvm_required" type="text"/>
                        </p>
                        <p>
                            <label for="jsvehiclemanager_user_email"><?php _e('Email','js-vehicle-manager'); ?><font color="red">&nbsp*</font></label>
                            <input name="jsvehiclemanager_user_email" id="jsvehiclemanager_user_email" class="jsvm_required" type="email"/>
                        </p>
                        <p>
                            <label for="jsvehiclemanager_user_first"><?php _e('First name','js-vehicle-manager'); ?><font color="red">&nbsp*</font></label>
                            <input name="jsvehiclemanager_user_first" id="jsvehiclemanager_user_first" type="text"/>
                        </p>
                        <p>
                            <label for="jsvehiclemanager_user_last"><?php _e('Last name','js-vehicle-manager'); ?><font color="red">&nbsp*</font></label>
                            <input name="jsvehiclemanager_user_last" id="jsvehiclemanager_user_last" type="text"/>
                        </p>
                        <p>
                            <label for="jsvm_password"><?php _e('Password','js-vehicle-manager'); ?><font color="red">&nbsp*</font></label>
                            <input name="jsvehiclemanager_user_pass" id="jsvm_password" class="jsvm_required" type="password"/>
                        </p>
                        <p>
                            <label for="jsvm_password_again"><?php _e('Password Again','js-vehicle-manager'); ?><font color="red">&nbsp*</font></label>
                            <input name="jsvehiclemanager_user_pass_confirm" id="jsvm_password_again" class="jsvm_required" type="password"/>
                        </p>
                        <p>
                            <?php
                            do_action('register_form');
                            ?>
                        </p>
                        <?php
                        foreach (jsvehiclemanager::$_data[2] as $field ) {
                            switch ($field->field) {
                                case 'cell': ?>
                                    <p>
                                        <label ><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))/*." : "*/; ?>
                                            <?php
                                            $req = '';
                                            if ($field->required == 1) {
                                                $req = 'required';
                                                echo '<font color="red">&nbsp*</font>';
                                            }
                                            ?>
                                        </label>
                                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('cell', '', array( 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    </p>
                                <?php
                                break;
                                case 'weblink': ?>
                                    <p>
                                        <label ><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))/*." : "*/; ?>
                                            <?php
                                            $req = '';
                                            if ($field->required == 1) {
                                                $req = 'required';
                                                echo '<font color="red">&nbsp*</font>';
                                            }
                                            ?>
                                        </label>
                                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('weblink', '', array( 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    </p>
                                <?php
                                break;
                                case 'phone': ?>
                                    <p>
                                        <label ><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))/*." : "*/; ?>
                                            <?php
                                            $req = '';
                                            if ($field->required == 1) {
                                                $req = 'required';
                                                echo '<font color="red">&nbsp*</font>';
                                            }
                                            ?>
                                        </label>
                                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('phone', '', array( 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    </p>
                                <?php
                                break;
                                case 'cityid': ?>
                                    <p>
                                        <label ><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))/*." : "*/; ?>
                                            <?php
                                            $req = '';
                                            if ($field->required == 1) {
                                                $req = 'required';
                                                echo '<font color="red">&nbsp*</font>';
                                            }
                                            ?>
                                        </label>
                                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('cityid', '', array( 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    </p>
                                <?php
                                break;
                                case 'photo': ?>
                                    <p>
                                        <label ><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))/*." : "*/; ?>
                                            <?php
                                            $req = '';
                                            if ($field->required == 1) {
                                                $req = 'required';
                                                echo '<font color="red">&nbsp*</font>';
                                            }
                                            ?>
                                        </label>
                                        <input class="jsvm_inputbox" id="jsvm_profilephoto" name="profilephoto" type="file">
                                        <?php
                                            $logoformat = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('image_file_type');
                                            $maxsize = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('allowed_file_size');
                                        echo '('.esc_html($logoformat).')<br>';
                                        echo '('.__("Maximum file size","js-vehicle-manager").' '.esc_html($maxsize).' Kb)'; ?>
                                    </p>
                                <?php
                                break;
                                case 'facebook': ?>
                                    <p>
                                        <label ><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))/*." : "*/; ?>
                                            <?php
                                            $req = '';
                                            if ($field->required == 1) {
                                                $req = 'required';
                                                echo '<font color="red">&nbsp*</font>';
                                            }
                                            ?>
                                        </label>
                                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('facebook', '', array( 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    </p>
                                <?php
                                break;
                                case 'twitter': ?>
                                    <p>
                                        <label ><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))/*." : "*/; ?>
                                            <?php
                                            $req = '';
                                            if ($field->required == 1) {
                                                $req = 'required';
                                                echo '<font color="red">&nbsp*</font>';
                                            }
                                            ?>
                                        </label>
                                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('twitter', '', array( 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    </p>
                                <?php
                                break;
                                case 'linkedin': ?>
                                    <p>
                                        <label ><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))/*." : "*/; ?>
                                            <?php
                                            $req = '';
                                            if ($field->required == 1) {
                                                $req = 'required';
                                                echo '<font color="red">&nbsp*</font>';
                                            }
                                            ?>
                                        </label>
                                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('linkedin', '', array( 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    </p>
                                <?php
                                break;
                                case 'googleplus': ?>
                                    <p>
                                        <label ><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))/*." : "*/; ?>
                                            <?php
                                            $req = '';
                                            if ($field->required == 1) {
                                                $req = 'required';
                                                echo '<font color="red">&nbsp*</font>';
                                            }
                                            ?>
                                        </label>
                                       <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('googleplus', '', array( 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    </p>
                                <?php
                                break;
                                case 'pinterest': ?>
                                    <p>
                                        <label ><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))/*." : "*/; ?>
                                            <?php
                                            $req = '';
                                            if ($field->required == 1) {
                                                $req = 'required';
                                                echo '<font color="red">&nbsp*</font>';
                                            }
                                            ?>
                                        </label>
                                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('pinterest', '', array( 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    </p>
                                <?php
                                break;
                                case 'instagram': ?>
                                    <p>
                                        <label ><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))/*." : "*/; ?>
                                            <?php
                                            $req = '';
                                            if ($field->required == 1) {
                                                $req = 'required';
                                                echo '<font color="red">&nbsp*</font>';
                                            }
                                            ?>
                                        </label>
                                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('instagram', '', array( 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    </p>
                                <?php
                                break;
                                case 'reddit': ?>
                                    <p>
                                        <label ><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))/*." : "*/; ?>
                                            <?php
                                            $req = '';
                                            if ($field->required == 1) {
                                                $req = 'required';
                                                echo '<font color="red">&nbsp*</font>';
                                            }
                                            ?>
                                        </label>
                                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('reddit', '', array( 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    </p>
                                <?php
                                break;
                                case 'videotypeid': ?>
                                    <p>
                                        <label ><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))/*." : "*/; ?>
                                            <?php
                                            $req = '';
                                            if ($field->required == 1) {
                                                $req = 'required';
                                                echo '<font color="red">&nbsp*</font>';
                                            }
                                            ?>
                                        </label>
                                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::radiobutton('videotypeid', array(1 => __('Youtube video Link', 'js-vehicle-manager'), 2 => __('Embedded html', 'js-vehicle-manager')), '', array('class' => 'jsvm_inputbox', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    </p>
                                <?php
                                break;
                                case 'address': ?>
                                    <p>
                                        <label ><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))/*." : "*/; ?>
                                            <?php
                                            $req = '';
                                            if ($field->required == 1) {
                                                $req = 'required';
                                                echo '<font color="red">&nbsp*</font>';
                                            }
                                            ?>
                                        </label>
                                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('address', '', array('class' => 'jsvm_inputbox','data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    </p>
                                <?php
                                break;
                                case 'video': ?>
                                    <p>
                                        <label ><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))/*." : "*/; ?>
                                            <?php
                                            $req = '';
                                            if ($field->required == 1) {
                                                $req = 'required';
                                                echo '<font color="red">&nbsp*</font>';
                                            }
                                            ?>
                                        </label>
                                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('video', '', array( 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    </p>
                                <?php
                                break;
                                case 'description': ?>
                                    <p>
                                        <label ><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))/*." : "*/; ?>
                                            <?php
                                            $req = '';
                                            if ($field->required == 1) {
                                                $req = 'required';
                                                echo '<font color="red">&nbsp*</font>';
                                            }
                                            ?>
                                        </label>
                                        <?php echo wp_kses_post(wp_editor('', 'description', array('media_buttons' => false, 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    </p>
                                <?php
                                break;
                                case 'map': ?>
                                    <div class="form-group col-sm-12 col-md-12">
                                        <div class="col-sm-12 col-md-12">
                                            <div id="jsvm_map_container" style="height: 350px;" ></div>
                                        </div>
                                        <div class="col-sm-12 col-md-4 jsvm_cm-search-fm-map-optn">
                                            <label class="control-label"  id="jsvm_longitude" for="longitude"><?php echo __('Longitude','js-vehicle-manager')/*." :"*/; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('longitude', '', array( 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        </div>
                                        <div class="col-sm-12 col-md-4 jsvm_cm-search-fm-map-optn">
                                            <label class="control-label"  id="jsvm_latitude" for="latitude"><?php echo __('Latitude','js-vehicle-manager')/*." :"*/; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('latitude','', array( 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                <?php
                                break;
                                default:
                                    echo JSVEHICLEMANAGERincluder::getObjectClass('customfields')->formCustomFields($field,1);
                                break;

                            }?>
                <?php } ?>

                            <?php
                            $config_array = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigByFor('recaptcha');
                            $google_recaptcha = false;
                            if (JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest() && $config_array['recaptcha_registrationform'] == 1) {
                                $google_recaptcha = true;
                             ?>
                                <p>
                                    <div class="g-recaptcha" data-sitekey="<?php echo esc_attr($config_array['recaptcha_publickey']);?>"></div>
                                </p>
                            <?php
                            } ?>
                        <p>
                            <input type="hidden" name="jsvehiclemanager_autoz_register_nonce" value="<?php echo esc_attr(wp_create_nonce('jsvehiclemanager-autoz-register-nonce')); ?>"/>
                            <div id="jsvm_save">
                                <input type="submit" id="jsvm_save" value="<?php _e('Register New Account','js-vehicle-manager'); ?>"/>
                            </div>
                        </p>
                        <input type="hidden" id="jsvm_id" name="id" value=""/>
                        <input type="hidden" id="jsvm_deleteima" name="deleteimage[]" value=""/>
                        <input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo esc_attr(wp_create_nonce('save-user')); ?>"/>
                    </fieldset>
                </form>
            </div>
        </div>
    <?php
    } else {
        JSVEHICLEMANAGERlayout::getRegistrationDisabled();
    }
}
if(isset($google_recaptcha) && $google_recaptcha){ ?>
    <?php
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

     wp_enqueue_script('jsvm-repaptcha-scripti','https://www.google.com/recaptcha/api.js');
}
?>
</div>
