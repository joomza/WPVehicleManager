<?php
if (!defined('ABSPATH')) die('Restricted Access');?>
<div id="jsvehiclemanager-main-up-wrapper">
<?php

$msgkey = JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getMessagekey();
JSVEHICLEMANAGERmessages::getLayoutMessage($msgkey);
JSVEHICLEMANAGERbreadcrumbs::getBreadcrumbs();
include_once(JSVEHICLEMANAGER_PLUGIN_PATH . 'includes/header.php');
if (jsvehiclemanager::$_error_flag_message == null) {

?>
<div id="jsvehiclemanager-wrapper">
    <div class="control-pannel-header">
        <span class="heading">
            <?php echo __('Add New Vehicle', 'js-vehicle-manager'); ?>
        </span>
    </div>
    <div id="jsvehiclemanager-add-form-vehicle-wrapper">
    	<div id="jsvehiclemanager-add-vehicle-wrap">
    		<form action="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'action'=>'jsvmtask', 'task'=>'savevehicle','jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid()))); ?>" method="post" name="adminForm" id="adminForm" class="form-validate js-form-horizontal" enctype="multipart/form-data">
    			<div class="jsvehiclemanager-form-field-wrapper">
                    <?php
                    $default_value = JSVEHICLEMANAGERincluder::getJSModel('common')->getDefaultValuesForVehicleCombos();
                    $termsconditions_flag = 0;
                    $map = false;
                    $map1 = false;
                    $discounttypes = array(
                        (object) array('id' => 1, 'text' => esc_html__('Percentage', 'js-vehicle-manager')),
                        (object) array('id' => 0, 'text' => esc_html__('Amount', 'js-vehicle-manager'))
                    );

                    foreach (jsvehiclemanager::$_data[3] as $field) {

                        if( $field->required == 1 ){
                            $req = 'required';
                        }else{
                            $req='';
                        }

                        switch ($field->field) {
                            case "vehicletype": ?>
                                    <div class="jsvehiclemanager-js-form-wrapper">
                                        <label id="vechiletypeidmsg" for="vechiletypeid" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?><font color="red">*</font></label>
                                        <div class="jsvehiclemanager-value">
                                            <?php  echo wp_kses(JSVEHICLEMANAGERformfield::select('vehicletypeid', JSVEHICLEMANAGERincluder::getJSModel('vehicletype')->getVehicletypeForCombo(),isset(jsvehiclemanager::$_data[0]->vehicletypeid)? jsvehiclemanager::$_data[0]->vehicletypeid :'','', array('class' => 'inputbox jsvehiclemanager-select2','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                    <?php
                            break;
                            case "make": ?>
                                    <div class="jsvehiclemanager-js-form-wrapper">
                                        <label id="makeidmsg" for="makeid" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?><?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                         <div class="jsvehiclemanager-value">
                                            <?php  echo wp_kses(JSVEHICLEMANAGERformfield::select('makeid', JSVEHICLEMANAGERincluder::getJSModel('make')->getMakeForCombo(),isset(jsvehiclemanager::$_data[0]->makeid)? jsvehiclemanager::$_data[0]->makeid :'',__('Select make', 'js-vehicle-manager'), array('class' => 'inputbox','data-placeholder'=> __('Select make', 'js-vehicle-manager'),'onchange' => 'getmodels(\'modelid\', this.value);','data-validation'=>$req, "data-makeid" => "1")), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                    <?php
                            break;
                            case "model": ?>
                                    <div class="jsvehiclemanager-js-form-wrapper">
                                        <label id="modelidmsg" for="modelid" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?>

                                        <img id="makemodelloading-gif" style="display:none;" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL."includes/images/makemodelloading.gif"; ?>" alt="<?php echo esc_attr(__('loading','js-vehicle-manager')); ?>" title="<?php echo esc_attr(__('loading','js-vehicle-manager')); ?>" /> </label>

                                        <div class="jsvehiclemanager-value" id="vf_models">
                                            <?php  echo wp_kses(JSVEHICLEMANAGERformfield::select('modelid', JSVEHICLEMANAGERincluder::getJSModel('model')->getVehiclesModelsbyMakeId(isset(jsvehiclemanager::$_data[0]->makeid)? jsvehiclemanager::$_data[0]->makeid :''),isset(jsvehiclemanager::$_data[0]->modelid)? jsvehiclemanager::$_data[0]->modelid :'',__('Select model', 'js-vehicle-manager'), array('class' => 'inputbox','data-placeholder'=> __('Select model', 'js-vehicle-manager'),'data-validation'=>$req, "data-modelid" => "1")), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                    <?php
                            break;
                            case "condition": ?>
                                    <div class="jsvehiclemanager-js-form-wrapper">
                                        <label id="modelidmsg" for="conditionid" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                        <div class="jsvehiclemanager-value">
                                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('conditionid', JSVEHICLEMANAGERincluder::getJSModel('conditions')->getConditionForCombo(), isset(jsvehiclemanager::$_data[0]->conditionid)? jsvehiclemanager::$_data[0]->conditionid :'' , __('Select condition', 'js-vehicle-manager'), array('class' => 'inputbox','data-placeholder'=> __('Select condition', 'js-vehicle-manager'),'data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                 <?php
                            break;
                            case "modelyear": ?>
                                    <div class="jsvehiclemanager-js-form-wrapper">
                                        <label id="modelyearidmsg" for="modelyearid" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                        <div class="jsvehiclemanager-value">
                                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('modelyearid', JSVEHICLEMANAGERincluder::getJSModel('modelyears')->getModelyearsForCombo(), isset(jsvehiclemanager::$_data[0]->modelyearid)? jsvehiclemanager::$_data[0]->modelyearid :'' , '', array('class' => 'inputbox','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                    <?php
                            break;
                            case "fueltype": ?>
                                    <div class="jsvehiclemanager-js-form-wrapper">
                                        <label id="fueltypeidmsg" for="fueltypeid" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                        <div class="jsvehiclemanager-value">
                                            <?php  echo wp_kses(JSVEHICLEMANAGERformfield::select('fueltypeid', JSVEHICLEMANAGERincluder::getJSModel('fueltypes')->getFueltypeForCombo(),isset(jsvehiclemanager::$_data[0]->fueltypeid)? jsvehiclemanager::$_data[0]->fueltypeid:'','', array('class' => 'inputbox','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                    <?php
                            break;
                            case "adexpiry":
                                $check_flag = apply_filters("jsvm_credits_check_expiry_exists",0,'add_vehicle');
                                if($check_flag == 0){ ?>
                                    <div class="jsvehiclemanager-js-form-wrapper jsvehiclemanager-form-vehicle-expiry-date-wrapper">
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
                                            <?php  echo wp_kses(JSVEHICLEMANAGERformfield::select('adexpiryid', JSVEHICLEMANAGERincluder::getJSModel('adexpiry')->getVehiclesAdexpirie(),isset(jsvehiclemanager::$_data[0]->adexpiryid)? jsvehiclemanager::$_data[0]->adexpiryid:'',__('Select ad expiry', 'js-vehicle-manager'), array('class' => 'inputbox','data-placeholder'=> __('Select ad expiry', 'js-vehicle-manager'),'data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS);?>
                                        </div>
                                    </div>
                                    <?php
                                }elseif(isset(jsvehiclemanager::$_data[0]->adexpiryvalue)){ ?>
                                    <div class="jsvehiclemanager-js-form-wrapper jsvehiclemanager-form-vehicle-expiry-date-wrapper">
                                        <label id="adexpiryidmsg" for="adexpiryid" class="jsvehiclemanager-title">
                                            <?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?>
                                        </label>
                                        <div class="jsvehiclemanager-value">
                                            <?php
                                            if(isset(jsvehiclemanager::$_data[0]->adexpiryvalue)){ ?>
                                                <span class="jsvehiclemanager-form-vehicle-expiry-date">
                                                    <?php echo __('Expiry Date','js-vehicle-manager').': '.esc_html(date_i18n(jsvehiclemanager::$_config['date_format'],strtotime(jsvehiclemanager::$_data[0]->adexpiryvalue))); ?>
                                                </span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php }
                            break;
                            case "cylinder": ?>
                                    <div class="jsvehiclemanager-js-form-wrapper">
                                        <label id="cylinderidmsg" for="cylinderid" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                        <div class="jsvehiclemanager-value">
                                               <?php  echo wp_kses(JSVEHICLEMANAGERformfield::select('cylinderid', JSVEHICLEMANAGERincluder::getJSModel('cylinders')->getCylinderForCombo(),isset(jsvehiclemanager::$_data[0]->cylinderid)? jsvehiclemanager::$_data[0]->cylinderid:'','', array('class' => 'inputbox','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                    <?php
                            break;
                            case "price": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label id="cylinderidmsg" for="pricem" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('currencyid', JSVEHICLEMANAGERincluder::getJSModel('currency')->getCurrencyForCombo(),isset(jsvehiclemanager::$_data[0]->currencyid) ? jsvehiclemanager::$_data[0]->currencyid: $default_value['currencies'], '', array('class' => 'form-control jsvehiclemanager-price-currency')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>

                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('price', isset(jsvehiclemanager::$_data[0]->price) ? __(jsvehiclemanager::$_data[0]->price,'js-vehicle-manager') : '', array('class' => 'inputbox one jsvehiclemanager-price-figur','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>

                                    <?php
                            break;
                            case "transmission": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label id="cylinderidmsg" for="transmissionid" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <div class="jsvehiclemanager-value">
                                                <?php  echo wp_kses(JSVEHICLEMANAGERformfield::select('transmissionid', JSVEHICLEMANAGERincluder::getJSModel('transmissions')->getTransmissionsForCombo(),isset(jsvehiclemanager::$_data[0]->transmissionid)? jsvehiclemanager::$_data[0]->transmissionid:'','', array('class' => 'inputbox','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "mileages": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label id="cylinderidmsg" for="mileages" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <div class="jsvehiclemanager-value jsvehiclemanager-speedometer">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('mileages', isset(jsvehiclemanager::$_data[0]->mileages) ? __(jsvehiclemanager::$_data[0]->mileages,'js-vehicle-manager') : '', array('class' => 'inputbox one','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                                <span class="jsvehiclemanager-speedometer"></span>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "speedmetertype": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label id="cylinderidmsg" for="cylinderid" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <div class="jsvehiclemanager-value">
                                                <?php  echo wp_kses(JSVEHICLEMANAGERformfield::select('speedmetertypeid', JSVEHICLEMANAGERincluder::getJSModel('mileages')->getMileagesForCombo(),isset(jsvehiclemanager::$_data[0]->speedmetertypeid)? jsvehiclemanager::$_data[0]->speedmetertypeid:'','', array('class' => 'inputbox','onchange' => "speedmeterchange(this)",'data-symbols' => jsvehiclemanager::$_data['mileage_symbols'],'data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "stocknumber": ?>
                                    <div class="jsvehiclemanager-js-form-wrapper">
                                        <label id="stocknumbermsg" for="stocknumber" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                        <div class="jsvehiclemanager-value">
                                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('stocknumber', isset(jsvehiclemanager::$_data[0]->stocknumber) ? __(jsvehiclemanager::$_data[0]->stocknumber,'js-vehicle-manager') : '', array('class' => 'inputbox one','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                    <?php
                            break;
                            case "registrationnumber": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label id="registrationnumbermsg" for="registrationnumber" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('registrationnumber', isset(jsvehiclemanager::$_data[0]->registrationnumber) ? __(jsvehiclemanager::$_data[0]->registrationnumber,'js-vehicle-manager') : '', array('class' => 'inputbox one','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "registrationcity": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label id="regcitymsg" for="regcity" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <div class="jsvehiclemanager-value " id="vehicleform_regcity">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('regcity', isset(jsvehiclemanager::$_data[0]->regcity) ? __(jsvehiclemanager::$_data[0]->regcity,'js-vehicle-manager') : '', array('class' => 'inputbox one','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "locationcity": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label id="loccitymsg" for="loccity" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <div class="jsvehiclemanager-value " id="vehicleform_loccity">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('loccity', isset(jsvehiclemanager::$_data[0]->loccity) ? __(jsvehiclemanager::$_data[0]->loccity,'js-vehicle-manager') : '', array('class' => 'inputbox one','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "loczip": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label id="loczipmsg" for="loczip" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <div class="jsvehiclemanager-value" id="vehicleform_loczip">
                                               <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('loczip', isset(jsvehiclemanager::$_data[0]->loczip) ? __(jsvehiclemanager::$_data[0]->loczip,'js-vehicle-manager') : '', array('class' => 'inputbox one','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "streetaddress": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label id="streetaddressmsg" for="streetaddress" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php
                                                if ($field->required == 1) {
                                                    echo ' <font color="red">*</font>';
                                                }
                                                ?></label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('streetaddress', isset(jsvehiclemanager::$_data[0]->streetaddress) ? __(jsvehiclemanager::$_data[0]->streetaddress,'js-vehicle-manager') : '', array('class' => 'inputbox one','data-validation'=>$req,'onblur'=>'addMarkerFromAddress()')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "bargainprice": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label id="bargainprice" for="bargainprice" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('bargainprice', isset(jsvehiclemanager::$_data[0]->bargainprice) ? __(jsvehiclemanager::$_data[0]->bargainprice,'js-vehicle-manager') : '', array('class' => 'inputbox one','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?> <span class="pricecurrency"></span>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "exportprice": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label id="exportprice" for="exportprice" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('exportprice', isset(jsvehiclemanager::$_data[0]->exportprice) ? __(jsvehiclemanager::$_data[0]->exportprice,'js-vehicle-manager') : '', array('class' => 'inputbox one','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?> <span class="pricecurrency"></span>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "isdiscount": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label id="isdiscountmsg" for="isdiscount" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <div class="jsvehiclemanager-value">
                                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::radiobutton('isdiscount', array('1' => esc_html__('Yes', 'js-vehicle-manager'), '0' => esc_html__('No', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data[0]->isdiscount) ? jsvehiclemanager::$_data[0]->isdiscount : 0, array('class' => 'form-control','data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "discount": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label id="discountmsg" for="discount" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('discount', isset(jsvehiclemanager::$_data[0]->discount) ? __(jsvehiclemanager::$_data[0]->discount,'js-vehicle-manager') : '', array('class' => 'inputbox one','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "discounttype": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label id="discountmsg" for="discounttype" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <div class="jsvehiclemanager-value">
                                                <?php  echo wp_kses(JSVEHICLEMANAGERformfield::select('discounttype', $discounttypes, isset(jsvehiclemanager::$_data[0]->discounttype)? jsvehiclemanager::$_data[0]->discounttype:'',esc_html__('Select discount', 'js-vehicle-manager'), array('class' => 'form-control jsvm_select2','data-validation' => $req, 'data-placeholder'=> esc_html__('Select discount','js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "discountstart": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label id="discountstartmsg" for="discountstart" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <div class="jsvehiclemanager-value">
                                             <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('discountstart', isset(jsvehiclemanager::$_data[0]->discountstart) ? __(jsvehiclemanager::$_data[0]->discountstart,'js-vehicle-manager') : '', array('class' => 'inputbox one custom_date','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "discountend": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label id="discountendmsg" for="discountend" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <div class="jsvehiclemanager-value">
                                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('discountend', isset(jsvehiclemanager::$_data[0]->discountend) ? __(jsvehiclemanager::$_data[0]->discountend,'js-vehicle-manager') : '', array('class' => 'inputbox one custom_date','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "exteriorcolor": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label id="exteriorcolormsg" for="exteriorcolor" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('exteriorcolor', isset(jsvehiclemanager::$_data[0]->exteriorcolor) ? __(jsvehiclemanager::$_data[0]->exteriorcolor,'js-vehicle-manager') : '', array('class' => 'inputbox one','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "interiorcolor": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label class="jsvehiclemanager-title"  id="interiorcolormsg" for="interiorcolor"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('interiorcolor', isset(jsvehiclemanager::$_data[0]->interiorcolor) ? __(jsvehiclemanager::$_data[0]->interiorcolor,'js-vehicle-manager') : '', array('class' => 'inputbox one','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "enginecapacity": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label class="jsvehiclemanager-title"  id="enginecapacitymsg" for="enginecapacity"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('enginecapacity', isset(jsvehiclemanager::$_data[0]->enginecapacity) ? __(jsvehiclemanager::$_data[0]->enginecapacity,'js-vehicle-manager') : '', array('class' => 'inputbox one','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "cityfuelconsumption": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label class="jsvehiclemanager-title"  id="cityfuelconsumptionmsg" for="cityfuelconsumption"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <div class="jsvehiclemanager-value jsvehiclemanager-speedometer">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('cityfuelconsumption', isset(jsvehiclemanager::$_data[0]->cityfuelconsumption) ? __(jsvehiclemanager::$_data[0]->cityfuelconsumption,'js-vehicle-manager') : '', array('class' => 'inputbox one','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                                <span class="jsvehiclemanager-speedometer"></span>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "highwayfuelconsumption": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label class="jsvehiclemanager-title"  id="highwayfuelconsumptionmsg" for="highwayfuelconsumption"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <div class="jsvehiclemanager-value jsvehiclemanager-speedometer">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('highwayfuelconsumption', isset(jsvehiclemanager::$_data[0]->highwayfuelconsumption) ? __(jsvehiclemanager::$_data[0]->highwayfuelconsumption,'js-vehicle-manager') : '', array('class' => 'inputbox one','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                                <span class="jsvehiclemanager-speedometer"></span>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "acceleration": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label class="jsvehiclemanager-title"  id="accelerationmsg" for="acceleration"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?>  <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('acceleration', isset(jsvehiclemanager::$_data[0]->acceleration) ? __(jsvehiclemanager::$_data[0]->acceleration,'js-vehicle-manager') : '', array('class' => 'inputbox one','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "maxspeed": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label class="jsvehiclemanager-title"  id="maxspeedmsg" for="maxspeed"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('maxspeed', isset(jsvehiclemanager::$_data[0]->maxspeed) ? __(jsvehiclemanager::$_data[0]->maxspeed,'js-vehicle-manager') : '', array('class' => 'inputbox one','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "map": $map = true; ?>
                            <div class="jsvehiclemanager-js-form-wrapper jsvehiclemanager-full-width">
                                <label class="jsvehiclemanager-title"  id="mapmsg" for="map"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                <div class="jsvehiclemanager-value jsvehiclemanager-full-width">
                                    <div id="map_container" style="border: 1px solid #ccc;"></div>
                                </div>
                            </div>
                            <div class="jsvehiclemanager-js-form-wrapper jsvehiclemanager-full-width">
                                    <div class="jsvehiclemanager-js-form-wrapper">
                                        <label class="jsvehiclemanager-title"  id="longitude" for="longitude"><?php echo __('Longitude','js-vehicle-manager')." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                        <div class="jsvehiclemanager-value">
                                           <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('longitude', isset(jsvehiclemanager::$_data[0]->longitude) ? __(jsvehiclemanager::$_data[0]->longitude,'js-vehicle-manager') : '', array('class' => 'inputbox one','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>

                                        </div>
                                    </div>
                                    <div class="jsvehiclemanager-js-form-wrapper">
                                        <label class="jsvehiclemanager-title"  id="latitude" for="latitude"><?php echo esc_html(__('Latitude','js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                        <div class="jsvehiclemanager-value">
                                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('latitude', isset(jsvehiclemanager::$_data[0]->latitude) ? __(jsvehiclemanager::$_data[0]->latitude,'js-vehicle-manager') : '', array('class' => 'inputbox one','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                            </div>
                                    <?php
                            break;
                             case 'description': ?>

                                 <div class="jsvehiclemanager-js-form-wrapper jsvehiclemanager-full-width">
                                    <label class="jsvehiclemanager-title"  id="descriptionmsg" for="description"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                    <div class="jsvehiclemanager-value jsvehiclemanager-full-width">
                                       <?php echo wp_kses_post(wp_editor(isset(jsvehiclemanager::$_data[0]->description) ? jsvehiclemanager::$_data[0]->description: '', 'vechiledescription', array('media_buttons' => false,'data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    </div>
                                </div>
                            <?php
                            break;
                            case "video": ?>
                                <div class="jsvehiclemanager-js-form-wrapper">
                                    <label class="jsvehiclemanager-title" for="videotype"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                    <div class="jsvehiclemanager-value">
                                         <?php echo wp_kses(JSVEHICLEMANAGERformfield::radiobutton('videotype', array(1 => esc_html__('Youtube video Link', 'js-vehicle-manager'), 2 => esc_html__('Embedded html', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data[0]->videotype) ? jsvehiclemanager::$_data[0]->videotype : '', array('class' => 'jsvm_inputbox', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    </div>
                                </div>
                                <div class="jsvehiclemanager-js-form-wrapper">
                                    <label class="jsvehiclemanager-title"  id="videomsg" for="video"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                    <div class="jsvehiclemanager-value">
                                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('video', isset(jsvehiclemanager::$_data[0]->video) ? __(jsvehiclemanager::$_data[0]->video,'js-vehicle-manager') : '', array('class' => 'inputbox one','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    </div>
                                </div>
                           <?php
                            break;
                            case "engincenumber": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label class="jsvehiclemanager-title"  id="enginenumbermsg" for="enginenumber"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('enginenumber', isset(jsvehiclemanager::$_data[0]->enginenumber) ? __(jsvehiclemanager::$_data[0]->enginenumber,'js-vehicle-manager') : '', array('class' => 'inputbox one','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "chasisnumber": ?>
                                        <div class="jsvehiclemanager-js-form-wrapper">
                                            <label class="jsvehiclemanager-title"  id="chasisnumbermsg" for="chasisnumber"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                            <div class="jsvehiclemanager-value">
                                                <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('chasisnumber', isset(jsvehiclemanager::$_data[0]->chasisnumber) ? __(jsvehiclemanager::$_data[0]->chasisnumber,'js-vehicle-manager') : '', array('class' => 'inputbox one','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                            </div>
                                        </div>
                                    <?php
                            break;
                            case "co2": ?>
                                    <div class="jsvehiclemanager-js-form-wrapper">
                                        <label id="co2msg" for="co2" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                        <div class="jsvehiclemanager-value">
                                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('co2', isset(jsvehiclemanager::$_data[0]->co2) ? __(jsvehiclemanager::$_data[0]->co2,'js-vehicle-manager') : '', array('class' => 'inputbox one','data-validation'=>$req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                <?php
                            break;
                            case 'brochure': ?>
                                <div class="jsvehiclemanager-js-form-wrapper jsvehiclemanager-full-width">
                                    <label id="brochuremsg" for="brochure" class="jsvehiclemanager-title"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                    <div class="jsvehiclemanager-value">
                                        <input type="file" name="brochure" id="jsvm_brochure" value="" data-validation="<?php echo esc_attr($req); ?>" />
                                        <?php
                                            echo '<div class="jsvm_cm_file_info">'.esc_html__('Maximum file size allowed','js-vehicle-manager').' <b>('.JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('allowed_file_size').' '.esc_html__('KB','js-vehicle-manager').')</b></div>';
                                            echo '<div class="jsvm_cm_file_info">'.esc_html__('File type allowed','js-vehicle-manager').' <b>('.JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('file_file_type').')</b></div>';
                                            if(isset(jsvehiclemanager::$_data[0]->brochure) && jsvehiclemanager::$_data[0]->brochure != ''){
                                                echo '<input type="checkbox" name="removebrochurefile" id="jsvm_removebrochurefile" value="1" /> '.esc_html__('Delete','js-vehicle-manager').' ('.esc_html(basename(jsvehiclemanager::$_data[0]->brochure)).')';
                                            }
                                        ?>
                                    </div>
                                </div>
                            <?php
                            break;
                            case 'termsconditions':
                                if(!isset(jsvehiclemanager::$_data[0])){
                                    $termsconditions_flag = 1;
                                    $termsconditions_fieldtitle = $field->fieldtitle;
                                    $termsconditions_fieldtitle .= '<font color="red">*</font>';
                                    $termsconditions_link = get_the_permalink($field->userfieldparams);
                                }
                            break;
                            default:
                                $u_field = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->formCustomFields($field);
                                if($u_field){
                                    echo wp_kses($u_field, JSVEHICLEMANAGER_ALLOWED_TAGS);
                                }
                                break;
                        }
                    }
                    ?>
                </div>
                <div class="jsvehiclemanager-form-section-checkbox-wrap">
                        <div class="jsvehiclemanager-checkbox-headings-parent">
                            <?php echo __('Vehicle Options Check Any That Apply','js-vehicle-manager'); ?>
                        </div>
                        <?php
                            $colcount = 1;
                            $count = 0;
                            function getCheckboxField(&$count,$fieldname,$vehicleoptions,$lang){
                                $content = '<div class= "jsvehiclemanager-vehicle-details-checkbox checkboxes">';

                                $content .= '
                                            <div class="jsvehiclemanager-js-checkbox">
                                                <label for="'.$fieldname.'">
                                                    <input type="checkbox" name="'.$fieldname.'" id="'.$fieldname.'" value="1" ';
                                if (isset($vehicleoptions[$fieldname])){
                                    $content .= ($vehicleoptions[$fieldname] == 1) ? 'checked="checked"' : '';
                                }
                                $content .= ' />';
                                $content .= __($lang,'js-vehicle-manager');
                                $content .= '</label>
                                            </div>
                                        </div>  ';
                                        $count++;
                                return $content;
                            }

                            function newSection($count,$lang){
                                if ($count > 0) echo "</div>";
                                $count = 0;
                                $content = '<div class="jsvehiclemanager-checkbox-headings">
                                                '.esc_html(__($lang,'js-vehicle-manager')).'
                                            </div><div class="jsvehiclemanager-checkbox-sections">';
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
                    }
                }
                if($count != 0){
                	echo '</div>';
                }
            ?>
                </div>
                <div class="jsvehiclemanager-form-upload-img-wrap">
                    <div class="jsvehiclemanager-form-upload-img-headings">
                        <?php echo __('Upload Vehicle Images','js-vehicle-manager'); ?>
                    </div>
                    <div data-images="images" class="jsvehiclemanager-vehicle-upload-img-wrp">
                        <div class="jsvehiclemanager-vehicle-upload-img-top">
                            <div class="jsvehiclemanager-vehicle-upload-img">
                                <img src="<?php echo esc_url(jsvehiclemanager::$_data[7][0][0]); ?>" data-defaultimage="<?php echo esc_attr(jsvehiclemanager::$_data[7][0][1]); ?>" id="jsvehiclemanager_ve_main_image">
                            </div>
                            <div class="jsvehiclemanager-vehicle-upload-img-right">
                                <input type="file" id="jsvehiclemanager-uploadBtn" name="images[]" style="display:none;" class="jsvehiclemanager-upload" multiple>
                                <input type="button" value="<?php echo __('Choose Files','js-vehicle-manager'); ?>" class="jsvehiclemanager-full-width jsvehiclemanager-upload-choose-button" onclick="jQuery('.jsvehiclemanager-upload').last().click();">
                                <?php
                                    echo '<div class="jsvm_cm_file_info">'.esc_html__('Maximum file size allowed','js-vehicle-manager').' <b>('.JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('allowed_file_size').' '.esc_html__('KB','js-vehicle-manager').')</b></div>';
                                    echo '<div class="jsvm_cm_file_info">'.esc_html__('File type allowed','js-vehicle-manager').' <b>('.JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('image_file_type').')</b></div>';

                                ?>
                            </div>
                        </div>
                        <div class="jsvehiclemanager-vehicle-upload-img-bottom">

                    <?php
                    $maximum_images_per_vehicle = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('maximum_images_per_vehicle');
                    for($k = 0; $k < $maximum_images_per_vehicle;$k++): ?>

                        <div class="jsvehiclemanager-vehicle-upload-img">
                                <div class="jsvehiclemanager-vehicle-upload">
                            <?php if(jsvehiclemanager::$_data[7][$k][1] == 1): ?>

                             <img class="jsvehiclemanager-cross_img jsvehiclemanager-uploaded-img" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL."/includes/images/cancel-icon.png"; ?>" />
                             <div class="jsvehiclemanager-backgroud-overlay-for-img" > </div>

                            <?php endif; ?>

                                <img src="<?php echo esc_url(jsvehiclemanager::$_data[7][$k][0]); ?>" alt="<?php echo __('Vehicle Image','js-vehicle-manager'); ?>" title="<?php echo __('Vehicle Image','js-vehicle-manager'); ?>" id="jsvm_src_<?php echo esc_attr($k); ?>" class="jsvm_ve-img" data-filename="" data-replaced="<?php echo esc_attr(jsvehiclemanager::$_data[7][$k][1]); ?>">

                                <input type="hidden" name="deleteimages[]" class="delimg" data-atr-vehicleid="<?php echo esc_attr(jsvehiclemanager::$_data[7][$k][2]) ?>" value=""/>

                                </div>
                                <div class="jsvehiclemanager-vehicle-upload-make-defualt">
                                    <input type="button" class="jsvm_cm-mark-btn" value="<?php echo __('Make Default','js-vehicle-manager'); ?>" onclick="makeImageDefault(<?php echo $k; ?>);"/>
                                </div>
                            </div>

                    <?php endfor; ?>

                        </div>
                    </div>
                </div>

            <?php
            if(jsvehiclemanager::$_data['sellerflag'] == 0){ ?>
               <div class="jsvehiclemanager-form-sellerinfo-wrap">
                 <div class="jsvehiclemanager-form-sellerinfo-headings">
                        <?php echo __('Contact Info','jsvehiclemanager'); ?>
                 </div>
                 <div class="jsvehiclemanager-form-field-wrapper">
                <?php
                $rowcount = 0;
                foreach (jsvehiclemanager::$_data[5] as $field ) {
                    if( $field->required == 1 ){
                        $req = 'required';
                    }else{
                        $req='';
                    }
                    switch ($field->field) {
                        case 'name':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">
                                <label for="seller[name]" class="form-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('seller[name]', isset(jsvehiclemanager::$_data[6]->name) ? jsvehiclemanager::$_data[6]->name: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'email':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">
                                <div class="jsvehiclemanager-value">
                                    <label for="seller[email]" class="form-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('seller[email]', isset(jsvehiclemanager::$_data[6]->email) ? jsvehiclemanager::$_data[6]->email: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'cell':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">

                                    <label for="seller[cell]" class="form-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('seller[cell]', isset(jsvehiclemanager::$_data[6]->cell) ? jsvehiclemanager::$_data[6]->cell: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'weblink':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">

                                    <label for="seller[weblink]" class="form-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('seller[weblink]', isset(jsvehiclemanager::$_data[6]->weblink) ? jsvehiclemanager::$_data[6]->weblink: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'phone':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">

                                    <label for="seller[phone]" class="form-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('seller[phone]', isset(jsvehiclemanager::$_data[6]->phone) ? jsvehiclemanager::$_data[6]->phone: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'cityid':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">

                                    <label for="sellercityid" class="form-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('sellercityid', isset(jsvehiclemanager::$_data[6]->cityid) ? jsvehiclemanager::$_data[6]->cityid: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'photo': ?>
                            <div class="jsvehiclemanager-js-form-wrapper jsvehiclemanager-full-width">

                                    <label for="jsvm_profilephoto" class="form-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <input class="jsvm_inputbox" id="jsvm_profilephoto" name="profilephoto" type="file">
                                    <?php
                                        $logoformat = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('image_file_type');
                                        $maxsize = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('allowed_file_size');
                                    echo '('.$logoformat.')<br>';
                                    echo '('.esc_html__("Maximum file size","js-vehicle-manager").' '.$maxsize.' Kb)'; ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'facebook':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">

                                    <label for="seller[facebook]" class="form-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                     <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('seller[facebook]', isset(jsvehiclemanager::$_data[6]->facebook) ? jsvehiclemanager::$_data[6]->facebook: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'twitter':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">

                                    <label for="seller[twitter]" class="form-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                      <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('seller[twitter]', isset(jsvehiclemanager::$_data[6]->twitter) ? jsvehiclemanager::$_data[6]->twitter: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'linkedin':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">

                                    <label for="seller[linkedin]" class="form-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                     <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('seller[linkedin]', isset(jsvehiclemanager::$_data[6]->linkedin) ? jsvehiclemanager::$_data[6]->linkedin: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'googleplus':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">

                                    <label for="seller[googleplus]" class="form-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                     <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('seller[googleplus]', isset(jsvehiclemanager::$_data[6]->googleplus) ? jsvehiclemanager::$_data[6]->googleplus: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'pinterest':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">

                                    <label for="seller[pinterest]" class="form-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                     <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('seller[pinterest]', isset(jsvehiclemanager::$_data[6]->pinterest) ? jsvehiclemanager::$_data[6]->pinterest: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'instagram':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">

                                    <label for="seller[instagram]" class="form-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('seller[instagram]', isset(jsvehiclemanager::$_data[6]->instagram) ? jsvehiclemanager::$_data[6]->instagram: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS);?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'reddit':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">

                                    <label for="seller[reddit]" class="form-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('seller[reddit]', isset(jsvehiclemanager::$_data[6]->reddit) ? jsvehiclemanager::$_data[6]->reddit: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'videotypeid':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">

                                    <label for="seller[videotypeid]" class="form-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                     <div class="jsvehiclemanager-value">
                                    <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::radiobutton('seller[videotypeid]', array(1 => esc_html__('Youtube video Link', 'js-vehicle-manager'), 2 => esc_html__('Embedded html', 'js-vehicle-manager')), '', array('class' => 'jsvm_inputbox', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'video':  ?>
                            <div class="jsvehiclemanager-js-form-wrapper">

                                    <label for="seller[video]" class="form-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                    <div class="jsvehiclemanager-value">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('seller[video]', isset(jsvehiclemanager::$_data[6]->video) ? jsvehiclemanager::$_data[6]->video: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS);?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'description': ?>
                            <div class="jsvehiclemanager-js-form-wrapper jsvehiclemanager-full-width">

                                    <label for="" class="form-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'))." : "; ?>
                                        <?php
                                        $req = '';
                                        if ($field->required == 1) {
                                            $req = 'required';
                                            echo '<font color="red">&nbsp*</font>';
                                        }
                                        ?>
                                    </label>
                                     <div class="jsvehiclemanager-value jsvehiclemanager-full-width">
                                    <?php echo wp_kses_post(wp_editor(isset(jsvehiclemanager::$_data[6]->description) ? jsvehiclemanager::$_data[6]->description: '', 'sellerdescription', array('media_buttons' => false, 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                </div>
                            </div>
                        <?php
                        break;
                        case 'map': $map1 = true; ?>
                            <div class="jsvehiclemanager-js-form-wrapper jsvehiclemanager-full-width">
                                <div class="jsvehiclemanager-js-form-wrapper jsvehiclemanager-full-width">
                                    <div class="jsvehiclemanager-value jsvehiclemanager-full-width">
                                        <div id="jsvm_map_container1" style="border: 1px solid #ccc;" ></div>
                                    </div>
                                </div>
                                <div class="jsvehiclemanager-js-form-wrapper jsvehiclemanager-full-width">
                                     <div class="jsvehiclemanager-js-form-wrapper">
                                        <label class="control-label"  id="longitude" for="longitude1"><?php echo esc_html__('Longitude','js-vehicle-manager')." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                        <div class="jsvehiclemanager-value">
                                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('longitude1', isset(jsvehiclemanager::$_data[6]->longitude) ? jsvehiclemanager::$_data[6]->longitude: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                    <div class="jsvehiclemanager-js-form-wrapper">
                                        <label class="control-label"  id="latitude" for="latitude1"><?php echo esc_html__('Latitude','js-vehicle-manager')." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                                        <div class="jsvehiclemanager-value">
                                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('latitude1', isset(jsvehiclemanager::$_data[6]->latitude) ? jsvehiclemanager::$_data[6]->latitude: '', array('class' => 'form-control', 'data-validation' => $req)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        break;
                        default:
                            $u_field = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->formCustomFields($field);
                            if($u_field){

                                echo wp_kses($u_field, JSVEHICLEMANAGER_ALLOWED_TAGS);;
                            }
                        break;
                    }
                }
                echo '</div>'; // in each case div of wrapper col-md-12 has to close;
                    ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('seller[id]', isset(jsvehiclemanager::$_data[6]->id) ? jsvehiclemanager::$_data[6]->id :''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('seller[created]', isset(jsvehiclemanager::$_data[6]->created) ? jsvehiclemanager::$_data[6]->created : date_i18n('Y-m-d H:i:s')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('seller[uid]', isset(jsvehiclemanager::$_data[6]->uid) ? jsvehiclemanager::$_data[6]->uid :''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('seller[hash]', isset(jsvehiclemanager::$_data[6]->hash) ? jsvehiclemanager::$_data[6]->hash :''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                </div>

            <?php
            } ?>

            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('id', isset(jsvehiclemanager::$_data[0]->id) ? jsvehiclemanager::$_data[0]->id :''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('uid', JSVEHICLEMANAGERincluder::getObjectClass('user')->uid()), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('form_request', 'jsvehiclemanager'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('creditid', ''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('sellerflag', jsvehiclemanager::$_data['sellerflag']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <input type="hidden" name="task" value="savevehicle" />

            <?php if($termsconditions_flag == 1){ ?>
                            <div class="jsvehiclemanager-termsconditions-wrapper">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('termsconditions', array('1' => sprintf(__('%s', 'js-vehicle-manager'), $termsconditions_fieldtitle)), 0, array('class' => 'checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                    <a title="<?php echo esc_attr(__('Terms and Conditions','js-vehicle-manager')); ?>" href="<?php echo esc_url($termsconditions_link); ?>" target="_blank" >
                                    <img alt="<?php echo esc_attr(__('Terms and Conditions','js-vehicle-manager')); ?>" title="<?php echo esc_attr(__('Terms and Conditions','js-vehicle-manager')); ?>" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/creditslog-link.png'; ?>" />
                                    </a>
                            </div>
                        <?php
                        }
            ?>

            <?php
                $google_recaptcha = false;
                if( JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest() ){
                    $config_array =  JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigByFor('recaptcha');
                    if( $config_array['recaptcha_vehicleform'] == 1 ){
                        $google_recaptcha = true;
                    ?>
                        <div class="jsvehiclemanager-form-field-wrapper">
                            <div class="jsvehiclemanager-js-form-wrapper">
                                <div class="jsvehiclemanager-value">
                                    <div class="g-recaptcha" data-sitekey="<?php echo esc_attr($config_array['recaptcha_publickey']); ?>"></div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                }
            ?>
                <div class="jsvehiclemanager-js-buttons-area">
                    <div class="jsvehiclemanager-js-buttons-area-btn">
                        <a class="jsvehiclemanager-js-btn-cancel" href="index.php?option=com_jsvehiclemanager&c=vehicle&view=vehicle&layout=vehicles"><?php //echo __('Cancel'); ?></a>
                        <?php
                        if(isset(jsvehiclemanager::$_data[0]->vehicleid) || JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()){ ?>
                            <input class="jsvehiclemanager-js-btn-save" type="submit" rel="button" id="jsvehiclemanager_vehiclformbutton" value="<?php echo __('Save Vehicle','js-vehicle-manager') ?>"/>
                            <?php
                        }else{ ?>
                            <input class="jsvehiclemanager-js-btn-save" type="button" rel="button" id="jsvehiclemanager_vehiclformbutton" value="<?php echo __('Save Vehicle','js-vehicle-manager') ?>" onclick="jsvehiclemanagerformpopup('add_vehicle','adminForm',<?php echo jsvehiclemanager::getPageid(); ?>,true);"/>
                        <?php
                        } ?>
                    </div>
                </div>

            </div>
                <input type="hidden" name="task" value="vehicle.savevehicle" />
                <input type="hidden" name="check" name="check" value="" />
                <input type="hidden" id="map_flag" value="<?php echo $map==true ? 1 : 0; ?>" />
                <input type="hidden" id="map1_flag" value="<?php echo $map1==true ? 1 : 0; ?>" />
                <input type="hidden" name="default_image_name" id="jsvm_default_image_name" value=""/>
                <input type="hidden" name="default_image_url" id="jsvm_default_image_url" value=""/>
                <input type="hidden" name="removefile" id ="jsvm_removefile" value=""/>
                <input type="hidden" name="_wpnonce" id ="_wpnonce" value="<?php echo esc_html(wp_create_nonce('save-vehicle')); ?>"/>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('vehicleid', isset(jsvehiclemanager::$_data[0]->vehicleid) ? jsvehiclemanager::$_data[0]->vehicleid :''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            </form>
        </div>
    </div>
</div>
<?php
    if(isset($google_recaptcha) && $google_recaptcha){
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        ?>
        <?php $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
wp_enqueue_script('jsvm-repaptcha-scripti','https:www.google.com/recaptcha/api.js' );

    }
}
else{
    echo wp_kses(jsvehiclemanager::$_error_flag_message, JSVEHICLEMANAGER_ALLOWED_TAGS);
}
?>
</div>


