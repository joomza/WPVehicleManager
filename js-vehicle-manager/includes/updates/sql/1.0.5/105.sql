ALTER TABLE `#__js_vehiclemanager_fieldsordering` ADD `search_ordering` INT NOT NULL DEFAULT '0' AFTER `cannotsearch`;
UPDATE `#__js_vehiclemanager_fieldsordering` SET `search_ordering` = `ordering` WHERE `cannotsearch` = 0
INSERT INTO `#__js_vehiclemanager_config` (`configname`, `configvalue`, `configfor`) VALUES ('show_total_number_of_vehicles', '1', 'vehicle');

REPLACE INTO `#__js_vehiclemanager_config` (`configname`, `configvalue`, `configfor`) VALUES ('productversion', '105', 'default');
