<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERCityTable extends JSVEHICLEMANAGERtable {

    public $id = '';
    public $cityName = '';
    public $name = '';
    public $stateid = '';
    public $countryid = '';
    public $latitude = '';
    public $longitude = '';
    public $enabled = '';

    function __construct() {
        parent::__construct('cities', 'id'); // tablename, primarykey
    }

}

?>