INSERT INTO `wechat_yey_mld`.`wechat_base_module` (`module_id`, `name`, `module`, `explain`, `icon_id`, `path`, `parent_module_id`, `mini_icon_id`, `wait_read_table`) VALUES ('120403', '评价问卷', '204_03_0', '', '120400', 'sub/survey/appraise_manage.php', '120400', '120400', '');


CREATE TABLE `survey_appraise` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `title` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '标题',
  `state` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态，0.未发布  1.已发布',
  `type` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `info` text COLLATE utf8_unicode_ci NOT NULL COMMENT '评价信息项目',
  `create_date` datetime NOT NULL COMMENT '建立日期',
  `release_date` datetime NOT NULL COMMENT '发布日期',
  `end_date` datetime NOT NULL COMMENT '结束日期',
  `comment` text COLLATE utf8_unicode_ci NOT NULL COMMENT '备注信息',
  `is_deleted` int(1) unsigned NOT NULL DEFAULT '0',
  `is_auto` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否套用公式',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='评价主题' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- 表的结构 `survey_appraise_answers`
-- 

CREATE TABLE `survey_appraise_answers` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `appraise_id` mediumint(8) unsigned NOT NULL COMMENT '问卷编号',
  `uid` mediumint(8) unsigned NOT NULL COMMENT '微信用户id',
  `info` text COLLATE utf8_unicode_ci NOT NULL COMMENT '信息',
  `class_id` mediumint(8) unsigned NOT NULL COMMENT '学校编号',
  `date` datetime NOT NULL COMMENT '答题日期',
  `parameter` text COLLATE utf8_unicode_ci NOT NULL COMMENT '网址参数',
  `suggest` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '建议',
  `answer_1` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_2` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_3` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_4` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_5` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_6` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_7` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_8` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_9` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_10` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_11` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_12` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_13` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_14` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_15` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_16` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_17` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_18` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_19` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_20` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_21` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_22` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_23` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_24` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_25` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_26` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_27` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_28` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_29` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_30` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_31` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_32` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_33` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_34` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_35` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_36` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_37` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_38` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_39` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_40` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_41` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_42` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_43` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_44` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_45` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_46` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_47` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_48` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_49` text COLLATE utf8_unicode_ci NOT NULL,
  `answer_50` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='问卷调查答案' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Stand-in structure for view `survey_appraise_answers_view`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `survey_appraise_info_item`
-- 

CREATE TABLE `survey_appraise_info_item` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '名称',
  `type` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '信息分类',
  `number` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT=' 评价表格信息项目' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- 表的结构 `survey_appraise_options`
-- 

CREATE TABLE `survey_appraise_options` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `question_id` mediumint(8) unsigned NOT NULL COMMENT '问题编号',
  `option` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '选项',
  `number` char(2) COLLATE utf8_unicode_ci NOT NULL COMMENT '选项序号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='调查问卷的题目选项' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- 表的结构 `survey_appraise_questions`
-- 

CREATE TABLE `survey_appraise_questions` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `appraise_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '问卷编号',
  `question` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '题目',
  `type` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '1.单选 2.多选 3.文本',
  `number` int(3) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `is_must` int(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否必填',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='问卷调查题目' AUTO_INCREMENT=1 ;


INSERT INTO `survey_appraise_info_item` (`id`, `name`, `type`, `number`) VALUES 
(1, '班级名称', '幼儿园', 1),
(2, '幼儿数', '幼儿园', 2),
(3, '教师姓名', '幼儿园', 3),
(4, '班级', '中小学', 1),
(5, '科目', '中小学', 2),
(6, '时间', '中小学', 3),
(7, '授课课程', '中小学', 4),
(8, '任课教师', '中小学', 5),
(9, '班级', '中小学主题班（队）会', 1),
(10, '班会主题', '中小学主题班（队）会', 2);

ALTER TABLE  `survey_appraise_answers` ADD  `owner_class_id` MEDIUMINT( 8 ) NOT NULL DEFAULT  '0' COMMENT  '评价人班级编号' AFTER  `uid` ;
ALTER TABLE  `survey_appraise_answers` CHANGE  `owner_class_id`  `owner_class_id` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT  '评价人班级编号'


----survey_appraise_answers_view----
select `survey_appraise_answers`.`id` AS `id`,`survey_appraise_answers`.`appraise_id` AS `appraise_id`,`survey_appraise_answers`.`suggest` AS `suggest`,`survey_appraise_answers`.`parameter` AS `parameter`,`survey_appraise`.`is_auto` AS `is_auto`,`survey_appraise_answers`.`uid` AS `uid`,`survey_appraise_answers`.`owner_class_id` AS `owner_class_id`,`survey_appraise_answers`.`class_id` AS `class_id`,`wechat_base_user_info`.`name` AS `owner_name`,`survey_appraise`.`title` AS `appraise_title`,`survey_appraise`.`state` AS `appraise_state`,`survey_appraise`.`type` AS `appraise_type`,`survey_appraise`.`info` AS `appraise_info`,`survey_appraise_answers`.`info` AS `info`,`survey_appraise_answers`.`date` AS `date`,`survey_appraise_answers`.`answer_1` AS `answer_1`,`survey_appraise_answers`.`answer_2` AS `answer_2`,`survey_appraise_answers`.`answer_3` AS `answer_3`,`survey_appraise_answers`.`answer_4` AS `answer_4`,`survey_appraise_answers`.`answer_5` AS `answer_5`,`survey_appraise_answers`.`answer_6` AS `answer_6`,`survey_appraise_answers`.`answer_7` AS `answer_7`,`survey_appraise_answers`.`answer_8` AS `answer_8`,`survey_appraise_answers`.`answer_9` AS `answer_9`,`survey_appraise_answers`.`answer_10` AS `answer_10`,`survey_appraise_answers`.`answer_11` AS `answer_11`,`survey_appraise_answers`.`answer_12` AS `answer_12`,`survey_appraise_answers`.`answer_13` AS `answer_13`,`survey_appraise_answers`.`answer_14` AS `answer_14`,`survey_appraise_answers`.`answer_15` AS `answer_15`,`survey_appraise_answers`.`answer_16` AS `answer_16`,`survey_appraise_answers`.`answer_17` AS `answer_17`,`survey_appraise_answers`.`answer_18` AS `answer_18`,`survey_appraise_answers`.`answer_19` AS `answer_19`,`survey_appraise_answers`.`answer_20` AS `answer_20`,`survey_appraise_answers`.`answer_21` AS `answer_21`,`survey_appraise_answers`.`answer_22` AS `answer_22`,`survey_appraise_answers`.`answer_23` AS `answer_23`,`survey_appraise_answers`.`answer_24` AS `answer_24`,`survey_appraise_answers`.`answer_25` AS `answer_25`,`survey_appraise_answers`.`answer_26` AS `answer_26`,`survey_appraise_answers`.`answer_27` AS `answer_27`,`survey_appraise_answers`.`answer_28` AS `answer_28`,`survey_appraise_answers`.`answer_29` AS `answer_29`,`survey_appraise_answers`.`answer_30` AS `answer_30`,`survey_appraise_answers`.`answer_31` AS `answer_31`,`survey_appraise_answers`.`answer_32` AS `answer_32`,`survey_appraise_answers`.`answer_33` AS `answer_33`,`survey_appraise_answers`.`answer_34` AS `answer_34`,`survey_appraise_answers`.`answer_35` AS `answer_35`,`survey_appraise_answers`.`answer_36` AS `answer_36`,`survey_appraise_answers`.`answer_37` AS `answer_37`,`survey_appraise_answers`.`answer_38` AS `answer_38`,`survey_appraise_answers`.`answer_39` AS `answer_39`,`survey_appraise_answers`.`answer_40` AS `answer_40`,`survey_appraise_answers`.`answer_41` AS `answer_41`,`survey_appraise_answers`.`answer_42` AS `answer_42`,`survey_appraise_answers`.`answer_43` AS `answer_43`,`survey_appraise_answers`.`answer_44` AS `answer_44`,`survey_appraise_answers`.`answer_45` AS `answer_45`,`survey_appraise_answers`.`answer_46` AS `answer_46`,`survey_appraise_answers`.`answer_47` AS `answer_47`,`survey_appraise_answers`.`answer_48` AS `answer_48`,`survey_appraise_answers`.`answer_49` AS `answer_49`,`survey_appraise_answers`.`answer_50` AS `answer_50`,`student_class`.`class_name` AS `class_name` from (((`survey_appraise_answers` join `wechat_base_user_info` on((`survey_appraise_answers`.`uid` = `wechat_base_user_info`.`uid`))) join `survey_appraise` on((`survey_appraise_answers`.`appraise_id` = `survey_appraise`.`id`))) join `student_class` on((`student_class`.`class_id` = `survey_appraise_answers`.`class_id`)));
