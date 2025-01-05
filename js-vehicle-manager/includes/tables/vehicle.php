<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERVehicleTable extends JSVEHICLEMANAGERtable {

     public $id = '';
     public $uid = '';
     public $sellerinfoid = '';
     public $vehicletypeid = '';
     public $makeid = '';
     public $modelid = '';
     public $modelyearid = '';
     public $conditionid = '';
     public $fueltypeid = '';
     public $cylinderid = '';
     public $transmissionid = '';
     public $adexpiryid = '';
     public $regcity = '';
     public $loccity = '';
     public $mileages = '';
     public $price = '';
     public $exteriorcolor = '';
     public $interiorcolor = '';
     public $enginecapacity = '';
     public $cityfuelconsumption = '';
     public $highwayfuelconsumption = '';
     public $video = '';
     public $videotype = '';
     public $description = '';
     public $status = '';
     public $title = '';
     public $alias = '';
     public $loczip = '';
     public $created = '';
     public $isgoldvehicle = '';
     public $isfeaturedvehicle = 2; // for the case of new vehicle store
     public $startfeatureddate = '';
     public $endfeatureddate = '';
     public $adexpiryvalue = '';
     public $currencyid = '';
     public $vehicleid = '';
     public $hits = '';
     public $issold = '';
     public $solddate = '';
     public $latitude = '';
     public $longitude = '';
     public $registrationnumber = '';
     public $chasisnumber = '';
     public $enginenumber = '';
     public $streetaddress = '';
     public $stocknumber = '';
     public $acceleration = '';
     public $maxspeed = '';
     public $bargainprice = '';
     public $exportprice = '';
     public $isdiscount = '';
     public $discountstart = '';
     public $discountend = '';
     public $discounttype = '';
     public $discount = '';
     public $speedmetertypeid = '';
     public $co2 = '';
     public $soldbyuid = '';
     public $goldvehiclebyuid = '';
     public $featuredvehiclebyuid = '';
     public $isdeleted = '';
     public $deletevehiclebyid = '';
     public $vehicleoptions = '';
     public $params = '';
     public $brochure = '';
     public $hash = '';

    function __construct() {
        parent::__construct('vehicles', 'id'); // tablename, primarykey
    }

}

?>