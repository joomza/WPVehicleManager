<div id="jsvehiclemanager-main-up-wrapper">
<?php
$msgkey = JSVEHICLEMANAGERincluder::getJSModel('premiumplugin')->getMessagekey();
JSVEHICLEMANAGERmessages::getLayoutMessage($msgkey);
JSVEHICLEMANAGERbreadcrumbs::getBreadcrumbs();
include_once(JSVEHICLEMANAGER_PLUGIN_PATH . 'includes/header.php'); ?>
<div id="jsvehiclemanager-content">
	<?php
	$msg = __('Page not found....!','js-vehicle-manager');
    echo wp_kses(JSVEHICLEMANAGERlayout::getNoRecordFound($msg), JSVEHICLEMANAGER_ALLOWED_TAGS);
	?>
</div>
</div>
