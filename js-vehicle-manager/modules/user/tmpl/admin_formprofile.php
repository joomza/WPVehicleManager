<?php if (!defined('ABSPATH')) die('Restricted Access'); 
$google_api_key = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('google_map_api_key');
wp_enqueue_script('jquery-ui-datepicker');
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
wp_enqueue_style('jquery-ui-css', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/css/jquery-ui-smoothness.css');
wp_enqueue_script('jsvm-maps-scripti','https://maps.googleapis.com/maps/api/js?key='.$google_api_key);
?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $.validate();
        $('.custom_date').datepicker();
    });
</script>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        jQuery("a#jsvm_userpopup").click(function (e) {
            e.preventDefault();
            jQuery("div#jsvm_popup-new-company").css("display", "none");
            jQuery("img.icon").css("display", "none");
            jQuery("div#jsvm_popup-record-data").css("display", "block");
            jQuery("div#jsvm_full_background").show();
            var ajaxurl = "<?php echo esc_url(admin_url('admin-ajax.php')) ?>";
            jsvm_showloading();
            jQuery.post(ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'user', task: 'getUserListAjax',wpnoncecheck:common.wp_vm_nonce}, function (data) {
                if (data) {
                    jQuery("div#jsvm_popup-record-data").html("");
                    jQuery("span#jsvm_popup_title").html(jQuery("input#jsvm_user-popup-title-text").val());
                    jQuery("div#jsvm_popup-record-data").html(data);
                    setUserLink();
                    jsvm_hideloading();
                }
            });
            jQuery("div#jsvm_popup_main").slideDown('slow');
        });

        jQuery(document).delegate('form#jsvm_userpopupsearch', 'submit', function (e) {
            e.preventDefault();
            var name = jQuery("input#name").val();
            var emailaddress = jQuery("input#email").val();
            var ajaxurl = "<?php echo esc_url(admin_url('admin-ajax.php')) ?>";
            jQuery.post(ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'user', task: 'getUserListAjax', name: name, uname: username, email: emailaddress, listfor: 1,wpnoncecheck:common.wp_vm_nonce}, function (data) {
                if (data) {
                    jQuery("span#jsvm_popup_title").html(jQuery("input#jsvm_user-popup-title-text").val());
                    jQuery("div#jsvm_popup-record-data").html(data);
                    setUserLink();
                }
            });//jquery closed
        });        
    
        jQuery("span.close, div#jsvm_full_background,img#jsvm_popup_cross").click(function (e) {
            jQuery("div#jsvm_popup_main").slideUp('slow', function () {
                jQuery("div#jsvm_full_background").hide();
            });

        });
    });


    function updateuserlist(pagenum) {
        var ajaxurl = "<?php echo esc_url(admin_url('admin-ajax.php')) ?>";
        jQuery.post(ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'user', task: 'getUserListAjax', userlimit: pagenum,wpnoncecheck:common.wp_vm_nonce}, function (data) {
            if (data) {
                jQuery("div#jsvm_popup-record-data").html("");
                jQuery("span#jsvm_popup_title").html(jQuery("input#jsvm_user-popup-title-text").val());
                jQuery("div#jsvm_popup-record-data").html(data);
                setUserLink();
            }
        });
    }

    function setUserLink() {
        jQuery("a.jsvm_js-userpopup-link").each(function () {
            var anchor = jQuery(this);
            jQuery(anchor).click(function (e) {
                var name = jQuery(this).attr('data-sname');
                var email = jQuery(this).attr('data-semail');
                jQuery("div#jsvm_sname-div").html(name);
                jQuery("input#name").val(name);
                jQuery("input#email").val(email);

                var id = jQuery(this).attr('data-sid');
                jQuery('input#uid').val(id);

                jQuery('div#jsvehiclemanager-adminadd-vehicle').hide();
                jQuery('div#jsvehiclemanager-selleradd-vehicle').show();


                jQuery("div#jsvm_popup_main").slideUp('slow', function () {
                    jQuery("div#jsvm_full_background").hide();
                });
            });
        });
    }
</script>

<div style="display:none;" id="jsvm_ajaxloaded_wait_overlay"></div>
<img style="display:none;" id="jsvm_ajaxloaded_wait_image" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/loading.gif'; ?>">

<div id="jsvehiclemanageradmin-wrapper">
    <div id="jsvm_full_background" style="display:none;"></div>
    <div id="jsvm_popup_main" style="display:none;">
        <span class="jsvm_popup-top"><span id="jsvm_popup_title" ></span><img id="jsvm_popup_cross" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/popup-close.png"></span>
            <div class="jsvm_js-vehicle-manager-sellerpopupwrapper">
                <form id="jsvm_userpopupsearch">
                    <div class="jsvm_search-center">
                        <div class="jsvm_js-vehicle-manager-searchpopupwrapper">
                            <div class="jsvm_search-value">
                                <input type="text" name="name" id="jsvm_name" placeholder="<?php echo __('Name', 'js-vehicle-manager');?>" />
                            </div>
                            <div class="jsvm_search-value">
                                <input type="text" name="email" id="jsvm_email" placeholder="<?php echo __('Email Address', 'js-vehicle-manager');?>"/>
                            </div>
                            <div class="jsvm_search-value-button">
                                <div class="jsvm_js-button ">
                                    <input type="submit" class="jsvm_submit-button" value="<?php echo __('Search', 'js-vehicle-manager');?>" />
                                </div>
                                <div class="jsvm_js-button">
                                    <input type="submit" onclick="document.getElementById('jsvm_name').value = ''; document.getElementById('jsvm_email').value = '';" value="<?php echo __('Reset', 'js-vehicle-manager');?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        <div id="jsvm_popup-record-data" style="display:inline-block;width:100%;"></div>
    </div>
    <div id="jsvehiclemanageradmin-leftmenu">
        <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </div>
    <div id="jsvehiclemanageradmin-data">
    <span class="jsvm_js-admin-title">
        <a href="<?php echo esc_url(admin_url('admin.php?page=jsvm_user')); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" /></a>
        <?php
        $heading = isset(jsvehiclemanager::$_data[0]) ? __('Edit', 'js-vehicle-manager') : __('Add New', 'js-vehicle-manager');
        echo esc_html($heading) . '&nbsp' . __('Profile', 'js-vehicle-manager');
        ?>
<?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </span>
    <div class="jsvehiclemanager-form-wrap jsvm_profile-form">
        <form id="jsvehiclemanager-form" method="post" enctype="multipart/form-data" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_user&task=saveprofile")); ?>">
            <?php 
            if( ! isset(jsvehiclemanager::$_data[0]->id) ){ ?>

            <div class="jsvm_js-form-wrapper">
                <label id="uid" for="sellerid" class="jsvehiclemanager-title"><?php echo __('Select User','js-vehicle-manager')."<font class='jsvm_required-notifier'>*</font> :"; ?></label>
                <div id="jsvm_sname-div" class="jsvm_selected-seller-div" ></div>
                <a href="#" id="jsvm_userpopup" class="jsvm_cm-userpopup">
                    <?php echo __('Select','js-vehicle-manager') .' '. __('User', 'js-vehicle-manager'); ?>
                </a>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('uid', isset(jsvehiclemanager::$_data[0]->uid) ? jsvehiclemanager::$_data[0]->uid : '', array('data-validation'=>'required')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            </div>

            <?php
                } ?>
            
            <?php     
                foreach (jsvehiclemanager::$_data[2] as $field ) {
                    $req = '';
                    if ($field->required == 1){
                        $req = 'required';
                    }
                    switch ($field->field) {
                        case 'name': ?>
                            <div class="jsvm_js-field-wrapper js-row jsvm_no-margin">
                                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding">
                                    <?php echo esc_html(__($field->fieldtitle, 'js-vehicle-manager')); ?><font class="jsvm_required-notifier">*</font>
                                </div>
                                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('name', isset(jsvehiclemanager::$_data[0]->name) ? __(jsvehiclemanager::$_data[0]->name,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => 'required')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>            
                        <?php
                        break;
                        case 'email':?>
                            <div class="jsvm_js-field-wrapper js-row jsvm_no-margin">
                                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo esc_html(__($field->fieldtitle, 'js-vehicle-manager')); ?><font class="jsvm_required-notifier">*</font></div>
                                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('email', isset(jsvehiclemanager::$_data[0]->email) ? __(jsvehiclemanager::$_data[0]->email,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => 'required')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                            </div>
                        <?php
                        break;
                        case 'cell': ?>
                            <div class="jsvm_js-field-wrapper js-row jsvm_no-margin">
                                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo esc_html(__($field->fieldtitle, 'js-vehicle-manager')); ?></div>
                                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('cell', isset(jsvehiclemanager::$_data[0]->cell) ? __(jsvehiclemanager::$_data[0]->cell,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                            </div>
                        <?php
                        break;
                        case 'weblink': ?>
                            <div class="jsvm_js-field-wrapper js-row jsvm_no-margin">
                                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo esc_html(__($field->fieldtitle, 'js-vehicle-manager')); ?></div>
                                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('weblink', isset(jsvehiclemanager::$_data[0]->weblink) ? __(jsvehiclemanager::$_data[0]->weblink,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                            </div>
                        <?php
                        break;
                        case 'phone': ?>
                            <div class="jsvm_js-field-wrapper js-row jsvm_no-margin">
                                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo esc_html(__($field->fieldtitle, 'js-vehicle-manager')); ?></div>
                                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('phone', isset(jsvehiclemanager::$_data[0]->phone) ? __(jsvehiclemanager::$_data[0]->phone,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                            </div>
                        <?php
                        break;
                        case 'cityid': ?>
                            <div class="jsvm_js-field-wrapper js-row jsvm_no-margin">
                                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo esc_html(__($field->fieldtitle, 'js-vehicle-manager')); ?></div>
                                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('cityid', isset(jsvehiclemanager::$_data[0]->cityid) ? __(jsvehiclemanager::$_data[0]->cityid,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                            </div>
                        <?php
                        break;
                        case 'photo': ?>
                            <div class="jsvm_js-field-wrapper js-row jsvm_no-margin">
                                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo esc_html(__($field->fieldtitle, 'js-vehicle-manager')); ?></div>
                                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding">
                                    <div class="jsvm_js-field-wrap">
                                        <input class="jsvm_inputbox" id="jsvm_profilephoto" name="profilephoto" type="file">
                                        <?php
                                            echo wp_kses(JSVEHICLEMANAGERformfield::hidden('deleteimage', 0), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                            $logoformat = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('image_file_type');
                                            $maxsize = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('allowed_file_size');
                                            echo '('.esc_html($logoformat).')<br>';
                                            echo '('.__("Maximum file size","js-vehicle-manager").' '.esc_html($maxsize).' Kb)';
                                        ?>
                                    </div>
                                    <?php
                                    if (isset(jsvehiclemanager::$_data[0]->photo) && jsvehiclemanager::$_data[0]->photo != "") { ?>
                                         <div class="jsvm_js-logo-wrap">
                                            <div class="jsvm_js-logo-img">
                                                <img id="jsvm_js-logoimg" src="<?php echo jsvehiclemanager::$_data[0]->photo; ?>">
                                                <span class="jsvm_remove-file" onClick="return removePhoto(<?php echo esc_html(jsvehiclemanager::$_data[0]->id); ?>);"><img id="jsvm_js-deletelogo" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/form_delete.png"></span>
                                                <div class="jsvm_profile-profileimg-overlay" style="display:none;" ></div>
                                            </div>
                                        </div>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'facebook': ?>
                            <div class="jsvm_js-field-wrapper js-row jsvm_no-margin">
                                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo esc_html(__($field->fieldtitle, 'js-vehicle-manager')); ?></div>
                                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('facebook', isset(jsvehiclemanager::$_data[0]->facebook) ? __(jsvehiclemanager::$_data[0]->facebook,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                            </div>
                        <?php
                        break;
                        case 'twitter': ?>
                            <div class="jsvm_js-field-wrapper js-row jsvm_no-margin">
                                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo esc_html(__($field->fieldtitle, 'js-vehicle-manager')); ?></div>
                                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('twitter', isset(jsvehiclemanager::$_data[0]->twitter) ? __(jsvehiclemanager::$_data[0]->twitter,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                            </div>
                        <?php
                        break;
                        case 'linkedin': ?>
                            <div class="jsvm_js-field-wrapper js-row jsvm_no-margin">
                                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo esc_html(__($field->fieldtitle, 'js-vehicle-manager')); ?></div>
                                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('linkedin', isset(jsvehiclemanager::$_data[0]->linkedin) ? __(jsvehiclemanager::$_data[0]->linkedin,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                            </div>
                        <?php
                        break;
                        case 'googleplus': ?>
                            <div class="jsvm_js-field-wrapper js-row jsvm_no-margin">
                                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo esc_html(__($field->fieldtitle, 'js-vehicle-manager')); ?></div>
                                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('googleplus', isset(jsvehiclemanager::$_data[0]->googleplus) ? __(jsvehiclemanager::$_data[0]->googleplus,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                            </div>
                        <?php
                        break;
                        case 'pinterest': ?>
                            <div class="jsvm_js-field-wrapper js-row jsvm_no-margin">
                                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo esc_html(__($field->fieldtitle, 'js-vehicle-manager')); ?></div>
                                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('pinterest', isset(jsvehiclemanager::$_data[0]->pinterest) ? __(jsvehiclemanager::$_data[0]->pinterest,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                            </div>
                        <?php
                        break;
                        case 'instagram': ?>
                            <div class="jsvm_js-field-wrapper js-row jsvm_no-margin">
                                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo esc_html(__($field->fieldtitle, 'js-vehicle-manager')); ?></div>
                                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('instagram', isset(jsvehiclemanager::$_data[0]->instagram) ? __(jsvehiclemanager::$_data[0]->instagram,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                            </div>
                        <?php
                        break;
                        case 'reddit': ?>
                            <div class="jsvm_js-field-wrapper js-row jsvm_no-margin">
                                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo esc_html(__($field->fieldtitle, 'js-vehicle-manager')); ?></div>
                                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('reddit', isset(jsvehiclemanager::$_data[0]->reddit) ? __(jsvehiclemanager::$_data[0]->reddit,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                            </div>
                        <?php
                        break;
                        case 'videotypeid': ?>
                            <div class="jsvm_js-field-wrapper js-row jsvm_no-margin">
                                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo esc_html(__($field->fieldtitle, 'js-vehicle-manager')); ?></div>
                                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::radiobutton('videotypeid', array(1 => __('Youtube video Link', 'js-vehicle-manager'), 2 => __('Embedded html', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data[0]->videotypeid) ? jsvehiclemanager::$_data[0]->videotypeid : '', array('class' => 'jsvm_inputbox', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                            </div>
                        <?php
                        break;
                        case 'video': ?>
                            <div class="jsvm_js-field-wrapper js-row jsvm_no-margin">
                                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo esc_html(__($field->fieldtitle, 'js-vehicle-manager')); ?></div>
                                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('video', isset(jsvehiclemanager::$_data[0]->video) ? __(jsvehiclemanager::$_data[0]->video,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                            </div>
                        <?php
                        break;
                        case 'address': ?>
                            <div class="jsvm_js-field-wrapper js-row jsvm_no-margin">
                                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo esc_html(__($field->fieldtitle, 'js-vehicle-manager')); ?></div>
                                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('address', isset(jsvehiclemanager::$_data[0]->address) ? __(jsvehiclemanager::$_data[0]->address,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one','onblur'=>'addMarkerFromAddress()')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                            </div>
                        <?php
                        break;
                        case 'description': ?>
                            <div class="jsvm_js-field-wrapper js-row jsvm_no-margin">
                                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo esc_html(__($field->fieldtitle, 'js-vehicle-manager')); ?></div>
                                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses_post(wp_editor(isset(jsvehiclemanager::$_data[0]->description) ? jsvehiclemanager::$_data[0]->description: '', 'description', array('media_buttons' => false)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                            </div>
                        <?php
                        break;
                        case 'map': ?>
                            <div class="jsvm_js-field-wrapper js-row jsvm_no-margin">
                                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo esc_html(__($field->fieldtitle, 'js-vehicle-manager')); ?></div>
                                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding">
                                    <div id="jsvm_map_container" ></div>   
                                    <div class="js-col-md-6">
                                        <label class="control-label"  id="longitudemsg" for="longitude"><?php echo __('Longitude','js-vehicle-manager')." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('longitude', isset(jsvehiclemanager::$_data[0]->longitude) ? jsvehiclemanager::$_data[0]->longitude: '', array('class' => 'form-control')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    </div>
                                    <div class="js-col-md-6">
                                        <label class="control-label"  id="latitudemsg" for="latitude"><?php echo __('Latitude','js-vehicle-manager')." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('latitude', isset(jsvehiclemanager::$_data[0]->latitude) ? jsvehiclemanager::$_data[0]->latitude: '', array('class' => 'form-control')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        break;
                        default:?>
                        <div class="jsvm_js-field-wrapper js-row jsvm_no-margin">  
                            <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo esc_html(__($field->fieldtitle, 'js-vehicle-manager')); ?></div>
                            <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-3 jsvm_no-padding">
                            <?php
                                echo JSVEHICLEMANAGERincluder::getObjectClass('customfields')->formCustomFields($field , 0 , 1 );
                            ?>
                            </div>
                        </div>
                        <?php break;
                    }
                } ?>
            <div class="jsvm_js-field-wrapper js-row jsvm_no-margin">
                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Published', 'js-vehicle-manager'); ?></div>
                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::radiobutton('status', array('1' => __('Yes', 'js-vehicle-manager'), '0' => __('No', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data[0]->status) ? jsvehiclemanager::$_data[0]->status : 1, array('class' => 'jsvm_radiobutton')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            </div>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('id', isset(jsvehiclemanager::$_data[0]->id) ? jsvehiclemanager::$_data[0]->id : ''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('jsvehiclemanager_isdefault', isset(jsvehiclemanager::$_data[0]->isdefault) ? jsvehiclemanager::$_data[0]->isdefault : ''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('created', isset(jsvehiclemanager::$_data[0]->created) ? jsvehiclemanager::$_data[0]->created : date('Y-m-d H:i:s')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('profileid', isset(jsvehiclemanager::$_data[0]->profileid) ? jsvehiclemanager::$_data[0]->profileid : ''), JSVEHICLEMANAGER_ALLOWED_TAGS);?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('hash', isset(jsvehiclemanager::$_data[0]->hash) ? jsvehiclemanager::$_data[0]->hash : ''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('form_request', 'jsvehiclemanager'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('_wpnonce', wp_create_nonce('save-user')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <div class="jsvm_js-submit-container">
                <div class="jsvm_js-button-container">
                    <a id="jsvm_form-cancel-button" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_user')); ?>" ><?php echo __('Cancel', 'js-vehicle-manager'); ?></a>
                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::submitbutton('save', __('Save','js-vehicle-manager') .' '. __('Profile', 'js-vehicle-manager'), array('class' => 'button')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<?php 
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
wp_enqueue_script('jsvm-repaptcha-scripti','https://www.google.com/recaptcha/api.js');

?>
<script type="text/javascript">
    var marker;
    jQuery(document).ready(function ($) {
        //Token Input
        getTokenInput();
        loadMap();
    });
    var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
    var multicities = <?php echo (isset(jsvehiclemanager::$_data[0]->cityid) && jsvehiclemanager::$_data[0]->cityid != '[null]')  ? jsvehiclemanager::$_data[0]->cityid :"''" ?>;    function getTokenInput() {
        var vehicleArray = '<?php echo admin_url("admin.php?page=jsvm_city&action=jsvmtask&task=getaddressdatabycityname"); ?>';
        jQuery("#cityid").tokenInput(vehicleArray, {
            theme: "jsvehiclemanager",
            preventDuplicates: true,
            hintText: "<?php echo __('Type In A Search Term', 'js-vehicle-manager'); ?>",
            noResultsText: "<?php echo __('No Results', 'js-vehicle-manager'); ?>",
            searchingText: "<?php echo __('Searching', 'js-vehicle-manager'); ?>",
            tokenLimit:1,
            prePopulate: multicities,
            onResult: function(item) {
                if (jQuery.isEmptyObject(item)){
                    return [{id:0, name: jQuery("tester").text()}];
                } else {
                    //add the item at the top of the dropdown
                    item.unshift({id:0, name: jQuery("tester").text()});
                    return item;
                }
            },
            onAdd: function(item) {
                if (item.id > 0){
                    addMarkerOnMap(item.name);
                    return; 
                }
                <?php $newtyped_cities = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('newtyped_cities');
                if ($newtyped_cities == 1) { ?>
                    if (item.name.search(",") == - 1) {
                    var input = jQuery("tester").text();
                            alert ("<?php echo __('Location Format Is Not Correct Please Enter City In This Format City Name Country Name Or City Name State Name Country Name', 'js-vehicle-manager'); ?>");
                            jQuery("#cityid").tokenInput("remove", item);
                            return false;
                    } else{
                    var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
                            jQuery.post(ajaxurl, {action: 'jsvehiclemanager_ajax', jsvehiclemanagerme: 'city', task: 'savetokeninputcity', citydata: jQuery("tester").text(),wpnoncecheck:common.wp_vm_nonce}, function(data){
                            if (data){
                            try {
                            var value = jQuery.parseJSON(data);
                                    jQuery('#cityid').tokenInput('remove', item);
                                    jQuery('#cityid').tokenInput('add', {id: value.id, name: value.name});
                            }
                            catch (err) {
                            jQuery("#cityid").tokenInput("remove", item);
                                    alert(data);
                            }
                            }
                            });
                        }
                <?php } ?>
            },onDelete: function(item){
                    if(marker != undefined){
                        marker.setMap(null);
                        jQuery("input#latitude").val("");
                        jQuery("input#longitude").val("");
                    }
                }
            
        });
    }
    
    function addMarkerOnMap(location){
        var geocoder =  new google.maps.Geocoder();
        geocoder.geocode( { 'address': location}, function(results, status) {
            var latlng = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
            if (status == google.maps.GeocoderStatus.OK) {
                if(map != null){
                    addMarker(latlng);
                    map.setCenter(latlng);
                }
            } else {
                //alert("<?php echo __('Something got wrong','js-vehicle-manager');?>:"+status);
            }
        });
    }
    
    function addMarkerFromAddress(){
        var location_str = jQuery("input#address").val();
        addMarkerOnMap(location_str);
    }
</script>
<style type="text/css">
    div#jsvm_map_container{
        height:350px; ?>;
        width:100%;
    }    
</style>
<input type="hidden" id="default_longitude" name="default_longitude" value="<?php echo (isset(jsvehiclemanager::$_data[0]->longitude) && jsvehiclemanager::$_data[0]->longitude !='' ) ? jsvehiclemanager::$_data[0]->longitude : esc_attr(jsvehiclemanager::$_config['default_longitude']); ?>"/>
<input type="hidden" id="default_latitude" name="default_latitude" value="<?php echo (isset(jsvehiclemanager::$_data[0]->latitude) && jsvehiclemanager::$_data[0]->latitude !='' ) ? jsvehiclemanager::$_data[0]->latitude : esc_attr(jsvehiclemanager::$_config['default_latitude']); ?>"/>
<?php if((isset(jsvehiclemanager::$_data[0]->longitude) && jsvehiclemanager::$_data[0]->longitude !='') && (isset(jsvehiclemanager::$_data[0]->longitude) && jsvehiclemanager::$_data[0]->longitude !='') ){?>
        <input type="hidden" id="jsvm_addmarker" name="addmarker" value="1"/>
<? }else{?>
        <input type="hidden" id="jsvm_addmarker" name="addmarker" value="0"/>    
<?php }

?>
<script type="text/javascript">
    var marker;
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
        google.maps.event.addListener(map, "click", function (e) {
            var latLng = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
            geocoder = new google.maps.Geocoder();
            geocoder.geocode({'latLng': latLng}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                addMarker(results[0].geometry.location);
            } else {
                alert("<?php echo __('Geocode was not successful for the following reason', 'js-vehicle-manager'); ?>: " + status);
            }
            });
        });
    }
    
    function addMarker (latlang){
        if (marker) {
            //if marker already was created change positon
            marker.setPosition(latlang);
            map.setCenter(latlang);
            if(marker.map == null){
                marker = new google.maps.Marker({
                    position: latlang,
                    map: map,
                    center: latlang,
                    draggable: true,
                    scrollwheel: false,
                });

                marker.setMap(map);
                map.setCenter(latlang)
                marker.addListener("dblclick", function() {
                    marker.setMap(null);
                    jQuery("input#latitude").val("");
                    jQuery("input#longitude").val("");
                });
            }
        }else{
            marker = new google.maps.Marker({
                position: latlang,
                map: map,
                draggable: true,
                scrollwheel: false,
            });
            marker.setMap(map);
             map.setCenter(latlang);
            marker.addListener("dblclick", function() {
                marker.setMap(null);
                jQuery("input#latitude").val("");
                jQuery("input#longitude").val("");
            });
        }
        jQuery("input#latitude").val(marker.position.lat());
        jQuery("input#longitude").val(marker.position.lng());
    }


    function removePhoto(){
        jQuery("div.jsvm_profile-profileimg-overlay").show();
        jQuery("span.jsvm_remove-file").hide();
        jQuery("input#deleteimage").val(1);
    }
</script>
