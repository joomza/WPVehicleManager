<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERVehicleimageTable extends JSVEHICLEMANAGERtable {

    public $id = '';
    public $vehicleid = '';
    public $file = '';
    public $filename = '';
    public $filesize = '';
    public $created = '';
    public $status = '';
    public $isdefault = '';

    function __construct() {
        parent::__construct('vehicleimages', 'id'); // tablename, primarykey
    }

}

?>