<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERfieldsorderingTable extends JSVEHICLEMANAGERtable {

    public $id = '';
    public $field = '';
    public $fieldtitle = '';
    public $ordering = '';
    public $section = '';
    public $fieldfor = '';
    public $published = '';
    public $isvisitorpublished = '';
    public $sys = '';
    public $cannotunpublish = '';
    public $required = '';
    public $isuserfield = '';
    public $userfieldtype = '';
    public $userfieldparams = '';
    public $search_user = '';
    public $search_visitor = '';
    public $cannotsearch = '';
    public $showonlisting = '';
    public $cannotshowonlisting = '';
    public $depandant_field = '';
    public $readonly = '';
    public $size = '';
    public $maxlength = '';
    public $cols = '';
    public $rows = '';
    public $j_script = '';
    public $search_ordering = '';

    function __construct() {
        parent::__construct('fieldsordering', 'id'); // tablename, primarykey
    }

}

?>
