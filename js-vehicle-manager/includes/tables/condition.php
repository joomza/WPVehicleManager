<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERConditionTable extends JSVEHICLEMANAGERtable {

    public $id = '';
    public $title = '';
    public $color = '';
    public $status = '';
    public $alias = '';
    public $ordering = '';

    function __construct() {
        parent::__construct('conditions', 'id'); // tablename, primarykey
    }

}

?>