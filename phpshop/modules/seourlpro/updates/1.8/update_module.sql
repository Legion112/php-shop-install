ALTER TABLE `phpshop_news` ADD `news_seo_name` VARCHAR(255) NOT NULL;
ALTER TABLE `phpshop_page_categories` ADD `page_cat_seo_name` VARCHAR(255) NOT NULL;
ALTER TABLE `phpshop_modules_seourlpro_system` ADD `seo_news_enabled` enum('1','2') NOT NULL default '2';
ALTER TABLE `phpshop_modules_seourlpro_system` ADD `seo_page_enabled` enum('1','2') NOT NULL default '2';
