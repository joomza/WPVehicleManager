<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERcurrencyModel {

    function getCurrencybyId($id) {
        if (is_numeric($id) == false)
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT * FROM `#__js_vehiclemanager_currencies` WHERE id = " . $id;
        $db->setQuery($query);
        jsvehiclemanager::$_data[0] = $db->loadObject();
        return;
    }

    function getCurrencyForCombo() {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT id, symbol AS text FROM `#__js_vehiclemanager_currencies` WHERE status = 1 ORDER BY isdefault DESC,ordering ASC ";
        $db->setQuery($query);
        $allcurrency = $db->loadObjectList();
        return $allcurrency;
    }

    function getDefaultCurrency() {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT currency.id FROM `#__js_vehiclemanager_currencies` currency WHERE currency.default = 1 AND currency.status = 1 ";
        $db->setQuery($query);
        $defaultValue = $db->loadObject();
        if (!$defaultValue) {
            $query = "SELECT id FROM `#__js_vehiclemanager_currencies` WHERE status=1";
            $db->setQuery($query);
            $defaultValue = $db->loadObjectList();
        }
        return $defaultValue;
    }

    function getAllCurrencies() {
        // Filter
        $title = jsvehiclemanager::$_search['currency']['title'];
        $status = jsvehiclemanager::$_search['currency']['status'];
        $code = jsvehiclemanager::$_search['currency']['code'];

        $inquery = '';
        $clause = ' WHERE ';
        if ($title != null) {
            $inquery .= $clause . "title LIKE '%" . $title . "%'";
            $clause = ' AND ';
        }
        if (is_numeric($status))
            $inquery .= $clause . " status = " . $status;
        if ($code != null)
            $inquery .=$clause . " code LIKE '%" . $code . "%'";

        jsvehiclemanager::$_data['filter']['title'] = $title;
        jsvehiclemanager::$_data['filter']['status'] = $status;
        jsvehiclemanager::$_data['filter']['code'] = $code;
        //Pagination
        $db = new jsvehiclemanagerdb();
        $query = "SELECT count(id) FROM `#__js_vehiclemanager_currencies` ";
        $query .= $inquery;
        $db->setQuery($query);
        $total = $db->loadResult();
        jsvehiclemanager::$_data['total'] = $total;
        jsvehiclemanager::$_data[1] = JSVEHICLEMANAGERpagination::getPagination($total);
        //Data
        $query = "SELECT * FROM `#__js_vehiclemanager_currencies` $inquery ORDER BY ordering ASC ";
        $query .= " LIMIT " . JSVEHICLEMANAGERpagination::$_offset . ", " . JSVEHICLEMANAGERpagination::$_limit;
        $db->setQuery($query);
        jsvehiclemanager::$_data[0] = $db->loadObjectList();

        return;
    }

    function updateIsDefault($id) {
        if (!is_numeric($id))
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "UPDATE `#__js_vehiclemanager_currencies` AS cur SET cur.isdefault = 0 WHERE cur.id != " . $id;
        $db->setQuery($query);
        $db->query();
    }

    function validateFormData(&$data) {
        $canupdate = false;
        if ($data['id'] == '') {
            $result = $this->isCurrencyExist($data['title']);
            $db = new jsvehiclemanagerdb();
            if ($result == true) {
                return JSVEHICLEMANAGER_ALREADY_EXIST;
            } else {
                $query = "SELECT max(ordering)+1 AS maxordering FROM `#__js_vehiclemanager_currencies`";
                $db->setQuery($query);
                $data['ordering'] = $db->loadResult();
            }

            if ($data['status'] == 0) {
                $data['default'] = 0;
            } else {
                if ( isset($data['default']) && $data['default'] == 1) {
                    $canupdate = true;
                }
            }
        } else {
            if ($data['status'] == 0) {
                $data['default'] = 0;
            } else {
                if ( isset($data['default']) && $data['default'] == 1) {
                    $canupdate = true;
                }
            }
        }
        return $canupdate;
    }

    function storeCurrency($data) {
        if (empty($data))
            return false;

        $canupdate = $this->validateFormData($data);
        if ($canupdate === JSVEHICLEMANAGER_ALREADY_EXIST)
            return JSVEHICLEMANAGER_ALREADY_EXIST;

        $row = JSVEHICLEMANAGERincluder::getJSTable('currency');
        $data = JSVEHICLEMANAGERincluder::getJSmodel('common')->stripslashesFull($data);// remove slashes with quotes.
        $data = JSVEHICLEMANAGERincluder::getJSModel('common')->getSanitizedFormData($data);
        if (!$row->bind($data)) {
            return JSVEHICLEMANAGER_SAVE_ERROR;
        }
        if (!$row->store()) {
            return JSVEHICLEMANAGER_SAVE_ERROR;
        }
        if ($row->isdefault == 1) {
            $this->updateIsDefault($row->id);
        }
        return JSVEHICLEMANAGER_SAVED;
    }

    function isCurrencyExist($title) {
        if(!$title)
            return false;
        $db = new jsvehiclemanagerdb();
        $query = "SELECT COUNT(id) FROM `#__js_vehiclemanager_currencies` WHERE title = '" . $title . "'";
        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result > 0)
            return true;
        else
            return false;
    }

    function deleteCurrencies($ids) {
        if (empty($ids))
            return false;
        $row = JSVEHICLEMANAGERincluder::getJSTable('currency');
        $notdeleted = 0;
        foreach ($ids as $id) {
            if(is_numeric($id)){
                if ($this->currencyCanDelete($id) == true) {
                    if (!$row->delete($id)) {
                        $notdeleted += 1;
                    }
                } else {
                    $notdeleted += 1;
                }
            }else{
                $notdeleted += 1;
            }
        }
        if ($notdeleted == 0) {
            JSVEHICLEMANAGERmessages::$counter = false;
            return JSVEHICLEMANAGER_DELETED;
        } else {
            JSVEHICLEMANAGERmessages::$counter = $notdeleted;
            return JSVEHICLEMANAGER_DELETE_ERROR;
        }
    }

    function publishUnpublish($ids, $status) {
        if (empty($ids))
            return false;
        if (!is_numeric($status))
            return false;

        $row = JSVEHICLEMANAGERincluder::getJSTable('currency');
        $total = 0;
        if ($status == 1) {
            foreach ($ids as $id) {
                if(is_numeric($id)){
                    if (!$row->update(array('id' => $id, 'status' => $status))) {
                        $total += 1;
                    }
                }else{
                    $total += 1;
                }
            }
        } else {
            foreach ($ids as $id) {
                if(is_numeric($id)){
                    if ($this->currencyCanUnpulish($id)) {
                        if (!$row->update(array('id' => $id, 'status' => $status))) {
                            $total += 1;
                        }
                    } else {
                        $total += 1;
                    }
                }else{
                    $total += 1;
                }
            }
        }
        if ($total == 0) {
            JSVEHICLEMANAGERmessages::$counter = false;
            if ($status == 1)
                return JSVEHICLEMANAGER_PUBLISHED;
            else
                return JSVEHICLEMANAGER_UN_PUBLISHED;
        }else {
            JSVEHICLEMANAGERmessages::$counter = $total;
            if ($status == 1)
                return JSVEHICLEMANAGER_PUBLISH_ERROR;
            else
                return JSVEHICLEMANAGER_UN_PUBLISH_ERROR;
        }
    }

    function currencyCanUnpulish($currencyid) {
        if(!is_numeric($currencyid)) return false;
        $db = new jsvehiclemanagerdb();
        $query = " SELECT COUNT(id) FROM `#__js_vehiclemanager_currencies` AS cur WHERE cur.id = " . $currencyid . " AND cur.isdefault = 1 ";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total > 0)
            return false;
        else
            return true;
    }

    function currencyCanDelete($currencyid) {
        if (is_numeric($currencyid) == false)
            return false;
        $db = new jsvehiclemanagerdb();
        $query = " SELECT
                    ( SELECT COUNT(id) FROM `#__js_vehiclemanager_vehicles` WHERE currencyid = " . $currencyid . ")
                    + ( SELECT COUNT(id) FROM `#__js_vehiclemanager_currencies` AS cur WHERE cur.id = " . $currencyid . " AND cur.isdefault =1)
                    AS total ";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total > 0)
            return false;
        else
            return true;
    }

    function getDefaultCurrencyId() {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT id FROM `#__js_vehiclemanager_currencies` WHERE `default` = 1";
        $db->setQuery($query);
        $id = $db->loadResult();
        return $id;
    }

    function getCurrency($title) {
        $db = new jsvehiclemanagerdb();
        $query = "SELECT  id, symbol,title FROM `#__js_vehiclemanager_currencies`  WHERE id != 1 AND status = 1 ORDER BY title ASC ";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        $currency = array();
        if ($title)
            $currency[] = array('value' => '', 'text' => $title);
        foreach ($rows as $row) {
            $currency[] = array('value' => $row->id, 'text' => $row->symbol);
        }
        return $currency;
    }

    function getSymbolPosition($price, $symbol){

        // $price = number_format($price,jsvehiclemanager::$_config['price_numbers_after_decimel_point'], jsvehiclemanager::$_config['price_decimal_separator'],jsvehiclemanager::$_config['price_thousand_separator']);
        if(jsvehiclemanager::$_config['price_poition_of_currency'] == 1){
            $price = $symbol.' '.$price;
        }else{
            $price = $price.' '.$symbol;
        }

        return $price;
    }

    function getMessagekey(){
        $key = 'currency';if(is_admin()){$key = 'admin_'.$key;}return $key;
    }

}

?>
