<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERcustomfieldModel {
     function getMessagekey(){
        $key = 'customfield';if(is_admin()){$key = 'admin_'.$key;}return $key;
    }


}

?>
