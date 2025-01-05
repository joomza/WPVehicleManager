<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
wp_enqueue_script('jquery-ui-tabs');
?>

<div id="jsvehiclemanageradmin-wrapper">
    <div id="jsvehiclemanageradmin-leftmenu">
        <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </div>
    <div id="jsvehiclemanageradmin-data">
    <span class="jsvm_js-admin-title">
        <a href="<?php echo esc_url(admin_url('admin.php?page=jsvehiclemanager')); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" /></a>
        <?php echo __('Cron Job', 'js-vehicle-manager'); ?>
    </span>
    <div id="jsvm_tabs" class="jsvm_tabs">
        <ul>
            <li><a  href="#jsvm_webcrown"><?php echo __('Webcrown.org', 'js-vehicle-manager'); ?></a></li>
            <li><a href="#jsvm_wget"><?php echo __('Wget', 'js-vehicle-manager'); ?></a> </li>
            <li><a href="#jsvm_curl"><?php echo __('Curl', 'js-vehicle-manager'); ?></a></li>
            <li><a href="#jsvm_phpscript"><?php echo __('Php Script', 'js-vehicle-manager'); ?></a></li>
            <li><a href="#jsvm_url"><?php echo __('Website', 'js-vehicle-manager'); ?></a></li>
        </ul>
        <?php
        $array = array('even', 'odd');
        $k = 0;
        ?>
        <div id="jsvm_cron_info_area"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/info-icon.png"> <?php echo __("Recommended run script once a day","js-vehicle-manager").' !'; ?></div>
        <div class="jsvm_tabInner">
            <div id="jsvm_webcrown">
                <div class="jsvm_cron_main_heading"><?php echo __('Configuration Of A Backup Job With', 'js-vehicle-manager').'Webcron.org'; ?></div>
                <div id="jsvm_cron_job_detail_wrapper" class="<?php echo esc_attr($array[$k]);$k = 1 - $k; ?>">
                    <span class="jsvm_crown_text_left">
                        <?php echo __('Name Of Cron Job', 'js-vehicle-manager'); ?>
                    </span>
                    <span class="jsvm_crown_text_right"><?php echo __('Log In To','js-vehicle-manager'). ' Webcron.org. '. __('In The Cron Area','js-vehicle-manager').', '.__('Click On The New Cron Button','js-vehicle-manager').'. '.__('Below You will Find What You Have To Enter At','js-vehicle-manager').' Webcron.orgs'. __('Interface', 'js-vehicle-manager'); ?></span>
                </div>
                <div id="jsvm_cron_job_detail_wrapper" class="<?php echo esc_attr($array[$k]);$k = 1 - $k; ?>">
                    <span class="jsvm_crown_text_left">
                        <?php echo __('Timeout', 'js-vehicle-manager'); ?>
                    </span>
                    <span class="jsvm_crown_text_right"><?php echo __('180 sec If The Backup Does Not Complete','js-vehicle-manager').', '.__('Increase It','js-vehicle-manager').'. '.__('Most Sites Will Work With A Setting Of 180 Or 600 Here','js-vehicle-manager').'. '.__('If You Have A Very Big Site Which Takes More Than 5 Minutes To Back Itself Up','js-vehicle-manager').', '.__('You Might Consider Using Akeeba Backup Professional And The Native Cli Cron Job Instead','js-vehicle-manager').', '.__('As Its Much More Cost-effective.', 'js-vehicle-manager'); ?></span>
                </div>
                <div id="jsvm_cron_job_detail_wrapper" class="<?php echo esc_attr($array[$k]);$k = 1 - $k; ?>">
                    <span class="jsvm_crown_text_left"><?php echo __('Url You Want To Execute', 'js-vehicle-manager'); ?></span>
                    <span class="jsvm_crown_text_right">
                     <?php echo esc_url(wp_nonce_url(admin_url("admin.php?page=jsvm_vehiclealert&action=jsvmtask&task=sendvehiclealert&ck=" . jsvehiclemanager::$_data[0]['ck']),'send-alert')); ?>
                    </span>
                </div>
                <div id="jsvm_cron_job_detail_wrapper" class="<?php echo esc_attr($array[$k]);$k = 1 - $k; ?>">
                    <span class="jsvm_crown_text_left"><?php echo __('Login', 'js-vehicle-manager'); ?></span>
                    <span class="jsvm_crown_text_right">
                     <?php echo __('Leave This Blank', 'js-vehicle-manager'); ?>
                    </span>
                </div>
                <div id="jsvm_cron_job_detail_wrapper" class="<?php echo esc_attr($array[$k]);$k = 1 - $k; ?>">
                    <span class="jsvm_crown_text_left"><?php echo __('Password', 'js-vehicle-manager'); ?></span>
                    <span class="jsvm_crown_text_right"><?php echo __('Leave This Blank', 'js-vehicle-manager'); ?></span>
                </div>
                <div id="jsvm_cron_job_detail_wrapper" class="<?php echo esc_attr($array[$k]);$k = 1 - $k; ?>">
                    <span class="jsvm_crown_text_left">
                     <?php echo __('Execution Time', 'js-vehicle-manager'); ?>
                    </span>
                    <span class="jsvm_crown_text_right">
                        <?php echo __('Thats The Grid Below The Other Options','js-vehicle-manager').'. '.__('Select When And How Often You Want Your Cron Job To Run.', 'js-vehicle-manager'); ?>
                    </span>
                </div>
                <div id="jsvm_cron_job_detail_wrapper" class="<?php echo esc_attr($array[$k]);$k = 1 - $k; ?>">
                    <span class="jsvm_crown_text_left"><?php echo __('Alerts', 'js-vehicle-manager'); ?></span>
                    <span class="jsvm_crown_text_right">
                        <?php echo __('If You Have Already Set Up Alert Methods In','js-vehicle-manager').' Webcron.orgs'. __('Interface','js-vehicle-manager').', '.__('We Recommend Choosing An Alert Method Here And Not Checking The only On Error So That You Always Get A Notification When The Backup Cron Job Runs','js-vehicle-manager').'. '.__('Finally Click On The Submit Button To Finish Setting Up Your Cron Job.', 'js-vehicle-manager'); ?>
                    </span>
                </div>
            </div>
            <div id="jsvm_wget">
                <div id="jsvm_cron_job">
                    <div class="jsvm_cron_main_heading"><?php echo __('Cron Scheduling Using Wget most Hosts', 'js-vehicle-manager'); ?></div>
                    <div id="jsvm_cron_job_detail_wrapper" class="even">
                        <span class="jsvm_crown_text_right fullwidth">
                            <?php echo 'wget --max-redirect=10000 "' . esc_url(wp_nonce_url(admin_url("admin.php?page=jsvm_vehiclealert&action=jsvmtask&task=sendvehiclealert&ck=" . jsvehiclemanager::$_data[0]['ck'] . '" -O - 1>/dev/null 2>/dev/null '),'send-alert')); ?>
                        </span>
                    </div>
                </div>  
            </div>
            <div id="jsvm_curl">
                <div id="jsvm_cron_job">
                    <div class="jsvm_cron_main_heading"><?php echo __('Cron Scheduling Using Curl siteground And A Few Other Hosts', 'js-vehicle-manager'); ?></div>
                    <div id="jsvm_cron_job_detail_wrapper" class="even">
                        <span class="jsvm_crown_text_right fullwidth">
                            <?php echo 'curl "' . esc_url(wp_nonce_url(admin_url("admin.php?page=jsvm_vehiclealert&action=jsvmtask&task=sendvehiclealert&ck=" . jsvehiclemanager::$_data[0]['ck']),'send-alert') . '"<br>' . __('Or', 'js-vehicle-manager')) . '<br>'; ?>
                            <?php echo 'curl -L --max-redirs 1000 -v "' . esc_url(wp_nonce_url(admin_url("admin.php?page=jsvm_vehiclealert&action=jsvmtask&task=sendvehiclealert&ck=" . jsvehiclemanager::$_data[0]['ck'] . '" 1>/dev/null 2>/dev/null'),'send-alert')); ?>
                        </span>
                    </div>
                </div>  
            </div>
            <div id="jsvm_phpscript">
                <div id="jsvm_cron_job">
                    <div class="jsvm_cron_main_heading"><?php echo __('Custom Php Script To Run', 'js-vehicle-manager'); ?></div>

                    <div id="jsvm_cron_job_detail_wrapper" class="even">
                        <span class="jsvm_crown_text_right fullwidth">
                            <?php
                            echo '  $curl_handle=curl_init();<br>
                                    curl_setopt($curl_handle, CURLOPT_URL, \'' . esc_url(wp_nonce_url(admin_url("admin.php?page=jsvm_vehiclealert&action=jsvmtask&task=sendvehiclealert&ck=" . jsvehiclemanager::$_data[0]['ck']),'send-alert')) . '\');<br>
                                    curl_setopt($curl_handle,CURLOPT_FOLLOWLOCATION, TRUE);<br>
                                    curl_setopt($curl_handle,CURLOPT_MAXREDIRS, 10000);<br>
                                    curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER, 1);<br>
                                    $buffer = curl_exec($curl_handle);<br>
                                    curl_close($curl_handle);<br>
                                    if (empty($buffer))<br>
                                      echo "' . __('Sorry','js-vehicle-manager').', '.__('    The Backup Did Not Work.', 'js-vehicle-manager') . '";<br>
                                    else<br>
                                      echo $buffer;<br>
                                    ';
                            ?>
                        </span>
                    </div>
                </div>  
            </div>
            <div id="jsvm_url">
                <div id="jsvm_cron_job">
                    <div class="jsvm_cron_main_heading"><?php echo __('Url For Use With Your Own Scripts And Third Party Services', 'js-vehicle-manager'); ?></div>
                    <div id="jsvm_cron_job_detail_wrapper" class="even">
                        <span class="jsvm_crown_text_right fullwidth"><?php echo esc_url(wp_nonce_url(admin_url("admin.php?page=jsvm_vehiclealert&action=jsvmtask&task=sendvehiclealert&ck=" . jsvehiclemanager::$_data[0]['ck']),'send-alert')); ?></span>
                    </div>
                </div>  
            </div>
        </div>
    </div>  
</div>
<script>
    jQuery(document).ready(function () {
        jQuery("#jsvm_tabs").tabs();
    });
</script>
