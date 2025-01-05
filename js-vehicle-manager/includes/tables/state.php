<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERstateTable extends JSVEHICLEMANAGERtable {

    public $id = '';
    public $name = '';
    public $shortRegion = '';
    public $countryid = '';
    public $enabled = '';

    function __construct() {
        parent::__construct('states', 'id'); // tablename, primarykey
    }

}

?>