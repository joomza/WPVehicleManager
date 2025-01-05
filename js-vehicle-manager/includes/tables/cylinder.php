<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERCylinderTable extends JSVEHICLEMANAGERtable {

    public $id = '';
    public $title = '';
    public $status = '';
    public $isdefault = '';
    public $ordering = '';

    function __construct() {
        parent::__construct('cylinders', 'id'); // tablename, primarykey
    }

}

?>