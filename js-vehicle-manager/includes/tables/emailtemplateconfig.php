<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERemailtemplateconfigTable extends JSVEHICLEMANAGERtable {

    public $id = '';
    public $emailfor = '';
    public $admin = '';
    public $seller = '';
    public $buyer = '';
    public $seller_visitor = '';
    public $buyer_visitor = '';

    function __construct() {
        parent::__construct('emailtemplates_config', 'id'); // tablename, primarykey
    }

}

?>