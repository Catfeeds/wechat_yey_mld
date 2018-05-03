CREATE TABLE `teaching_sport_item` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '体育名称',
  `number` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `type` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '分为：input、time',
  `unit` char(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '计量单位',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='体育项目编号' AUTO_INCREMENT=1 ;

INSERT INTO `teaching_sport_item` (`id`, `name`, `number`, `type`, `unit`) VALUES 
(1, '坐位体前屈', 1, 'input', '厘米'),
(2, '立定跳远', 1, 'input', '厘米'),
(3, '网球掷远', 3, 'input', '米'),
(4, '走平衡木', 4, 'time', '秒'),
(5, '10米往返跑', 5, 'time', '秒'),
(6, '双脚连续跳', 6, 'time', '秒');

CREATE TABLE `teaching_sport_records` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `student_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '学生编号',
  `record_uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '记录人编号',
  `year` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '年份',
  `month` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '月份',
  `date` date NOT NULL COMMENT '日期',
  `item_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '项目编号',
  `score` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '分数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='体育成绩' AUTO_INCREMENT=1 ;

-------teaching_sport_records_view
select `teaching_sport_records`.`id` AS `id`,`teaching_sport_records`.`student_id` AS `student_id`,`student_onboard_info`.`name` AS `student_name`,`student_onboard_info`.`class_number` AS `class_number`,`student_class`.`class_name` AS `class_name`,`student_class`.`grade` AS `grade`,`teaching_sport_records`.`record_uid` AS `record_uid`,`wechat_base_user_info`.`name` AS `teacher_name`,`teaching_sport_item`.`type` AS `item_unit`,`teaching_sport_item`.`unit` AS `unit`,`teaching_sport_records`.`year` AS `year`,`teaching_sport_records`.`month` AS `month`,`teaching_sport_records`.`date` AS `date`,`teaching_sport_records`.`item_id` AS `item_id`,`teaching_sport_item`.`name` AS `item_name`,`teaching_sport_records`.`score` AS `score` from ((((`teaching_sport_item` join `teaching_sport_records` on((`teaching_sport_records`.`item_id` = `teaching_sport_item`.`id`))) join `student_onboard_info` on((`teaching_sport_records`.`student_id` = `student_onboard_info`.`student_id`))) join `student_class` on((`student_onboard_info`.`class_number` = `student_class`.`class_id`))) join `wechat_base_user_info` on((`teaching_sport_records`.`record_uid` = `wechat_base_user_info`.`uid`)));