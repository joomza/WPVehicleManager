<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERVehicletypeTable extends JSVEHICLEMANAGERtable {

    public $id = '';
    public $title = '';
    public $status = '';
    public $isdefault = '';
    public $logo = '';
    public $alias = '';
    public $ordering = '';

    function __construct() {
        parent::__construct('vehicletypes', 'id'); // tablename, primarykey
    }

}

?>