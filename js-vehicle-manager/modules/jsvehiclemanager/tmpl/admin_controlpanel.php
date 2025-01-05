<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
wp_enqueue_script('jsvm-res-tables', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/js/responsivetable.js');
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
do_action('admin_enqueue_scripts');
?>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.setOnLoadCallback(drawStackChartHorizontal);
    function drawStackChartHorizontal() {
        var data = google.visualization.arrayToDataTable([
            <?php
                echo wp_kses_post(jsvehiclemanager::$_data['stack_chart_horizontal']['title']) . ',';
                echo wp_kses_post(jsvehiclemanager::$_data['stack_chart_horizontal']['data']);
            ?>
        ]);
        var view = new google.visualization.DataView(data);
        var options = {
        curveType: 'function',
                height:300,
                legend: { position: 'top', maxLines: 3 },
                pointSize: 4,
                isStacked: true,
                focusTarget: 'category',
                chartArea: {width:'90%', top:50}
        };
        var chart = new google.visualization.LineChart(document.getElementById("stack_chart_horizontal"));
        chart.draw(view, options);
    }
</script>
<div id="jsvehiclemanageradmin-wrapper">
    <div id="jsvehiclemanageradmin-leftmenu">
        <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </div>
    <div id="jsvehiclemanageradmin-data">
        <div class="jsvm_dashboard">
            <span class="jsvm_heading-dashboard"><?php echo __('Dashboard', 'js-vehicle-manager'); ?></span>
            <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
        </div>
        <div id="jsvehiclemanager-admin-wrapper">
            <div class="jsvm_count1">
                <div class="jsvm_box">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/total.png">
                    <div class="jsvm_text">
                        <div class="jsvm_bold-text"><?php echo esc_html(jsvehiclemanager::$_data['totalvehicles']); ?></div>
                        <div class="jsvm_nonbold-text"><?php echo __('Total vehicles', 'js-vehicle-manager'); ?></div>
                    </div>
                </div>
                <div class="jsvm_box">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/active.png">
                    <div class="jsvm_text">
                        <div class="jsvm_bold-text"><?php echo esc_html(jsvehiclemanager::$_data['activevehicles']); ?></div>
                        <div class="jsvm_nonbold-text"><?php echo __('Active vehicles', 'js-vehicle-manager'); ?></div>
                    </div>
                </div>
                <div class="jsvm_box">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/expired.png">
                    <div class="jsvm_text">
                        <div class="jsvm_bold-text"><?php echo esc_html(jsvehiclemanager::$_data['expiredvehicles']); ?></div>
                        <div class="jsvm_nonbold-text"><?php echo __('Expired vehicles', 'js-vehicle-manager'); ?></div>
                    </div>
                </div>
            </div>
            <div class="jsvm_newestjobs">
                <span class="jsvm_header">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/newesticon.png">
                    <span><?php echo __('Statistics', 'js-vehicle-manager'); ?> (<?php echo esc_html(jsvehiclemanager::$_data['fromdate']); ?> - <?php echo esc_html(jsvehiclemanager::$_data['curdate']); ?>) </span>
                </span>
                <div class="performance-graph" id="stack_chart_horizontal"></div>
            </div>
            <div class="jsvm_main-heading">
                <span class="jsvm_text"><?php echo __('Admin', 'js-vehicle-manager'); ?></span>
            </div>
            <div class="jsvm_box-wrapper">
                <a href="admin.php?page=jsvm_vehicle" class="jsvm_box">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/vehicles.png" />
                    <div class="jsvm_text">
                        <?php echo __('Vehicles', 'js-vehicle-manager') ?>
                    </div>
                </a>
                <a href="admin.php?page=jsvm_vehicle&jsvmlt=vehiclequeue" class="jsvm_box">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/queue.png" />
                    <div class="jsvm_text">
                        <?php echo __('Approval Queue', 'js-vehicle-manager') ?>
                    </div>
                </a>
                <a href="admin.php?page=jsvm_fieldordering&ff=1" class="jsvm_box">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/fields.png" />
                    <div class="jsvm_text">
                        <?php echo __('Vehicle Fields', 'js-vehicle-manager') ?>
                    </div>
                </a>
                <?php do_action('jsvm_addons_admin_cp_links_for_credit',1); // 1 for defining position to place icon on admin cp ?>
                <a href="admin.php?page=jsvm_vehicletype" class="jsvm_box">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/types.png">
                    <div class="jsvm_text">
                        <?php echo __('Vehicle types', 'js-vehicle-manager'); ?>
                    </div>
                </a>
                <a href="admin.php?page=jsvehiclemanager&jsvmlt=information" class="jsvm_box">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/information.png">
                    <div class="jsvm_text">
                        <?php echo __('Information', 'js-vehicle-manager'); ?>
                    </div>
                </a>
                <a href="admin.php?page=jsvm_systemerror&jsvmlt=systemerrors" class="jsvm_box">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/system-error.png">
                    <div class="jsvm_text">
                        <?php echo __('System Errors', 'js-vehicle-manager'); ?>
                    </div>
                </a>
                <a href="admin.php?page=jsvehiclemanager&jsvmlt=translations" class="jsvm_box">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/language.png">
                    <div class="jsvm_text">
                        <?php echo __('Translations', 'js-vehicle-manager'); ?>
                    </div>
                </a>

                <?php do_action('jsvm_addons_admin_cp_links_for_export'); ?>
            </div>
            <div class="jsvm_main-heading">
                <span class="jsvm_text"><?php echo __('Configuration', 'js-vehicle-manager'); ?></span>
            </div>
            <div class="jsvm_box-wrapper">
                <a href="admin.php?page=jsvm_configuration&jsvmlt=configurations" class="jsvm_box">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/configuration.png">
                    <div class="jsvm_text">
                        <?php echo __('Configuration', 'js-vehicle-manager') ?>
                    </div>
                </a>
                <?php do_action('jsvm_addons_admin_cp_links_for_credit',2) ?>
                <?php do_action('jsvm_addons_admin_cp_links_for_theme') ?>
            </div>
            <div class="jsvm_newest-vehicles-portion">
                <div class="jsvm_newest-vehicles-portion-header">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/newesticon.png">
                    <?php echo __('Newest Vehicles','js-vehicle-manager'); ?>
                </div>
                <div class="jsvm_vehicles-portion">
                    <?php foreach (jsvehiclemanager::$_data['newest'] as $vehicle) { ?>
                    <div class="jsvm_vechile-wrapper">
                        <div class="jsvm_left-img">
                            <?php
                                if($vehicle->filename != '') {
                                $imagesrc = JSVEHICLEMANAGERIncluder::getJSModel('vehicle')->getVehicleImageByPath($vehicle->file,$vehicle->filename,'ms');
                                ?>
                                <img src="<?php echo esc_attr($imagesrc); ?>" />
                            <?php }else{ ?>
                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/default-car-3.png" />
                            <?php } ?>
                        </div>
                        <div class="jsvm_right-top">
                            <?php
                            if ($vehicle->title != '')
                                $titlevar = $vehicle->title;
                            else
                                $titlevar = $vehicle->maketitle . ' ' . $vehicle->modeltitle. ' - ' .$vehicle->modelyeartitle;
                            ?>
                            <a href="<?php echo esc_url(admin_url('admin.php?page=jsvm_vehicle&jsvmlt=formvehicle&jsvehiclemanagerid='.$vehicle->id.' ')); ?>"> <?php echo esc_html($titlevar); ?> </a>
                            <div class="jsvm_veh-price">
                                <?php echo wp_kses(JSVEHICLEMANAGERincluder::getJSModel('common')->getPrice($vehicle->price,$vehicle->currency, $vehicle->isdiscount, $vehicle->discounttype, $vehicle->discount, $vehicle->discountstart, $vehicle->discountend), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                            </div>
                        </div>
                        <div class="jsvm_right-bottom">
                            <div class="jsvm_left-part">
                                <div class="jsvm_detail">
                                    <div class="jsvm_js_autoz_tag" style="color:<?php echo esc_attr($vehicle->conditioncolor); ?>;border: 1px solid <?php echo esc_attr($vehicle->conditioncolor); ?>;"><?php echo esc_html(__($vehicle->conditiontitle,'js-vehicle-manager')); ?><div class="jsvm_arrow_left"></div></div>
                                </div>
                                <?php if($vehicle->transmission != ''){ ?>
                                <div class="jsvm_detail">
                                    <?php echo '  -'.esc_html(__($vehicle->transmission,'js-vehicle-manager')); ?>
                                </div>
                                <?php } if($vehicle->fueltitle != ''){ ?>
                                <div class="jsvm_detail">
                                    <?php echo '  -'.esc_html(__($vehicle->transmission,'js-vehicle-manager')); ?>
                                    <?php echo '  -'.esc_html(__($vehicle->fueltitle,'js-vehicle-manager')); ?>
                                </div>
                                <?php } if($vehicle->mileage){ ?>
                                <div class="jsvm_detail">
                                    <?php if ($vehicle->mileage) echo '  -'.esc_html(__($vehicle->mileage,'js-vehicle-manager')) . '/' . $vehicle->mileagesymbol; ?>
                                </div>
                                <?php } if($vehicle->enginecapacity != ''){ ?>
                                <div class="jsvm_detail">
                                    <?php echo '  -'.esc_html($vehicle->enginecapacity); ?>
                                </div>
                                <?php } ?>
                                <?php
                                $comma = ", ";
                                if ($vehicle->cityname != '') {
                                    echo '  -'.esc_html(__($vehicle->cityname,'js-vehicle-manager')) . $comma;
                                }
                                if ($vehicle->statename != '') {
                                    echo esc_html(__($vehicle->statename,'js-vehicle-manager')) . $comma;
                                }
                                if ($vehicle->countryname != '') {
                                    echo esc_html(__($vehicle->countryname,'js-vehicle-manager'));
                                } ?>
                            </div>

                            <?php if($vehicle->status == 1){ ?>
                                <div class="jsvm_veh-approved">
                                    <?php echo __('Approved','js-vehicle-manager'); ?>
                                </div>
                            <?php }elseif($vehicle->status == -1){ ?>
                                <div class="jsvm_veh-Rejected">
                                    <?php echo __('Rejected','js-vehicle-manager'); ?>
                                </div>
                            <?php }elseif($vehicle->status == 0){ ?>
                                <div class="jsvm_veh-pending">
                                    <?php echo __('Pending','js-vehicle-manager'); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="jsvm_main-heading">
                <span class="jsvm_text"><?php echo __('Misc', 'js-vehicle-manager'); ?></span>
            </div>
            <div class="jsvm_box-wrapper">
                <a href="admin.php?page=jsvm_emailtemplate" class="jsvm_box">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/email-temp.png">
                    <div class="jsvm_text">
                        <?php echo __('Email template', 'js-vehicle-manager') ?>
                    </div>
                </a>
                <a href="admin.php?page=jsvm_user" class="jsvm_box">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/users.png">
                    <div class="jsvm_text">
                        <?php echo __('Users', 'js-vehicle-manager') ?>
                    </div>
                </a>
                <a href="admin.php?page=jsvm_fueltypes" class="jsvm_box">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/fuel-type.png">
                    <div class="jsvm_text">
                        <?php echo __('Fuel types', 'js-vehicle-manager') ?>
                    </div>
                </a>
                <a href="admin.php?page=jsvm_mileages" class="jsvm_box">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/mileages.png">
                    <div class="jsvm_text">
                        <?php echo __('Mileages', 'js-vehicle-manager') ?>
                    </div>
                </a>
                <a href="admin.php?page=jsvm_modelyears" class="jsvm_box">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/modelyear.png" />
                    <div class="jsvm_text">
                        <?php echo __('Model years', 'js-vehicle-manager') ?>
                    </div>
                </a>
                <a href="admin.php?page=jsvm_transmissions" class="jsvm_box">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/transmissions.png" />
                    <div class="jsvm_text">
                        <?php echo __('Transmissions', 'js-vehicle-manager') ?>
                    </div>
                </a>
                <a href="admin.php?page=jsvm_currency" class="jsvm_box">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/currency.png" />
                    <div class="jsvm_text">
                        <?php echo __('Currencies', 'js-vehicle-manager') ?>
                    </div>
                </a>
                <a href="admin.php?page=jsvm_conditions" class="jsvm_box">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/conditions.png" />
                    <div class="jsvm_text">
                        <?php echo __('Conditions', 'js-vehicle-manager') ?>
                    </div>
                </a>
                <a href="admin.php?page=jsvm_adexpiry" class="jsvm_box">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/add-expiry.png" />
                    <div class="jsvm_text">
                        <?php echo __('Ad Expiry', 'js-vehicle-manager') ?>
                    </div>
                </a>
            </div>
            <?php do_action('jsvm_addons_admin_cp_links_for_reports'); ?>
            <div class="jsvm_main-heading">
                <span class="jsvm_text"><?php echo __('Support', 'js-vehicle-manager'); ?></span>
            </div>
            <div class="jsvm_box-wrapper">
                <a href="admin.php?page=jsvehiclemanager&jsvmlt=shortcodes" class="jsvm_box">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/shortcodes.png" />
                    <div class="jsvm_text">
                        <?php echo __('Shortcodes', 'js-vehicle-manager') ?>
                    </div>
                </a>
                <a href="https://www.wpvehiclemanager.com/support/support-ticket.html" class="jsvm_box">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/support.png" />
                    <div class="jsvm_text">
                        <?php echo __('Support', 'js-vehicle-manager') ?>
                    </div>
                </a>
                <a href="http://docs.joomsky.com/jscarmanager.html" class="jsvm_box">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/documentation.png" />
                    <div class="jsvm_text">
                        <?php echo __('Documentation', 'js-vehicle-manager') ?>
                    </div>
                </a>
                <a href="http://www.joomshark.com/forum/js-vehicle-manager.html" class="jsvm_box">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/cp/forum.png" />
                    <div class="jsvm_text">
                        <?php echo __('Forum', 'js-vehicle-manager') ?>
                    </div>
                </a>
            </div>
            <div class="jsvm_review">
                <div class="jsvm_upper">
                    <div class="jsvm_imgs">
                        <img class="jsvm_reviewpic" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/review.png">
                        <img class="jsvm_reviewpic2" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/corner-1.png">
                    </div>
                    <div class="jsvm_text">
                        <div class="jsvm_simple-text">
                            <span class="jsvm_nobold"><?php echo __('We\'d love to hear from ', 'js-vehicle-manager'); ?></span>
                            <span class="jsvm_bold"><?php echo __('You', 'js-vehicle-manager'); ?>.</span>
                            <span class="jsvm_nobold"><?php echo __('Please write appreciated review at', 'js-vehicle-manager'); ?></span>
                        </div>
                        <a href="https://wordpress.org/support/view/plugin-reviews/js-vehicle-manager" target="_blank"><?php echo __('Word Press Extension Directory', 'js-vehicle-manager'); ?><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/arrow2.png"></a>
                    </div>
                    <div class="jsvm_right">
                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/star.png">
                    </div>
                </div>
                <div class="jsvm_lower">
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery("span.jsvm_dashboard-icon").find('span.download').hover(function(){
            jQuery(this).find('span').toggle("slide");
        }, function(){
            jQuery(this).find('span').toggle("slide");
        });
    });
</script>
