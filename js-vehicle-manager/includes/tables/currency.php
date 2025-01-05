<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERCurrencyTable extends JSVEHICLEMANAGERtable {

    public $id = '';
    public $title = '';
    public $symbol = '';
    public $code = '';
    public $status = '';
    public $isdefault = '';
    public $ordering = '';

    function __construct() {
        parent::__construct('currencies', 'id'); // tablename, primarykey
    }

}

?>