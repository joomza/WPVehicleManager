REPLACE INTO `#__js_vehiclemanager_config` (`configname`, `configvalue`, `configfor`) VALUES ('productversion', '117', 'default');
CREATE TABLE IF NOT EXISTS `#__js_vehiclemanager_jsvmsessiondata` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `usersessionid` char(64) NOT NULL,
  `sessionmsg` text CHARACTER SET utf8 NOT NULL,
  `sessionexpire` bigint(32) NOT NULL,
  `sessionfor` varchar(125) NOT NULL,
  `msgkey`varchar(125) NOT NULL  
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
