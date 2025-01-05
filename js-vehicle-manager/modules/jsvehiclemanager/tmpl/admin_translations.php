<?php
   if(!defined('ABSPATH'))
    die('Restricted Access');
?>
    <?php $msgkey = JSVEHICLEMANAGERincluder::getJSModel('jsvehiclemanager')->getMessagekey();
    JSVEHICLEMANAGERmessages::getLayoutMessage($msgkey); ?>

<div id="jsvehiclemanageradmin-wrapper">
    <div id="jsvehiclemanageradmin-leftmenu">
        <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </div>
    <div id="jsvehiclemanageradmin-data">
        <span class="jsvm_js-admin-title">
            <a href="<?php echo esc_url(admin_url('admin.php?page=jsvehiclemanager')); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" /></a>
            <?php echo __('Translations', 'js-vehicle-manager') ?>
        </span>


        <div id="jsvehiclemanager-content">
            <div id="jsvm_black_wrapper_translation"></div>
            <div id="jsvm_jstran_loading">
                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/spinning-wheel.gif" />
            </div>

            <div id="jsvm_js-language-wrapper">
                <div class="jsvm_jstopheading"><?php echo __('Get Vehicle Manager Translations','js-vehicle-manager');?></div>
                <div id="jsvm_gettranslation" class="jsvm_gettranslation"><img style="width:18px; height:auto;" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/download-icon.png" /><?php echo __('Get Translations','js-vehicle-manager');?></div>
                <div id="jsvm_js_ddl">
                    <span class="jsvm_title"><?php echo __('Select Translation','js-vehicle-manager');?>:</span>
                    <span class="jsvm_combo" id="jsvm_js_combo"></span>
                    <span class="jsvm_button" id="jsvm_jsdownloadbutton"><img style="width:14px; height:auto;" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/download-icon.png" /><?php echo __('Download','js-vehicle-manager');?></span>
                    <div id="jsvm_jscodeinputbox" class="jsvm_js-some-disc"></div>
                    <div class="jsvm_js-some-disc"><img style="width:18px; height:auto;" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/info-icon.png" /><?php echo __('When WordPress language change to ro, WP Vehicle Manager language will auto change to ro');?></div>
                </div>
                <div id="jsvm_js-emessage-wrapper">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/c_error.png" />
                    <div id="jsvm_jslang_em_text"></div>
                </div>
                <div id="jsvm_js-emessage-wrapper_ok">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/saved.png" />
                    <div id="jsvm_jslang_em_text_ok"></div>
                </div>
            </div>
            <div id="jsvm_js-lang-toserver">
                <div class="js-col-xs-12 js-col-md-8 col"><a class="jsvm_anc jsvm_one" href="https://www.transifex.com/joom-sky/js-vehicle-manager" target="_blank"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/translation-icon.png" /><?php echo __('Contribute In Translation','js-vehicle-manager');?></a></div>
                <div class="js-col-xs-12 js-col-md-4 col"><a class="jsvm_anc jsvm_two" href="http://www.joomsky.com/translations.html" target="_blank"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/manual-download.png" /><?php echo __('Manual Download','js-vehicle-manager');?></a></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var ajaxurl = "<?php echo esc_url(admin_url('admin-ajax.php')) ?>";
    jQuery(document).ready(function(){
        jQuery('#jsvm_gettranslation').click(function(){
            jsShowLoading();
            jQuery.post(ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'jsvehiclemanager', task: 'getListTranslations',wpnoncecheck:common.wp_vm_nonce}, function (data) {
                if (data) {

                    jsHideLoading();
                    data = JSON.parse(data);
                    if(data['error']){
                        jQuery('#jsvm_js-emessage-wrapper div').html(data['error']);
                        jQuery('#jsvm_js-emessage-wrapper').show();
                    }else{
                        jQuery('#jsvm_js-emessage-wrapper').hide();
                        jQuery('#jsvm_gettranslation').hide();
                        jQuery('div#jsvm_js_ddl').show();
                        jQuery('span#jsvm_js_combo').html(data['data']);
                    }
                }
            });
        });
        
        jQuery(document).on('change', 'select#translations' ,function() {
            var lang_name = jQuery( this ).val();
            if(lang_name != ''){
                jQuery('#jsvm_js-emessage-wrapper_ok').hide();
                jsShowLoading();
                jQuery.post(ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'jsvehiclemanager', task: 'validateandshowdownloadfilename',langname:lang_name,wpnoncecheck:common.wp_vm_nonce}, function (data) {
                    if (data) {
                        jsHideLoading();
                        data = JSON.parse(data);
                        if(data['error']){
                            jQuery('#jsvm_js-emessage-wrapper div').html(data['error']);
                            jQuery('#jsvm_js-emessage-wrapper').show();
                            jQuery('#jsvm_jscodeinputbox').slideUp('400' , 'swing' , function(){
                                jQuery('input#languagecode').val("");
                            });
                        }else{
                            jQuery('#jsvm_js-emessage-wrapper').hide();
                            jQuery('#jsvm_jscodeinputbox').html(data['path']+': '+data['input']);
                            jQuery('#jsvm_jscodeinputbox').slideDown();
                        }
                    }
                });
            }
        });

        jQuery('#jsvm_jsdownloadbutton').click(function(){
            jQuery('#jsvm_js-emessage-wrapper_ok').hide();
            var lang_name = jQuery('#translations').val();
            var file_name = jQuery('#languagecode').val();
            if(lang_name != '' && file_name != ''){
                jsShowLoading();
                jQuery.post(ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'jsvehiclemanager', task: 'getlanguagetranslation',langname:lang_name , filename: file_name,wpnoncecheck:common.wp_vm_nonce}, function (data) {
                    if (data) {
                        jsHideLoading();
                        data = JSON.parse(data);
                        if(data['error']){
                            jQuery('#jsvm_js-emessage-wrapper div').html(data['error']);
                            jQuery('#jsvm_js-emessage-wrapper').show();
                        }else{
                            jQuery('#jsvm_js-emessage-wrapper').hide();
                            jQuery('#jsvm_js-emessage-wrapper_ok div').html(data['data']);
                            jQuery('#jsvm_js-emessage-wrapper_ok').slideDown();
                        }
                    }
                });
            }
        });
    });
    
    function jsShowLoading(){
        jQuery('div#jsvm_black_wrapper_translation').show();
        jQuery('div#jsvm_jstran_loading').show();
    }    

    function jsHideLoading(){
        jQuery('div#jsvm_black_wrapper_translation').hide();
        jQuery('div#jsvm_jstran_loading').hide();
    }
</script>
