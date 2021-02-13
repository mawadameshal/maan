ALTER TABLE `forms` CHANGE `old_category` `old_category_id` INT(11) NULL DEFAULT NULL;


ALTER TABLE `forms`
ADD `user_change_category_id` INT(11) NULL DEFAULT NULL AFTER `reprocessing`,
ADD `user_change_content_id` INT(11) NULL DEFAULT NULL AFTER `user_change_category`;





INSERT INTO `links` (`id`, `title`, `url`, `icon`, `show_menu`, `parent_id`, `created_at`, `updated_at`) VALUES (NULL, 'الإجازات', '', 'icon-diamond', '1', '0', NULL, NULL);
INSERT INTO `links` (`id`, `title`, `url`, `icon`, `show_menu`, `parent_id`, `created_at`, `updated_at`) VALUES (NULL, 'إدارة الإجازات', '/account/account', '', '1', '52', NULL, NULL);
UPDATE `links` SET `url` = '/account/events', `created_at` = NULL, `updated_at` = NULL WHERE `links`.`id` = 53;
