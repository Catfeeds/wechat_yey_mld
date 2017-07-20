INSERT INTO `wechat_yey_mld`.`wechat_base_module_icon` (`icon_id`, `path`) VALUES ('120500', 'glyphicon-blackboard');
INSERT INTO `wechat_yey_mld`.`wechat_base_module` (`module_id`, `name`, `module`, `explain`, `icon_id`, `path`, `parent_module_id`, `mini_icon_id`, `wait_read_table`) VALUES ('120500', '教育教学', '205_00_0', '幼儿园网络教学专用模块', '120500', 'sub/teaching/index.php', '0', '120400', ''), ('120501', '微教学', '205_01_0', '', '120500', 'sub/teaching/wei_teach.php', '120500', '120500', '');
CREATE TABLE `teaching_wei_teach` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `owner_id` mediumint(8) unsigned NOT NULL COMMENT '作者',
  `create_date` datetime NOT NULL COMMENT '创建日期',
  `release_date` datetime NOT NULL COMMENT '发布日期',
  `state` int(1) unsigned NOT NULL COMMENT '0.暂存 1.已发布',
  `title` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '标题',
  `comment` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '备注',
  `video` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '视频地址',
  `icon` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '缩略图地址',
  `target` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '目标人群ID数组，已班为单位',
  `target_name` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '目标人群名称',
  `visitor_num` int(8) unsigned NOT NULL COMMENT '访问量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='微教学' AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `teaching_wei_teach_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `teaching_wei_teach_view` AS select `teaching_wei_teach`.`id` AS `id`,`teaching_wei_teach`.`owner_id` AS `owner_id`,`wechat_base_user_info`.`name` AS `owner_name`,`teaching_wei_teach`.`create_date` AS `create_date`,`teaching_wei_teach`.`release_date` AS `release_date`,`teaching_wei_teach`.`state` AS `state`,`teaching_wei_teach`.`title` AS `title`,`teaching_wei_teach`.`comment` AS `comment`,`teaching_wei_teach`.`video` AS `video`,`teaching_wei_teach`.`icon` AS `icon`,`teaching_wei_teach`.`target` AS `target`,`teaching_wei_teach`.`target_name` AS `target_name`,`teaching_wei_teach`.`visitor_num` AS `visitor_num` from (`teaching_wei_teach` join `wechat_base_user_info` on((`teaching_wei_teach`.`owner_id` = `wechat_base_user_info`.`uid`)));

ALTER TABLE `teaching_wei_teach` CHANGE `visitor_num` `visitor_num` INT(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '访问量';
