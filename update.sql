CREATE TABLE `student_onboard_checkingin` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `active` int(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否为有效状态0为无效',
  `class_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '班级编号',
  `date` date NOT NULL DEFAULT '0000-00-00' COMMENT '考勤日期',
  `modify_date` datetime NOT NULL COMMENT '修改时间',
  `absenteeism_stu` text COLLATE utf8_unicode_ci NOT NULL COMMENT '缺勤人员',
  `absenteeism_sum` int(3) unsigned NOT NULL DEFAULT '0' COMMENT '缺勤人数',
  `checkingin_sum` int(3) unsigned NOT NULL DEFAULT '0' COMMENT '出勤人数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `student_onboard_checkingin_class_view` AS select `student_onboard_checkingin`.`id` AS `id`,`student_onboard_checkingin`.`active` AS `active`,`student_onboard_checkingin`.`class_id` AS `class_id`,`student_class`.`class_name` AS `class_name`,`student_onboard_checkingin`.`date` AS `date`,`student_onboard_checkingin`.`modify_date` AS `modify_date`,`student_onboard_checkingin`.`absenteeism_stu` AS `absenteeism_stu`,`student_onboard_checkingin`.`absenteeism_sum` AS `absenteeism_sum`,`student_onboard_checkingin`.`checkingin_sum` AS `checkingin_sum`,`student_class`.`grade` AS `grade` from (`student_onboard_checkingin` join `student_class` on((`student_onboard_checkingin`.`class_id` = `student_class`.`class_id`)));

CREATE TABLE `student_onboard_checkingin_detail` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `check_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '考勤编号',
  `student_id` mediumint(8) unsigned NOT NULL COMMENT '学生编号',
  `type` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '请假类型',
  `comment` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '类型描述',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='请假详情' AUTO_INCREMENT=1 ;

CREATE TABLE `student_onboard_checkingin_parent` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '家长微信编号',
  `student_id` mediumint(8) unsigned NOT NULL COMMENT '学生编号',
  `date` date NOT NULL COMMENT '提交日期',
  `type` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '请假类型',
  `comment` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '类型描述',
  `start_date` date NOT NULL COMMENT '请假开始日期',
  `end_date` date NOT NULL COMMENT '请假结束日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='请假详情' AUTO_INCREMENT=1 ;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `student_onboard_checkingin_parent_view` AS select `student_onboard_checkingin_parent`.`id` AS `id`,`student_onboard_checkingin_parent`.`user_id` AS `user_id`,`wechat_wx_user_info`.`user_name` AS `parent_name`,`student_onboard_checkingin_parent`.`student_id` AS `student_id`,`student_onboard_info`.`name` AS `name`,`student_onboard_info`.`class_number` AS `class_number`,`student_onboard_checkingin_parent`.`date` AS `date`,`student_onboard_checkingin_parent`.`type` AS `type`,`student_onboard_checkingin_parent`.`comment` AS `comment`,`student_onboard_checkingin_parent`.`start_date` AS `start_date`,`student_onboard_checkingin_parent`.`end_date` AS `end_date` from ((`student_onboard_checkingin_parent` join `student_onboard_info` on((`student_onboard_checkingin_parent`.`student_id` = `student_onboard_info`.`student_id`))) join `wechat_wx_user_info` on((`student_onboard_checkingin_parent`.`user_id` = `wechat_wx_user_info`.`id`)));
