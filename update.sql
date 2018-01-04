CREATE TABLE `survey_teacher` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `title` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '标题',
  `comment` text COLLATE utf8_unicode_ci NOT NULL COMMENT '问卷说明',
  `create_date` datetime NOT NULL COMMENT '建立日期',
  `state` int(2) unsigned NOT NULL COMMENT '0.暂存 1.已发布 2.结束',
  `is_anonymity` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否匿名',
  `owner_id` mediumint(9) NOT NULL COMMENT '拥有者',
  `release_date` datetime NOT NULL COMMENT '发布日期',
  `end_date` datetime NOT NULL COMMENT '结束日期',
  `target_name` text COLLATE utf8_unicode_ci NOT NULL COMMENT '对象群体名称',
  `target_list` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '对象ID数组',
  `first` text COLLATE utf8_unicode_ci NOT NULL COMMENT '提醒标题',
  `remark` text COLLATE utf8_unicode_ci NOT NULL COMMENT '提醒内容',
  `completed_sum` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '完成数',
  `pending_sum` int(5) NOT NULL DEFAULT '0' COMMENT '未完成数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='问卷调查' AUTO_INCREMENT=1 ;

CREATE TABLE `survey_teacher_answers` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `survey_id` mediumint(8) unsigned NOT NULL COMMENT '问卷编号',
  `user_id` mediumint(8) unsigned NOT NULL COMMENT '微信用户id',
  `uid` mediumint(8) unsigned NOT NULL COMMENT '教师编号',
  `name` char(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '学生姓名',
  `sex` char(5) COLLATE utf8_unicode_ci NOT NULL COMMENT '性别',
  `id_type` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '证件类型',
  `card_id` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '证件编号',
  `class_name` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '班级名称',
  `user_name` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '家长姓名',
  `date` datetime NOT NULL COMMENT '答题日期',
  `answer_1` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_2` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_3` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_4` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_5` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_6` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_7` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_8` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_9` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_10` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_11` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_12` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_13` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_14` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_15` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_16` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_17` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_18` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_19` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_20` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_21` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_22` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_23` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_24` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_25` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_26` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_27` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_28` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_29` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_30` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_31` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_32` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_33` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_34` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_35` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_36` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_37` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_38` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_39` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_40` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_41` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_42` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_43` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_44` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_45` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_46` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_47` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_48` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_49` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer_50` char(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='问卷调查答案' AUTO_INCREMENT=1;

CREATE TABLE `survey_teacher_options` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `question_id` mediumint(8) unsigned NOT NULL COMMENT '问题编号',
  `option` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '选项',
  `number` char(2) COLLATE utf8_unicode_ci NOT NULL COMMENT '选项序号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='调查问卷的题目选项' AUTO_INCREMENT=1;

CREATE TABLE `survey_teacher_questions` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `survey_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '问卷编号',
  `question` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '题目',
  `type` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '1.单选 2.多选 3.文本',
  `number` int(3) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='问卷调查题目' AUTO_INCREMENT=1;

CREATE TABLE `teaching_h5` (
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
  `visitor_num` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '访问量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='微教学' AUTO_INCREMENT=1

--teaching_h5_view--
select `teaching_h5`.`id` AS `id`,`teaching_h5`.`owner_id` AS `owner_id`,`wechat_base_user_info`.`name` AS `owner_name`,`teaching_h5`.`create_date` AS `create_date`,`teaching_h5`.`release_date` AS `release_date`,`teaching_h5`.`state` AS `state`,`teaching_h5`.`title` AS `title`,`teaching_h5`.`comment` AS `comment`,`teaching_h5`.`video` AS `video`,`teaching_h5`.`icon` AS `icon`,`teaching_h5`.`target` AS `target`,`teaching_h5`.`target_name` AS `target_name`,`teaching_h5`.`visitor_num` AS `visitor_num` from (`teaching_h5` join `wechat_base_user_info` on((`teaching_h5`.`owner_id` = `wechat_base_user_info`.`uid`)));

--wechat_base_user_role_wechat_view--
select `wechat_base_user_role`.`uid` AS `uid`,`wechat_base_user_info`.`name` AS `name`,`wechat_base_user_role`.`dept_id` AS `dept_id`,`wechat_base_user_role`.`role_id` AS `role_id`,`wechat_base_user_role`.`sec_role_id_1` AS `sec_role_id_1`,`wechat_base_user_role`.`sec_role_id_2` AS `sec_role_id_2`,`wechat_base_user_role`.`sec_role_id_3` AS `sec_role_id_3`,`wechat_base_user_role`.`sec_role_id_4` AS `sec_role_id_4`,`wechat_base_user_role`.`sec_role_id_5` AS `sec_role_id_5`,`wechat_base_user_wechat`.`wechat_id` AS `user_id`,`wechat_wx_user_info`.`photo` AS `photo`,`wechat_wx_user_info`.`nickname` AS `nickname`,`wechat_wx_user_info`.`sex` AS `sex`,`wechat_wx_user_info`.`openid` AS `openid`,`wechat_wx_user_info`.`group_id` AS `group_id`,`wechat_wx_user_info`.`session_id` AS `session_id` from (((`wechat_base_user_wechat` join `wechat_base_user_role` on((`wechat_base_user_role`.`uid` = `wechat_base_user_wechat`.`uid`))) join `wechat_wx_user_info` on((`wechat_base_user_wechat`.`wechat_id` = `wechat_wx_user_info`.`id`))) join `wechat_base_user_info` on((`wechat_base_user_info`.`uid` = `wechat_base_user_role`.`uid`)));

INSERT INTO `wechat_yey_mld`.`wechat_base_module` (`module_id`, `name`, `module`, `explain`, `icon_id`, `path`, `parent_module_id`, `mini_icon_id`, `wait_read_table`) VALUES ('120402', '教师问卷', '204_02_0', '', '1', 'sub/survey/teacher_survey_manage.php', '120400', '1', '');

UPDATE `wechat_yey_mld`.`wechat_base_module` SET `icon_id` = '120400', `mini_icon_id` = '120400' WHERE `wechat_base_module`.`module_id` = 120402 LIMIT 1;

INSERT INTO `wechat_yey_mld`.`wechat_base_module` (`module_id`, `name`, `module`, `explain`, `icon_id`, `path`, `parent_module_id`, `mini_icon_id`, `wait_read_table`) VALUES ('120502', 'H5页面', '205_02_0', '', '1120500', 'sub/teaching/H5.php', '120500', '120500', '');

UPDATE `wechat_yey_mld`.`wechat_base_module` SET `icon_id` = '120500' WHERE `wechat_base_module`.`module_id` = 120502 LIMIT 1;

UPDATE `wechat_yey_mld`.`wechat_base_module` SET `name` = '玛卡初页' WHERE `wechat_base_module`.`module_id` = 120502 LIMIT 1;

UPDATE `wechat_yey_mld`.`wechat_base_module` SET `path` = 'sub/teaching/h5.php' WHERE `wechat_base_module`.`module_id` = 120502 LIMIT 1;




