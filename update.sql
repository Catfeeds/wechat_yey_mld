INSERT INTO `wechat_yey_mld`.`wechat_base_module` (`module_id`, `name`, `module`, `explain`, `icon_id`, `path`, `parent_module_id`, `mini_icon_id`, `wait_read_table`) VALUES ('120600', '日常办公', '206_00_0', '幼儿园日常办公数字化平台', '120600', 'sub/dailywork/index.php', '0', '120600', ''), ('120601', '工资条', '206_01_0', '', '120600', 'sub/dailywork/payroll.php', '120600', '120600', '');

INSERT INTO `wechat_yey_mld`.`wechat_base_module_icon` (`icon_id`, `path`) VALUES ('120600', 'fa fa-file-text');

CREATE TABLE `dailywork_payroll_item` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `number` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `name` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='工资单项目表' AUTO_INCREMENT=34 ;

INSERT INTO `dailywork_payroll_item` (`id`, `number`, `name`) VALUES 
(1, 1, '岗位工资'),
(2, 2, '薪级工资'),
(3, 3, '百分之十'),
(4, 4, '教龄'),
(5, 5, '书报洗理'),
(6, 6, '卫生津贴'),
(7, 7, '提租补贴'),
(8, 8, '托补奶费'),
(9, 9, '独生子女'),
(10, 10, '劳保通信'),
(11, 11, '骨干奖励'),
(12, 12, '职务津贴'),
(13, 13, '岗位履职'),
(14, 14, '岗位等级'),
(15, 15, '工教龄'),
(16, 16, '防暑降温'),
(17, 17, '物业补助'),
(18, 18, '安全维护'),
(19, 19, '考勤绩效'),
(20, 20, '养老补助'),
(21, 21, '综合补贴'),
(22, 22, '节日补贴'),
(23, 23, '半年奖'),
(24, 24, '全年奖'),
(25, 25, '应发工资'),
(26, 26, '个人所得税'),
(27, 27, '住房公积金'),
(28, 28, '养老保险'),
(29, 29, '医疗保险'),
(30, 30, '失业保险'),
(31, 31, '职业年金'),
(32, 32, '扣除合计'),
(33, 33, '实发数');


CREATE TABLE `dailywork_payroll_object` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `operator_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '操作员',
  `operator_date` datetime NOT NULL COMMENT '操作时间',
  `date` date NOT NULL COMMENT '工资日期，用户手写',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='发放工资记录' AUTO_INCREMENT=1 ;

CREATE TABLE `dailywork_payroll_object_detail` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `teacher_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '教师编号',
  `detail` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '工资明细',
  `object_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '发放编号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='工资明细' AUTO_INCREMENT=1 ;


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `wechat_yey_mld`.`dailywork_payroll_object_view` AS select `wechat_yey_mld`.`dailywork_payroll_object`.`id` AS `id`,`wechat_yey_mld`.`dailywork_payroll_object`.`operator_id` AS `operator_id`,`wechat_yey_mld`.`wechat_base_user_info`.`name` AS `operator_name`,`wechat_yey_mld`.`dailywork_payroll_object`.`operator_date` AS `operator_date`,`wechat_yey_mld`.`dailywork_payroll_object`.`date` AS `date` from (`wechat_yey_mld`.`dailywork_payroll_object` join `wechat_yey_mld`.`wechat_base_user_info` on((`wechat_yey_mld`.`dailywork_payroll_object`.`operator_id` = `wechat_yey_mld`.`wechat_base_user_info`.`uid`)));

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `wechat_yey_mld`.`dailywork_payroll_object_detail_view` AS select `wechat_yey_mld`.`dailywork_payroll_object_detail`.`id` AS `id`,`wechat_yey_mld`.`dailywork_payroll_object_detail`.`teacher_id` AS `teacher_id`,`wechat_yey_mld`.`wechat_base_user_info`.`name` AS `teacher_name`,`wechat_yey_mld`.`wechat_base_user_wechat`.`wechat_id` AS `wechat_id`,`wechat_yey_mld`.`dailywork_payroll_object_detail`.`object_id` AS `object_id`,`dailywork_payroll_object_view`.`operator_id` AS `operator_id`,`dailywork_payroll_object_view`.`operator_name` AS `operator_name`,`dailywork_payroll_object_view`.`operator_date` AS `operator_date`,`dailywork_payroll_object_view`.`date` AS `date`,`wechat_yey_mld`.`dailywork_payroll_object_detail`.`detail` AS `detail` from (((`wechat_yey_mld`.`dailywork_payroll_object_detail` join `wechat_yey_mld`.`dailywork_payroll_object_view` on((`wechat_yey_mld`.`dailywork_payroll_object_detail`.`object_id` = `dailywork_payroll_object_view`.`id`))) join `wechat_yey_mld`.`wechat_base_user_info` on((`wechat_yey_mld`.`dailywork_payroll_object_detail`.`teacher_id` = `wechat_yey_mld`.`wechat_base_user_info`.`uid`))) join `wechat_yey_mld`.`wechat_base_user_wechat` on((`wechat_yey_mld`.`wechat_base_user_info`.`uid` = `wechat_yey_mld`.`wechat_base_user_wechat`.`uid`)));

