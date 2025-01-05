<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERformhandler {

    function __construct() {
        add_action('init', array($this, 'checkFormRequest'));
        add_action('init', array($this, 'checkDeleteRequest'));
    }

    /*
     * Handle Form request
     */

    function checkFormRequest() {
        $formrequest = JSVEHICLEMANAGERrequest::getVar('form_request', 'post');
        if ($formrequest == 'jsvehiclemanager') {
            //handle the request
            $modulename = (is_admin()) ? 'page' : 'jsvmme';
            $module = JSVEHICLEMANAGERrequest::getVar($modulename);
            $module = str_replace('jsvm_', '', $module);
            JSVEHICLEMANAGERincluder::include_file($module);
            $class = 'JSVEHICLEMANAGER' . $module . "Controller";
            $task = JSVEHICLEMANAGERrequest::getVar('task');
            if(class_exists($class)){
                $obj = new $class;
                $obj->$task();
            }
        }
    }

    /*
     * Handle Form request
     */

    function checkDeleteRequest() {
        $jsvehiclemanager_action = JSVEHICLEMANAGERrequest::getVar('action', 'get');
        if ($jsvehiclemanager_action == 'jsvmtask') {
            //handle the request
            $modulename = (is_admin()) ? 'page' : 'jsvmme';
            $module = JSVEHICLEMANAGERrequest::getVar($modulename);
            $module = str_replace('jsvm_', '', $module);
            JSVEHICLEMANAGERincluder::include_file($module);
            $class = 'JSVEHICLEMANAGER' . $module . "Controller";
            $action = JSVEHICLEMANAGERrequest::getVar('task');
            if(class_exists($class)){
                $obj = new $class;
                $obj->$action();
            }

        }
    }

}

$formhandler = new JSVEHICLEMANAGERformhandler();
?>
