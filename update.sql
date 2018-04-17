INSERT INTO `wechat_yey_mld`.`wechat_base_module` (`module_id`, `name`, `module`, `explain`, `icon_id`, `path`, `parent_module_id`, `mini_icon_id`, `wait_read_table`) VALUES ('120403', '评价问卷', '204_02_0', '', '120400', 'sub/survey/appraise_manage.php', '120400', '120400', '');


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
  `school_id` mediumint(8) unsigned NOT NULL COMMENT '学校编号',
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
CREATE TABLE `survey_appraise_answers_view` (
`id` mediumint(8) unsigned
,`appraise_id` mediumint(8) unsigned
,`suggest` char(255)
,`parameter` text
,`is_auto` int(1) unsigned
,`uid` mediumint(8) unsigned
,`school_id` mediumint(8) unsigned
,`school_name` char(20)
,`owner_name` char(20)
,`appraise_title` char(255)
,`appraise_state` int(1) unsigned
,`appraise_type` char(255)
,`appraise_info` text
,`info` text
,`date` datetime
,`answer_1` text
,`answer_2` text
,`answer_3` text
,`answer_4` text
,`answer_5` text
,`answer_6` text
,`answer_7` text
,`answer_8` text
,`answer_9` text
,`answer_10` text
,`answer_11` text
,`answer_12` text
,`answer_13` text
,`answer_14` text
,`answer_15` text
,`answer_16` text
,`answer_17` text
,`answer_18` text
,`answer_19` text
,`answer_20` text
,`answer_21` text
,`answer_22` text
,`answer_23` text
,`answer_24` text
,`answer_25` text
,`answer_26` text
,`answer_27` text
,`answer_28` text
,`answer_29` text
,`answer_30` text
,`answer_31` text
,`answer_32` text
,`answer_33` text
,`answer_34` text
,`answer_35` text
,`answer_36` text
,`answer_37` text
,`answer_38` text
,`answer_39` text
,`answer_40` text
,`answer_41` text
,`answer_42` text
,`answer_43` text
,`answer_44` text
,`answer_45` text
,`answer_46` text
,`answer_47` text
,`answer_48` text
,`answer_49` text
,`answer_50` text
);
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


