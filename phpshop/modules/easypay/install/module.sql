DROP TABLE IF EXISTS `phpshop_modules_easypay_system`;CREATE TABLE IF NOT EXISTS `phpshop_modules_easypay_system` (  `id` int(11) NOT NULL auto_increment,  `status` int(11) NOT NULL,  `title` varchar(64) NOT NULL default '',  `web_key` varchar(64) NOT NULL default '',  `EP_Debug` int(11) NOT NULL default 0,  `EP_MerNo` varchar(64) NOT NULL default '',  `EP_Expires` varchar(64) NOT NULL default '',  `version` FLOAT(2) DEFAULT '1.0' NOT NULL,  PRIMARY KEY  (`id`)) ENGINE=MyISAM DEFAULT CHARSET=cp1251;INSERT INTO `phpshop_modules_easypay_system` VALUES (1,0,'Платежная система Easypay','',0,'','','1.0');INSERT INTO `phpshop_payment_systems` (`id`, `name`, `path`, `enabled`, `num`, `message`, `message_header`, `yur_data_flag`, `icon`) VALUES(10002, 'Easypay', 'modules', '0', 0, '', '', '', '/UserFiles/Image/Payments/visa.png');