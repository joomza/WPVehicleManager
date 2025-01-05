<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERUploads {

    private $uploadfor;
    private $objectid;
    
    function jsvehiclemanager_upload_dir( $dir ) {
        $datadirectory = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
        $path = $datadirectory . '/data';

        $flag = false;
        if($this->uploadfor == 'vehicle'){
            $path = $path . '/vehicle/vehicle_'.$this->objectid;
        }elseif($this->uploadfor == 'vehicletype'){
            $path = $path . '/vehicletype/vehicletype_'.$this->objectid;
            $flag = true;
        }elseif($this->uploadfor == 'make'){
            $path = $path . '/make/make_'.$this->objectid;
            $flag = true;
        }elseif($this->uploadfor == 'profile'){
            $path = $path . '/profile/profile_'.$this->objectid;
        }

        $userpath = $path;

        $array = array(
            'path'   => $dir['basedir'] . '/' . $userpath,
            'url'    => $dir['baseurl'] . '/' . $userpath,
            'subdir' => '/'. $userpath,
        ) + $dir;
        
        // delete previous files
        if($flag){
            $path = $array['path'];
            $files = glob( $path . '/*');
            foreach($files as $file){
                if(is_file($file)) unlink($file);
            }
        }
        return $array;
        
    }

    function storeCustomUploadFile($id, $field,$for = 0){
        $file_size = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('allowed_file_size');
        if (!function_exists('wp_handle_upload')) { 
            require_once( ABSPATH . 'wp-admin/includes/file.php' ); 
        }
        if($for ==0 ){
            $this->objectid = $id;
            $this->uploadfor = 'vehicle';
        }elseif($for == 2){
            $this->objectid = $id;
            $this->uploadfor = 'profile';
        }
        $key = JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getMessagekey();
        // Register our path override.
        add_filter( 'upload_dir', array($this,'jsvehiclemanager_upload_dir'));
        // Do our thing. WordPress will move the file to 'uploads/mycustomdir'.
        $result = array();
        $filename = '';
        $return = true;
        $file = array(
                'name'     => $_FILES[$field]['name'],
                'type'     => $_FILES[$field]['type'],
                'tmp_name' => $_FILES[$field]['tmp_name'],
                'error'    => $_FILES[$field]['error'],
                'size'     => $_FILES[$field]['size']
                );
        $uploadfilesize = $_FILES[$field]['size'] / 1024; //kb
        if($uploadfilesize > $file_size){
            JSVEHICLEMANAGERmessages::setLayoutMessage( __('Error file size too large', 'js-vehicle-manager'), 'error', $key);;
            $return = 5;
        }else{
            $filetyperesult = wp_check_filetype($_FILES[$field]['name']);
            if(!empty($filetyperesult['ext']) && !empty($filetyperesult['type'])){
                $image_file_types = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('image_file_type');
                $file_file_types = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('file_file_type');
                if(strstr($image_file_types, $filetyperesult['ext']) || strstr($file_file_types, $filetyperesult['ext'])){
                    $result = wp_handle_upload($file, array('test_form' => false));
                    if ( $result && ! isset( $result['error'] ) ) {
                        $filename = basename( $result['file'] );
                    } else {
                        jsvmmessage::setMessage($result['error'], 'error',$key);
                    }
                }else{
                    $return = 5;
                }
            }else{
                $return = 6;
            }
        }
        // Set everything back to normal.
        remove_filter( 'upload_dir', array($this,'jsvehiclemanager_upload_dir'));
        if($for == 0){
            JSVEHICLEMANAGERincluder::getJSModel('vehicle')->storeUploadFieldValueInParams($id,$filename,$field);
        }elseif($for == 2){
            JSVEHICLEMANAGERincluder::getJSModel('user')->storeUploadFieldValueInParams($id,$filename,$field);
        }
        return ;
    }
    
    function vehicleManagerUpload($id, $file , $for){
        $file_size = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('allowed_file_size');
        if (!function_exists('wp_handle_upload')) { 
            require_once( ABSPATH . 'wp-admin/includes/file.php' ); 
        }
        $this->objectid = $id;
        if($for == 1){
            $this->uploadfor = 'vehicletype';
            $model = 'vehicletype';
        }elseif($for == 2){
            $this->uploadfor = 'make';
            $model = 'make';
        }elseif($for == 3){
            $this->uploadfor = 'profile';
            $model = 'user';
        }elseif($for == 4 || $for == 5){
            $this->objectid = $id;
            $this->uploadfor = 'vehicle';
            $model = 'vehicle';
        }elseif($for == 6){
            $model = 'configuration';
        }else{
            return false;
        }
        if($file['size'] == 0){
            return false;
        }

        // Register our path override.
        add_filter( 'upload_dir', array($this,'jsvehiclemanager_upload_dir'));
        // Do our thing. WordPress will move the file to 'uploads/mycustomdir'.
        $result = array();
        $fileurl = array();
        $filename = '';
        $uploadfilesize = $file['size'] / 1024; //kb
        $key = JSVEHICLEMANAGERincluder::getJSModel($model)->getMessagekey();
        if($uploadfilesize > $file_size){
            JSVEHICLEMANAGERmessages::setLayoutMessage(__('Error file size too large', 'js-vehicle-manager'), 'error' , $key);
        }else{
            $filetyperesult = wp_check_filetype($file['name']);
            if(!empty($filetyperesult['ext']) && !empty($filetyperesult['type'])){
                if($for == 5){
                    $image_file_types = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('file_file_type');
                }else{
                    $image_file_types = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('image_file_type');
                }
                if(strstr($image_file_types, $filetyperesult['ext'])){
                    $result = wp_handle_upload($file, array('test_form' => false));
                    if ( $result && ! isset( $result['error'] ) ) {
                        $fileurl[0] = $result['file'];
                        $fileurl[1] = $result['url'];
                    } else {
                        /**
                         * Error generated by _wp_handle_upload()
                         * @see _wp_handle_upload() in wp-admin/includes/file.php
                         */
                        JSVEHICLEMANAGERmessages::setLayoutMessage($result['error'], 'error' , $key);
                    }
                }else{
                    JSVEHICLEMANAGERmessages::setLayoutMessage(__('Error file extension mismatch', 'js-vehicle-manager'), 'error' , $key);
                }
            }else{
                JSVEHICLEMANAGERmessages::setLayoutMessage(__('Error wp file extension mismatch', 'js-vehicle-manager'), 'error' , $key);
            }
        }

        // Set everything back to normal.
        remove_filter( 'upload_dir', array($this,'jsvehiclemanager_upload_dir'));
        if($for == 4){
            return $fileurl;
        }
        if($for == 3){
            return $fileurl;
        }
        if($for == 6){
            return $fileurl[1];
        }
        if(empty($fileurl)){
            return false;
        }else{
            return $fileurl[1];
        }
    }
}

?>
