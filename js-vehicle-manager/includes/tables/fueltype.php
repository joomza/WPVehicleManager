<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERFueltypeTable extends JSVEHICLEMANAGERtable {

    public $id = '';
    public $title = '';
    public $status = '';
    public $isdefault = '';
    public $alias = '';
    public $ordering = '';

    function __construct() {
        parent::__construct('fueltypes', 'id'); // tablename, primarykey
    }

}

?>