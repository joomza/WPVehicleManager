<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERcustomfields {

    function formCustomFields($field, $reg_form = 0 , $admin_profile_page = 0, $plugin_call = 0) {
        if($field->isuserfield != 1 || $field->userfieldtype == 'vehicleoption'){
            return false;
        }
        $cssclass = "";
        $html = '';
        //if($plugin_call == 0){
            $div1 = (is_admin()) ? 'jsvm_js-form-wrapper' : (($field->size == 100) ? 'col-sm-12 col-md-6 jsvehiclemanager-js-form-wrapper' : 'col-sm-12 col-md-6 jsvehiclemanager-js-form-wrapper');
            $div2 = (is_admin()) ? 'jsvehiclemanager-value' : 'form-group jsvehiclemanager-value';
            $lbl = (is_admin()) ? 'control-label' : 'control-label ';
        // }else{
        //     $div1 = (is_admin()) ? 'jsvm_js-form-wrapper' : (($field->size == 100) ? 'col-sm-12 col-md-6' : 'col-sm-12 col-md-6');
        //     $div2 = (is_admin()) ? 'jsvehiclemanager-value' : 'form-group';
        //     $lbl = (is_admin()) ? 'control-label' : 'control-label';
        // }

        if($reg_form == 1){
            $lbl = '';
        }

        $required = $field->required;
        if($reg_form == 0){
            $html = '<div class="' . $div1 . '">';
        }elseif($reg_form == 1){
            $html .= '<p>';
        }
        $html .= '<label for="'.$field->field.'" class="' . $lbl . '">';
        if ($required == 1) {
            if($field->userfieldtype != 'checkbox')
                $html .= $field->fieldtitle . '<font color="red">*</font>';
            if ($field->userfieldtype == 'email')
                $cssclass = "email";
            else
                $cssclass = "required";
        }else {
            $html .= $field->fieldtitle;
            if ($field->userfieldtype == 'email')
                $cssclass = "email";
            else
                $cssclass = "";
        }
        $html .= ' </label>';
        $adminFormClass = '';
        if(is_admin()){
            $html .= '<div class="' . $div2 . '">';
            $adminFormClass = "jsvm_inputbox jsvm_one";
        }else if(!is_admin()){
            $html .= '<div class="' . $div2 . '">';
        }
        //$readonly = $field->readonly ? "'readonly => 'readonly'" : "";
        $readonly = "";
        $maxlength = $field->maxlength ? "$field->maxlength" : "";
        $fvalue = "";
        $value = "";
        $userdataid = "";
        if (isset(jsvehiclemanager::$_data[0]->id)) {
            $userfielddataarray = json_decode(jsvehiclemanager::$_data[0]->params);
            $uffield = $field->field;
            if (isset($userfielddataarray->$uffield) || !empty($userfielddataarray->$uffield)) {
                $value = $userfielddataarray->$uffield;
            } else {
                $value = '';
            }
        }

        if($admin_profile_page == 1){
            $html = '';
        }

        switch ($field->userfieldtype) {
            case 'text':
            case 'email':
                $html .= JSVEHICLEMANAGERformfield::text($field->field, $value, array('class' => "form-control $adminFormClass", 'data-validation' => $cssclass, 'maxlength' => $maxlength, $readonly));
                break;
            case 'date':
                $html .= JSVEHICLEMANAGERformfield::text($field->field, $value, array('class' => 'form-control custom_date jsvm_one', 'data-validation' => $cssclass));
                break;
            case 'textarea':
                $html .= JSVEHICLEMANAGERformfield::textarea($field->field, $value, array('class' => 'form-control jsvm_one', 'data-validation' => $cssclass, 'rows' => $field->rows, 'cols' => $field->cols, $readonly));
                break;
            case 'checkbox':
                if (!empty($field->userfieldparams)) {
                    $comboOptions = array();
                    $obj_option = json_decode($field->userfieldparams);
                    $i = 0;
                    $valuearray = explode(', ',$value);
                    foreach ($obj_option AS $option) {
                        $check = '';
                        if(in_array($option, $valuearray)){
                            $check = 'checked';
                        }
                        $html .= '<input type="checkbox" ' . $check . ' class="radiobutton" value="' . $option . '" id="' . $field->field . '_' . $i . '" name="' . $field->field . '[]">';
                        $html .= '<label for="' . $field->field . '_' . $i . '" id="foruf_checkbox1">' . $option . '</label>';
                        $i++;
                    }
                } else {
                    $comboOptions = array('1' => $field->fieldtitle);
                    $html .= JSVEHICLEMANAGERformfield::checkbox($field->field, $comboOptions, $value, array('class' => 'radiobutton'));
                }
                break;
            case 'radio':
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    for ($i = 0; $i < count($obj_option); $i++) {
                        $comboOptions[$obj_option[$i]] = "$obj_option[$i]";
                    }
                }
                $jsFunction = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantField('" . $field->field . "','" . $field->depandant_field . "',2);";
                }
                $html .= JSVEHICLEMANAGERformfield::radiobutton($field->field, $comboOptions, $value, array('data-validation' => $cssclass, 'onclick' => $jsFunction));
                break;
            case 'combo':
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    foreach ($obj_option as $opt) {
                        $comboOptions[] = (object) array('id' => $opt, 'text' => $opt);
                    }
                }
                //code for handling dependent field
                $jsFunction = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantField('" . $field->field . "','" . $field->depandant_field . "',1);";
                }
                //end
                $html .= JSVEHICLEMANAGERformfield::select($field->field, $comboOptions, $value, __('Select', 'js-vehicle-manager') . ' ' . $field->fieldtitle, array('data-validation' => $cssclass, 'onchange' => $jsFunction, 'class' => 'form-control jsvm_one select2',"data-live-search"=>"true", 'data-placeholder'=>__('Select', 'js-vehicle-manager') . ' ' .$field->fieldtitle));
                break;
            case 'depandant_field':
                $comboOptions = array();
                if ($value != null) {
                    if (!empty($field->userfieldparams)) {
                        $obj_option = $this->getDataForDepandantFieldByParentField($field->field, $userfielddataarray);
                        foreach ($obj_option as $opt) {
                            $comboOptions[] = (object) array('id' => $opt, 'text' => $opt);
                        }
                    }
                }
                //code for handling dependent field
                $jsFunction = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantField('" . $field->field . "','" . $field->depandant_field . "');";
                }
                //end
                $html .= JSVEHICLEMANAGERformfield::select($field->field, $comboOptions, $value, __('Select', 'js-vehicle-manager') . ' ' . $field->fieldtitle, array('data-validation' => $cssclass, 'onchange' => $jsFunction, 'class' => 'form-control jsvm_one select2',"data-live-search"=>"true", 'data-placeholder'=>__('Select', 'js-vehicle-manager') . ' ' . $field->fieldtitle));
                break;
            case 'multiple':
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    foreach ($obj_option as $opt) {
                        $comboOptions[] = (object) array('id' => $opt, 'text' => $opt);
                    }
                }
                $array = $field->field;
                $array .= '[]';
                $valuearray = explode(', ', $value);
                $html .= JSVEHICLEMANAGERformfield::select($array, $comboOptions, $valuearray, __('Select', 'js-vehicle-manager') . ' ' . $field->fieldtitle, array('data-validation' => $cssclass, 'multiple' => 'multiple', 'class' => 'form-control jsvm_one select2',"data-live-search"=>"true" ,"multiple"=>"multiple", 'data-placeholder'=>__('Select', 'js-vehicle-manager') . ' ' . $field->fieldtitle));
                break;
            case 'file':
                $html .= '<input type="file" name="'.$field->field.'" id="'.$field->field.'" />';
                if($value != null){
                    $html .= JSVEHICLEMANAGERformfield::hidden($field->field.'_1', 0);
                    $html .= JSVEHICLEMANAGERformfield::hidden($field->field.'_2',$value);
                    $jsFunction = 'deleteCutomUploadedFile("'.$field->field.'_1")';
                    $html .='<span class="'.$field->field.'_1">';
                    if($field->fieldfor == 1){
                        $path = wp_nonce_url(admin_url("?page=vehicle&action=jsvmtask&task=downloadbyname&id=".jsvehiclemanager::$_data['objectid']."&name=".$value),'download-vehicle');
                    }else{
                        $path = wp_nonce_url(admin_url("?page=vehicle&action=jsvmtask&task=downloadbyname&id=".jsvehiclemanager::$_data['objectid']."&name=".$value."&seller=1"),'download-vehicle');
                    }
                    $html .= $value;
                    $html .='(&nbsp;';
                    $html .= '<a href="'.$path.'" >'. __('Download', 'js-vehicle-manager').'</a>';
                    $html .='&nbsp;)';

                    $html .='( ';
                    $html .= '<a href="#" onClick="'.$jsFunction.'" >'. __('Delete', 'js-vehicle-manager').'</a>';
                    $html .= ' )</span>';
                }
                break;
        }

        if($admin_profile_page == 1){
            return $html;
        }

        if($reg_form == 0){
            $html .= '</div>
            </div>';
        }elseif($reg_form == 1){
            $html .= '</p>';
        }
        return $html;
    }

    function formCustomFieldOfVehicleSection($field) {
        if($field->isuserfield == 1){
            $value = "";
            if (isset(jsvehiclemanager::$_data[0]->id)) {
                $userfielddataarray = json_decode(jsvehiclemanager::$_data[0]->params);
                $uffield = $field->field;
                if (isset($userfielddataarray->$uffield) || !empty($userfielddataarray->$uffield)) {
                    $value = $userfielddataarray->$uffield;
                } else {
                    $value = '';
                }
            }
            $cssClass =  !is_admin() ? 'col-sm-12 col-md-4 jsvm_cm-veh-fm-checkbox' : 'jsvm_vehicle-details-checkbox jsvm_checkboxes';

            $html = '<div class= "'.$cssClass.'">';
            $html .= '<div class="checkbox jsvm_cm-veh-fm-inputbox">
                            <label>
                                <input type="checkbox" name="'.$field->field.'" id="'.$field->field.'" value="1" ';
            if ($value != ''){
                $html .=  'checked="checked"';
            }
            $html .= ' />';
            $html .= __($field->fieldtitle);
            $html .= '</label>
                        </div>
                    </div>  ';

            return $html;
        }
    }

    function viewCustomFieldOfVehicleSection($field,$params,$comp_flag = '') {
        if($field->isuserfield == 1 && $field->userfieldtype == 'vehicleoption'){
            $value = "";
            $userfielddataarray = json_decode($params);
            $uffield = $field->field;
            if (isset($userfielddataarray->$uffield) || !empty($userfielddataarray->$uffield)) {
                $value = $userfielddataarray->$uffield;
            } else {
                $value = '';
            }
            $html = '';
            if($value != ''){
                $html = "<div class='feature-section-info' >
                            '. __($field->fieldtitle,'js-vehicle-manager').'
                        </div>";
            }
            if(!empty($comp_flag)){
                return $html;
            }else{
                return $value;
            }
        }
    }

    function viewCustomFieldOfVehicleSectionpdf($field,$params) {
        $value = 0;
        if($field->isuserfield == 1){
            $userfielddataarray = json_decode($params);
            $uffield = $field->field;
            if (isset($userfielddataarray->$uffield) || !empty($userfielddataarray->$uffield)) {
                $value = 1;
            }else{
                $value = 0;
            }
            return $value;
        }
        return $value;
    }

    function formCustomFieldsForSearch($field, &$i, $isadmin = 0,$search_popup=0) {
        if($field->isuserfield != 1 || $field->userfieldtype == 'vehicleoption'){
            return false;
        }
        $cssclass = "";
        $html = '';
        $i++;
        $required = $field->required;
        if($search_popup == 0){
            $div1 = 'col-sm-12 col-md-6 jsvm-search-form';
        }else{
            $div1 = 'col-sm-12 col-md-12 jsvm-search-div';
        }
        $div3 = 'form-group ';
        $lbl =  'control-label';
        $html = '<div class="' . $div1 . '"> ';
        $html .= ' <div class="' . $div3 . '">';
        if($isadmin == 0){
            $html .= '<label class="' . $lbl . '">';
            $html .= $field->fieldtitle;
            $html .= ' </label>';
        }
        if($isadmin == 1){
            $html = ''; // only field send
        }
        $readonly = ''; //$field->readonly ? "'readonly => 'readonly'" : "";
        $maxlength = ''; //$field->maxlength ? "'maxlength' => '".$field->maxlength : "";
        $fvalue = "";
        $value = null;
        $userdataid = "";
        $userfielddataarray = array();
        if (isset(jsvehiclemanager::$_data['filter']['params'])) {
            $userfielddataarray = jsvehiclemanager::$_data['filter']['params'];
            $uffield = $field->field;
            //had to user || oprator bcz of radio buttons

            if (isset($userfielddataarray[$uffield]) || !empty($userfielddataarray[$uffield])) {
                $value = $userfielddataarray[$uffield];
            } else {
                $value = '';
            }
        }
        switch ($field->userfieldtype) {
            case 'text':
            case 'file':
            case 'email':
                $html .= JSVEHICLEMANAGERformfield::text($field->field, $value, array('class' => 'form-control jsvm_one', 'data-validation' => $cssclass,'placeholder' =>$field->fieldtitle, $maxlength, $readonly));
                break;
            case 'date':
                $html .= JSVEHICLEMANAGERformfield::text($field->field, $value, array('class' => 'form-control custom_date jsvm_one', 'data-validation' => $cssclass));
                break;
            case 'editor':
                $html .= wp_editor(isset($value) ? $value : '', $field->field, array('media_buttons' => false, 'data-validation' => $cssclass));
                break;
            case 'textarea':
                $html .= JSVEHICLEMANAGERformfield::textarea($field->field, $value, array('class' => 'form-control jsvm_one', 'data-validation' => $cssclass, 'rows' => $field->rows, 'cols' => $field->cols, $readonly));
                break;
            case 'checkbox':
                if (!empty($field->userfieldparams)) {
                    $comboOptions = array();
                    $obj_option = json_decode($field->userfieldparams);
                    if(empty($value))
                        $value = array();
                    foreach ($obj_option AS $option) {
                        if( in_array($option, $value)){
                            $check = 'checked="true"';
                        }else{
                            $check = '';
                        }
                        $html .= '<input type="checkbox" ' . $check . ' class="radiobutton" value="' . $option . '" id="' . $field->field . '_' . $i . '" name="' . $field->field . '[]">';
                        $html .= '<label for="' . $field->field . '_' . $i . '" id="foruf_checkbox1">' . $option . '</label>';
                        $i++;
                    }
                } else {
                    $comboOptions = array('1' => $field->fieldtitle);
                    $html .= JSVEHICLEMANAGERformfield::checkbox($field->field, $comboOptions, $value, array('class' => 'radiobutton'));
                }
                break;
            case 'radio':
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    for ($i = 0; $i < count($obj_option); $i++) {
                        $comboOptions[$obj_option[$i]] = "$obj_option[$i]";
                    }
                }
                $jsFunction = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantField('" . $field->field . "','" . $field->depandant_field . "',2);";
                }
                $html .= JSVEHICLEMANAGERformfield::radiobutton($field->field, $comboOptions, $value, array('data-validation' => $cssclass, "autocomplete" => "off", 'onclick' => $jsFunction));
                break;
            case 'combo':
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    foreach ($obj_option as $opt) {
                        $comboOptions[] = (object) array('id' => $opt, 'text' => $opt);
                    }
                }
                //code for handling dependent field
                $jsFunction = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantField('" . $field->field . "','" . $field->depandant_field . "',1);";
                }
                //end
                $html .= JSVEHICLEMANAGERformfield::select($field->field, $comboOptions, $value, __('Select', 'js-vehicle-manager') . ' ' . $field->fieldtitle, array('data-validation' => $cssclass, 'onchange' => $jsFunction, 'class' => 'form-control jsvm_one select2',"data-live-search"=>"true", 'data-placeholder'=>__('Select', 'js-vehicle-manager') . ' ' . $field->fieldtitle));
                break;
            case 'depandant_field':
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = $this->getDataForDepandantFieldByParentField($field->field, $userfielddataarray);
                    if (!empty($obj_option)) {
                        foreach ($obj_option as $opt) {
                            $comboOptions[] = (object) array('id' => $opt, 'text' => $opt);
                        }
                    }
                }
                //code for handling dependent field
                $jsFunction = '';
                if ($field->depandant_field != null) {
                    $jsFunction = "getDataForDepandantField('" . $field->field . "','" . $field->depandant_field . "');";
                }
                //end
                $html .= JSVEHICLEMANAGERformfield::select($field->field, $comboOptions, $value, __('Select', 'js-vehicle-manager') . ' ' . $field->fieldtitle, array('data-validation' => $cssclass, 'onchange' => $jsFunction, 'class' => 'form-control jsvm_one select2',"data-live-search"=>"true" , 'data-placeholder'=>__('Select', 'js-vehicle-manager') . ' ' . $field->fieldtitle)); //,"multiple"=>"multiple"
                break;
            case 'multiple':
                $comboOptions = array();
                if (!empty($field->userfieldparams)) {
                    $obj_option = json_decode($field->userfieldparams);
                    foreach ($obj_option as $opt) {
                        $comboOptions[] = (object) array('id' => $opt, 'text' => $opt);
                    }
                }
                $array = $field->field;
                $array .= '[]';
                $html .= JSVEHICLEMANAGERformfield::select($array, $comboOptions, $value, __('Select', 'js-vehicle-manager') . ' ' . $field->fieldtitle, array('data-validation' => $cssclass, 'multiple' => 'multiple', 'class' => 'jsvm_cm_select2' ,'data-placeholder'=>__('Select', 'js-vehicle-manager') . ' ' . $field->fieldtitle));
                break;
        }
        if($isadmin == 1){
            return $html;

        }
        $html .= '</div></div>';
        return $html;

    }

    function showCustomFields($field, $fieldfor, $params,$seller = 0) {
        if($field->isuserfield != 1 || $field->userfieldtype == 'vehicleoption'){
            return false;
        }
        $html = '';
        $fvalue = '';

        if(!empty($params)){

            $data = json_decode($params,true);
            if(is_array($data)){
                if(array_key_exists($field->field, $data)){
                    $fvalue = $data[$field->field];
                }
            }
        }
        if($fieldfor == 1){ // For Detail
            $return_array[0] = $field->fieldtitle;
            $html = '';
            if($field->userfieldtype=='file'){
               if($fvalue !=null){
                    if($seller == 0){
                        $path = wp_nonce_url(admin_url("?page=vehicle&action=jsvmtask&task=downloadbyname&id=".jsvehiclemanager::$_data['objectid']."&name=".$fvalue),'download-vehicle');
                    }else{
                        $path = wp_nonce_url(admin_url("?page=vehicle&action=jsvmtask&task=downloadbyname&id=".jsvehiclemanager::$_data['objectid']."&name=".$fvalue."&seller=1"),'download-vehicle');
                    }

                    $html .= '
                        <div class="js_vehiclefile">
                            ' . $field->fieldtitle . ' ( ' . $fvalue . ' ) ' . '
                            <a class="button" target="_blank" href="' . $path . '">' . __('Download', 'js-vehicle-manager') . '</a>
                        </div>';
                }
                $return_array[1] = $html;

            }else{
                $return_array[1] = $fvalue;
            }
            return $return_array;
        }elseif($fieldfor == 2){ // For Vehicle Listings
            $return_array[0] = $field->fieldtitle;
            $return_array[1] = $fvalue;
            return $return_array;
        }


    }
    
    function userFieldsData($fieldfor,$section = 0,$listing = null) {
        if(!is_numeric($fieldfor))
            return '';

        if (JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()) {
            $published = ' isvisitorpublished = 1' ;
        } else {
            $published = ' published = 1 ';
        }
        if ($section != 0) {
            $published .= ' AND section = '.$section ;
        } else {
            $published .= '';
        }

        $db = new jsvehiclemanagerdb();
        $inquery = '';
        if ($listing == 1) {
            $inquery = ' AND showonlisting = 1 ';
        }
        $db = new jsvehiclemanagerdb();
        $query = "SELECT field,fieldtitle,isuserfield,userfieldtype,userfieldparams  FROM `#__js_vehiclemanager_fieldsordering` WHERE isuserfield = 1 AND " . $published . " AND fieldfor =" . $fieldfor . $inquery." ORDER BY ordering";
        $db->setQuery($query);
        $data = $db->loadObjectList();
        return $data;
    }

    function userFieldsForSearch($fieldfor) {
        if(!is_numeric($fieldfor))
            return '';
        $db = new jsvehiclemanagerdb();
        if (JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()) {
            $inquery = ' isvisitorpublished = 1 AND search_visitor =1';
        } else {
            $inquery = ' published = 1 AND search_user =1';
        }
        if($fieldfor == 1){
            $inquery .= ' AND section = 10 ';

        }

        $db = new jsvehiclemanagerdb();
        $query = "SELECT rows,cols,required,field,fieldtitle,isuserfield,userfieldtype,userfieldparams
                ,depandant_field  FROM #__js_vehiclemanager_fieldsordering WHERE isuserfield = 1 AND " . $inquery . " AND fieldfor =" . $fieldfor  ."  ORDER BY ordering ";
        $db->setQuery($query);
        $data = $db->loadObjectList();
        return $data;
    }

    function getDataForDepandantFieldByParentField($fieldfor, $data) {
        $db = new jsvehiclemanagerdb();
        if (JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()) {
            $published = ' isvisitorpublished = 1 ';
        } else {
            $published = ' published = 1 ';
        }
        $value = '';
        $returnarray = array();
        $query = "SELECT field from #__js_vehiclemanager_fieldsordering WHERE isuserfield = 1 AND " . $published . " AND depandant_field ='" . $fieldfor . "'";
        $db->setQuery($query);
        $field = $db->loadResult();
        if ($data != null) {
            foreach ($data as $key => $val) {
                if ($key == $field) {
                    $value = $val;
                }
            }
        }
        $query = "SELECT userfieldparams from #__js_vehiclemanager_fieldsordering WHERE isuserfield = 1 AND " . $published . " AND field ='" . $fieldfor . "'";
        $db->setQuery($query);
        $field = $db->loadResult();
        $fieldarray = json_decode($field);
        foreach ($fieldarray as $key => $val) {
            if ($value == $key)
                $returnarray = $val;
        }
        return $returnarray;
    }

}

?>
