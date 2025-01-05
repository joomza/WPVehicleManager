<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERincluder {

    function __construct() {

    }

    /*
     * Includes files
     */

    public static function include_file($filename, $module_name = null) {
        if ($module_name != null) {
            $file_path = JSVEHICLEMANAGERincluder::getPluginPath($module_name,'file',$filename);
            if (file_exists(JSVEHICLEMANAGER_PLUGIN_PATH . 'includes/css/inc-css/' . $module_name . '-' . $filename . '.css.php')) {
                require_once(JSVEHICLEMANAGER_PLUGIN_PATH . 'includes/css/inc-css/' . $module_name . '-' . $filename . '.css.php');
            }

            if(is_array($file_path) && file_exists($file_path['tmpl_file'])){
                if (file_exists($file_path['inc_file'])) {
                    require_once($file_path['inc_file']);
                }
                include_once $file_path['tmpl_file'];
            }else if(file_exists($file_path)){
                //$incfilepath = explode('.', $file_path);
		$incfilepath = explode('.php', $file_path);
                $incfilename = $incfilepath[0].'.inc.php';
                if (file_exists($incfilename)) {
                    require_once($incfilename);
                }
                include_once $file_path; //
            }else{
                $file_path = JSVEHICLEMANAGERincluder::getPluginPath('premiumplugin','file','missingaddon');
                if(is_array($file_path)){
                    include_once $file_path['tmpl_file'];
                }else{
                    include_once $file_path; //
                }
            }
        } else {
            $file_path = JSVEHICLEMANAGERincluder::getPluginPath($filename,'file');
            if(file_exists($file_path)){
                include_once $file_path; //
            }else{
                $file_path = JSVEHICLEMANAGERincluder::getPluginPath('premiumplugin','file');
                include_once $file_path; //
            }
        }



        return;
    }

    /*
     * Static function to handle the page slugs
     */

    public static function include_slug($page_slug) {
        include_once JSVEHICLEMANAGER_PLUGIN_PATH . 'modules/js-vehicle-manager-controller.php';
    }

    /*
     * Static function for the model object
     */

    public static function getJSModel($modelname) {
        $file_path = JSVEHICLEMANAGERincluder::getPluginPath($modelname,'model');
        include_once $file_path;
        $classname = "JSVEHICLEMANAGER" . $modelname . 'Model';
        $obj = new $classname();
        return $obj;
    }

    /*
     * Static function for the classes objects
     */

    public static function getObjectClass($classname) {
        $file_path = JSVEHICLEMANAGERincluder::getPluginPath($classname,'class');
        include_once $file_path;
        $classname = "JSVEHICLEMANAGER" . $classname ;
        $obj = new $classname();
        return $obj;
    }

    /*
     * Static function for the classes not objects
     */

    public static function getClassesInclude($classname) {
        $file_path = JSVEHICLEMANAGERincluder::getPluginPath($classname,'class');
        include_once $file_path;
    }

    /*
     * Static function for the table object
     */

    public static function getJSTable($tableclass) {
        $file_path = JSVEHICLEMANAGERincluder::getPluginPath($tableclass,'table');
        require_once JSVEHICLEMANAGER_PLUGIN_PATH . 'includes/tables/table.php';
        include_once $file_path;
        $classname = "JSVEHICLEMANAGER" . $tableclass . 'Table';
        $obj = new $classname();
        return $obj;
    }

    /*
     * Static function for the controller object
     */

    public static function getJSController($controllername) {
        $file_path = JSVEHICLEMANAGERincluder::getPluginPath($controllername,'controller');

        include_once $file_path;
        $classname = "JSVEHICLEMANAGER".$controllername . "Controller";
        $obj = new $classname();
        return $obj;
    }

    public static function getPluginPath($module,$type,$file_name = '') {

        $addons_secondry = array('facebook','linkedin','creditslog','creditspack','paymentmethodconfiguration','purchase','purchasehistory','paymenthistory','usercredits','popup');

        if(in_array($module, jsvehiclemanager::$_active_addons)){
            $path = WP_PLUGIN_DIR.'/'.'js-vehicle-manager-'.$module.'/';
            switch ($type) {
                case 'file':
                    if($file_name != ''){
                        if (locate_template('js-vehicle-manager/' . $module . '-' . $file_name . '.php', 0, 1)) {
                            $file_path['inc_file'] = $path . 'module/tmpl/' . $file_name . '.inc.php';
                            $file_path['tmpl_file'] = locate_template('js-vehicle-manager/' . $module . '-' . $file_name . '.php', 0, 1);
                        }else{
                            $file_path = $path . 'module/tmpl/' . $file_name . '.php';
                        }
                    }else{
                        $file_path = $path . 'module/controller.php';
                    }
                    break;
                case 'model':
                    $file_path = $path . 'module/model.php';
                    break;

                case 'class':
                    $file_path = $path . 'classes/' . $module . '.php';
                    break;
                case 'controller':
                    $file_path = $path . 'module/controller.php';
                    break;
                case 'table':
                    $file_path = $path . 'includes/' . $module . '-table.php';
                    break;
            }

        }elseif(in_array($module, $addons_secondry)){ // to handle the case of modules that are submodules for some addon
            $parent_module = '';
            switch ($module) {// to identify addon for submodules.
                case 'facebook':
                case 'linkedin':
                    $parent_module = 'sociallogin';
                    break;
                case 'creditslog':
                case 'creditspack':
                case 'paymentmethodconfiguration':
                case 'purchase':
                case 'purchasehistory':
                case 'paymenthistory':
                case 'usercredits':
                case 'popup':
                    $parent_module = 'credits';
                break;
            }

            $path = WP_PLUGIN_DIR.'/'.'js-vehicle-manager-'.$parent_module.'/';
            if(in_array($parent_module, jsvehiclemanager::$_active_addons)){
                switch ($type) {
                    case 'file':
                        if($file_name != ''){
                            if (locate_template('js-vehicle-manager/' . $module . '-' . $file_name . '.php', 0, 1)) {
                                $file_path['inc_file'] = $path . $module.'/tmpl/' . $file_name . '.inc.php';
                                $file_path['tmpl_file'] = locate_template('js-vehicle-manager/' . $module . '-' . $file_name . '.php', 0, 1);
                            }else{
                                $file_path = $path . $module.'/tmpl/' . $file_name . '.php';
                            }
                        }else{
                            $file_path = $path . $module.'/controller.php';
                        }
                        break;
                    case 'model':
                        $file_path = $path . $module.'/model.php';
                        break;

                    case 'class':
                        $file_path = $path . 'classes/' . $module . '.php';
                        break;
                    case 'controller':
                        $file_path = $path . $module.'/controller.php';
                        break;
                    case 'table':
                        $file_path = $path . 'includes/' . $module . '-table.php';
                        break;
                }
            }else{
                $file_path = JSVEHICLEMANAGERincluder::getPluginPath('premiumplugin','file');
            }

        }else{
            $path = JSVEHICLEMANAGER_PLUGIN_PATH;
            switch ($type) {
                case 'file':
                    if($file_name != ''){
                        if (locate_template('js-vehicle-manager/' . $module . '-' . $file_name . '.php', 0, 1)) {
                            $file_path['inc_file'] = $path . 'modules/' . $module . '/tmpl/' . $file_name . '.inc.php';
                            $file_path['tmpl_file'] = locate_template('js-vehicle-manager/' . $module . '-' . $file_name . '.php', 0, 1);
                        }else{
                            $file_path = $path . 'modules/' . $module . '/tmpl/' . $file_name . '.php';
                        }
                    }else{
                        $file_path = $path . 'modules/' . $module . '/controller.php';
                    }
                    break;
                case 'model':
                        $file_path = $path . 'modules/' . $module . '/model.php';
                    break;

                case 'class':
                    $file_path = $path . 'includes/classes/' . $module . '.php';
                    break;
                case 'controller':
                        $file_path = $path . 'modules/' . $module . '/controller.php';
                    break;
                case 'table':
                    $file_path = $path . 'includes/tables/' . $module . '.php';;
                    break;
            }
        }
        return $file_path;
    }

}

$includer = new JSVEHICLEMANAGERincluder();
if (!defined('JCONSTS'))
    define('JCONSTS', base64_decode("aHR0cDovL3d3dy5qb29tc2t5LmNvbS9pbmRleC5waHA/b3B0aW9uPWNvbV9qc3Byb2R1Y3RsaXN0aW5nJnRhc2s9YWFnamN3cA=="));

if (!defined('JCONSTV'))
    define('JCONSTV', base64_decode("aHR0cHM6Ly9zZXR1cC5qb29tc2t5LmNvbS9qc2pvYnN3cC9wcm8vaW5kZXgucGhw"));
?>
