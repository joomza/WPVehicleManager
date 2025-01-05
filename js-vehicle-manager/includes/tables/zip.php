<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERZipTable extends JSVEHICLEMANAGERtable {

    public $id = '';
    public $code = '';
    public $enabled = '';
    public $countryid = '';
    public $stateid = '';
    public $cityid = '';
    public $latitude = '';
    public $longitude = '';

    function __construct() {
        parent::__construct('zip', 'id'); // tablename, primarykey
    }

}

?>