CREATE TABLE `student_onboard_checkingin` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `active` int(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否为有效状态0为无效',
  `class_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '班级编号',
  `date` date NOT NULL DEFAULT '0000-00-00' COMMENT '考勤日期',
  `absenteeism_stu` text COLLATE utf8_unicode_ci NOT NULL COMMENT '缺勤人员',
  `absenteeism_sum` int(3) unsigned NOT NULL DEFAULT '0' COMMENT '缺勤人数',
  `checkingin_sum` int(3) unsigned NOT NULL DEFAULT '0' COMMENT '出勤人数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

DROP TABLE IF EXISTS `student_onboard_checkingin_class_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `student_onboard_checkingin_class_view` AS select `student_onboard_checkingin`.`id` AS `id`,`student_onboard_checkingin`.`active` AS `active`,`student_onboard_checkingin`.`class_id` AS `class_id`,`student_class`.`class_name` AS `class_name`,`student_onboard_checkingin`.`date` AS `date`,`student_onboard_checkingin`.`absenteeism_stu` AS `absenteeism_stu`,`student_onboard_checkingin`.`absenteeism_sum` AS `absenteeism_sum`,`student_onboard_checkingin`.`checkingin_sum` AS `checkingin_sum`,`student_class`.`grade` AS `grade` from (`student_onboard_checkingin` join `student_class` on((`student_onboard_checkingin`.`class_id` = `student_class`.`class_id`)));
