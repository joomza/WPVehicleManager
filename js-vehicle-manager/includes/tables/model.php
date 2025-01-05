<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERModelTable extends JSVEHICLEMANAGERtable {

    public $id = '';
    public $makeid = '';
    public $title = '';
    public $alias = '';
    public $status = '';
    public $ordering = '';

    function __construct() {
        parent::__construct('models', 'id'); // tablename, primarykey
    }

}

?>