<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERMileageTable extends JSVEHICLEMANAGERtable {

    public $id = '';
    public $title = '';
    public $status = '';
    public $isdefault = '';
    public $symbol = '';
    public $alias = '';
    public $ordering = '';

    function __construct() {
        parent::__construct('mileages', 'id'); // tablename, primarykey
    }

}

?>