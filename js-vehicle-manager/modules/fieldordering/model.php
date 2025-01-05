<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERFieldorderingModel {

    function __construct() {

    }

    function fieldsRequiredOrNot($ids, $value) {
        if (empty($ids))
            return false;
        if (!is_numeric($value))
            return false;
        $db = new jsvehiclemanagerdb();
        $total = 0;
        foreach ($ids as $id) {
            if(is_numeric($id) && is_numeric($value)){
                $query = "UPDATE `#__js_vehiclemanager_fieldsordering` SET required = " . $value . " WHERE id = " . $id . " AND (sys = 0 OR sys IS NULL )";
                $db->setQuery($query);
                if (false === $db->query()) {
                    $total += 1;
                }
            }else{
                $total += 1;
            }
        }
        if ($total == 0) {
            JSVEHICLEMANAGERmessages::$counter = false;
            if ($value == 1)
                return JSVEHICLEMANAGER_REQUIRED;
            else
                return JSVEHICLEMANAGER_NOT_REQUIRED;
        }else {
            JSVEHICLEMANAGERmessages::$counter = $total;
            if ($value == 1)
                return JSVEHICLEMANAGER_REQUIRED_ERROR;
            else
                return JSVEHICLEMANAGER_NOT_REQUIRED_ERROR;
        }
    }

    function getFieldsOrdering($fieldfor) {
        if (is_numeric($fieldfor) == false)
            return false;
        $title = jsvehiclemanager::$_search['fieldsordering']['title'];
        $ustatus = jsvehiclemanager::$_search['fieldsordering']['ustatus'];
        $vstatus = jsvehiclemanager::$_search['fieldsordering']['vstatus'];
        $required = jsvehiclemanager::$_search['fieldsordering']['required'];

        $inquery = '';
        if ($title != null)
            $inquery .= " AND field.fieldtitle LIKE '%$title%'";
        if (is_numeric($ustatus))
            $inquery .= " AND field.published = $ustatus";
        if (is_numeric($vstatus))
            $inquery .= " AND field.isvisitorpublished = $vstatus";
        if (is_numeric($required))
            $inquery .= " AND field.required = $required";

        jsvehiclemanager::$_data['filter']['title'] = $title;
        jsvehiclemanager::$_data['filter']['ustatus'] = $ustatus;
        jsvehiclemanager::$_data['filter']['vstatus'] = $vstatus;
        jsvehiclemanager::$_data['filter']['required'] = $required;
        $db = new jsvehiclemanagerdb();
        //Pagination
        $query = "SELECT COUNT(field.id) FROM `#__js_vehiclemanager_fieldsordering` AS field WHERE field.fieldfor = " . $fieldfor;
        $query .= $inquery;
        $db->setQuery($query);
        $total = $db->loadResult();
        jsvehiclemanager::$_data[1] = $total;
        jsvehiclemanager::$_data[1] = JSVEHICLEMANAGERpagination::getPagination($total);

        //Data
        $query = "SELECT field.*
                    FROM `#__js_vehiclemanager_fieldsordering` AS field
                    WHERE field.fieldfor = " . $fieldfor;
        $query .= $inquery;
        $query .= ' ORDER BY';
        $query .= ' field.section, field.ordering ASC';


        $query .=" LIMIT " . JSVEHICLEMANAGERpagination::$_offset . "," . JSVEHICLEMANAGERpagination::$_limit;
        $db->setQuery($query);
        jsvehiclemanager::$_data[0] = $db->loadObjectList();
          //echo '<pre>';print_r(jsvehiclemanager::$_data[0]);die();
        return;
    }

    function getFieldsOrderingByFor($fieldfor) {
        $db = new jsvehiclemanagerdb();
        if (!is_numeric($fieldfor))
            return false;
        $published = JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest() ? ' AND isvisitorpublished = 1 ' : ' AND published = 1 ' ;
        $query = "SELECT * FROM `#__js_vehiclemanager_fieldsordering`
                    WHERE published = 1 AND fieldfor =  " . $fieldfor .$published. " ORDER BY ordering";

        $db->setQuery($query);
        $fields = $db->loadObjectList();
        return $fields;
    }

    function getVehiclesFieldsOrderingBySection($section) {
        $db = new jsvehiclemanagerdb();
        if (!is_numeric($section))
            return false;
        $published = JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest() ? ' isvisitorpublished ' : ' published ' ;


        $query = "SELECT  ".$published." FROM `#__js_vehiclemanager_fieldsordering`
                    WHERE fieldfor =  1 AND ordering = 0 AND section = ".$section." ";

        $db->setQuery($query);
        $published_count = $db->loadResult();
        $fields = (object) array();

        if($published_count != 0 || $section == 10){
            $query = "SELECT  * FROM `#__js_vehiclemanager_fieldsordering`
                        WHERE ".$published." = 1 AND fieldfor =  1 AND section = ".$section." ORDER BY ordering";

            $db->setQuery($query);
            $fields = $db->loadObjectList();
        }

        return $fields;
    }


    function getFieldsOrderingforForm($fieldfor) {
        if (is_numeric($fieldfor) == false)
            return false;
        $published = (JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()) ? "isvisitorpublished" : "published";
        $db = new jsvehiclemanagerdb();
        $query = "SELECT * FROM `#__js_vehiclemanager_fieldsordering`
                 WHERE $published = 1 AND fieldfor = " . $fieldfor . " ORDER BY";
        if ($fieldfor == 3) // for resume it must be order by section and ordering
            $query.=" section , ";
        $query.=" ordering";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        return $rows;
    }

    function getFieldsOrderingforSearch($fieldfor) {
        if (is_numeric($fieldfor) == false)
            return false;
        if (JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()) {
            $published = ' AND isvisitorpublished = 1 AND search_visitor = 1';
        } else {
            $published = ' AND published = 1 AND search_user = 1';
        }
        $db = new jsvehiclemanagerdb();
        $query = "SELECT * FROM `#__js_vehiclemanager_fieldsordering`
                 WHERE cannotsearch = 0 AND  fieldfor = " . $fieldfor . $published . " ORDER BY search_ordering";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        jsvehiclemanager::$_data[3] = $rows;
        return;
    }

    function getFieldsOrderingforView($fieldfor,$section = 0) {
        if (is_numeric($fieldfor) == false)
            return false;
        $sectionstr = $section !=0 ? " AND section = ".$section  : '';
        $db = new jsvehiclemanagerdb();
        $query = "SELECT field,fieldtitle FROM `#__js_vehiclemanager_fieldsordering`
                WHERE  fieldfor =  " . $fieldfor . $sectionstr ." ORDER BY ordering";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        $return = array();
        foreach ($rows AS $row) {
            $return[$row->field] = $row->fieldtitle;
        }
        return $return;
    }

    function getFieldsForListing($fieldfor) {
        if (is_numeric($fieldfor) == false)
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT field,showonlisting FROM `#__js_vehiclemanager_fieldsordering`
                WHERE  fieldfor =  " . $fieldfor ." ORDER BY ordering";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        $return = array();
        foreach ($rows AS $row) {
                $return[$row->field] = $row->showonlisting;
        }
        return $return;
    }

    function fieldsPublishedOrNot($ids, $value) {
        if (empty($ids))
            return false;
        if (!is_numeric($value))
            return false;
        $db = new jsvehiclemanagerdb();
        $total = 0;
        foreach ($ids as $id) {
            if(is_numeric($id) && is_numeric($value)){
                $query = "UPDATE `#__js_vehiclemanager_fieldsordering` SET published = " . $value . " WHERE id = " . $id . " AND (cannotunpublish=0 OR cannotunpublish IS NULL) ";
                $db->setQuery($query);
                if (false === $db->query()) {
                    $total += 1;
                }
            }else{
                $total += 1;
            }
        }
        if ($total == 0) {
            JSVEHICLEMANAGERmessages::$counter = false;
            if ($value == 1)
                return JSVEHICLEMANAGER_PUBLISHED;
            else
                return JSVEHICLEMANAGER_UN_PUBLISHED;
        }else {
            JSVEHICLEMANAGERmessages::$counter = $total;
            if ($value == 1)
                return JSVEHICLEMANAGER_PUBLISH_ERROR;
            else
                return JSVEHICLEMANAGER_UN_PUBLISH_ERROR;
        }
    }

    function visitorFieldsPublishedOrNot($ids, $value) {
        if (empty($ids))
            return false;
        if (!is_numeric($value))
            return false;
        $db = new jsvehiclemanagerdb();
        $total = 0;
        foreach ($ids as $id) {
            if(is_numeric($id) && is_numeric($value)){
                $query = "UPDATE `#__js_vehiclemanager_fieldsordering` SET isvisitorpublished = " . $value . " WHERE id = " . $id . " AND (cannotunpublish = 0 OR cannotunpublish IS NULL) ";
                $db->setQuery($query);
                if (false === $db->query()) {
                    $total += 1;
                }
            }else{
                $total += 1;
            }
        }
        if ($total == 0) {
            JSVEHICLEMANAGERmessages::$counter = false;
            if ($value == 1)
                return JSVEHICLEMANAGER_PUBLISHED;
            else
                return JSVEHICLEMANAGER_UN_PUBLISHED;
        }else {
            JSVEHICLEMANAGERmessages::$counter = $total;
            if ($value == 1)
                return JSVEHICLEMANAGER_PUBLISH_ERROR;
            else
                return JSVEHICLEMANAGER_UN_PUBLISH_ERROR;
        }
    }

    function fieldOrderingUp($field_id) {
        if (is_numeric($field_id) == false)
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "UPDATE `#__js_vehiclemanager_fieldsordering` AS f1, `#__js_vehiclemanager_fieldsordering` AS f2
                SET f1.ordering = f1.ordering + 1
                WHERE f1.ordering = f2.ordering - 1
                AND f1.fieldfor = f2.fieldfor
                AND f1.section = f2.section
                AND f2.id = " . $field_id;
        $db->setQuery($query);
        if (false == $db->query()) {
            return JSVEHICLEMANAGER_ORDER_UP_ERROR;
        }

        $query = " UPDATE `#__js_vehiclemanager_fieldsordering`
                    SET ordering = ordering - 1
                    WHERE id = " . $field_id;
        $db->setQuery($query);
        if (false == $db->query()) {
            return JSVEHICLEMANAGER_ORDER_UP_ERROR;
        }
        return JSVEHICLEMANAGER_ORDER_UP;
    }

    function fieldOrderingDown($field_id) {
        if (is_numeric($field_id) == false)
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "UPDATE `#__js_vehiclemanager_fieldsordering` AS f1, `#__js_vehiclemanager_fieldsordering` AS f2
                    SET f1.ordering = f1.ordering - 1
                    WHERE f1.ordering = f2.ordering + 1
                    AND f1.fieldfor = f2.fieldfor
                    AND f1.section = f2.section
                    AND f2.id = " . $field_id;
        $db->setQuery($query);
        if (false == $db->query()) {
            return JSVEHICLEMANAGER_ORDER_DOWN_ERROR;
        }

        $query = " UPDATE `#__js_vehiclemanager_fieldsordering`
                    SET ordering = ordering + 1
                    WHERE id = " . $field_id;
        $db->setQuery($query);
        if (false == $db->query()) {
            return JSVEHICLEMANAGER_ORDER_DOWN_ERROR;
        }
        return JSVEHICLEMANAGER_ORDER_DOWN;
    }

    function storeUserField($data) {
        if (empty($data)) {
            return false;
        }
        $row = JSVEHICLEMANAGERincluder::getJSTable('fieldsordering');
        if ($data['isuserfield'] == 1) {
            // value to add as field ordering
            if ($data['id'] == '') { // only for new
                $db = new jsvehiclemanagerdb();
                $query = "SELECT max(ordering) FROM `#__js_vehiclemanager_fieldsordering` WHERE fieldfor = " . $data['fieldfor'];
                if($data['fieldfor'] == 1){
                    $query .= ' AND section = '.$data['section'];
                }
                $db->setQuery($query);
                $var = $db->loadResult();
                $data['ordering'] = $var + 1;

                $query = "SELECT max(search_ordering) FROM `#__js_vehiclemanager_fieldsordering` WHERE fieldfor = " . $data['fieldfor'];
                if($data['fieldfor'] == 1){
                    $query .= ' AND section = '.$data['section'];
                }
                $db->setQuery($query);
                $var = $db->loadResult();
                $data['search_ordering'] = $var + 1;

                $data['cannotsearch'] = 0;
                $query = "SELECT max(id) FROM `#__js_vehiclemanager_fieldsordering` ";
                $db->setQuery($query);
                $maxid = $db->loadResult();
                $maxid++;
                $data['field'] = 'ufield_'.$maxid;
            }

            if($data['fieldfor'] == 2){
                $data['section'] = 10;
            }

            if(!isset($data['section']) || $data['section']  == ''){
                $data['section'] = 10;
            }

            $params = array();
            //code for depandetn field
            if (isset($data['userfieldtype']) && $data['userfieldtype'] == 'depandant_field') {
                if ($data['id'] != '') {
                    //to handle edit case of depandat field
                    $data['arraynames'] = $data['arraynames2'];
                }
                $flagvar = $this->updateParentField($data['parentfield'], $data['field'], $data['fieldfor']);
                if ($flagvar == false) {
                    return JSVEHICLEMANAGER_SAVE_ERROR;
                }
                if (!empty($data['arraynames'])) {
                    $valarrays = explode(',', $data['arraynames']);
                    foreach ($valarrays as $key => $value) {
                        $keyvalue = $value;
                        $value = str_replace(' ','_',$value);
                        if ($data[$value] != null) {
                            $params[$keyvalue] = array_filter($data[$value]);
                        }
                    }
                }
            }
            if (!empty($data['values'])) {
                foreach ($data['values'] as $key => $value) {
                    if ($value != null) {
                        $params[] = trim($value);
                    }
                }
            }
            if(!empty($params)){
                $params = json_encode($params);
                $data['userfieldparams'] = $params;
            }
        }

        if($data['fieldfor'] == 3 && $data['section'] != 1){
            $data['cannotshowonlisting'] = 1;
        }
        if(isset($data['userfieldtype']) && $data['userfieldtype'] == 'file'){
            $data['cannotshowonlisting'] = 1;
            $data['showonlisting'] = 0;
        }
        if (!$row->bind($data)) {
            return JSVEHICLEMANAGER_SAVE_ERROR;
        }
        if (!$row->store()) {
            return JSVEHICLEMANAGER_SAVE_ERROR;
        }
        $stored_id = $row->id;
        return JSVEHICLEMANAGER_SAVED;
    }

    function updateParentField($parentfield, $field, $fieldfor) {
        if(!is_numeric($parentfield)) return false;
        if(!is_numeric($fieldfor)) return false;
        $db = new jsvehiclemanagerdb();
        $query = "UPDATE `#__js_vehiclemanager_fieldsordering` SET depandant_field = '' WHERE fieldfor = ".$fieldfor." AND depandant_field = '".$parentfield."'";
        $db->setQuery($query);
        $db->query();
        $row = JSVEHICLEMANAGERincluder::getJSTable('fieldsordering');
        $row->update(array('id' => $parentfield, 'depandant_field' => $field));
        return true;
    }

    function getFieldsForComboByFieldFor() {
        check_ajax_referer( 'wp_js_vm_nonce_check', 'wpnoncecheck' );
        $fieldfor = JSVEHICLEMANAGERrequest::getVar('fieldfor');
        $parentfield = JSVEHICLEMANAGERrequest::getVar('parentfield');
        if(!is_numeric($fieldfor)) return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT fieldtitle AS text ,id FROM `#__js_vehiclemanager_fieldsordering` WHERE fieldfor = " . $fieldfor . " AND (userfieldtype = 'radio' OR userfieldtype = 'combo') ";
        $db->setQuery($query);
        $data = $db->loadObjectList();
        if($parentfield){
            $query = "SELECT id FROM `#__js_vehiclemanager_fieldsordering` WHERE fieldfor = $fieldfor AND (userfieldtype = 'radio' OR userfieldtype = 'combo') AND depandant_field = '" . $parentfield . "' ";
            $db->setQuery($query);
            $parent = $db->loadResult();
        }else{
            $parent = '';
        }
        $jsFunction = 'getDataOfSelectedField();';
        $html = JSVEHICLEMANAGERformfield::select('parentfield', $data, $parent, __('Select parent field','js-vehicle-manager'), array('onchange' => $jsFunction, 'class' => 'jsvm_inputbox jsvm_one'));
        $data = json_encode($html);
        return $data;
    }

    function getSectionToFillValues() {
        check_ajax_referer( 'wp_js_vm_nonce_check', 'wpnoncecheck' );
        $db = new jsvehiclemanagerdb();
        $field = JSVEHICLEMANAGERrequest::getVar('pfield');
        if(!is_numeric($field))
            return '';
        $query = "SELECT userfieldparams FROM `#__js_vehiclemanager_fieldsordering` WHERE id=$field";
        $db->setQuery($query);
        $data = $db->loadResult();
        $data = json_decode($data);
        $html = '';
        $fieldsvar = '';
        $comma = '';
        for ($i = 0; $i < count($data); $i++) {
            $fieldsvar .= $comma . "$data[$i]";
            $textvar = $data[$i];
            $textvar .='[]';
            $html .= "<div class='jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin'>";
            $html .= "<div class='jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding'>" . $data[$i] . "</div>";
            $html .= "<div class='jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding combo-options-fields' id='" . $data[$i] . "'>
                            <span class='jsvm_input-field-wrapper'>
                                " . wp_kses(JSVEHICLEMANAGERformfield::text($textvar, '', array('class' => 'jsvm_inputbox jsvm_one jsvm_user-field')), JSVEHICLEMANAGER_ALLOWED_TAGS) . "
                                <img class='jsvm_input-field-remove-img' src='" . JSVEHICLEMANAGER_PLUGIN_URL . "includes/images/remove.png' />
                            </span>
                            <input type='button' id='jsvm_depandant-field-button' onClick='getNextField(\"" . $data[$i] . "\",this);'  value='Add More' />
                        </div>";
            $html .= "</div>";
            $comma = ',';
        }
        $html .= " <input type='hidden' name='arraynames' value='" . $fieldsvar . "' />";
        $html = json_encode($html);
        return $html;
    }

    function getOptionsForFieldEdit() {
        check_ajax_referer( 'wp_js_vm_nonce_check', 'wpnoncecheck' );
        $field = JSVEHICLEMANAGERrequest::getVar('field');
        $yesno = array(
            (object) array('id' => 1, 'text' => __('Yes', 'js-vehicle-manager')),
            (object) array('id' => 0, 'text' => __('No', 'js-vehicle-manager')));

        if(!is_numeric($field)) return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT * FROM `#__js_vehiclemanager_fieldsordering` WHERE id=" . $field;
        $db->setQuery($query);
        $data = $db->loadObject();

        $html = '<span class="jsvm_popup-top">
                    <span id="jsvm_popup_title" >
                    ' . __("Edit Field", "js-vehicle-manager") . '
                    </span>
                    <img id="jsvm_popup_cross" onClick="closePopup();" src="' . JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/popup-close.png">
                </span>';
        $html .= '<form id="jsvehiclemanager-form" class="jsvm_popup-field-from" method="post" action="' . admin_url("admin.php?page=jsvm_fieldordering&task=saveuserfield") . '">';
        $html .= '<div class="jsvm_popup-field-wrapper">
                    <div class="jsvm_popup-field-title">' . __('Field Title', 'js-vehicle-manager') . '<font class="jsvm_required-notifier">*</font></div>
                    <div class="jsvm_popup-field-obj">' . wp_kses(JSVEHICLEMANAGERformfield::text('fieldtitle', isset($data->fieldtitle) ? $data->fieldtitle : 'text', '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => 'required')), JSVEHICLEMANAGER_ALLOWED_TAGS) . '</div>
                </div>';
        if ($data->cannotunpublish == 0) {
            $html .= '<div class="jsvm_popup-field-wrapper">
                        <div class="jsvm_popup-field-title">' . __('User Published', 'js-vehicle-manager') . '</div>
                        <div class="jsvm_popup-field-obj">' . wp_kses(JSVEHICLEMANAGERformfield::select('published', $yesno, isset($data->published) ? $data->published : 0, __('Select published', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => 'required')), JSVEHICLEMANAGER_ALLOWED_TAGS) . '</div>
                    </div>';
            $html .= '<div class="jsvm_popup-field-wrapper">
                        <div class="jsvm_popup-field-title">' . __('Visitor published', 'js-vehicle-manager') . '</div>
                        <div class="jsvm_popup-field-obj">' . wp_kses(JSVEHICLEMANAGERformfield::select('isvisitorpublished', $yesno, isset($data->isvisitorpublished) ? $data->isvisitorpublished : 0, __('Select visitor published', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => 'required')), JSVEHICLEMANAGER_ALLOWED_TAGS) . '</div>
                    </div>';
            if($data->field != 'termsconditions') {
                $sec = substr($data->field, 0, 8); //get section_
                if($sec != 'section_'){
                    $html .= '<div class="jsvm_popup-field-wrapper">
                                    <div class="jsvm_popup-field-title">' . __('Required', 'js-vehicle-manager') . '</div>
                                    <div class="jsvm_popup-field-obj">' . wp_kses(JSVEHICLEMANAGERformfield::select('required', $yesno, isset($data->required) ? $data->required : 0, __('Select required', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => 'required')), JSVEHICLEMANAGER_ALLOWED_TAGS) . '</div>
                                </div>';
                }
            }else{
                $html .= '<div class="jsvm_popup-field-wrapper">
                             <div class="jsvm_popup-field-title">' . __('Terms And Conditions Page', 'js-vehicle-manager') . '</div>
                             <div class="jsvm_popup-field-obj">' . wp_kses(JSVEHICLEMANAGERformfield::select('userfieldparams', JSVEHICLEMANAGERincluder::getJSModel('postinstallation')->getPageList() , isset($data->userfieldparams) ? $data->userfieldparams : '', '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => 'required')), JSVEHICLEMANAGER_ALLOWED_TAGS) . '</div>
                         </div>';
            }

        }

        if ($data->cannotsearch == 0) {
            $html .= '<div class="jsvm_popup-field-wrapper">
                        <div class="jsvm_popup-field-title">' . __('User Search', 'js-vehicle-manager') . '</div>
                        <div class="jsvm_popup-field-obj">' . wp_kses(JSVEHICLEMANAGERformfield::select('search_user', $yesno, isset($data->search_user) ? $data->search_user : 0, __('Select user search', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => 'required')), JSVEHICLEMANAGER_ALLOWED_TAGS) . '</div>
                    </div>';
            $html .= '<div class="jsvm_popup-field-wrapper">
                        <div class="jsvm_popup-field-title">' . __('Visitor Search', 'js-vehicle-manager') . '</div>
                        <div class="jsvm_popup-field-obj">' . wp_kses(JSVEHICLEMANAGERformfield::select('search_visitor', $yesno, isset($data->search_visitor) ? $data->search_visitor : 0, __('Select visitor search', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => 'required')), JSVEHICLEMANAGER_ALLOWED_TAGS) . '</div>
                    </div>';
        }
        $showonlisting = true;
        if($data->fieldfor == 3 && $data->section != 1 ){
            $showonlisting = false;
        }
        if (($data->isuserfield == 1 || $data->cannotshowonlisting == 0) && $showonlisting == true) {
            $html .= '<div class="jsvm_popup-field-wrapper">
                        <div class="jsvm_popup-field-title">' . __('Show On Listing', 'js-vehicle-manager') . '</div>
                        <div class="jsvm_popup-field-obj">' . wp_kses(JSVEHICLEMANAGERformfield::select('showonlisting', $yesno, isset($data->showonlisting) ? $data->showonlisting : 0, __('Select show on listing', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => 'required')), JSVEHICLEMANAGER_ALLOWED_TAGS) . '</div>
                    </div>';
        }
        $html .= wp_kses(JSVEHICLEMANAGERformfield::hidden('form_request', 'jsvehiclemanager'), JSVEHICLEMANAGER_ALLOWED_TAGS);
        $html .= wp_kses(JSVEHICLEMANAGERformfield::hidden('id', $data->id), JSVEHICLEMANAGER_ALLOWED_TAGS);
        $html .= wp_kses(JSVEHICLEMANAGERformfield::hidden('isuserfield', $data->isuserfield), JSVEHICLEMANAGER_ALLOWED_TAGS);
        $html .= wp_kses(JSVEHICLEMANAGERformfield::hidden('fieldfor', $data->fieldfor), JSVEHICLEMANAGER_ALLOWED_TAGS);
        $html .= wp_kses(JSVEHICLEMANAGERformfield::hidden('_wpnonce', wp_create_nonce('save-field')), JSVEHICLEMANAGER_ALLOWED_TAGS);

        $html .='<div class="jsvm_js-submit-container js-col-lg-10 js-col-md-10 js-col-md-offset-1 js-col-md-offset-1">
                    ' . wp_kses(JSVEHICLEMANAGERformfield::submitbutton('save', __('Save', 'js-vehicle-manager'), array('class' => 'button')), JSVEHICLEMANAGER_ALLOWED_TAGS);
        if ($data->isuserfield == 1) {
            $html .= '<a id="jsvm_user-field-anchor" href="'.esc_url(admin_url('admin.php?page=jsvm_fieldordering&jsvmlt=formuserfield&jsvehiclemanagerid=' . $data->id . '&ff='.$data->fieldfor)).'"> ' . __('Advanced', 'js-vehicle-manager') . ' </a>';
        }
        $html .='</div>
            </form>';
        return json_encode($html);
    }

    function deleteUserField($id){
        if (!is_numeric($id))
           return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT field,fieldfor FROM `#__js_vehiclemanager_fieldsordering` WHERE id = " . $id;
        $db->setQuery($query);
        $result = $db->loadObject();
        $row = JSVEHICLEMANAGERincluder::getJSTable('fieldsordering');
        if ($this->userFieldCanDelete($result) == true) {
            if (!$row->delete($id)) {
                return JSVEHICLEMANAGER_DELETE_ERROR;
            }else{
                return JSVEHICLEMANAGER_DELETED;
            }
        }
        return JSVEHICLEMANAGER_IN_USE;
    }

    function enforceDeleteUserField($id){
        if (is_numeric($id) == false)
           return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT field,fieldfor FROM `#__js_vehiclemanager_fieldsordering` WHERE id = " . $id;
        $db->setQuery($query);
        $result = $db->loadObject();
        $row = JSVEHICLEMANAGERincluder::getJSTable('fieldsordering');
        if ($this->userFieldCanDelete($result) == true) {
            if (!$row->delete($id)) {
                return JSVEHICLEMANAGER_DELETE_ERROR;
            }else{
                return JSVEHICLEMANAGER_DELETED;
            }
        }
        return JSVEHICLEMANAGER_IN_USE;
    }

    function userFieldCanDelete($field) {
        $fieldname = $field->field;
        $fieldfor = $field->fieldfor;

        if($fieldfor == 1){//for deleting a vehicle field
            $table = "vehicles";
        }elseif($fieldfor == 2){//for deleting a user field
            $table = "users";
        }elseif($fieldfor == 3){//for deleting a users field
            $table = "users";
        }
        $db = new jsvehiclemanagerdb();
        $query = ' SELECT
                    ( SELECT COUNT(id) FROM `#__js_vehiclemanager_'.$table.'` WHERE
                        params LIKE \'%"' . $fieldname . '":%\'
                    )
                    AS total';
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total > 0)
            return false;
        else
            return true;
    }

    function getUserfieldsfor($fieldfor, $resumesection = null) {
        if (!is_numeric($fieldfor))
            return false;
        if (JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()) {
            $published = ' isvisitorpublished = 1 ';
        } else {
            $published = ' published = 1 ';
        }
        if ($resumesection != null) {
            $published .= " AND section = $resumesection ";
        }
        $db = new jsvehiclemanagerdb();
        $query = "SELECT field,userfieldparams,userfieldtype FROM `#__js_vehiclemanager_fieldsordering` WHERE fieldfor = " . $fieldfor . " AND isuserfield = 1 AND " . $published;
        $db->setQuery($query);
        $fields = $db->loadObjectList();
        return $fields;
    }

    function getUserfieldsforEmail() {
        $published = ' published = 1 ';
        $db = new jsvehiclemanagerdb();
        $query = "SELECT field,userfieldparams,userfieldtype,fieldfor,fieldtitle FROM `#__js_vehiclemanager_fieldsordering` WHERE isuserfield = 1 AND " . $published;
        $db->setQuery($query);
        $fields = $db->loadObjectList();
        return $fields;
    }


    function getUserFieldbyId($id, $fieldfor) {
        $db = new jsvehiclemanagerdb();
        if ($id) {
            if (is_numeric($id) == false)
                return false;
            $query = "SELECT * FROM `#__js_vehiclemanager_fieldsordering` WHERE id = " . $id;
            $db->setQuery($query);
            jsvehiclemanager::$_data[0]['userfield'] = $db->loadObject();
            $params = jsvehiclemanager::$_data[0]['userfield']->userfieldparams;
            jsvehiclemanager::$_data[0]['userfieldparams'] = !empty($params) ? json_decode($params, True) : '';
        }
        $query = "SELECT fieldtitle,section FROM `#__js_vehiclemanager_fieldsordering` WHERE field LIKE 'section_%' AND fieldfor = 1";
        $db->setQuery($query);
        jsvehiclemanager::$_data[0]['vehiclesections'] = $db->loadObjectList();
        jsvehiclemanager::$_data[0]['fieldfor'] = $fieldfor;
        return;
    }

    function DataForDepandantField(){
        check_ajax_referer( 'wp_js_vm_nonce_check', 'wpnoncecheck' );
        $val = JSVEHICLEMANAGERrequest::getVar('fvalue');
        $childfield = JSVEHICLEMANAGERrequest::getVar('child');
        $db = new jsvehiclemanagerdb();
        $query = "SELECT userfieldparams,fieldtitle, required FROM `#__js_vehiclemanager_fieldsordering` WHERE field = '".$childfield."'";
        $db->setQuery($query);
        $data = $db->loadObject();
        $decoded_data = json_decode($data->userfieldparams);
        $comboOptions = array();
        $flag = 0;
        foreach ($decoded_data as $key => $value) {
            if($key==$val){
               for ($i=0; $i <count($value) ; $i++) {
                   $comboOptions[] = (object)array('id' => $value[$i], 'text' => $value[$i]);
                   $flag = 1;
               }
            }
        }
        $textvar =  ($flag == 1) ?  __('Select', 'js-vehicle-manager').' '.$data->fieldtitle : '';
        $required = '';
        if($data->required == 1){
            $required = 'required';
        }
        $html = JSVEHICLEMANAGERformfield::select($childfield, $comboOptions, '',$textvar, array('data-validation' => $required,'class' => 'jsvm_inputbox jsvm_one jsvm_cm_select2 select2 form-control jsvm_select2'));
        $phtml = json_encode($html);
        return $phtml;
    }

    function getFieldTitleByFieldAndFieldfor($field,$fieldfor){
        if(!is_numeric($fieldfor)) return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT fieldtitle FROM `#__js_vehiclemanager_fieldsordering` WHERE field = '".$field."' AND fieldfor = ".$fieldfor;
        $db->setQuery($query);
        $title = $db->loadResult();
        return $title;
    }

    function getUserUnpublishFieldsfor($fieldfor) {
        if (! is_numeric($fieldfor))
            return false;
        $db = new jsvehiclemanagerdb();
        if (JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest()) {
            $published = ' isvisitorpublished = 0 ';
        } else {
            $published = ' published = 0 ';
        }
        $query = "SELECT field FROM `#__js_vehiclemanager_fieldsordering` WHERE fieldfor = " . $fieldfor . " AND isuserfield = 1 AND " . $published;
        $db->setQuery($query);
        $fields = $db->loadObjectList();
        return $fields;
    }

    function getFieldTitleByField($field){
        if(!$field)
            return '';
        $db = new jsvehiclemanagerdb();
        $query = "SELECT fieldtitle FROM `#__js_vehiclemanager_fieldsordering` WHERE isuserfield = 1 AND field= '".$field."' ";
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }

    function getFieldPublishStatusByfield($field,$fieldfor){
        if(!is_numeric($fieldfor)) return false;
        $db = new jsvehiclemanagerdb();
        $published = JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest() ? 'isvisitorpublished' : 'published';
        $query = "SELECT $published FROM `#__js_vehiclemanager_fieldsordering` WHERE fieldfor = $fieldfor AND field = '".$field."'";
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }

    function getFieldPublishStatusByfieldForListing($field,$fieldfor){
        if(!is_numeric($fieldfor)) return false;
        $db = new jsvehiclemanagerdb();
        $published = JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest() ? 'isvisitorpublished' : 'published';
        $query = "SELECT showonlisting FROM `#__js_vehiclemanager_fieldsordering` WHERE fieldfor = $fieldfor AND $published = 1 AND field = '".$field."'";
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }

    function getSearchFieldsOrdering($fieldfor) {
        if (is_numeric($fieldfor) == false)
            return false;
        $db = new jsvehiclemanagerdb();
        $search = JSVEHICLEMANAGERrequest::getVar('search','',1);
        $inquery = '';
            $inquery .= " AND field.cannotsearch = 0";
        if ($search == 0){
            $inquery .= " AND (field.search_user  = 1 OR field.search_visitor = 1 ) ";
        }
        jsvehiclemanager::$_data['filter']['search'] = $search;
        //Data
        $query = "SELECT field.fieldtitle,field.id,field.search_user,field.search_visitor,field.search_ordering
                    FROM `#__js_vehiclemanager_fieldsordering` AS field
                    WHERE field.fieldfor = " . $fieldfor;
        $query .= $inquery;
        $query .= ' ORDER BY field.search_ordering';

        $db->setQuery($query);

        jsvehiclemanager::$_data[0] = $db->loadObjectList();
        return;
    }

       function storeSearchFieldOrdering($data) {//
        if (empty($data)) {
            return false;
        }
        $row = JSVEHICLEMANAGERincluder::getJSTable('fieldsordering');
        if (!$row->bind($data)) {
            return JSVEHICLEMANAGER_SAVE_ERROR;
        }

        if (!$row->store()) {
            return JSVEHICLEMANAGER_SAVE_ERROR;
        }

        $stored_id = $row->id;
        return JSVEHICLEMANAGER_SAVED;
    }

    function storeSearchFieldOrderingByForm($data) {//
        if (empty($data)) {
            return false;
        }
        parse_str($data['fields_ordering_new'],$sorted_array);
        $sorted_array = reset($sorted_array);
        if(!empty($sorted_array)){
            $row = JSVEHICLEMANAGERincluder::getJSTable('fieldsordering');
            for ($i=0; $i < count($sorted_array) ; $i++) {
                $row->update(array('id' => $sorted_array[$i], 'search_ordering' => 1 + $i));
                //$row->update(array('id' => $sorted_array[$i], 'search_ordering' => 1 + $i));
            }
        }
        return JSVEHICLEMANAGER_SAVED;
    }

    /* Fieldordering Search data, admin setting and delete cookies */
    function getAdminFieldorderingSearchFormData(){
        $jsvm_search_array = array();
        $jsvm_search_array['title'] = JSVEHICLEMANAGERrequest::getVar('title');
        $jsvm_search_array['ustatus'] = JSVEHICLEMANAGERrequest::getVar('ustatus');
        $jsvm_search_array['vstatus'] = JSVEHICLEMANAGERrequest::getVar('vstatus');
        $jsvm_search_array['required'] = JSVEHICLEMANAGERrequest::getVar('required');
        $jsvm_search_array['search_from_fieldordering'] = 1;
        return $jsvm_search_array;
    }

    function setSearchVariableForAdminFieldordering($jsvm_search_array){
        jsvehiclemanager::$_search['fieldsordering']['title'] = isset($jsvm_search_array['title']) ? $jsvm_search_array['title'] : null;
        jsvehiclemanager::$_search['fieldsordering']['ustatus'] = isset($jsvm_search_array['ustatus']) ? $jsvm_search_array['ustatus'] : null;
        jsvehiclemanager::$_search['fieldsordering']['vstatus'] = isset($jsvm_search_array['vstatus']) ? $jsvm_search_array['vstatus'] : null;
        jsvehiclemanager::$_search['fieldsordering']['required'] = isset($jsvm_search_array['required']) ? $jsvm_search_array['required'] : null;
        jsvehiclemanager::$_search['fieldsordering']['search_from_fieldordering'] = isset($jsvm_search_array['search_from_fieldordering']) ? $jsvm_search_array['search_from_fieldordering'] : null;
    }

    function getCookiesSavedSearchDataFieldordering(){
        $jsvm_search_array = array();
        $vehicle_search_cookie_data = '';
        if(isset($_COOKIE['jsvm_vehicle_search_data'])){
            $vehicle_search_cookie_data = $_COOKIE['jsvm_vehicle_search_data'];
            $vehicle_search_cookie_data = json_decode( base64_decode($vehicle_search_cookie_data) , true );
        }
        if($vehicle_search_cookie_data != '' && isset($vehicle_search_cookie_data['search_from_fieldordering']) && $vehicle_search_cookie_data['search_from_fieldordering'] == 1){
            $jsvm_search_array['title'] = $vehicle_search_cookie_data['title'];
            $jsvm_search_array['ustatus'] = $vehicle_search_cookie_data['ustatus'];
            $jsvm_search_array['vstatus'] = $vehicle_search_cookie_data['vstatus'];
            $jsvm_search_array['required'] = $vehicle_search_cookie_data['required'];
            $jsvm_search_array['search_from_fieldordering'] = $vehicle_search_cookie_data['search_from_fieldordering'];
        }
        return $jsvm_search_array;
    }

    function getMessagekey(){
        $key = 'fieldordering';if(is_admin()){$key = 'admin_'.$key;}return $key;
    }
}

?>
