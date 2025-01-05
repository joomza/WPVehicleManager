<?php if (!defined('ABSPATH')) die('Restricted Access');?>
<div id="jsvehiclemanageradmin-wrapper">
    <div id="jsvehiclemanageradmin-leftmenu">
        <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </div>
   <div id="jsvehiclemanageradmin-data">
        <span class="jsvm_js-admin-title">
            <span class="jsvm_heading">
                <a href="<?php echo esc_url(admin_url('admin.php?page=jsvehiclemanager')); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" /></a>
                <span class="jsvm_text-heading"><?php echo __('Information', 'js-vehicle-manager'); ?></span>
            </span>
            <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
        </span>
        <span class="jsvm_js-admin-component"><?php echo __('Component Details', 'js-vehicle-manager'); ?></span>
        <div class="jsvm_detail-part">
            <span class="jsvm_js-admin-component-detail">    </span>
            <div class="jsvm_js-admin-info-wrapper">
                <span class="jsvm_js-admin-info-title"><?php echo __('Created By', 'js-vehicle-manager'); ?></span>
                <span class="jsvm_js-admin-info-vlaue"><?php echo 'Ahmed Bilal'; ?></span>
            </div>
            <div class="jsvm_js-admin-info-wrapper">
                <span class="jsvm_js-admin-info-title"><?php echo __('Company', 'js-vehicle-manager'); ?></span>
                <span class="jsvm_js-admin-info-vlaue"><?php echo 'Joom Sky'; ?></span>
            </div>
            <div class="jsvm_js-admin-info-wrapper">
                <span class="jsvm_js-admin-info-title"><?php echo __('Plugins', 'js-vehicle-manager'); ?></span>
                <span class="jsvm_js-admin-info-vlaue"><?php echo 'WP Vehicle Manager'; ?></span>
            </div>
            <div class="jsvm_js-admin-info-wrapper">
                <span class="jsvm_js-admin-info-title"><?php echo __('Version', 'js-vehicle-manager'); ?></span>
                <span class="jsvm_js-admin-info-vlaue"><?php echo '1.0.6 -b'; ?></span>
            </div>
        </div>
        <div class="jsvm_js-admin-joomsky-wrapper ">
            <span class="jsvm_js-admin-title">
                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/about-us/logo.png" />
            </span>
            <span class="jsvm_detail-text">
                <span class="jsvm_detail-heading">
                    <?php echo 'About JoomSky'; ?>
                </span>
                <?php echo 'Our philosophy on project development is quite simple. We deliver exactly what you need to ensure the growth and effective running of your business. To do this we undertake a complete analysis of your business needs with you, then conduct thorough research and use our knowledge and expertise of software development programs to identify the products that are most beneficial to your business projects.'; ?>
                <span class="jsvm_js-joomsky-link">
                    <a href="http://www.joomsky.com" target="_blank">www.joomsky.com</a>
                </span>
            </span>
        </div>
    <div class="jsvm_products">
        <div class="jsvm_components" id="jsvm_jobs-free">
            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/about-us/joomla.png" />
            <span class="jsvm_component-text">
                <span class="jsvm_component-title">
                    <?php echo 'JS Jobs'; ?>
                </span>
                <span class="jsvm_component-type">
                    <?php echo 'Joomla'; ?>
                </span>
                <span class="jsvm_component-detail">
                    <?php echo 'JS Jobs for any business, industry body or staffing company wishing to establish a presence on the internet where job seekers can come to view the latest jobs and apply to them.JS Jobs allows you to run your own, unique jobs classifieds service where you or employer can advertise their jobs and jobseekers can upload their Resume'; ?>
                </span>
            </span>
            <span class="jsvm_info-urls">
                <a class="jsvm_pro" href="http://www.joomsky.com/products/js-jobs-pro.html">
                    <?php echo 'Pro Download'; ?>
                </a>
                <a class="jsvm_free" href="http://www.joomsky.com/products/js-jobs.html">
                    <?php echo 'Free Download'; ?>
                </a>
            </span>
        </div>
        <div class="jsvm_components" id="jsvm_autoz-pro">
            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/about-us/wordpress.png" />
            <span class="jsvm_component-text">
                <span class="jsvm_component-title">
                    <?php echo 'JS Jobs'; ?>
                </span>
                <span class="jsvm_component-type">
                    <?php echo 'WordPress'; ?>
                </span>
                <span class="jsvm_component-detail">
                    <?php echo 'JS Jobs for any business, industry body or staffing company wishing to establish a presence on the internet where job seekers can come to view the latest jobs and apply to them.JS Jobs allows you to run your own, unique jobs classifieds service where you or employer can advertise their jobs and jobseekers can upload their Resumes'; ?>
                </span>
            </span>
            <span class="jsvm_info-urls">
                <a class="jsvm_pro" href="http://www.joomsky.com/products/js-jobs-pro-wp.html">
                    <?php echo 'Pro Download'; ?>
                </a>
                <a class="jsvm_free" href="http://www.joomsky.com/products/js-jobs-wp.html">
                    <?php echo 'Free Download'; ?>
                </a>
            </span>
        </div>
        <div class="jsvm_components" id="jsvm_ticket-free">
            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/about-us/joomla.png" />
            <span class="jsvm_component-text">
                <span class="jsvm_component-title">
                    <?php echo 'JS Support Ticket'; ?>
                </span>
                <span class="jsvm_component-type">
                    <?php echo 'Joomla'; ?>
                </span>
                <span class="jsvm_component-detail">
                    <?php echo 'JS Support Ticket is a trusted open source ticket system. JS Support ticket is a simple, easy to use, web-based customer support system. User can create ticket from front-end. WP support ticket comes packed with lot features than most of the expensive(and complex) support ticket system on market.'; ?>
                </span>
            </span>
            <span class="jsvm_info-urls">
                <a class="jsvm_pro" href="https://www.joomsky.com/products/js-support-ticket-pro-joomla.html">
                    <?php echo 'Pro Download'; ?>
                </a>
                <a class="jsvm_free" href="http://www.joomsky.com/products/js-support-ticket-joomla.html">
                    <?php echo 'Free Download'; ?>
                </a>
            </span>
        </div>
        <div class="jsvm_components" id="jsvm_autoz-free">
            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/about-us/wordpress.png" />
            <span class="jsvm_component-text">
                <span class="jsvm_component-title">
                    <?php echo 'JS Support Ticket'; ?>
                </span>
                <span class="jsvm_component-type">
                    <?php echo 'WordPress'; ?>
                </span>
                <span class="jsvm_component-detail">
                    <?php echo 'JS Support Ticket is a trusted open source ticket system. JS Support ticket is a simple, easy to use, web-based customer support system. User can create ticket from front-end. WP support ticket comes packed with lot features than most of the expensive(and complex) support ticket system on market.'; ?>
                </span>
            </span>
            <span class="jsvm_info-urls">
                <a class="jsvm_pro" href="http://www.joomsky.com/products/js-support-ticket-pro-wp.html">
                    <?php echo 'Pro Download'; ?>
                </a>
                <a class="jsvm_free" href="http://www.joomsky.com/products/js-support-ticket-wp.html">
                    <?php echo 'Free Download'; ?>
                </a>
            </span>
        </div>
        <div class="jsvm_components" id="jsvm_ticket-pro">
            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/about-us/joomla.png" />
            <span class="jsvm_component-text">
                <span class="jsvm_component-title">
                    <?php echo 'JS Autoz'; ?>
                </span>
                <span class="jsvm_component-type">
                    <?php echo 'Joomla'; ?>
                </span>
                <span class="jsvm_component-detail">
                    <?php echo 'JS Autoz is robust and powerful vehicles show room component for Joomla. WP Autoz help you build online show room with clicks. With admin power you can easily manage makes, models, types etc. in admin area.'; ?>
                </span>    
            </span>
            <span class="jsvm_info-urls">
                <a class="jsvm_pro" href="http://www.joomsky.com/products/js-autoz-pro.html">
                    <?php echo 'Pro Download'; ?>
                </a>
                <a class="jsvm_free" href="http://www.joomsky.com/products/js-autoz.html">
                    <?php echo 'Free Download'; ?>
                </a>
            </span>
        </div>
        <?php /*
        <div class="jsvm_components" id="jsvm_ticket-pro">
            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/about-us/wordpress.png" />
            <span class="jsvm_component-text">
                <span class="jsvm_component-title">
                    <?php echo 'WP Vehicle Manager'; ?>
                </span>    
                <span class="jsvm_component-type">
                    <?php echo 'WordPress'; ?>
                </span>    
                <span class="jsvm_component-detail">
                    <?php echo 'WP Vehicle Manager is robust and powerful vehicles show room component for Joomla. WP Autoz help you build online show room with clicks. With admin power you can easily manage makes, models, types etc. in admin area.'; ?>
                </span>    
            </span>
            <span class="jsvm_info-urls">
                <a class="jsvm_pro" href="http://www.joomsky.com/products/js-autoz-pro.html">
                    <?php echo 'Pro Download'; ?>
                </a>
                <a class="jsvm_free" href="http://www.joomsky.com/products/js-autoz.html">
                    <?php echo 'Free Download'; ?>
                </a>
            </span>
        </div>
        */ ?>
    </div>
    </div>
</div>
