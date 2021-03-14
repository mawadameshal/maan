ALTER TABLE `forms` CHANGE `old_category` `old_category_id` INT(11) NULL DEFAULT NULL;


ALTER TABLE `forms`
ADD `user_change_category_id` INT(11) NULL DEFAULT NULL AFTER `reprocessing`,
ADD `user_change_content_id` INT(11) NULL DEFAULT NULL AFTER `user_change_category`;





INSERT INTO `links` (`id`, `title`, `url`, `icon`, `show_menu`, `parent_id`, `created_at`, `updated_at`) VALUES (NULL, 'الإجازات', '', 'icon-diamond', '1', '0', NULL, NULL);
INSERT INTO `links` (`id`, `title`, `url`, `icon`, `show_menu`, `parent_id`, `created_at`, `updated_at`) VALUES (NULL, 'إدارة الإجازات', '/account/account', '', '1', '52', NULL, NULL);
UPDATE `links` SET `url` = '/account/events', `created_at` = NULL, `updated_at` = NULL WHERE `links`.`id` = 53;

UPDATE `links` SET `parent_id` = '6' WHERE `links`.`id` = 51;


INSERT INTO `links` (`id`, `title`, `url`, `icon`, `show_menu`, `parent_id`, `created_at`, `updated_at`) VALUES (NULL, 'الملحقات', '/account/Appendix', '', '1', '9', '2019-12-30 00:00:00', '2019-12-30 00:00:00');


UPDATE `procedure_type` SET `name` = 'جهة مسؤولة عن المعالجة' WHERE `procedure_type`.`id` = 2;
UPDATE `procedure_type` SET `id` = '5' WHERE `procedure_type`.`id` = 4;
UPDATE `procedure_type` SET `id` = '4' WHERE `procedure_type`.`id` = 3;
INSERT INTO `procedure_type` (`id`, `name`, `created_at`, `updated_at`) VALUES (3, 'جهة مسؤولة عن المصادقة', current_timestamp(), current_timestamp());


UPDATE `links` SET `title` = 'إدارة الرسائل (SMS)' WHERE `links`.`id` = 49;
UPDATE `links` SET `title` = 'إرسال الرسائل (SMS) ' WHERE `links`.`id` = 48;
INSERT INTO `links` (`id`, `title`, `url`, `icon`, `show_menu`, `parent_id`, `created_at`, `updated_at`) VALUES (NULL, 'تعريف الرسائل (SMS)', '/account/message/create_message_type', '', '1', '40', NULL, NULL);
ALTER TABLE `message_type` ADD `consumed_letters` INT(11) NULL DEFAULT NULL AFTER `updated_at`, ADD `count_of_letter` INT(11) NULL DEFAULT NULL AFTER `consumed_letters`, ADD `Remaining_letters` INT(11) NULL DEFAULT NULL AFTER `count_of_letter`;
ALTER TABLE `message_type` CHANGE `text` `text` VARCHAR(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;


-- 25/2/2020
ALTER TABLE `sms` DROP `message_text`;
ALTER TABLE `sms` DROP `count _message`, DROP `name`;
ALTER TABLE `sms` ADD `citizen_id` INT(11) NOT NULL AFTER `updated_at`;



ALTER TABLE `message_type` ADD `send_procedure` VARCHAR(250) NULL DEFAULT NULL AFTER `Remaining_letters`;
ALTER TABLE `message_type` CHANGE `send_procedure` `send_procedure` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `sms` ADD `send_status` VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `citizen_id`;
ALTER TABLE `sms` ADD `form_id` INT(11) NULL DEFAULT NULL AFTER `send_status`;
ALTER TABLE `sms` ADD `user_id` INT(11) NULL DEFAULT NULL ;


ALTER TABLE `forms` ADD `reprocessing_recommendations` TEXT NULL DEFAULT NULL AFTER `user_change_content_id`;
ALTER TABLE `forms` ADD `user_reprocessing_recommendations` INT(11) NULL DEFAULT NULL AFTER `reprocessing_recommendations`;

ALTER TABLE `forms` CHANGE `user_reprocessing_recommendations` `user_reprocessing_recommendations_id` INT(11) NULL DEFAULT NULL;

INSERT INTO `links` (`id`, `title`, `url`, `icon`, `show_menu`, `parent_id`, `created_at`, `updated_at`) VALUES (NULL, ' توصيات مستخدمي النظام', '/account/recommendations', '', '1', '9', '2019-12-30 07:00:00', '2019-12-30 07:00:00');


////

ALTER TABLE `forms` CHANGE `reprocessing` `reprocessing` TINYINT(2) NULL DEFAULT NULL;
ALTER TABLE `forms` ADD `confirm_deleting` TINYINT(4) NOT NULL DEFAULT '0' AFTER `user_reprocessing_recommendations_id`, ADD `recommendations_for_deleting` TEXT NULL DEFAULT NULL AFTER `confirm_deleting`;
ALTER TABLE `forms` ADD `user_recommendations_for_deleting_id` INT(11) NULL DEFAULT NULL AFTER `recommendations_for_deleting`;
ALTER TABLE `forms` CHANGE `confirm_deleting` `confirm_deleting` DATETIME NULL DEFAULT NULL;


----------
ALTER TABLE `form_responses` ADD `old_response` TEXT NULL DEFAULT NULL AFTER `deleted_at`;
ALTER TABLE `form_responses` ADD `confirm_account_id` INT(11) NULL DEFAULT NULL AFTER `old_response`, ADD `objection_response` TINYINT(4) NULL DEFAULT NULL AFTER `confirm_account_id`, ADD `confirmation_date` DATE NULL DEFAULT NULL AFTER `objection_response`, ADD `confirmation_status` TINYINT(4) NULL DEFAULT NULL AFTER `confirmation_date`;


ALTER TABLE `form_follows` ADD `account_id` INT(11) NULL DEFAULT NULL AFTER `deleted_at`;

ALTER TABLE `form_follows` ADD `follow_reason_not` VARCHAR(500) NULL DEFAULT NULL AFTER `account_id`;


