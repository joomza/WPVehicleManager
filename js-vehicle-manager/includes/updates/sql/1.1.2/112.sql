ALTER TABLE `#__js_vehiclemanager_config` ADD `addon` VARCHAR(100) NOT NULL AFTER `configfor`;
UPDATE `#__js_vehiclemanager_config` SET `addon` = 'adsense' WHERE `configname` IN ('googleadsenseshowafter','googleadsenseshowinlistvehicle','googleadsenseclient','googleadsenseslot','googleadsenseheight','googleadsensewidth','googleadsensecustomcss');
UPDATE `#__js_vehiclemanager_config` SET `addon` = 'buyercontacttoseller' WHERE `configname` IN ('vehicle_buyercontactseller','cm_buyer_can_contact_seller');
UPDATE `#__js_vehiclemanager_config` SET `addon` = 'comparevehicle' WHERE `configname` IN ('dashboard_compare','vis_dashboard_compare');
UPDATE `#__js_vehiclemanager_config` SET `addon` = 'credits' WHERE `configname` IN ('free_credits_purchased_only_once','auto_assign_free_package','free_package_purchase_only_once','free_package_auto_approve','dashboard_package','dashboard_ratelist','dashboard_creditslog','dashboard_purchasehistory','vis_dashboard_package','vis_dashboard_ratelist','vis_dashboard_creditslog','vis_dashboard_purchasehistory');
UPDATE `#__js_vehiclemanager_config` SET `addon` = 'featuredvehicle' WHERE `configname` IN ('maximum_feature_vehicle_in_listing','show_featured_vehicles_in_vehicles_listing','featuredvehicle_autoapprove','no_of_featured_vehicles_in_vehicle_listing');
UPDATE `#__js_vehiclemanager_config` SET `addon` = 'financeplan' WHERE `configname` IN ('vehicledetail_finance_calculator','interestrate','recaptcha_makeanoffer','vehicledetail_makeanoffer');
UPDATE `#__js_vehiclemanager_config` SET `addon` = 'markassold' WHERE `configname` IN ('show_sold_vehicle','show_sold_vehicles');
UPDATE `#__js_vehiclemanager_config` SET `addon` = 'pdf' WHERE `configname` IN ('vehicledetail_pdf');
UPDATE `#__js_vehiclemanager_config` SET `addon` = 'print' WHERE `configname` IN ('vehicledetail_print');
UPDATE `#__js_vehiclemanager_config` SET `addon` = 'shortlist' WHERE `configname` IN ('dashboard_shortlistvehicles','vis_dashboard_shortlistvehicles','topmenu_shortlistvehicles','vis_topmenu_shortlistvehicles','vehiclelist_shortlist','vehicledetail_shortlist');
UPDATE `#__js_vehiclemanager_config` SET `addon` = 'sociallogin' WHERE `configname` IN ('apikeylinkedin','clientsecretlinkedin','apikeyxing','clientsecretxing','loginwithfacebook','loginwithlinkedin','loginwithxing','apikeyfacebook','clientsecretfacebook');
UPDATE `#__js_vehiclemanager_config` SET `addon` = 'socialsharing' WHERE `configname` IN ('tumbler_share','fb_like','fb_comments','google_like','fb_share','google_share','blogger_share','instgram_share','linkedin','digg_share','twitter_share','pintrest_share','yahoo_share');
UPDATE `#__js_vehiclemanager_config` SET `addon` = 'tellafriend' WHERE `configname` IN ('tell_a_friend','recaptcha_tellafriend','vehiclelist_tellafriend','vehicledetail_tellafriend','recaptcha_scheduletestdrive','vehicledetail_scheduletestdrive');
UPDATE `#__js_vehiclemanager_config` SET `addon` = 'vehiclealert' WHERE `configname` IN ('visitor_can_vehicle_alert','vechicle_alerts_allowed_per_user','vehicle_alert_popup_delay','vehicle_alert_button_or_popup','dashboard_vehiclealert','vis_dashboard_vehiclealert');
UPDATE `#__js_vehiclemanager_config` SET `addon` = 'vehiclerss' WHERE `configname` IN ('vehicle_rss','rss_vehicle_title','rss_vehicle_ttl','rss_vehicle_description','rss_vehicle_copyright','rss_vehicle_webmaster','rss_vehicle_editor','rss_vehicle_image','rss_vehicle_categories','dashboard_vehiclerss','vis_dashboard_vehiclerss');
UPDATE `#__js_vehiclemanager_config` SET `addon` = 'visitoraddvehicle' WHERE `configname` IN ('visitor_can_edit_vehicle','visitor_add_vehicle_redirect_page','visitor_can_add_vehicle','vis_dashboard_addVehicle','vis_topmenu_addVehicle');

REPLACE INTO `#__js_vehiclemanager_config` (`configname`, `configvalue`, `configfor`) VALUES ('productversion', '112', 'default');
