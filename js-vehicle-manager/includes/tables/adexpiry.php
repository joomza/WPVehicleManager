<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERAdexpiryTable extends JSVEHICLEMANAGERtable {

    public $id = '';
    public $status = '';
    public $type = '';
    public $isdefault = '';
    public $advalue = '';
    public $ordering = '';

    function __construct() {
        parent::__construct('adexpiries', 'id'); // tablename, primarykey
    }

}

?>