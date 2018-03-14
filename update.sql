-------teaching_news_view
select `teaching_news`.`id` AS `id`,`teaching_news`.`owner_id` AS `owner_id`,`wechat_base_user_info`.`name` AS `owner_name`,`teaching_news`.`create_date` AS `create_date`,`teaching_news`.`release_date` AS `release_date`,`teaching_news`.`state` AS `state`,`teaching_news`.`title` AS `title`,`teaching_news`.`comment` AS `comment`,`teaching_news`.`target` AS `target`,`teaching_news`.`target_name` AS `target_name` from (`teaching_news` join `wechat_base_user_info` on((`teaching_news`.`owner_id` = `wechat_base_user_info`.`uid`)));

CREATE TABLE `teaching_news` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `owner_id` mediumint(8) unsigned NOT NULL COMMENT '作者',
  `create_date` datetime NOT NULL COMMENT '创建日期',
  `release_date` datetime NOT NULL COMMENT '发布日期',
  `state` int(1) unsigned NOT NULL COMMENT '0.暂存 1.已发布',
  `title` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '标题',
  `comment` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '备注',
  `target` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '目标人群ID数组，已班为单位',
  `target_name` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '目标人群名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='微教学' AUTO_INCREMENT=4 ;

CREATE TABLE `teaching_news_list` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `news_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '新闻ID',
  `comment` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '摘要',
  `icon` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '图标',
  `link` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '连接',
  `number` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `visitor_num` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '访问量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='新闻列表页面' AUTO_INCREMENT=1 ;

INSERT INTO `wechat_yey_mld`.`wechat_base_module` (`module_id`, `name`, `module`, `explain`, `icon_id`, `path`, `parent_module_id`, `mini_icon_id`, `wait_read_table`) VALUES ('12503', '新闻组', '205_03_0', '', '120600', 'sub/teaching/news.php', '120600', '120600', '');

UPDATE `wechat_yey_mld`.`wechat_base_module` SET `module_id` = '120503', `icon_id` = '120500', `parent_module_id` = '120500', `mini_icon_id` = '120500' WHERE `wechat_base_module`.`module_id` = 12503 LIMIT 1;
