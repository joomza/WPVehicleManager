<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERCountryTable extends JSVEHICLEMANAGERtable {

    public $id = '';
    public $name = '';
    public $shortCountry = '';
    public $continentID = '';
    public $dialCode = '';
    public $enabled = '';

    function __construct() {
        parent::__construct('countries', 'id'); // tablename, primarykey
    }

}

?>