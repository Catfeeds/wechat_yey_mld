ALTER TABLE `student_onboard_checkingin` ADD `class_name` CHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '班级名称' AFTER `class_id`;
ALTER TABLE `student_onboard_checkingin_detail` ADD `name` CHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '幼儿姓名' AFTER `student_id`;
ALTER TABLE `student_onboard_checkingin` ADD `grade_number` INT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '年级编号' AFTER `owner_id`, ADD `grade_name` CHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '年级名称' AFTER `grade_number`;


