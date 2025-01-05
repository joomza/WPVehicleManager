<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

if (!defined('JSVEHICLEMANAGER_FILE_TYPE_ERROR')) {
    define('JSVEHICLEMANAGER_FILE_TYPE_ERROR', 'JSVEHICLEMANAGER_FILE_TYPE_ERROR');
    define('JSVEHICLEMANAGER_FILE_SIZE_ERROR', 'JSVEHICLEMANAGER_FILE_SIZE_ERROR');
    define('JSVEHICLEMANAGER_ALREADY_EXIST', 'JSVEHICLEMANAGER_ALREADY_EXIST');
    define('JSVEHICLEMANAGER_NOT_EXIST', 'JSVEHICLEMANAGER_NOT_EXIST');
    define('JSVEHICLEMANAGER_IN_USE', 'JSVEHICLEMANAGER_IN_USE');
    define('JSVEHICLEMANAGER_SET_DEFAULT', 'JSVEHICLEMANAGER_SET_DEFAULT');
    define('JSVEHICLEMANAGER_SET_DEFAULT_ERROR', 'JSVEHICLEMANAGER_SET_DEFAULT_ERROR');
    define('JSVEHICLEMANAGER_STATUS_CHANGED', 'JSVEHICLEMANAGER_STATUS_CHANGED');
    define('JSVEHICLEMANAGER_STATUS_CHANGED_ERROR', 'JSVEHICLEMANAGER_STATUS_CHANGED_ERROR');
    define('JSVEHICLEMANAGER_APPROVED', 'JSVEHICLEMANAGER_APPROVED');
    define('JSVEHICLEMANAGER_APPROVE_ERROR', 'JSVEHICLEMANAGER_APPROVE_ERROR');
    define('JSVEHICLEMANAGER_REJECTED', 'JSVEHICLEMANAGER_REJECTED');
    define('JSVEHICLEMANAGER_REJECT_ERROR', 'JSVEHICLEMANAGER_REJECT_ERROR');
    define('JSVEHICLEMANAGER_UN_PUBLISHED', 'JSVEHICLEMANAGER_UN_PUBLISHED');
    define('JSVEHICLEMANAGER_UN_PUBLISH_ERROR', 'JSVEHICLEMANAGER_UN_PUBLISH_ERROR');
    define('JSVEHICLEMANAGER_UNPUBLISH_DEFAULT_ERROR', 'JSVEHICLEMANAGER_UNPUBLISH_DEFAULT_ERROR');
    define('JSVEHICLEMANAGER_PUBLISHED', 'JSVEHICLEMANAGER_PUBLISHED');
    define('JSVEHICLEMANAGER_PUBLISH_ERROR', 'JSVEHICLEMANAGER_PUBLISH_ERROR');
    define('JSVEHICLEMANAGER_REQUIRED', 'JSVEHICLEMANAGER_REQUIRED');
    define('JSVEHICLEMANAGER_REQUIRED_ERROR', 'JSVEHICLEMANAGER_REQUIRED_ERROR');
    define('JSVEHICLEMANAGER_NOT_REQUIRED', 'JSVEHICLEMANAGER_NOT_REQUIRED');
    define('JSVEHICLEMANAGER_NOT_REQUIRED_ERROR', 'JSVEHICLEMANAGER_NOT_REQUIRED_ERROR');
    define('JSVEHICLEMANAGER_ORDER_UP', 'JSVEHICLEMANAGER_ORDER_UP');
    define('JSVEHICLEMANAGER_ORDER_UP_ERROR', 'JSVEHICLEMANAGER_ORDER_UP_ERROR');
    define('JSVEHICLEMANAGER_ORDER_DOWN', 'JSVEHICLEMANAGER_ORDER_DOWN');
    define('JSVEHICLEMANAGER_ORDER_DOWN_ERROR', 'JSVEHICLEMANAGER_ORDER_DOWN_ERROR');
    define('JSVEHICLEMANAGER_SAVED', 'JSVEHICLEMANAGER_SAVED');
    define('JSVEHICLEMANAGER_SAVE_ERROR', 'JSVEHICLEMANAGER_SAVE_ERROR');
    define('JSVEHICLEMANAGER_DELETED', 'JSVEHICLEMANAGER_DELETED');
    define('JSVEHICLEMANAGER_DELETE_ERROR', 'JSVEHICLEMANAGER_DELETE_ERROR');
    define('JSVEHICLEMANAGER_VERIFIED', 'JSVEHICLEMANAGER_VERIFIED');
    define('JSVEHICLEMANAGER_APPLY', 'JSVEHICLEMANAGER_APPLY');
    define('JSVEHICLEMANAGER_APPLY_ERROR', 'JSVEHICLEMANAGER_APPLY_ERROR');
    define('JSVEHICLEMANAGER_UN_VERIFIED', 'JSVEHICLEMANAGER_UN_VERIFIED');
    define('JSVEHICLEMANAGER_VERIFIED_ERROR', 'JSVEHICLEMANAGER_VERIFIED_ERROR');
    define('JSVEHICLEMANAGER_UN_VERIFIED_ERROR', 'JSVEHICLEMANAGER_UN_VERIFIED_ERROR');
    define('JSVEHICLEMANAGER_INVALID_REQUEST', 'JSVEHICLEMANAGER_INVALID_REQUEST');
    define('JSVEHICLEMANAGER_ENABLED', 'JSVEHICLEMANAGER_ENABLED');
    define('JSVEHICLEMANAGER_DISABLED', 'JSVEHICLEMANAGER_DISABLED');
    define('JSVEHICLEMANAGER_INVALID_LOSTEMAIL', 'JSVEHICLEMANAGER_INVALID_LOSTEMAIL'); 
    define('JSVEHICLEMANAGER_EMPTY_LOSTUSERNAME', 'JSVEHICLEMANAGER_EMPTY_LOSTUSERNAME'); 
    define('JSVEHICLEMANAGER_CONFIRMEMAIL_RESET', 'JSVEHICLEMANAGER_CONFIRMEMAIL_RESET');
    define('JSVEHICLEMANAGER_EXPIRED_INVALID_KEY', 'JSVEHICLEMANAGER_EXPIRED_INVALID_KEY');
    define('JSVEHICLEMANAGER_PASSWORD_RESET_MISMATCH', 'JSVEHICLEMANAGER_PASSWORD_RESET_MISMATCH');
    define('JSVEHICLEMANAGER_PASSWORD_RESET_EMPTY', 'JSVEHICLEMANAGER_PASSWORD_RESET_EMPTY');
    define('JSVEHICLEMANAGER_INVALID_LOSTREQUEST', 'JSVEHICLEMANAGER_INVALID_LOSTREQUEST');
    define('JSVEHICLEMANAGER_WOO_UNPUBLISHED', 'JSVEHICLEMANAGER_WOO_UNPUBLISHED');
    define('JSVEHICLEMANAGER_ALREADY_PURCHASED', 'JSVEHICLEMANAGER_ALREADY_PURCHASED');
    define('JSVEHICLEMANAGER_PLUGIN_PATH', plugin_dir_path( __DIR__ ));
    define('JSVEHICLEMANAGER_PLUGIN_URL', plugin_dir_url( __DIR__ ));

    define('JSVEHICLEMANAGER_ALLOWED_TAGS',array(
        'div'      => array(
            'class'  => array(),
            'id' => array(),
            'data-sitekey' => array(),
            'title' => array(),
            'role' => array(),
            'onclick' => array(),
            'onmouseout' => array(),
            'onmouseover' => array(),
            'data-section' => array(),
            'data-sectionid' => array(),
            'data-boxid' => array(),
            'data-id' => array(),
            'style' => array(),
            'color' => array(),
            'unselectable' => array(),
            'data-mce-style' => array(),
            'data-mce-selected' => array(),
            'data-mce-bogus' => array(),
        ),
        
        'object'      => array(
            'class'  => array(),
            'title'  => array(),
            'data'  => array(),
             'width'  => array(),
            'height'  => array(),
            'id' => array(),
            'type' => array(),
            'title' => array(),
            'role' => array(),
            'onclick' => array(),
            'data-dismiss' => array(),
            'aria-label' => array(),
            'style' => array(),
            'color' => array(),
        ),
        
        'button'      => array(
            'class'  => array(),
            'id' => array(),
            'type' => array(),
            'title' => array(),
            'role' => array(),
            'onclick' => array(),
            'data-dismiss' => array(),
            'aria-label' => array(),
            'style' => array(),
            'color' => array(),
        ),
        
        'iframe'      => array(
            'title'  => array(),
            'width'  => array(),
            'height'  => array(),
            'src'  => array(),
            'frameborder'  => array(),
            'allowfullscreen'  => array(),
            'data-origheight'  => array(),
            'data-origwidth'  => array(),
            'class'  => array(),
            'id' => array(),
            'type' => array(),
            'title' => array(),
            'role' => array(),
            'onclick' => array(),
            'data-dismiss' => array(),
            'aria-label' => array(),
            'style' => array(),
            'color' => array(),
        ),
        'i'      => array(
            'class'  => array(),
            'id' => array(),
            'style' => array(),
        ),
        'h1'      => array(
            'class'  => array(),
            'id' => array(),
            'style' => array(),
        ),
        'h2'      => array(
            'class'  => array(),
            'id' => array(),
            'style' => array(),
        ),
        'h3'      => array(
            'class'  => array(),
            'id' => array(),
            'style' => array(),
        ),
        'h4'      => array(
            'class'  => array(),
            'id' => array(),
            'style' => array(),
        ),
        'h5'      => array(
            'class'  => array(),
            'id' => array(),
            'style' => array(),
        ),
        'h6'      => array(
            'class'  => array(),
            'id' => array(),
            'style' => array(),
        ),
        'font'      => array(
            'class'  => array(),
            'id' => array(),
            'style' => array(),
            'color' => array(),
        ),
        'span'      => array(
            'class'  => array(),
            'id' => array(),
            'aria-hidden' => array(),
            'style' => array(),
            'color' => array(),
        ),
        'input'      => array(
            'type'  => array(),
            'id' => array(),
            'class' => array(),
            'name' => array(),
            'value' => array(),
            'onclick' => array(),
            'onchange' => array(),
            'data-validation' => array(),
            'required' => array(),
            'size' => array(),
            'placeholder' => array(),
            'checked' => array(),
            'autocomplete' => array(),
            'multiple' => array(),
            'rel' => array(),
            'maxlength' => array(),
            'disabled' => array(),
            'readonly' => array(),
            'data-for' => array(),
            'credit_userid' => array(),
            'data-dismiss' => array(),
            'data-validation-optional' => array(),
            'data-myrequired' => array(),
            'style' => array(),
            'data-placeholder' => array(),
            'data-symbols' => array(),
            'color' => array(),
        ),
        'textarea'     => array(
            'rows' => array(),
            'name' => array(),
            'class' => array(),
            'id' => array(),
            'value' => array(),
            'cols' => array(),
            'data-validation' => array(),
            'data-myrequired' => array(),
            'autocomplete' => array(),
            'style' => array(),
            'data-placeholder' => array(),
            'data-symbols' => array(),
            'color' => array(),
        ),
        'button'      => array(
            'type'  => array(),
            'id' => array(),
            'class' => array(),
            'name' => array(),
            'value' => array(),
            'onclick' => array(),
            'data-validation' => array(),
            'required' => array(),
            'data-dismiss' => array(),
            'style' => array(),
            'color' => array(),

        ),
        'select'      => array(
            'id' => array(),
            'class' => array(),
            'name' => array(),
            'onchange' => array(),
            'data-validation' => array(),
            'required' => array(),
            'multiple' => array(),
            'data-myrequired' => array(),
            'data-placeholder' => array(),
            'style' => array(),
            'multiple' => array(),
            'title' => array(),
            'data-makeid' => array(),
            'data-modelid' => array(),
             'data-symbols' => array(),
             'color' => array(),
        ),
        'option'      => array(
            'id' => array(),
            'class' => array(),
            'name' => array(),
            'value' => array(),
            'selected' => array(),
            'style' => array(),
            'data-placeholder' => array(),
            'color' => array(),
        ),
        'img'      => array(
            'src'  => array(),
            'id' => array(),
            'class' => array(),
            'onclick' => array(),
            'alt' => array(),
            'width' => array(),
            'height' => array(),
            'border' => array(),
            'style' => array(),
            'data-placeholder' => array(),
            'color' => array(),
        ),
        'link'      => array(
            'src'  => array(),
            'id' => array(),
            'rel' => array(),
            'href' => array(),
            'media' => array(),
            'style' => array(),
            'color' => array(),
        ),
        'meta'      => array(
            'property'  => array(),
            'content' => array(),
            'style' => array(),
        ),
        'a'      => array(
            'href'  => array(),
            'title' => array(),
            'onclick' => array(),
            'id' => array(),
            'class' => array(),
            'name' => array(),
            'data-toggle' => array(),
            'data-id' => array(),
            'data-name' => array(),
            'data-email' => array(),
            'data-id' => array(),
            'data-name' => array(),
            'data-email' => array(),
            'message' => array(),
            'confirmmessage' => array(),
            'data-for' => array(),
            'data-sortby' => array(),
            'data-image1' => array(),
            'data-image2' => array(),
            'data-showmore' => array(),
            'data-scrolltask' => array(),
            'data-offset' => array(),
            'data-section' => array(),
            'target' => array(),
            'style' => array(),
            'color' => array(),
        ),
        'ul'      => array(
            'type'  => array(),
            'id' => array(),
            'class' => array(),
            'style' => array(),
        ),
        'ol'      => array(
            'id' => array(),
            'class' => array(),
            'style' => array(),
        ),
        'li'      => array(
            'id' => array(),
            'class' => array(),
            'onclick' => array(),
            'style' => array(),
        ),
        'dl'      => array(
            'id' => array(),
            'class' => array(),
            'style' => array(),
        ),
        'dt'      => array(
            'id' => array(),
            'class' => array(),
            'style' => array(),
        ),
        'dd'      => array(
            'id' => array(),
            'class' => array(),
            'style' => array(),
        ),
        'table'      => array(
            'id' => array(),
            'class' => array(),
            'style' => array(),
            'data-mce-style' => array(),
            'data-mce-selected' => array(),
        ),
        'thead'      => array(
            'id' => array(),
            'class' => array(),
            'style' => array(),
            'data-mce-style' => array(),
            'data-mce-selected' => array(),
        ),
        'tr'      => array(
            'id' => array(),
            'class' => array(),
            'style' => array(),
            'data-mce-style' => array(),
        ),
        'td'      => array(
            'id' => array(),
            'class' => array(),
            'style' => array(),
            'data-mce-style' => array(),
        ),
        'th'      => array(
            'id' => array(),
            'class' => array(),
            'style' => array(),
            'data-mce-style' => array(),
        ),
        'p'      => array(
            'id' => array(),
            'class' => array(),
            'style' => array(),
            'data-mce-style' => array(),
        ),
        'form'      => array(
            'id' => array(),
            'class' => array(),
            'method' => array(),
            'action' => array(),
            'enctype' => array(),
        ),
        'label'      => array(
            'id' => array(),
            'class' => array(),
            'for' => array(),
            'onclick' => array(),
            'style' => array(),
            'color' => array(),
        ),
        'i'     => array(
            'id' => array(),
            'class' => array(),
            'aria-hidden' => array(),
            'style' => array(),
        ),
        'style'     => array(
            'src' => array(),
            'type' => array(),
            'class' => array(),
            'style' => array(),
        ),
        'script'     => array(
            'src' => array(),
            'type' => array(),
            'class' => array(),
            'style' => array(),
        ),
        'br'     => array(
            'style' => array(),),
        'hr'     => array(
            'id' => array(),
            'class' => array(),
            'style' => array(),),
        'b'     => array(
            'style' => array(),),
        'em'     => array(
            'style' => array(),),
        'strong' => array(
            'style' => array(),
        ),
        'small' => array(
            'style' => array(),),
        ' ' => array(),
    ));
}
?>
