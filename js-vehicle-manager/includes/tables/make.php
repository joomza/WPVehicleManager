<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERMakeTable extends JSVEHICLEMANAGERtable {

    public $id = '';
    public $title = '';
    public $alias = '';
    public $status = '';
    public $logo = '';
    public $ordering = '';

    function __construct() {
        parent::__construct('makes', 'id'); // tablename, primarykey
    }

}

?>