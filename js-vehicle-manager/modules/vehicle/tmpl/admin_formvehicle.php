<?php if (!defined('ABSPATH')) die('Restricted Access');
$discounttypes = array(
            (object) array('id' => 1, 'text' => __('Percentage', 'js-vehicle-manager')),
            (object) array('id' => 0, 'text' => __('Amount', 'js-vehicle-manager')));
wp_enqueue_script('jquery-ui-datepicker');
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
wp_enqueue_style('jquery-ui-css', $protocol.'ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
$dateformat = jsvehiclemanager::$_config['date_format'];
if ($dateformat == 'm/d/Y' || $dateformat == 'd/m/y' || $dateformat == 'm/d/y' || $dateformat == 'd/m/Y') {
    $dash = '/';
} else {
    $dash = '-';
}
$firstdash = strpos($dateformat, $dash, 0);
$firstvalue = substr($dateformat, 0, $firstdash);
$firstdash = $firstdash + 1;
$seconddash = strpos($dateformat, $dash, $firstdash);
$secondvalue = substr($dateformat, $firstdash, $seconddash - $firstdash);
$seconddash = $seconddash + 1;
$thirdvalue = substr($dateformat, $seconddash, strlen($dateformat) - $seconddash);
$js_dateformat = '%' . $firstvalue . $dash . '%' . $secondvalue . $dash . '%' . $thirdvalue;
$js_scriptdateformat = $firstvalue . $dash . $secondvalue . $dash . $thirdvalue;
$js_scriptdateformat = str_replace('Y', 'yy', $js_scriptdateformat);
?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $.validate({
            onError : function(){
                jsvm_hideloading();
            }
        });
        $('.custom_date').datepicker({dateFormat: '<?php echo $js_scriptdateformat; ?>'});
        jQuery("a#jsvm_userpopup").click(function (e) {
            e.preventDefault();
            jQuery("div#jsvm_popup-new-company").css("display", "none");
            jQuery("img.jsvm_icon").css("display", "none");

            jQuery("div#jsvm_popup-record-data").css("display", "block");
            jQuery("div#jsvm_full_background").show();
            var ajaxurl = "<?php echo esc_url(admin_url('admin-ajax.php')) ?>";
            jsvm_showloading();
            jQuery.post(ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'user', task: 'getSellerListAjax',wpnoncecheck:common.wp_vm_nonce}, function (data) {
                if (data) {
                    jQuery("div#jsvm_popup-record-data").html("");
                    jQuery("span#jsvm_popup_title").html(jQuery("input#jsvm_user-popup-title-text").val());
                    jQuery("div#jsvm_popup-record-data").html(data);
                    setUserLink();
                }
                jsvm_hideloading();
            });
            jQuery("div#jsvm_popup_main").slideDown('slow');
        });

        jQuery(document).delegate('form#jsvm_userpopupsearch', 'submit', function (e) {
            e.preventDefault();
            e.preventDefault();
            var username = jQuery("input#jsvm_uname").val();
            var name = jQuery("input#jsvm_name").val();
            var emailaddress = jQuery("input#jsvm_email").val();
            var ajaxurl = "<?php echo esc_url(admin_url('admin-ajax.php')) ?>";
            jQuery.post(ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'user', task: 'getSellerListAjax', name: name, uname: username, email: emailaddress, listfor: 1,wpnoncecheck:common.wp_vm_nonce}, function (data) {
                if (data) {
                    jQuery("span#jsvm_popup_title").html(jQuery("input#jsvm_user-popup-title-text").val());
                    jQuery("div#jsvm_popup-record-data").html(data);
                    setUserLink();
                }
            });//jquery closed
        });

        jQuery("span.jsvm_close, div#jsvm_full_background,img#jsvm_popup_cross").click(function (e) {
            jQuery("div#jsvm_popup_main").slideUp('slow', function () {
                jQuery("div#jsvm_full_background").hide();
            });

        });
    });


    function updateuserlist(pagenum) {
        var ajaxurl = "<?php echo esc_url(admin_url('admin-ajax.php')) ?>";
        jQuery.post(ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'user', task: 'getSellerListAjax', userlimit: pagenum,wpnoncecheck:common.wp_vm_nonce}, function (data) {
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
                jQuery("div#jsvm_sname-div").html(name);

                var id = jQuery(this).attr('data-sid');
                jQuery('input.jsvm_credit-userid').attr('data-credit-userid',id);
                jQuery('input#jsvm_uid').val(id);

                jQuery('div#jsvehiclemanager-adminadd-vehicle').hide();
                jQuery('div#jsvehiclemanager-selleradd-vehicle').show();


                jQuery("div#jsvm_popup_main").slideUp('slow', function () {
                    jQuery("div#jsvm_full_background").hide();
                });
            });
        });
    }
</script>

<?php
$section_userfields = $section_body = $section_drivetrain = $section_exterior = $section_interior = $section_electrnoics = $section_safetyfeature = '0';
$status = array((object) array('id' => 0, 'text' => __('Pending', "js-vehicle-manager")), (object) array('id' => 1, 'text' => __('Approved', "js-vehicle-manager")), (object) array('id' => -1, 'text' => __('Rejected', "js-vehicle-manager")));
    function checkrowcount(&$rowcount){
            if ($rowcount == 0) {
                echo '<div class="jsvehiclemanager-add-veh-from">';
            }elseif ($rowcount % 2 == 0) {
                echo '</div>';
                echo '<div class="jsvehiclemanager-add-veh-from">';
            }
            $rowcount++;
        }
?>

<div style="display:none;" id="jsvm_ajaxloaded_wait_overlay"></div>
<img style="display:none;" id="jsvm_ajaxloaded_wait_image" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/loading.gif'; ?>">

<div id="jsvehiclemanageradmin-wrapper">
    <div id="jsvm_full_background" style="display:none;"></div>
    <div id="jsvm_popup_main" style="display:none;">
        <span class="jsvm_popup-top"><span id="jsvm_popup_title" ></span><img id="jsvm_popup_cross" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/popup-close.png"></span>
            <div class="js-vehicle-manager-sellerpopupwrapper">
                <form id="jsvm_userpopupsearch">
                    <div class="jsvm_search-center">
                        <div class="js-vehicle-manager-searchpopupwrapper">
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
            <a href="<?php echo esc_url(admin_url('admin.php?page=jsvm_vehicle')); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" /></a>
            <?php $msg = isset(jsvehiclemanager::$_data[0]) ? __('Edit', 'js-vehicle-manager') : __('Add New','js-vehicle-manager'); ?>
            <?php echo esc_html($msg) . ' ' . __('Vehicle', 'js-vehicle-manager'); ?>
        </span>
        <?php
        $default_value = JSVEHICLEMANAGERincluder::getJSModel('common')->getDefaultValuesForVehicleCombos();
        $user = jsvehiclemanager::$_data['user'];
        ?>
        <div id="jsvehiclemanager-add-vehicle-wrap">
            <form  method="post" name="adminForm" id="jsvm_adminForm" class="jsvm_form-validate js-form-horizontal" enctype="multipart/form-data" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_vehicle&action=jsvmtask&task=savevehicle")); ?>">
                <div class="jsvehiclemanager-form-field-wrapper">
                    <?php
                        if( ! isset(jsvehiclemanager::$_data[0]->uid)){ ?>

                    <div class="jsvehiclemanager-vehicleform-admininfo">
                        <div class="jsvm_admininfo-vehicleform-field-left">
                            <div class="jsvm_admininfo-vform-field"><span> <?php echo __('Name' , 'js-vehicle-manager'); ?>:&nbsp;</span> <?php echo esc_attr($user->name); ?></div>
                            <div class="jsvm_admininfo-vform-field"><span> <?php echo __('Email' , 'js-vehicle-manager'); ?>:&nbsp;</span><?php echo esc_attr($user->email); ?></div>
                        </div>
                        <div class="jsvm_admininfo-vehicleform-field-right">
                            <a class="jsvm_admininfo-vform-field-a" target="_blank" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_user&jsvmlt=formprofile&jsvehiclemanagerid='.$user->id)); ?>"> <?php echo __('Edit Profile'); ?></a>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                    <div class="jsvm_js-form-wrapper">
                        <label id="jsvm_sellerid" for="sellerid" class="jsvehiclemanager-title"><?php echo __('Select seller','js-vehicle-manager')." :"; ?></label>
                        <div id="jsvm_sname-div" class="jsvm_selected-seller-div" ><?php echo isset(jsvehiclemanager::$_data[0]->name) ? esc_html(jsvehiclemanager::$_data[0]->name) : ''; ?></div>
                        <a href="#" id="jsvm_userpopup" class="jsvm_cm-userpopup vehicle-form">
                            <?php echo __('Select','js-vehicle-manager') .' '. __('Seller', 'js-vehicle-manager'); ?>
                        </a>
                        <img class="jsvehiclem-img" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/info-icon.png" />
                        <span class="jsvehiclem-desc"><?php echo __('Your profile will be use if you do not select seller.' , 'js-vehicle-manager'); ?></span>
                    </div>
                    <?php
                    $rowcount = 0;
                    foreach (jsvehiclemanager::$_data[3] as $field) {
                        switch ($field->field) {
                            case "vehicletype": checkrowcount($rowcount);?>
                                    <div class="jsvm_js-form-wrapper">
                                        <label id="jsvm_vechiletypeidmsg" for="vehicletypeid" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                            <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                        </label>
                                        <div class="jsvehiclemanager-value">
                                            <?php  echo wp_kses(JSVEHICLEMANAGERformfield::select('vehicletypeid', JSVEHICLEMANAGERincluder::getJSModel('vehicletype')->getVehicletypeForCombo(),isset(jsvehiclemanager::$_data[0]->vehicletypeid)? jsvehiclemanager::$_data[0]->vehicletypeid : $default_value['vehicletypes'] ,__('Select type', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                    <?php
                            break;
                            case "make": checkrowcount($rowcount);?>
                                    <div class="jsvm_js-form-wrapper">
                                        <label id="jsvm_makeidmsg" for="makeid" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                            <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                        </label>
                                         <div class="jsvehiclemanager-value">
                                            <?php  echo wp_kses(JSVEHICLEMANAGERformfield::select('makeid', JSVEHICLEMANAGERincluder::getJSModel('make')->getMakeForCombo(),isset(jsvehiclemanager::$_data[0]->makeid)? jsvehiclemanager::$_data[0]->makeid :'',__('Select make', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox','onchange' => 'getmodels(\'modelid\', this.value);', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                    <?php
                            break;
                            case "model": checkrowcount($rowcount);?>
                                    <div class="jsvm_js-form-wrapper">
                                        <label id="jsvm_modelidmsg" for="modelid" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                            <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            <img id="makemodelloading-gif" style="display:none;" src="<?php echo CAR_MANAGER_IMAGE;?>/makemodelloading.gif" />
                                        </label>
                                        <div class="jsvehiclemanager-value" id="vf_models">
                                            <?php  echo wp_kses(JSVEHICLEMANAGERformfield::select('modelid', JSVEHICLEMANAGERincluder::getJSModel('model')->getVehiclesModelsbyMakeId(isset(jsvehiclemanager::$_data[0]->makeid)? jsvehiclemanager::$_data[0]->makeid :''),isset(jsvehiclemanager::$_data[0]->modelid)? jsvehiclemanager::$_data[0]->modelid :'',__('Select model','js-vehicle-manager'), array('class' => 'jsvm_inputbox', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                    <?php
                            break;
                            case "condition": checkrowcount($rowcount);?>
                                    <div class="jsvm_js-form-wrapper">
                                        <label id="jsvm_modelidmsg" for="conditionid" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                            <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                        </label>
                                        <div class="jsvehiclemanager-value">
                                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('conditionid', JSVEHICLEMANAGERincluder::getJSModel('conditions')->getConditionForCombo(), isset(jsvehiclemanager::$_data[0]->conditionid)? jsvehiclemanager::$_data[0]->conditionid :'' , __('Select condition', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                 <?php
                            break;
                            case "modelyear": checkrowcount($rowcount); ?>
                                    <div class="jsvm_js-form-wrapper">
                                        <label id="jsvm_modelyearidmsg" for="modelyearid" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                            <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                        </label>
                                        <div class="jsvehiclemanager-value">
                                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('modelyearid', JSVEHICLEMANAGERincluder::getJSModel('modelyears')->getModelyearsForCombo(), isset(jsvehiclemanager::$_data[0]->modelyearid)? jsvehiclemanager::$_data[0]->modelyearid : $default_value['modelyears'] , '', array('class' => 'jsvm_inputbox', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                    <?php
                            break;
                            case "fueltype": checkrowcount($rowcount); ?>
                                    <div class="jsvm_js-form-wrapper">
                                        <label id="jsvm_fueltypeidmsg" for="fueltypeid" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                            <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                        </label>
                                        <div class="jsvehiclemanager-value">
                                            <?php  echo wp_kses(JSVEHICLEMANAGERformfield::select('fueltypeid', JSVEHICLEMANAGERincluder::getJSModel('fueltypes')->getFueltypeForCombo(),isset(jsvehiclemanager::$_data[0]->fueltypeid)? jsvehiclemanager::$_data[0]->fueltypeid : $default_value['fueltypes'],'', array('class' => 'jsvm_inputbox', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                    <?php
                            break;
                            case "cylinder": checkrowcount($rowcount); ?>
                                    <div class="jsvm_js-form-wrapper">
                                        <label id="jsvm_cylinderidmsg" for="cylinderid" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                            <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                        </label>
                                        <div class="jsvehiclemanager-value">
                                               <?php  echo wp_kses(JSVEHICLEMANAGERformfield::select('cylinderid', JSVEHICLEMANAGERincluder::getJSModel('cylinders')->getCylinderForCombo(),isset(jsvehiclemanager::$_data[0]->cylinderid)? jsvehiclemanager::$_data[0]->cylinderid : $default_value['cylinders'] ,'', array('class' => 'jsvm_inputbox', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                    <?php
                            break;
                            case "adexpiry": checkrowcount($rowcount);
                                $check_flag = apply_filters("jsvm_credits_check_expiry_exists",0,'add_vehicle');
                                if($check_flag == 0){ ?>
                                   <div class="jsvm_js-form-wrapper">
                                        <label id="adexpiryidmsg" for="adexpiryid" class="jsvehiclemanager-title">
                                                <?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?>
                                                <?php
                                                if(isset(jsvehiclemanager::$_data[0]->adexpiryvalue)){ ?>
                                                    <span class="jsvehiclemanager-form-vehicle-expiry-date">
                                                        <?php echo __('Expiry Date','js-vehicle-manager').': '.esc_html(date_i18n(jsvehiclemanager::$_config['date_format'],strtotime(jsvehiclemanager::$_data[0]->adexpiryvalue))); ?>
                                                    </span>
                                                <?php } ?>
                                        </label>
                                        <div class="jsvehiclemanager-value">
                                            <?php  echo wp_kses(JSVEHICLEMANAGERformfield::select('adexpiryid', JSVEHICLEMANAGERincluder::getJSModel('adexpiry')->getVehiclesAdexpirie(),isset(jsvehiclemanager::$_data[0]->adexpiryid)? jsvehiclemanager::$_data[0]->adexpiryid:'',__('Select Ad Expiry', 'js-vehicle-manager'), array('class' => 'inputbox','data-placeholder'=> __('Select ad expiry', 'js-vehicle-manager'),'data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                    <?php
                                }elseif(isset(jsvehiclemanager::$_data[0]->adexpiryvalue)){ ?>
                                    <div class="jsvm_js-form-wrapper">
                                         <label id="adexpiryidmsg" for="adexpiryid" class="jsvehiclemanager-title">
                                                 <?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?>
                                                 <?php
                                                 if(isset(jsvehiclemanager::$_data[0]->adexpiryvalue)){ ?>
                                                     <span class="jsvehiclemanager-form-vehicle-expiry-date">
                                                         <?php echo __('Expiry Date','js-vehicle-manager').': '.esc_html(date_i18n(jsvehiclemanager::$_config['date_format'],strtotime(jsvehiclemanager::$_data[0]->adexpiryvalue))); ?>
                                                     </span>
                                                 <?php } ?>
                                         </label>
                                         <div class="jsvehiclemanager-value">
                                             <?php  echo wp_kses(JSVEHICLEMANAGERformfield::select('adexpiryid', JSVEHICLEMANAGERincluder::getJSModel('adexpiry')->getVehiclesAdexpirie(),isset(jsvehiclemanager::$_data[0]->adexpiryid)? jsvehiclemanager::$_data[0]->adexpiryid:'',__('Select Ad Expiry', 'js-vehicle-manager'), array('class' => 'inputbox','data-placeholder'=> __('Select ad expiry', 'js-vehicle-manager'),'data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                         </div>
                                     </div>
                                <?php }
                            break;
                            case "price": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper">
                                            <label id="jsvm_cylinderidmsg" for="price" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value">
                                                <div class="jsvehiclemanager-currency-wrap">
                                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('currencyid', JSVEHICLEMANAGERincluder::getJSModel('currency')->getCurrencyForCombo(), isset(jsvehiclemanager::$_data[0]->currencyid)? jsvehiclemanager::$_data[0]->currencyid : $default_value['currencies'] , '', array('class' => 'jsvm_inputbox', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                                </div>
                                                <div class="jsvehiclemanager-price-wrap">
                                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('price', isset(jsvehiclemanager::$_data[0]->price) ? __(jsvehiclemanager::$_data[0]->price,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => 'required', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                                </div>
                                            </div>
                                        </div>
                            <?php
                            break;
                            case "transmission": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper">
                                            <label id="jsvm_cylinderidmsg" for="transmissionid" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value">
                                                <?php  echo wp_kses(JSVEHICLEMANAGERformfield::select('transmissionid', JSVEHICLEMANAGERincluder::getJSModel('transmissions')->getTransmissionsForCombo(),isset(jsvehiclemanager::$_data[0]->transmissionid)? jsvehiclemanager::$_data[0]->transmissionid : $default_value['transmissions'] ,'', array('class' => 'jsvm_inputbox', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "mileages": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper jsvm_speedometer">
                                            <label id="jsvm_cylinderidmsg" for="mileages" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('mileages', isset(jsvehiclemanager::$_data[0]->mileages) ? __(jsvehiclemanager::$_data[0]->mileages,'js-vehicle-manager') : $default_value['mileages'] , array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => 'required', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                                <span class="jsvm_speedometer"></span>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "speedmetertype": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper">
                                            <label id="jsvm_speedmetertypeidmsg" for="speedmetertypeid" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value">
                                                <?php  echo wp_kses(JSVEHICLEMANAGERformfield::select('speedmetertypeid', JSVEHICLEMANAGERincluder::getJSModel('mileages')->getMileagesForCombo(),isset(jsvehiclemanager::$_data[0]->speedmetertypeid)? jsvehiclemanager::$_data[0]->speedmetertypeid:'','', array('class' => 'jsvm_inputbox', 'onchange' => "speedmeterchange(this)", 'data-symbols' => jsvehiclemanager::$_data['mileage_symbols'], 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "stocknumber": checkrowcount($rowcount); ?>
                                    <div class="jsvm_js-form-wrapper">
                                        <label id="jsvm_stocknumbermsg" for="stocknumber" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                            <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                        </label>
                                        <div class="jsvehiclemanager-value">
                                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('stocknumber', isset(jsvehiclemanager::$_data[0]->stocknumber) ? __(jsvehiclemanager::$_data[0]->stocknumber,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                    <?php
                            break;
                            case "registrationnumber": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper">
                                            <label id="jsvm_registrationnumbermsg" for="registrationnumber" class="jsvehiclemanager-title"><?php echo __($field->fieldtitle,'js-vehicle-manager')." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('registrationnumber', isset(jsvehiclemanager::$_data[0]->registrationnumber) ? __(jsvehiclemanager::$_data[0]->registrationnumber,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "registrationcity": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper">
                                            <label id="jsvm_regcitymsg" for="regcity" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value" id="jsvm_vehicleform_regcity">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('regcity', isset(jsvehiclemanager::$_data[0]->regcity) ? __(jsvehiclemanager::$_data[0]->regcity,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "locationcity": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper">
                                            <label id="jsvm_loccitymsg" for="loccity" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value" id="jsvm_vehicleform_loccity">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('loccity', isset(jsvehiclemanager::$_data[0]->loccity) ? __(jsvehiclemanager::$_data[0]->loccity,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "loczip": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper">
                                            <label id="jsvm_loczipmsg" for="loczip" class="jsvehiclemanager-title"><?php echo __($field->fieldtitle,'js-vehicle-manager')." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value" id="jsvm_vehicleform_loczip">
                                               <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('loczip', isset(jsvehiclemanager::$_data[0]->loczip) ? __(jsvehiclemanager::$_data[0]->loczip,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "streetaddress": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper">
                                            <label id="jsvm_streetaddressmsg" for="streetaddress" class="jsvehiclemanager-title"><?php echo __($field->fieldtitle,'js-vehicle-manager')." :"; ?> <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?></label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('streetaddress', isset(jsvehiclemanager::$_data[0]->streetaddress) ? __(jsvehiclemanager::$_data[0]->streetaddress,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => $req,'onblur'=>'addMarkerFromAddress()')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "bargainprice": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper">
                                            <label id="jsvm_bargainpricemsg" for="bargainprice" class="jsvehiclemanager-title"><?php echo __($field->fieldtitle,'js-vehicle-manager')." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('bargainprice', isset(jsvehiclemanager::$_data[0]->bargainprice) ? __(jsvehiclemanager::$_data[0]->bargainprice,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?> <span class="jsvm_pricecurrency"></span>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "exportprice": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper">
                                            <label id="jsvm_exportpricemsg" for="exportprice" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('exportprice', isset(jsvehiclemanager::$_data[0]->exportprice) ? __(jsvehiclemanager::$_data[0]->exportprice,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?> <span class="jsvm_pricecurrency"></span>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "isdiscount": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper">
                                            <label id="jsvm_isdiscountmsg" for="isdiscount" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value">
                                                <div class="jsvm_div-white">
                                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::radiobutton('isdiscount', array('1' => __('Yes', 'js-vehicle-manager'), '0' => __('No', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data[0]->isdiscount) ? jsvehiclemanager::$_data[0]->isdiscount : 0, array('class' => 'form-control','data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "discount": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper">
                                            <label id="jsvm_discountmsg" for="discount" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('discount', isset(jsvehiclemanager::$_data[0]->discount) ? __(jsvehiclemanager::$_data[0]->discount,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "discounttype": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper">
                                            <label id="jsvm_discounttypemsg" for="discounttype" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value">
                                                <?php  echo wp_kses(JSVEHICLEMANAGERformfield::select('discounttype', $discounttypes, isset(jsvehiclemanager::$_data[0]->discounttype)? jsvehiclemanager::$_data[0]->discounttype:'','', array('class' => 'form-control  jsvm_selectpicker',"data-live-search"=>"true",'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "discountstart": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper">
                                            <label id="jsvm_discountstartmsg" for="discountstart" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('discountstart', isset(jsvehiclemanager::$_data[0]->discountstart) ? __(jsvehiclemanager::$_data[0]->discountstart,'js-vehicle-manager') : '', array('class' => 'form-control jsvm_inputbox jsvm_one custom_date', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "discountend": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper">
                                            <label id="jsvm_discountendmsg" for="discountend" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('discountend', isset(jsvehiclemanager::$_data[0]->discountend) ? __(jsvehiclemanager::$_data[0]->discountend,'js-vehicle-manager') : '', array('class' => 'form-control jsvm_inputbox jsvm_one custom_date','data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "exteriorcolor": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper">
                                            <label id="jsvm_exteriorcolormsg" for="exteriorcolor" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('exteriorcolor', isset(jsvehiclemanager::$_data[0]->exteriorcolor) ? __(jsvehiclemanager::$_data[0]->exteriorcolor,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "interiorcolor": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper">
                                            <label class="jsvehiclemanager-title"  id="jsvm_interiorcolormsg" for="interiorcolor"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('interiorcolor', isset(jsvehiclemanager::$_data[0]->interiorcolor) ? __(jsvehiclemanager::$_data[0]->interiorcolor,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "enginecapacity": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper">
                                            <label class="jsvehiclemanager-title"  id="jsvm_enginecapacitymsg" for="enginecapacity"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('enginecapacity', isset(jsvehiclemanager::$_data[0]->enginecapacity) ? __(jsvehiclemanager::$_data[0]->enginecapacity,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "cityfuelconsumption": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper jsvm_speedometer">
                                            <label class="jsvehiclemanager-title"  id="jsvm_cityfuelconsumptionmsg" for="cityfuelconsumption"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('cityfuelconsumption', isset(jsvehiclemanager::$_data[0]->cityfuelconsumption) ? __(jsvehiclemanager::$_data[0]->cityfuelconsumption,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                                <span class="speedometer"></span>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "highwayfuelconsumption": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper jsvm_speedometer">
                                            <label class="jsvehiclemanager-title"  id="jsvm_highwayfuelconsumptionmsg" for="highwayfuelconsumption"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('highwayfuelconsumption', isset(jsvehiclemanager::$_data[0]->highwayfuelconsumption) ? __(jsvehiclemanager::$_data[0]->highwayfuelconsumption,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                                <span class="jsvm_speedometer"></span>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "acceleration": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper">
                                            <label class="jsvehiclemanager-title"  id="jsvm_accelerationmsg" for="acceleration"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <span class="jsvm_small-text"><?php echo __('(0-100)'); ?></span>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value">
                                                <span class="jsvm_speedometer"></span><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('acceleration', isset(jsvehiclemanager::$_data[0]->acceleration) ? __(jsvehiclemanager::$_data[0]->acceleration,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "maxspeed": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper">
                                            <label class="jsvehiclemanager-title"  id="jsvm_maxspeedmsg" for="maxspeed"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('maxspeed', isset(jsvehiclemanager::$_data[0]->maxspeed) ? __(jsvehiclemanager::$_data[0]->maxspeed,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "map": ?>
                                        <div class="jsvm_js-form-wrapper jsvm_map">
                                            <label class="jsvehiclemanager-title"  id="jsvm_mapmsg" for="map"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> </label>
                                            <div class="jsvehiclemanager-value jsvm_map">
                                                <div id="jsvm_map_container"></div>
                                            </div>
                                        </div>
                                        <div class="jsvm_js-form-wrapper map">
                                            <div class="jsvehiclemanager-value jsvm_longitude">
                                                <label class="jsvehiclemanager-title"  id="longitudemsg" for="longitude"><?php echo __('Longitude','js-vehicle-manager')." :"; ?> </label>
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('longitude', isset(jsvehiclemanager::$_data[0]->longitude) ? __(jsvehiclemanager::$_data[0]->longitude,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                            <div class="jsvehiclemanager-value jsvm_latitude">
                                                <label class="jsvehiclemanager-title"  id="latitudemsg" for="latitude"><?php echo __('Latitude','js-vehicle-manager')." :"; ?></label>
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('latitude', isset(jsvehiclemanager::$_data[0]->latitude) ? __(jsvehiclemanager::$_data[0]->latitude,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "video": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper">
                                            <label class="jsvehiclemanager-title"  id="jsvm_videomsg" for="video"><?php echo __('Video Type','js-vehicle-manager')." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value">
                                                 <?php echo wp_kses(JSVEHICLEMANAGERformfield::radiobutton('videotype', array(1 => __('Youtube video Link', 'js-vehicle-manager'), 2 => __('Embedded html', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data[0]->videotype) ? jsvehiclemanager::$_data[0]->videotype : '', array('class' => 'jsvm_inputbox', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php echo  checkrowcount($rowcount);?>
                                        <div class="jsvm_js-form-wrapper">
                                            <label class="jsvehiclemanager-title"  id="jsvm_videomsg" for="video"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('video', isset(jsvehiclemanager::$_data[0]->video) ? __(jsvehiclemanager::$_data[0]->video,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                                break;
                            case "engincenumber": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper">
                                            <label class="jsvehiclemanager-title"  id="jsvm_enginenumbermsg" for="enginenumber"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('enginenumber', isset(jsvehiclemanager::$_data[0]->enginenumber) ? __(jsvehiclemanager::$_data[0]->enginenumber,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "chasisnumber": checkrowcount($rowcount); ?>
                                        <div class="jsvm_js-form-wrapper">
                                            <label class="jsvehiclemanager-title"  id="jsvm_chasisnumbermsg" for="chasisnumber"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                                <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                            </label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('chasisnumber', isset(jsvehiclemanager::$_data[0]->chasisnumber) ? __(jsvehiclemanager::$_data[0]->chasisnumber,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "co2": checkrowcount($rowcount); ?>
                                    <div class="jsvm_js-form-wrapper">
                                        <label id="jsvm_co2msg" for="co2" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>
                                            <?php
                                                $req = '';
                                                if ($field->required == 1) {
                                                    $req = 'required';
                                                    echo '<font color="red">&nbsp*</font>';
                                                }
                                            ?>
                                        </label>
                                        <div class="jsvehiclemanager-value">
                                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('co2', isset(jsvehiclemanager::$_data[0]->co2) ? __(jsvehiclemanager::$_data[0]->co2,'js-vehicle-manager') : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                <?php
                            break;
                            case 'brochure': checkrowcount($rowcount); ?>
                                <div class="jsvm_js-form-wrapper">
                                    <label for="brochure" class="control-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?>
                                        <?php
                                            $req = '';
                                            if ($field->required == 1) {
                                                $req = 'required';
                                                echo '<font color="red">&nbsp*</font>';
                                            }
                                        ?>
                                    </label>
                                    <input type="file" name="brochure" id="jsvm_brochure" value="" data-validation="<?php echo esc_attr($req); ?>" />
                                    <?php
                                        echo '<div class="jsvm_cm_file_info">'.__('Maximum file size allowed','js-vehicle-manager').' <b>('.JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('allowed_file_size').' '.__('KB','js-vehicle-manager').')</b></div>';
                                        echo '<div class="jsvm_cm_file_info">'.__('File type allowed','js-vehicle-manager').' <b>('.JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('file_file_type').')</b></div>';
                                        if(isset(jsvehiclemanager::$_data[0]->brochure) && jsvehiclemanager::$_data[0]->brochure != ''){
                                            echo '<input type="checkbox" name="removebrochurefile" id="jsvm_removebrochurefile" value="1" /> '.__('Delete','js-vehicle-manager').' ('.esc_html(basename(jsvehiclemanager::$_data[0]->brochure)).')';
                                        }
                                    ?>
                                </div>
                            <?php
                            break;
                            case 'description': checkrowcount($rowcount); ?>
                                <div class="jsvm_js-form-wrapper jsvm_description">
                                    <label for="description" class="control-label"><?php echo __($field->fieldtitle,'js-vehicle-manager');?></label>
                                    <div class="jsvehiclemanager-value">
                                        <?php echo wp_kses(wp_editor(isset(jsvehiclemanager::$_data[0]->description) ? jsvehiclemanager::$_data[0]->description: '', 'vechiledescription', array('media_buttons' => false, 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    </div>
                                </div>
                            <?php
                                break;
                            default:
                                $u_field = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->formCustomFields($field);
                                if($u_field){
                                    checkrowcount($rowcount);
                                    echo wp_kses($u_field, JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                        }
                    }
                    echo "</div>";
                    ?>
                </div>

 <div class="jsvehiclemanager-form-section-checkbox-wrap">
                        <div class="jsvm_checkbox-heading">
                            <?php echo __('Vehicle Options Check Any That Apply','js-vehicle-manager'); ?>
                        </div>
                        <?php
                            $colcount = 1;
                            $count = 0;
                            function getCheckboxField(&$count,$fieldname,$vehicleoptions,$lang){
                                $content = '<div class= "jsvm_vehicle-details-checkbox jsvm_checkboxes">';

                                $content .= '
                                            <div class="jsvm_js-checkbox">
                                                <label for="'.$fieldname.'">
                                                    <input type="checkbox" name="'.$fieldname.'" id="'.$fieldname.'" value="1" ';
                                if (isset($vehicleoptions[$fieldname])){
                                    $content .= ($vehicleoptions[$fieldname] == 1) ? 'checked="checked"' : '';
                                }
                                $content .= ' />';
                                $content .= __($lang , 'js-vehicle-manager');
                                $content .= '</label>
                                            </div>
                                        </div>  ';
                                        $count++;
                                return $content;
                            }

                            function newSection($count,$lang){
                                if ($count > 0) echo "</div>";
                                $count = 0;
                                $content = '<div class="jsvm_checkbox-headings">
                                                '.__($lang,'js-vehicle-manager').'
                                            </div><div class="jsvm_checkbox-sections">';
                                echo $content;
                                return $count;
                            }

                //Body section
                if(isset(jsvehiclemanager::$_data[1]['body'])){
                    $vehicloptions = jsvehiclemanager::$_data[1]['body'];
                }else{
                    $vehicloptions = array();
                }
                foreach (jsvehiclemanager::$_data[4]['body'] as $field) {
                    switch ($field->field) {
                        case "section_body":
                            $count = newSection($count,'BODY');
                            $section_body = 1;
                        break;
                        case "2door":
                            if ($section_body == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "3door":
                            if ($section_body == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "4door":
                            if ($section_body == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "5door":
                            if ($section_body == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "convertible":
                            if ($section_body == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "crewcab":
                            if ($section_body == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "extendedcab":
                            if ($section_body == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "longbox":
                            if ($section_body == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "offroadpackage":
                            if ($section_body == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "shortbox":
                            if ($section_body == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        default:
                            echo wp_kses(JSVEHICLEMANAGERincluder::getObjectClass('customfields')->formCustomFieldOfVehicleSection($field), JSVEHICLEMANAGER_ALLOWED_TAGS);
                        break;
                    }
                }
                // Section drivetrain
                if(isset(jsvehiclemanager::$_data[1]['drivetrain'])){
                    $vehicloptions = jsvehiclemanager::$_data[1]['drivetrain'];
                }else{
                    $vehicloptions = array();
                }
                foreach (jsvehiclemanager::$_data[4]['drivetrain'] as $field) {
                    switch ($field->field) {
                        case "section_drivetrain":
                            $count = newSection($count,$field->fieldtitle);
                            $section_drivetrain = 1;
                        break;
                        case "2wheeldrive":
                            if ($section_drivetrain == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "4wheeldrive":
                            if ($section_drivetrain == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "allwheeldrive":
                            if ($section_drivetrain == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "rearwheeldrive":
                            if ($section_drivetrain == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "supercharged":
                            if ($section_drivetrain == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "turbo":
                            if ($section_drivetrain == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        default:
                            echo  wp_kses(JSVEHICLEMANAGERincluder::getObjectClass('customfields')->formCustomFieldOfVehicleSection($field), JSVEHICLEMANAGER_ALLOWED_TAGS);
                        break;
                    }
                }
                // Section exterior
                if(isset(jsvehiclemanager::$_data[1]['exterior'])){
                    $vehicloptions = jsvehiclemanager::$_data[1]['exterior'];
                }else{
                    $vehicloptions = array();
                }
                foreach (jsvehiclemanager::$_data[4]['exterior'] as $field) {
                    switch ($field->field) {
                        case "section_exterior":
                            $count = newSection($count, 'EXTERIOR');
                            $section_exterior = 1;
                        break;
                        case "alloywheels":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "bedliner":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "bugshield":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "campermirrors":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "cargocover":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "customwheels":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "dualslidingdoor":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "foglamps":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "heatedwindshield":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "limitationconvertibletop":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "luggagerack":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "metallicpaint":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "nerfbars":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "newtyres":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "premiumwheels":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "rearwiper":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "rarewheels":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "removabletop":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "ridecontrol":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "runningboards":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "splashquards":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "spoiler":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "sunroof":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "ttops":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "toneaucover":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        case "towingpackage":
                            if ($section_exterior == 1) {
                                echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            }
                        break;
                        default:
                            echo  wp_kses(JSVEHICLEMANAGERincluder::getObjectClass('customfields')->formCustomFieldOfVehicleSection($field), JSVEHICLEMANAGER_ALLOWED_TAGS);
                        break;
                    }
                }
                    // Section interior
                    if(isset(jsvehiclemanager::$_data[1]['interior'])){
                        $vehicloptions = jsvehiclemanager::$_data[1]['interior'];
                    }else{
                        $vehicloptions = array();
                    }
                    foreach (jsvehiclemanager::$_data[4]['interior'] as $field) {
                        switch ($field->field) {
                            case "section_interior":
                                $count = newSection($count,'INTERIOR');
                                $section_interior = 1;
                            break;
                            case "adjustablefootpedals":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "airconditioning":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "autodimisrvmirror":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "bucketseats":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "centerconsole":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "childseats":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "cooledseats":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "cruisecontrol":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "dualclimatecontrol":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "heatedmirrors":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "heatedseats":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "leatherseats":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "narrowbucketseats":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "power3rdrowseat":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "powerdoorlocks":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "powermirrors":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "powerseats":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "powerwindows":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "rearairconditioning":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "reardefrost":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "rearslidingwindow":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "retrobucketseats":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "tiltsteering":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "tintedwindows":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "tv":
                                if ($section_interior == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            default:
                                echo wp_kses(JSVEHICLEMANAGERincluder::getObjectClass('customfields')->formCustomFieldOfVehicleSection($field), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            break;
                        }
                    }
                    // Section electronics
                    if(isset(jsvehiclemanager::$_data[1]['electronics'])){
                        $vehicloptions = jsvehiclemanager::$_data[1]['electronics'];
                    }else{
                        $vehicloptions = array();
                    }
                    foreach (jsvehiclemanager::$_data[4]['electronics'] as $field) {
                        switch ($field->field) {
                            case "section_electronics":
                                $count = newSection($count,'ELECTRONICS');
                                $section_electrnoics = 1;
                            break;
                            case "alarm":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "amfmradio":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                 }
                            break;
                            case "antitheft":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "backupcameraandmirror":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "cdchanger":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "dualdvd":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "dvdplayer":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "dvdplayer":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "handsfreecomsys":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "informationcenter":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "integratedphone":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "ipodmp3port":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "ipodport":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "keylessentry":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "memoryseats":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "navigationsystem":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "onstar":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "parkassistrear":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "powerliftgate":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "rearlookingdifferential":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "rearstereo":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "remotestart":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "satelliteradio":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "steeringwheelcontrol":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "stereotape":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "trailerbrakesystem":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "tripmileagecomputer":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "tyrepressuremonitoringsystem":
                                if ($section_electrnoics == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            default:
                                echo  wp_kses(JSVEHICLEMANAGERincluder::getObjectClass('customfields')->formCustomFieldOfVehicleSection($field), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            break;

                        }
                    }// Section safetyfeatures
                    if(isset(jsvehiclemanager::$_data[1]['safety'])){
                        $vehicloptions = jsvehiclemanager::$_data[1]['safety'];
                    }else{
                        $vehicloptions = array();
                    }
                    foreach (jsvehiclemanager::$_data[4]['safety'] as $field) {
                        switch ($field->field) {
                            case "section_safetyfeatures":
                                $count = newSection($count,'SAFETY_FEATURES');
                                $section_safetyfeature = 1;
                            break;
                            case "antilockbrakes":
                                if ($section_safetyfeature == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "backupsensors":
                                if ($section_safetyfeature == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "cartracker":
                                if ($section_safetyfeature == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "driverairbag":
                                if ($section_safetyfeature == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "passengerairbag":
                                if ($section_safetyfeature == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "rearairbags":
                                if ($section_safetyfeature == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "sideairbags":
                                if ($section_safetyfeature == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "signalmirrors":
                                if ($section_safetyfeature == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            case "tractioncontrol":
                                if ($section_safetyfeature == 1) {
                                    echo wp_kses(getCheckboxField($count,$field->field,$vehicloptions,$field->fieldtitle), JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                            break;
                            default:
                                echo  wp_kses(JSVEHICLEMANAGERincluder::getObjectClass('customfields')->formCustomFieldOfVehicleSection($field), JSVEHICLEMANAGER_ALLOWED_TAGS);
                            break;
                        }
                    }
                    ?>
                </div>

                <div class="jsvehiclemanager-form-upload-img-wrap">
                    <div class="jsvehiclemanager-form-upload-img-headings">
                        <?php echo __('Upload Vehicle Images','js-vehicle-manager'); ?>
                    </div>
                    <div class="jsvehiclemanager-vehicle-upload-img-wrp" data-images="images">
                        <div class="jsvehiclemanager-vehicle-upload-img-top">
                            <input id="jsvm_uploadFile" class="jsvm_inputval" placeholder="Choose File" disabled="disabled" />
                            <div class="jsvm_fileUpload">
                                <span class="jsvm_btn-upload"><?php echo __('Upload Images','js-vehicle-manager');?></span>
                                <input id="jsvm_uploadBtn" type="file" class="jsvm_upload" name="images[]" multiple />
                            </div>
                            <?php
                                $logoformat = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('image_file_type');
                                $maxsize = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('allowed_file_size');
                            ?>
                            <div class="jsvm_js-image-file-size"><?php echo __('Files Allowed','js-vehicle-manager')." : ";?><?php echo $logoformat;?></div>
                            <div class="jsvm_js-image-file-size"><?php echo __('File size','js-vehicle-manager')." : ";?><?php echo $maxsize.'kb';?></div>
                        </div>
                            <div class="jsvm_form-vehicle-main-img-wrapper jsvm_cm-img-wrap">
                                <img id="jsvm_ve_main_image" src="<?php echo jsvehiclemanager::$_data[7][0][0]; ?>" alt="" class="img-thumbnail jsvm_veh-imga jsvm_cm-main-img" data-defaultimage="<?php echo jsvehiclemanager::$_data[7][0][1]; ?>" data-filename="" />
                                <?php if(jsvehiclemanager::$_data[7][0][1] == 1){ ?>
                                    <img class="jsvm_srca_<?php echo 0; ?> jsvm_uploaded-img jsvm_cm-main-img" id="jsvm_cross_img" src="<?php echo CAR_MANAGER_IMAGE; ?>/reject-s.png"  />
                                    <div class="jsvm_backgroud-overlay-for-img" > </div>
                                    <input type="hidden" name="deleteimages[]" class="jsvm_hid_<?php echo 0; ?> jsvm_delimg" data-atr-vehicleid="<?php echo jsvehiclemanager::$_data[7][0][2] ?>" value="" />
                                <?php } ?>
                            </div>
                        <div class="jsvm_imgs-wrapper jsvm_form-vehicle-small-img-main-wrapper">
                            <?php
                            $maximum_images_per_vehicle = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('maximum_images_per_vehicle');
                            for($k = 0; $k < $maximum_images_per_vehicle;$k++) {?>
                            <div class="jsvm_cm-img-button-wrap">
                                <div class="jsvm_cm-img-wrap">
                                    <img id="jsvm_src_<?php echo $k; ?>" class="jsvm_ve-img" src="<?php echo jsvehiclemanager::$_data[7][$k][0]; ?>" class="img-thumbnail" data-replaced="<?php echo jsvehiclemanager::$_data[7][$k][1]; ?>" data-filename="" />
                                <?php if(jsvehiclemanager::$_data[7][$k][1] == 1){ ?>
                                    <img class="jsvm_srca_<?php echo esc_attr($k); ?> jsvm_uploaded-img" id="jsvm_cross_img" src="<?php echo CAR_MANAGER_IMAGE; ?>/reject-s.png"  />
                                    <div class="jsvm_backgroud-overlay-for-img" > </div>
                                    <input type="hidden" name="deleteimages[]" class="jsvm_hid_<?php echo esc_attr($k); ?> jsvm_delimg" data-atr-vehicleid="<?php echo esc_attr(jsvehiclemanager::$_data[7][$k][2]) ?>" value=""/>
                                <?php } ?>
                                </div>
                                <input type="button" class="jsvm_cm-mark-btn" value="<?php echo __('Make Default','js-vehicle-manager');?>" onclick="makeImageDefault(<?php echo $k; ?>);"/>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="default_image_name" id="jsvm_default_image_name" value=""/>
                <input type="hidden" name="default_image_url" id="jsvm_default_image_url" value=""/>
                <input type="hidden" name="removefile" id ="jsvm_removefile" value=""/>
                <script type="text/javascript">
                    function makeImageDefault(imgnum) {
                        var imageexist = jQuery('img#jsvm_src_'+imgnum).attr('data-replaced');
                        if(imageexist == 1){
                            var imgsrc2 = jQuery('img#jsvm_src_'+imgnum).attr('src');
                            jQuery('img#jsvm_ve_main_image').attr('src',imgsrc2);
                            var filename = jQuery('img#jsvm_src_'+imgnum).attr('data-filename');
                            if(filename != ''){// new images case
                                jQuery('img#jsvm_ve_main_image').attr('data-filename',filename);
                                jQuery('input#jsvm_default_image_name').val(filename);
                                jQuery('input#jsvm_default_image_url').val(0);
                            }else{
                                // to handle edit case
                                filename = jQuery('img#jsvm_src_'+imgnum).attr('src');
                                jQuery('input#jsvm_default_image_name').val(filename);
                                jQuery('input#jsvm_default_image_url').val(1);
                            }
                        }
                    }

                    var filearrayinal;
                    jQuery(document).ready(function(){
                        jQuery("#jsvm_brochure").change(function(){
                            var file = jQuery(this).get(0).files[0];

                            var fileext = file.name.split('.').pop();
                            var filesize = (file.size / 1024);
                            var filename = file.name;

                            var allowedsize = <?php echo JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('allowed_file_size'); ?>;
                            var allowedExt = '<?php echo JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('file_file_type'); ?>';
                            allowedExt = allowedExt.split(',');
                            for(var i = 0; i < allowedExt.length; i++){
                                allowedExt[i] = allowedExt[i].trim();
                            }
                            var resetfield = true;
                            if (jQuery.inArray(fileext, allowedExt) != - 1){
                                if (allowedsize > filesize){
                                    resetfield = false;
                                } else{
                                    alert("<?php echo __('File size is greater then allowed file size', 'js-vehicle-manager'); ?>");
                                }
                            } else{
                                alert("<?php echo __('File ext. is mismatched', 'js-vehicle-manager'); ?>");
                            }
                            if(resetfield == true){
                                jQuery(this).val("");
                            }
                        });
                        jQuery(document).delegate("#jsvm_uploadBtn",'change',function(){
                            var files = jQuery(this).get(0).files;
                            filearrayinal = files;
                            var replaced;
                            for (var i = 0;i < files.length ;i++) {
                                var fileext = files[i].name.split('.').pop();
                                var filesize = (files[i].size / 1024);
                                var filename = files[i].name;
                                var allowedsize = <?php echo JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('allowed_file_size'); ?>;
                                var allowedExt = '<?php echo JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('image_file_type'); ?>';
                                allowedExt = allowedExt.split(',');
                                if (jQuery.inArray(fileext, allowedExt) != - 1){
                                    if (allowedsize > filesize){
                                        var reader = new FileReader();
                                        reader.onload = (function(theFile){
                                            var fileName = theFile.name;
                                            return function(e){
                                                var srcimage = jQuery('div[data-images="images"]').find('img[data-replaced="0"]:first');
                                                jQuery(srcimage).attr('src', e.target.result);
                                                jQuery(srcimage).attr('data-replaced',1);
                                                jQuery(srcimage).attr('data-filename',fileName);
                                                jQuery(srcimage).parents('div.jsvm_cm-img-wrap').append('<img class="jsvm_srca_'+i+'" data-img-number="'+i+'" id="jsvm_cross_img" src="<?php echo CAR_MANAGER_IMAGE; ?>/reject-s.png" /><div class="jsvm_backgroud-overlay-for-img" > </div>');
                                                jQuery(srcimage).parents('div.jsvm_cm-img-wrap').find('div.jsvm_backgroud-overlay-for-img').hide();
                                                if(jQuery('img#jsvm_ve_main_image').attr('data-defaultimage') != 1){
                                                    jQuery('img#jsvm_ve_main_image').attr('src', e.target.result).attr('data-defaultimage',1);
                                                }
                                            };
                                        })(files[i]);
                                        reader.readAsDataURL(files[i]);
                                    } else{
                                        alert("<?php echo __('File size is greater then allowed file size', 'js-vehicle-manager'); ?>");
                                    }
                                } else{
                                    alert("<?php echo __('File ext. is mismatched', 'js-vehicle-manager'); ?>");
                                }
                            }
                            jQuery('input#jsvm_uploadBtn').hide();
                            jQuery('div.jsvm_fileUpload').append('<input id="jsvm_uploadBtn" type="file" class="jsvm_upload" name="images[]" multiple />');

                        });
                        // code to remove image
                        jQuery(document).delegate("img#jsvm_cross_img",'click',function(){
                            if(jQuery(this).hasClass('jsvm_uploaded-img')){
                                var vehimgid = jQuery(this).parents('div.jsvm_cm-img-wrap').children("input.jsvm_delimg").attr("data-atr-vehicleid");
                                jQuery(this).parents('div.jsvm_cm-img-wrap').children("input.jsvm_delimg").val(vehimgid);
                                jQuery(this).parents('div.jsvm_cm-img-wrap').children("div.jsvm_backgroud-overlay-for-img").show();
                                jQuery(this).parents('div.jsvm_cm-img-wrap').children("img#jsvm_cross_img").remove();

                            }else{// code to remove image from filelist before upload
                                var filename = jQuery(this).parents("div.jsvm_cm-img-wrap").find("img").attr("data-filename");
                                jQuery(this).parents("div.jsvm_cm-img-wrap").find("img").attr("data-replaced",0);
                                jQuery("input#jsvm_removefile").val(jQuery("input#jsvm_removefile").val() +','+ filename);
                                jQuery(this).parents('div.jsvm_cm-img-wrap').children("div.jsvm_backgroud-overlay-for-img").show();
                                jQuery(this).parents('div.jsvm_cm-img-wrap').children("img#jsvm_cross_img").remove();
                            }
                        });

                        jQuery("div.jsvm_cm-img-wrap").hover(
                            function() {
                                jQuery(this).children("img#jsvm_cross_img").show();
                                jQuery(this).children("div.jsvm_backgroud-overlay-for-img").show();
                            }, function() {
                                if(jQuery(this).children("img#jsvm_cross_img").length > 0){
                                    jQuery(this).children("img#jsvm_cross_img").hide();
                                    jQuery(this).children("div.jsvm_backgroud-overlay-for-img").hide();
                                }

                            }
                        );
                    });
                </script>
              <div class="jsvm_js-form-publish-wrapper">
                    <label  for="" class="jsvehiclemanager-title"><?php echo __('Published','js-vehicle-manager')." :"; ?></label>
                    <span class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::radiobutton('status', array('1' => __('Yes', 'js-vehicle-manager'), '0' => __('No', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data[0]->status) ? jsvehiclemanager::$_data[0]->status : 1, array('class' => 'jsvm_radiobutton')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </span>
                </div>
                <div class="jsvm_js-buttons-area">
                    <div class="jsvm_js-buttons-area-btn">
                        <a class="jsvm_js-btn-cancel" href="index.php?option=com_jsvehiclemanager&c=vehicle&view=vehicle&layout=vehicles"><?php //echo __('Cancel'); ?></a>
                        <?php if(isset(jsvehiclemanager::$_data[0]->id)){ ?>
                            <input class="jsvm_js-btn-save" type="submit" rel="button" id="jsvehiclemanager_vehiclformbutton" value="<?php echo __('Save Vehicle','js-vehicle-manager') ?>" />
                            <?php
                        }else{ ?>
                            <div id="jsvehiclemanager-adminadd-vehicle">
                                <input class="jsvm_js-btn-save" type="submit" rel="button" id="jsvehiclemanager_vehiclformbutton" value="<?php echo __('Save Vehicle','jsvehiclemanager') ?>" />
                            </div>
                            <div id="jsvehiclemanager-selleradd-vehicle" style="display:none;">
                                <input type="button" rel="button" id="jsvehiclemanager_vehiclformbutton" class="jsvm_js-btn-save jsvm_credit-userid" data-credit-userid="" value="<?php echo __('Save Vehicle','js-vehicle-manager') ?>" onClick="jsvehiclemanagerformpopupAdmin('add_vehicle','jsvm_adminForm');"/>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <input type="hidden" id="jsvm_uid" name="uid"  value="<?php echo isset(jsvehiclemanager::$_data[0]->uid) ? jsvehiclemanager::$_data[0]->uid : esc_attr($user->id); ?>" data-validation="required" />
                <input type="hidden" name="id" value="<?php echo isset(jsvehiclemanager::$_data[0]->id) ? jsvehiclemanager::$_data[0]->id : ''; ?>" />
                <input type="hidden" name="hash" value="<?php echo isset(jsvehiclemanager::$_data[0]->hash) ? jsvehiclemanager::$_data[0]->hash : ''; ?>" />
                <input type="hidden" id="jsvm_user-popup-title-text" name="user-popup-title-text" value="<?php echo __('Select','js-vehicle-manager') .' '. __('Seller', 'js-vehicle-manager'); ?>" />
                <input type="hidden" id="jsvm_isadmin" name="isadmin" value="1" />
                <input type="hidden" id="jsvm_payment" name="payment" value="" />
                <input type="hidden" id="creditid" name="creditid" value="" />
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('sellerflag', 1), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('_wpnonce', wp_create_nonce('save-vehicle')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <input type="hidden" name="check" value="" />
                <input type="hidden" name="vehicleid" value="<?php echo isset(jsvehiclemanager::$_data[0]->vehicleid) ? jsvehiclemanager::$_data[0]->vehicleid : ''; ?>" />
            </form>
        </div>
    </div>
</div>

<style type="text/css">
    div#jsvm_map_container{width:100%;height:350px;}
</style>
<?php $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://"; ?>
<script type="text/javascript" src="<?php echo $protocol; ?>maps.googleapis.com/maps/api/js?key=<?php echo jsvehiclemanager::$_config['google_map_api_key']; ?>"></script>
<input type="hidden" id="jsvm_default_longitude" name="default_longitude" value="<?php echo (isset(jsvehiclemanager::$_data[0]->longitude) && jsvehiclemanager::$_data[0]->longitude !='' ) ? jsvehiclemanager::$_data[0]->longitude : jsvehiclemanager::$_config['default_longitude']; ?>"/>
<input type="hidden" id="jsvm_default_latitude" name="default_latitude" value="<?php echo (isset(jsvehiclemanager::$_data[0]->latitude) && jsvehiclemanager::$_data[0]->latitude !='' ) ? jsvehiclemanager::$_data[0]->latitude : jsvehiclemanager::$_config['default_latitude']; ?>"/>
<?php if((isset(jsvehiclemanager::$_data[0]->longitude) && jsvehiclemanager::$_data[0]->longitude !='') && (isset(jsvehiclemanager::$_data[0]->longitude) && jsvehiclemanager::$_data[0]->longitude !='') ){?>
        <input type="hidden" id="jsvm_addmarker" name="addmarker" value="1"/>
<? }else{?>
        <input type="hidden" id="jsvm_addmarker" name="addmarker" value="0"/>
<?php } ?>
<script type="text/javascript">
    function getmodels(src, val){
        jQuery("img#makemodelloading-gif").show();
        var ajaxurl = "<?php echo esc_url(admin_url("admin-ajax.php")); ?>";
            jQuery.post(ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'model', task: 'getVehiclesModelsbyMake', makeid: val,wpnoncecheck:common.wp_vm_nonce}, function(data){
                if (data){
                   jQuery("#" + src).html(data); //retuen value
                }
                jQuery("img#makemodelloading-gif").hide();
            });
    }
        function setPriceCurrencyLabel() {
            try {
                var field = jQuery('#jsvm_currencyid');
                var value = field.options[field.selectedIndex].text;
                var divs = jQuery('.jsvm_pricecurrency');
                for (var i = 0; i < divs.length; i++) {
                    divs[i].innerHTML = value;
                }
            } catch (err) {
                //alert(err);
            }
        }
        function setSpeedoMeterLabel() {
            try {
                var field = jQuery('speedmetertypeid');
                var value = field.options[field.selectedIndex].text;
                var divs = jQuery('.jsvm_speedometer');
                for (var i = 0; i < divs.length; i++) {
                    divs[i].innerHTML = value;
                }
                jQuery('#jsvm_co2_emission').html('g/' + value.substring(0, value.length - 1).toLowerCase());
            } catch (err) {
                //alert(err);
            }
        }
        var marker;
            function loadMap() {
                var default_latitude = document.getElementById('jsvm_default_latitude').value;
                var default_longitude = document.getElementById('jsvm_default_longitude').value;
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

    var multicities = <?php echo isset(jsvehiclemanager::$_data[0]->regcity) ? jsvehiclemanager::$_data[0]->regcity : "''";?>;
    var multicities1 = <?php echo isset(jsvehiclemanager::$_data[0]->loccity) ? jsvehiclemanager::$_data[0]->loccity : "''";?>;
    var multicities2 = '';
    var cityname = '';
    var marker;
    function getTokenInput() {
        var vehicleArray = '<?php echo admin_url("admin.php?page=jsvm_city&action=jsvmtask&task=getaddressdatabycityname"); ?>';
        jQuery("#loccity").tokenInput(vehicleArray, {
            theme: "jsvehiclemanager",
            preventDuplicates: true,
            hintText: "<?php echo __('Type In A Search Term', 'js-vehicle-manager'); ?>",
            noResultsText: "<?php echo __('No Results', 'js-vehicle-manager'); ?>",
            searchingText: "<?php echo __('Searching', 'js-vehicle-manager'); ?>",
            prePopulate: multicities1,
            tokenLimit: 1,

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
                    cityname = item.name;
                    return;
                }
                <?php $newtyped_cities = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('newtyped_cities');
                if ($newtyped_cities == 1) { ?>
                    if (item.name.search(",") == - 1) {
                    var input = jQuery("tester").text();
                            alert ("<?php echo __('Location Format Is Not Correct Please Enter City In This Format City Name Country Name Or City Name State Name Country Name', 'js-vehicle-manager'); ?>");
                            jQuery("#loccity").tokenInput("remove", item);
                            return false;
                    } else{
                    var ajaxurl = "<?php echo esc_url(admin_url("admin-ajax.php")); ?>";
                            jQuery.post(ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'city', task: 'savetokeninputcity', citydata: jQuery("tester").text(),wpnoncecheck:common.wp_vm_nonce}, function(data){
                            if (data){
                            try {
                            var value = jQuery.parseJSON(data);
                                    jQuery('#loccity').tokenInput('remove', item);
                                    jQuery('#loccity').tokenInput('add', {id: value.id, name: value.name});
                            }
                            catch (err) {
                            jQuery("#loccity").tokenInput("remove", item);
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
        jQuery("#regcity").tokenInput(vehicleArray, {
            theme: "jsvehiclemanager",
            preventDuplicates: true,
            hintText: "<?php echo __('Type In A Search Term', 'js-vehicle-manager'); ?>",
            noResultsText: "<?php echo __('No Results', 'js-vehicle-manager'); ?>",
            searchingText: "<?php echo __('Searching', 'js-vehicle-manager'); ?>",
            prePopulate: multicities,
            tokenLimit: 1,
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
                    return;
                }
                <?php $newtyped_cities = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('newtyped_cities');
                if ($newtyped_cities == 1) { ?>
                    if (item.name.search(",") == - 1) {
                    var input = jQuery("tester").text();
                            alert ("<?php echo __('Location Format Is Not Correct Please Enter City In This Format City Name Country Name Or City Name State Name Country Name', 'js-vehicle-manager'); ?>");
                            jQuery("#regcity").tokenInput("remove", item);
                            return false;
                    } else{
                    var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
                            jQuery.post(ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'city', task: 'savetokeninputcity', citydata: jQuery("tester").text(),wpnoncecheck:common.wp_vm_nonce}, function(data){
                            if (data){
                            try {
                            var value = jQuery.parseJSON(data);
                                    jQuery('#regcity').tokenInput('remove', item);
                                    jQuery('#regcity').tokenInput('add', {id: value.id, name: value.name});
                            }
                            catch (err) {
                            jQuery("#regcity").tokenInput("remove", item);
                                    alert(data);
                            }
                            }
                            });
                        }
                <?php } ?>
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

    jQuery(document).ready(function(){
        var slectedtype = jQuery("select#speedmetertypeid");
        speedmeterchange(slectedtype);
        loadMap();
        setPriceCurrencyLabel();
        getTokenInput();
        setSpeedoMeterLabel();
    });

    jQuery("form#jsvm_adminForm").submit(function (e) {
        //jsvm_showloading();
    });
    function addMarkerFromAddress(){
        var location_str = jQuery("input#streetaddress").val();
        location_str = location_str +" "+cityname;
        addMarkerOnMap(location_str);
    }

    function speedmeterchange(obj){

        var selectedValue = jQuery(obj).val();
        var mileagesSymbols = jQuery(obj).attr('data-symbols');
        if(mileagesSymbols != null){
            var array = mileagesSymbols.split(',');
            for (i = 0; i < array.length; i++) {
                var arr = array[i].split(':');
                if(arr[0] == selectedValue){
                    // Update fields label
                    jQuery('div.jsvm_speedometer').find('input').addClass('jsvm_lenghtless');
                    jQuery('div.jsvm_speedometer').find('span.jsvm_speedometer').css('display','inline-block');
                    jQuery('div.jsvm_speedometer').find('span.jsvm_speedometer').html(arr[1]);
                    break;
                }
            }
        }
    }

</script>
